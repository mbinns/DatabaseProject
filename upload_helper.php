<?php
$target_file = basename($_FILES["upload"]["name"]);
$FileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Allow certain file formats
if($FileType != "jpg" && $FileType != "png" && $FileType != "jpeg"
&& $FileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
}else{
    $target_dir = "media/pictures/";
    $target_file = $target_dir . basename($_FILES["upload"]["name"]);
    
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        return;
        $uploadOk = 0;
    }
    if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["upload"]["name"]). " has been uploaded.";
        return;
    } else {
        echo "Sorry, there was an error uploading your file.";
        return;
    }
}

// Allow certain file formats
if($FileType != "mp3" && $FileType != "Ogg" && $FileType != "wav") {
    echo "Sorry, only mp3, Ogg, wav files are allowed.";
}else{
    $target_dir = "./media/music/";
    $target_file = $target_dir . basename($_FILES["upload"]["name"]);
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        return;
    }
    if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["upload"]["name"]). " has been uploaded.";
        return;
    } else {
        echo "Sorry, there was an error uploading your file.";
        return;
    }
}

// Allow certain file formats
if($FileType != "mp4" && $FileType != "webm") {
    echo "Sorry, only mp4, Pgg, webm files are allowed.";
}else{
    $target_dir = "./media/videos/";
    $target_file = $target_dir . basename($_FILES["upload"]["name"]);
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        return;
    }
    if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["upload"]["name"]). " has been uploaded.";
        return;
    } else {
        echo "Sorry, there was an error uploading your file.";
        return;
    }
}

?>
