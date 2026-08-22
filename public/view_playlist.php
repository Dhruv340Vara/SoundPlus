<!-- View Playlist -->

<?php 
session_start();
include('includes/db_connect.php');

if(!isset($_SESSION['user_id'])){
    header('Location: login.html');
 }


$playlistId=$_GET['id'];
$userId=$_SESSION['user_id'];

//Fetch playlists detail

$playlistquery="SELECT name FROM playlists WHERE id=$playlistId AND user_id=$userId";
$playlistResult=mysqli_query($conn,$playlistquery);

$playlist=mysqli_fetch_assoc($playlistResult);

if(!$playlist){
    die("Playlist not found or you don't have acccess");
}

//Fetch songs in the playlist

$songsQuery="SELECT s.song_id,s.title,s.cover_image,s.file_path,s.artist_id FROM songs s JOIN playlist_songs ps ON s.song_id=ps.song_id WHERE ps.playlist_id=$playlistId";

$songsResult=mysqli_query($conn,$songsQuery);

$songs=[];

while($row=mysqli_fetch_assoc($songsResult)){
    $songs[]=$row;
}

//Handle song deletin from playlist

if(isset($_POST['delete_song'])){
    $songId=$_POST['song_id'];
    $deleteQuery="DELETE FROM playlist_songs WHERE playlist_id=$playlistId AND song_id=$songId";

    if(mysqli_query($conn,$deleteQuery)){
        header("Location: view_playlist.php?id=$playlistId");
        exit();
    }
    else{
      echo "Error deleting song: ".mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($playlist['name']) ?> - Plalist</title>

    <style>
          body{
            font-family:arial,sans-serif;
            margin:0;
            padding:0;
            background-color:#f5f5f5;
            color:#333;
        }
        main{
          padding:20px;
        }
        h1{
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
        }
        .song-list{
            display: flex;
            flex-direction: column;
            gap:15px;
        }
        .song-card{
            background: white;
            border-radius: 8px;
            padding:15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease,box-shadow 0.3s ease;
        }
        .song-card:hover{
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
        .song-card img{
            width:60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            cursor: pointer;
        }
        .song-card .song-info{
            flex:1;
            margin-left: 15px;
        }
        .song-card  .song-info p{
            margin:5px 0 0;
            font-size: 14px;
            color:#666;
        }
        .song-card .song-actions{
            position: relative;
        }
        .song-card .dots{
            font-size:24px;
            color:#666;
            cursor: pointer;
            padding:5px;
        }
        .song-card .dropdown-menu{
            display: none;
            position:absolute;
            top:100%;
            right:0;
            background:white;
            border:1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            z-index: 10;
            min-width:120;
        }
        .song-card .dropdown-menu ul{
            list-style: none;
            margin:0;
            padding:0;
        }
        .song-card .dropdown-menu ul li{
            padding: 10px 20px;
            cursor: pointer;
            white-space: nowrap;
        }
        .song-card .dropdown-menu ul li:hover{
            background:#f1f1f1;
        }

        
.music-player-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
    box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.08);
    z-index: 1000;
    gap: 2rem;
}
.dark-theme .music-player-bar{
  background-color: #222425;
}
.player-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    min-width: 200px;
}

