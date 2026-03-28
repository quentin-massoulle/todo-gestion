import { showAlert } from './showAlert.js';

document.addEventListener('DOMContentLoaded', () => {
    let urlPost = window.urlPost || null;
    let urlGet  = window.urlGet || null;
    const form = document.querySelector('#message-form');

    function scrollToBottom() {
        const container = document.querySelector('.message-channel');
        if (container) {
            container.scrollTo({
                top: container.scrollHeight,
                behavior: 'smooth'
            });
        }
    }

    // Initial scroll
    setTimeout(scrollToBottom, 500);

    // Auto-resize textarea
    if (form) {
        const textarea = form.querySelector('.message-input');
        if (textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        }
    }

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
                getMessages(data);
            } else {
                showAlert('error', result.errors || result.message || 'Une erreur est survenue');
            }

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

    const groupeId = data.get('groupe');

    if (!groupeId) {
        if (container.children.length === 0 || container.querySelector('.no-messages')) {
            container.innerHTML = `<div class="no-messages flex flex-col items-center justify-center h-full text-gray-400 space-y-2">
                <i class="fas fa-comments text-3xl opacity-20"></i>
                <p class="text-xs font-medium italic">Discussion indisponible.</p>
            </div>`;
        }
        return;
    }

    const filteredParams = new URLSearchParams();
    filteredParams.append('groupe', groupeId);

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

        // Check if we need to scroll (if user was already at bottom)
        const isAtBottom = container.scrollHeight - container.clientHeight <= container.scrollTop + 1;

        container.innerHTML = '';

        if (Array.isArray(messages) && messages.length > 0) {
            messages.forEach(msg => {
                const userIdMeta = document.querySelector('meta[name="user-id"]');
                const currentUserId = userIdMeta ? parseInt(userIdMeta.content) : null;
                const isOwnMessage = msg.user_id === currentUserId;

                const messageDiv = document.createElement('div');
                messageDiv.className = `flex ${isOwnMessage ? 'justify-end' : 'justify-start'} group`;

                messageDiv.innerHTML = `
                    <div class="max-w-[85%] flex flex-col ${isOwnMessage ? 'items-end' : 'items-start'}">
                        ${!isOwnMessage ? `
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 ml-2">
                                ${msg.user?.prenom || 'Utilisateur'}
                            </span>
                        ` : ''}
                        <div class="px-4 py-2.5 rounded-2xl shadow-sm text-sm ${isOwnMessage ? 'bg-indigo-600 text-white rounded-tr-none' : 'bg-white text-gray-700 border border-gray-100 rounded-tl-none'}">
                            ${msg.contenu}
                        </div>
                        <span class="text-[9px] text-gray-400 mt-1 ${isOwnMessage ? 'mr-1' : 'ml-1'}">
                            ${msg.created_at_human || ''}
                        </span>
                    </div>
                `;
                container.appendChild(messageDiv);
            });

            if (isAtBottom) {
                scrollToBottom();
            }
        } else {
            container.innerHTML = `<div class="no-messages flex flex-col items-center justify-center h-full text-gray-400 space-y-2">
                <i class="fas fa-comments text-3xl opacity-20"></i>
                <p class="text-xs font-medium italic">Aucun message pour l’instant.</p>
            </div>`;
        }
    } catch (error) {
        console.error('Erreur réseau :', error);
    }
}
    
});
