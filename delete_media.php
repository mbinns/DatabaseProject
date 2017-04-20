<?php
include_once "helper.php";
session_start();

$userId = $_SESSION['user_id'];
$mediaId = $_GET['media_id'];

global $db;
$query = "SELECT filepath FROM media WHERE media_id = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "i", $mediaId);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $filepath);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

$query = "DELETE FROM media WHERE media_id = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "i", $mediaId);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

unlink($filepath);
header("Location: channel.php?user_id=$userId");
?>
