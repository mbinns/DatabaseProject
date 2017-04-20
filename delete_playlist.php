<?php
include_once "helper.php";
session_start();

$userId = $_SESSION['user_id'];
$playlistId = $_GET['playlist_id'];

// Delete from playlist table and cascade playlistmedia delete
global $db;
$query = "DELETE FROM playlist WHERE pl_id = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "i", $playlistId);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: channel.php?user_id=$userId");
?>
