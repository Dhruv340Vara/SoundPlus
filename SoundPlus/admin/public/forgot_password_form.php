<?php
$userId=isset($_GET['user_id']) ? $_GET['user_id']:'';
$userId=htmlspecialchars($userId)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .error{
            color:red;
            font-size:14px;
            margin-top:5px;
        }
        .success{
            color:green;
            font-size:14px;
            margin-top:5px;
        }
    </style>
</head>
<body>
    <div class="login-container">
    <h2>Reset password</h2>
    <form action="reset_password_process.php" method="post" onsubmit="return validatePassword()"> 
    <input type="hidden" name="user_id" value="<?php echo$userId; ?>">

    <div class="input-group">
        <label for="new_password"></label>
        <input type="password" name="new_password" id="new_password" placeholder="Enter new password" required>
        <div id="passwordError" class="error"> </div>
        <div id="passwordSuccess" class="success"> </div>
    </div>
<button type="submit" class="btn">Reset Password</button>
    </form>
    <div class="login-link">Remebered Your Password? <a href="login.html">Login</a></div>
    </div>
    

<script>
        //forgot_passworf form
        // Password Live Validation
        const passwordInput = document.getElementById("new_password");
        const passwordError = document.getElementById("passwordError");
        const passwordSuccess = document.getElementById("passwordSuccess");

        // Password strength criteria: at least 8 characters, 1 uppercase, 1 number, 1 special character
        const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

        passwordInput.addEventListener("input", function () {
            const password = passwordInput.value.trim();

            if (!passwordRegex.test(password)) {
                passwordError.textContent =
                    "Password must be at least 8 characters long, include an uppercase letter, a number, and a special character.";
                passwordSuccess.textContent = "";
            } else {
                passwordError.textContent = "";
                passwordSuccess.textContent = "Password meets the criteria.";
            }
        });

        // Final validation on form submission
        function validatePassword() {
            const password = passwordInput.value.trim();

            if (!passwordRegex.test(password)) {
                passwordError.textContent =
                    "Password must be at least 8 characters long, include an uppercase letter, a number, and a special character.";
                passwordSuccess.textContent = "";
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }
    //end</script>
    
</body>
</html>