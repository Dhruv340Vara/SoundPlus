<!-- Add Album -->

<?php
 session_start();

 if(!isset($_SESSION['admin']))
 {
    header('Location: login.php');
    exit();
 }
 


//  Include admin header

include('../includes/admin_header.php');
include('../includes/admin_db_connect.php');

//fetch all artists for the dropdown

$query_artists="SELECT artist_id,name FROM artists";
$artists_result=$conn->query($query_artists);

//Handle from Submission 

if($_SERVER['REQUEST_METHOD']=='POST')
{
   $title=trim($_POST['title']);
   $artist_id=intval($_POST['artist_id']);
   $release_date=$_POST['release_date'];
   $cover_image=$_FILES['cover_image'];

   //Validate required fields

   if(empty($title) || empty($artist_id) || empty($release_date))
   {
      $error_message="Please Fill in all Required fields";
   }
   else
   {
      //Handle Cover image uploade

      $cover_image_path="default_album.png"; //Default Cover

      if(!empty($cover_image['name']))
      {
         $target_dir="../assets/images/album_covers/";
         $target_file=$target_dir.basename($cover_image["name"]);
         $image_extension=strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
         $allowed_extension=['jpg','jpeg','png','gif'];

         if(in_array($image_extension,$allowed_extension)){

            if(move_uploaded_file($cover_image["tmp_name"],$target_file))
            {
               $cover_image_path=basename($cover_image["name"]);
            }
            else{
               $error_message="Failed to upload cover image.";
            }
         }
         else{
            $error_message="Only JPG,JPEG,PNG and GIF files are allowed.";
         }
      }

      //Insert album into the database

      if(empty($error_message)){

         $query="INSERT INTO albums (title,artist_id,release_date,cover_image)values(?,?,?,?)";
         $stmt=$conn->prepare($query);
         $stmt->bind_param("siss",$title,$artist_id,$release_date,$cover_image_path);

         if($stmt->execute())
         {
            $success_message="Album added Succeessfull!";
         }
         else{
            $error_message="Failed to add album.Please Try Again.";
         }
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Add Album</title>
   <link rel="stylesheet" href="../css/admin.css">
</head>
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
<body>
   <div class="container">
      <h2>Add Album</h2>

      <?php if(isset($success_message))echo "<p class='success'>$success_message</p>";?>
      <?php if(isset($error_message))echo "<p class='error'>$error_message</p>";?>


      <form action="" method="post" enctype="multipart/form-data">

      <lable for="title">Album Title</lable>

      <input type="text" name="title" id="title" required>

      <lable for="artist_id">Artist</lable>     

      <select name="artist_id" id="artist_id" required>
          <option value="">Seletct an Artist</option>
          <?php while($artist=$artists_result->fetch_assoc()) {?>
          <option value="<?php echo $artist['artist_id'];?>">
          <?php echo $artist['name'];?>
         </option>
          <?php } ?>
</select>

         

          <lable for="release_date">Release Date</label>
          <input type="date" name="release_date" id="release_date" required>

          <lable for="cover_image">Cover Image(Optional)</label>
          <input type="file" name="cover_image" id="cover_image">

          <button type="submit">Add Album</button>
          <a href="manage_albums.php" class="a"><-</a>
          </form>
         
      </div>
      
 

   <?php
   //include admin footer

   include('../includes/admin_footer.php');

   ?>
</body>
</html>