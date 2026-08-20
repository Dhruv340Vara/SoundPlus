<!-- Analytics -->

<?php
 session_start();

 if(!isset($_SESSION['admin']))
 {
    header('Location: login.php');
    exit();
 }
 

include('../includes/admin_header.php');
include('../includes/admin_db_connect.php');

//Get the total amount of users

$queryUsers="SELECT COUNT(*) AS total_users FROM users";
$resultUsers=$conn->query($queryUsers);
$totalUsers=$resultUsers->fetch_assoc()['total_users'];

//Get the most played song

$queryMostPlayed="SELECT songs.title,COUNT(analytics.song_id)AS play_count FROM analytics 
JOIN songs ON analytics.song_id=songs.song_id WHERE analytics.action='play'
GROUP BY songs.song_id ORDER BY play_count DESC LIMIT 1";

$resultMostPlayed=$conn->query($queryMostPlayed);
$mostPlayedSong=$resultMostPlayed->fetch_assoc();  //error occur

//GET the number of downloads

$queryDownloads="SELECT COUNT(*) AS total_downloads FROM downloads";
$resultDownloads=$conn->query($queryDownloads);
$totalDownloads=$resultDownloads->fetch_assoc()['total_downloads'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="admin-page">
        <h2>Analytics</h2>
        <p><strong>Total Users:</strong><?php echo $totalUsers; ?></p>

        <h3>Most Played Song</h3>
        <?php if($mostPlayedSong): ?>

        <p><strong>Title:</strong><?php echo $mostPlayedSong; ?></p>
        <p><strong>Play Count:</strong><?php echo $mostPlayedSong['play_count']; ?></p>
        
        <?php else: ?>

             <p>No Song Data Available</p>
        
        <?php endif; ?>

          <p><strong>Total Downloads:</strong><?php echo $totalDownloads; ?></p>
    </div>

    <?php include('../includes/admin_footer.php'); ?>
</body>
</html>