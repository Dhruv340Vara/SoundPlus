<!-- Login PhP -->
<?php

session_start();

include('includes/db_connect.php');

//handle form submission

if($_SERVER['REQUEST_METHOD']=='POST')
{
    $identifier=trim($_POST['identifier']);  //Email or mobile
    $password=trim($_POST['password']);

    //Check if the email or mobile exists in the database
    
    if(!empty($identifier) && !empty($password))
    {
        if(filter_var($identifier,FILTER_VALIDATE_EMAIL))
        {
            $query="SELECT * from users where email='$identifier'"; 
        }
        else{
            $query="SELECT * from users where mobile='$identifier'"; 
        }
        $result=$conn->query($query);

        if($result->num_rows === 1) 
        {
            $user=$result->fetch_assoc();
             
            //verify password 
            if(password_verify($password,$user['password']))
            {
                //Store user data in session,inlcuding the username
        
                $_SESSION['user_id']=$user['user_id'];
                $_SESSION['username']=$user['username']; //Store username
                $_SESSION['user_email']=$user['email'];
                $_SESSION['user_mobile']=$user['mobile'];
        
                //Set success message
        
                echo "<script>alert('Login Successfull Redirecting to Home...');</script>";
                echo "<script>window.location.href='home.php';</script>";
                exit;
            }
            else{
                echo "<script>alert('not found username or password');</script>";
                echo "<script>window.location.href='login.html';</script>";
            }

            
        }
  
    else{
        //Set error message

        echo "<script>alert('Invalid Email/Mobile or Password');</script>";
        echo "<script>window.location.href='login.html';</script>";
        exit;


    }
  }
}
?>