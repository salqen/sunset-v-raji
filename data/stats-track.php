<?php
// Jednoduché anonymné počítadlo návštevnosti (bez cookies, GDPR-friendly).
// Ukladá len denné súčty a pre dnešok krátke anonymné hashe na rozlíšenie unikátov.
(function (): void {
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    if ($ua === '' || preg_match('/bot|crawl|spider|slurp|facebookexternalhit|preview|lighthouse|pingdom|monitor/i', $ua)) return;
    $file = __DIR__ . '/stats.json';
    $today = date('Y-m-d');
    $fh = @fopen($file, 'c+');
    if (!$fh || !flock($fh, LOCK_EX)) { if ($fh) fclose($fh); return; }
    $raw = stream_get_contents($fh);
    $d = json_decode((string)$raw, true);
    if (!is_array($d)) $d = ['days' => [], 'today' => '', 'hashes' => []];
    if (($d['today'] ?? '') !== $today) { $d['today'] = $today; $d['hashes'] = []; }
    if (!isset($d['days'][$today])) $d['days'][$today] = ['v' => 0, 'u' => 0];
    $d['days'][$today]['v']++;
    $hash = substr(hash('sha256', $today . '|' . ($_SERVER['REMOTE_ADDR'] ?? '') . '|' . $ua), 0, 12);
    if (!in_array($hash, $d['hashes'], true)) {
        $d['hashes'][] = $hash;
        $d['days'][$today]['u']++;
    }
    // drž max 400 dní histórie
    if (count($d['days']) > 400) { ksort($d['days']); $d['days'] = array_slice($d['days'], -400, null, true); }
    ftruncate($fh, 0); rewind($fh);
    fwrite($fh, json_encode($d, JSON_UNESCAPED_UNICODE));
    flock($fh, LOCK_UN); fclose($fh);
})();
