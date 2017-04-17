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
    mysqli_stmt_bind_param($stmt, "d", $id);
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
    mysqli_stmt_bind_param($stmt, "d", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $fname, $lname);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $fname." ".$lname;
}

function getUserJoinYear($id)
{
    global $db;
    $query = "SELECT year(joindate) FROM account WHERE user_id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "d", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $year);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $year;
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

    global $db;
    $query = "SELECT password FROM account WHERE email = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $hashedPassword);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return password_verify($plainPassword, $hashedPassword) ? 2 : 1;
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

/*
    TODO:
    In index.index if this returns true then instead of "Sign In/Register"
    "Sign Out" should be shown instead
*/
function isUserLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function registerUser($email, $password, $firstname, $lastname)
{
    global $db;
    $query = "INSERT INTO account (email, password, firstname, lastname) values (?, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $email, $password, $firstname, $lastname);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
?>
