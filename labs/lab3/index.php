<?php
//inlude top which sets up the database and queries
include 'top.php';
//get the submitted dept value and store in $dept default % to get all classes before dept is set
$deptSelected = htmlentities(isset($_GET['departmentLB']) ? $_GET['departmentLB'] : '%', ENT_QUOTES, "UTF-8");
//get the submitted class value and store in $class default % to get all classes in dept before classes is set
$classSelected = htmlentities(isset($_GET['classbydeptLB']) ? $_GET['classbydeptLB'] : '%', ENT_QUOTES, "UTF-8");
//begin the form
print '<form method = "get" action = "index.php" id="inlineform">';
//listbox of distinct departments
include 'distinctdepartments.php';
//listbox of classes by department
include 'classesbydepartment.php';
//end the form
print '</form>';
//display information of selected classes and footer
include 'classinformation.php';
include 'footer.php';
?>