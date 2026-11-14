document.addEventListener('DOMContentLoaded', () => {
    // Hanya aktif pada halaman produk pelanggan.
    const productPage = document.querySelector('[data-customer-products]');

    if (!productPage) {
        return;
    }

    productPage.querySelectorAll('[data-cart-action]').forEach(form => {
        form.addEventListener('submit', async event => {
            event.preventDefault();

            const button = form.querySelector('button[type="submit"]');
            const container = form.closest('.d-flex');
            const quantityElement = container?.querySelector('[data-cart-quantity]');
            const decreaseButton = container?.querySelector('[data-cart-decrease]');

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

                if (quantityElement) {
                    quantityElement.textContent = result.quantity;
                }

                if (decreaseButton) {
                    decreaseButton.disabled = result.quantity <= 0;
                }

            } catch (error) {
                console.error(error);

                if (window.Swal) {
                    window.Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: error.message,
                    });
                }

            } finally {
                if (button) {
                    button.disabled = false;
                }
            }
        });
    });
});