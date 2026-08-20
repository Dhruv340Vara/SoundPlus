<?php

session_start();

if(!isset($_SESSION['admin']))
{
   header('Location: login.php');
   exit();
}

  include('../includes/admin_db_connect.php');
  if(isset($_GET['id'])){
    $user_id=$_GET['id'];

    //delete user
    $query="DELETE from users where user_id=?";
    $stmt=$conn->prepare($query);
    $stmt->bind_param("i",$user_id);
    $stmt->execute();

 
    header('Location:manage_users.php');
    echo"<script>alert('delete user')</script>";
  }
?>