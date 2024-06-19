
//Capturo los elementos input por Id
let inputCrearNombreConfig = document.getElementById('crearNombreConfig');
let inputCrearDescripcionConfig = document.getElementById('crearDescripcionConfig');
let inputCrearGastosConfig = document.getElementById('crearGastosConfig');
let inputCrearFechaCorteConfig = document.getElementById('crearFechaCorteConfig');
let inputCrearStatusCrearConfig = document.getElementById('statusCrearConfig');
let btnCrearConfiguracion = document.getElementById('btnCrearConfiguracion');

if (btnCrearConfiguracion) {

  btnCrearConfiguracion.addEventListener("click", (e) => {

    e.preventDefault();

    // Eventos de inputs
    eventoInputs(inputCrearDescripcionConfig, 'keypress', 'claseCrearDescripcionConfig');
    eventoInputs(inputCrearDescripcionConfig, 'change', 'claseCrearDescripcionConfig');

    eventoInputs(inputCrearGastosConfig, 'keypress', 'claseCrearGastosConfig');
    eventoInputs(inputCrearGastosConfig, 'change', 'claseCrearGastosConfig');

    eventoInputs(inputCrearFechaCorteConfig, 'keypress', 'claseCrearFechaCorteConfig');
    eventoInputs(inputCrearFechaCorteConfig, 'change', 'claseCrearFechaCorteConfig');

    let validacionesFormConfig = validacionesConfig(inputCrearDescripcionConfig, inputCrearGastosConfig, inputCrearFechaCorteConfig);

    if (validacionesFormConfig == true) {
      ajaxCrearConfig();
    }

  });
}

function ajaxCrearConfig() {
  $.ajax({
    type: 'POST',
    url: baseUrl + 'Configuracion/crear',
    data: {
      nombreConfig: inputCrearNombreConfig.value,
      descripcionConfig: inputCrearDescripcionConfig.value,
      gastosConfig: inputCrearGastosConfig.value,
      fechaCorteConfig: inputCrearFechaCorteConfig.value,
      statusCrearConfig: inputCrearStatusCrearConfig.value,
    },
  }).done(function (respuestaPeticion) {
    $('#configuracionPeticionAjax').html(respuestaPeticion);
    if (respuestaPeticion == 1) {
      let paginaActualConfig = 1;
      obtenerConfigTabla('', paginaActualConfig);
      $('#crearFormularioConfig').trigger('reset');
      Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Guardado Correctamente',
        showConfirmButton: false,
        timer: 800
      })
      $("#modalCrearConfiguracion").modal('hide');
    }
  })
}



























