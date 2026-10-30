
document.addEventListener('DOMContentLoaded', () => {
    // Bootstrap form validation
    const forms = document.querySelectorAll('.needs-validation');

    forms.forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        });
    });

    // Show / Hide Password
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    const togglePasswordIcon = document.getElementById('togglePasswordIcon');

    if (passwordInput && togglePassword && togglePasswordIcon) {
        togglePassword.addEventListener('click', () => {
            const isHidden = passwordInput.type === 'password';

            passwordInput.type = isHidden ? 'text' : 'password';

            togglePasswordIcon.classList.toggle('fa-eye', !isHidden);
            togglePasswordIcon.classList.toggle('fa-eye-slash', isHidden);

            togglePassword.setAttribute(
                'aria-label',
                isHidden ? 'Sembunyikan password' : 'Tampilkan password'
            );

            togglePassword.setAttribute('aria-pressed', String(isHidden));
        });
    }
});
