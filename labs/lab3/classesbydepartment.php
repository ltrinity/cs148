<!--this page will display a listbox based on the department selected in the listbox of departments-->
<!--begin select with name classbydeptLB-->
<select name="classbydeptLB">
    <?php
    //if a class has been selected
    if ($classSelected != '%') {
//parse the string by the tilda which was inserted between all the information
        $classSubmissionArray = explode('~', $classSelected);
//store the variables that were parsed into the array
        $courseIDpmk = $classSubmissionArray[3];
    } else {
        //initialize pmk to null
        $courseIDpmk = '';
    }
//put the selected department in an array to pass into the query
    $inputForClassListbox = array($deptSelected);
    //initialize SQL query
    $classByDept = 'SELECT fldDepartment, fldCourseNumber, fldCourseTitle, pmkCourseID '
            . 'FROM tblCourses WHERE fldDepartment LIKE ?';
    $classes = $thisDatabaseReader->select($classByDept, $inputForClassListbox, 1, 0, 0, 0, false, false);
    if (is_array($classes)) {
        foreach ($classes as $class) {
//                show the info related to each course in the department as an option in the listbox
            print "<option";
            //preserve submission from previous input
            if ($class['pmkCourseID'] == $courseIDpmk) {
                print ' selected="selected"';
            }
            print ">" . $class['fldDepartment'] . "~" . $class['fldCourseNumber'] .
                    "~" . $class['fldCourseTitle'] . "~" . $class['pmkCourseID'] . "</option>";
        }
    }
    ?>
    <!--end select-->
</select>
<!--submit button code-->
<fieldset class="buttons">
    <legend></legend>
    <input type="submit" id="classSelect" name="classSelect" value="Filter" tabindex="900" class="button">
</fieldset>