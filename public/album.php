<?php 

include('includes/db_connect.php');
if(!isset($_GET['album_id'])){
    die("Album not found");
}
$album_id=intval($_GET['album_id']);

//Fetch Album Details

$album_query="SELECT albums.*,artists.name AS artist_name FROM albums JOIN artists ON 
albums.artist_id=artists.artist_id WHERE albums.album_id=$album_id";

$album_result=mysqli_query($conn,$album_query);
$album=mysqli_fetch_assoc($album_result);

//Fetch Songs in the album

$songs_query="SELECT * FROM songs WHERE album_id=$album_id ORDER BY song_id ASC";
$songs_result=mysqli_query($conn,$songs_query);
$songs=mysqli_fetch_all($songs_result,MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($album['title']); ?></title>
<link rel="stylesheet" href="assets/css/player.css">
<link rel="stylesheet" href="assets/css/album.css">
<style> /* Back to Home Button */
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

<div class="album-container">
<a href="home.php" class="back-home">
        ⬅ Back to Home
    </a>
    </div><br>
    <div class="album-header">
        <img src="../assets/images/album_covers/<?php echo htmlspecialchars($album['cover_image']); ?>"
        alt="<?php echo htmlspecialchars($album['title']); ?>">

        <div>
            <h1><?php echo htmlspecialchars($album['title']); ?></h1>
            <p>by<?php echo htmlspecialchars($album['artist_name']); ?></p>

            <div class="controls">
                <button class="btn" onclick="playAlbum()">▶ Play Album</button>
                <i class="like-btn" onclick="toggleLike(this)">❤</i>  <!-- like icon -->
            </div>
        </div>
    </div>

    <div class="song-list">
        <h2>Songs</h2>

        <ul id="song-list">
            <?php foreach($songs as $song) { ?>
                <li data-song-id="<?php echo htmlspecialchars($song['song_id']); ?>"
                onclick="playTrack('<?php echo htmlspecialchars($song['file_path']); ?>',
                '<?php echo htmlspecialchars($song['title']); ?>',
                '..assets/images/album_covers/<?php echo htmlspecialchars($album['cover_image']); ?>',
                '<?php echo htmlspecialchars($album['artist_name']); ?>')">
                <span><?php echo htmlspecialchars($song['song_id']).".".htmlspecialchars($song['title']); ?></span>
                <button  class="btn"> ▶ </button>
            </li>
            <?php } ?>
        </ul>
    </div>
    </div>
    <br><br><br><br><br>
    
        <div class="music-player-bar">
        <div class="player-info">
        <img src="../assets/images/album_covers/<?php echo htmlspecialchars($album['cover_image']);  ?>">
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
       </div></div>

       
    
</div>

<script>
//album.php

let isPlaying = false;
let isMuted = false;
let audio = new Audio();


    function seek(event) {
        const progressBar = event.currentTarget;
        const clickPosition = event.offsetX;
        const progressWidth = progressBar.offsetWidth;
        const clickRatio = clickPosition / progressWidth;
        audio.currentTime = clickRatio * audio.duration;
    }




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


        
        
        
        function checkLoginAndPlay(filePath, title,name) {
                    /*let isLoggedIn = <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>;*/
                    if (!isLoggedIn) {
                        showLoginMessage();
                        setTimeout(() => {
                            window.location.href = "login.html";
                        }, 3000);
                        return;
                    }
                    playTrack(filePath, title, cover,name);
                }
        
        
        function showLoginMessage()
         {
         document.getElementById('login-message').style.display = 'flex';
              }
        
             
        
               
        function playTrack(filePath, title, cover,name) {
            audio.src = filePath;
            document.getElementById('track-title').textContent = title;
            document.getElementById('track-artist').textContent = name;
           
            audio.play();
            isPlaying = true;
            document.getElementById('play-pause').textContent = '⏸';
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
        
        function toggleMute() {
            isMuted = !isMuted;
            audio.muted = isMuted;
            document.getElementById('mute-btn').textContent = isMuted ? '🔇' : '🔊';
        }
        
        function changeVolume() {
            audio.volume = document.getElementById('volume').value / 100;
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
    
    let songQueue = [];
        
        function playAlbum() {
            songQueue = Array.from(document.querySelectorAll('#song-list li')).map(li => li.getAttribute('onclick'));
            playNextInQueue();
        }

        function playNextInQueue() {
            if (songQueue.length > 0) {
                let nextSong = songQueue.shift();
                eval(nextSong);
                audio.onended = playNextInQueue;
            }
        }

        function downloadAlbum() {
            window.location.href = 'download_album.php?album_id=<?php echo $album_id; ?>';
        }

        function toggleLike(btn) {
            btn.classList.toggle('liked');
            if (btn.classList.contains('liked')) {
                btn.style.color = 'pink';
                btn.innerHTML = '❤ Added to Favorites';
            } else {
                btn.style.color = '';
                btn.innerHTML = '❤';
            }
        }
            


</script>



</body>

</html>


