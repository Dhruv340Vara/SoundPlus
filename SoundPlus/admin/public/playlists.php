<!-- playlist -->

<?php 
session_start();
include('includes/db_connect.php');

if(!isset($_SESSION['user_id'])){
    header('Location: login.html');
 }


$user_id=$_SESSION['user_id'] ?? null;

//Fetch users's playlists

$query="SELECT id,name FROM playlists WHERE user_id=?";
$stmt=$conn->prepare($query);
$stmt->bind_param("i",$user_id);
$stmt->execute();
$result=$stmt->get_result();


$playlists=[];

while($row=$result->fetch_assoc()){
    $playlists[]=$row;
}

//Handle plalists deletion

if(isset($_POST['delete_playlist'])){
    
    $playlistId=$_POST['playlist_id'] ?? null;
    
    if(!empty($playlistId) && is_numeric($playlistId))
    {
        $deleteQuery="DELETE from playlists where id=? and user_id=?";
        $stmt=$conn->prepare($deleteQuery);
        $stmt->bind_param("ii",$playlistId,$user_id);
        if($stmt->execute()){
            header("Location: playlists.php");
        exit();
    }
    else{
        echo "Error deleting plalists: ".mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Playlist</title>

    <style>
        body{
            font-family:arial,sans-serif;
            margin:0;
            padding:0;
            background-color:#f5f5f5;
            color:#333;
        }
        main{
            padding:40px;
        }
        h1{
            font-size:32px;
            margin-bottom: 30px;
            color:#333;
        }
        .playlist-container{
            display: grid;
            grid-template-columns: repeat(auto-fill,minmax(250px,1fr));
            gap:25px;
        }
        .playlist-card{
            background: white;
            border-radius: 12px;
            overflow: visible;
            box-shadow: 0 4px 8px rgba(0, 0,0,0.1);
            transition:transform 0.3s ease,box-shadow 0.3s ease;
            cursor: pointer;
            position: relative;
        }
        .playlist-card:hover{
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0,0,0.2);
        }
        .playlist-card h3{
            padding:20px;
            margin:0;
            font-size: 18px;
            font-weight: 500;
            text-align: center;
            color:#444;
        }

        /* Three Dot Dropdownn */

        .playlist-actions{
            position: absolute;
            top:10px;
            right: 10px;
            cursor: pointer;
            z-index: 10;
        }
        .playlist-actions .dots{
            font-size: 24px;
            color:#666;
            padding:5px;
        }
        .playlist-actions .dropdown-menu{
            display: none;
            position: absolute;
            top:100%;
            right:0;
            background: white;
            border: 10x solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0,0,0.1);
            z-index: 20;
            min-width: 120px;
         }
         .playlist-actions .dropdown-menu ul{
            list-style: none;
            margin: 0;
            padding: 0;
         }
         .playlist-actions .dropdown-menu ul li{
            padding:10px 20px;
            cursor:pointer;
            white-space: nowrap;
         }

         .playlist-actions .dropdown-menu ul li:hover{
            background: #f1f1f1;
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
    </style>
</head>
<body>
    <!-- Header -->

    <header>
    <a href="home.php" class="back-home">
        ⬅ Back to Home
    </a>
    </header>

    <!-- Main Content -->
    
    <main>
        <h1>My Playlists</h1>

        <div class="playlist-container">
            <?php foreach ($playlists as $playlist): ?>

            <div class="playlist-card">
                <!-- Playlist Name -->

                <h3 onclick="viewPlaylist(<?= $playlist['id'] ?>)"><?= htmlspecialchars($playlist['name']) ?></h3>

                <!-- Three Dots Dropdown -->

                <div class="playlist-actions">
                    <div class="dots" onclick="toggleDropdown(this)">...</div>

                    <div class="dropdown-menu">
                        <ul>
                            <li onclick="deletePlaylist(<?= $playlist['id'] ?>)">Delete</li>
                        </ul>
                    </div>
                 </div>
                
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script>
        //Toggle dropdown menu


        function toggleDropdown(element){
            const dropdown=element.nextElementSibling;

            dropdown.style.display=dropdown.style.display === 'block' ? 'none':'block';

            event.stopPropagation();
        }
         //close dropdown when clicking outside 

            document.addEventListener('click',function() {
               const dropdowns=document.querySelectorAll('.dropdown-menu');
               dropdowns.forEach(dropdown => {
                dropdown.style.display='none';
               });
            });

            //Delete Playlist

            function deletePlaylist(playlistId){

                if(confirm("Are you sure you want to delete this playlist?")){
                    const form=document.createElement('form');

                    form.method='POST';
                    form.style.display='none';

                    const input=document.createElement('input');
                    input.type='hidden';
                    input.name='playlist_id';
                    input.value=playlistId;

                    const deleteInput=document.createElement('input');

                    deleteInput.type='hidden';
                    deleteInput.name='delete_playlist';
                    deleteInput.value='1';

                    form.appendChild(input);
                    form.appendChild(deleteInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            }

            //View playlist

            function viewPlaylist(playlistId){
                window.location.href=`view_playlist.php?id=${playlistId}`;
            }
        
    </script>
</body>
</html>