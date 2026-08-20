<?php
include('includes/db_connect.php');
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    //initlize aary o sore error message
    $errors = [];

    $username=trim(mysqli_real_escape_string($conn,$_POST['username']));
    $email=trim(mysqli_real_escape_string($conn,$_POST['email']));
    $mobile=trim(mysqli_real_escape_string($conn,$_POST['mobile']));
    $password=trim(mysqli_real_escape_string($conn,$_POST['password']));

    //validate  username  must be alphanumeric and between 3-20 charcers 
    if(empty($username))
    {
        $errors[]="username is required";

    } 
    elseif (!preg_match('/^[a-zA-Z0-9@]{3,10}$/',$username))
    {
        $errors[]="Username must be 3-20 characters long and contion only number and letters.";
    }

   //Validate email must be a valid email formt

   if(empty($email))
   {

    $errors[]="Email is Required";

   }
   elseif(!filter_var($email,FILTER_VALIDATE_EMAIL))
   {
    $email[]="Invalid Email Format.";
   }

   //Validae mobile must be exactly 10 digits

   if(empty($mobile))
   {
    $errors[]="Mobile Number is Required."; 
   }
   elseif(!preg_match('/^[0-9]{10}$/',$mobile)){
    $errors[]="Mobile Number mus be exactly 10 digis.";
   }

   //Validate Password must be mee strong criteria

   if(empty($password)){
    $errors[]="Password is Required.";
   }
   elseif(!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',$password)){
    $errors[]="Password mus be a least 8 characers long,iclude an uppercase letter,a number and a special character.";
   }

   //if there are no validation errors,proceed to chek the database
   if(empty($errors))
   {
    //hash the password for security
    $hashed_password=password_hash($password,PASSWORD_DEFAULT);

    //check  if email mobile or username alerady existis iny the database
    $check_query="SELECT *  FROM users  where email='$email' or mobile='$mobile' or username='$username' ";
    $result=$conn->query($check_query);
    
    if(!$result)
    {
        die("query failed".$conn->error);
    }
    if($result->num_rows > 0)
    {
        echo"<script>alert('Email,Mobile number or Username alerady exists');</script>";
        echo"<script>window.location.href='signup.html';</script>";
    }
    else
    {
        //insert the user data the 'users' tabel
        $insert_query="INSERT INTO users (username,email,mobile,password) VALUES ('$username','$email','$mobile','$hashed_password')";
        
        if($conn->query($insert_query) === TRUE)
        {
            echo"<script>alert('signup sucessfull Redircting to login...')</script>";
            echo"<script>window.location.href='login.html';</script>";
            exit();
        }
        else
        {
            echo"<script>alert('Database error:".$conn->error."')</script>";
        }
    }
   }
   else
   {
    //display  validation errors 
    foreach($errors as $error)
    {
        echo"<script>alert('$error');</script>";
    }
    echo"<script>window.location.href='signup.html';</script>";
   }
}

?>
