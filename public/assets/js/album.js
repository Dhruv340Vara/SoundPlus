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


        
        
        
        function checkLoginAndPlay(filePath, title, cover,name) {
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
            document.getElementById('track-cover').src = cover;
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
            

