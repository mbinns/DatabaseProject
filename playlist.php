<?php
include_once "helper.php";
session_start();

if (!isset($_GET['playlist_id']))
    return;
$playlistId = $_GET['playlist_id'];

if (isUserLoggedIn())
    $userId = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- Site Properties -->
    <!-- ../dist/components/-->
    <title>MeTube</title>
    <link href="Content/semantic.css" rel="stylesheet" />
    <link href="Content/components/reset.css" rel="stylesheet" />
    <link href="Content/components/site.css" rel="stylesheet" />
    <link href="Content/components/container.css" rel="stylesheet" />
    <link href="Content/components/grid.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="Content/components/image.css">
    <link rel="stylesheet" type="text/css" href="Content/components/menu.css">
    <link href="Content/components/header.css" rel="stylesheet" />
    <link href="Content/components/dropdown.css" rel="stylesheet" />
    <link href="Content/components/segment.css" rel="stylesheet" />
    <link href="Content/components/button.css" rel="stylesheet" />
    <link href="Content/components/list.css" rel="stylesheet" />
    <link href="Content/components/icon.css" rel="stylesheet" />
    <link href="Content/components/sidebar.css" rel="stylesheet" />
    <link href="Content/components/transition.css" rel="stylesheet" />

    <!-- Modfying some stuff for the home page -->
    <style type="text/css">
		.pusher {
			background-color: #1b1c1d !important;

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
    </style>

    <!-- ../dist/components/-->
    <script src="Scripts/jquery-1.8.1.min.js"></script>
    <script src="Scripts/semantic.js"></script>
    <script src="Content/components/visibility.js"></script>
    <script src="Content/components/sidebar.js"></script>
    <script src="Content/components/transition.js"></script>

    <!-- Menu -->
<?php include "alt_menu.php";?>
</head>

<body>
<!-- Following Menu -->
<!-- Sidebar Menu -->
<?php include "alt_menu.php";?>

<div class="pusher">
<?php include "menu.php";?>
    <?php
    global $db;
    $query = "SELECT pl_name FROM playlist WHERE pl_id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $playlistId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $playlistName);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    $query = "SELECT account.user_id, account.firstname, account.lastname,
              media.media_id, media.title, media.type, media.description, media.upload_date
              FROM media
              JOIN playlistmedia ON media.media_id = playlistmedia.media_id
              JOIN account ON media.user_id = account.user_id
              WHERE playlistmedia.playlist_id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $playlistId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $uploadUserId, $fname, $lname, $mediaId, $title, $type, $description, $uploadDate);
    ?>

    <div class="ui items divided list segment container">
        <?php
        echo " <div class='header'><h2>$playlistName</h2></div>";
        while (mysqli_stmt_fetch($stmt))
        {
            echo
            "<div class='item'>
                <div class='small image'>
                    <img src='".getThumbnail($type)."'>
                </div>
                <div class='content'>
                    <a class='header' href='player.php?media_id=".$mediaId."'>".$title."</a>
                    <a class='extra' href='channel.php?user_id=$uploadUserId'>".$type." uploaded by
                        <span style='color: #f2711c'>".$fname." ".$lname."</span>on "
                        .date_format(date_create($uploadDate), 'F Y')
                    ."</a>
                    <div class='meta'>
                        <span>".$description."</span>
                    </div>
                </div>";
                if (isset($userId) && isUserProfile($userId))
                {
                    echo"
                    <div class='right floated content'>
                        <div class='ui button negative' onclick=\"location.href='remove_from_playlist.php?media_id=$mediaId&pId=$playlistId';\">Remove</div>
                    </div>";
                }
            echo "
            </div>";
        }
        mysqli_stmt_close($stmt);
        ?>
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
</div>
</body>
</html>
