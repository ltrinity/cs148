<?php
//initialize database connection
include "top.php";
include "nav.php";
//########################################################
print '<form method = "get" action = "index.php">';
#initialize variables
$studentNetId = 'ltrinity';
$advisorNetId = '';
$yearEntered = '2015';
$degree = '';
$plans=array("BS CS 2015","BS CSIS 2015","BA CS 2015","BS CAS 2015");
$planSelected ="BS CS 2015";
$dataRecord = array();

if (isset($_GET["btnSubmit"])) {
    $studentNetId = htmlentities($_GET["studentNetId"], ENT_QUOTES, "UTF-8");
    $advisorNetId = htmlentities($_GET["advisorNetId"], ENT_QUOTES, "UTF-8");
    $yearEntered = htmlentities($_GET["yearEntered"], ENT_QUOTES, "UTF-8");
    $planSelected = htmlentities($_GET["plans"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $plan;
    $dataRecord[] = $studentNetId;
    $dataRecord[] = $advisorNetId;
    $dataRecord[] = $yearEntered;
}
?>
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
    <label>Choose Plan for your degree.
        <select name="plans">
            <?php
            if (is_array($plans)) {
                foreach ($plans as $plan) {
                    print '<option';
                    if ($plan == $planSelected) {
                        print ' selected="selected"';
                    }
                    print '>';
                    print $plan;
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
