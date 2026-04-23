document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const nom = document.querySelector('input[name="nom"]');
            const prenom = document.querySelector('input[name="prenom"]');
            let valid = true;
            let message = '';
            if (!nom || nom.value.trim() === '') {
                valid = false;
                message += 'Le nom est requis. ';
            }
            if (!prenom || prenom.value.trim() === '') {
                valid = false;
                message += 'Le prénom est requis. ';
            }
            if (!valid) {
                e.preventDefault();
                let errorDiv = document.querySelector('#error-message');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.id = 'error-message';
                    errorDiv.style.color = 'red';
                    form.parentNode.insertBefore(errorDiv, form);
                }
                errorDiv.textContent = message;
            }
        });
    }
});