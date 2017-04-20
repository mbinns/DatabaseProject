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

