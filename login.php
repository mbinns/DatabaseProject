﻿<?php
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
    <title>Register</title>
    <link href="Content/semantic.css" rel="stylesheet" />
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

    <!-- Style changes for register page -->
    <style type="text/css">
        body {
            background-color: #1b1c1d !important;
        }

            body > .grid {
                height: 100%;
            }

		.pusher {
			background-color: #1b1c1d !important;
		}

        .image {
            margin-top: -100px;
        }

        .column {
            max-width: 450px;
        }

        .hidden.menu {
            display: none;
        }

        .masthead.segment {

            padding: 1em 0em;
        }

        .masthead .logo.item img {
            margin-right: 1em;
        }

        .masthead .ui.menu .ui.button {
            margin-left: 0.5em;
        }

        .masthead h1.ui.header {
            margin-top: 3em;
            margin-bottom: 0em;
            font-size: 4em;
            font-weight: normal;
        }

        .masthead h2 {
            font-size: 1.7em;
            font-weight: normal;
        }

		.ui#form{
			padding-top: 5%;
		}
        .ui.vertical.stripe {
            padding: 8em 0em;
        }

            .ui.vertical.stripe h3 {
                font-size: 2em;
            }

            .ui.vertical.stripe .button + h3,
            .ui.vertical.stripe p + h3 {
                margin-top: 3em;
            }

            .ui.vertical.stripe .floated.image {
                clear: both;
            }

            .ui.vertical.stripe p {
                font-size: 1.33em;
            }

            .ui.vertical.stripe .horizontal.divider {
                margin: 3em 0em;
            }

        .quote.stripe.segment {
            padding: 0em;
        }

            .quote.stripe.segment .grid .column {
                padding-top: 5em;
                padding-bottom: 5em;
            }

        .footer.segment {
            padding: 5em 0em;
			bottom: 0;
        }

        .secondary.pointing.menu .toc.item {
            display: none;
        }

        @media only screen and (max-width: 700px) {
            .ui.fixed.menu {
                display: none !important;
            }

            .secondary.pointing.menu .item,
            .secondary.pointing.menu .menu {
                display: none;
            }

            .secondary.pointing.menu .toc.item {
                display: block;
            }

            .masthead h1.ui.header {
                font-size: 2em;
                margin-top: 1.5em;
            }

            .masthead h2 {
                margin-top: 0.5em;
                font-size: 1.5em;
            }
        }

		.pusher {
			background: #1b1c1d;
		}
    </style>

    <!-- Scripts -->
    <script src="Scripts/jquery-1.8.1.min.js"></script>
    <script src="Scripts/semantic.js"></script>
    <script src="Content/components/transition.js"></script>
    <script src="Content/components/form.js"></script>
    <script src="Content/components/visibility.js"></script>
    <script src="Content/components/sidebar.js"></script>

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

    <!-- Scripts for menu -->
    <?php include "menu_scripts.php";?>
</head>
<body>
<!-- Following Menu -->
<!-- Sidebar Menu -->
<?php include "alt_menu.php";?>

<div class="pusher">
        <?php include "menu.php";?>
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
    </div>
<?php include "footer.php";?>
</body>
</html>
