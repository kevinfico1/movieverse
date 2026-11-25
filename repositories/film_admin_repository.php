<?php

function ambil_film_admin() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $hasil = [];
    $daftar = $_SESSION['film_admin'] ?? [];

    foreach ($daftar as $film) {
        if ($film['status'] !== 'Publish') {
            continue;
        }

        $hasil[$film['id']] = [
            'judul'     => $film['judul'],
            'deskripsi' => $film['deskripsi'],
            'poster'    => $film['poster'],
            'rating'    => '-',
            'tahun'     => (int) substr($film['tanggal'], -4),
            'eps'       => 1,
            'warna'     => (strlen($film['judul']) * 47) % 360,
            'genre'     => $film['genre'],
        ];
    }

    return $hasil;
}
