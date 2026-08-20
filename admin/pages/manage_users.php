<?php

session_start();

if(!isset($_SESSION['admin'])){
    header('Location: login.php');
    exit();
}

include('../includes/admin_header.php');
include('../includes/admin_db_connect.php');

$query="SELECT * FROM users";
$result=$conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
</head>
<body>
    <div class="admin-page">
        <h2>User Management</h2>

        <table>
            <tr>
                 <th>Username</th>
                 <th>Email</th>
                 <th>Status</th>
                 <th>Actions</th>
            </tr>

            <?php while($row=$result->fetch_assoc()){?>
                <tr>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><a href="edit_user.php?id=<?php echo $row['user_id']; ?>" onclick="return confirm('Are you sure you want to Edit this User?');">Edit</a> | <a href="delete_user.php?id=<?php echo $row['user_id']; ?>" onclick="return confirm('Are you sure you want to delete this User?');">Delete</a></td>
            </tr>

            <?php } ?>

            </table>
    </div>

    <?php include('../includes/admin_footer.php'); ?>
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