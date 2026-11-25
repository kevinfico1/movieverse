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
        $query = $pdo->prepare("
            SELECT m.*, GROUP_CONCAT(c.name SEPARATOR ',') AS genre
            FROM movies m
            LEFT JOIN movie_categories mc ON mc.movie_id = m.id
            LEFT JOIN categories c ON c.id = mc.category_id
            WHERE m.id > ? AND m.status = 'published'
            GROUP BY m.id
            ORDER BY m.id
        ");
        $query->execute([ID_FILM_AWAL]);
    } catch (PDOException $error) {
        return $hasil;
    }

    foreach ($query as $film) {
        $hasil[$film['id']] = [
            'judul'     => $film['title'],
            'deskripsi' => $film['synopsis'],
            'poster'    => cari_poster($film['id']),
            'rating'    => $film['rating'],
            'tahun'     => (int) $film['release_year'],
            'eps'       => 1,
            'warna'     => (strlen($film['title']) * 47) % 360,
            'genre'     => array_values(array_filter(explode(',', (string) $film['genre']))),
        ];
    }

    return $hasil;
}
