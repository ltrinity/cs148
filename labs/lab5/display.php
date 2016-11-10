<?php
//initialize database connection
include "top.php";
//create navigation
include "nav.php";
include "ldap.php";
//get remote user net id
$currentUser = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
//default plan selected to null
$planSelected = "";
################Plan Query#########################3
$getPlansQuery = 'SELECT pmkPlanId, fldType, fldConcentration, fldCollege, fldCatalogYear ';
$getPlansQuery .= 'FROM tblPlans JOIN tblDegrees ON pmkDegreeId = fnkDegreeId WHERE fnkStudentNetId = ?';
$planQueryData = array($currentUser);
$plans = $thisDatabaseReader->select($getPlansQuery, $planQueryData, 1);
##############if form is submitted################################################
if (isset($_GET["formSubmit"])) {
    //get the values from the form
    $planSelected = htmlentities($_GET["plans"], ENT_QUOTES, "UTF-8");
    $planInput = array($planSelected);
    $classQuery = 'SELECT DISTINCT fldDepartment, fldCourseNumber, fldCourseTitle, pmkCourseId, '
            . 'fnkCourseId, fnkTerm, fldTerm, fnkTermYear, fldTermYear, fldRequirement FROM tblSemestersCourses '
            . 'JOIN tblCourses ON pmkCourseId = fnkCourseId '
            . 'JOIN tblSemesters ON fnkTerm = fldTerm AND fnkTermYear = fldTermYear '
            . 'WHERE tblSemestersCourses.fnkPlanId = ? ORDER BY fldTermYear,fldTerm';
    
    $classes = $thisDatabaseReader->select($classQuery, $planInput, 1, 2, 0, 0, false, false);
}
?>
<!--begin form-->
<form method = "get" action = "display.php">
    <fieldset id = "planForm2">
        <legend>Display Plans</legend>
        <label>Choose your plan.
            <select name="plans">
                <?php
                if (is_array($plans)) {
                    print '<option';
                    //get selected to preserve from previous submission
                    if ("" == $planSelected) {
                        print ' selected="selected"';
                    }
                    print ' value ="">Choose a Plan</option>';
                    foreach ($plans as $plan) {
                        print '<option';
                        if ($plan['pmkPlanId'] == $planSelected) {
                            print ' selected="selected"';
                        }
                        print ' value = "';
                        print $plan['pmkPlanId'];
                        print '">';
                        print $plan['fldCollege'];
                        print ' ';
                        print $plan['fldType'];
                        print ' ';
                        print $plan['fldConcentration'];
                        print " Catalog Year: ";
                        print $plan['fldCatalogYear'];
                        print '</option>';
                    }
                }
                ?>
                <!--end select-->
            </select>
        </label>
    </fieldset>
    <fieldset class="buttons">
        <legend></legend>
        <input class="button" id="formSubmit" name="formSubmit" tabindex="900" type="submit" value="Choose Plan" >
    </fieldset>
</form>
<?php
$getCurrentInfoQuery = 'SELECT fldType, fldConcentration, fldCollege ,fldDateCreated, fldCatalogYear, fnkStudentNetId, fnkAdvisorNetId ';
$getCurrentInfoQuery .= 'FROM tblPlans JOIN tblDegrees ON pmkDegreeId = fnkDegreeId WHERE pmkPlanId = ?';
$getInfoData = array($planSelected);
if ($planSelected != "") {
    $currentInformation = $thisDatabaseReader->select($getCurrentInfoQuery, $getInfoData, 1);
}
if (is_array($currentInformation)) {
    $oneRow = $currentInformation[0];
    print '<fieldset>';
    print '<legend>Current Plan Information</legend>';
    print '<p>Degree: ' . $oneRow['fldType'] . " ".$oneRow['fldConcentration'] . " ".$oneRow['fldCollege'] . '</p>';
    print '<p>Catalog Year: ' . $oneRow['fldCatalogYear'] . '</p>';
    print '<p>Date Created: ' . $oneRow['fldDateCreated'] . '</p>';
    //parse student name
    $sNameArray = explode(":", ldapName($oneRow['fnkStudentNetId']));
    $sFirstName = $sNameArray[0];
    $sLastName = $sNameArray[1];
    $sEmail = $oneRow['fnkStudentNetId'] . "@uvm.edu";
    //parse advisor name
    $aNameArray = explode(":", ldapName($oneRow['fnkAdvisorNetId']));
    $aFirstName = $aNameArray[0];
    $aLastName = $aNameArray[1];
    print '<p>Student: '. $sFirstName . " " . $sLastName . ' - ' . $sEmail . '</p>';
    //if advisor is not null create advisor email else it is also null
    if ($oneRow['fnkAdvisorNetId'] != "") {
        $aEmail = $oneRow['fnkAdvisorNetId'] . "@uvm.edu";
        print '<p>Advisor: ' . $aFirstName . " " . $aLastName . ' - ' . $aEmail . '</p>';
    }
    print '</fieldset>';
}
if (is_array($classes)) {
    print '<fieldset>';
    print '<legend>Color Legend</legend>';
    print '<p class ="Major">Major</p>';
    print '<p class ="Minor">Minor</p>';
    print '<p class ="Elective">Elective</p>';
    print '</fieldset>';
    print '<table>';
    print '<tr>';
    print '<th>Year</th>';
    print '<th>Semester</th>';
    print '<th>Department</th>';
    print '<th>Number</th>';
    print '<th>Title</th>';
    print '</tr>';
    foreach ($classes as $class) {
        print '<tr class = "'. $class['fldRequirement'] . '">';
        print '<td>' . $class['fldTermYear'] . '</td>';
        print '<td>' . $class['fldTerm'] . '</td>';
        print '<td>' . $class['fldDepartment'] . '</td>';
        print '<td>' . $class['fldCourseNumber'] . '</td>';
        print '<td>' . $class['fldCourseTitle'] . '</td>';
        print '</tr>';
    }
    print '</table>';
}


include "footer.php";
?>