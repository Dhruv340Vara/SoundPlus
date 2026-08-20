<!-- forgot Passsowrd -->


<?php

session_start();

include('../includes/admin_db_connect.php');

if($_SERVER['REQUEST_METHOD']==='POST'){

    $username=isset($_POST['username'])?trim($_POST['username']) : '';
    $newPassword=isset($_POST['new_password'])?trim($_POST['new_password']) : '';

    if(empty($username) || empty($newPassword)){
        $message="Please Fill in all Fields.";
    }
    else{
        //Update the password in the database without hashing

        $query="UPDATE admins SET password=? WHERE username=?";
        $stmt=$conn->prepare($query);

        $stmt->bind_param("ss",$newPassword,$username);

        if($stmt->execute() && $stmt->affected_rows>0){
            $message="Password Reset Sucessfully.";
        }
         else
         {
                $message="No account found with this username."; 
            }
           
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #2c3e50;
    background-size: 100% 100%;
    animation: gradient-animation 15s ease infinite; /
}

/* Gradient Animation */
@keyframes gradient-animation {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Login Container Styling */
.login-container {
    width: 380px;
    padding: 25px 30px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
    backdrop-filter: blur(15px);
    position: relative;
    overflow: hidden;
    animation: fadeInUp 1.5s ease-out;
}

/* Fade-in Animation */
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(50px); }
    100% { opacity: 1; transform: translateY(0); }
}

/* Heading Style */
.login-container h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #ff0000;
    font-size: 30px;
    letter-spacing: 1px;
}

/* Input Field Styling */
.login-container .input-group {
    position: relative;
    margin-bottom: 20px;
}

.login-container .input-group input {
    width: 94%;
    padding: 12px 15px;
    border: 1px solid rgba(0, 0, 0, 0.5);
    border-radius: 10px;
    background: transparent;
    color: white;
    font-size: 16px;
    outline: none;
    transition: 0.3s;
}

/* Floating Label Styling */
.login-container .input-group label {
    position: absolute;
    top: 12px;
    left: 15px;
    font-size: 14px;
    color: rgba(0, 0, 0, 0.7);
    pointer-events: none;
    transition: 0.3s;
}

.login-container .input-group input:focus + label,
.login-container .input-group input:not(:placeholder-shown) + label {
    top: -8px;
    left: 10px;
    font-size: 12px;
    color: #38bdf8;
    background: #1e293b;
    padding: 0 5px;
    border-radius: 5px;
}

/* Button Styling */
.login-container .btn {
    width: 100%;
    padding: 14px 0;
    border: none;
    border-radius: 10px;
    background:linear-gradient(135deg, green, #1d4ed8);
    color: #fff;
    font-size: 18px;
    cursor: pointer;
    transition: 0.3s;
    box-shadow: 0 8px 15px rgba(56, 189, 248, 0.3);
}

.login-container .btn:hover {
    background: linear-gradient(135deg, #1e40afd8, #1d4fd8c5);
    transform: scale(1.05);
    
}
/* Forgot Password Button */
.forgot-btn {
    width: 100%;
    margin-top: 15px;
    padding: 12px 0;
    border: none;
    border-radius: 5px;
    background: linear-gradient(90deg, #f97316, #fb923c);
    color: #fff;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
}

.forgot-btn:hover {
    background: linear-gradient(90deg, #fb923c, #f97316);
    transform: translateY(-2px);
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.3);
}

p{
    color:white;
    text-align:center;
    font-size:20px;
}



</style>
</head>
<body>
<div class="login-container">
    <h2>Forgot password</h2>
    <p>Admin Your username</p>
    <form action="" method="post">
        <div class="input-group ">
        <input type="text" name="username" placeholder="Enter you username" required>
        </div>
        <div class="input-group ">
        <input type="password" name="new_password" placeholder="Enter new password" required> 
        </div>
        <button type="submit" class="btn">Reset password</button>
    </form>
    <?php if(isset($message)):?>
        <p class="message <?php echo strpos($message,'successfully') !== false ? 'success' : '';?>"> 
     <?php echo $message;?>
        </p>

        <?php endif;?>
        <div style="margin-top:15px"><a href="login.php"><button class="btn">Back To Login</button></a></div>
</div> 
</body>
</html>
