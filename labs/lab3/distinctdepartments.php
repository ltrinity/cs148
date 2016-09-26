<!--this page will display a listbox of all distinct departments-->
<h2>List Box of Distinct UVM Departments</h2>
<!--begin form which posts to current page-->
<form method = "post" action = "index.php">
    <!--    begin select with name departmentLB-->
    <select name="departmentLB">
        <?php
//select and print all distinct departments in the courses table as an option int the listbox
        $query = 'SELECT DISTINCT fldDepartment FROM tblCourses';
        $records = $thisDatabaseReader->select($query, "", 0, 0, 0, 0, false, false);
        if (is_array($records)) {
            foreach ($records as $record) {
                print "<option>" . $record['fldDepartment'] . "</option>";
            }
        }
        ?>
        <!--end select-->
    </select>
    <!--button code-->
    <fieldset class="buttons">
        <legend></legend>
        <input type="submit" id="deptSelect" name="deptSelect" value="Select Department" tabindex="900" class="button">
    </fieldset>
</form>

