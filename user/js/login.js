// script.js

// Example: Handle form submission
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    // Add your form submission logic here
    alert('Form submitted');
    
    // Toggle illustration sliding
    document.querySelector('.illustration img').classList.toggle('active');
});

document.getElementById('toSignup').addEventListener('click', () => {
    document.querySelector('.login-container').style.transform = 'translateX(-100%)';
    document.querySelector('.signup-container').style.transform = 'translateX(0)';
});

document.getElementById('toLogin').addEventListener('click', () => {
    document.querySelector('.login-container').style.transform = 'translateX(0)';
    document.querySelector('.signup-container').style.transform = 'translateX(100%)';
});

function validateForm() {
    var username = document.getElementById("username").value.trim();
    var password = document.getElementById("password").value.trim();

    if (username === "" || password === "") {
        alert("Please fill in all fields.");
        return false;
    }

    return true;
}
