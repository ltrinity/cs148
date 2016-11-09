<?php
//inlude top which sets up the database and queries
include 'top.php';
//include navigation
include "nav.php";
#############initialize variables###########################################
//get remote user net id
$currentUser = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
//default plan selected to null
$planSelected = "";
$deptSelected = "";
$classSelected = "";
$termSelected = "";
$termYearSelected = "";
$requirement = "";
################Plan Query##############################
$getPlansQuery = 'SELECT pmkPlanId, fldType, fldConcentration, fldCollege, fldCatalogYear ';
$getPlansQuery .= 'FROM tblPlans JOIN tblDegrees ON pmkDegreeId = fnkDegreeId WHERE fnkStudentNetId = ?';
$planQueryData = array($currentUser);
$plans = $thisDatabaseReader->select($getPlansQuery, $planQueryData, 1);
################################################################
//if form is submitted
if (isset($_GET["filter"])) {
//get the values from the form
    $planSelected = htmlentities($_GET["plans"], ENT_QUOTES, "UTF-8");
    //get the submitted dept value and store in $dept default % to get all classes before dept is set
    $deptSelected = htmlentities($_GET['departmentLB'], ENT_QUOTES, "UTF-8");
    //get the submitted class value and store in $class default % to get all classes in dept before classes is set
    $classSelected = htmlentities($_GET['classbydeptLB'], ENT_QUOTES, "UTF-8");
    $termSelected = htmlentities($_GET['termLB'], ENT_QUOTES, "UTF-8");
    $termYearSelected = htmlentities($_GET['termYearLB'], ENT_QUOTES, "UTF-8");
    $requirement = htmlentities($_GET['requirementLB'], ENT_QUOTES, "UTF-8");
}
if (isset($_GET["formSubmit"])) {
    //get the values from the form
    $planSelected = htmlentities($_GET["plans"], ENT_QUOTES, "UTF-8");
    //get the submitted dept value and store in $dept default % to get all classes before dept is set
    $deptSelected = htmlentities($_GET['departmentLB'], ENT_QUOTES, "UTF-8");
    //get the submitted class value and store in $class default % to get all classes in dept before classes is set
    $classSelected = htmlentities($_GET['classbydeptLB'], ENT_QUOTES, "UTF-8");
    $termSelected = htmlentities($_GET['termLB'], ENT_QUOTES, "UTF-8");
    $termYearSelected = htmlentities($_GET['termYearLB'], ENT_QUOTES, "UTF-8");
    $requirement = htmlentities($_GET['requirementLB'], ENT_QUOTES, "UTF-8");
###################Depending on what form values have been changed##################################################
    #semester write is true if they choose a plan, term, and term year
    if ($planSelected != "" && $termSelected != "" && $termYearSelected != "") {
        $semesterWrite = true;
    }
    #allow to write to tblSemesters if these value are set
    if ($semesterWrite) {
        $tblSemestersInfo = array($planSelected, $termSelected, $termYearSelected);
        $tblSemestersQuery = 'INSERT INTO tblSemesters SET ';
        $tblSemestersQuery .= 'fnkPlanId = ? ,';
        $tblSemestersQuery .= 'fldTerm = ? ,';
        $tblSemestersQuery .= 'fldTermYear = ? ,';
        $tblSemestersQuery .= 'fldSemesterCredits = 0';
        $thisDatabaseWriter->insert($tblSemestersQuery, $tblSemestersInfo);
    }
    #allow write to tblSemestersCourses if they pick a class
    if ($semesterWrite && $classSelected != "") {
        $tblSemestersCoursesInfo = array($planSelected, $termSelected, $termYearSelected, $requirement, $classSelected);
        $tblSemestersCoursesQuery = 'INSERT INTO tblSemestersCourses SET ';
        $tblSemestersCoursesQuery .= 'fnkPlanId = ? ,';
        $tblSemestersCoursesQuery .= 'fnkTerm = ? ,';
        $tblSemestersCoursesQuery .= 'fnkTermYear = ? ,';
        $tblSemestersCoursesQuery .= 'fldRequirement = ?,';
        $tblSemestersCoursesQuery .= 'fnkCourseId = ?';
        $thisDatabaseWriter->insert($tblSemestersCoursesQuery, $tblSemestersCoursesInfo);
        $classSelected="";
        $requirement="";
        print '<h3> You just added a course to your plan </h3>';
    }


}
?>
<!--begin form-->
<form method = "get" action = "chooseCourse.php" id="inlineform">
    <fieldset id = "planForm2">
        <legend>Choose a plan to edit</legend>
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
    </fieldset>
    <fieldset class="buttons">
        <legend></legend>
    </fieldset>
    <!--this page will display a listbox of all distinct departments-->
    <!--    begin select with name departmentLB-->
    <fieldset class="PlanForm">
    <legend>Filter courses by department</legend>
    <select name="departmentLB">
        <?php
