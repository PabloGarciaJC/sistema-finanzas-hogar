function editarHistorial(idHistorial, nombreHistorial, descripcionHistorial, gastosHistorial, fechaCorteHistorial, statusHistorial, paginaActualHistorial) {

  //Repoblar Inputs
  $('#idHistorial').val(idHistorial);
  $('#editNombreHistorial').val(nombreHistorial);
  $('#editDescripcionHistorial').val(descripcionHistorial);
  $('#editGastosHistorial').val(gastosHistorial);
  $('#editFechaCorteHistorial').val(fechaCorteHistorial);
  $('#editStatusHistorial').val(statusHistorial);
  $('#editPaginaActualHistorial').val(paginaActualHistorial);

}

// Obtengo el id Registro POR GET
let idEditRegistro = document.getElementById('idRegistro');

//Capturo los elementos por id
let idHistorial = document.getElementById('idHistorial');
let editNombreHistorial = document.getElementById('editNombreHistorial');
let editDescripcionHistorial = document.getElementById('editDescripcionHistorial');
let editGastosHistorial = document.getElementById('editGastosHistorial');
let editFechaCorteHistorial = document.getElementById('editFechaCorteHistorial');
let editStatusHistorial = document.getElementById('editStatusHistorial');
let editPaginaActualHistorial = document.getElementById('editPaginaActualHistorial');
let btnEditarHistorial = document.getElementById('btnEditarHistorial');

if (btnEditarHistorial) {

  btnEditarHistorial.addEventListener("click", (e) => {

    e.preventDefault();
    // Eventos de inputs
    eventoInputs(editDescripcionHistorial, 'keypress', 'claseEditDescripcionHistorial');
    eventoInputs(editDescripcionHistorial, 'change', 'claseEditDescripcionHistorial');

    eventoInputs(editGastosHistorial, 'keypress', 'claseEditGastosHistorial');
    eventoInputs(editGastosHistorial, 'change', 'claseEditGastosHistorial');

    eventoInputs(editFechaCorteHistorial, 'keypress', 'claseEditFechaCorteHistorial');
    eventoInputs(editFechaCorteHistorial, 'change', 'claseEditFechaCorteHistorial');

    let editValidacionesHistorial = validacionesHistorial(editDescripcionHistorial, editGastosHistorial, editFechaCorteHistorial);

    if (editValidacionesHistorial == true) {
      ajaxEditarHistorial(idHistorial, editNombreHistorial, editDescripcionHistorial, editGastosHistorial, editFechaCorteHistorial, editStatusHistorial, editPaginaActualHistorial);
    }
  });
}

function ajaxEditarHistorial(idHistorial, editNombreHistorial, editDescripcionHistorial, editGastosHistorial, editFechaCorteHistorial, editStatusHistorial, editPaginaActualHistorial) {
  $.ajax({
    type: 'POST',
    url: baseUrl + 'historial/editar',
    data: {
      idHistorial: idHistorial.value,
      nombreHistorial: editNombreHistorial.value,
      descripcionHistorial: editDescripcionHistorial.value,
      gastosHistorial: editGastosHistorial.value,
      fechaCorteHistorial: editFechaCorteHistorial.value,
      statusHistorial: editStatusHistorial.value, 
      idEditRegistro: idEditRegistro.value
    },
  }).done(function (respuestaPeticion) {
    $('#editPeticionAjaxHistorial').html(respuestaPeticion);
    if (respuestaPeticion == 1) {
      let editarPaginaActualHistorial = editPaginaActualHistorial.value;
      obtenerHistorialTabla('', editarPaginaActualHistorial);
      Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Actualizado Correctamente',
        showConfirmButton: false,
        timer: 800
      })
      $("#modalEditarHistorial").modal('hide');
    }
  })
    .fail(function () {
      console.log('error');
    })
    .always(function () {
      console.log('completo');
    });
}

















