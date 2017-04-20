<?php
include_once "helper.php";
session_start();

if (!isset($_GET['media_id']))
    return;

function formatTimestamp($time)
{
    $date = date_create($time);
    return date_format($date, "F d Y h:i A");
}

$mediaId = $_GET['media_id'];

global $db;
$query = "SELECT title, type, filepath, description, user_id, upload_date, download_count, mime, show_comments FROM media WHERE media_id = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "i", $mediaId);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $title, $type, $filepath, $description, $userId, $uploadDate, $downloadCount, $mime, $showComments);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
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
    <title>MeTube Media Player</title>
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

    <!-- Player stuff -->
	<link href="Content/components/dropdown.css" rel="stylesheet" />
	<link href="Content/components/comments.css" rel="stylesheet" />


    <!-- Modfying some stuff for the home page -->
    <style type="text/css">
        .ui#comments{
        }
        .ui#media{
            padding-top: 5em;
            padding-bottom: 5em;
        }
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

    <!-- ../dist/components/-->
    <script src="Scripts/jquery-1.8.1.min.js"></script>
    <script src="Scripts/semantic.js"></script>
    <script src="Content/components/visibility.js"></script>
    <script src="Content/components/sidebar.js"></script>
    <script src="Content/components/transition.js"></script>
	<script src= "Content/components/search.js"></script>
	<script src= "Content/components/dropdown.js"></script>
	<script src= "Content/components/comments.js"></script>

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
            <a class="active item" href="index.php">Home</a>
            <?php
            if (isUserLoggedIn())
            {
                echo
                "<a class='item' href='channel.php?user_id=".$_SESSION['user_id']."'>My Channel</a>";
            }
            ?>
            <div class="ui simple dropdown item">Media
                <i class="dropdown icon"></i>
                <div class="menu">
                  <a class="item" href="all.php">All</a>
                  <a class="item" href="videos.php">Videos</a>
                  <a class="item" href="music.php">Music</a>
                  <a class="item" href="pictures.php">Pictures</a>
                </div>
            </div>
            <a class="item">Favorites</a>
            <div class="right menu">
                <?php
                if (isUserLoggedIn())
                {
                    echo
                    "<div class='item'>
                        <a class='item' href='index.php?logout'>Log out</a>
                    </div>";
                }
                else
                {
                    echo
                    "<div class='item'>
                        <a class='item' href='login.php'>Login</a>
                    </div>";

                    echo
                    "<div class='item'>
                        <a class='item' href='register.php'>Sign Up</a>
                    </div>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <div class="ui vertical inverted sidebar menu">
        <a class="active item" href="index.php">Home</a>
        <?php
        if (isUserLoggedIn())
        {
            echo
            "<a class='item' href='channel.php?user_id=".$_SESSION['user_id']."'>My Channel</a>";
        }
        ?>
        <div class="header item">Media
            <div class="menu">
                <a class="item" href="all.php">All</a>
                <a class="item" href="videos.php">Videos</a>
                <a class="item" href="music.php">Music</a>
                <a class="item" href="pictures.php">Pictures</a>
            </div>
        </div>
        <?php
        if (isUserLoggedIn())
        {
            echo
            "<a class='item' href='index.php?logout'>Log out</a>";
        }
        else
        {
            echo
            "<a class='item' href='login.php'>Login</a>";
            echo
            "<a class='item' href='register.php'>Sign Up</a>";
        }
        ?>
    </div>


    <!-- Page Contents -->
    <div class="pusher">
        <div class="ui inverted vertical masthead segment">

            <div class="ui container">
                <div class="ui large secondary inverted pointing menu">
                    <a class="toc item">
                        <i class="sidebar icon"></i>
                    </a>
                    <a class="active item" href="index.php">Home</a>
                    <?php
                    if (isUserLoggedIn())
                    {
                        echo
                        "<a class='item' href='channel.php?user_id=".$_SESSION['user_id']."'>My Channel</a>";
                    }
                    ?>
                    <div class="ui simple dropdown item">Media
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <a class="item" href="all.php">All</a>
                            <a class="item" href="videos.php">Videos</a>
                            <a class="item" href="music.php">Music</a>
                            <a class="item" href="pictures.php">Pictures</a>
                        </div>
                    </div>
                    <div class="right item">
                    <div class="ui category search item">
                        <div class="ui icon input">
                            <input class="prompt" type="text" placeholder="Search...">
                                <i class="search link icon"></i>
                            </div>
                        <div class="results"></div>
                    </div>
                        <?php
                        if (isUserLoggedIn())
                        {
                            echo
                            "<a class='item' href='index.php?logout'>Log out</a>";
                        }
                        else
                        {
                            echo
                            "<a class='item' href='login.php'>Login</a>";
                            echo
                            "<a class='item' href='register.php'>Sign Up</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div><!--Masthead-->

        <!-- Media player -->
        <div id="media" class="ui container inverted segment">

            <?php
            if ($type == "Picture")
            {
                echo
                "<img class='ui huge image' src='".$filepath."'></img>";
            }
            else if ($type == "Music")
            {
                echo
                "<audio controls>
                    <source src='".$filepath."' type='audio/mpeg'>
                        Your browser does not support the audio element.
                </audio>";
            }
            else if ($type == "Video")
            {
                echo
                "<div class='videoContainer'>
                    <video id='player' controls preload='auto' poster='' width='720'>
                        <source src='".$filepath."' type='video/mp4'/>
                        <p>Your browser does not support the video tag.</p>
                    </video>
                    <div class='control'>
                        <div class='btmControl'>
                            <div class='btnPlay btn' title='Play/Pause video'><span class='icon-play'></span></div>
                            <div class='progress-bar'>
                                <div class='progress'>
                                    <span class='bufferBar'></span>
                                    <span class='timeBar'></span>
                                </div>
                            </div>
                            <div class='volume' title='Set volume'>
                                <span class='volumeBar'></span>
                            </div>
                            <div class='sound sound2 btn' title='Mute/Unmute sound'><span class='icon-sound'></span></div>
                            <div class='btnFS btn' title='Switch to full screen'><span class='icon-fullscreen'></span></div>
                        </div>
                    </div>
                </div>";
            }

            echo
            "<div class='caption'>
                <h1>".$title."</h1>
                <h3>".$downloadCount."&nbsp;&nbsp;&nbsp;Views</h3>
            </div";

            if (isUserLoggedIn())
            {
                // TODO: Add all of the user's playlists
                echo
                "<div class='ui compact menu'>
                    <div class='ui simple dropdown item'>
                        Add to Playlist
                        <i class='dropdown icon'></i>
                        <div class='menu'>
                            <div class='item'>Favorites</div>
                        </div>
                    </div>
                </div>";
            }
            ?>

            <?php
            if ($showComments)
            {
                echo
                "<div id='comments' class='ui segment comments container'>
                    <h3 class='ui dividing header'>Comments</h3>";

                global $db;
                // $query = "SELECT comment, time, user_id FROM comments WHERE media_id = ? ORDER BY time DESC";

                $query = "SELECT comments.comment, comments.time, comments.user_id, account.firstname, account.lastname
                          FROM comments
                          JOIN account ON comments.user_id = account.user_id
                          WHERE media_id = ? ORDER BY time DESC";

                $stmt = mysqli_prepare($db, $query);
                mysqli_stmt_bind_param($stmt, "i", $mediaId);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $comment, $time, $userId, $fname, $lname);

                while (mysqli_stmt_fetch($stmt))
                {
                    echo
                    "<div class='comment'>
                        <div class='content'>
                            <a class='author' href='channel.php?user_id=".$userId."'>".$fname." ".$lname."</a>
                            <div class='metadata'>
                                <span class='date'>".formatTimestamp($time)."</span>
                            </div>
                            <div class='text'>"
                                .$comment.
                            "</div>
                        </div>
                    </div>";
                }

                echo
                "<form class='ui reply form'>
                    <div class='field'>
                        <textarea></textarea>
                    </div>
                    <div class='ui blue labeled submit icon button'>
                        <i class='icon edit'></i> Add Reply
                    </div>
                </form>
            </div>";
        }
        ?>
        </div>

        <div class="ui inverted vertical footer segment">
            <div class="ui container">
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
    </div><!-- Pusher -->
</body>

