<?php

session_start();

if(!isset($_SESSION['admin']))
{
   header('Location: login.php');
   exit();
}

  include('../includes/admin_db_connect.php');
  if(isset($_GET['id'])){
    $plan_id=$_GET['id'];

    //delete user
    $query="DELETE from plans where plan_id=?";
    $stmt=$conn->prepare($query);
    $stmt->bind_param("i",$plan_id);
    $stmt->execute();

 
    header('Location:manage_plans.php');
    echo"<script>alert('plan deleted');</script>";
  }
?>