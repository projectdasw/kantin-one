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
    // LIVE SEARCH, FILTER & PAGINATION
    // ==========================================
    const searchForm = document.getElementById('userSearchForm');
    const searchInput = document.getElementById('userSearchInput');
    const tableContainer = document.getElementById('usersTableContainer');

    if (searchForm && searchInput && tableContainer) {
        let searchTimeout;
        let controller;

        async function loadUsers(url) {
            if (controller) {
                controller.abort();
            }

            const currentController = new AbortController();
            controller = currentController;
            tableContainer.style.opacity = '0.5';

            try {
                const response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    signal: currentController.signal
                });

                if (!response.ok) {
                    throw new Error('Gagal mengambil data pengguna.');
                }

                const html = await response.text();

                // Abaikan response dari request yang sudah tidak aktif
                if (controller !== currentController) return;

                tableContainer.innerHTML = html;
                window.history.replaceState({}, '', url);
            } catch (error) {
                if (error.name !== 'AbortError') {
                    console.error(error);

                    Swal.fire(
                        'Gagal',
                        'Tidak dapat memuat data pengguna.',
                        'error'
                    );
                }
            } finally {
                if (controller === currentController) {
                    tableContainer.style.opacity = '1';
                }
            }
        }

        function buildSearchUrl() {
            const url = new URL(searchForm.action, window.location.origin);
            const formData = new FormData(searchForm);

            formData.forEach((value, key) => {
                if (value !== '') {
                    url.searchParams.set(key, value);
                }
            });

            // Pencarian baru dimulai dari halaman pertama
            url.searchParams.delete('page');

            return url.toString();
        }

        // Live Search
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                loadUsers(buildSearchUrl());
            }, 350);
        });

        // Filter Role dan Status
        searchForm.addEventListener('submit', function (event) {
            event.preventDefault();
            clearTimeout(searchTimeout);
            loadUsers(buildSearchUrl());
        });

        // Pagination AJAX
        tableContainer.addEventListener('click', function (event) {
            const link = event.target.closest('.pagination a');
            if (!link) return;

            event.preventDefault();
            loadUsers(link.href);
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
});
