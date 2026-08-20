

<?php
session_start();
include('includes/db_connect.php');

$data=json_decode(file_get_contents('php://input'),true);

$playlistId=$data['playlistId'];
$songId=$data['songId'];

$query="INSERT INTO playlist_songs(playlist_id,song_id) VALUES($playlistId,$songId)";
$result=mysqli_query($conn,$query);

if($result){
    echo json_encode(['success' => true]);
}
else{
 echo json_encode(['error' => false]);
}
?>