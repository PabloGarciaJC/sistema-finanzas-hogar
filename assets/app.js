// Importá tus estilos CSS para que se incluyan en el build
import './styles/app.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';


document.addEventListener('DOMContentLoaded', function () {
    const userCards = document.querySelectorAll('.user-card');
    const form = document.getElementById('login-form');
    const emailInput = document.getElementById('inputEmail');

    const passwordInput = document.getElementById('inputPassword');
    const loadingIndicator = document.querySelector('.spinner');

    // Verificamos si el spinner existe en la página
    if (!loadingIndicator) {
        console.error('El spinner no fue encontrado en el DOM.');
        return;
    }

    userCards.forEach(card => {
        const selectLink = card.querySelector('.select-action');
        selectLink.addEventListener('click', function (e) {
            e.preventDefault();

            userCards.forEach(c => c.classList.remove('active'));
            card.classList.add('active');

            emailInput.value = card.dataset.email;
            passwordInput.value = card.dataset.password;

            // Mostrar el spinner antes de enviar el formulario
            loadingIndicator.style.display = 'inline-block';
            // Enviar el formulario automáticamente
            form.submit();
        });
    });

    // Limpiar formulario si haces clic fuera
    document.addEventListener('click', function (event) {
        if (!event.target.closest('.user-card') && !event.target.closest('#login-form')) {
            emailInput.value = '';
            passwordInput.value = '';
            userCards.forEach(c => c.classList.remove('active'));
        }
    });
});
