<!-- Manage Artists -->

<?php

session_start();

if(!isset($_SESSION['admin'])){
    header('Location: login.php');
    exit();
}

//  Include admin header

include('../includes/admin_header.php');
include('../includes/admin_db_connect.php');

$query="SELECT * FROM artists ORDER BY created_at DESC";
$result=$conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Artists</title>
</head>
<body>


    <div class="admin-page">
        <h2>Manage Artists</h2>

        <a href="add_artist.php" class="a">⬅ Add New Artist</a>

        <!-- Artists List -->
       <h3>Existing Artists</h3>

       <table>
         <thead>
            <tr>
                <th>Profile Picture</th>
                <th>Name</th>
                <th>Bio</th>
                <th>Actions</th>
            </tr>
        </thead>

    <tbody>
        <?php while($artist=$result->fetch_assoc()): ?>

            <tr>
                <td><img src="<?php echo '../assets/images/artist_profiles/'.($artist['profile_picture']??'default_user.png'); ?>" alt="Artist Profile" width="50"></td>

                <td><?php echo htmlspecialchars($artist['name']); ?></td>
                <td><?php echo htmlspecialchars($artist['bio']??'N/A'); ?></td>
                <td><a href="edit_artist.php?artist_id=<?php echo $artist['artist_id']; ?>" onclick="return confirm('Are you sure you want to Edit this artist?');">Edit</a> 
                |
                <a href="delete_artist.php?artist_id=<?php echo $artist['artist_id']; ?>" onclick="return confirm('Are you sure you want to delete this artist?');">Delete</a>
        </td>
        </tr>

        <?php endwhile; ?>
        </tbody>
     </table>
    </div>

    <?php
    include('../includes/admin_footer.php');
    ?>
</body>
</html>
<style>    .a{

color: red;

font-size:20px;
margin-left:1200px;
border: none;
border-radius: 5px;
cursor: pointer;

text-decoration:none;
}

.a:hover {
color:#666;
}</style>