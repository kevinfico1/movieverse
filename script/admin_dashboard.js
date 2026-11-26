var tombolGenre = document.getElementById('tombolTambahGenre');
var inputPoster = document.getElementById('fPoster');
var preview = document.getElementById('previewPoster');
var ikon = document.getElementById('ikonPoster');
var form = document.getElementById('formMedia');

tombolGenre.addEventListener('click', function () {
  var nama = prompt('Nama genre baru:');

  if (nama && nama.trim() !== '') {
    document.getElementById('genreBaru').value = nama.trim();
    document.getElementById('formGenre').submit();
  }
});

inputPoster.addEventListener('change', function () {
  var file = inputPoster.files[0];

  if (file) {
    preview.src = URL.createObjectURL(file);
    preview.hidden = false;
    ikon.hidden = true;
  }
});

form.addEventListener('reset', function () {
  preview.hidden = true;
  ikon.hidden = false;
});

var inputGenre = document.getElementById('fGenre');
var tombolPilih = document.querySelectorAll('.genre-pilih');
var terpilih = [];

var wadahGenre = document.getElementById('genreTersembunyi');

function tampilkanGenre() {
  inputGenre.value = terpilih.join(', ');
  wadahGenre.innerHTML = '';

  for (var n = 0; n < terpilih.length; n++) {
    var kiriman = document.createElement('input');
    kiriman.type = 'hidden';
    kiriman.name = 'genre[]';
    kiriman.value = terpilih[n];
    wadahGenre.appendChild(kiriman);
  }

  for (var i = 0; i < tombolPilih.length; i++) {
    var dipilih = terpilih.indexOf(tombolPilih[i].dataset.genre) !== -1;

    tombolPilih[i].classList.toggle('dipilih', dipilih);
    tombolPilih[i].disabled = terpilih.length >= 4 && !dipilih;
  }
}

for (var k = 0; k < tombolPilih.length; k++) {
  tombolPilih[k].addEventListener('click', function () {
    var nama = this.dataset.genre;
    var posisi = terpilih.indexOf(nama);

    if (posisi === -1) {
      terpilih.push(nama);
    } else {
      terpilih.splice(posisi, 1);
    }

    tampilkanGenre();
  });
}

form.addEventListener('reset', function () {
  terpilih = [];
  tampilkanGenre();
});
