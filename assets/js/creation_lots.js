// qd DOM est prêt
document.addEventListener('DOMContentLoaded', ()=> {
  const available = document.querySelector('.available-list');
  const lotBody   = document.querySelector('.lot-table tbody');
  const btnCreate = document.getElementById('create-lot');
  const msg       = document.getElementById('response-msg');
  const lotName   = document.getElementById('lot-name');

  // quand on clique sur "Ajouter"
  available.addEventListener('click', e => {
    if(!e.target.classList.contains('btn-add')) return;
    const btn = e.target;
    const libelle = btn.dataset.libelle;
    const max = parseInt(btn.dataset.max,10);

    // si déjà ajouté, skip
    if(lotBody.querySelector(`[data-libelle="${libelle}"]`)) {
      alert(libelle + ' est déjà dans le lot !');
      return;
    }

    // créer ligne
    const tr = document.createElement('tr');
    tr.dataset.libelle = libelle;
    tr.innerHTML = `
      <td>${libelle}</td>
      <td>
        <input type="number" min="1" max="${max}" value="1">
      </td>
      <td>
        <button class="btn-remove">✕</button>
      </td>
    `;
    lotBody.appendChild(tr);
  });

  // gérer suppression et quantité
  lotBody.addEventListener('click', e => {
    if(e.target.classList.contains('btn-remove')) {
      e.target.closest('tr').remove();
    }
  });

  // création du lot (mock)
  btnCreate.addEventListener('click', ()=> {
    const name = lotName.value.trim();
    if(!name) {
      msg.textContent = 'Donne un nom à ton lot !'; msg.style.color = 'red';
      return;
    }
    const items = Array.from(lotBody.querySelectorAll('tr')).map(tr=>{
      const lib = tr.dataset.libelle;
      const qty = tr.querySelector('input').value;
      return {lib,qty};
    });
    if(items.length===0) {
      msg.textContent = 'Ajoute au moins 1 article !'; msg.style.color = 'red';
      return;
    }

    // mock console log, ici on ferait fetch POST vers PHP/API
    console.log('création du lot', name, items);
    msg.textContent = `✅ Lot "${name}" créé avec ${items.length} articles.`;
    msg.style.color = 'green';

    // reset form
    lotName.value='';
    lotBody.innerHTML='';
  });
});
