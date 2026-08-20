
<?php

session_start();

if(!isset($_SESSION['admin'])){
    header('Location: login.php');
    exit();
}

include('../includes/admin_header.php');
include('../includes/admin_db_connect.php');

$query="SELECT * from plans";
$result=$conn->query($query);
?>
<div class="container">
    <h2>Manage Subscription Plans</h2>
    <a href="add_plan.php" class="a">⬅ Add new Plan </a>
    <table>
        <thead>
            <tr>
                
                    
            
    <th>plan Name</th>
    <th>Price</th>
    <th>Duration (Month)</th>
    <th>Description</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>
    <?php while($row=$result->fetch_assoc()) { ?>
<tr>
    <td><?php echo  htmlspecialchars($row['name']);?></td>
    <td><?php echo  htmlspecialchars($row['price']);?></td>
    <td><?php echo htmlspecialchars($row['duration']);?></td>
    <td><?php echo  htmlspecialchars($row['description']);?></td>
    <td><a href="edit_plan.php?id=<?php echo $row['plan_id']; ?>"  onclick="return confirm('Are you sure you want to Edit this plan?');">Edit</a> | <a href="delete_plan.php?id=<?php echo $row['plan_id']; ?>"  onclick="return confirm('Are you sure you want to delete this plan?');">Delete</a></td>
</tr>
<?php }?>
</tbody>
    </table>
</div>
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