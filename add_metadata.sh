#!/bin/bash

SONG_DIR="admin/uploads/songs"

add_metadata() {
    local file="$1"
    local title="$2"
    local artist="$3"
    local album="$4"
    local genre="$5"

    echo "Updating: $file"

    ffmpeg -y -i "$SONG_DIR/$file" \
        -map 0:a \
        -c:a copy \
        -metadata title="$title" \
        -metadata artist="$artist" \
        -metadata album="$album" \
        -metadata genre="$genre" \
        "$SONG_DIR/temp.mp3" \
        -loglevel error

    if [ $? -eq 0 ]; then
        mv "$SONG_DIR/temp.mp3" "$SONG_DIR/$file"
        echo "✓ Done"
    else
        echo "✗ Failed: $file"
        rm -f "$SONG_DIR/temp.mp3"
    fi

    echo
}

add_metadata \
"Agar-Tum-Saath-Ho-FULL-AUDIO-Son.MP3" \
"Agar Tum Saath Ho" \
"Arijit Singh; Alka Yagnik" \
"Tamasha" \
"Bollywood"

add_metadata \
"Arijit-Singh-Humari-Adhuri-Kahan.MP3" \
"Hamari Adhuri Kahani" \
"Arijit Singh" \
"Hamari Adhuri Kahani" \
"Bollywood"

add_metadata \
"Banke-Hawa-Mein-Bezubaan-Mein-Of.MP3" \
"Banke Hawa Mein Bezubaan" \
"Rahat Fateh Ali Khan" \
"Unknown" \
"Bollywood"

add_metadata \
"Bhula-Dena-Mujhe-Video-Song-Aash.MP3" \
"Bhula Dena" \
"Mustafa Zahid" \
"Aashiqui 2" \
"Bollywood"

add_metadata \
"Channa-Mereya-Lyric-Video-Ae-Dil.MP3" \
"Channa Mereya" \
"Arijit Singh" \
"Ae Dil Hai Mushkil" \
"Bollywood"

add_metadata \
"Hanuman-Chalisa-Super-Fast-Music.MP3" \
"Hanuman Chalisa" \
"Unknown" \
"Hanuman Chalisa" \
"Bhakti"

add_metadata \
"Jai-Shree-Ram-Hansraj-Raghuwansh.MP3" \
"Jai Shree Ram" \
"Hansraj Raghuwanshi" \
"Jai Shree Ram" \
"Bhakti"

add_metadata \
"Kaun-Hain-Voh-Full-Video-Baahuba.MP3" \
"Kaun Hain Voh" \
"Kailash Kher" \
"Baahubali: The Beginning" \
"Bollywood"

add_metadata \
"Maa-Apne-Dware-Bula-Le-Mujhe-Ful.MP3" \
"Maa Apne Dware Bula Le Mujhe" \
"Sonu Nigam" \
"Maa Apne Dware Bula Le Mujhe" \
"Bhakti"

add_metadata \
"Maine-Royaa-1.MP3" \
"Maine Royaan" \
"Tanveer Evan" \
"Maine Royaan" \
"Pop"

add_metadata \
"Vishvambhari-Stuti-Kinjal-Dave-K.MP3" \
"Vishvambhari Stuti" \
"Kinjal Dave" \
"Vishvambhari Stuti" \
"Bhakti"

echo "======================================"
echo "Metadata update completed!"
echo "======================================"
