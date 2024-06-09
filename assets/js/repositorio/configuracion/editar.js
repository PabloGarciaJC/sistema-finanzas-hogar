function editarConfig(idConfig, nombreConfig, descripcionConfig, gastosConfig, fechaCorteConfig, statusConfig, editPaginaActualConfig) {
  //Repoblar Inputs
  $('#idConfig').val(idConfig);
  $('#editNombreConfig').val(nombreConfig);
  $('#editDescripcionConfig').val(descripcionConfig);
  $('#editGastosConfig').val(gastosConfig);
  $('#editFechaCorteConfig').val(fechaCorteConfig);
  $('#statusEditConfig').val(statusConfig);
  $('#editPaginaActualConfig').val(editPaginaActualConfig);
}

//Capturo los elementos por id
let idConfig = document.getElementById('idConfig');
let editNombreConfig = document.getElementById('editNombreConfig');
let editDescripcionConfig = document.getElementById('editDescripcionConfig');
let editGastosConfig = document.getElementById('editGastosConfig');
let editFechaCorteConfig = document.getElementById('editFechaCorteConfig');
let statusEditConfig = document.getElementById('statusEditConfig');
let editPaginaActualConfig = document.getElementById('editPaginaActualConfig');
let btnEditarConfiguracion = document.getElementById('btnEditarConfiguracion');

if (btnEditarConfiguracion) {
  btnEditarConfiguracion.addEventListener("click", (e) => {
    e.preventDefault();
    // Eventos de inputs
    eventoInputs(editDescripcionConfig, 'keypress', 'claseEditDescripcionConfig');
    eventoInputs(editDescripcionConfig, 'change', 'claseEditDescripcionConfig');

    eventoInputs(editGastosConfig, 'keypress', 'claseEditGastosConfig');
    eventoInputs(editGastosConfig, 'change', 'claseEditGastosConfig');

    eventoInputs(editFechaCorteConfig, 'keypress', 'claseEditFechaCorteConfig');
    eventoInputs(editFechaCorteConfig, 'change', 'claseEditFechaCorteConfig');

    let editValidacionFormConfig = validacionesConfig(editDescripcionConfig, editGastosConfig, editFechaCorteConfig);

    if (editValidacionFormConfig == true) {
      ajaxEditarConfig(idConfig, editNombreConfig, editDescripcionConfig, editGastosConfig, editFechaCorteConfig, statusEditConfig, editPaginaActualConfig);
    }

  });
}

function ajaxEditarConfig(idConfig, editNombreConfig, editDescripcionConfig, editGastosConfig, editFechaCorteConfig, statusEditConfig, editPaginaActualConfig) {
  $.ajax({
    type: 'POST',
    url: baseUrl + 'Configuracion/editar',
    data: {
      idConfig: idConfig.value,
      nombreConfig: editNombreConfig.value,
      descripcionConfig: editDescripcionConfig.value,
      gastosConfig: editGastosConfig.value,
      fechaCorteConfig: editFechaCorteConfig.value,
      statusConfig: statusEditConfig.value,
    },
  }).done(function (respuestaPeticion) {
    $('#editarConfiguracionPeticionAjax').html(respuestaPeticion);
    if (respuestaPeticion == 1) {
      let editarPaginaActualConfig = editPaginaActualConfig.value;
      obtenerConfigTabla('', editarPaginaActualConfig);
      Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Actualizado Correctamente',
        showConfirmButton: false,
        timer: 800
      })
      $("#modalEditarConfig").modal('hide');
    }
  })
    .fail(function () {
      console.log('error');
    })
    .always(function () {
      console.log('completo');
    });
}

















