<!-- SUBSCRIPTION Page -->

<?php

session_start();

include('includes/db_connect.php');

$user_id=$_SESSION['user_id'] ?? null;


//Fetch subsscription plans

$plans_query="SELECT * FROM plans";
$plans_result=mysqli_query($conn,$plans_query);

//Check if user has an active subscription

$subscription_query="SELECT * From  subscriptions WHERE  user_id=?";
$stmt=$conn->prepare($subscription_query);
$stmt->bind_param("i",$user_id);
$stmt->execute();

$subscription_result=$stmt->get_result();
$has_active_subscription=$subscription_result->num_rows > 0;
$stmt->close();

//handle subscription process

$message="";

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['plan_id']))
{
    $plan_id=$_POST['plan_id'];

    //Fetch Plan details

    $plan_query="SELECT * FROM plans WHERE plan_id=?";
    $stmt=$conn->prepare($plan_query);
    $stmt->bind_param("i",$plan_id);
    $stmt->execute();

    $result=$stmt->get_result();
    $plan=$result->fetch_assoc();
    $stmt->close();

    if(!$plan){
        $message="<div class='alert error'>Plan not Found!</div>"; //icon missing
    }
    elseif($has_active_subscription){
        $message="<div class='alert warning'>
        <div class='animation-box warning-icon'><i>&#9888;</i></div> 
        You already have an active subscription!</div>";        //Warning Icon missing
    }
    else{
        //calculate subscription period

        $start_date=date('Y-m-d');
        $end_date=date('Y-m-d',strtotime("+{$plan['duration']} days"));

        //Insert new subscription

        $insert_query="INSERT INTO subscriptions(user_id,plan_id,start_date,end_date)VALUES(?,?,?,?)";
        $stmt=$conn->prepare($insert_query);
        $stmt->bind_param("iiss",$user_id,$plan_id,$start_date,$end_date);

        if($stmt->execute()){
            $message="<div class='alert success'>
            <div class='animation-box success-icon'>
            <div class='checkmark'><i>&#127881</i></div>
          
            </div>
            Subscription Activated Enjoy your music.Redirecting to home...
            </div>
            <script>setTimeout(()=>{window.location.href='home.php';},5000);</script>";
            
        }
        else{
            $message="<div class'alert error'>Error Subscribing.Please try again.</div>";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Plans | SoundPlus</title>
    <style>
        /* General Styling */
        body {
            font-family: 'Arial', sans-serif;
            background: #ffffff;
            color: #333;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        /* Back to Home Button */
        .back-home {
            position: absolute;
            top: 20px;
            left: 20px;
            text-decoration: none;
            color: rgb(185, 29, 29);
            font-size: 18px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease-in-out;
        }

        .back-home:hover {
            color: rgb(170, 26, 24);
        }

        .back-home-icon {
            width: 24px;
            height: 24px;
            fill: #1DB954;
        }

        /* Subscription Container */
        .subscription-container {
            max-width: 1000px;
            margin: 50px auto;
            background: #f9f9f9;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        /* Plans Grid */
        .plans {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        /* Plan Card */
        .plan-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 25px;
            text-align: left;
            border: 2px solid #ddd;
            transition: all 0.3s ease-in-out;
            position: relative;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .plan-card:hover {
            border-color:  rgb(170, 26, 24);;
            transform: scale(1.03);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        /* Subscribe Button */
        .subscribe-btn {
            display: block;
            width: 100%;
            background: rgb(170, 26, 24);;
            border: none;
            color: white;
            padding: 12px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 8px;
            margin-top: 15px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .subscribe-btn:hover {
            background: rgb(185, 29, 29);
        }

        /* Subscription Messages */
        .alert {
            padding: 15px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
            animation: fadeIn 0.5s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .alert.success {
            background: #1DB954;
            color: white;
        }

        .alert.warning {
            background: #f1c40f;
            color: #333;
        }

        .alert.error {
            background: #e74c3c;
            color: white;
        }

        /* Animated Icons */
        .animation-box {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 24px;
            font-weight: bold;
        }

        .success-icon {
            background: #1DB954;
            color: white;
            animation: scaleUp 0.5s ease-in-out;
        }

        .warning-icon {
            background: #f1c40f;
            color: #333;
            animation: shake 0.5s ease-in-out;
        }

        .checkmark {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #1DB954;
            font-weight: bold;
        }

        /* Success Animation */
        @keyframes scaleUp {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Warning Shake */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
        }

    </style>
</head>
<body>
    <a href="home.php" class="back-home">
        ⬅ Back to Home
    </a>

    <div class="subscription-container">
        <h2>Choose Your Plan</h2>
        <?= $message ?>
        <div class="plans">
            <?php while($plan=mysqli_fetch_assoc($plans_result)) {?>
                <div class="plan-card">
                    <h3><?= htmlspecialchars($plan['name'])?></h3>
                    <p><?= htmlspecialchars($plan['description'])?></p>
                    <p class="price">&#8377;<?= htmlspecialchars($plan['price'])?></p>
                    <form  method="post">
                        <input type="hidden" name="plan_id" value="<?= $plan['plan_id'] ?>">
                        <button class="subscribe-btn" type="submit">Subscribe</button>
                    </form>
                </div>
                <?php }?>
        </div>
    </div>
</body>
</html>
