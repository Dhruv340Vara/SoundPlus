<!-- Edit Plan -->

<?php

session_start();

if(!isset($_SESSION['admin'])){
    header('Location: login.php');
    exit();
}

include('../includes/admin_header.php');
include('../includes/admin_db_connect.php');

//Fetch Plan Details

if(isset($_GET['id'])){

    $plan_id=$_GET['id'];

    $query="SELECT * FROM plans WHERE plan_id=?";
  
    $stmt=$conn->prepare($query);
    $stmt->bind_param("i",$plan_id);
    $stmt->execute();

    $result=$stmt->get_result();
    $plan=$result->fetch_assoc();
}
else
{
    header('Location: manage_plans.php');
    exit();
}

//Handle Form submission

if($_SERVER['REQUEST_METHOD']==='POST'){

    $name=$_POST['name'];
    $price=$_POST['price'];
    $duration=$_POST['duration'];
    $description=$_POST['description']; //Get the Description input

    $query="UPDATE plans SET name=?,price=?,duration=?,description=? WHERE plan_id=?";
    $stmt=$conn->prepare($query);
    $stmt->bind_param("sdssi",$name,$price,$duration,$description,$plan_id); //Bind the description

    if($stmt->execute()){
        header('Location: manage_plans.php');
    }
    else{
        echo "Error Updating Plan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h2>Edit Subscription Plan</h2>

        <form method="POST">

         <label for="name">Plan Name:</label>
         <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($plan['name']); ?>" required>

         <label for="price">Price:</label>
         <input type="number" name="price"  id="price" step="0.01" value="<?php  echo htmlspecialchars($plan['price']); ?>" required>

         <label for="price">Duration (Days)::</label>
         <input type="number" name="duration"  id="duration" value="<?php  echo htmlspecialchars($plan['duration']); ?>" required>

         <label for="description">Description:</label>
         <textarea name="description" id="description" rows="4" required><?php echo htmlspecialchars($plan['description']); ?></textarea>
         <button type="submit">Update Plan</button>
</form>
    </div>

<?php include('../includes/admin_footer.php'); ?>
</body>
</html>