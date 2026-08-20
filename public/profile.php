 <?php
 session_start();
 include('includes/db_connect.php');


 if(!isset($_SESSION['user_id']))
 {
    header('Location:home.php');
    exit();
 }
 
 ?>