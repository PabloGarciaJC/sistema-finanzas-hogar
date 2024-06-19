let paginaActual = 1;

// Se ejecuta Primero La Tabla
obtenerRegistrosTabla('', paginaActual);

//Capturo los elementos por id
let buscadorRegistro = document.getElementById('buscadorRegistro');

//Capturo el Buscador a tiempo Real
if (buscadorRegistro) {
  buscadorRegistro.addEventListener("keyup", function (e) {
    let imputBuscadorRegistro = buscadorRegistro.value; 
    obtenerRegistrosTabla(imputBuscadorRegistro, paginaActual);
  });
};

function obtenerRegistrosTabla(imputBuscadorRegistro, paginaActual) {
  $.ajax({
    type: 'POST',
    url: baseUrl + 'Registro/buscador',
    data: {
      imputBuscador: imputBuscadorRegistro,
      paginaActual: paginaActual
    },
  })
    .done(function (respuestaPeticion) {
      $('#tablaRegistro').html(respuestaPeticion);
    })
}









