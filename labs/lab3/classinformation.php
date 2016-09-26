<!--page to display information of class selected in listbox created by classesbydepartment.php-->
<h2>Class Information of Selected Class</h2>
<?php
//as long as there has been a class selected and posted from the class selection listbox
if ($class != '') {
    //parse the string by the tilda which was inserted between department and class name
    $myArray = explode('~', $class);
    //store the variables that were parsed into the array
    $currentDepartment = $myArray[0];
    $currentClassName = $myArray[1];
    //get the relevant fields from the courses table that match the variables parsed from above 
    $query = 'SELECT fldDepartment, fldCourseNumber, fldCourseName, fldCredits FROM tblCourses WHERE fldDepartment LIKE "' . $currentDepartment . '" AND fldCourseName LIKE "' . $currentClassName . '"';
    $records = $thisDatabaseReader->select($query, "", 1, 1, 4, 0, false, false);
    //print out the information
    if (is_array($records)) {
        foreach ($records as $record) {
            print "<p>Department: " . $record['fldDepartment'] . "</p>";
            print "<p>Course Number: " . $record['fldCourseNumber'] . "</p>";
            print "<p>Course Name: " . $record['fldCourseName'] . "</p>";
            print "<p>Credits: " . $record['fldCredits'] . "</p>";
        }
    }
    //get the primary key of the selected course in the courses table
    $query2 = 'SELECT pmkCourseID FROM tblCourses WHERE fldDepartment LIKE "' . $currentDepartment . '" AND fldCourseName LIKE "' . $currentClassName . '"';
    $records2 = $thisDatabaseReader->select($query2, "", 1, 1, 4, 0, false, false);
    if (is_array($records2)) {
        foreach ($records2 as $record2) {
            //store this value in the variable foreign key
            $foreignKey = $record2['pmkCourseID'];
        }
    }
    //get the relevant information from the teacherscourses table when the foreign key from that table matches the primary key stored
    $query3 = 'SELECT fldCompNumb, fldSection, fldLecLab, fldCampCode,'
            . 'fldMaxEnrollment, fldCurrentEnrollment, fldStartTime, fldEndTime,'
            . 'fldDays, fldBldg, fldRoom FROM tblTeachersCourses WHERE fnkCourseID =' . $foreignKey;
    $records3 = $thisDatabaseReader->select($query3, "", 1, 0, 0, 0, false, false);
    //print out the relevant fields
    if (is_array($records3)) {
        foreach ($records3 as $record3) {
            print "<p>CRN Number: " . $record3['fldCompNumb'] . "</p>";
            print "<p>Section: " . $record3['fldSection'] . "</p>";
            print "<p>Lecture/Lab: " . $record3['fldLecLab'] . "</p>";
            print "<p>Camp Code: " . $record3['fldCampCode'] . "</p>";
            print "<p>Max Enrollment: " . $record3['fldMaxEnrollment'] . "</p>";
            print "<p>Current Enrollment: " . $record3['fldCurrentEnrollment'] . "</p>";
            print "<p>Start Time: " . $record3['fldStartTime'] . "</p>";
            print "<p>End Time: " . $record3['fldEndTime'] . "</p>";
            print "<p>Days: " . $record3['fldDays'] . "</p>";
            print "<p>Building: " . $record3['fldBldg'] . "</p>";
            print "<p>Room: " . $record3['fldRoom'] . "</p>";
        }
    }
    
}
?>

