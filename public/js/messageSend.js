document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('#message-form');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const data = new FormData(form);
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error('Token CSRF non trouvé');
                return;
            }

            const response = await fetch('/message/addMessageGroupe', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken.content,
                    'Accept': 'application/json',
                },
                body: data,
            });

            const result = await response.json();

            if (response.ok && result.success) {
                showAlert('success', result.message);
                form.reset();
            } else {
                showAlert('error', result.errors || result.message || 'Une erreur est survenue');
            }

        } catch (error) {
            showAlert('error', 'Erreur réseau ou serveur');
            console.error(error);
        }
    });
});
