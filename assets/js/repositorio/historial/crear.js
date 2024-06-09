
//Capturo los elementos input por Id
let idRegistro = document.getElementById('idRegistro');
let inputCrearNombreHistorial = document.getElementById('crearNombreHistorial');
let inputCrearDescripcionHistorial = document.getElementById('crearDescripcionHistorial');
let inputCrearGastosHistorial = document.getElementById('crearGastosHistorial');
let inputCrearFechaCorteHistorial = document.getElementById('crearFechaCorteHistorial');
let inputStatusCrearHistorial = document.getElementById('statusCrearHistorial');
let btnCrearHistorial = document.getElementById('btnCrearHistorial');

if (btnCrearHistorial) {

  btnCrearHistorial.addEventListener("click", (e) => {

      e.preventDefault();

      // Eventos de inputs
      eventoInputs(inputCrearDescripcionHistorial, 'keypress', 'claseCrearDescripcionHistorial');
      eventoInputs(inputCrearDescripcionHistorial, 'change', 'claseCrearDescripcionHistorial');

      eventoInputs(inputCrearGastosHistorial, 'keypress', 'claseCrearGastosHistorial');
      eventoInputs(inputCrearGastosHistorial, 'change', 'claseCrearGastosHistorial');

      eventoInputs(inputCrearFechaCorteHistorial, 'keypress', 'claseCrearFechaCorteHistorial');
      eventoInputs(inputCrearFechaCorteHistorial, 'change', 'claseCrearFechaCorteHistorial');

      let validacionesFormHistorial = validacionesHistorial(inputCrearDescripcionHistorial, inputCrearGastosHistorial, inputCrearFechaCorteHistorial);

      if (validacionesFormHistorial == true) {

        ajaxCrearHistorial();
      }

    });
  }

function ajaxCrearHistorial() {
  $.ajax({
    type: 'POST',
    url: baseUrl + 'historial/crear',
    data: {
      nombreHistorial: inputCrearNombreHistorial.value,
      descripcionHistorial: inputCrearDescripcionHistorial.value,
      gastosHistorial: inputCrearGastosHistorial.value,
      fechaCorteHistorial: inputCrearFechaCorteHistorial.value,
      statusCrearHistorial: inputStatusCrearHistorial.value,
      idRegistro: idRegistro.value
    },
  }).done(function (respuestaPeticion) {

    $('#historialPeticionAjax').html(respuestaPeticion);

    if (respuestaPeticion == 1) {
      let paginaActualHistorial = 1;
      obtenerHistorialTabla('', paginaActualHistorial);
      $('#crearFormularioHistorial').trigger('reset');
      Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Guardado Correctamente',
        showConfirmButton: false,
        timer: 800
      })
      $("#modalHistorial").modal('hide');
    }

  })
    .fail(function () {
      console.log('error');
    })
    .always(function () {
      console.log('completo');
    });
}



























