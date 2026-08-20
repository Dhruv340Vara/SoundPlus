<?php
include('includes/db_connect.php');
if($_SERVER['REQUEST_METHOD']  === 'POST'){

    if(isset($_POST['user_id']) && isset($_POST['new_password']))
    {
        $userId=$_POST['user_id'];
        $newPassword=password_hash($_POST['new_password'],PASSWORD_BCRYPT);


        if($conn)
        {
            $query="UPDATE users set password = ? where user_id= ? ";
            $stmt=$conn->prepare($query);
            if($stmt)
            {
                $stmt->bind_param("si",$newPassword,$userId);

              if($stmt->execute())
              {
                echo"<script>alert('password reset sucessfully! you can now login..');</script>"; 
                echo"<script>window.location.href='login.html';</script>";
              }
              else
              {
                error_log("error Excuting query.".$stmt->error);
                echo "<script>alert('Falied to reset password.please try again.');</script>";
                echo"<script>window.location.href='forgot_password.php';</script>";
              }
            }

              else
              {
                error_log("error preparing query.".$conn->error);
                echo "<script>alert('Falied to prepare query.');</script>";
                echo"<script>window.location.href='forgot_password.php';</script>";
              }
            }
                else
                {
                    error_log("Database connection failed.".$mysqli_connect_error());
                    echo "<script>alert('Database connection failed.Please try again later.');</script>";
                    echo"<script>window.location.href='forgot_password.php';</script>";
                }
            }
            else
            {
                
                echo "<script>alert('Required data not recevied please try again..');</script>";
                echo"<script>window.location.href='forgot_password.php';</script>";
            }
        }
    

?>