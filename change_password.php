<?php
include_once "helper.php";
session_start();

if (!isUserLoggedIn())
    header("Location: index.php");

$userId = $_SESSION['user_id'];

if (isset($_POST["submit"]))
{
    if (isValidPassword($userId, $_POST["old_password"]))
    {
        $newPassword = password_hash($_POST["new_password"], PASSWORD_DEFAULT);
        updatePassword($newPassword);
        header("Location: channel.php?user_id=$userId");
    }
    else
        $changeError = "The current password does not match the records";
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
    <title>Change Password</title>
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
    <link href="Content/components/button.css" rel="stylesheet" />
    <link href="Content/components/list.css" rel="stylesheet" />
    <link href="Content/components/icon.css" rel="stylesheet" />
    <link href="Content/components/sidebar.css" rel="stylesheet" />
    <link href="Content/components/transition.css" rel="stylesheet" />
	<link href="Content/components/search.css" rel="stylesheet" />

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

    <!-- ../dist/components/-->
    <script src="Scripts/jquery-1.8.1.min.js"></script>
    <script src="Scripts/semantic.js"></script>
    <script src="Content/components/visibility.js"></script>
    <script src="Content/components/sidebar.js"></script>
    <script src="Content/components/transition.js"></script>
	<script src= "Content/components/search.js"></script>

    <!-- Change Script Input Validation -->
    <script>
        $(document)
          .ready(function () {
              $('.ui.form')
                .form({
                    fields: {
                        opassword: {
                            identifier: 'old_password',
                            rules: [
                              {
                                  type: 'empty',
                                  prompt: 'Please enter your old password'
                              },
                              {
                                  type: 'length[6]',
                                  prompt: 'Your password must be at least 6 characters'
                              }
                            ]//rules
                        },//old_password
                        npassword: {
                            identifier: 'new_password',
                            rules: [
                              {
                                  type: 'empty',
                                  prompt: 'Please enter your new password'
                              },
                              {
                                  type: 'length[6]',
                                  prompt: 'Your password must be at least 6 characters'
                              }
                            ]//rules
                        },//new_password
                        rnpassword: {
                            identifier: 'new_repassword',
                            rules: [
                              {
                                  type: 'empty',
                                  prompt: 'Please enter your re-enter your new password'
                              },
                              {
                                  type: 'length[6]',
                                  prompt: 'Your password must be at least 6 characters'
                              },
                              {
                                  type: 'match[new_password]',
                                  prompt: 'Your new passwords do not match'
                              }
                            ]//rules
                        }//new_repassword
                    }//fields
                })//form
              ;
          })
        ;
    </script>

    <!-- Script so the menu will follow -->
    <?php include "menu_scripts.php";?>
</head>
<body>

<!-- Following Menu -->
<!-- Sidebar Menu -->
<?php include "alt_menu.php";?>
<!-- Page Contents -->
<div class="pusher">
i   <!-- Menu -->
    <?php include "menu.php";?>
        <!-- Update Form -->
        <div id="form" class="ui inverted middle aligned center aligned page grid">
            <div class="column">
                <h2 class="ui orange image header">
                    Change Password
                </h2>
                <form name="change" class="ui inverted large form" action="change_password.php" method="post">
                    <div class="ui stacked inverted segment">
                        <div class="field">
                            <div class="ui left icon input">
                                <i class="lock icon"></i>
                                <input type="password" name="old_password" placeholder="Current Password">
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui left icon input">
                                <i class="lock icon"></i>
                                <input type="password" name="new_password" placeholder="New Password">
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui left icon input">
                                <i class="lock icon"></i>
                                <input type="password" name="new_repassword" placeholder="Re-enter Your New Password">
                            </div>
                        </div>
                        <button class="ui fluid large orange submit button" name="submit">Update</button>
                    </div>

                    <div name="error" class="ui error message"></div>

                </form>

                <?php
                if (isset($changeError))
                {
                    echo
                    "<div class='ui error message'>
                        <ul class='list'>
                            <li>".$changeError."</li>
                        </ul>
                    </div>";
                }
                ?>

            </div>
        </div>
    </div>

<?php include "footer.php";?>
</div>
</body>
</html>
