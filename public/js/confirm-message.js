document.addEventListener('DOMContentLoaded', ()=>{
    const forms = document.querySelectorAll('[data-confirm-message]');
    forms.forEach(form=>{
        form.addEventListener('submit', event=>{
            event.preventDefault();
            if (confirm(form.getAttribute('data-confirm-message')))
            {
                form.submit();
            }
        });
    });
});
