
<?php
session_start();
include('includes/db_connect.php');

$userId=$_GET['user_id'];
$query="SELECT id,name FROM playlists WHERE user_id=$userId";
$result=mysqli_query($conn,$query);

$playlists=[];

while($row=mysqli_fetch_assoc($result)){
    $playlists[]=$row;
}
echo json_encode($playlists);

?>