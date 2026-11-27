<?php

require_once __DIR__ . '/detail_film_repository.php';

$genre = [
    ['action',    'Action',    'fa-solid fa-hand-fist',                'linear-gradient(120deg,#0b1f4d,#274690,#7a8aa8)', 'https://i.pinimg.com/1200x/18/8f/85/188f85b98bc4415f9d0d2c29aecc986d.jpg', 'center 15%'],
    ['adventure', 'Adventure', 'fa-regular fa-compass',                'linear-gradient(180deg,#e3a15a,#c4622d,#5a3a2a)', 'https://i.pinimg.com/736x/7b/c2/e5/7bc2e55176c3763545d869cc1d33ae15.jpg', 'center 30%'],
    ['crime',     'Crime',     'fa-solid fa-link',                     'linear-gradient(120deg,#d9d9d9,#8a8a8a,#3a3a3a)', 'https://i.pinimg.com/1200x/b5/da/81/b5da816660ec3f7c2394e26b2671c9f3.jpg', 'center 20%'],
    ['comedy',    'Comedy',    'fa-regular fa-face-grin-squint-tears', 'linear-gradient(120deg,#5b4a47,#a07a68,#2f3a4a)', 'https://i.pinimg.com/736x/48/ae/09/48ae0932ec9fd9cb5a69f5f52ab182db.jpg', 'center 20%'],
    ['mystery',   'Mystery',   'fa-solid fa-user-secret',              'linear-gradient(90deg,#ffffff,#d8d870,#222222,#e0a030)', 'https://i.pinimg.com/1200x/3a/b7/08/3ab70800ec4755b3cd92382c41544c4f.jpg', 'center 25%'],
    ['thriller',  'Thriller',  'fa-solid fa-crosshairs',               'linear-gradient(120deg,#d8cfc0,#b9a98f,#8a2a2a)', 'https://i.pinimg.com/1200x/10/dd/d4/10ddd4b1754ece422f20b54cdba3174d.jpg', 'center 20%'],
    ['sci-fi',        'Sci-Fi',        'fa-solid fa-rocket',         'linear-gradient(120deg,#0b1f4d,#274690,#7a8aa8)', 'https://i.pinimg.com/736x/9d/57/7e/9d577e728888b03995b0010d48204be3.jpg', 'center 20%'],
    ['drama',         'Drama',         'fa-solid fa-masks-theater',  'linear-gradient(120deg,#5b4a47,#a07a68,#2f3a4a)', 'https://i.pinimg.com/736x/b9/10/46/b910468afe3d7cdc8229080b11ca8ee1.jpg', 'center 20%'],
    ['fantasy',       'Fantasy',       'fa-solid fa-wand-sparkles',  'linear-gradient(120deg,#38305f,#7566b5,#b2a8e8)', 'https://i.pinimg.com/736x/80/3d/b4/803db4d3fb0b7de9bf8a6afebbd49db4.jpg', 'center 20%'],
    ['psychological', 'Psychological', 'fa-solid fa-brain',          'linear-gradient(120deg,#222222,#555555,#999999)', 'https://i.pinimg.com/736x/bd/68/e8/bd68e8f4c81daac424e4f31b1dc392f3.jpg', 'center 20%'],
    ['supernatural',  'Supernatural',  'fa-solid fa-ghost',          'linear-gradient(120deg,#1a1a2e,#3a3a6e,#6a6aae)', 'https://i.pinimg.com/736x/de/11/d9/de11d91843c02c300b52cf5a9345b9d9.jpg', 'center 20%'],
];

function gambar_genre_otomatis($nama_genre) {
    $semua_film = ambil_semua_film();
    $nama_kecil = strtolower($nama_genre);

    foreach ($semua_film as $film) {
        if (empty($film['poster']) || empty($film['genre'])) {
            continue;
        }
        if (in_array($nama_kecil, array_map('strtolower', $film['genre']), true)) {
            return $film['poster'];
        }
    }

    $kumpulan = [];
    foreach ($semua_film as $film) {
        if (!empty($film['poster'])) {
            $kumpulan[] = $film['poster'];
        }
    }
    if (!$kumpulan) {
        return '';
    }
    return $kumpulan[crc32($nama_kecil) % count($kumpulan)];
}