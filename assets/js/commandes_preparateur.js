// commandes_preparateur.js
// change le statut cycle entre "en attente" ↔ "prête à expédier"

document.addEventListener('DOMContentLoaded', () => {
  const table = document.querySelector('.commandes-table');
  table.addEventListener('click', e => {
    if (!e.target.classList.contains('btn-change')) return;
    const row = e.target.closest('tr');
    const cell = row.querySelector('.statut-cell');
    // cycle des statuts
    const next = cell.textContent.trim() === 'en attente'
      ? 'prête à expédier'
      : 'en attente';
    cell.textContent = next;
  });
});
