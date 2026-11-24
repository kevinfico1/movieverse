<?php

const FILM_ADMIN_FILE = __DIR__ . '/../data/admin_state.json';
const FILM_ADMIN_NID_AWAL = 1000;

function muat_state_admin() {
    if (!is_file(FILM_ADMIN_FILE)) return null;

    $data = json_decode((string) file_get_contents(FILM_ADMIN_FILE), true);
    if (!is_array($data) || !isset($data['items']) || !is_array($data['items'])) return null;
    if (!isset($data['genres']) || !is_array($data['genres'])) $data['genres'] = [];
    return $data;
}

function ambil_film_admin() {
    $state = muat_state_admin();
    $hasil = [];
    if ($state === null) return $hasil;

    foreach ($state['items'] as $it) {
        if (empty($it['admin']) || empty($it['nid'])) continue;
        if (($it['status'] ?? '') !== 'Publish') continue;

        $tahun = (int) substr((string) ($it['tanggal'] ?? ''), -4);
        $judul = (string) ($it['judul'] ?? '');

        $hasil[(int) $it['nid']] = [
            'judul'     => $judul,
            'deskripsi' => (string) ($it['deskripsi'] ?? ''),
            'poster'    => (string) ($it['poster'] ?? ''),
            'rating'    => '-',
            'tahun'     => $tahun > 0 ? $tahun : (int) date('Y'),
            'eps'       => 1,
            'warna'     => crc32($judul) % 360,
            'genre'     => array_values((array) ($it['genre'] ?? [])),
        ];
    }
    return $hasil;
}
