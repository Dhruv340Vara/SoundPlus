<!-- Admin Header -->
<?php
  //Start the Session

  //Check if the user is admin

  if(!isset($_SESSION['admin'])){
   header('Location:login.php');  
     exit();
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SoundPlus Admin Panel</title>
    <link rel="stylesheet" href="../css/admin.css">
    
</head>
<body>
    <header>

      <div class="logo">
        <a href="dashbord.php">SoundPlus Admin</a>
      
      <nav>
      <ul>
       <li><a href="dashbord.php">DashBoard</a></li>
       <li><a href="manage_users.php">Manage Users</a></li>
       <li><a href="manage_songs.php">Manage Songs</a></li>
   
       <li><a href="manage_artists.php">Manage Artists</a></li>
       <li><a href="manage_plans.php">Manage Plans</a></li>
       <li><a href="manage_albums.php">Manage Albums</a></li>
       
       <li><a href="logout.php" onclick="return confirm('Are you sure you want Leave Admin..');">Logout</a></li>
    
    </ul>
    </nav>
    </div>

    </header>
</body>
</html>