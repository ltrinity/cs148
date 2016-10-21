<!--this page will display a listbox of all distinct departments-->
<!--    begin select with name departmentLB-->
<select name="departmentLB">
    <?php
//select and print all distinct departments in the courses table as an option int the listbox
    $distinctDepartmentQuery = 'SELECT DISTINCT fldDepartment FROM tblCourses';
    $distinctDepartments = $thisDatabaseReader->select($distinctDepartmentQuery, "", 0, 0, 0, 0, false, false);
    if (is_array($distinctDepartments)) {
        foreach ($distinctDepartments as $department) {
            print '<option';
            //get selected to preserve from previous submission
            if ($department['fldDepartment'] == $deptSelected) {
                print ' selected="selected"';
            }
            print '>' . $department['fldDepartment'] . '</option>';
        }
    }
    ?>
    <!--end select-->
</select>