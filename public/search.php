<?php 

include('includes/db_connect.php');

$query=$_GET['q'];
$query=$conn->real_escape_string($query);

$sql="SELECT * FROM songs WHERE title LIKE '%$query%' LIMIT 5";
$result=mysqli_query($conn,$sql);

if(mysqli_num_rows($result)>0)
{
  
    echo "<ul>";
  
    while($row=$result->fetch_assoc()){
      echo "<div class='search'>";
        echo "<li> <img src='" .$row['cover_image'] ."' alt='Cover' class='song-cover1' ></li>";
        echo"<li class='a1'><a href='home.php?id=".$row['song_id']."'>".$row['title']. "</a></li>";
        
        echo "</div>";
    }
    
    echo "</ul>";
   
}
else{
  echo "<ul><li>No results found</li></ul>";
}

$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
      
  <link rel="stylesheet" href="assets/css/player.css">
  <link rel="stylesheet" href="assets/css/styles.css">
  <link rel="stylesheet" href="assets/css/artistandalbumfetch.css">

  <style>
  
    .song-cover1{
            width: 30px;
            height: 40px;
            background: #fff;
            display:block;
            
        }
    .search{
      display:flex;
      align-items:center;
      gap:10px;
      width:auto;

    }
    
    .a1{
       align-items:center;
       white-space: nowwrap;
       text-decoration:none;
    }
    
  </style>
</head>
<body>
  
</body>
</html>