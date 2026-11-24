<?php
require_once __DIR__ . '/../../repositories/film_admin_repository.php';

header('Content-Type: application/json; charset=utf-8');

function balas($kode, $data) {
    http_response_code($kode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    balas(405, ['ok' => false, 'pesan' => 'Metode tidak diizinkan']);
}
if (($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') !== 'fetch') {
    balas(400, ['ok' => false, 'pesan' => 'Permintaan tidak valid']);
}

$masuk = json_decode((string) file_get_contents('php://input'), true);
if (!is_array($masuk) || !isset($masuk['items']) || !is_array($masuk['items'])) {
    balas(400, ['ok' => false, 'pesan' => 'Data tidak valid']);
}
if (count($masuk['items']) > 200) {
    balas(400, ['ok' => false, 'pesan' => 'Terlalu banyak data']);
}

$peta = [];
$nid_maks = FILM_ADMIN_NID_AWAL;
$lama = muat_state_admin();
if ($lama !== null) {
    foreach ($lama['items'] as $it) {
        if (!empty($it['nid']) && isset($it['id'])) {
            $peta[$it['id']] = (int) $it['nid'];
            $nid_maks = max($nid_maks, (int) $it['nid']);
        }
    }
}

$folder_upload = __DIR__ . '/../../asset/uploads';
if (!is_dir($folder_upload)) mkdir($folder_upload, 0755, true);
$ekstensi = ['jpeg' => 'jpg', 'png' => 'png', 'webp' => 'webp'];

$bersih = [];
foreach ($masuk['items'] as $it) {
    if (!is_array($it)) continue;

    $id    = preg_replace('/[^A-Za-z0-9_-]/', '', (string) ($it['id'] ?? ''));
    $judul = trim(mb_substr((string) ($it['judul'] ?? ''), 0, 120));
    if ($id === '' || $judul === '') continue;

    $genre = [];
    foreach ((array) ($it['genre'] ?? []) as $g) {
        $g = trim(mb_substr((string) $g, 0, 30));
        if ($g !== '' && count($genre) < 4) $genre[] = $g;
    }

    $tanggal = (string) ($it['tanggal'] ?? '');
    if (!preg_match('#^\d{1,2}/\d{1,2}/\d{4}$#', $tanggal)) $tanggal = date('d/m/Y');

    $poster = (string) ($it['poster'] ?? '');
    if (strpos($poster, 'data:image/') === 0 && ($pos = strpos($poster, ';base64,')) !== false) {
        $tipe  = substr($poster, 11, $pos - 11);
        $bytes = base64_decode(substr($poster, $pos + 8), true);
        if (isset($ekstensi[$tipe]) && $bytes !== false && strlen($bytes) <= 3000000 && @getimagesizefromstring($bytes) !== false) {
            $nama = 'film_' . $id . '_' . substr(md5($bytes), 0, 8) . '.' . $ekstensi[$tipe];
            file_put_contents($folder_upload . '/' . $nama, $bytes);
            $poster = '/asset/uploads/' . $nama;
        } else {
            $poster = '';
        }
    } elseif (!preg_match('#^/asset/uploads/[A-Za-z0-9_.-]+$#', $poster)
        && !(preg_match('#^https?://#i', $poster) && strlen($poster) <= 1000)) {
        $poster = '';
    }

    $baris = [
        'id'        => $id,
        'judul'     => $judul,
        'genre'     => $genre,
        'status'    => (($it['status'] ?? '') === 'Draft') ? 'Draft' : 'Publish',
        'tanggal'   => $tanggal,
        'poster'    => $poster,
        'deskripsi' => trim(mb_substr((string) ($it['deskripsi'] ?? ''), 0, 2000)),
        'admin'     => !empty($it['admin']),
    ];
    if ($baris['admin']) {
        $baris['nid'] = $peta[$id] ?? ++$nid_maks;
    }
    $bersih[] = $baris;
}

$genres = [];
foreach ((array) ($masuk['genres'] ?? []) as $g) {
    $g = trim(mb_substr((string) $g, 0, 30));
    if ($g === '' || count($genres) >= 60) continue;
    foreach ($genres as $x) { if (mb_strtolower($x) === mb_strtolower($g)) continue 2; }
    $genres[] = $g;
}

$folder_data = dirname(FILM_ADMIN_FILE);
if (!is_dir($folder_data)) mkdir($folder_data, 0755, true);

$json = json_encode(['items' => $bersih, 'genres' => $genres], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
if (file_put_contents(FILM_ADMIN_FILE, $json, LOCK_EX) === false) {
    balas(500, ['ok' => false, 'pesan' => 'Folder data/ tidak bisa ditulis']);
}

balas(200, ['ok' => true, 'items' => $bersih, 'genres' => $genres]);
