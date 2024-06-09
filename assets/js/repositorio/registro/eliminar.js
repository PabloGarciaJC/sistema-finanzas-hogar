function eliminar(id, mesR, yearR, paginaActual) {
  //Repoblar Inputs
  $('#eliminarIdRegistro').val(id);
  $('#eliminarMesR').val(mesR);
  $('#eliminarYearR').val(yearR);
  $('#eliminarPaginaActual').val(paginaActual);
}

//Capturo los elementos por id
let btnEliminarRegistro = document.getElementById('btnEliminarRegistro');
let eliminarIdRegistro = document.getElementById('eliminarIdRegistro');
let mes = document.getElementById('eliminarMesR');
let year = document.getElementById('eliminarYearR');
let eliminarPaginaActual = document.getElementById('eliminarPaginaActual');

if (btnEliminarRegistro) {
  //Capturo Modal Formulario Eliminar
  btnEliminarRegistro.addEventListener("click", (e) => {
    e.preventDefault();
    $.ajax({
      type: 'POST',
      url: baseUrl + 'Registro/eliminar',
      data: { id: eliminarIdRegistro.value }
    }).done(function (respuestaPeticion) {
      if (respuestaPeticion == 1) {
        let elimPaginaActual = eliminarPaginaActual.value;
        obtenerRegistrosTabla('', elimPaginaActual);
        Swal.fire({
          position: 'top-end',
          icon: 'success',
          title: 'Eliminado Correctamente',
          showConfirmButton: false,
          timer: 800
        })
        $("#modalEliminarRegistro").modal('hide');
      } else {
        Swal.fire({
          title: 'No se Puede eliminar registros que contengas tablas',
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


