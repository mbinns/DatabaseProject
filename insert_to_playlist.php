<?php
include_once "helper.php";
session_start();

$p_id = $_GET['playlist_id'];
$m_id = $_GET['media_id'];

//echo "\n" . $p_id;

//echo $m_id;
global $db;

$query = "INSERT INTO playlistmedia (playlist_id, media_id) values (?,?)";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "ii", $p_id, $m_id);
if ($stmt->execute()) {
    header("Location: player.php?media_id=$m_id");
} else {
    echo "Error deleting record: \n" . mysqli_error($db);
}
