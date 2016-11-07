<?php
//initialize database connection
include "top.php";
//include navigation page
include "nav.php";
include "ldap.php";
###############initialize variables#########################################
$studentNetId = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
$advisorNetId = '';
$yearEntered = '2015';
$degreeSelected = "";
$catalogSelected = "2016";
#initialize catalogs array
$catalogs = array();
#fill the catalogs array with years
$k = 2016;
for ($i = 0; $i < 116; $i++) {
    $catalogs[$i] = $k;
    $k--;
}
###############On Form Submission######################################################
if (isset($_GET["btnSubmit"])) {
    $studentNetId = htmlentities($_GET["studentNetId"], ENT_QUOTES, "UTF-8");
    $advisorNetId = htmlentities($_GET["advisorNetId"], ENT_QUOTES, "UTF-8");
    $yearEntered = htmlentities($_GET["yearEntered"], ENT_QUOTES, "UTF-8");
    $degreeSelected = htmlentities($_GET["degree"], ENT_QUOTES, "UTF-8");
    $catalogSelected = htmlentities($_GET["catalog"], ENT_QUOTES, "UTF-8");
    //parse student name
    $studentNameArray = explode(":", ldapName($studentNetId));
    $studentFirstName = $studentNameArray[0];
    $studentLastName = $studentNameArray[1];
    $studentEmail = $studentNetId . "@uvm.edu";
    //store data needed to input into tblStudents
    $tblStudentsInfo = array($studentNetId, $studentFirstName, $studentLastName, $studentEmail, $yearEntered);
    //parse advisor name
    $advisorNameArray = explode(":", ldapName($advisorNetId));
    $advisorFirstName = $advisorNameArray[0];
    $advisorLastName = $advisorNameArray[1];
    //if advisor is not null create advisor email else it is also null
    if ($advisorNetId != "") {
        $advisorEmail = $advisorNetId . "@uvm.edu";
    } else {
        $advisorEmail = "";
    }
    //store data needed to input into tblAdvisors
    $tblAdvisorsInfo = array($advisorNetId, $advisorFirstName, $advisorLastName, $advisorEmail);
    //get current date
    $dateCreated = date("m-d-Y");
    //store data needed to input into tblPlans
    $tblPlansInfo = array($studentNetId, $advisorNetId, $degreeSelected, $dateCreated, $catalogSelected);
    ######Queries and Table Insertions###############################################################
    $tblStudentsQuery = 'INSERT INTO tblStudents SET ';
    $tblStudentsQuery .= 'pmkStudentNetId = ? ,';
    $tblStudentsQuery .= 'fldStudentFirstName = ? ,';
    $tblStudentsQuery .= 'fldStudentLastName = ? ,';
    $tblStudentsQuery .= 'fldStudentEmail = ? ,';
    $tblStudentsQuery .= 'fldYearEntered = ?';
    $thisDatabaseWriter->insert($tblStudentsQuery, $tblStudentsInfo);
    $tblAdvisorsQuery = 'INSERT INTO tblAdvisors SET ';
    $tblAdvisorsQuery .= 'pmkAdvisorNetId = ? ,';
    $tblAdvisorsQuery .= 'fldAdvisorFirstName = ? ,';
    $tblAdvisorsQuery .= 'fldAdvisorLastName = ? ,';
    $tblAdvisorsQuery .= 'fldAdvisorEmail = ?';
    $thisDatabaseWriter->insert($tblAdvisorsQuery, $tblAdvisorsInfo);
    $tblPlansQuery = 'INSERT INTO tblPlans SET ';
    $tblPlansQuery .= 'fnkStudentNetId = ? ,';
    $tblPlansQuery .= 'fnkAdvisorNetId = ? ,';
    $tblPlansQuery .= 'fnkDegreeId = ? ,';
    $tblPlansQuery .= 'fldDateCreated = ? ,';
    $tblPlansQuery .= 'fldCatalogYear = ? ,';
    $tblPlansQuery .= 'fldPlanCredits = 0';
    $thisDatabaseWriter->insert($tblPlansQuery, $tblPlansInfo);
}
?>
<!--Start form--> 
<form method = "get" action = "index.php">
    <fieldset id = "planForm">
        <legend >Four Year Plan</legend>
        <label>Student Net Id
            <input id="studentNetId" maxlength="45" name="studentNetId" onfocus=this.select() type="text" 
                   value="<?php print $studentNetId ?>">
        </label>
        <label>Advisor Net Id
            <input autofocus id="advisorNetId" maxlength="45" name="advisorNetId" onfocus=this.select() type="text" 
                   placeholder= "Enter your netId" 
                   value="<?php print $advisorNetId ?>">
        </label>
        <label>Year you entered UVM
            <input id="yearEntered" maxlength="45" name="yearEntered" onfocus=this.select() type="text" 
                   value="<?php print $yearEntered ?>">
        </label>
        <label>Choose your degree.
            <select name="degree" id ="maxwidth">
                <?php
                #################Degree Query#############################
                $degreeQuery = 'SELECT pmkDegreeId, fldType, fldConcentration, fldCollege FROM tblDegrees';
                $degrees = $thisDatabaseReader->select($degreeQuery, "", 0);
                ####################################################
                if (is_array($degrees)) {
                    print '<option';
                    //get selected to preserve from previous submission
                    if ("" == $degreeSelected) {
                        print ' selected="selected"';
                    }
                    print ' value ="">Choose a Degree</option>';
                    foreach ($degrees as $degree) {
                        $degreeInfo = $degree['fldType'] . " " . $degree['fldConcentration'] . " " . $degree['fldCollege'];
                        print '<option';
                        if ($degree['pmkDegreeId'] == $degreeSelected) {
                            print ' selected="selected"';
                        }
                        print ' value = "';
                        print $degree['pmkDegreeId'];
                        print '">';
                        print $degreeInfo;
                        print '</option>';
                    }
                }
                ?>
                <!--end select-->
            </select>
        </label>
        <label>Choose your catalog year.
            <select name="catalog">
                <?php
                if (is_array($catalogs)) {
                    foreach ($catalogs as $catalog) {
                        print '<option';
                        if ($catalog == $catalogSelected) {
                            print ' selected="selected"';
                        }
                        print ' value = "';
                        print $catalog;
                        print '">';
                        print $catalog;
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
        <input class="button" id="btnSubmit" name="btnSubmit" tabindex="900" type="submit" value="Create Plan" >
    </fieldset>
</form>
<?php
include "footer.php";
?>
