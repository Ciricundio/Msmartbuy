document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("form");
  const inputs = form.querySelectorAll("input, select");
  const password = document.getElementById("password");
  const passwordCheck = document.getElementById("password_check");
  const btn = document.getElementById("btn");

  const createOrUpdateMessage = (input, id, message) => {
    let msg = document.getElementById(id);
    if (!msg) {
      msg = document.createElement("small");
      msg.id = id;
      msg.classList.add("text-danger");
      input.parentNode.appendChild(msg);
    }
    msg.textContent = message;
  };

  const removeMessage = (id) => {
    const el = document.getElementById(id);
    if (el) el.remove();
  };

  const isPasswordValid = () => {
    const value = password.value;

    if (value.length < 8) {
      createOrUpdateMessage(password, "msg-password", "Debe tener al menos 8 caracteres.");
      password.focus();
      return false;
    }

    if (!/\d/.test(value)) {
      createOrUpdateMessage(password, "msg-password", "Debe incluir al menos un número.");
      password.focus();
      return false;
    }

    if (!/[!@#$%^&*(),.?":{}|<>]/.test(value)) {
      createOrUpdateMessage(password, "msg-password", "Debe incluir un carácter especial.");
      password.focus();
      return false;
    }

    removeMessage("msg-password");
    return true;
  };

  const isConfirmationValid = () => {
    if (passwordCheck.value !== password.value) {
      createOrUpdateMessage(passwordCheck, "msg-confirm", "Las contraseñas no coinciden.");
      passwordCheck.focus();
      return false;
    }
    removeMessage("msg-confirm");
    return true;
  };

  const areAllFieldsFilled = () => {
    let allFilled = true;
    inputs.forEach(input => {
      if (input.type !== "submit" && input.value.trim() === "") {
        allFilled = false;
      }
    });
    return allFilled;
  };

  const updateButtonState = () => {
    if (areAllFieldsFilled() && isPasswordValid() && isConfirmationValid()) {
      btn.disabled = false;
    } else {
      btn.disabled = true;
    }
  };

  // Eventos en tiempo real
  inputs.forEach(input => {
    input.addEventListener("input", () => {
      updateButtonState();
    });
  });
});
