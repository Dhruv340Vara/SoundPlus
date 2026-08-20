<!-- Profile -->

<?php
 session_start();
 include('includes/db_connect.php');

 if(!isset($_SESSION['user_id'])){
    header('Location: home.php');
 }

//Initialize variable

$error='';
$success='';
$user=[];
$allowed_types=['image/jpeg','image/png','image/jpg'];  //jpeg,png,gif
$max_size=2 * 1024 * 1024; //2MB

//Fetch user data

$user_id=$_SESSION['user_id'];
$stmt=$conn->prepare("SELECT username,email,mobile,profile_picture,dob,gender FROM users WHERE user_id= ?");
$stmt->bind_param("i",$user_id);
$stmt->execute();
$result=$stmt->get_result();
$user=$result->fetch_assoc();
$stmt->close();

//Handle Form Submission

if($_SERVER['REQUEST_METHOD'] ==='POST' && isset($_POST['update']))
{

    //sanitize inputs

    $username=filter_input(INPUT_POST,'username');
    $email=filter_input(INPUT_POST,'email');
    $mobile=filter_input(INPUT_POST,'contact'); //diffrent
    $dob=$_POST['dob'];
    $gender=filter_input(INPUT_POST,'gender');

    //Handle Form submission

    if(!empty($_FILES['profile_image']['name']))
    {
        $upload_dir="../uploads/profile_picture/";

        if($_FILES['profile_image']['size']>$max_size){
            $error="File size must me less than 2MB";
        }
        elseif(!in_array($_FILES['profile_image']['type'],$allowed_types))
        {
            $error="Only JPG,PNG, and GIF files are allowed";
        }
        else{
            if(!file_exists($upload_dir))
            {
                mkdir($upload_dir,0755,true);
            }

            $file_ext=pathinfo($_FILES['profile_image']['name'],PATHINFO_EXTENSION);

            $filename=uniqid().'.'.$file_ext;
            $target_file=$upload_dir.$filename;

            if(move_uploaded_file($_FILES['profile_image']['tmp_name'],$target_file)){
                //Delete old file

                if(!empty($user['profile_picture'])){
                    $old_file=$upload_dir.$user['profile_picture'];

                    if(file_exists($old_file))unlink($old_file); //unlink old file 
                }
                $update_stmt=$conn->prepare("UPDATE users SET profile_picture=? WHERE user_id=?");
                $update_stmt->bind_param("si",$filename,$user_id);
                $update_stmt->execute();
                $update_stmt->close();
            }
            else{
                $error="Error uploading file";
            }
        }
    }

    //Update user Data

    $update_stmt=$conn->prepare("UPDATE users SET username=?,email=?,mobile=?,dob=?,gender=? WHERE user_id=?");
    $update_stmt->bind_param("sssssi",$username,$email,$mobile,$dob,$gender,$user_id);

   if($update_stmt->execute()){
    $success="Profile updayed successfully!";

    //Refresh user data

    $stmt=$conn->prepare("SELECT username,email,mobile,profile_picture,dob,gender FROM users WHERE user_id=?");
    $stmt->bind_param("i",$user_id);
    $stmt->execute();

    $result=$stmt->get_result();
    $user=$result->fetch_assoc();
    $stmt->close();
   }
   else{
      $error="error updating profile";
   }
   $update_stmt->close();
}

//fetch subscription detail

