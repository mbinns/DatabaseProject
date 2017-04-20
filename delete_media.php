<?php
include_once "helper.php";
session_start();

$userId = $_SESSION['user_id'];
$mediaId = $_GET['media_id'];

global $db;
$query = "SELECT title, filepath, description, tags, show_comments FROM media WHERE media_id =?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "i", $mediaId);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $title, $filepath, $description, $tags, $show_comments);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Delete from media table and cascade comments delete
$query = "DELETE FROM media WHERE media_id = $mediaId";

if (mysqli_query($db, $query))
    unlink($filepath);

header("Location: channel.php?user_id=$userId");
?>
