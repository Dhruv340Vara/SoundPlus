<!-- Adimin Authentication -->
<?php
 

  session_start();

  //Check if the user is admin

  if(!isset($_SESSION['admin'])){
    header('Location:login.php');
    exit();
  }
?>