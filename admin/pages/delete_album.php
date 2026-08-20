<!-- Delete Album -->

<?php

session_start();

if(!isset($_SESSION['admin'])){
    header('Loaction: login.php');
    exit();
}

//Databse Connection

include('../includes/admin_db_connect.php');

if(isset($_GET['album_id']))
{
    $album_id=intval($_GET['album_id']);

    //Delete Album

    $query="DELETE FROM albums WHERE album_id=?";
    $stmt=$conn->prepare($query);
    $stmt->bind_param("i",$album_id);

    if($stmt->execute()){
        header('Location: manage_albums.php');
    }
    else{
        echo "Error Deleting Album";
    }
}
else{
echo "Invalid request.No album ID Provided.";
}
