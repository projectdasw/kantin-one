document.addEventListener('DOMContentLoaded', () => {
    const searchForm = document.getElementById('floorSearchForm');
    const searchInput = document.getElementById('floorSearchInput');
    const buildingFilter = document.getElementById('floorBuildingFilter');
    const statusFilter = document.getElementById('floorStatusFilter');
    const resetButton = document.getElementById('floorResetFilter');
    const tableContainer = document.getElementById('floorsTableContainer');

    if (!searchForm || !tableContainer) return;

    let debounceTimer;
    let controller;

    const loadFloors = async (page = 1, updateUrl = true) => {
        if (controller) controller.abort();
        controller = new AbortController();

        const formData = new FormData(searchForm);
        formData.set('page', page);

        try {
            const response = await fetch(searchForm.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    Accept: 'text/html',
                },
                body: formData,
                signal: controller.signal,
            });

            if (!response.ok) {
                throw new Error('Gagal memuat data lantai.');
            }

            tableContainer.innerHTML = await response.text();

            if (updateUrl) {
                const params = new URLSearchParams();

                if (searchInput.value.trim()) {
                    params.set('search', searchInput.value.trim());
                }

                if (buildingFilter.value !== '') {
                    params.set('building_id', buildingFilter.value);
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
            loadFloors();
        }, 350);
    });

    buildingFilter.addEventListener('change', () => {
        loadFloors();
    });

    statusFilter.addEventListener('change', () => {
        loadFloors();
    });

    searchForm.addEventListener('submit', (event) => {
        event.preventDefault();
        clearTimeout(debounceTimer);
        loadFloors();
    });

    resetButton.addEventListener('click', () => {
        searchInput.value = '';
        buildingFilter.value = '';
        statusFilter.value = '';
        loadFloors();
    });

    tableContainer.addEventListener('click', (event) => {
        const link = event.target.closest('.pagination a');

        if (!link) return;

        event.preventDefault();

        const url = new URL(link.href);
        const page = url.searchParams.get('page') || 1;

        loadFloors(page);
    });

    tableContainer.addEventListener('submit', (event) => {
        const statusForm = event.target.closest('.floor-status-form');
        const deleteForm = event.target.closest('.floor-delete-form');

        if (!statusForm && !deleteForm) return;

        event.preventDefault();

        if (statusForm) {
            Swal.fire({
                title: 'Ubah Status Lantai?',
                text: 'Apakah Anda yakin ingin mengubah status lantai ini?',
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
                title: 'Hapus Lantai?',
                text: 'Apakah Anda yakin ingin menghapus lantai ini?',
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