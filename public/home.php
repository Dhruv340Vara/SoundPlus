
<?php
session_start();

include('includes/db_connect.php');

$category=isset($_GET['category']) ? $_GET['category'] : 'all';


//Modify Sql query based on category
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $sql="SELECT songs.*, artists.name AS artist_name FROM songs JOIN artists ON songs.artist_id = artists.artist_id WHERE songs.song_id=$id";
}
elseif($category == 'all')
{
    $sql="SELECT songs.*, artists.name AS artist_name FROM songs JOIN artists ON songs.artist_id = artists.artist_id";
}
elseif($category == 'old')
{
    $sql="SELECT songs.*, artists.name AS artist_name FROM songs JOIN artists ON songs.artist_id = artists.artist_id WHERE song_id BETWEEN 1 AND 10";
}
elseif($category == 'radio')
{
    $sql="SELECT songs.*, artists.name AS artist_name FROM songs JOIN artists ON songs.artist_id = artists.artist_id WHERE song_id BETWEEN 1 AND 16";
}
elseif($category == 'top_artist')
{
    $sql="SELECT songs.*, artists.name AS artist_name FROM songs JOIN artists ON songs.artist_id = artists.artist_id WHERE song_id BETWEEN 1 AND 20";
}
elseif($category == 'trending')
{
    $sql="SELECT songs.*, artists.name AS artist_name FROM songs JOIN artists ON songs.artist_id = artists.artist_id WHERE song_id ORDER BY song_id DESC LIMIT 10";
}
elseif($category == 'new')
{
    $sql="SELECT songs.*, artists.name AS artist_name FROM songs JOIN artists ON songs.artist_id = artists.artist_id WHERE song_id ORDER BY song_id ASC LIMIT 9";
}
else{
    $sql="SELECT songs.*, artists.name AS artist_name FROM songs JOIN artists ON songs.artist_id = artists.artist_id"; //Default fetch all songs
}

$result=$conn->query($sql);

//if it's ajax request return JSON (category+ songlist)

if(isset($_GET['ajax']))
{
    $songs_html="";

    while($row=mysqli_fetch_assoc($result))
    {
        $songs_html .='  <div id="songs-container" class="music-library">
        '. $row["cover_image"].'
        <div class="song-card" onclick="checkLoginAndSubscription(\''.$row['file_path'].'\', \''. $row['title'].'\',\' ../admin/assets/images/album_covers/'.$row['cover_image'] .'\', \''.$row['artist_name'] .'\')">
           <img src="../admin/assets/images/album_covers/'.$row['cover_image'].'" alt="Cover" class="song-cover">

           <div class="play-button"><i>&#9658</i></div>
           <div class="song-info">
             <h3 class="song-title">'. $row['title'] .'</h3>
           </div>

              
           <!-- Download Functionality -->
           <!-- Three-dot menu bbutton -->
           
           <div class="menu-container">
                  <button class="menu-btn" onclick="myfun()">...</button>
                  <div class="menu-dropdown">
                     <a href="'.$row['file_path'].'" download="basename("'.$row['file_path'].'")">Download</a>
                     
                  
                  </div>
                </div>
        </div>
      
      
             
          <!-- End download Funtionbality -->
        <?php } ?>
    </div>';
    }

    //json code


    echo json_encode([
        "category" => ucfirst($category), //send category name
        "html" => $songs_html //send generated HTML
    ]);
    exit;
}

$is_logged_in=isset($_SESSION['user_id']) ;

$user_id=$is_logged_in ? $_SESSION['user_id'] : null;


// $is_subsribed=false;
// if($is_logged_in){
//     $subscription_query="SELECT * from subscriptions where user_id =$user_id limit 1";
//     $subscription_result=mysqli_query($conn,$subscription_query);
//     $is_subsribed=mysqli_num_rows($subscription_result)>0;
// }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo'SoundPlus' ?></title>
   
    <link rel="stylesheet" href="assets/css/home_message.css">
    <link rel="stylesheet" href="assets/css/player.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/playlist.css">
    <link rel="stylesheet" href="assets/css/artistandalbumfetch.css">
 
