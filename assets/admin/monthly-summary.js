
document.querySelectorAll('.col-md-4.col-xxl-3').forEach(div => {
  div.classList.remove('col-md-4', 'col-xxl-3');
});

document.querySelectorAll('.col-xxl-5').forEach(div => {
  div.classList.remove('col-xxl-5');
});

document.querySelectorAll('.cntn-inputs').forEach(innerDiv => {
 innerDiv.classList.remove('col-md-10');
  const outerDiv = innerDiv.closest('.col-md-6');
  if (outerDiv) {
    outerDiv.classList.remove('col-md-6');
  }
});

document.querySelectorAll('.col-md-7.col-xxl-6').forEach(div => {
  div.classList.remove('col-md-7', 'col-xxl-6');
});

document.querySelectorAll('.col-md-9.col-xxl-7').forEach(div => {
  div.classList.remove('col-md-9', 'col-xxl-7');
});

document.querySelectorAll('.col-md-10.form-group').forEach(div => {
  div.classList.remove('col-md-10', 'form-group');
});
