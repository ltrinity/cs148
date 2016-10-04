<!--page to display information of class selected in listbox created by classesbydepartment.php-->
<?php
//if nothing has been set initialize query input variables to % to show all courses
    $currentDepartment = '%';
    $currentCourseNumber = '%';
    $currentClassName = '%';
    $currentCourseIDpmk = '%';
//if a class has been selected
if ($classSelected != '%') {
//parse the string by the tilda which was inserted between all the information
    $myArray = explode('~', $classSelected);
//store the variables that were parsed into the array
    $currentDepartment = $myArray[0];
    $currentCourseNumber = $myArray[1];
    $currentClassName = $myArray[2];
    $currentCourseIDpmk = $myArray[3];
}
//if the department has been changed
if ($deptSelected !=$currentDepartment) {
    $currentDepartment = $deptSelected;
    $currentCourseNumber = '%';
    $currentClassName = '%';
    $currentCourseIDpmk = '%';
}
//get the relevant fields from the courses table that match the variables parsed from above 
$uniqueCourseInfoVariables = array($currentDepartment, $currentCourseIDpmk);
$courseInformation = 'SELECT fldDepartment, fldCourseNumber, fldCourseName, pmkCourseId, fldCredits, fldCompNumb,'
        . 'fldSection, fldLecLab, fldCampCode, fldMaxEnrollment, fldCurrentEnrollment, fldStartTime, fldEndTime,'
        . 'fldDays, fldBldg, fldRoom, fnkCourseId FROM tblTeachersCourses JOIN tblCourses ON pmkCourseId = fnkCourseId '
        . 'WHERE fldDepartment LIKE ? AND fnkCourseID LIKE ?';
$uniqueCourseInformation = $thisDatabaseReader->select($courseInformation, $uniqueCourseInfoVariables, 1, 1, 0, 0, false, false);
//print out the information
if (is_array($uniqueCourseInformation)) {
    foreach ($uniqueCourseInformation as $uniqueCourse) {
        print "<p>" . $uniqueCourse['fldDepartment'] . " " . $uniqueCourse['fldCourseNumber'] . " " .
                $uniqueCourse['fldCourseName'] . " Credits: " . $uniqueCourse['fldCredits'] . "</p>
                <p>Section: " . $uniqueCourse['fldSection'] . " CRN Number: " . $uniqueCourse['fldCompNumb'] .
                " Lecture/Lab: " . $uniqueCourse['fldLecLab'] . " Camp Code: " . $uniqueCourse['fldCampCode'] . "</p>
                <p>Max Enrollment: " . $uniqueCourse['fldMaxEnrollment'] . " Current Enrollment: "
                . $uniqueCourse['fldCurrentEnrollment'] . "</p> <p>Start Time: " . $uniqueCourse['fldStartTime'] .
                " End Time: " . $uniqueCourse['fldEndTime'] . " Days: " . $uniqueCourse['fldDays'] .
                " Building: " . $uniqueCourse['fldBldg'] . " Room: " . $uniqueCourse['fldRoom'] . "</p>";
        echo "<br />\n";  
    }
}
?>

