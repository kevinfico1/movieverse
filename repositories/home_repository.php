<?php

if (!function_exists('e')) {
    function e($teks) {
        return htmlspecialchars($teks ?? '', ENT_QUOTES, 'UTF-8');
    }
}

function ambil_hero_home() {
    return [
        'studio'    => 'A FILM BY CHRISTOPHER NOLAN',
        'judul'     => 'THE ODYSSEY',
        'rating'    => '4.9',
        'tahun'     => '2026',
        'durasi'    => '2h 45m',
        'genre'     => 'Aksi, Petualangan',
        'deskripsi' => 'Perjalanan epik melintasi kegelapan dan pertempuran besar dalam mahakarya terbaru arahan Christopher Nolan.',
        'id_detail' => 22,
    ];
}

function ambil_trending_home() {
    return [
        ['id' => 2, 'judul' => 'Lanterns',          'rating' => '8.3', 'tahun' => '2026', 'poster' => 'https://i.pinimg.com/736x/c2/77/fb/c277fb23118b1431d2bb75e13ffceed9.jpg'],
        ['id' => 14, 'judul' => 'The Mentalist',     'rating' => '8.2', 'tahun' => '2026', 'poster' => 'https://i.pinimg.com/1200x/00/2c/15/002c158dd2b74d09ae2f7e6d2fb9cf5b.jpg'],
        ['id' => 3, 'judul' => 'Daredevil',         'rating' => '7.3', 'tahun' => '2026', 'poster' => 'https://i.pinimg.com/736x/11/2f/48/112f48d07127371768708c60ed4995b4.jpg'],
        ['id' => 19, 'judul' => 'Avengers Doomsday', 'rating' => '8.5', 'tahun' => '2026', 'poster' => 'https://i.pinimg.com/736x/18/20/f9/1820f96840b28134f8b78f5475b586e1.jpg'],
        ['id' => 20, 'judul' => 'Dexter',            'rating' => '8.6', 'tahun' => '2026', 'poster' => 'https://i.pinimg.com/736x/bd/68/e8/bd68e8f4c81daac424e4f31b1dc392f3.jpg'],
    ];
}

function ambil_series_home() {
    return [
        ['id' => 1, 'judul' => 'Vision Quest', 'rating' => '8.3', 'tahun' => '2026', 'poster' => 'https://i.pinimg.com/736x/9d/57/7e/9d577e728888b03995b0010d48204be3.jpg'],
        ['id' => 21, 'judul' => 'Breaking Bad', 'rating' => '9.5', 'tahun' => '2026', 'poster' => 'https://i.pinimg.com/1200x/b5/da/81/b5da816660ec3f7c2394e26b2671c9f3.jpg'],
        ['id' => 2, 'judul' => 'Lanterns',     'rating' => '8.3', 'tahun' => '2026', 'poster' => 'https://i.pinimg.com/736x/c2/77/fb/c277fb23118b1431d2bb75e13ffceed9.jpg'],
        ['id' => 4, 'judul' => 'Spider Noir',  'rating' => '8.3', 'tahun' => '2026', 'poster' => 'https://i.pinimg.com/736x/18/20/f9/1820f96840b28134f8b78f5475b586e1.jpg'],
        ['id' => 3, 'judul' => 'Daredevil',    'rating' => '7.3', 'tahun' => '2026', 'poster' => 'https://i.pinimg.com/736x/11/2f/48/112f48d07127371768708c60ed4995b4.jpg'],
    ];
}