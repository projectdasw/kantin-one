document.addEventListener('DOMContentLoaded', () => {
    const searchForm = document.getElementById('buildingSearchForm');
    const searchInput = document.getElementById('buildingSearchInput');
    const statusFilter = document.getElementById('buildingStatusFilter');
    const resetButton = document.getElementById('buildingResetFilter');
    const tableContainer = document.getElementById('buildingsTableContainer');

    if (!searchForm || !tableContainer) return;

    let debounceTimer;
    let controller;

    const loadBuildings = async (page = 1, updateUrl = true) => {
        if (controller) controller.abort();
        controller = new AbortController();

        const formData = new FormData(searchForm);
        formData.set('page', page);

        try {
            const response = await fetch(searchForm.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html',
                },
                body: formData,
                signal: controller.signal,
            });

            if (!response.ok) {
                throw new Error('Gagal memuat data gedung.');
            }

            tableContainer.innerHTML = await response.text();

            if (updateUrl) {
                const params = new URLSearchParams();

                if (searchInput.value.trim()) {
                    params.set('search', searchInput.value.trim());
                }

                if (statusFilter.value !== '') {
                    params.set('status', statusFilter.value);
                }

                if (page > 1) {
                    params.set('page', page);
                }

                const query = params.toString();

                history.replaceState(
                    {},
                    '',
                    window.location.pathname + (query ? `?${query}` : '')
                );
            }
        } catch (error) {
            if (error.name !== 'AbortError') {
                console.error(error);
                Swal.fire('Error', error.message, 'error');
            }
        }
    };

    searchInput.addEventListener('input', () => {
        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {
            loadBuildings();
        }, 350);
    });

    statusFilter.addEventListener('change', () => {
        loadBuildings();
    });

    searchForm.addEventListener('submit', (event) => {
        event.preventDefault();
        clearTimeout(debounceTimer);
        loadBuildings();
    });

    resetButton.addEventListener('click', () => {
        searchInput.value = '';
        statusFilter.value = '';
        loadBuildings();
    });

    tableContainer.addEventListener('click', (event) => {
        const link = event.target.closest('.pagination a');

        if (!link) return;

        event.preventDefault();

        const url = new URL(link.href);
        const page = url.searchParams.get('page') || 1;

        loadBuildings(page);
    });

    tableContainer.addEventListener('submit', (event) => {
        const statusForm = event.target.closest('.building-status-form');
        const deleteForm = event.target.closest('.building-delete-form');

        if (!statusForm && !deleteForm) return;

        event.preventDefault();

        if (statusForm) {
            Swal.fire({
                title: 'Ubah Status Gedung?',
                text: 'Apakah Anda yakin ingin mengubah status gedung ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) statusForm.submit();
            });
        }

        if (deleteForm) {
            Swal.fire({
                title: 'Hapus Gedung?',
                text: 'Apakah Anda yakin ingin menghapus gedung ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc3545',
            }).then((result) => {
                if (result.isConfirmed) deleteForm.submit();
            });
        }
    });
});