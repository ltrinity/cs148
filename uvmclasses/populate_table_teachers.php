<?php

//##############################################################################
/* This page grabs data from the UVM web site and populates your Teachers table.
 * 
 * Written By: Robert Erickson robert.erickson@uvm.edu
 * Last updated on: October 2, 2016
 * 
 */

// Pass in the term you are interested 1 (spring), 6 (summer), 9 (fall)
// code will load the apporaiate csv from the registrars page. You do not need
//  to download the csv file yourself.
// 
// For teachers just add them to tbl teachers ignore on duplicate since the
// teacher is already there based on net it. However this will not update a 
// a teachers information
// 
// The option ($displayOnly) will just display the sql and not enter any 
// information into the table.
// 
// 
//##############################################################################
include "top.php";

// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// 
//
//-----------------------------------------------------------------------------
// 
// Initialize variables
// Set code to displayOnly, INSERT SQL statements will NOT be executed
$displayOnly = false;


$time1 = new DateTime("now");
$teachersProcessed = 0;
$outputBuffer[] = "";
$teachersSQL[] = "";


// put records into database tables
// Set column numbers based on the header
// if room is epmpty?
/*
  [0] => Subj
  [1] => #
  [2] => Title
  [3] => Comp Numb
  [4] => Sec
  [5] => Inst Mthd
  [6] => Cmp Cde
  [7] => Max Enr
  [8] => Cur Enr
  [9] => Start Time
  [10] => End Time
  [11] => Days
  [12] => Credits
  [13] => Bldg
  [14] => Room
  [15] => Instructor
  [16] => NetId
  [17] => Email

  /* Subj            ANFS
 * #               491   
 * Title           Doctoral Dissertation                        
 * Comp Numb       90017
 * Sec             A
 * Inst Mthd       TD
 * Cmp Cde         M
 * Max Enr         20
 * Cur Enr         1
 * Remain Seats    19
 * Start Time      TBA
 * End Time                       
 * Days    
 * Credits         1 to 18
 * Bldg    
 * Room       
 * Instructor      Harvey, Jean Ruth          
 * NetId           jharvey
 * Email           Jean.Harvey@uvm.edu                            
 * X-Listing Group
 */


// initialize variables to zero in case it is not in the array, this corresponds to their column number in the array
$fldDepartment = 0;
$fldCourseNumber = 0;
$fldCourseTitle = 0;

$fldComputerNumber = 0;
$fldSection = 0;
$fldLectureLab = 0;

$fldCmpCde = 0;
$fldMaxStudents = 0;
$fldCurrStudents = 0;
$fldRemainingSeats = 0;
$fldStart = 0;
$fldDays = 0;
$fldCredits = 0;
$fldBuilding = 0;
$fldRoom = 0;

$fldInstructor = 0;
$fnkTeacherNetId = 0;
$fldEmail = 0;

// forign key values
$fnkCourseId = 0;
$fnkNetId = "";


// get month and set term based on date, may fall is available, nov spring is available. allow user to pass in term (1, 6, 9)
$term = 0;

if (isset($_GET["term"])) {
    $term = (int) $_GET["term"];
} else {

    $month = date("m");
    switch ($month) {
        case 1:
        case 2:
            $term = 1;
            break;
        case 3:
        case 4:
        case 5:
        case 6:
            $term = 6;
            break;
        case 7:
        case 8:
        case 9:
        case 10:
            $term = 9;
            break;
        case 11:
        case 12:
            $term = 1;
            break;
        default:
            $term = 9;
    }
}

//choose which semester data you want to scrape
switch ($term) {
    case 1:
        $url = "http://giraffe.uvm.edu/~rgweb/batch/curr_enroll_spring.csv";
        break;
    case 6:
        $url = "http://giraffe.uvm.edu/~rgweb/batch/curr_enroll_summer.csv";
    case 9:
        $url = "http://giraffe.uvm.edu/~rgweb/batch/curr_enroll_fall.csv";
        break;
}


// -- Table structure for table `tblCourses`
$query = "CREATE TABLE IF NOT EXISTS tblTeachers ( ";
$query .= "pmkNetId varchar(12) NOT NULL, ";
$query .= "fldLastName varchar(100) NOT NULL, ";
$query .= "fldFirstName varchar(100) NOT NULL, ";
$query .= "fldEmail varchar(100) NOT NULL, ";
$query .= "PRIMARY KEY (pmkNetId)";
$query .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8";
$results = $thisDatabaseAdmin->insert($query, "", 0, 5);

print "<p>SQL: </p><pre style='max-width:100%; white-space: pre-wrap;'>" . $query . "</pre>";

// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// 
// Process CSV file
// 
//-----------------------------------------------------------------------------
// the variable $url will be empty or false if the file does not open

$file = fopen($url, "r");

