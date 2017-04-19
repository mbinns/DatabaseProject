<?php
include_once "helper.php";
session_start();

function determineType($extension)
{
    if ($extension == "gif"  ||
        $extension == "jpg"  ||
        $extension == "jpeg" ||
        $extension == "png")
        return "Picture";
    else if (($extension == "mp3") ||
             ($extension == "ogg"))
        return "Music";
    else if (($extension == "mp4") ||
             ($extension == "wav"))
        return "Video";
    else
        return "Unsupported";
}

// Define allowed extensions
$allowedExts = array("gif", "jpeg", "jpg", "png", "mp3", "mp4", "wav", "ogg");

// Grabs the file extension by breaking the string into an array
$filename = explode(".", $_FILES["upload"]["name"]);
$extension = end($filename);

// Check the mime type
if (
   ($_FILES["upload"]["type"] == "image/gif")
|| ($_FILES["upload"]["type"] == "image/jpeg")
|| ($_FILES["upload"]["type"] == "image/jpg")
|| ($_FILES["upload"]["type"] == "image/pjpeg")
|| ($_FILES["upload"]["type"] == "image/x-png")
|| ($_FILES["upload"]["type"] == "image/png")
|| ($_FILES["upload"]["type"] == 'audio/x-mpeg-3')
|| ($_FILES["upload"]["type"] == 'audio/mp3')
|| ($_FILES["upload"]["type"] == 'audio/mpeg3')
|| ($_FILES["upload"]["type"] == 'audio/wav')
|| ($_FILES["upload"]["type"] == 'audio/x-wav')
|| ($_FILES["upload"]["type"] == 'audio/ogg')
|| ($_FILES["upload"]["type"] == 'video/ogg')
|| ($_FILES["upload"]["type"] == 'video/mpeg')
|| ($_FILES["upload"]["type"] == 'video/x-mpeg')
|| ($_FILES["upload"]["type"] == 'video/mp4')
)
{
    // If the errors item has any elements, then fail out
    if ($_FILES["upload"]["error"] > 0)
    {
        // Unknown upload error
        $error = 1;
    }

    // Check to see if the file has already been uploaded
    $name = $_FILES["upload"]["name"];
    if (file_exists("media/" . $name))
    {
        // The file already exists
        $error = 2;
    }

    $userId = $_SESSION['user_id'];
    $filePath = "media/" . $_FILES["upload"]["name"];
    $mime = $_FILES["upload"]["type"];
    $type = determineType($extension);
    $timestamp = date("Y-m-d h:i:sa");
    $comments = isset($_POST["comments"]) ? 1 : 0;

    if ($type == "Unsupported")
    {
        // Unsupported file type
        $error = 3;
    }

    if (!isset($error))
    {
        // Write the file
        move_uploaded_file($_FILES["upload"]["tmp_name"], $filePath);

        // Write the metadata to the database
        global $db;
        $query = "INSERT INTO media (title, type, filepath, description, user_id, upload_date, mime, show_comments) values (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "ssssissi",
                                $_POST["title"],
                                $type,
                                $filePath,
                                $_POST["description"],
                                $userId,
                                $timestamp,
                                $mime,
                                $comments);

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}
else
{
    // Invalid type, does not match our signature checker, or the file is over 1000MB
    $error = 4;
}

if (isset($error))
    header("Location: upload.php?error=$error");
else
    header("Location: channel.php?id=$userId");
?>
