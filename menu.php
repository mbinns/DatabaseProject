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
        <div class="ui search">
            <div class="ui icon input">
                <input class="prompt" type="text" placeholder="Search...">
                    <i class="search icon"></i>
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
