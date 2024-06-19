
function validacionesRegistro(inputIngresoVeronica, inputIngresoPablo, inputIngresoExtra,
  inputAhorros, inputMes, inputYear) {

  if (inputIngresoVeronica.value.trim() == "") {
    return mostrarMensajeErrorR(inputIngresoVeronica, '<strong> Error </strong>, no puede estar vacío.');
  } else if (isNaN(inputIngresoVeronica.value)) {
    return mostrarMensajeErrorR(inputIngresoVeronica, '<strong> Error </strong>, el campo debe ser numerico.');
  } else if (inputIngresoPablo.value.trim() == "") {
    return mostrarMensajeErrorR(inputIngresoPablo, '<strong> Error </strong>, no puede estar vacío.');
  } else if (isNaN(inputIngresoPablo.value)) {
    return mostrarMensajeErrorR(inputIngresoPablo, '<strong> Error </strong>, el campo debe ser numerico.');
  } if (inputIngresoExtra.value.trim() == "") {
    return mostrarMensajeErrorR(inputIngresoExtra, '<strong> Error </strong>, no puede estar vacío.');
  } else if (isNaN(inputIngresoExtra.value)) {
    return mostrarMensajeErrorR(inputIngresoExtra, '<strong> Error </strong>, el campo debe ser numerico.');
  } else if (inputAhorros.value.trim() == "") {
    return mostrarMensajeErrorR(inputAhorros, '<strong> Error </strong>, no puede estar vacío.');
  } else if (isNaN(inputAhorros.value)) {
    return mostrarMensajeErrorR(inputAhorros, '<strong> Error </strong>, el campo debe ser numerico.');
  } if (inputMes.value.trim() == "") {
    return mostrarMensajeErrorR(inputMes, '<strong> Error </strong>, no puede estar vacío.');
  } else if (!isNaN(inputMes.value)) {
    return mostrarMensajeErrorR(inputMes, '<strong> Error </strong>, el campo debe ser Texto.');
  } if (inputYear.value.trim() == "") {
    return mostrarMensajeErrorR(inputYear, '<strong> Error </strong>, no puede estar vacío.');
  } else if (isNaN(inputYear.value)) {
    return mostrarMensajeErrorR(inputYear, '<strong> Error </strong>, el campo debe ser numerico.');
  }else{
    return true;  
  }

}

function borrarMensajeErrorR(elementoR) {
  elementoR.parentElement.lastElementChild.innerHTML = "";
}

function mostrarMensajeErrorR(elementoR, mensaje) {
  elementoR.parentElement.lastElementChild.innerHTML = mensaje;
}

