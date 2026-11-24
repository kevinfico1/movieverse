<?php


require_once __DIR__ . '/detail_film_repository.php';

function ambil_genre_list() {
    return 'Action';
}

function ambil_banner_list() {
    return [
        'judul'     => 'Reacher',
        'deskripsi' => 'Jack Reacher, mantan polisi militer, singgah di sebuah kota kecil dan terseret ke dalam konspirasi yang tidak bisa ia abaikan.',
        'gambar'    => 'https://i.pinimg.com/1200x/f1/68/cd/f168cdd894fb1e1f51da9c1e8840f6b5.jpg',
    ];
}

function ambil_daftar_film_list() {
    $id_tampil = [5, 6, 7, 8, 9, 10];

    $hasil = [];
    foreach ($id_tampil as $id) {
        $film = ambil_film_by_id($id);
        if ($film !== null) {
            $hasil[] = $film;
        }
    }

    foreach (ambil_film_admin() as $id => $film) {
        $hasil[] = ['id' => $id] + $film;
    }
    return $hasil;
}