$sub_stmt=$conn->prepare("SELECT p.name As plan_name,p.price,s.start_date,s.end_date FROM subscriptions s JOIN
plans p ON s.plan_id=p.plan_id WHERE s.user_id=? AND s.end_date>=CURDATE()");

$sub_stmt->bind_param("i",$user_id);
$sub_stmt->execute();

$sub_result=$sub_stmt->get_result();
$subscription=$sub_result->fetch_assoc();
$sub_stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SoundPlus - Profile</title>
    <link rel="stylesheet" href="assets/css/user_profile.css">
</head>

<body>
    <svg style="display: none;">
        <symbol id="icon-home" viewBox="0 0 24 24">
            <path d="M12 2L2 12h3v8h6v-6h2v6h6v-8h3L12 2z"/>
        </symbol>
        <symbol id="icon-profile" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
        </symbol>
        <symbol id="icon-edit" viewBox="0 0 24 24">
            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
        </symbol>
        <symbol id="icon-lock" viewBox="0 0 24 24">
            <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
        </symbol>
        <symbol id="icon-crown" viewBox="0 0 24 24">
            <path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5zm14 3c0 .55-.45 1-1 1H6c-.55 0-1-.45-1-1s.45-1 1-1h12c.55 0 1 .45 1 1z"/>
        </symbol>
        <symbol id="icon-logout" viewBox="0 0 24 24">
            <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
        </symbol>
    </svg>

    <div class="container">
        <?php if($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php  endif; ?>

        
        <div class="header">
            <a href="home.php" class="nav-home">
                <svg class="icon"><use xlink:href="#icon-home"/></svg>
                SoundPlus
            </a>
            
            <div class="profile-dropdown">
                <button class="btn btn-secondary">
                    <svg class="icon"><use xlink:href="#icon-profile"/></svg>
                    <?php echo htmlspecialchars($user['username']); ?>
                </button>
                
                <div class="dropdown-menu">
                    <a href="user_profile.php" class="dropdown-item">
                        <svg class="icon"><use xlink:href="#icon-edit"/></svg>
                        Edit Profile
                    </a>
                    <a href="subscription.php" class="dropdown-item">
                        <svg class="icon"><use xlink:href="#icon-crown"/></svg>
                        Subscriptions
                    </a>
                    <a href="logout.php" class="dropdown-item">
                        <svg class="icon"><use xlink:href="#icon-logout"/></svg>
                        Log Out
                    </a>
                </div>
            </div>
        </div>


        <div class="profile-section">
            <nav class="sidebar">
                <a href="user_profile.php" class="nav-item">
                    <svg class="icon"><use xlink:href="#icon-edit"/></svg>
                    Edit Profile
                </a>
                <a href="forgot_password_form.php" class="nav-item">
                    <svg class="icon"><use xlink:href="#icon-lock"/></svg>
                    Change Password
                </a>
                <a href="subscription.php" class="nav-item">
                    <svg class="icon"><use xlink:href="#icon-crown"/></svg>
                    Subscriptions
                </a>
            </nav>

            <main class="main-content">
                <div class="profile-header">
                    <img src="../uploads/profile_picture/<?= htmlspecialchars($user['profile_picture']) ?>" 
                         alt="Profile" 
                         class="profile-pic">
                    <div>
                        <h1><?= htmlspecialchars($user['username']) ?></h1>
                        <div class="profile-actions">
                            
                        </div>
                    </div>
                    <div class="subscription-status">
                    <h2>Subscription Status</h2>
                    <?php if ($subscription): ?>
                        <p><strong>Plan:</strong> <?= htmlspecialchars($subscription['plan_name']) ?></p>
                        <p><strong>Price:</strong> &#8377;<?= htmlspecialchars($subscription['price']) ?></p>
                        <p><strong>Valid Until:</strong> <?= htmlspecialchars($subscription['end_date']) ?></p>
                    <?php else: ?>
                      <button class="btn btn-primary">  <use xlink:href="#icon-crown"/><p style="color: red;">No active subscription. <a href="subscription.php">Subscribe Now</a></p>
                    </button>              <?php endif; ?>
                </div>
                </div>

                <form action="user_profile.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input type="text" 
                               class="form-input"
                               value="<?= htmlspecialchars($user['username']) ?>"
                               name="username" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Profile Image</label>
                        <div class="upload-wrapper">
                            <label class="upload-label">
                                <svg class="icon"><use xlink:href="#icon-edit"/></svg>
                                Choose File
                                <input type="file" 
                                       id="file-input"
                                       name="profile_image"
                                       accept="image/*">
                            </label>
                            <span id="file-name" style="margin-left: 1rem; color: var(--text-secondary)"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" 
                               class="form-input"
                               value="<?= htmlspecialchars($user['email']) ?>"
                               name="email" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" 
                               class="form-input"
                               value="<?= htmlspecialchars($user['mobile']) ?>"
                               name="contact" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Birthday</label>
                        <input type="date" 
                               class="form-input"
                               value="<?= htmlspecialchars($user['dob']) ?>"
                               name="dob">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Gender</label>
                        <select class="form-input" name="gender">
                            <option value="male" <?= $user['gender'] === 'male' ? 'selected' : '' ?>>Male</option>
                            <option value="female" <?= $user['gender'] === 'female' ? 'selected' : '' ?>>Female</option>
                            <option value="other" <?= $user['gender'] === 'other' ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>

                    <button type="submit" name="update" class="btn btn-primary">
                        <svg class="icon"><use xlink:href="#icon-edit"/></svg>
                        Save Changes
                    </button>
                </form>
            </main>
        </div>
    </div>

    <script src="assets/js/user_profile.js"></script>
</body>
</html>