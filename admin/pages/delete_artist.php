<!-- Delete Artist -->

<?php
 session_start();

 if(!isset($_SESSION['admin']))
 {
    header('Location: login.php');
    exit();
 }
 
//Databse Connection

include('../includes/admin_db_connect.php');

if($_SERVER['REQUEST_METHOD']==='GET'){

    if(isset($_GET['artist_id'])){  //! error  && is_numeric($_GET['artist_id'])
      $artist_id=intval($_GET['artist_id']);

      //Check if the artist has associated songs or albums

      $songCheckQuery="SELECT COUNT(*) AS song_count FROM songs WHERE artist_id=?";
      $albumCheckQuery="SELECT COUNT(*) AS album_count FROM albums WHERE artist_id=?";

      $stmt=$conn->prepare($songCheckQuery);
      $stmt->bind_param("i",$artist_id);
      $stmt->execute();
      $songCheckResult=$stmt->get_result()->fetch_assoc();
      $stmt->close();

      $stmt=$conn->prepare($albumCheckQuery);
      $stmt->bind_param("i",$artist_id);
      $stmt->execute();
      $albumCheckResult=$stmt->get_result()->fetch_assoc();
      $stmt->close();

      if($songCheckResult['song_count']>0 || $albumCheckResult['album_count']>0){

        echo "<script>alert('Error: Cannot delete artist with associated songs or albums.Please delete those first.');</script>";
        echo "<script>window.location.href='manage_artists.php';</script>";
      }
      else{

        //Proceed to delete the artist

        $deleteQuery="DELETE FROM artists WHERE artist_id=?";
        $stmt=$conn->prepare($deleteQuery);
        $stmt->bind_param("i",$artist_id);

        if($stmt->execute()){
            echo "<div class='success'>Artist deleted successfully.</div>";
        }
        else{
            echo "<div class='error'>Error Occure Deleting Artist: ".$stmt->error."</div>";
        }
        $stmt->close();
      }
    }
      else{
        echo "<div class='error'>Invalid Request.Artist ID must be Valid</div>";
      }
    }
    $conn->close();

?>
