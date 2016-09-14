<?php
include ("top.php");
include ("constants.php");
include ("header.php");
include ("nav.php");?>
<h1>Info for Selected Course</h1><?php
//get the current selection from the list box
$option = $_POST['selector'];
//open the csv file
$file = fopen("curr_enroll_fall.csv", "r");
fgetcsv($file);
//initialize counter
$value1 = 0;
while ($row = fgetcsv($file)) {
//    if user selection is the current row
    if ($option == $value1) {
//        print the data
        print_r($row[0]);
        print SPACE;
        print_r($row[1]);
        print SPACE;
        print_r($row[4]);
        print SPACE;
        print_r($row[2]);
        print SPACE;
        print_r($row[3]);
        print SPACE;
        for ($i = 5; $i < 18; $i++) {
            print_r($row[$i]);
            print SPACE;
        }
    }
    $value1+=1;
}
//close file
fclose($file);
include ("footer.php")
?>
</html>