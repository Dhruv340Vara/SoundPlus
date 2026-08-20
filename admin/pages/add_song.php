<!-- ADD Songs -->

<?php
 session_start();

 if(!isset($_SESSION['admin']))
 {
    header('Location: login.php');
    exit();
 }
 
include('../includes/admin_header.php');
include('../includes/admin_db_connect.php');

//Fetch artist data from dropdown

$artist_query="SELECT artist_id,name FROM artists"; 
$artist_result=mysqli_query($conn,$artist_query);

//Fetch album data for dropdown

$album_query="SELECT album_id,title FROM albums";
$album_result=mysqli_query($conn,$album_query);

if($_SERVER['REQUEST_METHOD'] =='POST')
{
    $title=$_POST['title'];
    $artist_id=$_POST['artist_id'];
    $album_id=$_POST['album_id'];
    $genre=$_POST['genre'];



    //Upload Files

    $file_path='../uploads/songs/'.basename($_FILES['file_path']['name']);
    move_uploaded_file($_FILES['file_path']['tmp_name'],$file_path);

    $cover_image=null;

    if(!empty($_FILES['cover_image']['name']))
    {
        $cover_image='../uploads/cover_img/'.basename($_FILES['cover_image']['name']);
        move_uploaded_file($_FILES['cover_image']['tmp_name'],$cover_image);
    }  



$status='active';

$query="INSERT INTO songs(title,artist_id,album_id,genre,file_path,cover_image,status) VALUES('$title','$artist_id','$album_id','$genre','$file_path','$cover_image','$status')";


if(mysqli_query($conn,$query)){
    echo "Song added Successfully!";
}
else{
    echo "Error: ".mysqli_error($conn);
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Songs</title>
    <link rel="stylesheet" href="../css/admin.css">
    <style>
    .a{

color: red;
weight:100px;
font-size:40px;
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
    <h2>Add New Song</h2>
    <form action="add_song.php" method="POST" enctype="multipart/form-data">

    <label>Song Title</label>

    <input type="text" name="title" required><br><br>


    <label>Artist:</label>
    <select name="artist_id" required>
         <option value="">Select Artist</option>

         <?php while($artist=mysqli_fetch_assoc($artist_result)) { ?>
            <option value="<?=$artist['artist_id'] ?>"><?=$artist['name'] ?></option>

            <?php } ?>
    </select>
     <br>
     <br>
     <label>Album:</label>
    <select name="album_id" required>
         <option value="">Select Album</option>

         <?php while($album=mysqli_fetch_assoc($album_result)) { ?>
            <option value="<?=$album['album_id'] ?>"><?=$album['title'] ?></option>

            <?php } ?>
    </select>
     <br>
     <br>

     <label>Genre:</label>
     <input type="text" name="genre" ><br><br>

     <label>Song File (MP3):</label>
     <input type="file" name="file_path"  required><br><br>
     <label>Cover Image </label>
     <input type="file" name="cover_image" accept=".jpg,.png" required><br><br>

     <button type="submit">Add Song</button>

         </form>          
</body>
</html>

<?php include('../includes/admin_footer.php'); ?>