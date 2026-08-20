<?php

session_start();

if(!isset($_SESSION['admin']))
{
   header('Location: login.php');
   exit();
}

  include('../includes/admin_db_connect.php');
  if(isset($_GET['id'])){
    $song_id=$_GET['id'];

    //delete user
    $query="DELETE from songs where song_id=?";
    $stmt=$conn->prepare($query);
    $stmt->bind_param("i",$song_id);
    $stmt->execute();

 
    header('Location:manage_songs.php');
    echo"<script>alert('song deleted');</script>";
  }
?>
