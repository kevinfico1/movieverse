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
