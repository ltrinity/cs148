<?php
//initialize database connection
include "top.php";
//create navigation
include "nav.php";
###################################################
// find name in uvm directory      
function ldapName($uvmID) {
    if (empty($uvmID))
        return "no:netid";

    $name = "not:found";

    $ds = ldap_connect("ldap.uvm.edu");

    if ($ds) {
        $r = ldap_bind($ds);
        $dn = "uid=$uvmID,ou=People,dc=uvm,dc=edu";
        $filter = "(|(netid=$uvmID))";
        $findthese = array("sn", "givenname");

        // now do the search and get the results which are stored in $info
        $sr = ldap_search($ds, $dn, $filter, $findthese);

        // if we found a match (in this example we should actually always find just one
        if (ldap_count_entries($ds, $sr) > 0) {
            $info = ldap_get_entries($ds, $sr);
            $name = $info[0]["givenname"][0] . ":" . $info[0]["sn"][0];
        }
    }

    ldap_close($ds);
    return $name;
}

//########################################################
#initialize variables
//get remote user net id
$studentNetId = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
//advisor starts at null
$advisorNetId = '';
//default year entered
$yearEntered = '2015';
//default degree selected
$degreeSelected = "B.S. Accounting GSB";
//open the degree csv file
$file=fopen("Degrees.csv", "r");
//read the first line
fgetcsv($file);
//default catalog selected
$catalogSelected = "2016";
//initialize catalogs array
$catalogs= array();
//fill the catalogs array with years
$k=2016;
for($i = 0;$i<116;$i++){
    $catalogs[$i]=$k;
    $k--;
}
//if form is submitted
if (isset($_GET["btnSubmit"])) {
    //get the values from the form
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
    $tblStudentsInfo=array($studentNetId,$studentFirstName,$studentLastName,$studentEmail,$yearEntered);
    //parse advisor name
    $advisorNameArray = explode(":", ldapName($advisorNetId));
    $advisorFirstName = $advisorNameArray[0];
    $advisorLastName = $advisorNameArray[1];
    //if advisor is not null create advisor email else it is also null
    if($advisorNetId!=""){
    $advisorEmail = $advisorNetId . "@uvm.edu";}
    else{
        $advisorEmail="";
    }
    //store data needed to input into tblAdvisors
    $tblAdvisorsInfo=array($advisorNetId,$advisorFirstName,$advisorLastName,$advisorEmail);
    //get current date
    $dateCreated = date("m-d-Y");
    //store data needed to input into tblPlans
    $tblPlansInfo = array($studentNetId,$advisorNetId,$degreeSelected,$dateCreated,$catalogSelected);
    #####################################################################
    //Queries and Table Insertions
    ####################################################################
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
    $tblPlansQuery .= 'fldDegree = ? ,';
    $tblPlansQuery .= 'fldDateCreated = ? ,';
    $tblPlansQuery .= 'fldCatalogYear = ? ,';
    $tblPlansQuery .= 'fldPlanCredits = 0';
    $thisDatabaseWriter->insert($tblPlansQuery, $tblPlansInfo);
}
?>
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
                while ($degrees = fgetcsv($file)) {
                    $degreeInfo = $degrees[1] . " " . $degrees[2] . " " . $degrees[3];
                    print '<option';
                    if ($degreeInfo == $degreeSelected) {
                        print ' selected="selected"';
                    }
                    print ' value = "';
                    print $degreeInfo;
                    print '">';
                    print $degreeInfo;
                    print '</option>';
                
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
