function validateForm() {
    var password = document.getElementById("password").value;
    
    // Check password length
    if (password.length < 8) {
        alert("Password must be at least 8 characters long.");
        return false;
    }
    
    // Check if password contains at least one digit
    if (!/\d/.test(password)) {
        alert("Password must contain at least one digit (0-9).");
        return false;
    }
    
    return true;
}

document.addEventListener('DOMContentLoaded', function () {
    var selects = document.querySelectorAll('.user-form select');

    selects.forEach(function (select) {
        select.addEventListener('focus', function () {
            this.nextElementSibling.classList.add('active');
        });

        select.addEventListener('blur', function () {
            if (!this.value) {
                this.nextElementSibling.classList.remove('active');
            }
        });

        // Trigger the focus event to move the label if the select has a value on page load
        if (select.value) {
            select.dispatchEvent(new Event('focus'));
        }
    });
});

function validateForm() {
    // Validasi form dapat ditambahkan di sini
    return true;
}

document.addEventListener('DOMContentLoaded', function () {
    const selectElement = document.querySelector('#area');
    const labelElement = selectElement.nextElementSibling;

    selectElement.addEventListener('change', function () {
        if (this.value) {
            labelElement.style.top = '-20px';
            labelElement.style.left = '0';
            labelElement.style.color = '#949494';
            labelElement.style.fontSize = '12px';
        } else {
            labelElement.style.top = '0';
            labelElement.style.left = '0';
            labelElement.style.color = '#000';
            labelElement.style.fontSize = '16px';
        }
    });
});

function validateForm() {
    const phone = document.getElementById('phone').value;
    const phonePattern = /^[0-9]{10,14}$/;

    if (!phonePattern.test(phone)) {
        alert('Please enter a valid phone number.');
        return false;
    }

    // Add more validation if needed

    return true;
}

document.addEventListener('DOMContentLoaded', function() {
    // Show success or error notification based on PHP response
    var successMessage = "<?php echo $success; ?>";
    var errorMessage = "<?php echo $error; ?>";
    
    if (successMessage) {
        document.getElementById('success-box').style.display = 'block';
    }
    
    if (errorMessage) {
        document.getElementById('error-box').style.display = 'block';
    }
});

