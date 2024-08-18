const customSelect = document.querySelector(".custom-select");
const selectBtn = document.querySelector(".select-button");
const selectedValue = document.querySelector(".selected-value");
const optionsList = document.querySelectorAll(".select-dropdown li");

// Add click event to select button
selectBtn.addEventListener("click", () => {
    customSelect.classList.toggle("active");
    selectBtn.setAttribute("aria-expanded", customSelect.classList.contains("active") ? "true" : "false");
});

// Add event listeners to each option
optionsList.forEach((option) => {
    option.addEventListener("click", function() {
        selectedValue.textContent = this.textContent.trim(); // Update selected value text
        customSelect.classList.remove("active");

        // Update hidden input value (if needed)
        const radioInput = this.querySelector('input[type="radio"]');
        if (radioInput) {
            radioInput.checked = true;
        }

        // Perform additional actions if needed, such as submitting form
        // Example: document.querySelector("form").submit();
    });
});

// Validate form before submission
const form = document.getElementById("profile-form");

form.addEventListener("submit", function(event) {
    const name = document.getElementById("name").value;
    const birthdate = document.getElementById("birthdate").value;
    const phone = document.getElementById("phone").value;
    const area = document.querySelector('input[name="area"]:checked');
    const room_number = document.getElementById("room_number").value;

    const errorMessages = [];

    if (name.trim() === "") {
        errorMessages.push("Name is required");
    }

    if (birthdate.trim() === "") {
        errorMessages.push("Birthdate is required");
    }

    if (phone.trim() === "") {
        errorMessages.push("Phone number is required");
    }

    if (!area) {
        errorMessages.push("Area is required");
    }

    if (room_number.trim() === "") {
        errorMessages.push("Room number is required");
    }

    if (errorMessages.length > 0) {
        event.preventDefault(); // Prevent form submission

        // Display error messages in a popup
        alert(errorMessages.join("\n"));

        // Optionally, display error messages on the page
        const errorContainer = document.querySelector(".error-messages");
        errorContainer.innerHTML = "";
        errorMessages.forEach(message => {
            const p = document.createElement("p");
            p.textContent = message;
            errorContainer.appendChild(p);
        });
    }
});
