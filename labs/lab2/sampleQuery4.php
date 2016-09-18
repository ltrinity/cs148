<?php
include "top.php";
//##############################################################################
//
// This page lists the records based on the query given. Notice that this query
// passes a value of 0 for the number of conditions though the word ORDER counts
// as having an OR condition. Do you see how testquery shows you this?
//
//##############################################################################

$query = 'SELECT fldFirstName, fldLastName ';
$query .= 'FROM tblPeople ';
$query .= 'WHERE fldLastName = ? ';
$query .= 'ORDER BY fldFirstName';

$data = array('Jetson');

print '<h2>Notice the conditions count fails</h2>';
// lets run this through testquery to see what counts it prints out as they will fail
$records = $thisDatabaseReader->testquery($query, $data, 1, 0, 0, 0, false, false);

if (DEBUG) {
    print "<p>Contents of the array<pre>";
    print_r($records);
    print "</pre></p>";
 }

 print '<h2>Meet the Jetsons!</h2>';
if(is_array($records)){
     foreach($records as $record){
         print "<p>" . $record['fldFirstName'] . " " . $record['fldLastName'] . "</p>";
     }
 }
include "footer.php";
?>