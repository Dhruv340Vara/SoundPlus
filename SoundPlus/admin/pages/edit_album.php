<!-- Edit Album -->
<?php

session_start();

if(!isset($_SESSION['admin']))
{
    header('Location: login.php');
}

include('../includes/admin_header.php');
include('../includes/admin_db_connect.php');

//Fetch Album Details

if(isset($_GET['album_id'])){

    $album_id=intval($_GET['album_id']);
    
    $query="SELECT * FROM albums WHERE album_id=?";
    $stmt=$conn->prepare($query);
    $stmt->bind_param("i",$album_id);
    $stmt->execute();

    $result=$stmt->get_result();
    $album=$result->fetch_assoc();

    //Fetch artist for the dropdown

    $query_artist="SELECT artist_id,name FROM artists";
    $artist_result=$conn->query($query_artist);
}
else{
    header('Location: manage_albums.php');
    exit();
}

//Handle form submission

if($_SERVER['REQUEST_METHOD']==='POST'){

    $title=$_POST['title'];
    $artist_id=intval($_POST['artist_id']);
    $release_date=$_POST['release_date'];
    $cover_image=$_FILES['cover_image'];

    //Handle Cover Image

    $cover_image_path=$album['cover_image']; //Keep existing by defult

    if(!empty($cover_image['name'])){

        $target_dir="../assets/images/album_covers/";
        $target_file=$target_dir.basename($cover_image["name"]);

        if(move_uploaded_file($cover_image["tmp_name"],$target_file)){
            $cover_image_path=basename($cover_image["name"]);
        }
    }

    //Update album details

    $query="UPDATE albums SET  title=?,artist_id=?,release_date=?,cover_image=? WHERE album_id=?";
    $stmt=$conn->prepare($query);
    $stmt->bind_param("sissi",$title,$artist_id,$release_date,$cover_image_path,$album_id);

    if($stmt->execute()){
      header('Location: manage_albums.php');
    }
    else{
      echo "Error Updating Album";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
     
      <h2>Edit Album</h2>

      <form action="" method="POST" enctype="multipart/form-data">

      <label for="title">Album Title:</lable>
      <input type="text" name="title" id="title" value="<?php echo $album['title']; ?>" required>

      <label for="artist_id">Artist:</lable>
      <select name="artist_id" id="artist_id" required>

    <!-- Error -->
   <?php while($artist=$artist_result->fetch_assoc()) { ?>
   <option value="<?php echo $artist['artist_id']; ?>"
   <?php echo ($artist['artist_id'] == $album['artist_id']) ? 'selected' : ''; ?>>
   <?php echo $artist['name']; ?>
  </option>
  <?php } ?>
  </select>

  <label for="release_date">Release Date:</label>
  <input type="date" name="release_date" id="release_date" value="<?php echo $album['release_date']; ?>" required>

  <!-- Cover Image -->

  <label for="cover_image">Cover Image</label>
  <input type="file" name="cover_image" id="cover_image">
  <img src="../assets/images/album_covers/<?php echo $album['cover_image']; ?>" alt="current Cover Image" style="width: 50px; height: 50px;">

  <button type="submit">Update Album</button>
</form>
    </div>

    <?php include('../includes/admin_footer.php'); ?>
</body>
</html>