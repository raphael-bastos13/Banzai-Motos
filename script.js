

var imgAtualBMW = "../BMWS1000RR.png"; /* Imagem que vai vir depois quando mudar para BMW */
var imgAnteriorBMW = "../BMWS1000RR.png"; /* Imagem na tela atualmente para BMW */

function trocarBMW() {
  document.getElementById("figura").src = imgAtualBMW;
  let aux = imgAtualBMW;
  imgAtualBMW = imgAnteriorBMW;
  imgAnteriorBMW = aux;
}

var imgAtualHonda = "../HONDACBR650R.png"; /* Imagem que vai vir depois quando mudar para Honda */
var imgAnteriorHonda = "../HONDACBR650R.png"; /* Imagem na tela atualmente para Honda */

function trocarHonda() {
  document.getElementById("figura").src = imgAtualHonda;
  let aux = imgAtualHonda;
  imgAtualHonda = imgAnteriorHonda;
  imgAnteriorHonda = aux;
}

var imgAtualYamaha = "../yamahaxmax250.png"; /* Imagem que vai vir depois quando mudar para Yamaha */
var imgAnteriorYamaha = "../yamahaxmax250.png"; /* Imagem na tela atualmente para Yamaha */


function trocarYamaha() {
  document.getElementById("figura").src = imgAtualYamaha;
  let aux = imgAtualYamaha;
  imgAtualYamaha = imgAnteriorYamaha;
  imgAnteriorYamaha = aux;
}

var imgAtualTriumph = "../TriumphBonnevilleT100.png"; /* Imagem que vai vir depois quando mudar para Yamaha */
var imgAnteriorTriumph = "../TriumphBonnevilleT100.png"; /* Imagem na tela atualmente para Yamaha */


function trocarTriumph() {
  document.getElementById("figura").src = imgAtualTriumph;
  let aux = imgAtualTriumph;
  imgAtualTriumph = imgAnteriorTriumph;
  imgAnteriorTriumph = aux;
}

