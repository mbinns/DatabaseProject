<?php
include_once "helper.php";
session_start();

$m_id = $_GET['media_id'];

global $db;
$query = "SELECT title, description, tags, show_comments FROM media WHERE media_id =?";
//$query = "SELECT email, firstname, lastname, about FROM account WHERE user_id = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "i", $m_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $title, $desc, $tags, $comm);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

//Delete from media table and cascade comments delete
$query = "DELETE FROM media WHERE media_id = $m_id";
echo $query;

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if (mysqli_query($db, $query)) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . mysqli_error($db);
};
?>
