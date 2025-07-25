// Show/Hide Password
function togglePassword() {
  const passwordInput = document.getElementById('passwordField');
  const toggleIcon = document.getElementById('toggleIcon');
  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    toggleIcon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
  } else {
    passwordInput.type = 'password';
    toggleIcon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
  }
}

// Client-side Form Validation
function validateForm() {
  let errors = [];
  const form = document.getElementById('signupForm');

  const name = form.name.value.trim();
  const email = form.email.value.trim();
  const phone = form.phone.value.trim();
  const address = form.address.value.trim();
  const password = form.password.value.trim();

  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  if (name.length < 2) errors.push("Full name must be at least 2 characters.");
  if (!emailPattern.test(email)) errors.push("Enter a valid email address.");
  if (!/^[0-9]{10}$/.test(phone)) errors.push("Phone number must be exactly 10 digits.");
  if (address.length < 5) errors.push("Address must be at least 5 characters.");
  if (password.length < 6) errors.push("Password must be at least 6 characters.");

  const alertBox = document.getElementById("errorAlert");
  const errorMsg = document.getElementById("errorMsg");

  if (errors.length > 0) {
    alertBox.classList.remove("d-none");
    errorMsg.innerHTML = errors.map(err => `<div>${err}</div>`).join('');
  } else {
    alertBox.classList.add("d-none");
    errorMsg.innerHTML = '';
    form.setAttribute("method", "POST");
    form.submit();
  }
}
