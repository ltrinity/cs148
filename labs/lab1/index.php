<?php
include ("top.php");
include ("constants.php");
include ("header.php");
include ("nav.php");
?>
<!--title-->
<h1>UVM Fall Semester 2016 Course Search</h1>
<!--Begin form with method post, redirect to results page on submit-->
<form method = "post" action = "results.php">
    <!--begin listbox-->
    <select size="20" name="selector">
        <?php
//            open course csv file
        $file = fopen(CSV_FILE_NAME, "r");
        fgetcsv($file);
//            initialize counter
        $value = 0;
//            while a row still exists
        while ($row = fgetcsv($file)) {
//              set value of each option based on counter
            print '<option value = "';
            print $value;
            print '"';
//              first option is selected automatically
            if ($value == 0) {
                print ' selected="selected"';
            }
            print '>';
//              print course category number and section
            print_r($row[0]);
            print SPACE;
            print_r($row[1]);
            print SPACE;
            print_r($row[4]);
            print '</option>';
//                increment counter
            $value+=1;
        }
//            close file
        fclose($file);
        ?>
    </select>
    <!--submit button-->
    <fieldset class="buttons">
        <legend></legend>
        <input type="submit" id="btnSubmit" name="btnSubmit" value="Get Info" tabindex="900" class="button">
    </fieldset>
</form>
<?php include ("footer.php"); ?>
</body>

</html>