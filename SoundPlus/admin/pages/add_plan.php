<!-- ADD Plan -->

<?php
 session_start();

 if(!isset($_SESSION['admin']))
 {
    header('Location: login.php');
    exit();
 }
 

include('../includes/admin_header.php');
include('../includes/admin_db_connect.php');

//Handle form submission for adding a new plan


if($_SERVER['REQUEST_METHOD']==='POST')
{
    $name=$_POST['name'];
    $price=$_POST['price'];
    $duration=$_POST['duration'];
    $description=$_POST['description'];

    $query="INSERT INTO plans(name,price,duration,description) VALUES(?,?,?,?)";
    $stmt=$conn->prepare($query);
    $stmt->bind_param("sdss",$name,$price,$duration,$description);

    if($stmt->execute()){
        header('Location: manage_plans.php');
        exit();
    }
    else{
        echo "Error Occur While Addtion Plan";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Plan</title>
    <link rel="stylesheet" href="../css/admin.css">
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
</head>
<body>
<div class="container">

    <h2>Add New Subscription Plan</h2>
  
    <form method="POST">
    
    <label for="name">Plan Name:</label>
    <input type="text" name="name" id="name" required>

    <label for="price">Price:</label>
    <input type="number" name="price" id="name" step="0.01" required>

    <label for="duration">Duration (Month):</label>
    <input type="number" name="duration" id="duration" required>

    <label for="description">Description:</label>
    <textarea name="description" id="description" rows="4"></textarea>

    <button type="submit">Add Plan</button>
    <a href="manage_plans.php" class="a"><-</a>
   </form>  
 
   
</div>


<?php include('../includes/admin_footer.php');?>
</body>
</html>