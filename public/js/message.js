import { showAlert } from './showAlert.js';

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
        }, 5000);
    }

    async function getMessages(data) {
    const container = document.querySelector('.message-channel');
    if (!container) return;

   
    const tacheId = data.get('tache');
    const groupeId = data.get('groupe');

    if (!tacheId && !groupeId) {
        if (container.children.length === 0 || container.querySelector('.no-messages')) {
            container.innerHTML = `<div class="no-messages">Enregistrez pour activer la discussion.</div>`;
        }
        return;
    }

    const filteredParams = new URLSearchParams();
    if (tacheId) filteredParams.append('tache', tacheId);
    if (groupeId) filteredParams.append('groupe', groupeId);

    try {
        const response = await fetch(`${urlGet}?${filteredParams.toString()}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            },
        });

        if (!response.ok) {
            return; 
        }

        const datamessage = await response.json();
        const messages = datamessage.data;

        container.innerHTML = '';

        if (Array.isArray(messages) && messages.length > 0) {
            messages.forEach(msg => {
                const userIdMeta = document.querySelector('meta[name="user-id"]');
                const currentUserId = userIdMeta ? parseInt(userIdMeta.content) : null;
                const isOwnMessage = msg.user_id === currentUserId;

                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${isOwnMessage ? 'own-message' : 'other-message'}`;

                messageDiv.innerHTML = `
                    <div class="message-meta">
                        <span class="user-name">${isOwnMessage ? 'Moi' : (msg.user?.prenom || 'Utilisateur')}</span>
                        <span class="message-time">${msg.created_at_human || ''}</span>
                    </div>
                    <div class="message-content">${msg.contenu}</div>
                `;
                container.appendChild(messageDiv);
            });
        } else {
            container.innerHTML = `<div class="no-messages">Aucun message pour l’instant.</div>`;
        }
    } catch (error) {
        console.error('Erreur réseau :', error);
    }
}
    
});
