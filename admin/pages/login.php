<!-- Login Page for Admin -->

<?php 

session_start();

include('../includes/admin_db_connect.php'); //Database Connection

if($_SERVER['REQUEST_METHOD']=='POST')
{
    $username=$_POST['username'];
    $password=$_POST['password'];

    $query="SELECT * FROM admins WHERE username=? AND password=?";
    $stmt=$conn->prepare($query);
    $stmt->bind_param("ss",$username,$password);
    $stmt->execute();
    $result=$stmt->get_result();


    if($result->num_rows>0)
    {
        $_SESSION['admin']=$username;
        header('Location: dashbord.php');
    }
    else
    {
        $error="Password Or Username Are incorrect?";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
     *{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: 'Poppins',sans-serif;
}

body{
    height:100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(-45deg,#1e293b,#334155,#475569,#64748b);
    background-size: 400% 400%;
    animation:gradient-animation 10s ease infinite;
}

@keyframes gradient-animation{
    0%{background-position: 0% 50%;}
    50%{background-position: 100% 50%;}
    100%{background-position: 0% 50%;}
}

.login-container{
    width:380px;
    padding:40px 30px;
    background:rgba(255,255,255,0.1);
    border-radius:10px;
    box-shadow:0 8px 20px rgba(0,0,0,0.3);
    backdrop-filter:blur(10px);
    position:relative:
    overflow:hidden:
}


/* Input Field Styling */
.login-container .input-group {
    position: relative;
    margin-bottom: 20px;
}

.login-container .input-group input {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid rgba(0, 0, 0, 0.5);
    border-radius: 10px;
    background: transparent;
    color: #000000;
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

}

.login-container .btn:hover {
    background: linear-gradient(135deg, green, #1d4fd8c5);
    transform: scale(1.05);
    
}
/* Forgot Password Button */
.forgot-link 
{

    margin-top: 20px;
    text-align: center;
    font-size: 20px;
    color: rgba(0, 0, 0, 0.7);
 
}
.forgot-link a{
    color: #f83838;
    text-decoration: none;

}

.forgot-link:hover a{
    
color:blue;
text-decoration: none;

   
}

</style>

    
</head>
<body>
    <div class="login-container">
       
        <h2 style="margin-left:80px; margin-bottom:30px;">Admin Login</h2>

        <form action="" method="POST">

        <?php if(isset($error)){echo "<p class='error'>$error</p>";}?>

        <div class="input-group">
            <input type="text" name="username" required placeholder="">
            <label for="username">Username</label>
        </div>
        <div class="input-group">
            <input type="password" name="password" required placeholder="">
            <label for="password">Password</label>
        </div>
        <button type="submit" class="btn">Login</button>
        
        <div class="forgot-link">
            <a href="forgot_password.php">Forgot Password?</a>
        </div>
    </form>
    </div>
</body>
</html>