<!-- ######################     Main Navigation   ########################## -->
<nav>
    <ol>
        <?php
        // This sets the current page to not be a link. Repeat this if block for
        //  each menu item 
        
        
        if ($PATH_PARTS['filename'] == "index") {
            print '<li class="activePage"><a href="index.php">Home</a></li>';
        } else {
            print '<li><a href="index.php">Home</a></li>';
        }
        
        if ($PATH_PARTS['filename'] == "sampleQuery") {
            print '<li class="activePage"><a href="sampleQuery.php">Sample SELECT</a></li>';
        } else {
            print '<li><a href="sampleQuery.php">Sample SELECT</a></li>';
        }
        
        if ($PATH_PARTS['filename'] == "sampleQuery2") {
            print '<li class="activePage"><a href="sampleQuery2.php">Sample INSERT</a></li>';
        } else {
            print '<li><a href="sampleQuery2.php">Sample INSERT</a></li>';
        }
        
        if ($PATH_PARTS['filename'] == "sampleQuery3") {
            print '<li class="activePage"><a href="sampleQuery3.php">Sample SELECT (with ORDER)</a></li>';
        } else {
            print '<li><a href="sampleQuery3.php">Sample SELECT (with ORDER)</a></li>';
        }
        
        if ($PATH_PARTS['filename'] == "sampleQuery4") {
            print '<li class="activePage"><a href="sampleQuery4.php">Sample test (fails)</a></li>';
        } else {
            print '<li><a href="sampleQuery4.php">Sample test (fails)</a></li>';
        }
        ?>
    </ol>
</nav>
<!-- #################### Ends Main Navigation    ########################## -->

