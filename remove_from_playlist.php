<?php
include_once "helper.php";
session_start();

$userId = $_SESSION['user_id'];
$mediaId = $_GET['media_id'];
$pId = $_GET['pId'];

global $db;

// Delete from media table and cascade comments delete
$query = "DELETE FROM playlistmedia WHERE media_id = $mediaId and playlist_id = $pId";

if (mysqli_query($db, $query))
{
    header("Location: playlist.php?user_id=$pId");
}else{
    echo mysqli_error($db);
}
