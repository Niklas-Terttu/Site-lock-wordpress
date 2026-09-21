# Site Lock - Under Ombygning

Et professionelt WordPress plugin, der viser en tilpasselig "Under Ombygning" side mens du arbejder på dit websted.

## Funktioner

### Grundlæggende
- ✅ Slå "Under Ombygning" siden til/fra med et klik
- ✅ Rediger overskrift og besked (HTML understøttes)
- ✅ Adgangskode-beskyttelse - besøgende kan få adgang med en kode
- ✅ Admin bypass - admins ser altid hele webstedet normalt

### Udseende
- 🎨 Tilpasset baggrundsfarve, tekstfarve og knapfarve
- 📸 Upload logo/banner billede
- 📱 Fuld responsiv design (fungerer perfekt på mobiler)
- 🎯 Professionel og moderne design

### Avanceret
- 👥 Tillad abonnenter at se hele webstedet (hvis ønsket)
- 📧 Email notifikationer når nogen bruger koden
- 📝 Log alle adgangsersøg (hvornår, IP, hvilken kode)
- 📊 Se statistik over adgangsforsøg
- 🔗 Links til sociale medier (Facebook, Twitter, Instagram)
- 🚫 Meta-tags for at forhindre indexering af siden

## Installation

1. **Upload pluginet:**
   - Gå til WordPress Admin Panel → Plugins → Tilføj nyt
   - Klik på "Upload Plugin"
   - Vælg `site-lock-under-ombygning.zip` filen
   - Klik "Installér nu"

2. **Aktivér pluginet:**
   - Efter installation, klik "Aktivér Plugin"

3. **Konfigurér pluginet:**
   - Gå til Indstillinger → Under Ombygning
   - Indstil dine præferencer og gem

## Automatiske opdateringer

Pluginet tjekker automatisk GitHub-repositoryets seneste release. Når der pushes til
`main`, bygger GitHub en ny plugin-zip og opretter en release. WordPress kan derefter
vise opdateringen under **Dashboard → Opdateringer**.

Opdateringstjekket kan være cachet i op til 12 timer af WordPress.

## Sådan bruges det

### 1. Aktiver "Under Ombygning"
- Gå til Indstillinger → Under Ombygning → Generelt fanen
- Tjek "Aktiver 'Under Ombygning'" boksen
- Klik "Gem indstillinger"

### 2. Tilpas teksten
- Indstil "Overskrift" (f.eks. "Under Ombygning")
- Indstil "Besked" med din egen tekst (kan indeholde HTML)

### 3. Indstil adgangskode (valgfrit)
- Skriv en adgangskode i "Adgangskode" feltet
- Besøgende kan bruge denne kode til at få adgang til hele webstedet
- Lad være tom hvis du ikke ønsker adgangskode-funktion

### 4. Tilpas udseende
- Upload et logo under "Udseende" fanen
- Vælg baggrundsfarve, tekstfarve og knapfarve
- Gem indstillinger

### 5. Indstil yderligere muligheder
- **Tillad abonnenter:** Tillader brugere med "abonnent" rolle at se hele webstedet
- **Email notifikationer:** Modtag email når nogen bruger adgangskoden
- **Log adgangsforsøg:** Registrer alle forsøg på at få adgang
- **Sociale medier:** Tilføj links til dine sociale media-profiler

## Hvem kan se hvad?

| Brugertype | Ser "Under Ombygning" | Kan bruge kode? |
|-----------|:---:|:---:|
| Ikke logget ind (besøgende) | ✅ | Ja (hvis sat) |
| Abonnenter | ✅ (medmindre tilladt) | Ja (hvis sat) |
| Redaktører | ✅ | Ja (hvis sat) |
| Admin | ❌ Ser hele webstedet | N/A |

## Tips & Tricks

### Adgangskode-idéer
- Brug en stærk og tilfældig kode (f.eks. "a7x9k2m4p1")
- Skift koden regelmæssigt
- Dele koden på sociale medier eller via email til venner/kolleger

### Bedste praksis
- Test pluginet på en testside før du bruger det på live-site
- Husk at deaktivere pluginet når du er færdig med ombygningen
- Log adgangsforsøg hvis du vil have indsigt i hvor mange der forsøger at få adgang

### Email-notifikationer
- Aktiver "Email notifikationer" for at blive underrettet når nogen bruger koden
- Du modtager email til din WordPress admin-email adresse

## Fejlfinding

### Siden vises stadig for admins?
- Sørg for at du er logget ind som admin
- Hvis du bruger en autentificerings-plugin, kan det påvirke admin-check

### Koden virker ikke?
- Kontroller stavningen af koden (den skelner mellem store og små bogstaver)
- Prøv at rense dine browser-cookies
- Kontroller at "Adgangskode" feltet ikke er tomt

### Logo vises ikke?
- Kontroller at billedstørrelsen er rimelig
- Prøv at reuploade billedet
- Kontroller at media-biblioteket fungerer normalt

## Deaktivering

Når du er færdig med ombygningen:
1. Gå til Indstillinger → Under Ombygning
- Fjern fluebenet fra "Aktiver 'Under Ombygning'"
- Klik "Gem indstillinger"

Alle indstillinger gemmes, så du kan genaktivere det senere hvis du skal under ombygning igen.

## Sikkerhed

- Pluginet bruger WordPress nonce-sikkerhed for adgangskode-formularer
- Alle input-data er saniteret for at forhindre XSS-angreb
- IP-adresser og brugeragent-info logges (kan ses i admin-panelet)
- Koder gemmes i WordPress database (ikke i separate filer)

## Support

Hvis du oplever problemer:
1. Deaktivér alle andre plugins (for at eliminere konflikter)
2. Aktiver pluginet igen
3. Test funktionaliteten

## Changelog

### Version 1.0.0
- Første version
- Grundlæggende "Under Ombygning" funktionalitet
- Adgangskode-beskyttelse
- Admin bypass
- Tilpasset branding/styling
- Logging og email-notifikationer
- Sociale media links
- Fuldt dansk support

---

**Desenvolveret med ❤️ for WordPress**
