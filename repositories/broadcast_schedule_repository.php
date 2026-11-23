<?php

require_once __DIR__ . '/detail_film_repository.php';

function ambil_jadwal_judul() {
    $film_harian = [
        'Ted', 'Loki (Season 2)', 'Moonknight', 'The Mentalist',
        'Wednesday', 'Stranger Things', 'Severance', 'The Rookie',
    ];

    return [
        'Sunday'    => $film_harian,
        'Monday'    => $film_harian,
        'Tuesday'   => $film_harian,
        'Wednesday' => $film_harian,
        'Thursday'  => $film_harian,
        'Friday'    => $film_harian,
        'Saturday'  => $film_harian,
    ];
}

function ambil_jadwal() {
    $jadwal = [];
    foreach (ambil_jadwal_judul() as $hari => $daftar_judul) {
        $jadwal[$hari] = [];
        foreach ($daftar_judul as $judul) {
            $film = ambil_film_by_judul($judul);
            if ($film !== null) {
                $film['warna'] = $film['warna'] ?? 0;
                $jadwal[$hari][] = $film;
            }
        }
    }
    return $jadwal;
}