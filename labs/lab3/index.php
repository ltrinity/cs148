<?php
include "top.php";
include "distinctdepartments.php";
//get the submitted dept value and store in $dept
$dept = isset($_POST['departmentLB']) ? $_POST['departmentLB'] : '%';
include "classesbydepartment.php";
//get the submitted class value and store in $class
$class = isset($_POST['classbydeptLB']) ? $_POST['classbydeptLB'] : '';
include "classinformation.php";
?>

<?php
include "footer.php";
?>