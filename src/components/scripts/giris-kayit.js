(function () {
  "use strict";

  var EMAIL_REGEX = /^[A-Za-z0-9.!#$%&'*+/=?^_`{|}~-]+@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)+$/;
  var NAME_REGEX = /^[A-Za-zÇĞİÖŞÜçğıöşü\s'-]+$/;
  var PHONE_REGEX = /^05[0-9]{9}$/;

  function sanitizeEmail(value) {
    return (value || "").trim().replace(/\s+/g, "").slice(0, 254);
  }

  function sanitizeName(value, maxLen) {
    return (value || "")
      .replace(/\s+/g, " ")
      .replace(/^\s+/, "")
      .slice(0, maxLen || 120);
  }

  function sanitizePhone(value) {
    return (value || "").replace(/\D+/g, "").slice(0, 11);
  }

  function getErrorSlot(control) {
    if (control.type === "checkbox") {
      return control.closest(".auth-check") || control.parentElement;
    }
    return control.closest(".auth-field") || control.parentElement;
  }

  function getErrorNode(control) {
    var slot = getErrorSlot(control);
    if (!slot) return null;
    var cls = control.type === "checkbox" ? "auth-check-error" : "auth-field-error";
    var node = slot.querySelector("." + cls);
    if (!node) {
      node = document.createElement("p");
      node.className = cls;
      slot.appendChild(node);
    }
    return node;
  }

  function setError(control, message) {
    var node = getErrorNode(control);
    if (node) {
      node.textContent = message || "";
      node.style.display = message ? "block" : "none";
    }
    if (control.type !== "checkbox") {
      control.classList.toggle("auth-input--invalid", Boolean(message));
    }
  }

  function validateControl(control, form) {
    if (control.disabled) return true;
    var type = (control.type || "").toLowerCase();
    var tag = (control.tagName || "").toLowerCase();
    if (type === "hidden" || type === "button" || type === "submit" || type === "reset") return true;

    var value = control.value || "";
    var trimmed = typeof value === "string" ? value.trim() : value;
    var message = "";

    if (control.hasAttribute("data-auth-email")) {
      var email = sanitizeEmail(value);
      control.value = email;
      if (!email) {
        message = "E-posta alanı zorunludur.";
      } else if (email.length < 6 || email.length > 254 || !/^[\x21-\x7E]+$/.test(email) || !EMAIL_REGEX.test(email)) {
        message = "Geçerli bir e-posta adresi girin. Örnek: ornek@mail.com";
      }
    } else if (control.hasAttribute("data-auth-name")) {
      var maxLen = Number(control.getAttribute("maxlength")) || 120;
      var minLen = Number(control.getAttribute("minlength")) || 2;
      var name = sanitizeName(value, maxLen);
      control.value = name;
      if (!name) {
        message = "Ad soyad alanı zorunludur.";
      } else if (name.length < minLen) {
        message = "En az " + minLen + " karakter girin.";
      } else if (!NAME_REGEX.test(name)) {
        message = "Sayı kullanmadan, geçerli ad soyad girin.";
      }
    } else if (control.hasAttribute("data-auth-phone")) {
      var phone = sanitizePhone(value);
      control.value = phone;
      if (!phone) {
        message = "Telefon alanı zorunludur.";
      } else if (!PHONE_REGEX.test(phone)) {
        message = "Telefon 05 ile başlamalı ve 11 haneli olmalı.";
      }
    } else if (type === "checkbox" && control.required) {
      if (!control.checked) {
        message = "Devam etmek için bu onayı vermelisiniz.";
      }
    } else if (tag === "select" && control.required) {
      if (!trimmed) {
        message = "Lütfen bir seçenek belirleyin.";
      }
    } else {
      if (control.required && !trimmed) {
        message = "Bu alan zorunludur.";
      } else if (trimmed && control.minLength > 0 && trimmed.length < control.minLength) {
        message = "En az " + control.minLength + " karakter girin.";
      } else if (trimmed && control.maxLength > 0 && trimmed.length > control.maxLength) {
        message = "En fazla " + control.maxLength + " karakter girin.";
      }
    }

    if (!message && control.id === "auth-register-password-repeat") {
      var pass = form.querySelector("#auth-register-password");
      if (pass && control.value !== pass.value) {
        message = "Şifreler birbiriyle aynı olmalıdır.";
      }
    }

    control.setCustomValidity(message || "");
    setError(control, message);
    return !message;
  }

  function wireFormValidation(form) {
    var controls = form.querySelectorAll("input, select, textarea");
    controls.forEach(function (control) {
      control.addEventListener("input", function () {
        if (control.hasAttribute("data-auth-email")) control.value = sanitizeEmail(control.value);
        if (control.hasAttribute("data-auth-name")) control.value = sanitizeName(control.value, Number(control.getAttribute("maxlength")) || 120);
        if (control.hasAttribute("data-auth-phone")) control.value = sanitizePhone(control.value);
        if (control.classList.contains("auth-input--invalid")) validateControl(control, form);
      });
      control.addEventListener("blur", function () {
        validateControl(control, form);
      });
      if ((control.type || "").toLowerCase() === "checkbox" || (control.tagName || "").toLowerCase() === "select") {
        control.addEventListener("change", function () {
          validateControl(control, form);
        });
      }
    });

    form.addEventListener("submit", function (event) {
      var firstInvalid = null;
      controls.forEach(function (control) {
        var ok = validateControl(control, form);
        if (!ok && !firstInvalid) firstInvalid = control;
      });
      if (firstInvalid) {
        event.preventDefault();
        firstInvalid.focus();
      }
    });
  }

  document.querySelectorAll(".auth-form").forEach(wireFormValidation);

  var legalOpenBtns = document.querySelectorAll("[data-open-auth-legal]");
  var legalDialog = document.getElementById("authLegalDialog");
  if (legalDialog && typeof legalDialog.showModal === "function" && legalOpenBtns.length) {
    var closeLegal = function () {
      if (legalDialog.open) legalDialog.close();
    };
    legalOpenBtns.forEach(function (btn) {
      btn.addEventListener("click", function () {
        legalDialog.showModal();
      });
    });
    legalDialog.querySelectorAll("[data-close-auth-legal]").forEach(function (btn) {
      btn.addEventListener("click", closeLegal);
    });
    legalDialog.addEventListener("cancel", function (event) {
      event.preventDefault();
      closeLegal();
    });
    legalDialog.addEventListener("click", function (event) {
      if (event.target === legalDialog) closeLegal();
    });
  }
})();