</head>
<body>
    <header>
        <button class="toggle-sidebar" id="sidebar-toggle">☰</button>
        <div class="logo">SoundPlus</div>
        <div class="header-right">
            
           

<!-- for search  -->
        <div class="search-container">
                <form action="" method="GET" id="search-form">
                <input type="text"   id="search-bar" placeholder="Search Artist,Album Song" class="search-bar" onkeyup="searchFunction()"/>
                <button class="search-icon" style="background: none; border: none; cursor: pointer;" type="submit">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="#555">
        <path d="M10 2a8 8 0 1 0 4.9 14.32l5.6 5.61a1 1 0 0 0 1.4-1.42l-5.61-5.6A8 8 0 0 0 10 2zm0 2a6 6 0 1 1 0 12A6 6 0 0 1 10 4z"/>
    </svg>
</button>
<div id="result-box"></div>
<script src="assets/js/search.js"></script>
</form>
<!-- end serach -->
<!-- Auto-Suggestion container end -->           
</div>


<!--start subscriptin-->
            <!-- <div class="actions">
                <button class="pro" id="pro" onclick="pro()">Join SoundPlus Pro</button>
                <script>
                    function pro()
                    {
                        let isLoggedIn=<?= isset($_SESSION['user_id']) ? 'true' : 'false'  ?>;
                        if(!isLoggedIn)
                        {
                            showLoginMessage();
                            setTimeout(() => {
                                window.location.href="login.html";
                            }, 1000);
                        return;
                        }
                        else{
                            window.location.href="subscription.php";
                        }
                    }
                </script>
            </div> -->
<!--end subscriptin-->

<!--playlist-->
 <Button class="play" onclick="window.location.href='playlists.php'">+Your playlist</Button>
<!--end -->

            <div id="theme-toggle" class="sunmoon">
                <!-- Sun Icon (Hidden by default) -->
                <svg id="sun-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
                    <circle cx="12" cy="12" r="5"></circle>
                    <line x1="12" y1="1" x2="12" y2="3"></line>
                    <line x1="12" y1="21" x2="12" y2="23"></line>
                    <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                    <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                    <line x1="1" y1="12" x2="3" y2="12"></line>
                    <line x1="21" y1="12" x2="23" y2="12"></line>
                    <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                    <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                </svg>
                <!-- Moon Icon (Visible by default) -->
                <svg id="moon-icon"  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79z"></path>
                </svg>
            </div>
            
       
            <?php if (isset($_SESSION['user_id'])): ?> 
    <div class="profile-menu"> <img src="assets/images/p.png" alt="Profile Icon" class="profile-icon" onclick="toggleMenu()"/>
  <div class="dropdown-menu" id="dropdownMenu">
    <ul>
      <li><a href="user_profile.php">Profile</a></li>
     
      <li><a href="logout.php" class="logout" onclick="return confirm('Are you sure you want to Leave.?');">Logout</a></li>
     
    </ul>
  </div>
