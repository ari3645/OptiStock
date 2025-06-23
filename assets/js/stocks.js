console.log("fichier JS bien chargé");

document.addEventListener("DOMContentLoaded", () => {
  const table = document.querySelector(".stock-table");
  console.log("tableau trouvé :", table);

  table.addEventListener("click", (e) => {
    console.log("🖱️ bouton cliqué !");

    // Mode édition
    if (e.target.classList.contains("btn-edit")) {
      const row = e.target.closest("tr");

      // si déjà en mode édition on fait rien
      if (row.classList.contains("editing")) return;

      // sinon on passe en mode édition
      row.classList.add("editing");

      const cells = row.querySelectorAll("td");
      const currentValues = {
        produit: cells[0].textContent.trim(),
        quantite: cells[1].textContent.trim(),
        alerte: cells[2].textContent.trim(),
        categorie: cells[3].textContent.trim()
      };

      // remplaces each cell par un input/select
      cells[0].innerHTML = `<input type="text" value="${currentValues.produit}" />`;
      cells[1].innerHTML = `<input type="number" min="0" value="${currentValues.quantite}" />`;
      cells[2].innerHTML = `<input type="number" min="0" value="${currentValues.alerte}" />`;
      
      // CORRECTION: Ajouter toutes les catégories possibles dans le select
      cells[3].innerHTML = `
        <select>
          <option value="vêtements" ${currentValues.categorie === "vêtements" ? "selected" : ""}>vêtements</option>
          <option value="haut" ${currentValues.categorie === "haut" ? "selected" : ""}>haut</option>
          <option value="bas" ${currentValues.categorie === "bas" ? "selected" : ""}>bas</option>
        </select>`;
        
      console.log("test select HTML:", cells[3].innerHTML);

      // bouton devient "save"
      e.target.textContent = "enregistrer";
      e.target.classList.remove("btn-edit");
      e.target.classList.add("btn-save");
    }
    
    // CORRECTION: Utiliser else if au lieu de if séparé
    else if (e.target.classList.contains("btn-save")) {
      const row = e.target.closest("tr");
      const inputs = row.querySelectorAll("input, select");

      // récup les nouvelles valeurs
      const updated = Array.from(inputs).map(input => input.value);

      // remplacer les cellules with new values
      const cells = row.querySelectorAll("td");
      cells[0].textContent = updated[0];
      cells[1].textContent = updated[1];
      cells[2].textContent = updated[2];
      cells[3].textContent = updated[3];

      // bouton redevient "modifier"
      e.target.textContent = "modifier";
      e.target.classList.remove("btn-save");
      e.target.classList.add("btn-edit");

      row.classList.remove("editing");

      // ici on peut faire un fetch/ajax pour envoyer ça au serveur
      console.log("données modifiées :", updated);
    }
  });
});