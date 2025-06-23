document.addEventListener("DOMContentLoaded", () => {
    const paysSelect = document.getElementById("pays");
    const villeSelect = document.getElementById("ville");

    fetch("pays_villes.json")
      .then(res => res.json())
      .then(data => {
        // Load countries
        Object.keys(data).forEach(country => {
          const option = document.createElement("option");
          option.value = country;
          option.textContent = country;
          paysSelect.appendChild(option);
        });

        // Load cities based on selected country
        paysSelect.addEventListener("change", () => {
          const selectedCountry = paysSelect.value;
          const cities = data[selectedCountry] || [];

          // Clear and reload city options
          villeSelect.innerHTML = '<option value="" disabled selected>-- Choisir une ville --</option>';
          cities.forEach(city => {
            const option = document.createElement("option");
            option.value = city;
            option.textContent = city;
            villeSelect.appendChild(option);
          });
        });
      })
      .catch(error => {
        console.error("Erreur de chargement du fichier JSON:", error);
      });
  });




      


function togglePassword(inputId, toggleButton) {
    const input = document.getElementById(inputId);
    const icon = toggleButton.querySelector('i');

    if (input.type === "password") {
      input.type = "text";
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
    } else {
      input.type = "password";
      icon.classList.remove("fa-eye-slash");
      icon.classList.add("fa-eye");
    }
  }