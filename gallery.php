<?php
// AJAX endpoint – ďalšie fotky galérie
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
$c = json_decode((string)file_get_contents(__DIR__ . '/data/content.json'), true);
$gallery = is_array($c) ? ($c['gallery'] ?? []) : [];
$offset = max(0, (int)($_GET['offset'] ?? 0));
$limit = 8;
$items = array_slice($gallery, $offset, $limit);
$out = array_map(static fn(array $g): array => [
    'src'   => (string)($g['src'] ?? ''),
    'thumb' => (string)($g['thumb'] ?? '') !== '' ? (string)$g['thumb'] : (string)($g['src'] ?? ''),
    'alt'   => (string)($g['alt'] ?? ''),
], $items);
echo json_encode([
    'items'   => $out,
    'hasMore' => count($gallery) > $offset + $limit,
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
