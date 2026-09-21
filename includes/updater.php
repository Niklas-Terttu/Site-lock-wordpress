<?php
/**
 * GitHub-based plugin updates.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'SLUO_GITHUB_REPOSITORY', 'Niklas-Terttu/Site-lock-wordpress' );
define( 'SLUO_PLUGIN_SLUG', basename( SLUO_PLUGIN_BASENAME, '.php' ) );

add_filter( 'pre_set_site_transient_update_plugins', 'sluo_check_github_update' );
add_filter( 'plugins_api', 'sluo_github_plugin_information', 20, 3 );

function sluo_github_release() {
    $cached_release = get_transient( 'sluo_github_release' );

    if ( false !== $cached_release ) {
        return $cached_release;
    }

    $response = wp_remote_get(
        'https://api.github.com/repos/' . SLUO_GITHUB_REPOSITORY . '/releases/latest',
        array(
            'headers' => array(
                'Accept'     => 'application/vnd.github+json',
                'User-Agent' => 'Site-Lock-WordPress/' . SLUO_VERSION,
            ),
            'timeout' => 10,
        )
    );

    if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
        return false;
    }

    $release = json_decode( wp_remote_retrieve_body( $response ) );

    if ( empty( $release->tag_name ) || empty( $release->zipball_url ) ) {
        return false;
    }

    set_transient( 'sluo_github_release', $release, 12 * HOUR_IN_SECONDS );

    return $release;
}

function sluo_github_version( $tag_name ) {
    return ltrim( sanitize_text_field( $tag_name ), 'vV' );
}

function sluo_check_github_update( $transient ) {
    if ( empty( $transient->checked ) ) {
        return $transient;
    }

    $release = sluo_github_release();

    if ( ! $release ) {
        return $transient;
    }

    $version = sluo_github_version( $release->tag_name );

    if ( version_compare( SLUO_VERSION, $version, '>=' ) ) {
        return $transient;
    }

    $update = (object) array(
        'slug'        => SLUO_PLUGIN_SLUG,
        'plugin'      => SLUO_PLUGIN_BASENAME,
        'new_version' => $version,
        'url'         => 'https://github.com/' . SLUO_GITHUB_REPOSITORY,
        'package'     => ! empty( $release->assets[0]->browser_download_url )
            ? $release->assets[0]->browser_download_url
            : $release->zipball_url,
    );

    $transient->response[ SLUO_PLUGIN_BASENAME ] = $update;

    return $transient;
}

function sluo_github_plugin_information( $result, $action, $args ) {
    if ( 'plugin_information' !== $action || empty( $args->slug ) || SLUO_PLUGIN_SLUG !== $args->slug ) {
        return $result;
    }

    $release = sluo_github_release();

    if ( ! $release ) {
        return $result;
    }

    return (object) array(
        'name'          => 'Site Lock - Under Ombygning',
        'slug'          => SLUO_PLUGIN_SLUG,
        'version'       => sluo_github_version( $release->tag_name ),
        'author'        => '<a href="https://github.com/Niklas-Terttu">Niklas Terttu</a>',
        'homepage'      => 'https://github.com/' . SLUO_GITHUB_REPOSITORY,
        'download_link' => ! empty( $release->assets[0]->browser_download_url )
            ? $release->assets[0]->browser_download_url
            : $release->zipball_url,
        'sections'      => array(
            'description' => 'Et dansk WordPress-plugin til en side under ombygning.',
            'changelog'   => ! empty( $release->body ) ? wpautop( esc_html( $release->body ) ) : '',
        ),
    );
}