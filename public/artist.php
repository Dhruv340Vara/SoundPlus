       
<?php
session_start();

include('includes/db_connect.php');

if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit;
}


//Check if user is subscribed


$user_id=$_SESSION['user_id'];
$subscriptionQuery="SELECT * FROM subscriptions WHERE user_id=$user_id AND end_date >= CURDATE()";
$subscriptionResult=mysqli_query($conn,$subscriptionQuery);

if(mysqli_num_rows($subscriptionResult) === 0){
    header("Location: subscription.php");
    exit;
}

$artist_id = $_GET['artist_id'] ?? 0;

//Fetch artits details

$artistQuery="SELECT * FROM artists WHERE artist_id=$artist_id";
$artistResult=mysqli_query($conn,$artistQuery);
$artist=mysqli_fetch_assoc($artistResult);

//Fetch associated songs

$songsQuery="SELECT * FROM songs WHERE artist_id=$artist_id";
$songsResult=mysqli_query($conn,$songsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            font-family: 'Arial', sans-serif;
            background:#f4f4f4;
            color:#333;
            margin:0;
            padding: 20px;
        }
        /* Back to Home Button */
        .back-home {
            position: absolute;
            top: 20px;
            left: 20px;
            text-decoration: none;
            color:rgb(185, 29, 29);
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

        .artist-details{
            display: flex;
            align-items: center;
            padding: 20px;
            background: #fff;
            margin:20px;
            border-radius:10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .artist-image img{
            width: 150px;
            height:150px;
            border-radius: 50%;
            object-fit:cover;
            margin-right: 20px;
        }
        .artist-info h2{
            margin: 0;
            font-size: 24px;
        }
        .artist-info .bio{
            font-size: 16px;
            color:#666;

        } .artist-info .genre{
            font-size: 14px;
            color:#888;

        }
        .songs-list{
            padding:20px;
        }
        .song-cover{
            width: 50px;
            height: 50px;
            background: #fff;
            padding: 15px;
            margin:10px 0;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            cursor: pointer;
        }
        .song-card{
            display:flex;
            align-items:center;
            background:#fff;
            padding:15px;
            margin:10px 0;
            border-radius:10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            cursor:pointer;

        }
        .song-cover{
            width: 50px;
            height:50px;
            border-radius: 5px;
            margin-right: 15px;
            
        }
       .song-info h4{
        margin: 0;
        font-size: 18px;
       }
       .song-info p{
        margin:0;
        font-size:18px;
        color: #888;
       }
       .song-actions{

        margin-left: auto;
       }
       .song-actions button{
        background: none;
        border:none;
        cursor: pointer;
        font-size: 18px;
        color: rgb(170, 26, 24);
        margin-left: 10px;
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
  
  
  
  
 

    </style>
    
</head>
<body>
    <!-- Header -->


    <a href="home.php" class="back-home">
        ⬅ Back to Home
    </a>
  <br>

    <!-- Artist Detail -->

    <div class="artist-details">
        <div class="artist-image">
        <img src="<?php echo '../admin/assets/images/artist_profiles/'.($artist['profile_picture']??'default_user.png'); ?>" alt="<?= htmlspecialchars($artist['name']) ?>">
    </div>

    <div class="artist-info">
        <h2><?= htmlspecialchars($artist['name']) ?></h2>
        <p class="bio"><?= htmlspecialchars($artist['bio']) ?></p>

        <p class="genre"><strong>Genre:</strong><?= htmlspecialchars($artist['genre'] ?? 'N/A') ?></p>
    </div>
  </div>

  <!-- Songs List -->

  <div class="songs-list">
    <h3>Song by <?= htmlspecialchars($artist['name']) ?></h3>
    <?php while($song=mysqli_fetch_assoc($songsResult)) { ?>
    
        <div class="song-card" onclick="playTrack('<?= htmlspecialchars($song['file_path']) ?>', '<?= htmlspecialchars($song['title']) ?>', '../admin/assets/images/album_covers/<?= htmlspecialchars($song['cover_image']) ?>')">
        <img src="../admin/assets/images/album_covers/<?= htmlspecialchars($song['cover_image']) ?>" alt="Cover" class="song-cover">
        <div class="song-info">
          <h4><?= htmlspecialchars($song['title']) ?></h4>
            <p><?= htmlspecialchars($song['genre'] ?? 'N/A') ?></p>
        </div>
        <div class="song-actions">
            <button class="play-button" onclick="playTrack('<?= htmlspecialchars($song['file_path']) ?>', '<?= htmlspecialchars($song['title']) ?>', '../admin/assets/images/album_covers/<?= htmlspecialchars($song['cover_image']) ?>')">
            <i>▶</i>
        </button>
        </div>
        </div>
        
    <?php } ?>
    <br><br><br><br><br>
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
    <button onclick="playprevious()" >&#9664;&#9664;</button>
    <button onclick="togglePlayPause()" id="play-pause">&#9658;</button>
    <button onclick="playNext()" >&#9654;&#9654;</button>
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
    
</body>
</html>
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

    function playTrack(filePath, title, cover) {
        audio.src = filePath;
        document.getElementById('track-title').textContent = title;
       
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
