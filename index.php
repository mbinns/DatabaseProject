<?php
include_once "helper.php";
session_start();

if (isset($_GET['logout']))
{
    session_destroy();
    header("Location: index.php");
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

    <!-- Modfying some stuff for the home page -->
    <style type="text/css">
		.pusher {
			background-color: #1b1c1d !important;

		}
        .hidden.menu {
            display: none;
        }

        .masthead.segment {
            min-height: 700px;
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
                "<a class='item' href='channel.php?id=".$_SESSION['user_id']."'>My Channel</a>";
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
            "<a class='item' href='channel.php?id=".$_SESSION['user_id']."'>My Channel</a>";
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
        <div class="ui inverted vertical masthead center aligned segment">

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
                        "<a class='item' href='channel.php?id=".$_SESSION['user_id']."'>My Channel</a>";
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

            <div class="ui text container">
                <h1 class="ui inverted header">
                    MeTube
                </h1>
                <h2>Upload Whatever, Whenever</h2>
            </div>

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
    </div>

</body>
</html>
