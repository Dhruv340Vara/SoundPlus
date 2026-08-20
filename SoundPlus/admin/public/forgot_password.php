<?php
include('includes/db_connect.php');
if($_SERVER['REQUEST_METHOD'] ==='POST')
{
    $identifier=$_POST['identifier']; 

$query="SELECT  user_id  FROM  users WHERE email = ? OR mobile= ? ";
$stmt=$conn->prepare($query);
$stmt->bind_param("ss",$identifier,$identifier);
$stmt->execute();
$result=$stmt->get_result();
$user=$result->fetch_assoc();

if($user)
{
    $userId=$user['user_id'];
    header("Location:forgot_password_form.php?user_id=$userId");
    exit();
}
else
{
    echo"<script>alert('No Account Found this email or mobile.');</script>";
    echo"<script>window.location.href='forgot_password.php';</script>";
}


}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/style.css">
  
</head>
<body>
    <div class="login-container">
    <h2>Forgot Password</h2>
    <p class="instruction">Enter You email or mobile number to reset your password</p>
    <form action="forgot_password.php" method="post" > 



    <div class="input-group">
        
        <input type="text" name="identifier" id="identifier" placeholder="Enter Email or Mobile" required> 
        
    </div>

<button type="submit" class="btn">Reset Password</button>
    </form>
    <div class="login-link">Remebered Your Password? <a href="login.html">Login</a></div>
    </div>



       
</body>
</html>
    
