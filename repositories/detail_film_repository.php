<?php

if (!function_exists('e')) {
    function e($teks) {
        return htmlspecialchars($teks ?? '', ENT_QUOTES, 'UTF-8');
    }
}

// Ambil SEMUA film (kuncinya adalah id film)
function ambil_semua_film() {
    return [

        1 => [
            'judul'     => 'Vision Quest',
            'rating'    => '8.3',
            'deskripsi' => 'Serial ini akan berfokus pada karakter White Vision (Paul Bettany) yang diperkenalkan dalam WandaVision. Plotnya mengikuti perjalanan sintozoid tersebut saat ia berusaha memulihkan ingatannya yang hilang, mengeksplorasi kembali identitas dan keberadaannya, serta mencari tujuan baru dalam hidupnya setelah kehilangan keterikatan emosionalnya di Westview.',
            'poster'    => 'https://i.pinimg.com/736x/9d/57/7e/9d577e728888b03995b0010d48204be3.jpg',
        ],
        2 => [
            'judul'  => 'Lanterns',
            'rating' => '8.3',
            'poster' => 'https://i.pinimg.com/736x/c2/77/fb/c277fb23118b1431d2bb75e13ffceed9.jpg',
        ],
        3 => [
            'judul'  => 'Daredevil',
            'rating' => '7.3',
            'poster' => 'https://i.pinimg.com/736x/11/2f/48/112f48d07127371768708c60ed4995b4.jpg',
        ],
        4 => [
            'judul'  => 'Spider Noir',
            'rating' => '8.3',
            'poster' => 'https://i.pinimg.com/736x/18/20/f9/1820f96840b28134f8b78f5475b586e1.jpg',
        ],

        5 => [
            'judul'  => 'The Boys',
            'warna'  => 215,
            'poster' => 'https://i.pinimg.com/1200x/5d/50/c9/5d50c9ae08b4eedaa598db9033383a5a.jpg',
            'rating' => '8.7',
            'tahun'  => 2026,
            'eps'    => 3,
            'genre'  => ['Action', 'Crime', 'Drama', 'Thriller'],
        ],
        6 => [
            'judul'  => 'Peace Maker',
            'warna'  => 8,
            'poster' => 'https://i.pinimg.com/736x/3a/41/ed/3a41ed709c956092abed6851f86dbbc6.jpg',
            'rating' => '8.3',
            'tahun'  => 2026,
            'eps'    => 3,
            'genre'  => ['Action', 'Crime', 'Drama', 'Thriller'],
        ],
        7 => [
            'judul'  => 'The Punisher',
            'warna'  => 0,
            'poster' => 'https://i.pinimg.com/1200x/18/8f/85/188f85b98bc4415f9d0d2c29aecc986d.jpg',
            'rating' => '8.1',
            'tahun'  => 2026,
            'eps'    => 3,
            'genre'  => ['Action', 'Crime', 'Drama', 'Thriller'],
        ],
        8 => [
            'judul'  => 'The Old Man',
            'warna'  => 35,
            'poster' => 'https://i.pinimg.com/1200x/db/98/b5/db98b5ecd72c5e1e6708ca58ac864a03.jpg',
            'rating' => '8.0',
            'tahun'  => 2026,
            'eps'    => 3,
            'genre'  => ['Action', 'Crime', 'Drama', 'Thriller'],
        ],
        9 => [
            'judul'  => 'The Penguin',
            'warna'  => 350,
            'poster' => 'https://i.pinimg.com/736x/11/47/c3/1147c37b801978ccb665272ff6e64c35.jpg',
            'rating' => '8.6',
            'tahun'  => 2026,
            'eps'    => 3,
            'genre'  => ['Action', 'Crime', 'Drama', 'Thriller'],
        ],
        10 => [
            'judul'  => 'S.W.A.T.',
            'warna'  => 28,
            'poster' => 'https://i.pinimg.com/1200x/fe/4c/40/fe4c40761c7b086a873dd38fe8759c99.jpg',
            'rating' => '6.8',
            'tahun'  => 2026,
            'eps'    => 3,
            'genre'  => ['Action', 'Crime', 'Drama', 'Thriller'],
        ],

        // ----- Film untuk halaman Broadcast Schedule -----
        11 => [
            'judul'  => 'Ted',
            'warna'  => 135,
            'poster' => 'https://i.pinimg.com/736x/48/ae/09/48ae0932ec9fd9cb5a69f5f52ab182db.jpg',
        ],
        12 => [
            'judul'  => 'Loki (Season 2)',
            'warna'  => 110,
            'poster' => 'https://i.pinimg.com/736x/80/3d/b4/803db4d3fb0b7de9bf8a6afebbd49db4.jpg',
        ],
        13 => [
            'judul'  => 'Moonknight',
            'warna'  => 220,
            'poster' => 'https://i.pinimg.com/736x/7b/c2/e5/7bc2e55176c3763545d869cc1d33ae15.jpg',
        ],
        14 => [
            'judul'  => 'The Mentalist',
            'warna'  => 20,
            'rating' => '8.2',
            'poster' => 'https://i.pinimg.com/1200x/3a/b7/08/3ab70800ec4755b3cd92382c41544c4f.jpg',
        ],
        15 => [
            'judul'  => 'Wednesday',
            'warna'  => 265,
            'poster' => 'https://i.pinimg.com/736x/92/bc/09/92bc090faff90be339a435fc322ea511.jpg',
        ],
        16 => [
            'judul'  => 'Stranger Things',
            'warna'  => 345,
            'poster' => 'https://i.pinimg.com/736x/de/11/d9/de11d91843c02c300b52cf5a9345b9d9.jpg',
        ],
        17 => [
            'judul'  => 'Severance',
            'warna'  => 200,
            'poster' => 'https://i.pinimg.com/1200x/10/dd/d4/10ddd4b1754ece422f20b54cdba3174d.jpg',
        ],
        18 => [
            'judul'  => 'The Rookie',
            'warna'  => 190,
            'poster' => 'https://i.pinimg.com/736x/b9/10/46/b910468afe3d7cdc8229080b11ca8ee1.jpg',
        ],
        19 => [
            'judul'  => 'Avengers Doomsday',
            'warna'  => 10,
            'poster' => 'https://i.pinimg.com/736x/18/20/f9/1820f96840b28134f8b78f5475b586e1.jpg',
            'rating' => '8.5',
        ],
        20 => [
            'judul'  => 'Dexter',
            'warna'  => 0,
            'poster' => 'https://i.pinimg.com/736x/bd/68/e8/bd68e8f4c81daac424e4f31b1dc392f3.jpg',
            'rating' => '8.6',
        ],
        21 => [
            'judul'  => 'Breaking Bad',
            'warna'  => 120,
            'poster' => 'https://i.pinimg.com/1200x/b5/da/81/b5da816660ec3f7c2394e26b2671c9f3.jpg',
            'rating' => '9.5',
        ],
        22 => [
            'judul'     => 'THE ODYSSEY',
            'warna'     => 210,
            'poster'    => '/asset/photos/hero1.jpeg',
            'rating'    => '4.9',
            'deskripsi' => 'Perjalanan epik melintasi kegelapan dan pertempuran besar dalam mahakarya terbaru arahan Christopher Nolan.',
        ],

    ];
}

function ambil_film_by_id($id) {
    $semua = ambil_semua_film();
    $id = (int)$id;
    if (!isset($semua[$id])) return null;

    $film = ['id' => $id] + $semua[$id];
    if (empty($film['deskripsi'])) {
        $film['deskripsi'] = 'Deskripsi belum tersedia.';
    }
    return $film;
}

function ambil_film_by_judul($judul) {
    foreach (ambil_semua_film() as $id => $film) {
        if ($film['judul'] === $judul) {
            return ['id' => $id] + $film;
        }
    }
    return null;
}

function ambil_episode() {
    return ['No Strings', 'Theseus', 'Reboot'];
}

function ambil_serupa() {
    $hasil = [];
    foreach ([2, 3, 4] as $id) {
        $film = ambil_film_by_id($id);
        if ($film !== null) {
            $hasil[] = [
                'judul'  => $film['judul'],
                'rating' => $film['rating'],
                'poster' => $film['poster'],
            ];
        }
    }
    return $hasil;
}

function link_detail($id) {
    return '/pages/movies/detail_film.php?id=' . (int)$id;
}