<!-- Dash Board For PhP -->


<?php
 session_start();

 if(!isset($_SESSION['admin']))
 {
    header('Location: login.php');
    exit();
 }
 
//Databse Connection

include('../includes/admin_header.php');
include('../includes/admin_db_connect.php');
//Fetch metrics data

$total_users=$conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$total_songs=$conn->query("SELECT COUNT(*) as count FROM songs")->fetch_assoc()['count'];
$total_artists=$conn->query("SELECT COUNT(*) as count FROM artists")->fetch_assoc()['count'];

$total_Album=$conn->query("SELECT COUNT(*) as count FROM albums")->fetch_assoc()['count'];
// echo "dhruv";
$total_plan=$conn->query("SELECT COUNT(*) as count FROM plans")->fetch_assoc()['count'];
$total_revenue=$conn->query("SELECT COUNT(*) as count FROM plans")->fetch_assoc()['count'];

//Fetch Recent activites

//$recent_activites=$conn->$query("SELECT date,activity,user_name,status FROM activities ORDER BY date DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="../css/dashbord.css">
</head>
<body>

    <div class="container">
       <div class="dahboard-header">
        <h2>Welcome Back,Admin!</h2>
        <p>Here an overview of the system's performance anmd recent activites.</p>
       </div>

       <!-- Matrics Section -->
       <div class="metricsx">
          <div class="metric-card">
            <h3>Total Users</h3>
            <p><?php echo $total_users; ?></p>
          </div>
          <div class="metric-card">
            <h3>Total Songs</h3>
            <p><?php echo $total_songs; ?></p>
          </div>
        
          <div class="metric-card">
            <h3>Total Artists</h3>
            <p><?php echo $total_artists; ?></p>
          </div>
          <div class="metric-card">
            <h3>Total Album</h3>
            <p><?php echo $total_Album; ?></p>
          </div>
          <!-- <div class="metric-card">
            <h3>Active Plans</h3>
            <p><?php echo $total_plan; ?></p>
          </div> -->
          <!-- <div class="metric-card">
            <h3>Monthly Revenue</h3>
            <p>&#8377;<?php echo number_format($total_revenue,2); ?></p>
          </div> -->
       </div>
      </table>
       </div>

    </div>
</body>
</html>
<?php 
include('../includes/admin_footer.php');
?>