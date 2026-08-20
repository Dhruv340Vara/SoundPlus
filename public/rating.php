<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/rating.css">
</head>
<body>
    
<div class="rating" id="rating">
   <h2>Rate Your Experience</h2>
   <div class="rating-stars">
       <form action="" method="POST" id="rating-form">
           <div class="stars">
               <input type="radio" id="star1" name="rating" value="1" required>
               <label for="star1" title="1 stars">&#9733;</label>

               <input type="radio" id="star2" name="rating" value="2">
               <label for="star2" title="2 stars">&#9733;</label>

               <input type="radio" id="star3" name="rating" value="3">
               <label for="star3" title="3 stars">&#9733;</label>

               <input type="radio" id="star4" name="rating" value="4">
               <label for="star4" title="4 stars">&#9733;</label>

               <input type="radio" id="star5" name="rating" value="5">
               <label for="star5" title="5 star">&#9733;</label>
           </div>
           <button type="submit" class="submit-rating">Submit Rating</button>
       </form>
   </div>


   <div class="average-rating">

   <h3>Current Average Rating : </h3>

   <div id="rating-display">
    
   <?php 
  include('includes/db_connect.php');

   //Handle For Submission 

   if($_SERVER["REQUEST_METHOD"]==='POST' && isset($_POST['rating']))
   {
    $rating=intval($_POST['rating']);
    
    $query="INSERT INTO ratings (rating,timestamp) VALUES(?,NOW())";
    $stmt=$conn->prepare($query);

    if($stmt){
        $stmt->bind_param("i",$rating);

        if($stmt->execute())
        {
        echo "<script>alert(Rating Submited Successfully!);</script>";
        }
        else{
            echo "Error : ".$stmt->error;
      }
      $stmt->close();
    }
    else{
        echo "Error in Preparing Statement : ".$conn->error;
    }   
  }

  //Fetch average Rating

  $sql_avg="SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_ratings FROM ratings";

  $result=$conn->query($sql_avg);

  if($result && $result->num_rows>0){
    $row=$result->fetch_assoc();
    $average_rating=round($row['avg_rating']);
    $total_ratings=$row['total_ratings'];

    echo "<p><strong>$average_rating/5</strong>(Based On Total Ratings:   $total_ratings ratings)</p>";
  }
  else{
    echo "<p>No Of Ratings ye.Be the First To Rate!</p>";
  }
  $conn->close();

   ?>
   </div>
   </div>
</div>
<script src="assets/js/script.js"></script>
</body>
</html>