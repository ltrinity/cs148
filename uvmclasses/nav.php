<!-- ###################### Main Navigation ########################## -->
<nav>
    <ol>
        <?php
        /* This sets the current page to not be a link. Repeat this if block for
         * each menu item */
        print '<li';
        if ($PATH_PARTS['filename'] == "index") {
            print ' class="activePage"';
        }
        print '><a href="index.php">Home</a></li>';

        print '<li';
        if ($PATH_PARTS['filename'] == "populate_table_courses") {
            print ' class="activePage"';
        }
        print '><a href="populate_table_courses.php">populate tblCourses</a></li>';

        print '<li';
        if ($PATH_PARTS['filename'] == "populate_table_teachers") {
            print ' class="activePage"';
        }
        print '><a href="populate_table_teachers.php">populate tblTeachers</a></li>';
        
        print '<li';
        if ($PATH_PARTS['filename'] == "populate_table_sections") {
            print ' class="activePage"';
        }
        print '><a href="populate_table_sections.php">populate tblSections</a></li>';
        
        print '<li';
        if ($PATH_PARTS['filename'] == "tables") {
            print ' class="activePage"';
        }
        print '><a href="tables.php">Tables</a></li>';
        ?>
    </ol>
</nav>