<!-- Add Artist -->

<?php
 session_start();

 if(!isset($_SESSION['admin']))
 {
    header('Location: login.php');
    exit();
 }
 

include('../includes/admin_header.php');
include('../includes/admin_db_connect.php');

//Handle form submission

if($_SERVER['REQUEST_METHOD']==='POST')
{
        $name=$_POST['name'];
        $bio=$_POST['bio'];
        $profile_picture=$_FILES['profile_picture'];


        //Handle profile picture submission

        if($profile_picture['name']!=''){

            $target_dir="../assets/images/artist_profiles/";
            $target_file=$target_dir.basename($profile_picture["name"]);
            move_uploaded_file($profile_picture["tmp_name"],$target_file);
           $profile_picture_path=basename($profile_picture["name"]);

        }
        else{
            $profile_picture_path="default_artist.png";
        }

        //Insert artist inot the database

        $query="INSERT INTO artists(name,bio,profile_picture)VALUES(?,?,?)";
        $stmt=$conn->prepare($query);
        $stmt->bind_param("sss",$name,$bio,$profile_picture_path);

        if($stmt->execute()){
            $success_message="Artist added successfull!";
        }
        else{
            $error_message="Failed to add artist";
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Artist Page</title>
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

<div class="container">
    <h2>Add Artist</h2>

    <?php if(isset($success_message)) echo"<p class='success'>$success_message</p>";?>
    <?php if(isset($error_message))echo"<p class='error'>$error_message</p>";?>

    <form action="" method="POST" enctype="multipart/form-data">
       <label for="name">Aritst Name:</label>
       <input type="text" name="name" id="name" required>


       <lable for="bio">Bio:</label>
       <textarea name="bio" id="bio" rows="5" required></textarea>

       <label for="name">Profile_Picture:</label>
       <input type="file" name="profile_picture" id="profile_picture">
  
       <button type="submit">Add Artist</button>
       <a href="manage_artists.php" class="a"><-</a>
    </form>
   
</div>




<?php
include('../includes/admin_footer.php');
?>
</body>
</html>