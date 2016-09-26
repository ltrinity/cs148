<!--this page will display a listbox based on the department selected in the listbox of departments-->
<h2>List Box of Classes by Selected Department</h2>
<!--begin form which will post to the current page-->
<form method = "post" action = "index.php">
    <!--begin select with name classbydeptLB-->
    <select name="classbydeptLB">
        <?php
//        select the department and course name for all records in tblCourses that match the current dept $dept
        $query = 'SELECT fldDepartment, fldCourseName FROM tblCourses WHERE fldDepartment LIKE "' . $dept . '"';
        $records = $thisDatabaseReader->select($query, "", 1, 0, 2, 0, false, false);
        if (is_array($records)) {
            foreach ($records as $record) {
//                show each course in the department as an option in the listbox
                print "<option>" . $record['fldDepartment'] . "~" . $record['fldCourseName'] . "</option>";
            }
        }
        ?>
        <!--end select-->
    </select>
    <!--submit button code-->
    <fieldset class="buttons">
        <legend></legend>
        <input type="submit" id="classSelect" name="classSelect" value="Get Class Information" tabindex="900" class="button">
    </fieldset>
</form>