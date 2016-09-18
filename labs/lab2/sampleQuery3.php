<?php

include "top.php";
//##############################################################################
//
// This page lists the records based on the query given. Notice that this query
// passes a value of 1 for the number of conditions though there are none this 
// is a case where its not perfect and the word ORDER counts as having an OR
// condition. Its ok it still makes it hard from someone to break in.
//
//##############################################################################

$query = 'SELECT fldFirstName, fldLastName ';
$query .= 'FROM tblPeople ';
$query .= 'WHERE fldLastName = ? ';
$query .= 'ORDER BY fldFirstName';

$data = array('Jetson');


// lets run this through testquery to see what counts it prints out
$records = $thisDatabaseReader->testquery($query, $data, 1, 1, 0, 0, false, false);

// now lets run it so we can see the results
$records = $thisDatabaseReader->select($query, $data, 1, 1, 0, 0, false, false);

if (DEBUG) {
    print "<p>Contents of the array<pre>";
    print_r($records);
    print "</pre></p>";
}

print '<h2 class="alternateRows">Meet the Jetsons!</h2>';
if (is_array($records)) {
    foreach ($records as $record) {
        print "<p>" . $record['fldFirstName'] . " " . $record['fldLastName'] . "</p>";
    }
}
include "footer.php";
?>