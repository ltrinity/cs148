<?php
$getCurrentInfoQuery = 'SELECT fldDegree, fldDateCreated, fldCatalogYear, fnkStudentNetId, fnkAdvisorNetId ';
$getCurrentInfoQuery .= 'FROM tblPlans WHERE pmkPlanId = ?';
$getInfoData = array($planSelected);
if($planSelected != ""){
    $currentInformation = $thisDatabaseReader->select($getCurrentInfoQuery, $getInfoData, 1);
}
if(is_array($currentInformation)){
    $oneRow = $currentInformation[0];
    print '<h3>Current Plan Information</h3>';
    print '<p>Degree: ' . $oneRow['fldDegree'] . '</p>';
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
    print '<p>Student Name: ' . $sFirstName . " " . $sLastName . '</p>';
    print '<p>Student Email: ' . $sEmail . '</p>';
        //if advisor is not null create advisor email else it is also null
    if($oneRow['fnkAdvisorNetId']!=""){
    $aEmail = $oneRow['fnkAdvisorNetId'] . "@uvm.edu";
    print '<p>Advisor Name: ' . $aFirstName . " " . $aLastName . '</p>';
print '<p>Advisor Email: ' . $aEmail . '</p>';}
}


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
?>