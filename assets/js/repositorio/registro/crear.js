
//Capturo los elementos input por Id
let inputIngresoVeronica = document.getElementById('crearIngresoVeronicaR');
let inputIngresoPablo = document.getElementById('crearIngresoPabloR');
let inputIngresoExtra = document.getElementById('crearIngresoExtraR');
let inputAhorros = document.getElementById('crearAhorrosR');
let inputMes = document.getElementById('crearMesR');
let inputYear = document.getElementById('crearYearR');
let btnCrear = document.querySelector('#btnCrear');

if (btnCrear) {
  btnCrear.addEventListener("click", (e) => {
    e.preventDefault();
    // Eventos de inputs
    eventoInputs(inputIngresoVeronica, 'keypress', 'claseCrearIngresoVeronicaR');
    eventoInputs(inputIngresoVeronica, 'change', 'claseCrearIngresoVeronicaR');

    eventoInputs(inputIngresoPablo, 'keypress', 'claseCrearIngresoPabloR');
    eventoInputs(inputIngresoPablo, 'change', 'claseCrearIngresoPabloR');

    eventoInputs(inputIngresoExtra, 'keypress', 'claseCrearIngresoExtraR');
    eventoInputs(inputIngresoExtra, 'change', 'claseCrearIngresoExtraR');

    eventoInputs(inputAhorros, 'keypress', 'claseCrearAhorrosR');
    eventoInputs(inputAhorros, 'change', 'claseCrearAhorrosR');

    eventoInputs(inputMes, 'keypress', 'claseCrearMesR');
    eventoInputs(inputMes, 'change', 'claseCrearMesR');

    eventoInputs(inputYear, 'keypress', 'claseCrearYearR');
    eventoInputs(inputYear, 'change', 'claseCrearYearR');
    
    let validacionFormulario = validacionesRegistro(inputIngresoVeronica, inputIngresoPablo, inputIngresoExtra, inputAhorros, inputMes, inputYear);

    if (validacionFormulario == true) {
      ajaxCrear();
    }

  });
}


function ajaxCrear() {
  $.ajax({
    type: 'POST',
    url: baseUrl + 'Registro/crear',
    data: {
      ingresoVeronica: inputIngresoVeronica.value,
      ingresoPablo: inputIngresoPablo.value,
      ingresoExtra: inputIngresoExtra.value,
      ahorros: inputAhorros.value,
      mes: inputMes.value,
      year: inputYear.value
    },
  }).done(function (respuestaPeticion) {
    $('#crearRegistroPeticionAjax').html(respuestaPeticion);
    if (respuestaPeticion == 1) {
      let paginaActual = 1;
      obtenerRegistrosTabla('', paginaActual);
      $('#crearFormularioRegistro').trigger('reset');
      Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Guardado Correctamente',
        showConfirmButton: false,
        timer: 800
      })
      $("#modalCrearRegistro").modal('hide');
    } else {
      Swal.fire({ title: 'El mes y año, ya estan registrados !!' })
    }
  })
    .fail(function () {
      console.log('error');
    })
    .always(function () {
      console.log('completo');
    });
}



























