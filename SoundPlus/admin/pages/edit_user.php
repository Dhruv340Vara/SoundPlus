<?php
session_start();

if(!isset($_SESSION['admin'])){
    header('Location:login.php');  
      exit();
  }

  
include('../includes/admin_header.php');
include('../includes/admin_db_connect.php');

if(isset($_GET['id']))
{

$user_id=$_GET['id'];
//fetch user details

$query="SELECT * from users where user_id=?";
$stmt=$conn->prepare($query);
$stmt->bind_param("i",$user_id);
$stmt->execute();
$result=$stmt->get_result();

if($result->num_rows>0){
    $user=$result->fetch_assoc();

}else{
    echo"user not found!";
    exit();
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    $username=$_POST['username'];
    $email=$_POST['email'];
    $status=$_POST['status'];

    $updateQuery="UPDATE  users set  username= ?,email= ?,status= ? where user_id=?";

    $updatestmt=$conn->prepare($updateQuery);
    $updatestmt->bind_param("sssi",$username,$email,$status,$user_id);
    $updatestmt->execute();
    header('Location:manage_users.php');
}
}
  ?>

  <div class="admin-page">
    <h2>Edit User</h2>
    <form action="" method="post">
      <h3>username:<?php echo $user['username']; ?></h3>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
        <select name="status" id="">
            <option value="active"<?php if($user['status']=='active') echo 'selected';?>>active</option>
            <option value="inactive"<?php if($user['status']=='inactive') echo 'selected';?>>inactive</option>
        </select>
        <button type="submit">Update User</button>
    </form>
  </div>
  <?php 
include('../includes/admin_footer.php');
?>