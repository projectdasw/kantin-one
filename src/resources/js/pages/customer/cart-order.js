document.addEventListener('submit', async (event) => {
    const form = event.target.closest('[data-cart-action]');

    if (!form) {
        return;
    }

    event.preventDefault();

    const button = form.querySelector('button[type="submit"]');

    if (button?.disabled) {
        return;
    }

    if (button) {
        button.disabled = true;
    }

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: new FormData(form),
        });

        const result = await response.json();

        if (!response.ok || !result.success) {
            throw new Error(result.message || 'Gagal memperbarui keranjang.');
        }

        // Ambil tampilan keranjang terbaru dari server.
        const refreshResponse = await fetch(window.location.href, {
            headers: {
                Accept: 'text/html',
                'X-Requested-With': 'XMLHttpRequest',
            },
        });

        if (!refreshResponse.ok) {
            throw new Error('Gagal memperbarui tampilan keranjang.');
        }

        const html = await refreshResponse.text();
        const documentParser = new DOMParser();
        const newDocument = documentParser.parseFromString(html, 'text/html');

        const currentCart = document.querySelector('[data-customer-cart]');
        const updatedCart = newDocument.querySelector('[data-customer-cart]');

        if (!currentCart || !updatedCart) {
            throw new Error('Elemen keranjang tidak ditemukan.');
        }

        currentCart.replaceWith(updatedCart);

    } catch (error) {
        console.error('Customer cart error:', error);

        if (window.Swal) {
            window.Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: error.message || 'Terjadi kesalahan saat memperbarui keranjang.',
            });
        } else {
            alert(error.message || 'Terjadi kesalahan saat memperbarui keranjang.');
        }

        if (button) {
            button.disabled = false;
        }
    }
});