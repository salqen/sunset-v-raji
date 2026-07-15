# Sunset v Raji 2026 — landing page

Jednostránkový web pre podujatie **Sunset v Raji** (1. 8. 2026, lúka nad Kamennou Porubou).
Postavený pre klasický **Websupport hosting** (Apache + PHP 8), bez databázy.

## Štruktúra

```
index.php            hlavná stránka (obsah sa načítava z data/content.json)
gallery.php          AJAX endpoint – donačítanie ďalších fotiek galérie
kontakt.php          spracovanie kontaktného formulára (PHP mail())
admin/               administrácia obsahu (heslo, pozri nižšie)
data/content.json    všetok obsah webu (texty, program, lineup, galéria)
data/config.php      hash hesla do administrácie
assets/              CSS, JS, fonty, obrázky, hero video
uploads/             fotky nahrané cez administráciu
```

## Nasadenie na Websupport

1. Cez FTP / WebFTP nahraj **celý obsah tohto priečinka** do `web/` (document root domény sunsetvraji.sk).
2. Skontroluj, že priečinky `data/` a `uploads/` (vrátane `uploads/gallery` a `uploads/lineup`) majú **práva na zápis** (0755/0775 zvyčajne stačí, PHP beží pod vlastníkom súborov).
3. V administratíve Websupportu zapni **Let's Encrypt SSL** pre doménu (presmerovanie na HTTPS je už v `.htaccess`).
4. Hotovo — web beží na `https://sunsetvraji.sk`.

## Administrácia obsahu

- URL: `https://sunsetvraji.sk/admin/`
- Predvolené heslo: `SunsetRaji2026!` — **po prvom prihlásení ho zmeň** (sekcia Zmena hesla).
- Dá sa upravovať: texty, info karty, denný/večerný program, atrakcie (ikona, popis, fotka), lineup (vrátane fotiek DJ-ov), galéria (upload, mazanie, poradie, alt popisy), miesto/parkovanie, kontaktné e-maily, odkazy (FB event, Instagram), Meta Pixel ID a Google Analytics ID.
- Fotky sa pri uploade automaticky zmenšia a zoptimalizujú (galéria max 1600 px + náhľad, DJ fotky max 600 px).

## Sponzori

Logá partnerov sú v `assets/img/sponsors/` (vytiahnuté z PSD plagátu) a zoznam v `data/content.json` (kľúč `sponsors`). Nové logo: nahraj PNG s priehľadnosťou do priečinka a pridaj záznam do JSON-u.

## Hero video

Do `assets/video/` nahraj `hero.webm` (a ideálne aj `hero.mp4` pre Safari/iOS).
Web ho automaticky použije namiesto statickej grafiky. Odporúčanie: 10–20 s slučka bez zvuku, 1280×720, max ~4–6 MB. Kým video nie je nahrané, zobrazuje sa fotografia západu slnka z plagátu (bez textov, vytiahnutá z PSD).

## Kontaktný formulár

- Formulár v sekcii Kontakt odosiela správy cez PHP `mail()` na adresu nastavenú v administrácii (predvolene `info@sunsetvraji.sk` – schránka musí existovať vo Websupport mailhostingu, čo už je splnené).
- `support@sunsetvraji.sk` je na webe uvedený len informačne (podpora eventu), formulár naň nechodí.
- Antispam: honeypot pole + časová kontrola, ochrana proti header injection.
- Galéria zobrazuje prvých 8 fotiek; ďalšie sa donačítajú tlačidlom cez `gallery.php` (AJAX) – tlačidlo sa zobrazí automaticky, keď je v galérii viac ako 8 fotiek.

## Meranie a cookies

- Meta Pixel a Google Analytics sa načítajú **až po súhlase** návštevníka v cookie lište (GDPR).
- ID sa nastavujú v administrácii (Nastavenia). Kým sú prázdne, nič sa nenačítava.

## Potrebné podklady (čo ešte dodať)

| Podklad | Formát | Poznámka |
|---|---|---|
| Hero video | `hero.webm` (+ `hero.mp4`), 1280×720, max ~6 MB, bez zvuku | nahrať do `assets/video/` |
| Fotky z minulých ročníkov | JPG, min. 1600 px šírka, 8–15 ks | nahrať cez administráciu → Galéria |
| Fotky DJ-ov | JPG/PNG štvorec, min. 400×400 px | administrácia → Lineup |
| Časový harmonogram | text | administrácia → Program |
| Facebook event URL | odkaz | administrácia → Nastavenia |
| Meta Pixel ID / GA ID | číslo / G-XXXX | administrácia → Nastavenia |
| Info o parkovaní a príchode | text | administrácia → Miesto |

## Technické poznámky

- Fonty (Montserrat, Kaushan Script) sú hostované lokálne — žiadne požiadavky na Google Fonts (GDPR).
- Mapa Google sa načítava až po kliknutí (rýchlosť + súkromie).
- OG meta tagy + `og-image.jpg` (1200×630) pre správny náhľad pri zdieľaní na FB/Messengeri.
- `robots.txt`, `sitemap.xml`, štruktúrované dáta (schema.org Festival).
- Záloha obsahu: pri každom uložení v administrácii vzniká `data/content.backup.json`.
