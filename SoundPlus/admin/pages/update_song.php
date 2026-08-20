<!-- Update songs -->

<?php
 session_start();

 if(!isset($_SESSION['admin']))
 {
    header('Location: login.php');
    exit();
 }
 

include('../includes/admin_header.php');
include('../includes/admin_db_connect.php');

if($_SERVER['REQUEST_METHOD']=='POST'){

    $song_id=$_POST['song_id'];
    $title=$_POST['title'];
    $genre=$_POST['genre'];
    $status=$_POST['status'];

    $query="UPDATE songs SET title='$title',genre='$genre',status='$status' WHERE song_id=$song_id";

    if(mysqli_query($conn,$query)){
        echo "Song updated successfully!";
    }
    else{
        echo "Error: ".mysqli_error($conn);
    }
}
?>