// wait for DOM
document.addEventListener('DOMContentLoaded', ()=> {
  document.querySelectorAll('.btn-detail').forEach(btn=>{
    btn.addEventListener('click', e=> {
      // toggle la ligne juste après
      const tr = e.target.closest('tr');
      const detail = tr.nextElementSibling;
      if(detail && detail.classList.contains('invoice-detail')) {
        detail.style.display = detail.style.display === 'table-row' ? 'none' : 'table-row';
      }
    });
  });
});
