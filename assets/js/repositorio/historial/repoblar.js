
function repoblar(repoblarId) {

  $('#repoblarId').val(repoblarId);

}

//Capturo los elementos por id
let btnRepoblar = document.getElementById('btnRepoblar');
let inputRepoblarId = document.getElementById('repoblarId');


if (btnRepoblar) {

  btnRepoblar.addEventListener("click", (e) => {

    e.preventDefault();

    $.ajax({
      type: 'POST',
      url: baseUrl + 'historial/repoblar',
      data: {
        idRegistro: inputRepoblarId.value
      },

    })
      .done(function (respuestaPeticion) {

        $('#respuestaPeticionRepoblar').html(respuestaPeticion);

        let paginaActualConfig = 1;
        obtenerHistorialTabla('', paginaActualConfig);
        Swal.fire({
          position: 'top-end',
          icon: 'success',
          title: 'Repoblado Correctamente',
          showConfirmButton: false,
          timer: 800
        })
        $("#modalRepoblar").modal('hide');
      })
  });
}