<!-- Create Playlist -->


<?php

session_start();
include('includes/db_connect.php');

$data=json_decode(file_get_contents('php://input'),true);

$userId=$data['userId'];
$playlistName=$data['playlistName'];

$query="INSERT INTO playlists(user_id,name) VALUES('$userId','$playlistName')";
$result=mysqli_query($conn,$query);

if($result){
    echo json_encode(['success => true']);
}
else{
    echo json_encode(['error => false']);
}
?>