# Planarcadia (MovieVerse)

Planarcadia adalah website film dan series buatan kelompok kami. Website ini dibuat memakai PHP dan MySQL. Di dalamnya kita bisa melihat daftar film, mencari film, melihat jadwal tayang, dan membaca detail film. Ada juga sistem "Key" yang bisa dikumpulkan dari dua pet bernama Echo dan Aha. Admin bisa menambah dan mengatur film lewat halaman dashboard.

Nama repository kami MovieVerse, tapi nama yang muncul di website adalah Planarcadia.

## Deskripsi Aplikasi

Aplikasi ini kami buat untuk belajar membuat website yang bisa menyimpan data di database. Kami belajar membuat login dan register, membedakan akun member dan admin, serta membuat fitur tambah, hapus, dan ubah data.

Yang membuat website ini berbeda adalah sistem Key. Tombol Watch dan daftar episode di halaman detail film dikunci. Pengguna bisa mengumpulkan key dengan mengambil hadiah dari pet.

## Fitur Utama

Fitur untuk pengguna:

- Register dan login. Password disimpan dalam bentuk hash supaya lebih aman.
- Halaman Home. Isinya banner film utama, daftar Trending Now, dan daftar Series.
- Daftar Film. Ada poster, rating, genre, dan tahun. Ada juga kolom pencarian untuk mencari judul film.
- Detail Film. Isinya poster, rating, sinopsis, daftar episode, film serupa, dan jumlah key.
- Broadcast Schedule. Ini jadwal tayang film dari hari Senin sampai Minggu.
- Halaman Genre. Isinya kartu genre film seperti Action, Adventure, Crime, Comedy, Mystery, dan Thriller.
- Sistem Key dan Pet. Pengguna bisa mengambil hadiah dari pet Echo atau Aha. Echo memberi 1 sampai 5 key. Aha punya peluang 20 persen untuk memberi 1 key. Key paling banyak adalah 5.
- Logout.

Fitur untuk admin:

- Melihat statistik, yaitu jumlah series, user, key, dan pet.
- Menambah film baru lengkap dengan judul, tanggal, genre, status, deskripsi, dan poster.
- Mengubah status film menjadi Publish atau Draft.
- Menghapus film.
- Menambah genre baru.
- Halaman admin hanya bisa dibuka oleh akun yang role-nya admin.

## Teknologi yang Digunakan

- PHP 8 (tanpa framework)
- MySQL atau MariaDB, dihubungkan memakai PDO
- HTML, CSS, dan JavaScript
- Font Awesome untuk ikon
- Google Fonts untuk jenis huruf
- Laragon atau PHP built-in server untuk menjalankan website

## Arsitektur Aplikasi

Kode kami bagi menjadi beberapa folder supaya rapi dan mudah dicari.

- Folder pages dan file index.php berisi halaman-halaman website. Di sini juga ada pengecekan login dan pengecekan input dari pengguna.
- Folder components berisi bagian yang dipakai di banyak halaman, yaitu topbar dan footer.
- Folder repositories berisi fungsi untuk mengambil data film, jadwal, dan genre. Jadi file halaman tidak perlu menulis semua pengambilan data sendiri.
- Folder config berisi file koneksi ke database.
- Folder asset berisi gambar. Folder style berisi file CSS. Folder script berisi file JavaScript.
- Folder database berisi file SQL.

Cara kerjanya kira-kira begini. Pengguna membuka sebuah halaman. Halaman itu memanggil fungsi dari folder repositories. Fungsi itu mengambil data dari database lewat file koneksi di folder config. Setelah itu, data ditampilkan di halaman bersama topbar dan footer.

Cara kerja login: pengguna mengisi email dan password. Password dicek memakai fungsi password_verify. Kalau benar, data pengguna disimpan di session. Halaman lain akan mengecek session itu. Halaman dashboard juga mengecek apakah role pengguna adalah admin.

Database kami bernama movieverse dan punya 5 tabel:

- users, untuk menyimpan akun. Role-nya ada dua, yaitu admin dan member.
- movies, untuk menyimpan data film seperti judul, tipe, tahun, durasi, rating, sinopsis, produksi, dan status.
- categories, untuk menyimpan daftar genre.
- movie_categories, untuk menghubungkan film dengan genre. Satu film bisa punya lebih dari satu genre.
- broadcast_schedule, untuk menyimpan jadwal tayang film per hari.

## Cara Instalasi

Yang perlu disiapkan:

- PHP versi 8 atau lebih baru
- MySQL atau MariaDB
- Git
- Laragon (boleh dipakai, tidak wajib)

Langkah-langkahnya:

