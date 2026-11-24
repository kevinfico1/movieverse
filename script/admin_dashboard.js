document.addEventListener('DOMContentLoaded', () => {
  const KEY = 'planarcadia_admin_v1';
  const MAKS_TAMPIL = 4;

  const list = document.getElementById('kontenList');
  const genreList = document.getElementById('genreList');
  const form = document.getElementById('formMedia');
  const preview = document.getElementById('previewPoster');
  const ikon = document.getElementById('ikonPoster');
  const posterInput = document.getElementById('fPoster');

  const esc = (s) => String(s).replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

  // ---------- Penyimpanan (ke server: data/admin_state.json) ----------
  const ENDPOINT = '/pages/admin/simpan_film.php';
  const state = JSON.parse(document.getElementById('dataAwal').textContent);
  state.items.forEach((it, i) => { if (!it.id) it.id = 'awal-' + i; });
  let posterData = '';
  let antrean = Promise.resolve(true);

  // Simpan berurutan; hasilnya true bila berhasil
  const simpan = () => {
    antrean = antrean.then(async () => {
      try {
        const res = await fetch(ENDPOINT, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'fetch' },
          body: JSON.stringify(state),
        });
        const data = await res.json();
        if (!res.ok || !data.ok) throw new Error(data.pesan || 'Gagal menyimpan');

        // Ambil alamat poster & id film dari server, tanpa menimpa perubahan yang baru dibuat
        data.items.forEach((r) => {
          const lokal = state.items.find((x) => x.id === r.id);
          if (lokal) { lokal.poster = r.poster; if (r.nid) lokal.nid = r.nid; }
        });
        render();
        return true;
      } catch (e) {
        alert('Gagal menyimpan ke server: ' + e.message);
        return false;
      }
    });
    return antrean;
  };

  const catatan = document.getElementById('catatan');
  const tampilCatatan = (html, galat = false) => {
    catatan.innerHTML = html;
    catatan.classList.toggle('galat', galat);
    catatan.hidden = false;
  };

  // ---------- Tampilan ----------
  const tanggalHariIni = () => {
    const d = new Date();
    const p = (n) => String(n).padStart(2, '0');
    return `${p(d.getDate())}/${p(d.getMonth() + 1)}/${d.getFullYear()}`;
  };

  const baris = (it) => `
    <div class="adm-row adm-item" data-id="${esc(it.id)}">
      <div class="adm-judul">
        <div class="adm-poster">${it.poster ? `<img src="${esc(it.poster)}" alt="${esc(it.judul)}">` : '<i class="fa-solid fa-film"></i>'}</div>
        <span>${esc(it.judul)}</span>
      </div>
      <div class="adm-chips">${it.genre.map((g) => `<span class="chip">${esc(g)}</span>`).join('')}</div>
      <div class="adm-status">
        <button type="button" class="badge ${it.status === 'Draft' ? 'draft' : 'publish'}" aria-label="Ubah status"><i></i><span>${it.status === 'Draft' ? 'DRAFT' : 'PUBLISH'}</span></button>
        <span class="tgl">${esc(it.tanggal)}</span>
      </div>
      <div class="adm-aksi"><button type="button" class="btn-hapus" aria-label="Hapus ${esc(it.judul)}"><i class="fa-regular fa-trash-can"></i></button></div>
    </div>`;

  const render = () => {
    list.innerHTML = state.items.slice(0, MAKS_TAMPIL).map(baris).join('');
    genreList.innerHTML = state.genres.map((g) => `<span class="chip chip-lg">${esc(g)}</span>`).join('');
  };

  // ---------- Aksi tabel ----------
  list.addEventListener('click', (ev) => {
    const row = ev.target.closest('.adm-item');
    if (!row) return;
    const item = state.items.find((x) => x.id === row.dataset.id);
    if (!item) return;

    if (ev.target.closest('.badge')) {
      item.status = item.status === 'Draft' ? 'Publish' : 'Draft';
      render(); simpan();
      return;
    }
    if (ev.target.closest('.btn-hapus') && confirm(`Hapus "${item.judul}"?`)) {
      state.items = state.items.filter((x) => x.id !== item.id);
      render(); simpan();
    }
  });

  // ---------- Tambah genre ----------
  document.getElementById('tombolTambahGenre').addEventListener('click', () => {
    const nama = (prompt('Nama genre baru:') || '').trim();
    if (!nama) return;
    if (state.genres.some((g) => g.toLowerCase() === nama.toLowerCase())) {
      alert('Genre itu sudah ada.');
      return;
    }
    state.genres.push(nama.charAt(0).toUpperCase() + nama.slice(1));
    render(); simpan();
  });

  // ---------- Poster (dikecilkan supaya muat di penyimpanan) ----------
  posterInput.addEventListener('change', () => {
    const file = posterInput.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = () => {
      const img = new Image();
      img.onload = () => {
        const skala = Math.min(1, 240 / Math.max(img.width, img.height));
        const c = document.createElement('canvas');
        c.width = Math.round(img.width * skala);
        c.height = Math.round(img.height * skala);
        c.getContext('2d').drawImage(img, 0, 0, c.width, c.height);
        posterData = c.toDataURL('image/jpeg', 0.8);
        preview.src = posterData;
        preview.hidden = false;
        ikon.hidden = true;
      };
      img.src = reader.result;
    };
    reader.readAsDataURL(file);
  });

  // Tanggal manual: hanya angka dan "/"
  const fDate = document.getElementById('fDate');
  fDate.addEventListener('input', () => { fDate.value = fDate.value.replace(/[^\d/]/g, ''); });

  // Genre: pisahkan dengan koma, maksimal 4
  const MAKS_GENRE = 4;
  const fGenre = document.getElementById('fGenre');
  const daftarGenre = (teks) => {
    const hasil = [];
    teks.split(',').map((g) => g.trim()).filter(Boolean).forEach((g) => {
      if (!hasil.some((x) => x.toLowerCase() === g.toLowerCase())) hasil.push(g);
    });
    return hasil.slice(0, MAKS_GENRE);
  };
  fGenre.addEventListener('input', () => {
    const bagian = fGenre.value.split(',');
    if (bagian.length > MAKS_GENRE) fGenre.value = bagian.slice(0, MAKS_GENRE).join(',');
  });

  form.addEventListener('reset', () => {
    preview.hidden = true;
    ikon.hidden = false;
    posterData = '';
  });

  // ---------- Apply = simpan ----------
  form.addEventListener('submit', (ev) => {
    ev.preventDefault();
    const judul = document.getElementById('fTitle').value.trim();
    if (!judul) return;

    const tgl = fDate.value.trim();
    if (tgl && !/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(tgl)) {
      alert('Format tanggal harus dd/mm/yyyy, contoh 23/11/2026.');
      fDate.focus();
      return;
    }

    const status = document.getElementById('fStatus').value.trim().toLowerCase() === 'draft' ? 'Draft' : 'Publish';
    state.items.unshift({
      id: 'baru-' + Date.now(),
      judul,
      genre: daftarGenre(fGenre.value),
      status,
      tanggal: tgl || tanggalHariIni(),
      poster: posterData,
      deskripsi: document.getElementById('fDesc').value.trim(),
      admin: true,
    });
    render();
    form.reset();

    simpan().then((ok) => {
      if (!ok) return tampilCatatan('Film belum tersimpan di server.', true);
      tampilCatatan(status === 'Publish'
        ? `"${esc(judul)}" tersimpan dan sudah masuk <a href="/pages/movies/list_film.php">Daftar Film</a>.`
        : `"${esc(judul)}" tersimpan sebagai draft (belum tampil di Daftar Film).`);
    });
  });

  render();
});
