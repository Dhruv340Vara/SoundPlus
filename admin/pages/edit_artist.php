<!-- Edit Artists -->

<?php

session_start();

if(!isset($_SESSION['admin']))
{
   header('Location: login.php');
   exit();
}


include('../includes/admin_header.php');
include('../includes/admin_db_connect.php');


//Fetch artist details

if(isset($_GET['artist_id'])){
    $artist_id=intval($_GET['artist_id']);
    $query="SELECT * FROM artists WHERE artist_id=?";

    $stmt=$conn->prepare($query);
    $stmt->bind_param("i",$artist_id);
    $stmt->execute();

    $result=$stmt->get_result();
    $artist=$result->fetch_assoc();
}
else{
    header('Location: manage_artists.php');
    exit();
}

//Handle form submission

if($_SERVER['REQUEST_METHOD']=='POST'){

    $name=$_POST['name'];
    $bio=$_POST['bio'];
    $profile_picture=$_FILES['profile_picture'];

    //Handle profile image upload

    $profile_picture_path=$artist['profile_picture'];

    if(!empty($profile_picture['name'])){
        $target_dir="../assets/images/artist_profiles/";
        $target_file=$target_dir.basename($profile_picture["name"]);
        
        if(move_uploaded_file($profile_picture["tmp_name"],$target_file)){
             $profile_picture_path=basename($profile_picture["name"]);
        }
    }

    //update artist details

    $query="UPDATE artists SET name=?,bio=?,profile_picture=? WHERE artist_id=?";
    $stmt=$conn->prepare($query);
    $stmt->bind_param("sssi",$name,$bio,$profile_picture_path,$artist_id);

    if($stmt->execute()){
        header('Location: manage_artists.php');
        exit();
    }
    else{
        echo "<div class='alert error'>Error Updating artist.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Artist</title>
</head>
<body>
    <div class="container">
        <h2>Edit Artist</h2>


        <form action="" method="POST" enctype="multipart/form-data">
       
          <label for="name">Arits Name:</label>
          <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($artist['name']); ?>" required>
      
          <label for="bio">Artist Bio:</label>
          <textarea name="bio" id="bio0" cols="4" required><?php echo htmlspecialchars($artist['bio']); ?></textarea>
  
          <label for="profile_picture">Profile Image:</label>
          <input type="file" name="profile_picture" id="profile_picture">
          <img src="../assets/images/artist_profiles/<?php echo $artist['profile_picture']; ?>" alt="Current Profile Image"
          style="width:50px; height:50px; border-radius: 50%;">

          <button type="submit">Update Artist</button>
        </form>
    </div>

</body>
</html>

<?php include('../includes/admin_footer.php'); ?>