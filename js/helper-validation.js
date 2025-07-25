function validateHelperForm() {
  const form = document.getElementById('helperForm');
  const alertBox = document.getElementById('alertBox');
  const alertMsg = document.getElementById('alertMessage');
  let errors = [];

  const name = form.name.value.trim();
  const category = form.category.value;
  const location = form.location.value.trim();
  const timeslot = form.timeslot.value.trim();
  const hourly = form.hourly_rate.value;
  const exp = form.experience.value;
  const aadhaar = form.aadhaar_number.value.trim();
  const profile = form.profile_image.value;
  const aadhaar_file = form.aadhaar_file.value;
  const address_proof = form.address_proof.value;

  if (name.length < 2) errors.push("Name must be at least 2 characters.");
  if (!category) errors.push("Category is required.");
  if (location.length < 2) errors.push("Location is required.");
  if (timeslot.length < 2) errors.push("Timeslot is required.");
  if (!hourly || parseFloat(hourly) <= 0) errors.push("Hourly rate must be positive.");
  if (!exp || parseInt(exp) < 0) errors.push("Experience must be a valid number.");
  if (aadhaar.length < 8) errors.push("Aadhaar number must be at least 8 characters.");
  if (!profile) errors.push("Profile image is required.");
  if (!aadhaar_file) errors.push("Aadhaar file is required.");
  if (!address_proof) errors.push("Address proof is required.");

  if (errors.length > 0) {
    alertBox.classList.remove("d-none", "alert-success");
    alertBox.classList.add("alert-danger");
    alertMsg.innerHTML = errors.map(err => `<div>${err}</div>`).join('');
  } else {
    alertBox.classList.add("d-none");
    form.submit();
  }
}
