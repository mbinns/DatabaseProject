<?php
include_once "helper.php";
session_start();

if (!isset($_GET['receiver_id']))
    return;

$receiverId = $_GET['receiver_id'];

global $db;
$query = "INSERT into messages (sender_id, receiver_id, time, message) values (?, ?, ?, ?)";
$stmt = mysqli_prepare($db, $query);
$timestamp = date("Y-m-d h:i:sa");
mysqli_stmt_bind_param($stmt, "iiss", $_SESSION['user_id'], $receiverId, $timestamp, $_POST['message']);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: message.php?sender_id=$receiverId");
?>
