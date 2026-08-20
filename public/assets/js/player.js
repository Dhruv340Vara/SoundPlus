
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

    function playTrack(filePath, title, artist, coverImage) {
        audio.src = filePath;
        document.getElementById('track-title').textContent = title;
        document.getElementById('track-artist').textContent = artist;
        document.getElementById('track-cover').src = coverImage;
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

    function seek(event) {
        const progressBar = event.currentTarget;
        const clickPosition = event.offsetX;
        const progressWidth = progressBar.offsetWidth;
        const clickRatio = clickPosition / progressWidth;
        audio.currentTime = clickRatio * audio.duration;
    }

    function toggleQueue() {
        const queueDiv = document.getElementById('queue');
        queueDiv.style.display = queueDiv.style.display === 'flex' ? 'none' : 'flex';
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

