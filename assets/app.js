document.addEventListener('DOMContentLoaded', function () {
    const userCards = document.querySelectorAll('.user-card');
    const form = document.getElementById('login-form');
    const emailInput = document.getElementById('inputEmail');
    const passwordInput = document.getElementById('inputPassword');
    const loadingIndicator = document.getElementById('loading-indicator');

    //  Siempre ocultamos el loader al cargar
    if (loadingIndicator) {
        loadingIndicator.style.display = 'none';
    }

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
