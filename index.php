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
$galleryAll = $c['gallery'] ?? [];
$galleryFirst = array_slice($galleryAll, 0, 8);
$galleryHasMore = count($galleryAll) > 8;
// dátum: farebné lomky ako na plagáte
$heroDateHtml = str_replace('/', '<span class="sl">/</span>', h($hero['date_line']));
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
<link rel="stylesheet" href="assets/css/style.css?v=2">
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
      <a href="#kontakt">Kontakt</a>
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
    <p class="hero-date"><?= $heroDateHtml ?></p>
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

<!-- ATRAKCIE -->
<?php if (!empty($c['activities'])): ?>
<section class="section section-cream" id="atrakcie">
  <div class="wrap">
    <div class="center">
      <p class="eyebrow script">Pre deti aj dospelých</p>
      <h2>Atrakcie a aktivity</h2>
      <p class="lead narrow">Počas celého popoludnia nájdeš na lúke množstvo aktivít – a mnoho ďalšieho.</p>
    </div>
    <div class="act-grid">
      <?php foreach ($c['activities'] as $a): ?>
      <div class="act-card">
        <?php if (!empty($a['photo'])): ?>
        <img class="act-photo" src="<?= h($a['photo']) ?>" alt="<?= h($a['title']) ?>" loading="lazy" decoding="async">
        <?php else: ?>
        <div class="act-photo act-placeholder" aria-hidden="true"><span><?= h($a['icon'] ?? '✨') ?></span></div>
        <?php endif; ?>
        <div class="act-body">
          <h4><?= h($a['title']) ?></h4>
          <?php if (!empty($a['desc'])): ?><p><?= h($a['desc']) ?></p><?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

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
      <?php foreach ($galleryFirst as $i => $g): ?>
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

<!-- MIESTO -->
<section class="section" id="miesto">
  <div class="wrap">
    <div class="center">
      <p class="eyebrow script">Ako sa k nám dostať</p>
      <h2>Miesto a doprava</h2>
      <p class="lead narrow"><?= h($place['text']) ?></p>
    </div>
    <div class="map-box">
      <iframe src="https://maps.google.com/maps?q=<?= rawurlencode($place['maps_embed_q']) ?>&t=k&z=14&hl=sk&output=embed" loading="lazy" title="Mapa – miesto podujatia" allowfullscreen referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <div class="place-grid">
      <div class="place-card"><h4>🅿️ Parkovanie</h4><p><?= h($place['parking']) ?></p></div>
      <div class="place-card"><h4>🥾 Príchod</h4><p><?= h($place['arrival']) ?></p></div>
    </div>
    <p class="center"><a class="btn btn-primary" href="<?= h($place['maps_url']) ?>" target="_blank" rel="noopener">Otvoriť miesto v mapách</a></p>
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
        <li><span>Technická podpora eventu</span><a href="mailto:<?= h($site['support_email']) ?>"><?= h($site['support_email']) ?></a></li>
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

</main>

<!-- FOOTER -->
<footer class="bigfoot">
  <svg class="foot-hills" viewBox="0 0 1440 90" preserveAspectRatio="none" aria-hidden="true">
    <path d="M0,90 L0,60 C120,35 260,20 420,38 C560,53 640,28 780,22 C920,16 1040,48 1180,52 C1300,55 1380,40 1440,30 L1440,90 Z" fill="currentColor"/>
  </svg>
  <div class="foot-glow" aria-hidden="true"></div>
  <div class="wrap foot-inner">
    <div class="foot-cta center">
      <img class="foot-logo" src="assets/img/logo-white.png" alt="" width="220" height="154" loading="lazy">
      <p class="foot-script script">Vidíme sa pri západe slnka</p>
      <p class="foot-date"><?= $heroDateHtml ?></p>
      <p class="foot-place"><?= h($hero['place_line']) ?></p>
      <div class="cta-buttons">
        <a class="btn btn-light" href="<?= h($place['maps_url']) ?>" target="_blank" rel="noopener">Otvoriť miesto v mapách</a>
        <?php if (!empty($site['facebook_event'])): ?>
        <a class="btn btn-outline" href="<?= h($site['facebook_event']) ?>" target="_blank" rel="noopener">Sledovať udalosť na Facebooku</a>
        <?php endif; ?>
      </div>
    </div>
    <div class="foot-grid">
      <div>
        <h4>Navigácia</h4>
        <ul>
          <li><a href="#program">Program</a></li>
          <li><a href="#lineup">Lineup</a></li>
          <li><a href="#galeria">Galéria</a></li>
          <li><a href="#miesto">Miesto</a></li>
        </ul>
      </div>
      <div>
        <h4>Kontakt</h4>
        <ul>
          <li><a href="mailto:<?= h($site['contact_email']) ?>"><?= h($site['contact_email']) ?></a></li>
          <li><a href="mailto:<?= h($site['support_email']) ?>"><?= h($site['support_email']) ?></a></li>
        </ul>
      </div>
      <div>
        <h4>Sledovať</h4>
        <ul>
          <?php if (!empty($site['instagram'])): ?><li><a href="<?= h($site['instagram']) ?>" target="_blank" rel="noopener">Instagram</a></li><?php endif; ?>
          <?php if (!empty($site['facebook_event'])): ?><li><a href="<?= h($site['facebook_event']) ?>" target="_blank" rel="noopener">Facebook</a></li><?php endif; ?>
          <li><a href="ochrana-osobnych-udajov.php">Ochrana osobných údajov</a></li>
        </ul>
      </div>
    </div>
    <div class="foot-bottom">
      <p>© <?= date('Y') ?> Sunset v Raji · Rajecká dolina</p>
    </div>
  </div>
</footer>

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

<script src="assets/js/main.js?v=2" defer></script>
</body>
</html>
