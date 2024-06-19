
function editar(id, ingresoVeronicaR, ingresoPabloR, ingresoExtraR, ahorrosR, mesR, yearR, paginaActual) {
  //Repoblar Inputs
  $('#editarIdRegistro').val(id);
  $('#editarIngresoVeronicaR').val(ingresoVeronicaR);
  $('#editarIngresoPabloR').val(ingresoPabloR);
  $('#editarIngresoExtraR').val(ingresoExtraR);
  $('#editarAhorrosR').val(ahorrosR);
  $('#editarMesR').val(mesR);
  $('#editarYearR').val(yearR);
  $('#editarPaginaActual').val(paginaActual);
}

//Capturo los elementos por id
let editarIdRegistro = document.getElementById('editarIdRegistro');
let editarIngresoVeronica = document.getElementById('editarIngresoVeronicaR');
let editarIngresoPablo = document.getElementById('editarIngresoPabloR');
let editarIngresoExtra = document.getElementById('editarIngresoExtraR');
let editarAhorros = document.getElementById('editarAhorrosR');
let editarMes = document.getElementById('editarMesR');
let editarYear = document.getElementById('editarYearR');
let editarPaginaActual = document.getElementById('editarPaginaActual');
let btnEditarRegistro = document.getElementById('btnEditarRegistro');

if (btnEditarRegistro) {
  btnEditarRegistro.addEventListener("click", (e) => {
    e.preventDefault();
    // Eventos de inputs
    eventoInputs(editarIngresoVeronica, 'keypress', 'claseEditIngresoVeronicaR');
    eventoInputs(editarIngresoVeronica, 'change', 'claseEditIngresoVeronicaR');

    eventoInputs(editarIngresoPablo, 'keypress', 'claseEditIngresoPabloR');
    eventoInputs(editarIngresoPablo, 'change', 'claseEditIngresoPabloR');

    eventoInputs(editarIngresoExtra, 'keypress', 'claseEditIngresoExtraR');
    eventoInputs(editarIngresoExtra, 'change', 'claseEditIngresoExtraR');

    eventoInputs(editarAhorros, 'keypress', 'claseEditAhorrosR');
    eventoInputs(editarAhorros, 'change', 'claseEditAhorrosR');

    eventoInputs(editarMes, 'keypress', 'claseEditMesR');
    eventoInputs(editarMes, 'change', 'claseEditMesR');

    eventoInputs(editarYear, 'keypress', 'claseEditYearR');
    eventoInputs(editarYear, 'change', 'claseEditYearR');

    let validacionFormularioEditar = validacionesRegistro(editarIngresoVeronica, editarIngresoPablo, editarIngresoExtra, editarAhorros, editarMes, editarYear);
    
    if (validacionFormularioEditar == true) {
      ajaxEditar(editarIdRegistro, editarIngresoVeronica, editarIngresoPablo, editarIngresoExtra, editarAhorros, editarMes, editarYear, editarPaginaActual);
    }
    
  });
}

function ajaxEditar(editarIdRegistro, editarIngresoVeronica, editarIngresoPablo, editarIngresoExtra, editarAhorros, editarMes, editarYear, editarPaginaActual) {
  $.ajax({
    type: 'POST',
    url: baseUrl + 'Registro/editar',
    data: {
      id: editarIdRegistro.value,
      ingresoVeronica: editarIngresoVeronica.value,
      ingresoPablo: editarIngresoPablo.value,
      ingresoExtra: editarIngresoExtra.value,
      ahorros: editarAhorros.value,
      mes: editarMes.value,
      year: editarYear.value
    },
  }).done(function (respuestaPeticion) {
    $('#editarRegistroPeticionAjax').html(respuestaPeticion);
    if (respuestaPeticion == 1) {
      let EditPaginaActual = editarPaginaActual.value;
      obtenerRegistrosTabla('', EditPaginaActual);
      Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Actualizado Correctamente',
        showConfirmButton: false,
        timer: 800
      })
      $("#modalEditarRegistro").modal('hide');
    } else {
      Swal.fire({ title: 'El mes y año, ya estan registrados !!' })
    }
  })
}

















