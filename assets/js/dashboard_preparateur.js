// initialise après chargement DOM
window.addEventListener('DOMContentLoaded', () => {
  const cards = document.querySelectorAll('.stat-card');
  const container = document.getElementById('dynamic-content');

  // clique → active + update
  cards.forEach(card => {
    card.addEventListener('click', () => {
      cards.forEach(c => c.classList.remove('active'));
      card.classList.add('active');
      const key = card.dataset.section;
      container.innerHTML = getContent(key);
    });
  });

  // affichage par défaut
  cards[0].classList.add('active');
  container.innerHTML = getContent('to-prepare');
});

/**
 * Renvoie le HTML selon la clé :
 * - to-prepare : commandes à préparer
 * - ready      : commandes prêtes
 */
function getContent(key) {
  const data = {
    'to-prepare': `
      <h2>commandes à préparer</h2>
      <ul>
        <li>#101 – en attente de préparation</li>
        <li>#102 – en attente de préparation</li>
        <li>#103 – en attente de préparation</li>
      </ul>
    `,
    'ready': `
      <h2>commandes prêtes</h2>
      <ul>
        <li>#095 – prêtes pour expédition</li>
        <li>#096 – prêtes pour expédition</li>
      </ul>
    `
  };
  return data[key] || '<p>aucune donnée</p>';
}
