// -------- Connexion par rôle (fake login test) --------

const users = {
  'admin': { password: 'admin123', role: 'admin' },
  'gestionnaire': { password: 'gest123', role: 'gestionnaire' },
  'commercial': { password: 'com123', role: 'commercial' },
  'employe': { password: 'emp123', role: 'employe' }
};

const loginForm = document.getElementById('loginForm');
if (loginForm) {
  loginForm.addEventListener('submit', function(e) {
    e.preventDefault();

    const username = document.getElementById('username').value.toLowerCase();
    const password = document.getElementById('password').value;
    const errorMessage = document.getElementById('errorMessage');

    if (users[username] && users[username].password === password) {
      localStorage.setItem('currentUser', JSON.stringify({
        username: username,
        role: users[username].role
      }));

      switch(users[username].role) {
        case 'admin':
          window.location.href = 'admin_menu.html';
          break;
        case 'gestionnaire':
          window.location.href = 'gestionnaire_menu.html';
          break;
        case 'commercial':
          window.location.href = 'commercial_menu.html';
          break;
        case 'employe':
          window.location.href = 'employee_menu.html';
          break;
      }
    } else {
      errorMessage.classList.add('show');
      document.getElementById('username').style.borderColor = '#FF0000';
      document.getElementById('password').style.borderColor = '#FF0000';

      setTimeout(() => {
        errorMessage.classList.remove('show');
        document.getElementById('username').style.borderColor = '#C9F7F5';
        document.getElementById('password').style.borderColor = '#C9F7F5';
      }, 3000);
    }
  });

  document.getElementById('username').addEventListener('input', function () {
    document.getElementById('errorMessage').classList.remove('show');
    this.style.borderColor = '#C9F7F5';
  });

  document.getElementById('password').addEventListener('input', function () {
    document.getElementById('errorMessage').classList.remove('show');
    this.style.borderColor = '#C9F7F5';
  });
}

// -------- Validation formulaire d'inscription --------

const registerForm = document.getElementById('register-form');
if (registerForm) {
  registerForm.addEventListener('submit', function (event) {
    let valid = true;

    const fullname = document.getElementById('fullname');
    const email = document.getElementById('email');
    const phone = document.getElementById('phone');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm-password');
    const terms = document.getElementById('terms');

    document.querySelectorAll('.error-message').forEach(e => e.style.display = 'none');

    if (!fullname.value.trim()) {
      document.getElementById('fullname-error').style.display = 'block';
      valid = false;
    }

    if (!email.validity.valid) {
      document.getElementById('email-error').style.display = 'block';
      valid = false;
    }

    if (!phone.validity.valid) {
      document.getElementById('phone-error').style.display = 'block';
      valid = false;
    }

    if (password.value.length < 8 || !/[0-9\W]/.test(password.value)) {
      document.getElementById('password-error').style.display = 'block';
      valid = false;
    }

    if (confirmPassword.value !== password.value) {
      document.getElementById('confirm-password-error').style.display = 'block';
      valid = false;
    }

    if (!terms.checked) {
      document.getElementById('terms-error').style.display = 'block';
      valid = false;
    }

    if (!valid) event.preventDefault();
  });
}

// -------- Redirection après inscription réussie --------

if (document.body.classList.contains('register-success-page')) {
  setTimeout(() => {
    window.location.href = "login.html";
  }, 5000);
}

// -------- Actions génériques --------

document.querySelectorAll('.btn.primary').forEach(button => {
  button.addEventListener('click', () => {
    button.classList.add('clicked');
    console.log(`Action validée : ${button.textContent}`);
  });
});
