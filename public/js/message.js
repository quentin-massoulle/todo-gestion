document.addEventListener('DOMContentLoaded', () => {
    let urlPost = window.urlPost || null;
    let urlGet  = window.urlGet || null;
    const form = document.querySelector('#message-form');

    let lastFormData = new FormData(form);
    if (form && urlPost ) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const data = new FormData(form);
            sendMessage(data)
            });
        }


        async function sendMessage(data){
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            console.error('Token CSRF non trouvé');
            return;
        }
        try {
            let response = await fetch(urlPost, {
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

            getMessages(data);
        } catch (error) {
            showAlert('error', 'Erreur réseau ou serveur');
            console.error(error);
        }
    }
    if (urlGet)
    {
        setInterval(() => {
            if (lastFormData) {
                getMessages(lastFormData);
            }
        }, 10000);
    }

    async function getMessages(data) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        const container = document.querySelector('.message-channel');
    
        if (!csrfToken || !container) {
            console.error('CSRF token ou conteneur de messages manquant.');
            return;
        }
    
        const params = new URLSearchParams(data).toString();
    
        try {
            const response = await fetch(`${urlGet}?${params}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken.content,
                    'Accept': 'application/json',
                },
            });
    
            const datamessage = await response.json();
            const messages = datamessage.data;
    
            container.innerHTML = '';
    
            if (Array.isArray(messages) && messages.length > 0) {
                messages.forEach(msg => {
                    const isOwnMessage = msg.user_id === parseInt(document.querySelector('meta[name="user-id"]').content);
    
                    const messageDiv = document.createElement('div');
                    messageDiv.classList.add('message');
                    messageDiv.classList.add(isOwnMessage ? 'own-message' : 'other-message');
    
                    messageDiv.innerHTML = `
                        <div class="message-meta">
                            <span class="user-name">${isOwnMessage ? 'Moi' : (msg.user?.prenom || 'Utilisateur')}</span>
                            <span class="message-time">${msg.created_at_human}</span>
                        </div>
                        <div class="message-content">${msg.contenu}</div>
                    `;
    
                    container.appendChild(messageDiv);
                });
            } else {
                container.innerHTML = `<div class="no-messages">Aucun message pour l’instant.</div>`;
            }
    
        } catch (error) {
            console.error('Erreur lors de la récupération des messages :', error);
        }
    }
    
});
