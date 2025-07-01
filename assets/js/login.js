// login.js
// valid minimaliste du formulaire avant PHP

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('loginForm');
  const uErr = document.getElementById('err-username');
  const pErr = document.getElementById('err-password');

  form.addEventListener('submit', e => {
    let ok = true;
    uErr.textContent = pErr.textContent = '';

    if (!form.username.value.trim()) {
      uErr.textContent = 'champ requis';
      ok = false;
    }
    if (!form.password.value) {
      pErr.textContent = 'champ requis';
      ok = false;
    }
    if (!ok) e.preventDefault();
    // sinon, on soumet et le PHP (commenté) traitera la connexion
  });

  document.getElementById('forgot-user').onclick = () => {
    alert('Contacte ton admin pour récupérer ton identifiant.');
  };
  document.getElementById('forgot-pass').onclick = () => {
    alert('Contacte ton admin pour réinitialiser ton mot de passe.');
  };
});
