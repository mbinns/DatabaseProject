<?php
include_once "helper.php";
session_start();
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
    <?php include "menu_scripts.php";?>
</head>

<body>
    <!-- Following Menu -->
    <!-- Sidebar Menu -->
<?php include "alt_menu.php";?>
<div class="pusher">
    <!-- Menu -->
    <?php include "menu.php";?>

    <div class="ui items list divided segment container">
        <?php
        global $db;
        $query = "SELECT account.user_id, account.firstname, account.lastname,
                  media.media_id, media.title, media.type, media.upload_date, media.description
                  FROM media
                  JOIN account ON media.user_id = account.user_id
                  WHERE media.type = 'Video'";
        $result = mysqli_query($db, $query);
        echo "<div class='header'><h2>All Videos</h2></div>";
        while ($row = mysqli_fetch_row($result))
        {
            echo
            "<div class='item'>
                <div class='small image'>
                    <img src='media/Video_thumbnail.png'>
                </div>
                <div class='content'>
                    <a class='header' href='player.php?media_id=$row[3]'>".$row[4]."</a>
                    <a class='extra' href='channel.php?user_id=$row[0]'>".$row[5]." uploaded by
                        <span style='color: #f2711c'>".$row[1]." ".$row[2]."</span>on "
                        .date_format(date_create($row[6]), 'F Y')
                    ."</a>
                    <div class='meta'>
                        <span>".$row[7]."</span>
                    </div>
                </div>
            </div>";
        }
        ?>
    </div>

        <!-- Footer segement -->
        <?php include "footer.php";?>
    </div>
</div>
</body>
</html>
