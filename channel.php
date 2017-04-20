<?php
include_once "helper.php";
session_start();

if (!isset($_GET['user_id']))
    return;

$userId = $_GET['user_id'];

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- Site Properties -->
    <!-- Might have to fix these links on linux to match directory style-->
    <!-- ../dist/components/-->
    <title>Channel</title>
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

   <!-- CSS for Channel -->
   <link href="Content/components/card.css" rel="stylesheet" />
   <link href="Content/components/item.css" rel="stylesheet" />
   <link href="Content/components/list.css" rel="stylesheet" />

    <!-- Style changes for channel page -->
    <style type="text/css">
        body {
            background-color: #1b1c1d !important;
        }

		.ui#content{
			padding-top: 10em;
			padding-bottom: 10em;
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
            padding: 5em;
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

            .masthead.segment {
                min-height: 350px;
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
    </style>

<title>Channel</title>
    <!-- Might have to fix these links on linux to match directory style-->
    <!-- ../dist/components/-->
    <script src="Scripts/jquery-1.8.1.min.js"></script>
    <script src="Scripts/semantic.js"></script>
    <script src="Content/components/visibility.js"></script>
    <script src="Content/components/sidebar.js"></script>
    <script src="Content/components/transition.js"></script>

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
    <div class="ui large top fixed hidden menu">
        <div class="ui container">
            <a class="active item">Home</a>
            <a class="item" href="channel.php">Channel</a>
            <a class="item">Videos</a>
            <a class="item">Favorites</a>
            <div class="right menu">
                <div class="item">
                    <a class="ui button" href="login.php">Log in</a>
                </div>
                <div class="item">
                    <a class="ui primary button" href="register.php">Sign Up</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <div class="ui vertical inverted sidebar menu">
        <a class="active item">Home</a>
        <a class="item" href="channel.php">Channel</a>
        <a class="item">Videos</a>
        <a class="item">Favorites</a>
        <a class="item" href="login.php">Login</a>
        <a class="item" href="register.php">Signup</a>
    </div>
    <!-- Page Contents -->
    <div class="pusher">
        <div class="ui vertical masthead segment">
          <!-- Menu -->
          <div class="ui">
                <div class="ui large secondary container inverted pointing menu">
                <a class="toc item"> <em class="sidebar icon"></em></a>
                <a class="active item" href="index.php">Home</a>
                <a class="item" href="channel.php">Channel</a>
                <a class="item">Videos</a>
                <a class="item">Favorites</a>
                <div class="right item">
                	<a class="ui inverted button" href="login.php">Log in</a>
                	<a class="ui inverted button" href="register.php">Sign Up</a>
                </div>
            	</div>
          </div>
        </div>

        <!-- Profile -->
        <div id="content" class="ui stackable container grid">

            <!-- Profile Card -->
            <div class="ui card fluid">
                <div class="content">
                    <?php
                    echo
                    "<a class='center aligned header'>" .
                    "<h1>"
                        .getUserName($userId) .
                    "</h1>"
                    ."</a>";
                    ?>
                </div>
                <div class="meta">
                    <?php
                    echo
                    "<span class='date'><h3>Member since "
                    .getUserJoinDate($userId).
                    "</h3>"
                    ."</span>"
                    ?>
                </div>
                <?php
                echo
                "<div class='description'><h5> "
                    .getUserAbout($userId).
                "</h5>"
                ."</div>";
                ?>

                <?php
                if (isUserProfile($userId))
                {
                ?>
                    <div class="extra content">
                        <div class="ui two buttons bottom attached">
                            <div class="ui button" onclick="location.href='profile_update.php';">
                                <i class="icon settings"></i>Update Profile
                            </div>
                            <div class="ui button" onclick="location.href='change_password.php';">
                                <i class="icon settings"></i>Change Password
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>

            <!-- Messages -->
            <?php
            if (isUserProfile($userId))
            {
                global $db;
                $query = "SELECT DISTINCT messages.sender_id, account.firstname, account.lastname
                          FROM account
                          JOIN messages ON account.user_id = messages.sender_id
                          WHERE receiver_id = ?";
                $stmt = mysqli_prepare($db, $query);
                mysqli_stmt_bind_param($stmt, "i", $userId);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $senderId, $fname, $lname);

                echo
                "<div class='ui segment container divided list'>
                    <div class='header'><h2>Messages</h2></div>";

                while (mysqli_stmt_fetch($stmt))
                {
                    echo
                    "<div class='item'>
                        <div class='right floated content'>
                        <div class='ui button' onclick=\"location.href='message.php?sender_id=$senderId';\">Reply</div>
                        </div>
                        <div class='content'>
                            <h3>".$fname." ".$lname."</h3>
                        </div>
                    </div>";
                }
                echo
                "</div>";
                mysqli_stmt_close($stmt);
            }
            ?>

            <!-- Show user playlists -->
            <div class="ui list items segment divided container">
                <div class='header'>
                    <h2>Playlists</h2>
                </div>
                <?php
                global $db;
                $query = "SELECT pl_id, pl_name FROM playlist WHERE user_id = ?";
                $stmt = mysqli_prepare($db, $query);
                mysqli_stmt_bind_param($stmt, "i", $userId);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $playlistId, $playlistName);

                while (mysqli_stmt_fetch($stmt))
                {
                    echo
                    "<div class='item'>
                        <div class='content'>
                            <a class='header' href='playlist.php?playlist_id=".$playlistId."'>".$playlistName."</a>";

                            if (isUserProfile($userId) && $playlistName != "Favorites")
                            {
                                echo
                                "<div class='right floated content'>
                                    <div class='ui two buttons'>
                                        <div class='ui button positive' onclick=\"location.href='update_playlist.php?playlist_id=$playlistId';\">Update</div>
                                        <div class='ui button negative' onclick=\"location.href='delete_playlist.php?playlist_id=$playlistId';\">Delete</div>
                                    </div>
                                </div>";
                            }
                        echo
                        "</div>
                    </div>";
                }

                mysqli_stmt_close($stmt);
                ?>
            </div>

            <!-- Show user uploads -->
            <div class="ui items segment divided list container">
                <div class='item'>
                    <h2>Uploads</h2>
                </div>
                <?php
                global $db;
                $query = "SELECT media_id, title, type, description, upload_date FROM media WHERE user_id = ?";
                $stmt = mysqli_prepare($db, $query);
                mysqli_stmt_bind_param($stmt, "i", $userId);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $mediaId, $title, $type, $description, $uploadDate);

                while (mysqli_stmt_fetch($stmt))
                {
                    echo
                    "<div class='item'>
                        <div class='image'>
                            <img src='https://placehold.it/350x150'>
                        </div>
                        <div class='content'>
                            <a class='header' href='player.php?media_id=".$mediaId."'><h2>".$title."</h2></a>
                            <div class='extra'><h3>".$type." uploaded "
                                .date_format(date_create($uploadDate), 'F Y')
                            ."</h3></div>
                            <div class='meta'>
                                <span><h4>".$description."</h4></span>
                            </div>
                        </div>";
                        if (isUserProfile($userId))
                        {
                            echo
                            "<div class='right floated content'>
                                <div class='ui two buttons'>
                                    <div class='ui button positive' onclick=\"location.href='update_media.php?media_id=$mediaId';\">Update</div>
                                    <div class='ui button negative' onclick=\"location.href='delete_media.php?media_id=$mediaId';\">Delete</div>
                                </div>
                            </div>";
                        }
                    echo "</div>";
                }

                mysqli_stmt_close($stmt);
                ?>
            </div>

        </div>

        <!-- Footer segement -->
        <div class="ui inverted vertical footer segment container">
            <div class="ui centered">
                <div class="ui stackable inverted divided equal height stackable grid">
                    <div class="three wide column">
                        <h4 class="ui inverted header">Creators</h4>
                        <div class="ui inverted link list">
                            <a href="https://mbinns.github.io" class="item">Mackenzie Binns</a>
                            <a href="#" class="item">Ronnie Funderburk</a>
                            <a href="#" class="item">Kevin Kim</a>
                        </div>
                    </div>

                    <div class="seven wide column">
                        <h4 class="ui inverted header">About</h4>
                        <p>This is the MeTube site designed for the Clemson CPSC 4620 Databases class.</p>
                    </div>
                </div>
            </div>
        </div>


</div>
</body>
</html>
