function showAlert(type, messages) {
    // Supprime alert existante (optionnel)
    const existing = document.querySelector('.alert');
    if (existing) existing.remove();

    const div = document.createElement('div');
    div.className = 'alert fixed top-4 left-4 w-80 p-4 rounded shadow-md z-50 ' + 
        (type === 'success' 
            ? 'bg-green-100 border border-green-400 text-green-700' 
            : 'bg-red-100 border border-red-400 text-red-700');

    const btn = document.createElement('button');
    btn.innerHTML = '&times;';
    btn.style.float = 'right';
    btn.style.background = 'transparent';
    btn.style.border = 'none';
    btn.style.cursor = 'pointer';
    btn.style.fontSize = '1.2rem';
    btn.addEventListener('click', () => div.remove());

    div.appendChild(btn);

    if (Array.isArray(messages)) {
        const ul = document.createElement('ul');
        messages.forEach(msg => {
            const li = document.createElement('li');
            li.textContent = msg;
            ul.appendChild(li);
        });
        div.appendChild(ul);
    } else {
        div.appendChild(document.createTextNode(messages));
    }

    document.body.appendChild(div);

    setTimeout(() => div.remove(), 5000);
}
