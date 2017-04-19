<?php
include_once "helper.php";
session_start();

if (isset($_POST['submit']))
{
    $email = $_POST["email"];
    $password = $_POST["password"];

    $validity = hasValidCredentials($email, $password);

    switch ($validity)
    {
        // The email has not been registered
        case 0:
		    $loginError = "No account found with this email";
            break;
        // The password does not match
        case 1:
            $loginError = "Incorrect password";
            break;
        // Credentials are valid
        case 2:
            $userId = getUserId($email);
            $_SESSION["user_id"] = $userId;
            header("Location: channel.php?user_id=".$userId);
            break;
    }
}
?>

<!DOCTYPE html>
<html>
<head>

    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- Site Properties -->
    <!-- Might have to fix these links on linux to match directory style-->
    <!-- ../dist/components/-->
    <title>MeTube</title>
    <a href="register.php">register.php</a>
    <link href="Content/components/reset.css" rel="stylesheet" />
    <link href="Content/components/site.css" rel="stylesheet" />
    <link href="Content/components/container.css" rel="stylesheet" />
    <link href="Content/components/grid.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="Content/components/image.css">
    <link rel="stylesheet" type="text/css" href="Content/components/menu.css">
    <link href="Content/components/header.css" rel="stylesheet" />
    <link href="Content/components/divider.css" rel="stylesheet" />
    <link href="Content/components/dropdown.css" rel="stylesheet" />
    <link href="Content/components/segment.css" rel="stylesheet" />
    <link href="Content/components/list.css" rel="stylesheet" />
    <link href="Content/components/icon.css" rel="stylesheet" />
    <link href="Content/components/sidebar.css" rel="stylesheet" />

    <!-- Nice Transitions to avoid popin -->
    <link href="Content/components/transition.css" rel="stylesheet" />

    <!-- Login form -->
    <link href="Content/components/form.css" rel="stylesheet" />
    <link href="Content/components/input.css" rel="stylesheet" />
    <link href="Content/components/button.css" rel="stylesheet" />
    <link href="Content/components/message.css" rel="stylesheet" />

    <!-- Style changes for login page -->
    <style type="text/css">
        body {
            background-color: #1b1c1d !important;
        }

            body > .grid {
                height: 100%;
            }

        .image {
            margin-top: -100px;
        }

        .column {
            max-width: 450px;
        }

    </style>

    <!-- Scripts -->
    <script src="Scripts/jquery-1.8.1.min.js"></script>
    <script src="Content/components/transition.js"></script>
    <script src="Content/components/form.js"></script>

    <!-- Login Script Input Validation -->
    <script>
        $(document)
          .ready(function () {
              $('.ui.form')
                .form({
                    fields: {
                        email: {
                            identifier: 'email',
                            rules: [
                              {
                                  type: 'empty',
                                  prompt: 'Please enter your e-mail'
                              },
                              {
                                  type: 'email',
                                  prompt: 'Please enter a valid e-mail'
                              }
                            ]//rules
                        },//email
                        password: {
                            identifier: 'password',
                            rules: [
                              {
                                  type: 'empty',
                                  prompt: 'Please enter your password'
                              },
                              {
                                  type: 'length[6]',
                                  prompt: 'Your password must be at least 6 characters'
                              }
                            ]//rules
                        }//password
                    }//fields
                })//form
              ;
          })
        ;
    </script>

    <!-- Script so the menu will follow -->
    <script>
        $(document)
          .ready(function () {
              // fix menu when passed
              $('.masthead')
                .visibility({
                    once: false,
                    onBottomPassed: function () {
                        $('.fixed.menu').transition('fade in');
                    },
                    onBottomPassedReverse: function () {
                        $('.fixed.menu').transition('fade out');
                    }
                })
              ;
              // create sidebar and attach to menu open
              $('.ui.sidebar')
                .sidebar('attach events', '.toc.item')
              ;
          })
        ;
    </script>
</head>
<body>

    <!-- Following Menu -->
    <div class="ui large top inverted fixed hidden menu ">
        <div class="ui container">
            <a class="active item" href="index.php">Home</a>
            <a class="item">Channel</a>
            <a class="item">Videos</a>
            <a class="item">Favorites</a>
            <div class="right menu">
                <div class="item">
                    <a class="ui inverted button" href="login.php">Log in</a>
                </div>
                <div class="item">
                    <a class="ui inverted button" href="register.php">Sign Up</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <div class="ui vertical inverted sidebar menu">
        <a class="active item" href="index.php">Home</a>
        <a class="item">Channel</a>
        <a class="item">Videos</a>
        <a class="item">Favorites</a>
        <a class="item" href="login.php">Login</a>
        <a class="item" href="register.php">Signup</a>
    </div>

    <!-- Login Form -->
    <div class="ui middle aligned center aligned grid">
        <div class="column">
            <h2 class="ui orange image header">
                Log-in to your account
            </h2>
            <form class="ui inverted large form" action="login.php" method="post">
                <div class="ui stacked inverted segment">
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="user icon"></i>
                            <input type="text" name="email" placeholder="E-mail address">
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="password" name="password" placeholder="Password">
                        </div>
                    </div>
                    <button class="ui fluid large orange submit button" name="submit">Login</button>
                </div>

                <div class="ui error message"></div>

            </form>

            <?php
            if (isset($loginError))
            {
                echo
                "<div class='ui error message'>
                    <ul class='list'>
                        <li>".$loginError."</li>
                    </ul>
                </div>";
            }
            ?>

            <div class="ui message">
                New to us? <a href="register.php">Sign Up</a>
            </div>
        </div>
    </div>
</body>
</html>
