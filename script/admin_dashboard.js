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

var pilihanGenre = document.querySelectorAll('input[name="genre[]"]');

function batasiGenre() {
  var jumlah = 0;

  for (var i = 0; i < pilihanGenre.length; i++) {
    if (pilihanGenre[i].checked) {
      jumlah++;
    }
  }

  for (var j = 0; j < pilihanGenre.length; j++) {
    pilihanGenre[j].disabled = jumlah >= 4 && !pilihanGenre[j].checked;
  }
}

for (var k = 0; k < pilihanGenre.length; k++) {
  pilihanGenre[k].addEventListener('change', batasiGenre);
}

form.addEventListener('reset', function () {
  setTimeout(batasiGenre, 0);
});
