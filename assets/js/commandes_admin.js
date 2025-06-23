console.log("📦 commandes.js chargé");

document.addEventListener("DOMContentLoaded", () => {
  const rows = document.querySelectorAll(".orders-table tbody tr");
  const detailZone = document.getElementById("order-detail");

  rows.forEach(row => {
    row.addEventListener("click", () => {
      // récupère les infos de la ligne
      const cells = row.querySelectorAll("td");
      const id = cells[0].textContent.trim();
      const client = cells[1].textContent.trim();
      const date = cells[2].textContent.trim();
      const statut = cells[3].textContent.trim();

      // injecte dans le panneau de détail
      detailZone.innerHTML = `
        <h3>détail de la commande #${id}</h3>
        <p><strong>client :</strong> ${client}</p>
        <p><strong>date :</strong> ${date}</p>
        <p><strong>statut :</strong> <span id="statut">${statut}</span></p>
        <button id="update-status">mettre à jour le statut</button>
      `;

      // attache un event au bouton
      document.getElementById("update-status").addEventListener("click", () => {
        const span = document.getElementById("statut");
        span.textContent = "expédiée";
      });
    });
  });
});
