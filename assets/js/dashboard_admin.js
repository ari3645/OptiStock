// js pour rendre le dashboard vivant (pas juste un pdf stylé)

// attend que la page soit prête (no premature access here)
window.addEventListener("DOMContentLoaded", () => {
  // cible toutes les cartes de stats
  const statCards = document.querySelectorAll(".stat-card");
  const dynamicContent = document.getElementById("dynamic-content");

  // chaque carte devient cliquable
  statCards.forEach((card) => {
    card.addEventListener("click", () => {
      // vire les classes actives des autres
      statCards.forEach((c) => c.classList.remove("active"));
      // met la classe active sur celle qu'on clique
      card.classList.add("active");

      // récupère le type de contenu à afficher (genre commandes / factures)
      const dataType = card.dataset.section;

      // appelle la fonction qui update le contenu
      updateDynamicContent(dataType);
    });
  });

  // affiche un contenu par défaut au chargement (commandes si t’appelles pas)
  updateDynamicContent("commandes");
});

// swap le contenu selon la carte cliquée
function updateDynamicContent(type) {
  const content = {
    commandes: `
      <h3>commandes récentes</h3>
      <ul>
        <li>commande #001 - en cours</li>
        <li>commande #002 - livrée</li>
        <li>commande #003 - annulée</li>
      </ul>
    `,
    factures: `
      <h3>dernières factures</h3>
      <ul>
        <li>facture #203 - 49,99€</li>
        <li>facture #202 - 25,00€</li>
        <li>facture #201 - 99,90€</li>
      </ul>
    `,
    stocks: `
      <h3>stocks dispo</h3>
      <ul>
        <li>bracelets : 24 en stock</li>
        <li>colliers : 5 en stock (danger zone)</li>
        <li>bagues : 0 en stock (rip)</li>
      </ul>
    `,
    lots: `
      <h3>lots récents</h3>
      <ul>
        <li>lot #A01 - 15 articles</li>
        <li>lot #A02 - 22 articles</li>
        <li>lot #A03 - 5 articles (meh)</li>
      </ul>
    `,
  };

  // update le contenu ou fallback si type inconnu
  dynamicContent.innerHTML = content[type] || `<p>aucune donnée pour "${type}", oops</p>`;
}
