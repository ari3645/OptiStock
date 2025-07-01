// stocks_preparateur.js
// simple filter sur la colonne produit

window.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('filter-input');
  const rows  = document.querySelectorAll('.stock-table tbody tr');

  input.addEventListener('input', () => {
    const q = input.value.trim().toLowerCase();
    rows.forEach(r => {
      const prod = r.cells[0].textContent.toLowerCase();
      r.style.display = prod.includes(q) ? '' : 'none';
    });
  });
});
