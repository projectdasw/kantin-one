document.addEventListener('DOMContentLoaded', function () {
    // ==========================================
    // BOOTSTRAP FORM VALIDATION
    // ==========================================
    document.querySelectorAll('.needs-validation').forEach(form => {
        form.addEventListener('submit', function (event) {

            // Username lowercase
            const username = form.querySelector('#username');

            if (username) {
                username.value = username.value.toLowerCase();
            }

            // Password confirmation
            const password = form.querySelector('#password');
            const confirmation = form.querySelector('#password_confirmation');

            if (password && confirmation) {
                confirmation.setCustomValidity(
                    confirmation.value !== password.value
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
    });

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

        // ==========================================
    // DATATABLES: FILTER MASTER AKUN
    // ==========================================
    window.addEventListener('load', function () {
        const table = window.LaravelDataTables?.['users-table'];

        if (!table) {
            console.error('DataTables Master Akun tidak ditemukan.');
            return;
        }

        const roleFilter = document.getElementById('userRoleFilter');
        const statusFilter = document.getElementById('userStatusFilter');
        const resetButton = document.getElementById('resetUserFilters');

        // ==========================================
        // DATATABLES: SATUKAN SEARCH DAN FILTER
        // ==========================================
        const filtersContainer = document.getElementById('userFilters');

        const searchContainer = document.querySelector(
            '#users-table_wrapper .dt-search'
        );

        if (filtersContainer && searchContainer) {

            // Jadikan area pencarian sebagai toolbar horizontal
            searchContainer.classList.add(
                'd-flex',
                'flex-wrap',
                'align-items-center',
                'gap-2'
            );

            // Hilangkan margin bawaan label
            const searchLabel = searchContainer.querySelector('label');

            if (searchLabel) {
                searchLabel.classList.add('mb-0');
            }

            // Atur lebar input pencarian
            const searchInput = searchContainer.querySelector('input');

            if (searchInput) {
                searchInput.style.width = '260px';
            }

            // Masukkan filter tepat di samping pencarian
            filtersContainer.classList.add(
                'd-flex',
                'flex-wrap',
                'align-items-center',
                'gap-2'
            );

            searchContainer.appendChild(filtersContainer);
        }

        // Filter berdasarkan perubahan pilihan
        [roleFilter, statusFilter].forEach(filter => {
            if (!filter) return;

            filter.addEventListener('change', function () {
                table.ajax.reload();
            });
        });

        // Reset seluruh filter
        if (resetButton) {
            resetButton.addEventListener('click', function () {

                // Reset filter peran dan status
                if (roleFilter) roleFilter.value = '';
                if (statusFilter) statusFilter.value = '';

                // Reset input pencarian
                const searchInput = document.querySelector(
                    '#users-table_wrapper .dt-search input'
                );

                if (searchInput) {
                    searchInput.value = '';
                }

                // Reset pencarian DataTables dan reload data
                table.search('').draw();
            });
        }
    });
});
