<?php
// Sunset v Raji 2026 — landing page
declare(strict_types=1);
$contentFile = __DIR__ . '/data/content.json';
$c = json_decode((string)file_get_contents($contentFile), true);
if (!is_array($c)) { http_response_code(500); exit('Chyba obsahu.'); }
function h(?string $s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
$site = $c['site']; $hero = $c['hero']; $info = $c['info']; $place = $c['place'];
$heroVideoMobile = is_file(__DIR__ . '/assets/video/hero-mobile.mp4') ? 'assets/video/hero-mobile.mp4' : null;
$finaleVideoMobile = is_file(__DIR__ . '/assets/video/finale-mobile.mp4') ? 'assets/video/finale-mobile.mp4' : null;
$baseUrl = 'https://sunsetvraji.sk/';
$priceParts = array_map('trim', explode(':', (string)($c['party']['price_label'] ?? ''), 2));
$priceTitle = $priceParts[0]; $priceValue = $priceParts[1] ?? '';
$actsPhoto = array_values(array_filter($c['activities'], fn($a) => !empty($a['photo'])));
$actsPlain = array_values(array_filter($c['activities'], fn($a) => empty($a['photo'])));
$galleryAll = $c['gallery'] ?? [];
$galleryFirst = array_slice($galleryAll, 0, 8);
$galleryHasMore = count($galleryAll) > 8;
$mapsUrl = $place['maps_url'];
$mapsCoords = $place['maps_coords'] ?? '49.0989067,18.6941883';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= h($site['title']) ?> – 1. august 2026, lúka nad Kamennou Porubou</title>
<meta name="description" content="<?= h($site['description']) ?>">
<link rel="canonical" href="<?= h($baseUrl) ?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?= h($site['title']) ?>">
<meta property="og:description" content="<?= h($site['description']) ?>">
<meta property="og:image" content="<?= h($baseUrl) ?>assets/img/og-image.jpg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:url" content="<?= h($baseUrl) ?>">
<meta property="og:locale" content="sk_SK">
<meta name="twitter:card" content="summary_large_image">
<link rel="icon" href="/favicon.ico" sizes="48x48">
<link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon-32.png">
<link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon-16.png">
<link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicon-180.png">
<link rel="manifest" href="site.webmanifest">
<link rel="preload" href="assets/fonts/Montserrat-700-latin-ext.woff2" as="font" type="font/woff2" crossorigin>
<link rel="stylesheet" href="assets/css/style.css?v=7">
<script type="application/ld+json">
<?= json_encode([
  '@context' => 'https://schema.org',
  '@type' => 'Festival',
  'name' => 'Sunset v Raji 2026',
  'startDate' => '2026-08-01T14:00:00+02:00',
  'endDate' => '2026-08-02T03:00:00+02:00',
  'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
  'location' => ['@type' => 'Place', 'name' => 'Lúka nad Kamennou Porubou', 'address' => ['@type'=>'PostalAddress','addressLocality'=>'Kamenná Poruba','addressCountry'=>'SK']],
  'isAccessibleForFree' => false,
  'offers' => [
    ['@type'=>'Offer','name'=>'Denný program','price'=>'0','priceCurrency'=>'EUR'],
    ['@type'=>'Offer','name'=>'Večerná párty','price'=>'10','priceCurrency'=>'EUR'],
  ],
  'image' => $baseUrl.'assets/img/og-image.jpg',
  'description' => $site['description'],
], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) ?>
</script>
</head>
<body data-pixel="<?= h($site['meta_pixel_id']) ?>" data-ga="<?= h($site['ga_id']) ?>">

<header class="nav" id="nav">
  <div class="nav-inner">
    <a class="nav-brand" href="#hore" aria-label="Sunset v Raji – späť hore">
      <img src="assets/img/logo-white.png" alt="Sunset v Raji" width="86" height="60">
    </a>
    <nav class="nav-links" id="navLinks" aria-label="Hlavná navigácia">
      <a href="#den">Program</a>
      <a href="#lineup">Lineup</a>
      <a href="#galeria">Galéria</a>
      <a href="#informacie">Info</a>
      <a href="#kontakt">Kontakt</a>
    </nav>
    <button class="nav-burger" id="navBurger" aria-label="Otvoriť menu" aria-expanded="false"><span></span><span></span><span></span></button>
  </div>
</header>

<main id="hore">

<!-- HERO -->
<section class="hero" id="hero">
  <div class="hero-bg" aria-hidden="true">
    <picture>
      <source media="(max-width: 640px)" srcset="assets/img/hero-mobile.jpg">
      <img class="hero-photo" src="assets/img/hero.jpg" alt="" fetchpriority="high">
    </picture>
    <?php if ($heroVideoMobile): ?>
    <video class="bg-video-mobile" muted loop playsinline preload="none" poster="assets/img/hero-mobile.jpg" data-src-mobile="<?= h($heroVideoMobile) ?>"></video>
    <?php endif; ?>
    <div class="hero-shade"></div>
  </div>
  <div class="hero-content">
    <img class="hero-logo" src="assets/img/logo-white.png" alt="Sunset v Raji" width="360" height="252" fetchpriority="high">
    <p class="hero-date"><?= h($hero['date_line']) ?></p>
    <p class="hero-place"><?= h($hero['place_line']) ?></p>
    <p class="hero-claim script"><?= h($hero['claim_line'] ?? '') ?></p>
    <p class="hero-sub"><?= h($hero['sub_line']) ?></p>
    <div class="hero-btns">
      <a class="btn btn-primary" href="#den">Pozrieť program</a>
      <a class="btn btn-outline" href="<?= h($mapsUrl) ?>" target="_blank" rel="noopener">Otvoriť miesto v mapách</a>
    </div>
  </div>
  <a class="hero-scroll" href="#domov" aria-label="Posunúť nižšie"><span></span></a>
</section>

<!-- NOVÝ DOMOV SUNSETU -->
<section class="section parallax-sec" id="domov">
  <div class="parallax-bg" aria-hidden="true"><img src="assets/img/bg/domov.jpg" alt="" loading="lazy" decoding="async"></div>
  <div class="parallax-shade shade-solid-blue" aria-hidden="true"></div>
  <div class="wrap narrow center parallax-content">
    <p class="eyebrow script light-script"><?= h($c['about']['eyebrow']) ?></p>
    <h2 class="light"><?= h($c['about']['heading']) ?></h2>
    <p class="lead light-p"><?= h($c['about']['text']) ?></p>
    <p class="lead light-p"><?= h($c['about']['text2'] ?? '') ?></p>
    <p class="motto"><?= h($c['about']['motto'] ?? '') ?></p>
  </div>
</section>

<!-- DEŇ PRE DETI AJ DOSPELÝCH -->
<section class="section section-cream" id="den">
  <div class="wrap">
    <div class="center narrow">
      <p class="eyebrow script"><?= h($c['day']['eyebrow']) ?></p>
      <h2><?= h($c['day']['heading']) ?></h2>
      <p class="lead"><?= h($c['day']['text']) ?></p>
    </div>
    <?php if (!empty($c['program_day'])): ?>
    <div class="program-col program-day standalone">
      <h3><span class="sun-dot" aria-hidden="true"></span>Denný harmonogram</h3>
      <ul class="timeline">
        <?php foreach ($c['program_day'] as $it): ?>
        <li><span class="t-time"><?= h($it['time']) ?></span><span class="t-body"><strong><?= h($it['title']) ?></strong><?php if ($it['desc'] !== ''): ?><em><?= h($it['desc']) ?></em><?php endif; ?></span></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>
    <?php if ($actsPhoto): ?>
    <div class="act-grid">
      <?php foreach ($actsPhoto as $a): ?>
      <div class="act-card">
        <img class="act-photo" src="<?= h($a['photo']) ?>" alt="<?= h($a['title']) ?>" loading="lazy" decoding="async">
        <div class="act-body">
          <h4><?= h($a['title']) ?></h4>
          <?php if (!empty($a['desc'])): ?><p><?= h($a['desc']) ?></p><?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <?php if ($actsPlain): ?>
    <div class="act-more">
      <p class="act-more-title">A okrem toho ťa čaká</p>
      <ul class="act-chips">
        <?php foreach ($actsPlain as $a): ?>
        <li<?php if (!empty($a['desc'])): ?> title="<?= h($a['desc']) ?>"<?php endif; ?>><span class="ci" aria-hidden="true"><?= h($a['icon'] ?? '✨') ?></span><?= h($a['title']) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>
    <?php if (!empty($c['day']['note'])): ?><p class="center muted small note-gap"><?= h($c['day']['note']) ?></p><?php endif; ?>
  </div>
</section>

<!-- CHILL-OUT ZÓNA -->
<section class="section parallax-sec" id="chill">
  <div class="parallax-bg" aria-hidden="true"><img src="assets/img/bg/chill.jpg" alt="" loading="lazy" decoding="async"></div>
  <div class="parallax-shade" aria-hidden="true"></div>
  <div class="wrap narrow center parallax-content">
    <p class="eyebrow script light-script"><?= h($c['chillout']['eyebrow']) ?></p>
    <h2 class="light"><?= h($c['chillout']['heading']) ?></h2>
    <p class="lead light-p"><?= h($c['chillout']['text']) ?></p>
    <p class="lead light-p"><?= h($c['chillout']['text2'] ?? '') ?></p>
  </div>
</section>

<!-- JEDLO A OBČERSTVENIE -->
<section class="section section-cream" id="jedlo">
  <div class="wrap">
    <div class="center narrow">
      <p class="eyebrow script"><?= h($c['food']['eyebrow']) ?></p>
      <h2><?= h($c['food']['heading']) ?></h2>
      <p class="lead"><?= h($c['food']['text']) ?></p>
    </div>
    <div class="food-grid">
      <?php foreach ($c['food']['vendors'] as $v): ?>
      <div class="food-card">
        <span class="food-ico"><?= h($v['icon'] ?? '🍴') ?></span>
        <h4><?= h($v['name']) ?></h4>
        <p><?= h($v['desc']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="food-photos">
      <img src="assets/img/sekcie/jedlo-1.jpg" alt="Sunset bar počas dňa" loading="lazy" decoding="async">
      <img src="assets/img/sekcie/jedlo-2.jpg" alt="Burger z Farmy Bardy" loading="lazy" decoding="async">
    </div>
  </div>
</section>

<!-- PÁRTY POD HVIEZDAMI -->
<section class="section parallax-sec" id="party">
  <div class="parallax-bg" aria-hidden="true"><img src="assets/img/bg/party.jpg" alt="" loading="lazy" decoding="async"></div>
  <div class="parallax-shade shade-solid-sunset" aria-hidden="true"></div>
  <div class="wrap narrow center parallax-content">
    <p class="eyebrow script light-script"><?= h($c['party']['eyebrow']) ?></p>
    <h2 class="light"><?= h($c['party']['heading']) ?></h2>
    <p class="lead light-p"><?= h($c['party']['text']) ?></p>
    <div class="price-box">
      <span class="price-title"><?= h($priceTitle) ?></span>
      <?php if ($priceValue !== ''): ?><span class="price-value"><?= h($priceValue) ?></span><?php endif; ?>
    </div>
    <p class="small light-p"><?= h($c['party']['price_note']) ?></p>
  </div>
</section>

<!-- LINEUP -->
<section class="section section-night" id="lineup">
  <div class="night-bg" aria-hidden="true"><img src="assets/img/sekcie/lineup.jpg" alt="" loading="lazy" decoding="async"></div>
  <div class="wrap night-content">
    <div class="center">
      <p class="eyebrow script light-script">Keď zapadne slnko</p>
      <h2>Lineup</h2>
      <p class="lead light-p"><?= h($c['lineup_intro'] ?? '') ?></p>
    </div>
    <div class="lineup-grid">
      <?php foreach ($c['lineup'] as $dj):
        $initials = mb_strtoupper(mb_substr(trim($dj['name']), 0, 1, 'UTF-8'), 'UTF-8'); ?>
      <div class="dj">
        <?php if (!empty($dj['photo'])): ?>
        <img class="dj-photo" src="<?= h($dj['photo']) ?>" alt="<?= h($dj['name']) ?>" loading="lazy" width="160" height="160">
        <?php else: ?>
        <span class="dj-photo dj-initials" aria-hidden="true"><?= h($initials) ?></span>
        <?php endif; ?>
        <span class="dj-name"><?= h($dj['name']) ?><?php if ($dj['meta'] !== ''): ?> <small>(<?= h($dj['meta']) ?>)</small><?php endif; ?></span>
        <?php if ($dj['desc'] !== ''): ?><span class="dj-desc"><?= h($dj['desc']) ?></span><?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
    <?php if (!empty($c['program_night'])): ?>
    <div class="program-col program-night standalone">
      <h3><span class="moon-dot" aria-hidden="true"></span>Večerný harmonogram</h3>
      <ul class="timeline">
        <?php foreach ($c['program_night'] as $it): ?>
        <li><span class="t-time"><?= h($it['time']) ?></span><span class="t-body"><strong><?= h($it['title']) ?></strong><?php if ($it['desc'] !== ''): ?><em><?= h($it['desc']) ?></em><?php endif; ?></span></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>
    <?php if (!empty($c['lineup_note'])): ?><p class="center small light-muted note-gap"><?= h($c['lineup_note']) ?></p><?php endif; ?>
  </div>
</section>

<!-- GALÉRIA / ATMOSFÉRA -->
<section class="section section-cream" id="galeria">
  <div class="wrap">
    <div class="center narrow">
      <p class="eyebrow script"><?= h($c['atmosphere']['eyebrow']) ?></p>
      <h2><?= h($c['atmosphere']['heading']) ?></h2>
      <p class="lead"><?= h($c['atmosphere']['text']) ?></p>
      <p class="lead"><?= h($c['atmosphere']['text2'] ?? '') ?></p>
      <p class="motto motto-dark"><?= h($c['atmosphere']['motto'] ?? '') ?></p>
    </div>
    <div class="gallery" id="gallery">
      <?php foreach ($galleryFirst as $g): ?>
      <a href="<?= h($g['src']) ?>" class="g-item">
        <img src="<?= h($g['thumb'] ?: $g['src']) ?>" alt="<?= h($g['alt']) ?>" loading="lazy" decoding="async">
      </a>
      <?php endforeach; ?>
    </div>
    <div class="center gallery-more-wrap">
      <button class="btn btn-ghost<?= $galleryHasMore ? '' : ' hide' ?>" id="galleryMore" type="button" data-offset="8">Zobraziť viac fotiek</button>
    </div>
  </div>
</section>

<!-- PRAKTICKÉ INFORMÁCIE -->
<section class="section parallax-sec" id="informacie">
  <div class="parallax-bg" aria-hidden="true"><img src="assets/img/bg/info.jpg" alt="" loading="lazy" decoding="async"></div>
  <div class="parallax-shade shade-dark" aria-hidden="true"></div>
  <div class="wrap parallax-content">
    <div class="center">
      <p class="eyebrow script light-script">Informácie, ktoré by si mal vedieť</p>
      <h2 class="light">Praktické informácie</h2>
    </div>
    <div class="info-grid">
      <div class="info-card"><span class="info-ico">📅</span><span class="info-label">Dátum</span><span class="info-value"><?= h($info['date']) ?></span></div>
      <div class="info-card"><span class="info-ico">🕑</span><span class="info-label">Otvorenie areálu</span><span class="info-value"><?= h($info['time']) ?></span></div>
      <div class="info-card"><span class="info-ico">📍</span><span class="info-label">Miesto</span><span class="info-value"><?= h($info['place']) ?></span><a class="info-link" href="<?= h($mapsUrl) ?>" target="_blank" rel="noopener">Otvoriť v Google Maps →</a></div>
      <div class="info-card"><span class="info-ico">🎟️</span><span class="info-label">Vstupné</span><span class="info-value accent"><?= h($info['entry']) ?></span></div>
    </div>
    <div class="place-grid">
      <div class="place-card"><h4>🅿️ Parkovanie</h4><p><?= h($place['parking']) ?></p></div>
      <div class="place-card"><h4>🥾 Príchod</h4><p><?= h($place['arrival']) ?></p></div>
    </div>
    <div class="map-box">
      <iframe src="https://maps.google.com/maps?q=<?= rawurlencode($mapsCoords) ?>&t=k&z=15&hl=sk&output=embed" loading="lazy" title="Mapa – miesto podujatia" allowfullscreen referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <p class="center map-btn-gap"><a class="btn btn-primary" href="<?= h($mapsUrl) ?>" target="_blank" rel="noopener">Otvoriť miesto v Google Maps</a></p>
  </div>
</section>

<!-- KONTAKT -->
<section class="section section-cream" id="kontakt">
  <div class="wrap contact-wrap">
    <div class="contact-info">
      <p class="eyebrow script">Chceš sa niečo opýtať?</p>
      <h2>Napíš nám</h2>
      <p>Ozvi sa nám s čímkoľvek – otázky k programu, spolupráca, stánky alebo len tak.</p>
      <ul class="contact-mails">
        <li><span>Všeobecné otázky</span><a href="mailto:<?= h($site['contact_email']) ?>"><?= h($site['contact_email']) ?></a></li>
        <li><span>Podpora podujatia</span><a href="mailto:<?= h($site['support_email']) ?>"><?= h($site['support_email']) ?></a></li>
      </ul>
    </div>
    <form class="contact-form" id="contactForm" method="post" action="kontakt.php" novalidate>
      <input type="text" name="website" class="hp" tabindex="-1" autocomplete="off" aria-hidden="true">
      <input type="hidden" name="ts" value="<?= time() ?>">
      <label>Meno<input type="text" name="name" required maxlength="120" autocomplete="name"></label>
      <label>E-mail<input type="email" name="email" required maxlength="200" autocomplete="email"></label>
      <label>Správa<textarea name="message" rows="5" required maxlength="5000"></textarea></label>
      <button class="btn btn-primary" type="submit" id="contactSubmit">Odoslať správu</button>
      <p class="form-status" id="formStatus" role="status" aria-live="polite"></p>
    </form>
  </div>
</section>

<?php if (!empty($c['sponsors'])): ?>
<!-- PARTNERI PODUJATIA -->
<section class="sponsors-sec" id="partneri">
  <div class="wrap center">
    <p class="eyebrow script light-script">Ďakujeme, že to robia s nami</p>
    <h2>Partneri podujatia</h2>
    <div class="sponsors-row">
      <?php foreach ($c['sponsors'] as $s): ?>
      <img src="<?= h($s['img']) ?>" alt="<?= h($s['name']) ?>" title="<?= h($s['name']) ?>" loading="lazy" decoding="async">
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

</main>

<!-- FINALE + FOOTER (spoločné pozadie) -->
<div class="finale">
  <div class="finale-bg" aria-hidden="true">
    <img src="assets/img/bg/finale.jpg" alt="" loading="lazy" decoding="async">
    <?php if ($finaleVideoMobile): ?>
    <video class="bg-video-mobile" muted loop playsinline preload="none" poster="assets/img/bg/finale.jpg" data-src-mobile="<?= h($finaleVideoMobile) ?>"></video>
    <?php endif; ?>
  </div>
  <div class="finale-shade" aria-hidden="true"></div>
  <div class="finale-content">
    <div class="wrap center finale-cta">
      <img class="foot-logo" src="assets/img/logo-white.png" alt="" width="200" height="140" loading="lazy">
      <h2 class="light finale-heading"><?= h($c['finale']['heading']) ?></h2>
      <p class="light-p finale-text"><?= h($c['finale']['text']) ?></p>
      <p class="foot-date"><?= h($c['finale']['date_line']) ?></p>
      <p class="foot-place"><?= h($c['finale']['place_line']) ?></p>
      <p class="script finale-claim"><?= h($c['finale']['claim']) ?></p>
      <?php if (!empty($site['facebook_event'])): ?>
      <div class="cta-buttons">
        <a class="btn btn-outline" href="<?= h($site['facebook_event']) ?>" target="_blank" rel="noopener">Sledovať udalosť na Facebooku</a>
      </div>
      <?php endif; ?>
    </div>
    <footer class="foot-area">
      <div class="wrap foot-grid">
        <div>
          <h4>Navigácia</h4>
          <ul>
            <li><a href="#den">Program</a></li>
            <li><a href="#lineup">Lineup</a></li>
            <li><a href="#galeria">Galéria</a></li>
            <li><a href="#informacie">Info</a></li>
          </ul>
        </div>
        <div>
          <h4>Kontakt</h4>
          <ul>
            <li><a href="mailto:<?= h($site['contact_email']) ?>"><?= h($site['contact_email']) ?></a></li>
            <li><a href="mailto:<?= h($site['support_email']) ?>"><?= h($site['support_email']) ?></a></li>
          </ul>
        </div>
        <?php if (!empty($site['instagram']) || !empty($site['facebook_event'])): ?>
        <div>
          <h4>Sledovať</h4>
          <ul>
            <?php if (!empty($site['instagram'])): ?><li><a href="<?= h($site['instagram']) ?>" target="_blank" rel="noopener">Instagram</a></li><?php endif; ?>
            <?php if (!empty($site['facebook_event'])): ?><li><a href="<?= h($site['facebook_event']) ?>" target="_blank" rel="noopener">Facebook</a></li><?php endif; ?>
          </ul>
        </div>
        <?php endif; ?>
        <div>
          <h4>Právne</h4>
          <ul>
            <li><a href="ochrana-osobnych-udajov.php">Ochrana osobných údajov</a></li>
            <li><a href="obchodne-podmienky.php">Všeobecné obchodné podmienky</a></li>
            <li><a href="https://techessence.sk/wp-content/uploads/2024/02/Reklamacny-formular.pdf" target="_blank" rel="noopener">Reklamačný formulár</a></li>
            <li><a href="https://techessence.sk/wp-content/uploads/2024/02/Odstupenie-od-zmluvy.pdf" target="_blank" rel="noopener">Odstúpenie od zmluvy</a></li>
            <li><a href="https://techessence.sk/wp-content/uploads/2024/02/Navrh-na-zacatie-alternativneho-riesenia-sporu.pdf" target="_blank" rel="noopener">Alternatívne riešenie sporov</a></li>
          </ul>
        </div>
      </div>
      <div class="foot-bottom">
        <p>© <?= date('Y') ?> Sunset v Raji · Rajecká dolina</p>
      </div>
    </footer>
  </div>
</div>

<button class="to-top" id="toTop" aria-label="Späť hore">
  <svg class="to-top-ring" viewBox="0 0 48 48" aria-hidden="true">
    <circle class="ring-bg" cx="24" cy="24" r="21"/>
    <circle class="ring-fg" cx="24" cy="24" r="21" id="ringFg"/>
  </svg>
  <span class="to-top-arrow">↑</span>
</button>

<div class="lightbox" id="lightbox" hidden>
  <button class="lb-close" id="lbClose" aria-label="Zavrieť">×</button>
  <button class="lb-prev" id="lbPrev" aria-label="Predchádzajúca">‹</button>
  <img id="lbImg" src="" alt="">
  <button class="lb-next" id="lbNext" aria-label="Ďalšia">›</button>
</div>

<div class="cookiebar" id="cookiebar" hidden>
  <p>Používame cookies na meranie návštevnosti a účinnosti reklamy (Meta Pixel, analytika). Nevyhnutné cookies fungujú vždy. <a href="ochrana-osobnych-udajov.php">Viac informácií</a></p>
  <div class="cookiebar-btns">
    <button class="btn btn-primary btn-sm" id="ckAll" type="button">Súhlasím</button>
    <button class="btn btn-ghost btn-sm" id="ckNec" type="button">Iba nevyhnutné</button>
  </div>
</div>

<script src="assets/js/main.js?v=5" defer></script>
</body>
</html>
