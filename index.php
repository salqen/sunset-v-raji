<?php
// Sunset v Raji 2026 — landing page
declare(strict_types=1);
$contentFile = __DIR__ . '/data/content.json';
$c = json_decode((string)file_get_contents($contentFile), true);
if (!is_array($c)) { http_response_code(500); exit('Chyba obsahu.'); }
function h(?string $s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
$site = $c['site']; $hero = $c['hero']; $info = $c['info']; $place = $c['place'];
$heroVideo = is_file(__DIR__ . '/assets/video/hero.webm') ? 'assets/video/hero.webm' : null;
$heroVideoMp4 = is_file(__DIR__ . '/assets/video/hero.mp4') ? 'assets/video/hero.mp4' : null;
$baseUrl = 'https://sunsetvraji.sk/';
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
<link rel="stylesheet" href="assets/css/style.css?v=1">
<script type="application/ld+json">
<?= json_encode([
  '@context' => 'https://schema.org',
  '@type' => 'Festival',
  'name' => 'Sunset v Raji 2026',
  'startDate' => '2026-08-01T14:00:00+02:00',
  'endDate' => '2026-08-02T03:00:00+02:00',
  'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
  'location' => ['@type' => 'Place', 'name' => 'Lúka nad Kamennou Porubou', 'address' => ['@type'=>'PostalAddress','addressLocality'=>'Kamenná Poruba','addressCountry'=>'SK']],
  'isAccessibleForFree' => true,
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
      <a href="#program">Program</a>
      <a href="#lineup">Lineup</a>
      <a href="#galeria">Galéria</a>
      <a href="#miesto">Miesto</a>
    </nav>
    <button class="nav-burger" id="navBurger" aria-label="Otvoriť menu" aria-expanded="false"><span></span><span></span><span></span></button>
  </div>
</header>

<main id="hore">

<!-- HERO -->
<section class="hero" id="hero">
  <div class="hero-bg" aria-hidden="true">
    <?php if ($heroVideo || $heroVideoMp4): ?>
    <video class="hero-video" autoplay muted loop playsinline preload="metadata" poster="assets/img/hero-landscape.jpg">
      <?php if ($heroVideo): ?><source src="<?= h($heroVideo) ?>" type="video/webm"><?php endif; ?>
      <?php if ($heroVideoMp4): ?><source src="<?= h($heroVideoMp4) ?>" type="video/mp4"><?php endif; ?>
    </video>
    <?php else: ?>
    <div class="hero-sky"></div>
    <img class="hero-landscape" src="assets/img/hero-landscape.jpg" alt="" fetchpriority="high">
    <?php endif; ?>
    <div class="hero-shade"></div>
  </div>
  <div class="hero-content">
    <img class="hero-logo" src="assets/img/logo-white.png" alt="Sunset v Raji" width="360" height="252" fetchpriority="high">
    <p class="hero-date"><?= h($hero['date_line']) ?></p>
    <p class="hero-place"><?= h($hero['place_line']) ?></p>
    <p class="hero-sub"><?= h($hero['sub_line']) ?></p>
    <a class="btn btn-primary" href="#o-podujati">Viac informácií</a>
  </div>
  <a class="hero-scroll" href="#o-podujati" aria-label="Posunúť nižšie"><span></span></a>
</section>

<!-- O PODUJATÍ -->
<section class="section section-cream" id="o-podujati">
  <div class="wrap narrow center">
    <p class="eyebrow script"><?= h($site['claim']) ?></p>
    <h2><?= h($c['about']['heading']) ?></h2>
    <p class="lead"><?= h($c['about']['text']) ?></p>
  </div>
</section>

<!-- INFO KARTY -->
<section class="section section-cream pt-0" id="info">
  <div class="wrap">
    <div class="info-grid">
      <div class="info-card"><span class="info-ico">📅</span><span class="info-label">Dátum</span><span class="info-value"><?= h($info['date']) ?></span></div>
      <div class="info-card"><span class="info-ico">🕑</span><span class="info-label">Čas</span><span class="info-value"><?= h($info['time']) ?></span></div>
      <div class="info-card"><span class="info-ico">📍</span><span class="info-label">Miesto</span><span class="info-value"><?= h($info['place']) ?></span><a class="info-link" href="<?= h($place['maps_url']) ?>" target="_blank" rel="noopener">Otvoriť v Google Maps →</a></div>
      <div class="info-card"><span class="info-ico">🎟️</span><span class="info-label">Vstup</span><span class="info-value accent"><?= h($info['entry']) ?></span></div>
    </div>
  </div>
</section>

<!-- PROGRAM -->
<section class="section" id="program">
  <div class="wrap">
    <div class="center">
      <p class="eyebrow script">Od popoludnia do rána</p>
      <h2>Program</h2>
    </div>
    <div class="program-cols">
      <div class="program-col program-day">
        <h3><span class="sun-dot" aria-hidden="true"></span>Denný program</h3>
        <p class="muted">Popoludnie pre rodiny, deti aj dospelých.</p>
        <?php if (!empty($c['program_day'])): ?>
        <ul class="timeline">
          <?php foreach ($c['program_day'] as $it): ?>
          <li><span class="t-time"><?= h($it['time']) ?></span><span class="t-body"><strong><?= h($it['title']) ?></strong><?php if ($it['desc'] !== ''): ?><em><?= h($it['desc']) ?></em><?php endif; ?></span></li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <?php if (!empty($c['day_activities'])): ?>
        <div class="chips">
          <?php foreach ($c['day_activities'] as $a): ?><span class="chip"><?= h($a) ?></span><?php endforeach; ?>
          <span class="chip chip-more">a mnoho ďalšieho</span>
        </div>
        <?php endif; ?>
      </div>
      <div class="program-col program-night">
        <h3><span class="moon-dot" aria-hidden="true"></span>Večerný program</h3>
        <p class="muted">Elektronická párty pri západe slnka a počas noci.</p>
        <?php if (!empty($c['program_night'])): ?>
        <ul class="timeline">
          <?php foreach ($c['program_night'] as $it): ?>
          <li><span class="t-time"><?= h($it['time']) ?></span><span class="t-body"><strong><?= h($it['title']) ?></strong><?php if ($it['desc'] !== ''): ?><em><?= h($it['desc']) ?></em><?php endif; ?></span></li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
      </div>
    </div>
    <?php if (!empty($c['program_note'])): ?><p class="center muted small"><?= h($c['program_note']) ?></p><?php endif; ?>
  </div>
</section>

<!-- LINEUP -->
<section class="section section-night" id="lineup">
  <div class="wrap">
    <div class="center">
      <p class="eyebrow script light">Keď zapadne slnko</p>
      <h2>Lineup</h2>
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
  </div>
</section>

<!-- GALÉRIA -->
<section class="section section-cream" id="galeria">
  <div class="wrap">
    <div class="center">
      <p class="eyebrow script">Ako to u nás vyzerá</p>
      <h2>Atmosféra minulých rokov</h2>
    </div>
    <div class="gallery" id="gallery">
      <?php foreach ($c['gallery'] as $i => $g): ?>
      <a href="<?= h($g['src']) ?>" class="g-item" data-index="<?= $i ?>">
        <img src="<?= h($g['thumb'] ?: $g['src']) ?>" alt="<?= h($g['alt']) ?>" loading="lazy" decoding="async">
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- MIESTO -->
<section class="section" id="miesto">
  <div class="wrap">
    <div class="center">
      <p class="eyebrow script">Ako sa k nám dostať</p>
      <h2>Miesto a doprava</h2>
      <p class="lead narrow"><?= h($place['text']) ?></p>
    </div>
    <div class="map-box" id="mapBox" data-q="<?= h($place['maps_embed_q']) ?>">
      <button class="btn btn-ghost" id="mapLoad" type="button">Zobraziť mapu</button>
      <p class="small muted">Kliknutím sa načíta mapa Google. </p>
    </div>
    <div class="place-grid">
      <div class="place-card"><h4>🅿️ Parkovanie</h4><p><?= h($place['parking']) ?></p></div>
      <div class="place-card"><h4>🥾 Príchod</h4><p><?= h($place['arrival']) ?></p></div>
    </div>
    <p class="center"><a class="btn btn-primary" href="<?= h($place['maps_url']) ?>" target="_blank" rel="noopener">Otvoriť miesto v mapách</a></p>
  </div>
</section>

<!-- ZÁVEREČNÁ VÝZVA -->
<section class="section section-sunset center" id="cta">
  <div class="wrap narrow">
    <img class="cta-logo" src="assets/img/logo-white.png" alt="" width="220" height="154" loading="lazy">
    <h2 class="light">Vidíme sa 1. augusta<br>na lúke nad Kamennou Porubou.</h2>
    <div class="cta-buttons">
      <a class="btn btn-light" href="<?= h($place['maps_url']) ?>" target="_blank" rel="noopener">Otvoriť miesto v mapách</a>
      <?php if (!empty($site['facebook_event'])): ?>
      <a class="btn btn-outline" href="<?= h($site['facebook_event']) ?>" target="_blank" rel="noopener">Sledovať udalosť na Facebooku</a>
      <?php endif; ?>
    </div>
  </div>
</section>

</main>

<footer class="footer">
  <div class="wrap footer-inner">
    <p>© <?= date('Y') ?> Sunset v Raji</p>
    <p class="footer-social">
      <?php if (!empty($site['instagram'])): ?><a href="<?= h($site['instagram']) ?>" target="_blank" rel="noopener">Instagram</a><?php endif; ?>
      <?php if (!empty($site['facebook_event'])): ?><a href="<?= h($site['facebook_event']) ?>" target="_blank" rel="noopener">Facebook</a><?php endif; ?>
      <a href="ochrana-osobnych-udajov.php">Ochrana osobných údajov</a>
    </p>
  </div>
</footer>

<button class="to-top" id="toTop" aria-label="Späť hore">↑</button>

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

<script src="assets/js/main.js?v=1" defer></script>
</body>
</html>
