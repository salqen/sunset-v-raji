<?php
// Sunset v Raji — mini CMS
declare(strict_types=1);
session_start();

$ROOT = dirname(__DIR__);
$CONTENT = $ROOT . '/data/content.json';
$CONFIG = $ROOT . '/data/config.php';
$UP_GALLERY = $ROOT . '/uploads/gallery';
$UP_LINEUP = $ROOT . '/uploads/lineup';
$UP_ACT = $ROOT . '/uploads/activities';

$config = require $CONFIG;
function h(?string $s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

/* ---------- auth ---------- */
if (isset($_GET['logout'])) { session_destroy(); header('Location: index.php'); exit; }
$loginError = '';
if (($_POST['action'] ?? '') === 'login') {
    if (password_verify((string)($_POST['password'] ?? ''), $config['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['svr_admin'] = true;
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
        header('Location: index.php'); exit;
    }
    sleep(1);
    $loginError = 'Nesprávne heslo.';
}
$logged = !empty($_SESSION['svr_admin']);

if (!$logged): ?>
<!DOCTYPE html><html lang="sk"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Administrácia – Sunset v Raji</title><meta name="robots" content="noindex,nofollow">
<link rel="stylesheet" href="admin.css"></head>
<body class="login-body">
<form class="login-box" method="post" autocomplete="off">
  <h1>Sunset v Raji</h1><p>Administrácia obsahu</p>
  <?php if ($loginError): ?><p class="err"><?= h($loginError) ?></p><?php endif; ?>
  <input type="hidden" name="action" value="login">
  <input type="password" name="password" placeholder="Heslo" required autofocus>
  <button type="submit">Prihlásiť sa</button>
</form>
</body></html>
<?php exit; endif;

/* ---------- helpers ---------- */
$csrf = $_SESSION['csrf'];
function checkCsrf(): void {
    if (!hash_equals($_SESSION['csrf'] ?? '', (string)($_POST['csrf'] ?? ''))) {
        http_response_code(400); exit('Neplatná požiadavka (CSRF).');
    }
}
function loadContent(string $file): array {
    $d = json_decode((string)file_get_contents($file), true);
    return is_array($d) ? $d : [];
}
function saveContent(string $file, array $data): void {
    @copy($file, dirname($file) . '/content.backup.json');
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    $tmp = $file . '.tmp';
    file_put_contents($tmp, $json, LOCK_EX);
    rename($tmp, $file);
}
function str_field(string $key, string $default = ''): string {
    return trim((string)($_POST[$key] ?? $default));
}
function rows_field(string $key, array $cols): array {
    $out = [];
    $data = $_POST[$key] ?? [];
    if (!is_array($data)) return $out;
    $n = count($data[$cols[0]] ?? []);
    for ($i = 0; $i < $n; $i++) {
        $row = [];
        $empty = true;
        foreach ($cols as $col) {
            $v = trim((string)($data[$col][$i] ?? ''));
            $row[$col] = $v;
            if ($v !== '' && $col !== 'photo') $empty = false;
        }
        if (!$empty) $out[] = $row;
    }
    return $out;
}
function handleUpload(array $file, string $destDir, string $prefix, int $maxW, bool $thumb = false): ?array {
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) return null;
    if ($file['size'] > 12 * 1024 * 1024) return null;
    $info = @getimagesize($file['tmp_name']);
    if ($info === false || !in_array($info[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP], true)) return null;
    $img = match ($info[2]) {
        IMAGETYPE_JPEG => @imagecreatefromjpeg($file['tmp_name']),
        IMAGETYPE_PNG  => @imagecreatefrompng($file['tmp_name']),
        IMAGETYPE_WEBP => @imagecreatefromwebp($file['tmp_name']),
    };
    if (!$img) return null;
    $w = imagesx($img); $hh = imagesy($img);
    if ($w > $maxW) {
        $nh = (int)round($hh * $maxW / $w);
        $r = imagecreatetruecolor($maxW, $nh);
        imagecopyresampled($r, $img, 0, 0, 0, 0, $maxW, $nh, $w, $hh);
        imagedestroy($img); $img = $r;
    }
    $name = $prefix . '-' . date('Ymd-His') . '-' . substr(bin2hex(random_bytes(4)), 0, 6) . '.jpg';
    $path = $destDir . '/' . $name;
    imagejpeg($img, $path, 82);
    $result = ['src' => $name];
    if ($thumb) {
        $tw = 480; $w2 = imagesx($img); $h2 = imagesy($img);
        $th = (int)round($h2 * $tw / $w2);
        $t = imagecreatetruecolor($tw, $th);
        imagecopyresampled($t, $img, 0, 0, 0, 0, $tw, $th, $w2, $h2);
        imagejpeg($t, $destDir . '/thumb_' . $name, 75);
        imagedestroy($t);
        $result['thumb'] = 'thumb_' . $name;
    }
    imagedestroy($img);
    return $result;
}

$c = loadContent($CONTENT);
$msg = '';

/* ---------- save ---------- */
$action = $_POST['action'] ?? '';
if ($action === 'save') {
    checkCsrf();
    // základné
    $c['site']['title'] = str_field('site_title', $c['site']['title']);
    $c['site']['description'] = str_field('site_description');
    $c['site']['claim'] = str_field('site_claim');
    $c['hero']['date_line'] = str_field('hero_date');
    $c['hero']['place_line'] = str_field('hero_place');
    $c['hero']['sub_line'] = str_field('hero_sub');
    $c['about']['heading'] = str_field('about_heading');
    $c['about']['text'] = str_field('about_text');
    // info
    $c['info']['date'] = str_field('info_date');
    $c['info']['time'] = str_field('info_time');
    $c['info']['place'] = str_field('info_place');
    $c['info']['entry'] = str_field('info_entry');
    // program
    $c['program_day'] = rows_field('pday', ['time', 'title', 'desc']);
    $c['program_night'] = rows_field('pnight', ['time', 'title', 'desc']);
    $c['program_note'] = str_field('program_note');
    // atrakcie (fotky spracujeme pred filtrovaním prázdnych riadkov)
    $activities = [];
    $actNames = $_POST['act']['title'] ?? [];
    if (is_array($actNames)) {
        foreach (array_keys($actNames) as $i) {
            $a = [
                'icon'  => trim((string)($_POST['act']['icon'][$i] ?? '')),
                'title' => trim((string)($_POST['act']['title'][$i] ?? '')),
                'desc'  => trim((string)($_POST['act']['desc'][$i] ?? '')),
                'photo' => trim((string)($_POST['act']['photo'][$i] ?? '')),
            ];
            if (isset($_FILES['act_photo']['error'][$i]) && $_FILES['act_photo']['error'][$i] === UPLOAD_ERR_OK) {
                $f = ['tmp_name' => $_FILES['act_photo']['tmp_name'][$i], 'error' => $_FILES['act_photo']['error'][$i], 'size' => $_FILES['act_photo']['size'][$i]];
                $up = handleUpload($f, $UP_ACT, 'akt', 900);
                if ($up) $a['photo'] = 'uploads/activities/' . $up['src'];
            }
            if ($a['title'] !== '') $activities[] = $a;
        }
    }
    $c['activities'] = $activities;
    // lineup (existujúce fotky sa posielajú v hidden poli; fotky spracujeme pred filtrovaním prázdnych riadkov)
    $lineup = [];
    $names = $_POST['lineup']['name'] ?? [];
    if (is_array($names)) {
        foreach (array_keys($names) as $i) {
            $dj = [
                'name'  => trim((string)($_POST['lineup']['name'][$i] ?? '')),
                'meta'  => trim((string)($_POST['lineup']['meta'][$i] ?? '')),
                'desc'  => trim((string)($_POST['lineup']['desc'][$i] ?? '')),
                'photo' => trim((string)($_POST['lineup']['photo'][$i] ?? '')),
            ];
            if (isset($_FILES['lineup_photo']['error'][$i]) && $_FILES['lineup_photo']['error'][$i] === UPLOAD_ERR_OK) {
                $f = ['tmp_name' => $_FILES['lineup_photo']['tmp_name'][$i], 'error' => $_FILES['lineup_photo']['error'][$i], 'size' => $_FILES['lineup_photo']['size'][$i]];
                $up = handleUpload($f, $UP_LINEUP, 'dj', 600);
                if ($up) $dj['photo'] = 'uploads/lineup/' . $up['src'];
            }
            if ($dj['name'] !== '') $lineup[] = $dj;
        }
    }
    $c['lineup'] = $lineup;
    // miesto
    $c['place']['text'] = str_field('place_text');
    $c['place']['parking'] = str_field('place_parking');
    $c['place']['arrival'] = str_field('place_arrival');
    $c['place']['maps_url'] = str_field('place_maps_url');
    $c['place']['maps_embed_q'] = str_field('place_maps_q');
    // nastavenia
    $c['site']['facebook_event'] = str_field('set_fb');
    $c['site']['contact_email'] = str_field('set_email');
    $c['site']['support_email'] = str_field('set_support');
    $c['site']['instagram'] = str_field('set_ig');
    $c['site']['meta_pixel_id'] = str_field('set_pixel');
    $c['site']['ga_id'] = str_field('set_ga');
    // galéria: poradie + alt + mazanie
    if (isset($_POST['g_src']) && is_array($_POST['g_src'])) {
        $newGallery = [];
        foreach ($_POST['g_src'] as $i => $src) {
            if (!empty($_POST['g_del'][$i])) {
                $base = basename((string)$src);
                @unlink($UP_GALLERY . '/' . $base);
                @unlink($UP_GALLERY . '/thumb_' . $base);
                continue;
            }
            $newGallery[] = [
                'src' => (string)$src,
                'thumb' => (string)($_POST['g_thumb'][$i] ?? ''),
                'alt' => trim((string)($_POST['g_alt'][$i] ?? '')),
            ];
        }
        $c['gallery'] = $newGallery;
    }
    // nové fotky do galérie
    if (!empty($_FILES['gallery_new']['name'][0])) {
        foreach ($_FILES['gallery_new']['error'] as $i => $err) {
            if ($err !== UPLOAD_ERR_OK) continue;
            $f = ['tmp_name' => $_FILES['gallery_new']['tmp_name'][$i], 'error' => $err, 'size' => $_FILES['gallery_new']['size'][$i]];
            $up = handleUpload($f, $UP_GALLERY, 'foto', 1600, true);
            if ($up) $c['gallery'][] = ['src' => 'uploads/gallery/' . $up['src'], 'thumb' => 'uploads/gallery/' . $up['thumb'], 'alt' => ''];
        }
    }
    saveContent($CONTENT, $c);
    $msg = 'Uložené. <a href="../" target="_blank">Pozrieť web →</a>';
    $c = loadContent($CONTENT);
}
if ($action === 'password') {
    checkCsrf();
    $new = (string)($_POST['new_password'] ?? '');
    if (mb_strlen($new) < 10) {
        $msg = 'Heslo musí mať aspoň 10 znakov.';
    } elseif (!password_verify((string)($_POST['current_password'] ?? ''), $config['password_hash'])) {
        $msg = 'Aktuálne heslo nesedí.';
    } else {
        $cfg = "<?php\nreturn [\n    'password_hash' => " . var_export(password_hash($new, PASSWORD_DEFAULT), true) . ",\n];\n";
        file_put_contents($CONFIG, $cfg, LOCK_EX);
        $msg = 'Heslo zmenené.';
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Administrácia – Sunset v Raji</title>
<meta name="robots" content="noindex,nofollow">
<link rel="stylesheet" href="admin.css">
</head>
<body>
<header class="topbar">
  <strong>Sunset v Raji – administrácia</strong>
  <span><a href="../" target="_blank">Zobraziť web</a> · <a href="?logout=1">Odhlásiť</a></span>
</header>
<?php if ($msg): ?><div class="flash"><?= $msg ?></div><?php endif; ?>

<form method="post" enctype="multipart/form-data" class="editor">
<input type="hidden" name="action" value="save">
<input type="hidden" name="csrf" value="<?= h($csrf) ?>">

<nav class="tabs" id="tabs">
  <button type="button" data-tab="zaklad" class="on">Základné</button>
  <button type="button" data-tab="program">Program</button>
  <button type="button" data-tab="lineup">Lineup</button>
  <button type="button" data-tab="galeria">Galéria</button>
  <button type="button" data-tab="miesto">Miesto</button>
  <button type="button" data-tab="nastavenia">Nastavenia</button>
</nav>

<section class="tab on" id="tab-zaklad">
  <h2>Základné texty</h2>
  <label>Titulok webu <input name="site_title" value="<?= h($c['site']['title']) ?>"></label>
  <label>Popis (meta description, zdieľanie) <textarea name="site_description" rows="3"><?= h($c['site']['description']) ?></textarea></label>
  <label>Claim (rukopisný nadpis) <input name="site_claim" value="<?= h($c['site']['claim']) ?>"></label>
  <div class="cols">
    <label>Hero – dátum <input name="hero_date" value="<?= h($c['hero']['date_line']) ?>"></label>
    <label>Hero – miesto <input name="hero_place" value="<?= h($c['hero']['place_line']) ?>"></label>
  </div>
  <label>Hero – podtitulok <input name="hero_sub" value="<?= h($c['hero']['sub_line']) ?>"></label>
  <label>O podujatí – nadpis <input name="about_heading" value="<?= h($c['about']['heading']) ?>"></label>
  <label>O podujatí – text <textarea name="about_text" rows="4"><?= h($c['about']['text']) ?></textarea></label>
  <h2>Informačné karty</h2>
  <div class="cols">
    <label>Dátum <input name="info_date" value="<?= h($c['info']['date']) ?>"></label>
    <label>Čas <input name="info_time" value="<?= h($c['info']['time']) ?>"></label>
    <label>Miesto <input name="info_place" value="<?= h($c['info']['place']) ?>"></label>
    <label>Vstup <input name="info_entry" value="<?= h($c['info']['entry']) ?>"></label>
  </div>
</section>

<section class="tab" id="tab-program">
  <h2>Denný program</h2>
  <div class="rows" data-rows="pday">
    <?php foreach ($c['program_day'] as $it): ?>
    <div class="row3">
      <input name="pday[time][]" placeholder="14:00" value="<?= h($it['time']) ?>">
      <input name="pday[title][]" placeholder="Názov bodu" value="<?= h($it['title']) ?>">
      <input name="pday[desc][]" placeholder="Krátky popis (nepovinné)" value="<?= h($it['desc']) ?>">
      <button type="button" class="del" title="Odstrániť">×</button>
    </div>
    <?php endforeach; ?>
  </div>
  <button type="button" class="add" data-add="pday">+ Pridať bod</button>

  <h2>Večerný program</h2>
  <div class="rows" data-rows="pnight">
    <?php foreach ($c['program_night'] as $it): ?>
    <div class="row3">
      <input name="pnight[time][]" placeholder="20:00" value="<?= h($it['time']) ?>">
      <input name="pnight[title][]" placeholder="Názov bodu / DJ" value="<?= h($it['title']) ?>">
      <input name="pnight[desc][]" placeholder="Krátky popis (nepovinné)" value="<?= h($it['desc']) ?>">
      <button type="button" class="del" title="Odstrániť">×</button>
    </div>
    <?php endforeach; ?>
  </div>
  <button type="button" class="add" data-add="pnight">+ Pridať bod</button>

  <label style="margin-top:18px">Poznámka pod programom <input name="program_note" value="<?= h($c['program_note']) ?>"></label>

  <h2>Atrakcie a aktivity</h2>
  <p class="hint">Fotka je nepovinná – bez fotky sa zobrazí ikona. Odporúčaný formát: na šírku (3:2), min. 900 px.</p>
  <div class="rows" data-rows="act">
    <?php foreach (($c['activities'] ?? []) as $a): ?>
    <div class="rowact">
      <?php if (!empty($a['photo'])): ?><img class="actprev" src="../<?= h($a['photo']) ?>" alt=""><?php else: ?><span class="actprev actempty"><?= h($a['icon'] ?: '✨') ?></span><?php endif; ?>
      <input name="act[icon][]" placeholder="Ikona (emoji)" value="<?= h($a['icon'] ?? '') ?>" class="short">
      <input name="act[title][]" placeholder="Názov atrakcie" value="<?= h($a['title']) ?>">
      <input name="act[desc][]" placeholder="Krátky popis" value="<?= h($a['desc']) ?>">
      <input type="hidden" name="act[photo][]" value="<?= h($a['photo']) ?>">
      <input type="file" name="act_photo[]" accept="image/*">
      <button type="button" class="del" title="Odstrániť">×</button>
    </div>
    <?php endforeach; ?>
  </div>
  <button type="button" class="add" data-add="act">+ Pridať atrakciu</button>
</section>

<section class="tab" id="tab-lineup">
  <h2>Lineup</h2>
  <p class="hint">Fotka je nepovinná – bez fotky sa zobrazí iniciálka. Odporúčaný formát: štvorec, min. 400×400 px.</p>
  <div class="rows" data-rows="lineup">
    <?php foreach ($c['lineup'] as $dj): ?>
    <div class="rowdj">
      <?php if (!empty($dj['photo'])): ?><img class="djprev" src="../<?= h($dj['photo']) ?>" alt=""><?php else: ?><span class="djprev djempty"><?= h(mb_strtoupper(mb_substr($dj['name'],0,1))) ?></span><?php endif; ?>
      <input name="lineup[name][]" placeholder="Meno" value="<?= h($dj['name']) ?>">
      <input name="lineup[meta][]" placeholder="Napr. CZ" value="<?= h($dj['meta']) ?>" class="short">
      <input name="lineup[desc][]" placeholder="Popis / čas vystúpenia" value="<?= h($dj['desc']) ?>">
      <input type="hidden" name="lineup[photo][]" value="<?= h($dj['photo']) ?>">
      <input type="file" name="lineup_photo[]" accept="image/*">
      <button type="button" class="del" title="Odstrániť">×</button>
    </div>
    <?php endforeach; ?>
  </div>
  <button type="button" class="add" data-add="lineup">+ Pridať interpreta</button>
</section>

<section class="tab" id="tab-galeria">
  <h2>Galéria</h2>
  <p class="hint">Fotky sa automaticky zmenšia a zoptimalizujú. Poradie zmeníte šípkami.</p>
  <div class="gal" id="galRows">
    <?php foreach ($c['gallery'] as $g): ?>
    <div class="galrow">
      <img src="../<?= h($g['thumb'] ?: $g['src']) ?>" alt="">
      <input type="hidden" name="g_src[]" value="<?= h($g['src']) ?>">
      <input type="hidden" name="g_thumb[]" value="<?= h($g['thumb']) ?>">
      <input name="g_alt[]" placeholder="Popis fotky (alt)" value="<?= h($g['alt']) ?>">
      <span class="galbtns">
        <button type="button" class="up" title="Posunúť vyššie">↑</button>
        <button type="button" class="down" title="Posunúť nižšie">↓</button>
        <label class="delchk"><input type="checkbox" name="g_del[]" value=""> zmazať</label>
      </span>
    </div>
    <?php endforeach; ?>
  </div>
  <label style="margin-top:16px">Pridať fotky <input type="file" name="gallery_new[]" accept="image/*" multiple></label>
</section>

<section class="tab" id="tab-miesto">
  <h2>Miesto a doprava</h2>
  <label>Popis miesta <textarea name="place_text" rows="3"><?= h($c['place']['text']) ?></textarea></label>
  <label>Parkovanie <textarea name="place_parking" rows="3"><?= h($c['place']['parking']) ?></textarea></label>
  <label>Príchod <textarea name="place_arrival" rows="3"><?= h($c['place']['arrival']) ?></textarea></label>
  <label>Odkaz na Google Maps <input name="place_maps_url" value="<?= h($c['place']['maps_url']) ?>"></label>
  <label>Hľadaný výraz pre mapu na webe <input name="place_maps_q" value="<?= h($c['place']['maps_embed_q']) ?>"></label>
</section>

<section class="tab" id="tab-nastavenia">
  <h2>Odkazy a meranie</h2>
  <div class="cols">
    <label>Kontaktný e-mail (formulár + web) <input name="set_email" value="<?= h($c['site']['contact_email'] ?? '') ?>" placeholder="info@sunsetvraji.sk"></label>
    <label>Support e-mail (len informačný) <input name="set_support" value="<?= h($c['site']['support_email'] ?? '') ?>" placeholder="support@sunsetvraji.sk"></label>
  </div>
  <label>Facebook udalosť (URL) <input name="set_fb" value="<?= h($c['site']['facebook_event']) ?>" placeholder="https://www.facebook.com/events/..."></label>
  <label>Instagram (URL) <input name="set_ig" value="<?= h($c['site']['instagram']) ?>" placeholder="https://www.instagram.com/..."></label>
  <label>Meta Pixel ID <input name="set_pixel" value="<?= h($c['site']['meta_pixel_id']) ?>" placeholder="Len číslo, napr. 1234567890"></label>
  <label>Google Analytics ID <input name="set_ga" value="<?= h($c['site']['ga_id']) ?>" placeholder="G-XXXXXXX"></label>
  <p class="hint">Meranie sa načíta až po súhlase návštevníka s cookies.</p>
</section>

<div class="savebar"><button type="submit" class="save">Uložiť zmeny</button></div>
</form>

<form method="post" class="editor pass" id="tab-heslo">
  <h2>Zmena hesla</h2>
  <input type="hidden" name="action" value="password">
  <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
  <div class="cols">
    <label>Aktuálne heslo <input type="password" name="current_password" required></label>
    <label>Nové heslo (min. 10 znakov) <input type="password" name="new_password" minlength="10" required></label>
  </div>
  <button type="submit" class="save alt">Zmeniť heslo</button>
</form>

<script src="admin.js"></script>
</body>
</html>
