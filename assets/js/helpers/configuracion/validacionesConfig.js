
function validacionesConfig(inputCrearDescripcionConfig, inputCrearGastosConfig, inputCrearFechaCorteConfig) {
  if (inputCrearDescripcionConfig.value.trim() == "") {
    return mostrarMensajeErrorConfig(inputCrearDescripcionConfig, '<strong> Error </strong>, no puede estar vacío.');
  } else if (!isNaN(inputCrearDescripcionConfig.value)) {
    return mostrarMensajeErrorConfig(inputCrearDescripcionConfig, '<strong> Error </strong>, el campo debe ser Text.');
  } else if (inputCrearGastosConfig.value.trim() == "") {
    return mostrarMensajeErrorConfig(inputCrearGastosConfig, '<strong> Error </strong>, no puede estar vacío.');
  } else if (isNaN(inputCrearGastosConfig.value)) {
    return mostrarMensajeErrorConfig(inputCrearGastosConfig, '<strong> Error </strong>, el campo debe ser Numerico.');
  } if (inputCrearFechaCorteConfig.value.trim() == "") {
    return mostrarMensajeErrorConfig(inputCrearFechaCorteConfig, '<strong> Error </strong>, no puede estar vacío.');
  } else if (!isNaN(inputCrearFechaCorteConfig.value)) {
    return mostrarMensajeErrorConfig(inputCrearFechaCorteConfig, '<strong> Error </strong>, el campo debe ser Text.');
  } else {
    return true;
  }
}

function borrarMensajeErrorConfig(elementoEd) {
  elementoEd.parentElement.lastElementChild.innerHTML = "";
}

function mostrarMensajeErrorConfig(elementoEd, mensaje) {
  elementoEd.parentElement.lastElementChild.innerHTML = mensaje;
}