1. Download project ini dengan perintah `git clone https://github.com/kevinfico1/movieverse.git`, lalu masuk ke foldernya.
2. Buat database baru dengan nama `movieverse` di phpMyAdmin atau di terminal.
3. Import file `database/movieverse.sql` ke database tersebut. File ini sudah berisi tabel dan data awal.
4. Kalau mau, jalankan juga file `database/fill_empty_genres.sql` untuk melengkapi genre beberapa film.
5. Buka file `config/database.php`, lalu cocokkan isinya dengan database kamu. Isinya adalah host, nama database, username, dan password. Biasanya host adalah localhost, username adalah root, dan password kosong.
6. Pastikan folder `asset/uploads` bisa ditulis, karena dipakai untuk menyimpan poster dari admin.
7. Jalankan website dari folder project dengan perintah `php -S localhost:3000`, lalu buka `http://localhost:3000` di browser. Kalau memakai Laragon, atur document root ke folder project ini.

Catatan penting: website ini harus dijalankan dari root server, bukan dari subfolder. Ini karena alamat link di dalam kode diawali dengan tanda garis miring, contohnya `/pages/movies/list_film.php`.

Catatan lain: file SQL dibuat dengan MySQL 8.4. Kalau muncul error collation saat import, ganti tulisan `utf8mb4_0900_ai_ci` di file SQL menjadi `utf8mb4_unicode_ci`.

Cara membuat akun admin: daftar dulu lewat halaman Register. Akun baru otomatis menjadi member. Lalu jalankan perintah SQL `UPDATE users SET role = 'admin' WHERE email = 'email-kamu';` untuk mengubahnya menjadi admin. Di file SQL juga ada akun contoh. Sebaiknya akun contoh itu diganti atau dihapus kalau website dipasang di server sungguhan.

## Cara Penggunaan

Sebagai pengguna:

1. Buka website, lalu daftar di halaman Register dan login.
2. Di halaman Home, klik poster film untuk melihat detailnya.
3. Klik tombol panah di samping logo untuk membuka menu. Di menu ada Broadcast Schedule, List of Films, dan Genre.
4. Di List of Films, ketik judul film di kolom pencarian untuk mencari film.
5. Untuk mengumpulkan key, pertama buka halaman detail film dan klik Get more. Lalu buka halaman Genre dan pilih pet Echo atau Aha. Setelah itu klik Claim untuk mengambil hadiah. Jumlah key bisa dilihat di halaman detail film.

Sebagai admin:

1. Login memakai akun admin, lalu buka menu Admin.
2. Untuk menambah film, isi form di sebelah kanan, yaitu judul, tanggal dengan format dd/mm/yyyy, genre, status, deskripsi, dan poster. Lalu klik Apply.
3. Untuk mengubah status, klik tulisan Publish atau Draft pada film.
4. Untuk menghapus film, klik ikon tempat sampah lalu pilih OK.
5. Untuk menambah genre, klik tombol ADD di bagian Add More Genre.

## Struktur Folder

- index.php: halaman Home
- asset: gambar background, gambar pet, foto, dan poster hasil upload
- components: topbar dan footer
- config: koneksi database
- database: file SQL
- pages: halaman admin, halaman login dan register, serta halaman film
- repositories: fungsi untuk mengambil data
- script: file JavaScript
- style: file CSS

## Kontribusi

Kalau ada yang mau membantu mengembangkan project ini, caranya seperti ini:

1. Fork repository ini.
2. Buat branch baru, misalnya dengan perintah `git checkout -b fitur-baru`.
3. Ubah kode, lalu commit dengan pesan yang jelas, misalnya `git commit -m "tambah fitur watchlist"`.
4. Push branch kamu dengan perintah `git push origin fitur-baru`.
5. Buat Pull Request dan jelaskan apa yang kamu ubah.

Aturan sederhana saat menulis kode:

- Gunakan prepared statement untuk query database supaya aman.
- Gunakan fungsi e() saat menampilkan data ke halaman supaya aman dari XSS.
- Taruh kode pengambil data di folder repositories.
- Ikuti penamaan yang sudah ada. Nama fungsi dan variabel memakai bahasa Indonesia, dan CSS dipisah per halaman.

Kalau menemukan bug atau punya ide, silakan buat Issue di GitHub.

## Kekurangan dan Rencana Pengembangan

Project ini masih belum sempurna. Beberapa hal yang belum selesai:

- Tombol Watch, Add, dan OPEN episode belum berfungsi dan hanya tampilan saja.
- Jumlah key disimpan di session, jadi hilang kalau pengguna logout.
- Halaman jadwal tayang masih memakai daftar yang ditulis langsung di kode. Padahal tabel broadcast_schedule sudah ada di database.
- Katalog film awal (nomor 1 sampai 22) masih ditulis langsung di kode, jadi belum sama persis dengan isi tabel movies.
- Belum ada fitur lupa password.

Rencana kami ke depan adalah menambah pemutar video, fitur watchlist, menyimpan key di database, memindahkan semua data film dan jadwal ke database, menambah fitur edit film, dan fitur reset password.

## Tim Pengembang

Dibuat oleh kelompok Orang Have:

- Calder: UI/UX
- Kevin: Front End
- Vito: Backend
