<?php
//initialize database connection
include	"top.php";
//########################################################
// This page lists the records based on the query given
//########################################################
//this query displays all CS teachers sorted by last name then first name
//$csTeachersAlphabeticalSort = 'SELECT DISTINCT fldFirstName, fldLastName, fldDepartment FROM tblSections '
//        . 'JOIN tblCourses ON fnkCourseId = pmkCourseId '
//        . 'JOIN tblTeachers ON fnkTeacherNetId = pmkNetId '
//        . 'WHERE fldDepartment = "CS" '
//        . 'ORDER BY tblTeachers.fldLastName, tblTeachers.fldFirstName';
//this query sorts the CS teachers by current enrollment
$csTeachersSumStudentsSort = 'SELECT fldFirstName, fldLastName, fldDepartment, SUM(fldCurrentEnrollment), pmkNetID '
    . 'FROM tblSections JOIN tblCourses ON fnkCourseId = pmkCourseId JOIN tblTeachers ON fnkTeacherNetId = pmkNetId '
    . 'WHERE fldDepartment = "CS" GROUP BY pmkNetID ORDER BY SUM(fldCurrentEnrollment) DESC';
//public function select($query, $values = "", $wheres = 1, $conditions = 0, 
//   $quotes = 0, $symbols = 0, $spacesAllowed = false, $semiColonAllowed = false)
$records = $thisDatabaseReader->select($csTeachersSumStudentsSort, "", 1, 1, 2, 0, false, false);
if (DEBUG) {
    print "<p>Contents of the array<pre>";
    print_r($records);
    print "</pre></p>";
}
print '<h2 class="alternateRows">UVM Teachers</h2>';
if (is_array($records)) {
    foreach ($records as $record) {
        print "<p>" . $record['fldFirstName'] . " " . $record['fldLastName'] . " "
                . $record['SUM(fldCurrentEnrollment)'] ."</p>";
    }
}
//answering the question in the lab
print '<p> The debug statement is significant because by printing the array created by our query, '
. 'we can find our mistakes. If the array printed is empty, then we know the error is in creating '
        . 'the array with SQL statements. If the array has data, but it is not printed, we know our error is '
        . 'in displaying the data. Most likely an incorrect variable name or some other syntax issue. </p>';
include "footer.php";
?>
