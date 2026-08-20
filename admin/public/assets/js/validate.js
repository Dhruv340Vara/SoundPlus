    //signup validation start 
    
        // Live Validation Setup
        window.onload = function () {
            // Input Fields
            const username = document.getElementById("username");
            const email = document.getElementById("email");
            const mobile = document.getElementById("mobile");
            const password = document.getElementById("password");
            const confirmPassword = document.getElementById("confirmPassword");
    
            // Error Elements
            const usernameError = document.getElementById("usernameError");
            const emailError = document.getElementById("emailError");
            const mobileError = document.getElementById("mobileError");
            const passwordError = document.getElementById("passwordError");
            const confirmPasswordError = document.getElementById("confirmPasswordError");

            // Username Validation (3-10 characters, must include '@', only alphanumeric + @)
            const usernameRegex = /^[a-zA-Z0-9@]{3,10}$/;
            username.addEventListener("input", function () {
            const usernameValue = username.value.trim();
            if (!usernameRegex.test(usernameValue) || !usernameValue.includes('@')) {
             usernameError.textContent = "Username must be 3-10 characters long, include '@', and contain only letters, numbers, and '@'.";
             } else {
            usernameError.textContent = ""; // Clear error when valid
             }
            });

    
            // Email Validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            email.addEventListener("input", function () {
                if (!emailRegex.test(email.value.trim())) {
                    emailError.textContent = "Please enter a valid email address.";
                } else {
                    emailError.textContent = "";
                }
            });
    
            // Mobile Validation
            const mobileRegex = /^[0-9]{10}$/;
            mobile.addEventListener("input", function () {
                this.value = this.value.replace(/\D/g, ''); // Allow only digits
                if (this.value.length === 10 && mobileRegex.test(this.value)) {
                    mobileError.textContent = ""; // Valid mobile number
                } else if (this.value.length > 10) {
                    mobileError.textContent = "Mobile number must not exceed 10 digits.";
                } else if (this.value.length < 10 && this.value.length > 0) {
                    mobileError.textContent = "Mobile number must be exactly 10 digits.";
                } else {
                    mobileError.textContent = ""; // Clear error if empty
                }
            });
    
            // Password Validation
            const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            password.addEventListener("input", function () {
                if (!passwordRegex.test(password.value.trim())) {
                    passwordError.textContent =
                        "Password must be at least 8 characters long, include an uppercase letter, a number, and a special character.";
                } else {
                    passwordError.textContent = "";
                }
            });
    
            // Confirm Password Validation
            confirmPassword.addEventListener("input", function () {
                if (confirmPassword.value !== password.value) {
                    confirmPasswordError.textContent = "Passwords do not match.";
                } else {
                    confirmPasswordError.textContent = "";
                }
            });
        };
    
        // Final Validation on Form Submit
        function validateForm() {
            let isValid = true;
    
            // Input Fields
            const username = document.getElementById("username");
            const email = document.getElementById("email");
            const mobile = document.getElementById("mobile");
            const password = document.getElementById("password");
            const confirmPassword = document.getElementById("confirmPassword");
    
            // Error Elements
            const usernameError = document.getElementById("usernameError");
            const emailError = document.getElementById("emailError");
            const mobileError = document.getElementById("mobileError");
            const passwordError = document.getElementById("passwordError");
            const confirmPasswordError = document.getElementById("confirmPasswordError");
    
            // Username Validation (Only letters, numbers, and must include '@', 3-10 characters long)
            const usernameRegex = /^[a-zA-Z0-9@]{3,10}$/;
            if (!usernameRegex.test(username.value.trim()) || !username.value.includes('@')) {
            usernameError.textContent = "Username must be 3-10 characters long, and include '@' along with only letters, numbers, and '@'.";
            isValid = false;
            } else {
            usernameError.textContent = ""; // Clear error if valid
            }

    
            // Email Validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email.value.trim())) {
                emailError.textContent = "Please enter a valid email address.";
                isValid = false;
            }
    
            // Mobile Validation
            const mobileRegex = /^[0-9]{10}$/;
            if (!mobileRegex.test(mobile.value.trim())) {
                mobileError.textContent = "Mobile number must be exactly 10 digits.";
                isValid = false;
            }
    
            // Password Validation
            const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            if (!passwordRegex.test(password.value.trim())) {
                passwordError.textContent =
                    "Password must be at least 8 characters long, include an uppercase letter, a number, and a special character.";
                isValid = false;
            }
    
            // Confirm Password Validation
            if (confirmPassword.value !== password.value) {
                confirmPasswordError.textContent = "Passwords do not match.";
                isValid = false;
            }
    
            return isValid; // Submit form if valid
        }


        //signup end
    