</div>
              
            <?php else: ?>
               <!--  Show Login/Signup Links -->
              <a href="login.html" style="text-decoration:none; color:black;"  ><span class="span" >Login</span></a>
                <a href="signup.html" style="text-decoration:none; color:black;" ><span class="span">Sign Up</span></a>
            <?php endif; ?> 
              
        </div>
      
    </header>

    <aside class="sidebar" id="sidebar">
        <div class="profile">
            

            <?php if (isset($_SESSION['user_id'])): ?>
                <img src="assets/images/p.png" style=" margin-top:14px; width:35px; height:30px"></img> 
            <div class="p2">Hello,<?php echo htmlspecialchars($_SESSION['username']); ?></div>
        <?php else: ?>
            <img src="assets/images/p.png" style="margin-top:15px; width:40px; height:30px"></img>
            <a href="login.html" style="text-decoration: none; color: black; "><div class="p1">Login</div></a>
           <a href="signup.html" style="text-decoration:none; color:black; margin-left:10px;"> <div class="p2">Sign Up</div></a>
        <?php endif; ?>
        </div>
        <ul>
            <a href="home.php" style="text-decoration:none;"><li>Home</li></a>
            <a href="home.php" style="text-decoration:none;"><li>Geners</li></a>
            <a href="playlists.php" style="text-decoration:none;"><li>playlist</li></a>
            <a href="home.php" style="text-decoration:none;"><li>Artists</li></a>
            <a href="home.php" style="text-decoration:none;"><li>Albums</li></a>
            <h3>Quick Access</h3>
            <a href="home.php" style="text-decoration:none;"><li>Trending songs</li></a>
            <a href="home.php" style="text-decoration:none;"><li>New songs</li></a>
            <a href="home.php" style="text-decoration:none;"><li>old songs</li></a>
           
            <h3>Account</h3>
            <li><a href="user_profile.php" class="sidebar-link">profile</a></li>
            <li><a href="logout.php" class="sidebar-link" onclick="return confirm('Are you sure you want to Leave.?');">Logout</a></li>
          
        </ul>
        </aside>


        <nav class="nav">
            <ul>
                <li><a href="http://localhost/soundplus/public/home.php" onclick="fetchSongs('all')">All</a></li>
                <li><a href="http://localhost/soundplus/public/artist.php?artist_id=12" onclick="fetchSongs('top_artist')">Top Artist</a></li>
                <li><a href="http://localhost/soundplus/public/album.php?album_id=4" onclick="fetchSongs('top_playlist')">Top PlayList</a></li>
                <li><a href="http://localhost/soundplus/public/album.php?album_id=15" onclick="fetchSongs('trending')">Trending</a></li>
                <li><a href="http://localhost/soundplus/public/home.php" onclick="fetchSongs('new')">New Songs</a></li>
                <li><a href="http://localhost/soundplus/public/album.php?album_id=6" onclick="fetchSongs('old')">Old Songs</a></li>
                <li><a href="http://localhost/soundplus/public/home.php" onclick="fetchSongs('genres')">Genres</a></li>
                <li><a href="http://localhost/soundplus/public/home.php" onclick="fetchSongs('album')">Album</a></li>
                <li><a href="http://localhost/soundplus/public/home.php" onclick="fetchSongs('radio')">Radio</a></li>
            </ul>
        </nav>

       
      <!-- sidebar ovelay effect -->
        <div id="sidebar-overlay" class="sidebar-overlay"> </div>

       <!-- end -->

  <!-- playlist start-->
  <div id="playlist-modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closePlaylistModal()">&times;</span>
        <h2>Add to Playlist</h2>
        <div id="playlist-list">

        </div>
        <button onclick="createNewPlaylist()">Create New Playlist</button>
    </div>
  </div>
  <style>
  .modal{
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.5);
}
.modal-content{
    background-color: #fff;
    margin:15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
    max-width: 500px;
    border-radius: 8px;
    cursor: pointer;

}
.close{
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}
.close:hover{
    color: #000;
}

