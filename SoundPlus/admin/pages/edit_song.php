<!-- Edit Song -->

<?php
 session_start();

 if(!isset($_SESSION['admin']))
 {
    header('Location: login.php');
    exit();
 }
 

include('../includes/admin_header.php');
include('../includes/admin_db_connect.php');

$song_id=$_GET['id'];  //$song_id=$_GET['song_  id'];

$query="SELECT * FROM songs WHERE song_id=$song_id";
$result=mysqli_query($conn,$query);
$song=mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Song</title>
    <link rel="stylesheet" href="../css/admin.css"> 
</head>
<body>
    <h2>Edit Song</h2>
    <form action="update_song.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="song_id" value="<?= $song['song_id'] ?>">

        <label>Song Title : </label>
        <input type="text" name="title" value="<?= $song['title'] ?>" required><br>

        <label>Genre : </label>
        <input type="text" name="genre" value="<?= $song['genre'] ?>" required><br>

        <label>Status : </label>
         <select name="status">
            <option value="active" <?= $song['status']=='active'?'selected':''?>>Active</option>
            <option value="inactive" <?= $song['status']=='inactive'?'selected':''?>>Inactive</option>
         </select><br>

         <button type="submit">Update song</button>

    </form>
</body>
</html>