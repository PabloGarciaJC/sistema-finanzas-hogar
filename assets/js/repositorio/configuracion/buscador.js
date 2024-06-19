
let paginaActualConfig = 1;

// Se ejecuta Primero La Tabla
obtenerConfigTabla('', paginaActualConfig);

// Capturo los elementos por id
let buscadorConfig = document.getElementById('buscadorConfiguracion');

// Capturo el Buscador a tiempo Real
if (buscadorConfig) {

  buscadorConfig.addEventListener("keyup", function (e) {
    let imputBuscadorConfig = buscadorConfig.value;
    obtenerConfigTabla(imputBuscadorConfig, paginaActualConfig);
  });
};

function obtenerConfigTabla(imputBuscadorConfig, paginaActualConfig) {

  $.ajax({
    type: 'POST',
    url: baseUrl + 'Configuracion/buscador',
    data: {
      imputBuscadorConfig: imputBuscadorConfig,
      paginaActualConfig: paginaActualConfig,
    },
  })
    .done(function (respuestaPeticion) {
      $('#tablaConfiguracion').html(respuestaPeticion);
    })
}