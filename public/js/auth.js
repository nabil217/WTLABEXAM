

document.addEventListener('DOMContentLoaded', function () {

    
    var loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            var valid = true;

            var email = document.getElementById('email');
            var emailError = document.getElementById('email-error');
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!email.value.trim()) {
                emailError.textContent = 'Email is required.';
                valid = false;
            } else if (!emailRegex.test(email.value.trim())) {
                emailError.textContent = 'Enter a valid email address.';
                valid = false;
            } else {
                emailError.textContent = '';
            }

            var password = document.getElementById('password');
            var passwordError = document.getElementById('password-error');
            if (!password.value) {
                passwordError.textContent = 'Password is required.';
                valid = false;
            } else {
                passwordError.textContent = '';
            }

            if (!valid) e.preventDefault();
        });
    }

    
    var registerForm = document.getElementById('register-form');
    if (registerForm) {
        registerForm.addEventListener('submit', function (e) {
            var valid = true;
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            
            var name = document.getElementById('name');
            var nameError = document.getElementById('name-error');
            if (!name.value.trim()) {
                nameError.textContent = 'Full name is required.';
                valid = false;
            } else if (name.value.trim().length < 2) {
                nameError.textContent = 'Name must be at least 2 characters.';
                valid = false;
            } else {
                nameError.textContent = '';
            }

            
            var email = document.getElementById('email');
            var emailError = document.getElementById('email-error');
            if (!email.value.trim()) {
                emailError.textContent = 'Email is required.';
                valid = false;
            } else if (!emailRegex.test(email.value.trim())) {
                emailError.textContent = 'Enter a valid email address.';
                valid = false;
            } else {
                emailError.textContent = '';
            }

            
            var password = document.getElementById('password');
            var passwordError = document.getElementById('password-error');
            if (!password.value) {
                passwordError.textContent = 'Password is required.';
                valid = false;
            } else if (password.value.length < 8) {
                passwordError.textContent = 'Password must be at least 8 characters.';
                valid = false;
            } else {
                passwordError.textContent = '';
            }

        
            var confirm = document.getElementById('confirm_password');
            var confirmError = document.getElementById('confirm-error');
            if (!confirm.value) {
                confirmError.textContent = 'Please confirm your password.';
                valid = false;
            } else if (confirm.value !== password.value) {
                confirmError.textContent = 'Passwords do not match.';
                valid = false;
            } else {
                confirmError.textContent = '';
            }

            if (!valid) e.preventDefault();
        });

        
        var confirmInput = document.getElementById('confirm_password');
        if (confirmInput) {
            confirmInput.addEventListener('input', function () {
                var password = document.getElementById('password').value;
                var confirmError = document.getElementById('confirm-error');
                if (this.value && this.value !== password) {
                    confirmError.textContent = 'Passwords do not match.';
                } else {
                    confirmError.textContent = '';
                }
            });
        }
    }

});
