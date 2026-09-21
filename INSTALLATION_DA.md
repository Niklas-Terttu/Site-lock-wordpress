# Site Lock - Under Ombygning
## Installation og Brugs Guide (Dansk)

### 📋 Systemkrav
- WordPress 5.0 eller nyere
- PHP 5.6 eller nyere
- Aktiv webhosting med WordPress installeret

---

## 🚀 Installation

### Metode 1: Upload via WordPress Admin Panel

1. **Log ind i WordPress Admin Panel**
   - Besøg `dit-domæne.dk/wp-admin`
   - Log ind med dine admin-oplysninger

2. **Gå til Plugins → Tilføj Nyt**
   - Klik på "Tilføj nyt plugin"

3. **Upload Zip-fil**
   - Klik "Upload Plugin"
   - Vælg filen `site-lock-under-ombygning.zip`
   - Klik "Installér nu"

4. **Aktivér Pluginet**
   - Efter installation, klik "Aktivér Plugin"
   - Du burde nu se "Under Ombygning" i menuen under "Indstillinger"

### Metode 2: Manuel Upload via FTP

1. **Download plugin-filerne**
   - Pak `site-lock-under-ombygning.zip` ud

2. **Upload via FTP**
   - Forbind til din server via FTP
   - Naviger til `/wp-content/plugins/`
   - Upload hele `site-lock-under-ombygning` mappen

3. **Aktivér i WordPress**
   - Gå til WordPress Admin → Plugins
   - Find "Site Lock - Under Ombygning"
   - Klik "Aktivér"

---

## ⚙️ Konfiguration

### Trin 1: Åbn Indstillinger
1. Log ind som admin
2. Gå til **Indstillinger** → **Under Ombygning**

### Trin 2: Generelle Indstillinger
1. Tjek **"Aktiver 'Under Ombygning'"** for at slå siden til
2. Rediger **Overskrift** (f.eks. "Webstedet er under ombygning")
3. Rediger **Besked** (f.eks. med information om hvornår webstedet åbner igen)
4. Indstil **Adgangskode** (valgfrit) - denne kode tillader besøgende at se hele webstedet

### Trin 3: Tilpas Udseende (Valgfrit)
1. Klik på fanen **"Udseende"**
2. **Upload Logo:**
   - Klik "Upload Logo"
   - Vælg dit logo-billede
   - Klik "Brug Dette Billede"
3. **Vælg Farver:**
   - Klik på farveboksene for at vælge:
     - Baggrundsfarve
     - Tekstfarve
     - Knapfarve

### Trin 4: Avancerede Indstillinger (Valgfrit)
1. Klik på fanen **"Avanceret"**
2. Tilgængelige indstillinger:
   - ☑️ **Tillad abonnenter** - Brugere med "abonnent" rolle kan se hele webstedet
   - ☑️ **Vis admin bar** - Vis WordPress toolbar for admin brugere
   - ☑️ **Log adgangsforsøg** - Registrer hvem der bruger adgangskoden
   - ☑️ **Email notifikationer** - Modtag email når nogen bruger adgangskoden
   - 🔗 **Sociale medier** - Tilføj links til dine profiler (Facebook, Twitter, Instagram)

### Trin 5: Gem Indstillinger
- Klik **"Gem indstillinger"** for at gemme alle ændringer

---

## 💡 Praktisk Eksempel

### Scenario: Du er ved at redesigne dit websted

1. **Aktiver pluginet:**
   ```
   Indstillinger → Under Ombygning → Aktiver "Under Ombygning" ✓
   ```

2. **Tilpas teksten:**
   ```
   Overskrift: "Velkommen til vores nye websted!"
   Besked: "Vi er i gang med at redesigne vores hjemmeside. 
            Vi lancerer snart med en helt ny design og flere funktioner!"
   ```

3. **Indstil adgangskode:**
   ```
   Adgangskode: "design2024"
   ```
   → Dele koden med dine kollegaer/venner så de kan se det nye design

4. **Tilpas farver:**
   - Baggrundsfarve: #F5F5F5 (lys grå)
   - Tekstfarve: #333333 (mørkegrå)
   - Knapfarve: #FF6B6B (rød)

5. **Upload dit logo**
   - Klik "Upload Logo" og vælg dit firmas logo

6. **Gem** ✓

**Resultat:** Alle besøgende ser "Velkommen til vores nye websted!" meddelelsen, men kan få adgang ved at skrive "design2024"

---

## 👥 Hvem Kan Se Hvad?

| Brugertype | Standard | Med Adgangskode | Abonnenter Tilladt |
|-----------|:---:|:---:|:---:|
| **Besøgende** | ❌ Lock Screen | ✅ (med kode) | ❌ |
| **Abonnenter** | ❌ Lock Screen | ✅ (med kode) | ✅ |
| **Redaktører** | ❌ Lock Screen | ✅ (med kode) | ❌ |
| **Admins** | ✅ Normal | ✅ Normal | ✅ Normal |

