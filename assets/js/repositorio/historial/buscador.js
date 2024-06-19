
let paginaActualHistorial = 1;

// Se ejecuta Primero La Tabla
obtenerHistorialTabla('', paginaActualHistorial);

// Capturo los elementos por id
let buscadorHistorial = document.getElementById('buscadorHistorial');

// Capturo el Buscador a tiempo Real
if (buscadorHistorial) {
  buscadorHistorial.addEventListener("keyup", function (e) {
    let inputBuscadorHistorial = buscadorHistorial.value;
    obtenerHistorialTabla(inputBuscadorHistorial, paginaActualHistorial);
  });

};

function obtenerHistorialTabla(inputBuscadorHistorial, paginaActualHistorial) {

  // Obtengo el id Registro POR GET
  let idRegistroHistorial = document.getElementById('idRegistro');

  if (idRegistroHistorial) {

    $.ajax({
      type: 'POST',
      url: baseUrl + 'historial/buscador',
      data: {
        imputBuscadorHistorial: inputBuscadorHistorial,
        paginaActualHistorial: paginaActualHistorial,
        idRegistro: idRegistroHistorial.value
      },
    })
      .done(function (respuestaPeticion) {
        $('#tablaHistorial').html(respuestaPeticion);
      })
  }
}