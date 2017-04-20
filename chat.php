<?php
include_once "helper.php";
session_start();

if (!isset($_GET['sender_id']))
    return;

$senderId = $_GET['sender_id'];
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
    <title>Chat</title>
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


    <!-- Reply Script input Validation -->
    <script>
        $(document)
            .ready(function () {
                $('.ui.form')
                    .form({
                        fields: {
                            message: {
                                identifier: 'message',
                                rules: [
                                    {
                                        type    :   'empty',
                                        prompt  :   'Please enter a message'
                                    }
                                ]
                            }
                        }
                    })
                ;
            })
        ;
    </script>

    <!-- Menu -->
<?php include "menu_scripts.php";?>:
</head>

<body>
    <!-- Following Menu -->
    <!-- Sidebar Menu -->
<div class="pusher">
    <div class="ui container">
        <?php include "menu.php";?>

    <?php
    global $db;
    $senderName = getUserName($senderId);
    $query = "SELECT message, time FROM messages WHERE sender_id = ? AND receiver_id = ? ORDER BY time DESC";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "ii", $senderId, $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $message, $timestamp);
    ?>

    <div class="ui row segment centered">
        <h2>Messages from <?php echo $senderName ?></h2>
    </div>

    <div class="ui items segment container">
        <?php
        while (mysqli_stmt_fetch($stmt))
        {
            echo
            "<div class='item'>
                <div class='content'>
                    <div>".$message
                    ."</div>
                    <div class='meta'>
                        <span>".$timestamp."</span>
                    </div>
                </div>
            </div>";
        }
        mysqli_stmt_close($stmt);
        ?>
    </div>

        <form name="messages_form" class="ui reply form" action="reply.php?receiver_id=<?php echo $senderId ?>" method="post">
            <div class="field">
                <textarea name="message"></textarea>
            </div>
            <button class="ui fluid blue labeled submit icon button" name="submit">
                Send Reply
            </button>
        </form>

    <?php include "footer.php";?>
    </div>
</div>
</body>
</html>
