function eventoInputs(elemento, evento, idElemento) {
  elemento.addEventListener(evento, (e) => {
    let id = document.querySelector(`#${idElemento}`);
    id.lastElementChild.innerHTML = "";
  });
}