.player-cover {
    width: 56px;
    height: 56px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.track-details {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.track-title {
    font-size: 1rem;
    font-weight: 600;
    margin: 0;
}

.track-artist {
    font-size: 0.875rem;
    color: var(--secondary-color);
    margin: 0;
}

.player-controls {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    flex: 1;
    max-width: 600px;
    justify-content: center;
}

.player-controls button {
    background: none;
    border: none;
    color: var(--text-light);
    font-size: 1.5rem;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all var(--transition-speed) ease;
    cursor: pointer;
}

.player-controls button:hover {
    background: rgba(0, 0, 0, 0.05);
    transform: scale(1.1);
}

.play-pause {
    font-size: 2rem;
    background: var(--primary-color);
    color: white;
}

.play-pause:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(255, 77, 77, 0.3);
}

.progress-container {
  position: absolute;
  top: -4px;
  left: 0;
  right: 0;
  display: flex;
  align-items: center;
  gap: 15px;
  padding: 1px 10px;
}

.progress-bar {
  flex-grow: 1;
  height: 4px;
  background: rgba(255, 12, 12, 0.1);
  border-radius: 2px;
  cursor: pointer;
  position: relative;
}

.progress {
  height: 100%;
  background: rgba(255, 12, 12, 0.945);
  border-radius: 2px;
  position: relative;
}

.progress::after {
  content: '';
  position: absolute;
  right: -4px;
  top: -3px;
  width: 10px;
  height: 10px;
  background: #fff;
  border-radius: 50%;
  opacity: 0;
  transition: opacity 0.2s ease;
}

.progress-bar:hover .progress::after {
  opacity: 1;
}

.time{
  display: inline-flex;
  margin-left: 100px;
}













  
  

  
  
  .player-info img {
    width: 56px;
    height: 56px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }
  
 
  

  
  
 
  
  .dark-theme .player-controls button {
    background: none;
    color: var(--text-dark);
  }
  
  .player-controls button:hover {
    background: rgba(0, 0, 0, 0.05);
    transform: scale(1.1);
  }
  
 
  
  .player-controls .play-pause {
    font-size: 2rem;
    background: var(--primary-color);
    color: rgb(255, 0, 0);
  }
  
  
  .player-controls .play-pause:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(255, 77, 77, 0.3);
  }
  
  .volume-controls {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    min-width: 160px;
  }
  
  .volume-controls input[type="range"] {
    width: 100px;
    height: 4px;
    -webkit-appearance: none;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 2px;
  }
  .dark-theme .volume-controls input[type="range"] {
    background: rgb(255, 255, 255); 
  }

  .volume-controls input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 14px;
    height: 14px;
    background: var(--primary-color);
    border-radius: 50%;
    cursor: pointer;
  }
  
  
  .dark-theme .song-title {
    color: white;
  }
  
  .dark-theme .track-artist {
    color: rgb(255, 255, 255);
  }
  
  .dark-theme .progress-bar {
    background: rgb(255, 0, 0);
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
            cursor: pointer;
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

   
     <a class="back-home" onclick="window.history.back()" >  ⬅ Back to playlist</a>
<br><br>
 

     <!-- Main Content -->

     <main>
  
    
        <h1><?= htmlspecialchars($playlist['name']) ?></h1>

        <div class="song-list">
            <?php foreach($songs as $song): ?>
                <div class="song-card">
                <!-- song cover -->
                    <img src="<?= $song['cover_image'] ?>" alt="Song Cover" onclick="playTrack('<?= $song['file_path'] ?>','<?= $song['title'] ?>','<?= $song['cover_image'] ?>','<?= $song['artist_id'] ?>')">
                    <!-- song Info -->
                    <div class="song-info">
                        <h3><?= htmlspecialchars($song['title']) ?></h3>
                        <p>Artist ID: <?= htmlspecialchars($song['artist_id']) ?></p>
                    </div>
                    <!-- Thrre  Dot Dropdown -->
                    <div class="song-actions">
                        <div class="dots" onclick="toggleDropdown(this)">
                         ...
                        </div>
                        <div class="dropdown-menu">
                        <ul>
                           <li onclick="deleteSong(<?= $song['song_id'] ?>)">Delete</li>
                        </ul>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
        </div>
     </main>

     <!-- Music Player -->

     <!-- end Music Player -->

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

    function playTrack(filePath, title, cover,name) {
        audio.src = filePath;
        document.getElementById('track-title').textContent = title;
        document.getElementById('track-artist').textContent = name;
       
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
       
     <script>
        //toggle dropdown  menu

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

        
    //Delete Song

    function deleteSong(songId){

    if(confirm("Are you sure you want to delete this song from playlist?")){
    const form=document.createElement('form');

    form.method='POST';
    form.style.display='none';

    const input=document.createElement('input');
    input.type='hidden';
    input.name='song_id';
    input.value=songId;

    const deleteInput=document.createElement('input');

    deleteInput.type='hidden';
    deleteInput.name='delete_song';
    deleteInput.value='1';

    form.appendChild(input);
    form.appendChild(deleteInput);
    document.body.appendChild(form);
    form.submit();
}
}

     </script>
</body>
</html>