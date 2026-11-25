document.addEventListener('DOMContentLoaded', function () {
    // ==========================================
    // FORM VALIDATION
    // ==========================================
    const form = document.querySelector('.needs-validation');
    const nameInput = document.getElementById('name');
    const usernameInput = document.getElementById('username');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const confirmationInput = document.getElementById('password_confirmation');
    const roleInput = document.getElementById('role');
    const tenantInput = document.getElementById('tenant_id');
    const nameFeedback = document.getElementById('nameFeedback');
    const usernameFeedback = document.getElementById('usernameFeedback');
    const emailFeedback = document.getElementById('emailFeedback');
    const passwordFeedback = document.getElementById('passwordFeedback');
    const confirmationFeedback = document.getElementById('passwordConfirmationFeedback');
    const roleFeedback = document.getElementById('roleFeedback');
    const tenantFeedback = document.getElementById('tenantFeedback');

    // ==========================================
    // NAME VALIDATION
    // ==========================================
    if (nameInput && nameFeedback) {
        nameInput.addEventListener('invalid', function () {
            nameFeedback.textContent = 'Mohon isi nama akun.';
        });
    }

    // ==========================================
    // USERNAME VALIDATION
    // ==========================================
    if (usernameInput && usernameFeedback) {
        usernameInput.addEventListener('invalid', function () {
            if (usernameInput.value.trim() === '') {
                usernameFeedback.textContent = 'Mohon isi username.';
            } else if (usernameInput.validity.patternMismatch) {
                usernameFeedback.textContent =
                    'Username hanya boleh menggunakan huruf kecil, angka, underscore, dan tanda hubung.';
            } else if (usernameInput.validity.tooLong) {
                usernameFeedback.textContent = 'Username maksimal 50 karakter.';
            } else {
                usernameFeedback.textContent = 'Username tidak valid.';
            }
        });
    }

    // ==========================================
    // EMAIL VALIDATION
    // ==========================================
    if (emailInput && emailFeedback) {
        emailInput.addEventListener('invalid', function () {
            emailFeedback.textContent = 'Format email tidak valid.';
        });
    }

    // ==========================================
    // PASSWORD VALIDATION
    // ==========================================
    if (passwordInput && passwordFeedback) {
        function updatePasswordFeedback() {
            passwordFeedback.textContent = passwordInput.value.trim() === ''
                ? 'Mohon isi password.'
                : 'Password minimal 8 karakter.';
        }

        passwordInput.addEventListener('invalid', updatePasswordFeedback);
        passwordInput.addEventListener('input', updatePasswordFeedback);
    }

    // ==========================================
    // PASSWORD CONFIRMATION VALIDATION
    // ==========================================
    if (passwordInput && confirmationInput && confirmationFeedback) {
        function updateConfirmationFeedback() {
            confirmationFeedback.textContent =
                confirmationInput.value.trim() === ''
                    ? 'Mohon isi konfirmasi password.'
                    : 'Konfirmasi password tidak sama.';

            confirmationInput.setCustomValidity(
                confirmationInput.value !== passwordInput.value
                    ? 'Konfirmasi password tidak sama.'
                    : ''
            );
        }

        confirmationInput.addEventListener('input', updateConfirmationFeedback);
        confirmationInput.addEventListener('invalid', updateConfirmationFeedback);
        passwordInput.addEventListener('input', updateConfirmationFeedback);
    }

    // ==========================================
    // ROLE VALIDATION
    // ==========================================
    if (roleInput && roleFeedback) {
        roleInput.addEventListener('invalid', function () {
            roleFeedback.textContent = 'Mohon pilih peran.';
        });
    }

    // ==========================================
    // TENANT VALIDATION
    // ==========================================
    if (tenantInput && tenantFeedback) {
        tenantInput.addEventListener('invalid', function () {
            tenantFeedback.textContent = 'Mohon pilih tenant.';
        });
    }

    // ==========================================
    // BOOTSTRAP FORM VALIDATION
    // ==========================================
    if (form) {
        form.addEventListener('submit', function (event) {
            if (usernameInput) {
                usernameInput.value = usernameInput.value.toLowerCase();
            }

            if (passwordInput && confirmationInput) {
                confirmationInput.setCustomValidity(
                    confirmationInput.value !== passwordInput.value
                        ? 'Konfirmasi password tidak sama.'
                        : ''
                );
            }

            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        });
    }

    // ==========================================
    // USERNAME LOWERCASE
    // ==========================================
    document.addEventListener('input', function (event) {
        if (event.target.id !== 'username') return;

        const start = event.target.selectionStart;
        const end = event.target.selectionEnd;
        event.target.value = event.target.value.toLowerCase();
        event.target.setSelectionRange(start, end);

    });

    // ==========================================
    // TENANT FIELD: SHOW / HIDE BASED ON ROLE
    // ==========================================
    const roleSelect = document.getElementById('role');
    const tenantField = document.getElementById('tenantField');
    const tenantSelect = document.getElementById('tenant_id');

    if (roleSelect && tenantField && tenantSelect) {

        function toggleTenantField() {
            const selectedRole = roleSelect.value;

            const requiresTenant = [
                'tenant',
                'tenant_employee'
            ].includes(selectedRole);

            tenantField.classList.toggle('d-none', !requiresTenant);

            tenantSelect.required = requiresTenant;

            if (!requiresTenant) {
                tenantSelect.value = '';
            }
        }

        roleSelect.addEventListener('change', toggleTenantField);

        // Jalankan saat halaman pertama kali dibuka
        toggleTenantField();
    }

    // ==========================================
    // HTML ESCAPE FOR SWEETALERT
    // ==========================================
    function escapeHtml(value) {
        return String(value).replace(/[&<>"']/g, character => {
            const entities = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
    
            return entities[character];
        });
    }

    // ==========================================
    // SWEETALERT: ACTIVATE / DEACTIVATE
    // ==========================================
    document.addEventListener('submit', function (event) {
        const form = event.target.closest('.status-form');
        if (!form) return;

        event.preventDefault();
        const name = form.dataset.name;
        const isActive = form.dataset.active === '1';

        Swal.fire({
            title: isActive ? 'Nonaktifkan pengguna?' : 'Aktifkan pengguna?',
            text: `Apakah Anda yakin ingin ${ isActive ? 'menonaktifkan' : 'mengaktifkan' } akun ${name}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, lanjutkan',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then(result => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // ==========================================
    // SWEETALERT: DELETE USER (SOFT DELETE)
    // ==========================================
    document.addEventListener('submit', function (event) {
        const form = event.target.closest('.delete-user-form');
        if (!form) return;

        event.preventDefault();
        const name = form.dataset.name;

        Swal.fire({
            title: 'Hapus Akun Pengguna?',
            html: `
                Akun <strong>${escapeHtml(name)}</strong>
                akan dipindahkan ke data terhapus.
                <br><br>
                <small class="text-muted">
                    Data masih tersimpan dan dapat dipulihkan.
                </small>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then(result => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // ==========================================
    // PASSWORD VISIBILITY
    // ==========================================
    document.addEventListener('click', function (event) {
        const button = event.target.closest('.toggle-password');
        if (!button) return;

        const target = document.getElementById(button.dataset.target);
        if (!target) return;

        const isPassword = target.type === 'password';
        target.type = isPassword ? 'text' : 'password';
        button.innerHTML = isPassword ? '<i class="fas fa-eye-slash"></i>' : '<i class="fas fa-eye"></i>';
        button.setAttribute('aria-label', isPassword ? 'Sembunyikan password' : 'Tampilkan password');
    });

    // Restore user confirmation
    document.addEventListener('submit', function (event) {
        const form = event.target.closest('.restore-user-form');
        if (!form) return;

        event.preventDefault();

        Swal.fire({
            title: 'Pulihkan Pengguna?',
            text: `Apakah Anda yakin ingin memulihkan akun ${form.dataset.name}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Pulihkan',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then(result => {
            if (result.isConfirmed) form.submit();
        });
    });

    // Permanent delete confirmation - Double Confirmation
    document.addEventListener('submit', async function (event) {
        const form = event.target.closest('.force-delete-user-form');
        if (!form) return;

        event.preventDefault();

        const name = escapeHtml(form.dataset.name);

        // Confirmation pertama
        const firstConfirm = await Swal.fire({
            title: 'Hapus Permanen?',
            html: `
                Akun <strong>${name}</strong> akan dihapus permanen.
                <br><br>
                <span class="text-danger">
                    Data tidak dapat dipulihkan kembali!
                </span>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal',
            reverseButtons: true
        });

        if (!firstConfirm.isConfirmed) return;

        // Confirmation kedua
        const secondConfirm = await Swal.fire({
            title: 'Konfirmasi Terakhir!',
            html: `
                Apakah Anda benar-benar yakin ingin menghapus
                akun <strong>${name}</strong> secara permanen?
                <br><br>
                <strong class="text-danger">
                    Tindakan ini tidak dapat dibatalkan!
                </strong>
            `,
            icon: 'error',
            input: 'text',
            inputPlaceholder: 'Ketik HAPUS untuk melanjutkan',
            inputValidator: (value) => {
                if (value !== 'HAPUS') {
                    return 'Ketik HAPUS dengan huruf kapital untuk melanjutkan.';
                }
            },
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Hapus Permanen',
            cancelButtonText: 'Batalkan',
            reverseButtons: true
        });

        if (secondConfirm.isConfirmed) {
            form.submit();
        }
    });
});
