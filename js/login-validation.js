function validateLoginForm() {
  const form = document.getElementById('loginForm');
  const email = form.email.value.trim();
  const password = form.password.value.trim();
  const role = form.role.value.trim();
  const errorBox = document.getElementById('clientError');
  const errorMsg = document.getElementById('clientMsg');

  let errors = [];

  // Email validation
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!email || !emailRegex.test(email)) {
    errors.push("Please enter a valid email address.");
  }

  // Password validation
  if (!password || password.length < 6) {
    errors.push("Password must be at least 6 characters long.");
  }

  // Role validation
  if (!role) {
    errors.push("Please select a role.");
  }

  // Show errors or submit form
  if (errors.length > 0) {
    errorMsg.innerHTML = errors.map(e => `<div>${e}</div>`).join('');
    errorBox.classList.remove("d-none");
  } else {
    errorBox.classList.add("d-none");
    form.submit(); // ✅ Submit only when all checks pass
  }
}

function togglePassword() {
  const pwdField = document.getElementById('passwordField');
  const toggleIcon = document.getElementById('toggleIcon');
  if (pwdField.type === 'password') {
    pwdField.type = 'text';
    toggleIcon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
  } else {
    pwdField.type = 'password';
    toggleIcon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
  }
}
