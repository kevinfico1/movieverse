<?php
require_once __DIR__ . '/../config/database.php';

const ID_FILM_AWAL = 22;

function cari_poster($id) {
    $file = glob(__DIR__ . '/../asset/uploads/film_' . (int)$id . '.*');

    if ($file) {
        return '/asset/uploads/' . basename($file[0]);
    }
    return '';
}

function ambil_film_admin() {
    global $pdo;

    $hasil = [];

    try {
        $query = $pdo->prepare("SELECT * FROM movies WHERE id > ? AND status = 'published' ORDER BY id");
        $query->execute([ID_FILM_AWAL]);
        $daftar_film = $query->fetchAll();
    } catch (PDOException $error) {
        return $hasil;
    }

    foreach ($daftar_film as $film) {
        $query = $pdo->prepare('SELECT c.name FROM categories c JOIN movie_categories mc ON mc.category_id = c.id WHERE mc.movie_id = ? ORDER BY c.name');
        $query->execute([$film['id']]);

        $hasil[$film['id']] = [
            'judul'     => $film['title'],
            'deskripsi' => $film['synopsis'],
            'poster'    => cari_poster($film['id']),
            'rating'    => $film['rating'],
            'tahun'     => (int) $film['release_year'],
            'eps'       => 1,
            'warna'     => (strlen($film['title']) * 47) % 360,
            'genre'     => $query->fetchAll(PDO::FETCH_COLUMN),
        ];
    }

    return $hasil;
}
