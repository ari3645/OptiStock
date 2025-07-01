
document.addEventListener('DOMContentLoaded', () => {
  const form       = document.getElementById('order-form');
  const tbody      = document.querySelector('.orders-table tbody');
  const submitBtn  = document.getElementById('submit-orders');
  const msg        = document.getElementById('submit-msg');
  const qtyError   = document.getElementById('qty-error');

  // stock dispo tiré du select
  function dispoCount() {
    const opt = document.querySelector('#product-select option:checked');
    return opt ? parseInt(opt.dataset.dispo,10) : 0;
  }

  form.addEventListener('submit', e => {
    e.preventDefault();
    qtyError.textContent = '';
    const client  = document.getElementById('client-select').value;
    const prodOpt = document.getElementById('product-select');
    const produit = prodOpt.options[prodOpt.selectedIndex].text;
    const qtyInp  = document.getElementById('quantity-input');
    const qty     = parseInt(qtyInp.value,10);

    // validation quantité pas > dispo
    if (!qty || qty < 1 || qty > dispoCount()) {
      qtyError.textContent = 'quantité invalide';
      return;
    }

    // ajouter ligne au tableau
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${client}</td>
      <td>${produit}</td>
      <td>${qty}</td>
      <td><button class="btn-remove">supprimer</button></td>
    `;
    tbody.appendChild(tr);

    // réinitialiser form
    form.reset();
  });

  // suppression d'une ligne
  tbody.addEventListener('click', e => {
    if (e.target.classList.contains('btn-remove')) {
      e.target.closest('tr').remove();
    }
  });

  // validation finale
  submitBtn.addEventListener('click', () => {
    const rows = tbody.querySelectorAll('tr');
    if (!rows.length) {
      msg.textContent = 'rien à envoyer';
      return;
    }
    // ici on ferait un fetch/ajax pour envoyer tout
    msg.textContent = 'commandes envoyées '; 
    // vider la liste
    tbody.innerHTML = '';
  });
});
