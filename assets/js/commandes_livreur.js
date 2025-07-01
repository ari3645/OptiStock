// wait for dom - no jQuery needed
window.addEventListener('DOMContentLoaded', () => {
  const cards = document.querySelectorAll('.stat-card');
  const container = document.getElementById('dynamic-content');

  // clique sur card → active state + update
  cards.forEach(card => {
    card.addEventListener('click', () => {
      // retire active de toutes
      cards.forEach(c => c.classList.remove('active'));
      card.classList.add('active');

      // switch content selon data-section
      const key = card.dataset.section;
      container.innerHTML = getContent(key);
    });
  });

  // affichage initial
  container.innerHTML = getContent('to-deliver');
  cards[0].classList.add('active');
});

/**
 * renvoie un morceau de HTML selon la key
 */
function getContent(key) {
  const data = {
    'to-deliver': `
      <h2>commandes à livrer</h2>
      <ul>
        <li>#001 - en cours de livraison</li>
        <li>#002 - prêt pour collecte</li>
        <li>#003 - en cours de livraison</li>
      </ul>
    `,
    'delivered': `
      <h2>commandes livrées</h2>
      <ul>
        <li>#004 - livrée ✅</li>
        <li>#005 - livrée ✅</li>
        <li>#006 - livrée ✅</li>
      </ul>
    `
  };
  // fallback si clé inconnue
  return data[key] || '<p>aucune data dispo</p>';
}