//select and print all distinct departments in the courses table as an option int the listbox
        $distinctDepartmentQuery = 'SELECT DISTINCT fldDepartment FROM tblCourses';
        $distinctDepartments = $thisDatabaseReader->select($distinctDepartmentQuery, "", 0, 0, 0, 0, false, false);
        if (is_array($distinctDepartments)) {
            print '<option';
            //get selected to preserve from previous submission
            if ("" == $deptSelected) {
                print ' selected="selected"';
            }
            print ' value ="">Choose a Department</option>';
            foreach ($distinctDepartments as $department) {
                print '<option';
                //get selected to preserve from previous submission
                if ($department['fldDepartment'] == $deptSelected) {
                    print ' selected="selected"';
                }
                print ' value = "';
                print $department['fldDepartment'];
                print '">' . $department['fldDepartment'] . '</option>';
            }
        }
        ?>
        <!--end select-->
    </select>
    <select name="classbydeptLB">
        <?php
        if ($deptSelected == "") {
            $classByDept = 'SELECT fldDepartment, fldCourseNumber, fldCourseTitle, pmkCourseID FROM tblCourses';
            $classes = $thisDatabaseReader->select($classByDept, "", 0, 0, 0, 0, false, false);
        } else {
//put the selected department in an array to pass into the query
            $inputForClassListbox = array($deptSelected);
            //initialize SQL query
            $classByDept = 'SELECT fldDepartment, fldCourseNumber, fldCourseTitle, pmkCourseID '
                    . 'FROM tblCourses WHERE fldDepartment LIKE ?';
            $classes = $thisDatabaseReader->select($classByDept, $inputForClassListbox, 1, 0, 0, 0, false, false);
        }
        if (is_array($classes)) {
            print '<option';
            //get selected to preserve from previous submission
            if ("" == $classSelected) {
                print ' selected="selected"';
            }
            print ' value ="">Choose a Class</option>';
            foreach ($classes as $class) {
                print '<option value = "' . $class['pmkCourseID'] . '"';
                //get selected to preserve from previous submission
                if ($class['pmkCourseID'] == $classSelected) {
                    print ' selected="selected"';
                }
                print '>' . $class['fldDepartment'] . ' ' . $class['fldCourseNumber'] .
                        ' ' . $class['fldCourseTitle'] . '</option>';
            }
        }
        ?>
        <!--end select-->
    </select>
    <fieldset class="buttons">
        <legend></legend>
        <input type="submit" id="filter" name="filter" value="Filter" tabindex="900" class="button">
    </fieldset>
    </fieldset>
    <fieldset class="PlanForm">
    <legend>Select a year and semester</legend>
    <select name="termYearLB">
        <?php
        print '<option';
        //get selected to preserve from previous submission
        if ("" == $termYearSelected) {
            print ' selected="selected"';
        }
        print ' value ="">Choose a Term Year</option>';
        for ($i = 1; $i < 5; $i++) {
            print '<option value = "' . $i . '"';
            //get selected to preserve from previous submission
            if ($i == $termYearSelected) {
                print ' selected="selected"';
            }
            print '>Year ' . $i . '</option>';
        }
        ?>
        <!--end select-->
    </select>
    <select name="termLB">
        <?php
        print '<option';
        //get selected to preserve from previous submission
        if ("" == $termSelected) {
            print ' selected="selected"';
        }
        print ' value ="">Choose a Term</option>';
        print '<option value = "Fall"';
        //get selected to preserve from previous submission
        if ("Fall" == $termSelected) {
            print ' selected="selected"';
        }
        print '>Fall</option>';
        print '<option value = "Spring"';
        //get selected to preserve from previous submission
        if ("Spring" == $termSelected) {
            print ' selected="selected"';
        }
        print '>Spring</option>';
        print '<option value = "Summer"';
        //get selected to preserve from previous submission
        if ("Summer" == $termSelected) {
            print ' selected="selected"';
        }
        print '>Summer</option>';
        ?>
        <!--end select-->
    </select>
    </fieldset>
    <fieldset class="PlanForm">
    <legend>What requirement does this course fulfill?</legend>
    <select name="requirementLB">
        <?php
        print '<option';
        //get selected to preserve from previous submission
        if ("" == $requirement) {
            print ' selected="selected"';
        }
        print ' value ="">Choose a requirement type</option>';
        print '<option value = "Major"';
        //get selected to preserve from previous submission
        if ("Major" == $requirement) {
            print ' selected="selected"';
        }
        print '>Major</option>';
        print '<option value = "Minor"';
        //get selected to preserve from previous submission
        if ("Minor" == $requirement) {
            print ' selected="selected"';
        }
        print '>Minor</option>';
        print '<option value = "Elective"';
        //get selected to preserve from previous submission
        if ("Elective" == $requirement) {
            print ' selected="selected"';
        }
        print '>Elective</option>';
        ?>
        <!--end select-->
    </select>
    </fieldset>
    <!--submit button code-->
    <fieldset class="buttons">
        <legend></legend>
        <input type="submit" id="formSubmit" name="formSubmit" value="Add Course" tabindex="900" class="button">
    </fieldset>
    <?php
    print '</form>';
    include 'footer.php';
    ?>