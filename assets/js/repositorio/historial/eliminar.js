function eliminarHistorial(idHistorial, nombreHistorial, descripcionHistorial, gastosHistorial, fechaCorteHistorial, statusHistorial, eliminarPaginaActualHistorial) {

  //Repoblar Inputs
  $('#eliminarIdHistorial').val(idHistorial);
  $('#eliminarNombreHistorial').val(nombreHistorial);
  $('#eliminarDescripcionHistorial').val(descripcionHistorial);
  $('#eliminarGastosHistorial').val(gastosHistorial);
  $('#eliminarFechaCorteHistorial').val(fechaCorteHistorial);
  $('#eliminarStatusHistorial').val(statusHistorial);
  $('#eliminarPaginaActualHistorial').val(eliminarPaginaActualHistorial);
}

//Capturo los elementos por id
let btnEliminarHistorial = document.getElementById('btnEliminarHistorial');
let eliminarIdHistorial = document.getElementById('eliminarIdHistorial');
let eliminarPaginaActualHistorial = document.getElementById('eliminarPaginaActualHistorial');

if (btnEliminarHistorial) {
  //Capturo Modal Formulario Eliminar
  btnEliminarHistorial.addEventListener("click", (e) => {
    e.preventDefault();
    $.ajax({
      type: 'POST',
      url: baseUrl + 'Historial/eliminar',
      data: {
        eliminarIdHistorial: eliminarIdHistorial.value,
      },
    }).done(function (respuestaPeticion) {
      
      $('#eliminarHistorialPeticionAjax').html(respuestaPeticion);

      if (respuestaPeticion == 1) {
        let deletePaginaActualConfig = eliminarPaginaActualHistorial.value;
        obtenerHistorialTabla('', deletePaginaActualConfig);
        Swal.fire({
          position: 'top-end',
          icon: 'success',
          title: 'Eliminado Correctamente',
          showConfirmButton: false,
          timer: 800
        })
        $("#modalEliminarHistorial").modal('hide');
      } else {
        Swal.fire({
          title: 'No se Puede eliminar un Registro Predeterminado',
          showDenyButton: false,
          showCancelButton: true,
        })
      }
    })
      .fail(function () {
        console.log('error');
      })
      .always(function () {
        console.log('completo');
      });
  });
}


