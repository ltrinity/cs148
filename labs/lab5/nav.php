<!-- ######################     Main Navigation   ########################## -->
<nav>
    <ol>
        <?php
        // This sets the current page to not be a link. Repeat this if block for
        //  each menu item 
        
        
        if ($PATH_PARTS['filename'] == "index") {
            print '<li class="activePage"><a href="index.php">Index</a></li>';
        } else {
            print '<li><a href="index.php">Index</a></li>';
        }
        
        if ($PATH_PARTS['filename'] == "er") {
            print '<li class="activePage"><a href="er.php">ER Diagram</a></li>';
        } else {
            print '<li><a href="er.php">ER Diagram</a></li>';
        }
        if ($PATH_PARTS['filename'] == "dictionary") {
            print '<li class="activePage"><a href="dictionary.php">Data Dictionary</a></li>';
        } else {
            print '<li><a href="dictionary.php">Data Dictionary</a></li>';
        }
        if ($PATH_PARTS['filename'] == "schema") {
            print '<li class="activePage"><a href="schema.php">Schema</a></li>';
        } else {
            print '<li><a href="schema.php">Schema</a></li>';
        }
        ?>
    </ol>
</nav>
<!-- #################### Ends Main Navigation    ########################## -->