if ($file) {
    if (DEBUG)
        print "<p>File Opened. Begin reading data into an array.</p>\n";

//prepare the output
    $outputBuffer[] = "<h1>Courses from: " . $url . "</h1>";
    $outputBuffer[] = "<p>Showing all courses</p>";
    $outputBuffer[] = "<table class='csvData'>";
    $outputBuffer[] = "\t<tr>";


    /* This reads the first row which in our case is the column headers:
     * Subj # Title Comp Numb Sec Lec Lab Camp Code
     * Max Enrollment Current Enrollment Start Time End Time
     * Days Credits Bldg Room Instructor NetId Email
     */
    $headers = fgetcsv($file);
    if (DEBUG) {
        print "<p>Finished reading. File closed.</p>\n";
        print "<p>Contents of my array<p><pre> ";
        print_r($headers);
        print "</pre></p>";
    }

// should count headers as sometimes they are missing 2 which changes the structure

    foreach ($headers as $key => $value) {
        $outputBuffer[] = "\t\t<th>" . $value . "</th>";

        switch ($value) {
            case " Subj":
                $fldDepartment = $key;
                break;
            case "#":
                $fldCourseNumber = $key;
                break;
            case "Title":
                $fldCourseTitle = $key;
                break;
            case "Comp Numb":
                $fldComputerNumber = $key;
                break;
            case "Sec":
                $fldSection = $key;
                break;
            case "Inst Mthd":
                $fldLectureLab = $key;
                break;
            case "Cmp Cde":
                $fldCmpCde = $key;
                break;
            case "Max Enr":
                $fldMaxStudents = $key;
                break;
            case "Cur Enr":
                $fldNumStudents = $key;
                break;
            case "Start Time":
                $fldStart = $key;
                break;
            case "End Time":
                $fldStop = $key;
                break;
            case "Days":
                $fldDays = $key;
                break;
            case "Credits":
                $fldCredits = $key;
                break;
            case "Bldg":
                $fldBuilding = $key;
                break;
            case "Room":
                $fldRoom = $key;
                break;
            case "Instructor":
                $fldInstructor = $key; // gets broken into first and last name later
                break;
            case "NetId":
                $fnkTeacherNetId = $key;
                break;
            case "Email":
                $fldEmail = $key;
                break;
        }
    } // end looping through headers


    $outputBuffer[] = "\n\n\t</tr>";
    /* the while loop keeps exectuing until we reach the end of the file at
     * which point it stops. the resulting variable $records is an array with
     * all our data.
     */
    while (!feof($file)) {
        $teachersProcessed++;
        $record = fgetcsv($file);

        if (DEBUG) {
            print "<p>ROW: <pre>";
            print_r($record);
            print "</pre>";
        }

        $outputBuffer[] = "\n\n\t<tr>";
        foreach ($record as $key => $value) {
            $outputBuffer[] = "\t\t<td>" . $value . "</td>";
        }
        $outputBuffer[] = "\n\n\t</tr>";

// -------------------------------------------------------------------------
// process teacher table just insert them ignoring if they exist. i have them
// in a different order to explode the name which works this way. not sure if
// it would work if i put net id in first
        //skipping  staff and strange records
        if ($record[$fnkTeacherNetId] != "staff" AND $record[$fnkTeacherNetId] != "") {
            $query = "INSERT IGNORE INTO tblTeachers(fldLastName, fldFirstName, pmkNetId, fldEmail) ";
            $name = explode(', ', $record[$fldInstructor]); // name
            $first = "";

            $data = array();
            // normally names are last, first bumt there are exceptions so i try to deal with them.
            if (count($name) > 2) {
                $data[] = $name[0] . " " . $name[1];
                // more than first and last name Williams, Jr, Robert C.
                for ($i = 2; $i <= count($name) - 1; $i++) {
                    $first .= $name[$i];
                }
            } else {
                $data[] = $name[0];
                $first = $name[1];
            }
            $data[] = $first;
            $data[] = $record[$fnkTeacherNetId]; // net id
            $data[] = $record[$fldEmail]; // email
            $dataText = " VALUES ('" . $data[0] . "','" . $data[1] . "','" . $data[2] . "','" . $data[3] . "')";

            $teachersSQL[] = $query . $dataText;

            $query .= "VALUES (?, ?, ?, ?)";

            if (!$displayOnly) {
                $results = $thisDatabaseAdmin->insert($query, $data, 0, 0, 0, 0, false, false);
        
            } else {
                $results = $thisDatabaseAdmin->testquery($query, $data, 0, 0, 0, 0, false, false);
            }
        } // end staff record
    } // end reading file
    

// add a staff record
$query = "INSERT IGNORE INTO tblTeachers(fldLastName, fldFirstName, pmkNetId, fldEmail)  VALUES ('staff','Staff','TBD','staff@noreply.uvm.edu')";
$results = $thisDatabaseAdmin->insert($query, "", 0, 0, 8, 0, false, false);
// ---------------------------------------------------------------------
// display output
//
    $outputBuffer[] = "</table>";

    print "<h2>Teachers SQL</h2>";
    print "<p>Total Teachers processed (not all added): " . $teachersProcessed . "</p>";
    print "<p>Started: " . $time1->format("Y-m-d H:i:s");
    $time3 = new DateTime("now");
    print "<p>Completed: " . $time3->format("Y-m-d H:i:s");


    $teachersSQL = join("<p>\n", $teachersSQL);
    echo $teachersSQL;
    if ($teachersSQL[0] == "") {
        print "<p>No teachers added as they were already in the system</p>";
    }
    
    print "<h2>CSV Data processed</h2>";
    $outputBuffer = join("\n", $outputBuffer);
    echo $outputBuffer;

//closes the file
    fclose($file);
} else {

    if (DEBUG)
        print "<p>File Opened Failed.</p>\n";
    die();
} // ends file opened
?>