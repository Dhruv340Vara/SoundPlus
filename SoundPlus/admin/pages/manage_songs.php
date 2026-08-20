<!-- Manage Songs -->

<?php
 session_start();

 if(!isset($_SESSION['admin']))
 {
    header('Location: login.php');
    exit();
 }
 


//  Include admin header

include('../includes/admin_header.php');
include('../includes/admin_db_connect.php');

$query="SELECT * FROM songs";
$result=mysqli_query($conn,$query);

?>
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

    <table border="1">
       
    <h1>Upload New Song</h1>

    <a href="add_song.php" class="a">⬅ Add New Song</a>

    <tr>
        <th>Song ID</th>
        <th>Title</th>
        <th>Artist ID</th>
        <th>Album ID</th>
        <th>Genre</th>
        <th>File Path</th>
        <th>Uploaded At</th>
        <th>Status</th>
        <th>Cover Image</th>
        <th>Actions</th>
        <th>Play</th>
    </tr>

    <?php  while($row=mysqli_fetch_assoc($result)) { ?>
      
        <tr>
             <td><?=$row['song_id'] ?></td>
             <td><?=$row['title'] ?></td>
             <td><?=$row['artist_id'] ?></td>
             <td><?=$row['album_id'] ?></td>
             <td><?=$row['genre'] ?></td>
             <td><?=$row['file_path'] ?></td>
             <td><?=$row['uploaded_at']?></td>
             <td><?=$row['status']?></td>
             <td><img src="<?=$row['cover_image'] ?>" alt="Cover" width="50"></td>
             <td><a href="edit_song.php?id=<?=$row['song_id'] ?>">Edit</a> |
             <a href="delete_song.php?id=<?=$row['song_id'] ?>" onclick="return confirm('Are sure You Want to Delete This Song')">Delete</a>
             </td>

             <td>
                 <!-- Play/Pause button with css style and progress bar -->
                 <button class="playPauseBtn" onclick="togglePlayPause('<?=$row['file_path'] ?>',this)">
                 <span class="playIcon">▶</span>
                <span class="pauseIcon" style="display:none;">⏸</span>
                </button>

                <div class="progressBarContainer">
                    <progress class="progressBar" value="0" max="100"></progress>
                </div>
             </td>
        </tr>
        <?php } ?>
    </table>
    
    <!-- Javascript -->

    <script>
     
      function togglePlayPause(filePath,button){

        var progressBar=button.closest('td').querySelector('.progressBar');
        var playIcon=button.querySelector('.playIcon');
        var pauseIcon=button.querySelector('.pauseIcon');

        if(button.audio && !button.audio.paused){

            button.audio.pause();
            playIcon.style.display='inline';
            pauseIcon.style.display='none';
            progressBar.value=0;
            return;
        }

        if(!button.audio){
            button.audio= new Audio(filePath);
            button.audio.addEventListener('timeupdate',function()
            {
            progressBar.value=(button.audio.currentTime / button.audio.duration) * 100;
            }); 
        }
        button.audio.play();
        playIcon.style.display='none';
        pauseIcon.style.display='inline';
      }
    </script>

    <!-- Css For Manage song Page -->

    <style>
        /*Play/Pause button styling */

        .playPauseBtn{
            background-color:#4CAF50; /* professional green */
            color:white;
            border:none;
            padding:15px;
            cursor: pointer;
            font-size:20px;
            border-radius:50%;
            width:60px;
            height:60px;
            display:flex;
            justify-content:center;
            align-items:center;
            transition: background-color 0.3 ease;
            box-shadow:0 4px 6px rgba(0,0,0,0.1);
        }

        .playPauseBtn:hover{
            background-color:#45a049; /* darker green on hover */
        }

        .playPauseBtn:active{
            background-color:#388e3c; /* even darker green on click */
        }

        /*Progress Bar Styling */

        .progressBarContainer{
            margin-top:10px;
            width:100%;
        }

        .progressBar{
            width:100%;
            height:100%;
            border-radius:5px;
            background-color:#f1f1f1;
            box-shadow:inset 0 2px 4px rgba(0,0,0,0.1);
        }

        /*Play and Pause icon visibility */

        .playIcon{
            font-size:30px;
            color:#fff;
        }

        .pauseIcon{
            font-size:30px;
            color:#fff;
        }
    </style>


<?php include('../includes/admin_footer.php'); ?>