/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';

import * as bootstrap from 'bootstrap';

// Inicio de Sesion - Carga de Usuarios en Automatico
document.addEventListener('DOMContentLoaded', function () {
    const userCards = document.querySelectorAll('.user-card');
    const form = document.getElementById('login-form');
    const emailInput = document.getElementById('inputEmail');
    const passwordInput = document.getElementById('inputPassword');
    const loadingIndicator = document.getElementById('loading-indicator');

    userCards.forEach(card => {
        const selectLink = card.querySelector('.select-action');
        selectLink.addEventListener('click', function (e) {
            e.preventDefault();

            userCards.forEach(c => c.classList.remove('active'));
            card.classList.add('active');

            emailInput.value = card.dataset.email;
            passwordInput.value = card.dataset.password;

            // Mostrar el indicador de carga
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