</style>
  <script>
    function addToPlaylist(songId){
       
                    const isLoggedIn=<?= json_encode($is_logged_in) ?>;
         

                    if(!isLoggedIn){
                      alert("Please log in to add playlist.");
                      window.location.href="login.html";
                      return;
                    }

                    openPlaylistModal(songId);

                }

                let currentSongId=null;

                function openPlaylistModal(songId){
                    currentSongId=songId;
                    document.getElementById('playlist-modal').style.display='block';
                    fetchUserPlaylists();
                }


                function  closePlaylistModal(){
                    document.getElementById('playlist-modal').style.display='none';
                }


                function fetchUserPlaylists()
                
                {
                    const userId=<?= json_encode($_SESSION['user_id'] ?? null) ?>;
                    if(!userId)  return;

                    fetch(`fetch_playlists.php?user_id=${userId}`)
                    .then(response => response.json())
                    .then(data => {
                        const playlistList=document.getElementById('playlist-list');
                        playlistList.innerHTML =' ';

                        data.forEach(playlist => {
                            const playlistitem=document.createElement('div');
                            playlistitem.className='playlist-item';
                            playlistitem.textContent=playlist.name;
                            playlistitem.onclick=()=>addSongToPlaylist(playlist.id,currentSongId);
                            playlistList.appendChild(playlistitem);
                        });

                    })
                    .catch(error => console.error('Error fetching Playlists:',error));
                }


                function addSongToPlaylist(playlistId,songId){
                    fetch('add_to_playlist.php',{
                        method:'POST',
                        headers:{
                            'Content-type':'application/json'
                        },
                        body:JSON.stringify({playlistId,songId})
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success){
                            alert("song added to playlist sucessfully.");
                            closePlaylistModal();
                        }
                        else{

                            alert("failed to add song to  playlist ."); 
                        }
                    })
                    .catch(error => console.error('Error adding song to playlist:',error));
                }
          

            function createNewPlaylist(){
                const playlistName=prompt('Emter a name for your new playlists:');
                if(playlistName){
                    const userId=<?= json_encode($_SESSION['user_id'] ?? null )?>;
                    fetch('create_playlist.php',{
                        method:'POST',
                        headers:{
                            'Content-type':'application/json'
                        },
                        body: JSON.stringify({userId,playlistName})
                        
                    })
                   .then(response => response.json())
                    .then(data => {
                        if(data.success){
                            fetchUserPlaylists();
                        }
                        else{
                            alert('failed to create playlist.')
                        }
                    })
                    .catch(error => console.error('Error creating playlist:',error));
                }
            }

 </script>
  




  
