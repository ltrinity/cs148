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
$courseInformation = 'SELECT fldDepartment, fldCourseNumber, fldCourseTitle, pmkCourseId, fldCredits_, fldComputerNumber,'
        . 'fldSection, fldLectureLab, fldCampCode, fldMaxEnrollment, fldCurrentEnrollment, fldStart, fldStop,'
        . 'fldDays, fldBuilding, fldRoom, fnkCourseId, fnkTeacherNetId FROM tblSections JOIN tblCourses ON fnkCourseId = pmkCourseId '
        . 'WHERE fldDepartment LIKE ? AND fnkCourseID LIKE ?';
$uniqueCourseInformation = $thisDatabaseReader->select($courseInformation, $uniqueCourseInfoVariables, 1, 1, 0, 0, false, false);
//print out the information
if (is_array($uniqueCourseInformation)) {
    foreach ($uniqueCourseInformation as $uniqueCourse) {
        print '<p>' . $uniqueCourse['fldDepartment'] . ' ' . $uniqueCourse['fldCourseNumber'] . ' ' .
                $uniqueCourse['fldCourseTitle'] . ' Credits: ' . $uniqueCourse['fldCredits_'] . '</p>
                <p>Section: ' . $uniqueCourse['fldSection'] . ' CRN Number: ' . $uniqueCourse['fldComputerNumber'] .
                ' Lecture/Lab: ' . $uniqueCourse['fldLectureLab'] . ' Camp Code: ' . $uniqueCourse['fldCampCode'] . '</p>
                <p>Teacher: ' . $uniqueCourse['fnkTeacherNetId']  . ' Max Enrollment: ' . $uniqueCourse['fldMaxEnrollment'] . ' Current Enrollment: '
                . $uniqueCourse['fldCurrentEnrollment'] . '</p> <p>Start Time: ' . $uniqueCourse['fldStart'] .
                ' End Time: ' . $uniqueCourse['fldStop'] . ' Days: ' . $uniqueCourse['fldDays'] .
                ' Building: ' . $uniqueCourse['fldBuilding'] . ' Room: ' . $uniqueCourse['fldRoom'] . '</p>';
        echo '<br />\n';  
    }
}
?>

