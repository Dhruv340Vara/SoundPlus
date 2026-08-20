<!-- Manage album -->
<?php

session_start();

if(!isset($_SESSION['admin'])){
    header('Loaction: login.php');
    exit();
}

//Databse Connection

include('../includes/admin_header.php');
include('../includes/admin_db_connect.php');


//Fetch all album

$query="SELECT albums.*,artists.name AS artist_name FROM albums LEFT JOIN artists ON albums.artist_id=artists.artist_id";
$result=$conn->query($query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>    
    
.a{
color: red;
font-size:20px;
margin-left:1200px;
border: none;
border-radius: 5px;
cursor: pointer;
text-decoration:none;
}

.a:hover {
color:#666;
}
</style>

</head>
<body>
    

<div class="container">
    <h2>Manage Albums</h2>
    <a href="add_album.php" class="a"> ⬅ Add New Album </a>
    <table class="table">
        <thead><tr>
            <th>#</th>
            <th>Title</th>
            <th>Artist</th>
            <th>Relese Date</th>
            <th>Cover Image</th>
            <th>Action</th>
        </tr></thead>

        <tbody>
            <?php  while($album=$result->fetch_assoc()): ?>
            <tr>
            <td><?php echo $album['album_id'];?></td>
            <td><?php echo $album['title'];?></td>
            <td><?php echo $album['artist_name'];?></td>
            <td><?php echo $album['release_date'];?></td>
            <td><img src="../assets/images/album_covers/<?php echo $album['cover_image'];?>" alt="Cover_image" style="width:50px; heigh:50px;"></td>

            <td><a href="edit_album.php?album_id=<?php echo $album['album_id'];?>" class="btn btn-Waring" onclick="return confirm('Are you sure you want to Edit This Album?');">Edit</a> |
            <a href="delete_album.php?album_id=<?php echo $album['album_id'];?>" class="btn btn-danger" onclick="return confirm('Aru sure You Want to Delete This Album')"> delete</a></td>
        </tr>
        <?php endwhile; ?>

        </tbody>
    </table>
  
</div>
            

</body>
</html>
<?php
include('../includes/admin_footer.php');
?>