<main id="main-content">

    <h2 id="category-title" style="margin-left:20px"><?php echo ucfirst($category);?>  Songs</h2>
    <div id="songs-container" class="music-library">
                <?php while($row=mysqli_fetch_assoc($result)) { 
                $path="../admin/assets/images/album_covers/".$row['cover_image'];    
                ?>

                    <div class="song-card" onclick="checkLoginAndSubscription('<?= $row['file_path'] ?>', '<?= $row['title'] ?>', '<?= $path ?>', '<?= $row['artist_name'] ?>')">
                   
                    <img src="<?= $path ?>" alt="Cover" class="song-cover">

                   <div class="play-button"><i>&#9658</i></div>
                   <div class="song-info">
                     <h3 class="song-title"><?= $row['title'] ?></h3>
                   </div>
                  <!-- Download Functionality -->
                  <!-- Three-dot menu bbutton -->
                  
                  <div class="menu-container">
                         <button class="menu-btn">...</button>
                         <div class="menu-dropdown">
                            <a href="<?= $row['file_path'] ?>" download="<?= basename($row['file_path']) ?>">Download</a>
                            <a onclick="addToPlaylist('<?= $row['song_id']?>')">Add to Playlist</a>
                           
                         </div>
                        
                       </div>
                     
                    <!-- End download Funtionbality -->
                </div>
               
                <?php } ?>
            </div>



           <!-- Artist Fetch -->
             <?php
            include('includes/db_connect.php');
            $is_logged_in=isset($_SESSION['user_id']);
            // $is_subsribed=false;
            // if($is_logged_in){
            //     $user_id=$_SESSION['user_id'];
            //     $subscriptionQuery="SELECT * FROM subscriptions WHERE user_id=$user_id AND end_date >= CURDATE()";
            //     $subscriptionResult=mysqli_query($conn,$subscriptionQuery);
            //     $is_subsribed=mysqli_num_rows($subscriptionResult) > 0;
            // }
            //Fetch Artists
            $artistQuery="SELECT artist_id,name,profile_picture FROM artists";
            $artistResult=mysqli_query($conn,$artistQuery);
            ?>

            <h2 style="margin-left: 20px;">Top Atists</h2>
            <div id="artists-list">
               <?php while($artist=mysqli_fetch_assoc($artistResult)) { ?>
                <?php 
                $folder="../admin/assets/images/artist_profiles/";
                $profilePicture=$artist['profile_picture'];
                //Construct the full image path
                $imagePath=$folder.$profilePicture;
                if(!empty($profilePicture) && file_exists($imagePath)){
                    $src=$imagePath;
                }
                else{
                    $src=$folder."default_artist.jpg";
                }
                ?>
                <!-- Artist Card -->
                <div class="artist-card" onclick="checkLoginAndSubscriptionArtist(<?= $artist['artist_id'] ?>)">
                <div class="artist-img-container">
                    <img src="<?= htmlspecialchars($src) ?>" alt="<?= htmlspecialchars($artist['name']) ?>" class="artist-img">

                    <div class="play-button"><i>&#9658;</i></div>
                </div>    
                <p class="artist-name"><?= htmlspecialchars($artist['name']) ?></p>
            </div>
            <?php } ?>
            </div>        
              <script>
                function checkLoginAndSubscriptionArtist(artistId){
                    const isLoggedIn=<?= json_encode($is_logged_in) ?>;

                    if(!isLoggedIn){
                        alert("Please log in to view artists.");
                        window.location.href="login.html";
                        return;
                    }

                    window.location.href=`artist.php?artist_id=${artistId}`;
                }
              </script>         
           <!--  Artist Fetch end -->




    <!-- Album Fetch -->
    <?php
     include('includes/db_connect.php');

     $is_logged_in=isset($_SESSION['user_id']);
    //  $is_subsribed=false;

    //  if($is_logged_in){
    //      $user_id=$_SESSION['user_id'];

    //      $subscriptionQuery="SELECT * FROM subscriptions WHERE user_id=$user_id AND end_date >= CURDATE()";

    //      $subscriptionResult=mysqli_query($conn,$subscriptionQuery);
    //      $is_subsribed=mysqli_num_rows($subscriptionResult) > 0;
    //  }
   
    $query="SELECT cover_image,title,album_id,release_date FROM albums";
    $result=mysqli_query($conn,$query);

    if(!$result){
        die("Query Failed:".mysqli_error($conn));
    }
    ?>
     <h2 style="margin-left:20px;">New Albums</h2>

     <div class="album-container">
       <?php while($album=mysqli_fetch_assoc($result)){ ?>
        <div class="album" onclick="checkLoginAndSubscriptionAlbum('<?=$album['album_id'] ?>')">
        <?php
         $imagePath="../admin/assets/images/album_covers/".$album['cover_image'];

         if(!empty($album['cover_image']) && file_exists($imagePath)){
            echo '<img src="'.$imagePath.'" alt="'.$album['title'].'">';   //single double quote more
         }
         else{
            echo '<img src="default_album.jpg" alt="No Image">';
         }
         ?>
         <div class="play-button"><i>&#9658</i></div>
         <p><?php echo htmlspecialchars($album['title']); ?></p>
        </div>
        <?php } ?>

        <script>

              function checkLoginAndSubscriptionAlbum(albumId)
              {
                    const isLoggedIn=<?= json_encode($is_logged_in) ?>;
                    // const isSubscribed = <?php //echo json_encode($is_subsribed) 
                    ?>;
                    
                    if(!isLoggedIn){
                      alert("Please log in to view album.");
                      window.location.href="login.html";
                      return;
                    }

                    // if(!isSubscribed){
                    //     alert("You nedd a subscription to view Album ");
                    //     window.location.href="suscription.html";
                    //      return;
                    // }

                    window.location.href=`album.php?album_id=${albumId}`;
              }
        </script>
      
     </div>        
</main>

<!-- new add a login message -->
<div id="login-message" class="login-message">
<p><i>&#127925; </i>Unlock the world of music!.please log in to start enjoying your favorite Songs.</p>
</div>


       
     
        <div class="music-player-bar">
        <div class="player-info">
            <img src="assets/images/p.png" alt="Track Cover" id="track-cover">
            <div class="track-details">
                <p class="track-title" id="track-title">Track Name</p>
                <p class="track-artist" id="track-artist">Artist Name</p>
            </div>
        </div>

        <div class="player-controls">
    <button onclick="playprevious()" >&#9664&#9664;</button>
    <button onclick="togglePlayPause()" id="play-pause">&#9658</button>
    <button onclick="playNext()" >&#9654&#9654;</button>
       </div>

       <div class="progress-container">
        <span class="time" id="current-time">0:00</span>
        <div class="progress-bar" onclick="seek(event)">
    <div class="progress" id="progress"></div></div>
    <span class="time" id="duration">0:00</span>
       </div>

       <div class="volume-controls">
        <label onclick="toggleMute()" id="mute-btn">🔊</label>
        <input type="range" id="volume" min="0" max="100" value="100" onchange="changeVolume()">
       </div>

       
    
