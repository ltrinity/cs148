<?php
//get remote user net id
$currentUser = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
//default plan selected to null
$planSelected = "";
################Plan Query
$getPlansQuery = 'SELECT pmkPlanId, fldDegree, fldCatalogYear ';
$getPlansQuery .= 'FROM tblPlans WHERE fnkStudentNetId = ?';
$planQueryData = array($currentUser);
$plans = $thisDatabaseReader->select($getPlansQuery, $planQueryData, 1);        
########################
//if form is submitted
if (isset($_GET["formSubmit"])) {
    //get the values from the form
    $planSelected = htmlentities($_GET["plans"], ENT_QUOTES, "UTF-8");
}
?>
<form method = "get" action = "add.php">
    <fieldset id = "planForm2">
        <legend>Display Plans</legend>
        <label>Choose your plan.
            <select name="plans">
                <?php
                if (is_array($plans)) {
                    foreach ($plans as $plan) {
                        print '<option';
                        if ($plan['pmkPlanId'] == $planSelected) {
                            print ' selected="selected"';
                        }
                        print ' value = "';
                        print $plan['pmkPlanId'];
                        print '">';
                        print $plan['fldDegree'];
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