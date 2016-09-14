<nav>
    <ul>
        <?php
        /* This sets the current page to not be a link. Repeat this if block for
         *  each menu item */
        if ($path_parts['filename'] == "index") {
            print '<li>Index</li>';
        } else {
            print '<li><a href="index.php">Index</a></li>';
        }
        if ($path_parts['filename'] == "results") {
            print '<li>Class Info</li>';
        } else {
            print '<li><a href="results.php">Class Info</a></li>';
        }
        ?>
    </ul>
</nav>