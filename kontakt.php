<?php
// Kontaktný formulár – odoslanie na info@sunsetvraji.sk
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');

function fail(string $msg, int $code = 400): never {
    http_response_code($code);
    echo json_encode(['ok' => false, 'error' => $msg], JSON_UNESCAPED_UNICODE);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') fail('Neplatná požiadavka.', 405);

$c = json_decode((string)file_get_contents(__DIR__ . '/data/content.json'), true);
$to = is_array($c) ? (string)($c['site']['contact_email'] ?? '') : '';
if ($to === '' || !filter_var($to, FILTER_VALIDATE_EMAIL)) fail('Formulár nie je nakonfigurovaný.', 500);

// antispam: honeypot + časová kontrola
if (trim((string)($_POST['website'] ?? '')) !== '') fail('Správu sa nepodarilo odoslať.');
$ts = (int)($_POST['ts'] ?? 0);
if ($ts > 0 && (time() - $ts) < 3) fail('Formulár bol odoslaný príliš rýchlo, skúste znova.');

$name = trim((string)($_POST['name'] ?? ''));
$email = trim((string)($_POST['email'] ?? ''));
$message = trim((string)($_POST['message'] ?? ''));

if ($name === '' || mb_strlen($name) > 120) fail('Zadajte svoje meno.');
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 200) fail('Zadajte platný e-mail.');
if ($message === '' || mb_strlen($message) > 5000) fail('Zadajte správu (max. 5000 znakov).');
// hlavičkové injekcie
if (preg_match('/[\r\n]/', $name . $email)) fail('Neplatný vstup.');

$subject = '=?UTF-8?B?' . base64_encode('Správa z webu sunsetvraji.sk – ' . $name) . '?=';
$body = "Meno: $name\nE-mail: $email\nČas: " . date('d.m.Y H:i:s') . "\nIP: " . ($_SERVER['REMOTE_ADDR'] ?? '-') . "\n\nSpráva:\n$message\n";
$headers = implode("\r\n", [
    'From: Sunset v Raji <no-reply@sunsetvraji.sk>',
    'Reply-To: ' . $email,
    'MIME-Version: 1.0',
    'Content-Type: text/plain; charset=UTF-8',
    'Content-Transfer-Encoding: 8bit',
    'X-Mailer: sunsetvraji.sk',
]);

if (!@mail($to, $subject, $body, $headers)) {
    fail('Správu sa nepodarilo odoslať. Napíšte nám prosím priamo na ' . $to . '.', 500);
}
echo json_encode(['ok' => true], JSON_UNESCAPED_UNICODE);
