<?php
include_once "config.php";

function getUserId($email)
{
    global $db;
    $query = "SELECT user_id FROM account WHERE email = '$email'";
    $result = mysqli_query($db, $query);

    return mysqli_fetch_row($result)[0];
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
    $query = "SELECT password FROM account WHERE email = '$email'";
    $result = mysqli_query($db, $query);
    $hashedPassword = mysqli_fetch_row($result)[0];

    return password_verify($plainPassword, $hashedPassword) ? 2 : 1;
}

function isExistingEmail($email)
{
    global $db;
    $query = "SELECT email FROM account WHERE email = '$email'";
    $result = mysqli_query($db, $query);

    return mysqli_num_rows($result) != 0;
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

function registerUser($email, $password)
{
    global $db;
    $query = "INSERT INTO account (email, password) values ('$email', '$password')";
    $result = mysqli_query($db, $query);
}
?>