</div>
</div>
        <script>
    let isPlaying = false;
    let isMuted = false;
    let audio = new Audio();

    let isLoggedIn=<?php echo json_encode($is_logged_in); ?>;
    // let isSubscribed=<?php //echo json_encode($is_subsribed); ?>;
    
    //check login and play song
    function checkLoginAndSubscription(filepath,title,cover,artist){
                        if(!isLoggedIn){
                            showLoginMessage();
                            window.location.href="login.html?redirect="+encodeURIComponent(window.location.href);
                        return;
                        
                        }
                        
                        playTrack(filepath,title,cover,artist);
                        }

    function showLoginMessage()
    {
        document.getElementById('login-message').style.display='flex';
    }         

    function togglePlayPause() {
        if (isPlaying) {
            audio.pause();
            document.getElementById('play-pause').textContent = '▶';
        } else {
            audio.play();
            document.getElementById('play-pause').textContent = '⏸';
        }
        isPlaying = !isPlaying;
    }

    function playPrevious() {
        const queueList = document.getElementById('queue-list').children;
        const currentTrack = Array.from(queueList).findIndex(item => item.classList.contains('active'));

        if (currentTrack > 0) {
            const previousTrack = queueList[currentTrack - 1];
            previousTrack.click();
        }
    }

    function playNext() {
        const queueList = document.getElementById('queue-list').children;
        const currentTrack = Array.from(queueList).findIndex(item => item.classList.contains('active'));

        if (currentTrack < queueList.length - 1) {
            const nextTrack = queueList[currentTrack + 1];
            nextTrack.click();
        }
    }

    function playTrack(filePath, title, cover, artist) {
        audio.src = filePath;
        document.getElementById('track-title').textContent = title;
        document.getElementById('track-artist').textContent = artist;
       
        document.getElementById('track-cover').src = cover;
        audio.play();
        isPlaying = true;
        document.getElementById('play-pause').textContent = '⏸';
    }

    function toggleMute() {
        isMuted = !isMuted;
        audio.muted = isMuted;
        document.getElementById('mute-btn').textContent = isMuted ? '🔇' : '🔊';
    }

    function changeVolume() {
        audio.volume = document.getElementById('volume').value / 100;
    }
  
    function playPrevious(){
        const queueList=document.getElementById('queue-list').children;

        const currentTrack=Array.from(queueList).findIndex(item=> item.classList.contains('active'));

        if(currentTrack>0){
            const previousTrack=queueList[currentTrack-1];
            previousTrack.click();
        }
    }

    function playNext(){
        const queueList=document.getElementById('queue-list').children;

        const currentTrack=Array.from(queueList).findIndex(item=>item.classList.contains('active'));

        if(currentTrack < queueList.length-1){
            const nextTrack=queueList[currentTrack - 1];

            nextTrack.click();
        }
    }
    //seek progress bar
    function seek(event) {
        const progressBar = event.currentTarget;
        const clickPosition = event.offsetX;
        const progressWidth = progressBar.offsetWidth;
        const clickRatio = clickPosition / progressWidth;
        audio.currentTime = clickRatio * audio.duration;
    }


    //queue
    function toggleQueue() {
        const queueDiv = document.getElementById('queue');
        queueDiv.style.display = queueDiv.style.display === 'flex' ? 'none' : 'flex';
    }


    //time
    audio.addEventListener('timeupdate', function () {
        const progress = (audio.currentTime / audio.duration) * 100;
        document.getElementById('progress').style.width = `${progress}%`;
        document.getElementById('current-time').textContent = formatTime(audio.currentTime);
        document.getElementById('duration').textContent = formatTime(audio.duration);
    });

    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${minutes}:${secs < 10 ? '0' : ''}${secs}`;
    }


        </script>
       
    <script src="assets/js/script.js"></script>
</body>
</html>
<?php 
include('rating.php');
?>
<?php 
include('footer.php');
?>