---

## 📊 Access Log & Statistikker

### Øverste se hvem der forsøger at få adgang

1. Gå til **Indstillinger** → **Access Log**
2. Du vil se:
   - 📊 Statistik (i alt forsøg, vellykkede, mislykkede)
   - 📋 Tabel med alle forsøg (tidspunkt, status, kode brugt, IP-adresse)

### Handlinger:
- **Download CSV** - Eksportér log som Excel-fil
- **Slet Log** - Ryd alle logge-indgange

---

## ❌ Deaktivering

### Når du er færdig med ombygningen

1. Gå til **Indstillinger** → **Under Ombygning**
2. **Fjern fluebenet** fra "Aktiver 'Under Ombygning'"
3. Klik **"Gem indstillinger"**

**Resultat:** Alle besøgende kan nu se hele webstedet normalt igen

**Bemærk:** Alle dine indstillinger gemmes, så du kan genaktivere det senere!

---

## 🔒 Sikkerhed

### Hvor gemmes adgangskoden?
- Gemmes sikkert i WordPress database
- Ikke tilgængelig for ikke-admin brugere

### Hvad logges?
- Tidspunkt for hvert forsøg
- Om det var en velykket eller mislykket forsøg
- IP-adresse på den der forsøgte
- Hvilken kode der blev brugt

### Best Practices:
- ✅ Brug en stærk, tilfældig adgangskode
- ✅ Skift koden regelmæssigt
- ✅ Kontrollér Access Log for mistænkelig aktivitet
- ✅ Deaktivér pluginet når du er færdig

---

## ❓ Ofte Stillede Spørgsmål

### Q: Vil siden "Under Ombygning" vises for mig, selv hvis jeg er admin?
**A:** Nej! Som admin ser du altid hele webstedet normalt, selv hvis "Under Ombygning" er aktiveret.

### Q: Hvordan deler jeg adgangskoden med andre?
**A:** Du kan dele den via email, social media, SMS osv. Der er ingen særlig måde.

### Q: Kan jeg ændre adgangskoden bagefter?
**A:** Ja! Besøgende med den gamle kode kan fortsat få adgang indtil 7 dage er gået (cookie). Du kan manuelt rydde deres cookies fra din server hvis nødvendigt.

### Q: Hvad sker der hvis jeg deaktiverer pluginet?
**A:** Siden "Under Ombygning" slukkes øjeblikkeligt, og alle kan se hele webstedet. Dine indstillinger bevares!

### Q: Kan jeg gøre søgemaskiner udelukket fra siden?
**A:** Ja! Pluginet sætter automatisk `noindex, follow` meta-tags for at forhindre indeksering.

---

## 🐛 Fejlfinding

### Problem: Siden vises stadig normalt selv efter jeg aktiverede pluginet

**Løsning:**
1. Kontroller at du ikke er logget ind som admin
2. Åbn webstedet i en privat/inkognito browser-vindue
3. Tøm din browser cache

### Problem: Adgangskoden virker ikke

**Løsning:**
1. Kontroller stavningen (store/små bogstaver matters!)
2. Tøm cookies i din browser
3. Kontroller at adgangskoden ikke er tom i indstillingerne

### Problem: Logo vises ikke på siden

**Løsning:**
1. Kontroller at billedstørrelsen er rimelig (under 5 MB)
2. Prøv at reuploade billedet
3. Kontroller at media-biblioteket virker

### Problem: Jeg kan ikke få adgang til WordPress admin efter aktivering

**Løsning:**
1. Log ud og log ind igen
2. Som admin skal du altid kunne se hele webstedet
3. Hvis det ikke virker, deaktivér pluginet via FTP

---

## 📞 Support

Hvis du oplever problemer:

1. **Isolér problemet:**
   - Deaktivér alle andre plugins
   - Aktiver Site Lock igen
   - Test funktionaliteten

2. **Kontrollér logge:**
   - Se i **Indstillinger → Access Log** for fejl

3. **Få hjælp:**
   - Se README.md for mere dokumentation
   - Kontakt din webhost hvis problemet fortsætter

---

## 📝 Changelog

### Version 1.0.0
- ✅ Første udgave
- ✅ Fuldt dansk interface
- ✅ Adgangskode-beskyttelse
- ✅ Logo og farve-tilpasning
- ✅ Access logging
- ✅ Email notifikationer
- ✅ Sociale medier links

---

**Lavet med ❤️ for Cronovelo**

Versionsnummer: 1.0.0  
Senest opdateret: 2024
