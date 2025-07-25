function validateUpdateForm() {
  const form = document.getElementById("updateForm");
  const alertBox = document.getElementById("alertBox");
  const alertMessage = document.getElementById("alertMessage");
  const errors = [];

  if (form.name.value.trim().length < 2) errors.push("Name must be at least 2 characters.");
  if (!form.category.value) errors.push("Category is required.");
  if (form.location.value.trim().length < 2) errors.push("Location is required.");
  if (form.timeslot.value.trim().length < 2) errors.push("Timeslot is required.");
  if (!form.hourly_rate.value || parseFloat(form.hourly_rate.value) <= 0) errors.push("Hourly rate must be a positive number.");
  if (!form.experience.value || parseInt(form.experience.value) < 0) errors.push("Experience must be a valid number.");
  if (form.aadhaar_number.value.trim().length < 8) errors.push("Aadhaar number must be at least 8 characters.");

  if (errors.length > 0) {
    alertBox.classList.remove("d-none");
    alertMessage.innerHTML = errors.map(err => `<div>${err}</div>`).join('');
  } else {
    alertBox.classList.add("d-none");
    form.submit();
  }
}
