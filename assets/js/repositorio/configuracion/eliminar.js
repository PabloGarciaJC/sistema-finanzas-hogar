function eliminarConfig(idConfig, nombreConfig, descripcionConfig, gastosConfig, fechaCorteConfig, statusConfig, eliminarPaginaActualConfig) {
  //Repoblar Inputs
  $('#eliminarIdConfig').val(idConfig);
  $('#eliminarNombreConfig').val(nombreConfig);
  $('#eliminarDescripcionConfig').val(descripcionConfig);
  $('#eliminarGastosConfig').val(gastosConfig);
  $('#eliminarFechaCorteConfig').val(fechaCorteConfig);
  $('#statusEliminarConfig').val(statusConfig);
  $('#eliminarPaginaActualConfig').val(eliminarPaginaActualConfig);
}

//Capturo los elementos por id
let btnEliminarConfiguracion = document.getElementById('btnEliminarConfiguracion');
let eliminarIdConfig = document.getElementById('eliminarIdConfig');
let eliminarPaginaActualConfig = document.getElementById('eliminarPaginaActualConfig');

if (btnEliminarConfiguracion) {
  //Capturo Modal Formulario Eliminar
  btnEliminarConfiguracion.addEventListener("click", (e) => {
    e.preventDefault();
    $.ajax({
      type: 'POST',
      url: baseUrl + 'Configuracion/eliminar',
      data: {
        idEliminarConfig: eliminarIdConfig.value,
      },
    }).done(function (respuestaPeticion) {
      
      $('#eliminarConfigPeticionAjax').html(respuestaPeticion);
      if (respuestaPeticion == 1) {
        let deletePaginaActualConfig = eliminarPaginaActualConfig.value;
        obtenerConfigTabla('', deletePaginaActualConfig);
        Swal.fire({
          position: 'top-end',
          icon: 'success',
          title: 'Eliminado Correctamente',
          showConfirmButton: false,
          timer: 800
        })
        $("#modalEliminarrConfig").modal('hide');
      } else {
        Swal.fire({
          title: 'No se Puede eliminar un Registro Predeterminado',
          showDenyButton: false,
          showCancelButton: true,
        })
      }
    })

  });
}


