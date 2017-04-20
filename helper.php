<?php
include_once "config.php";

function getUserId($email)
{
    global $db;
    $query = "SELECT user_id FROM account WHERE email = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $id;
}

function getUserAbout($id)
{
    global $db;
    $query = "SELECT about FROM account WHERE user_id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $about);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $about;
}

function getUserName($id)
{
    global $db;
    $query = "SELECT firstname, lastname FROM account WHERE user_id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $fname, $lname);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $fname." ".$lname;
}

function getUserJoinDate($id)
{
    global $db;
    $query = "SELECT joindate FROM account WHERE user_id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $joinDate);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    $date = date_create($joinDate);
    return date_format($date, "F Y");
}

/*
    Determines if the users credentials are valid
    returns 0 if the email has not been registered
            1 if the password does not match
            2 if the credentials are valid
*/
function hasValidCredentials($email, $plainPassword)
{
    if (!isExistingEmail($email))
        return 0;

    return isValidPassword(getUserId($email), $plainPassword) ? 2 : 1;
}

function isExistingEmail($email)
{
    global $db;
    $query = "SELECT count(email) FROM account WHERE email = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $count != 0;
}

function isExistingPlaylist($playlistName)
{
    global $db;

    $query = "SELECT count(pl_name) FROM playlist WHERE pl_name = ? AND user_id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "si", $playlistName, $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $count != 0;
}

function isUserLoggedIn()
{
    return isset($_SESSION['user_id']);
}

// Is the current user in their own profile?
function isUserProfile($userId)
{
    return isUserLoggedIn() && $userId == $_SESSION['user_id'];
}

function isValidUpdateEmail($email)
{
    global $db;
    $query = "SELECT email FROM account WHERE user_id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "d", $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $oldEmail);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($email == $oldEmail)
        return true;
    else
        return !isExistingEmail($email);
}

function isValidPassword($userId, $plainPassword)
{
    global $db;
    $query = "SELECT password FROM account WHERE user_id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "s", $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $hashedPassword);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return password_verify($plainPassword, $hashedPassword);
}

function registerUser($email, $password, $firstname, $lastname)
{
    // Register user
    global $db;
    $query = "INSERT INTO account (email, password, firstname, lastname, joindate) values (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "sssss", $email, $password, $firstname, $lastname, date("Y-m-d"));
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Give this user a favorites playlist
    $query = "INSERT INTO playlist (pl_name, user_id) values (?, ?)";
    $stmt = mysqli_prepare($db, $query);
    $name = "Favorites";
    mysqli_stmt_bind_param($stmt, "si", $name, getUserId($email));
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function updatePassword($newPassword)
{
    // Update a user's password
    global $db;
    $query = "UPDATE account SET password = ? WHERE user_id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "sd", $newPassword, $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function updateUser($email, $firstname, $lastname, $about)
{
    // Update user information (except password)
    global $db;
    $query = "UPDATE account SET email = ?, firstname = ?, lastname = ?, about = ? WHERE user_id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "ssssd", $email, $firstname, $lastname, $about, $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function updateMedia($title, $desc, $tags, $comm, $m_id)
{
    // Update user information (except password)
    global $db;
    $query = "UPDATE media SET title = ?, description = ?, tags = ?, show_comments = ? WHERE media_id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "ssssd", $title, $desc, $tags, $comm, $m_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

?>
