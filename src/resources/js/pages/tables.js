document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('tableContainer');
    const searchInput = document.getElementById('tableSearch');
    const statusFilter = document.getElementById('tableStatus');

    if (!container || !searchInput || !statusFilter) return;

    let debounceTimer;

    // Memuat data meja melalui AJAX
    async function loadTables(url = null) {
        const params = new URLSearchParams({
            search: searchInput.value,
            status: statusFilter.value,
        });

        const requestUrl = url || `${window.location.pathname}?${params}`;

        container.style.opacity = '0.5';

        try {
            const response = await fetch(requestUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html',
                },
            });

            if (!response.ok) throw new Error('Gagal memuat data meja.');

            container.innerHTML = await response.text();
            initializeTooltips();
        } catch (error) {
            console.error(error);
            container.innerHTML = `
                <div class="alert alert-danger">
                    Gagal memuat data meja. Silakan coba kembali.
                </div>
            `;
        } finally {
            container.style.opacity = '1';
        }
    }

    // Pencarian dengan debounce
    searchInput.addEventListener('input', () => {
        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {
            loadTables();
        }, 400);
    });

    // Filter status
    statusFilter.addEventListener('change', () => loadTables());

    // Pagination AJAX
    container.addEventListener('click', (event) => {
        const link = event.target.closest('.pagination a');

        if (!link) return;

        event.preventDefault();
        loadTables(link.href);
    });

    // Konfirmasi hapus
    container.addEventListener('submit', async (event) => {
        const form = event.target.closest('.delete-table-form');

        if (!form) return;

        event.preventDefault();

        const result = await Swal.fire({
            title: 'Hapus meja?',
            text: 'Meja akan dipindahkan ke Recycle Bin.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
        });

        if (result.isConfirmed) {
            form.submit();
        }
    });

    function initializeTooltips() {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach((element) => {
            bootstrap.Tooltip.getOrCreateInstance(element);
        });
    }

    initializeTooltips();
});