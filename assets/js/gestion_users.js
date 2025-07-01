// – js pour gérer la création en AJAX
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('user-form');
  const msg  = document.getElementById('response-msg');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    msg.textContent = ''; 

    const data = new FormData(form);

    // envoi AJAX
    const resp = await fetch(form.action || window.location.href, {
      method: 'POST',
      headers: { 'X-Requested-With': 'XMLHttpRequest' },
      body: data
    });
    const json = await resp.json();

    // affichage du retour
    msg.textContent = json.msg;
    msg.style.color = json.status === 'success' ? 'green' : 'red';

    if (json.status === 'success') form.reset();
  });
});
