
function validacionesHistorial(inputCrearDescripcionHistorial, inputCrearGastosHistorial, inputCrearFechaCorteHistorial) {
  if (inputCrearDescripcionHistorial.value.trim() == "") {
    return mostrarMensajeErrorHistorial(inputCrearDescripcionHistorial, '<strong> Error </strong>, no puede estar vacío.');
  } else if (!isNaN(inputCrearDescripcionHistorial.value)) {
    return mostrarMensajeErrorHistorial(inputCrearDescripcionHistorial, '<strong> Error </strong>, el campo debe ser Text.');
  } else if (inputCrearGastosHistorial.value.trim() == "") {
    return mostrarMensajeErrorHistorial(inputCrearGastosHistorial, '<strong> Error </strong>, no puede estar vacío.');
  } else if (isNaN(inputCrearGastosHistorial.value)) {
    return mostrarMensajeErrorHistorial(inputCrearGastosHistorial, '<strong> Error </strong>, el campo debe ser Numerico.');
  } if (inputCrearFechaCorteHistorial.value.trim() == "") {
    return mostrarMensajeErrorHistorial(inputCrearFechaCorteHistorial, '<strong> Error </strong>, no puede estar vacío.');
  } else if (!isNaN(inputCrearFechaCorteHistorial.value)) {
    return mostrarMensajeErrorHistorial(inputCrearFechaCorteHistorial, '<strong> Error </strong>, el campo debe ser Text.');
  } else {
    return true;
  }
}

function borrarMensajeErrorHistorial(elementoEd) {
  elementoEd.parentElement.lastElementChild.innerHTML = "";
}

function mostrarMensajeErrorHistorial(elementoEd, mensaje) {
  elementoEd.parentElement.lastElementChild.innerHTML = mensaje;
}

