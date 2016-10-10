<?php

//##############################################################################
/* This page grabs data from the UVM web site and populates your Course table.
 * 
 * Written By: Robert Erickson robert.erickson@uvm.edu
 * Last updated on: October 2, 2016
 * 
 */

// Pass in the term you are interested 1 (spring), 6 (summer), 9 (fall)
// code will load the apporaiate csv from the registrars page. You do not need
//  to download the csv file yourself.
// 
// 
// For course add if it does not exist, keep in mind some courses have a lab
// to go with the same title like BCOR 11 Lec nad BCOR 11 Lab 
// Look for course department, number, type and title to see if they are in the
// table, if not add them
// 
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
$coursesAdded = 0;
$coursesProcessed = 0;
$outputBuffer[] = "";
$coursesSQL[] = "";


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
$query = "CREATE TABLE IF NOT EXISTS tblCourses ( ";
$query .= "pmkCourseId int(11) NOT NULL AUTO_INCREMENT, ";
$query .= "fldDepartment varchar(5) NULL, ";
$query .= "fldCourseNumber int(11) NULL, ";
$query .= "fldCourseTitle varchar(250) NULL, ";
$query .= "fldCredits varchar(10) NULL DEFAULT '3',";
$query .= "PRIMARY KEY (pmkCourseId)";
$query .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8";
$results = $thisDatabaseAdmin->insert($query, "", 0, 2, 2);

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
        $coursesProcessed++;
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
// process course, check if it exists and if it does get pmk, if not insert 
// and get pmk unless you insert the records it wont work this just lets you
// see it not working as its a new course and needs to be inserted 
        $fnkCourseId = " NEW COURSE ";

        $query = "SELECT pmkCourseId FROM tblCourses ";
        $query .= "WHERE fldDepartment = ? ";
        $query .= "AND fldCourseNumber = ? ";
        $query .= "AND fldCourseTitle = ? ";
        $query .= "AND fldCredits = ?";
        $data = array($record[$fldDepartment]);
        $data[] = $record[$fldCourseNumber];
        $data[] = $record[$fldCourseTitle];
        $data[] = $record[$fldCredits];

        $dataText = " VALUES ('";
        $dataText .= $record[$fldDepartment] . "', ";
        $dataText .= $record[$fldCourseNumber] . ",'";
        $dataText .= $record[$fldCourseTitle] . "','";
        $dataText .= $record[$fldCredits] . "')";

        $course = $thisDatabaseReader->select($query, $data, 1, 3, 0, 0, false, false);
        if (DEBUG) {
            print "<p>course: <pre>";
            print_r($course);
            print"</pre>";
        }
        if (count($course) > 0) {
            if ($course[0]["pmkCourseId"] > 0) {
                $fnkCourseId = $course[0]["pmkCourseId"];
            }
        } else {
            $query = "INSERT INTO tblCourses(fldDepartment, fldCourseNumber, fldCourseTitle, fldCredits) ";

            $coursesSQL[] = $query . $dataText;

            $query .= "VALUES (?, ?, ?, ?)";

            if (!$displayOnly) {
                $results = $thisDatabaseAdmin->insert($query, $data, 0, 0, 0, 0, false, false);

                // i dont use the foreign key in the code but this is how i would get it.
                $fnkCourseId = $thisDatabaseAdmin->lastInsert();
                $coursesAdded++;
            } else {
                $results = $thisDatabaseAdmin->testquery($query, $data, 0, 0, 0, 0, false, false);
            }
        } // end insert of new course
    } // end reading file
// ---------------------------------------------------------------------
// display output
//
    $outputBuffer[] = "</table>";

    print "<h2>Course SQL</h2>";
    print "<p>Total Courses added: " . $coursesAdded . " (many courses are already in the table)</p>";
    print "<p>Total Courses processed : " . $coursesProcessed . "</p>";
    print "<p>Started: " . $time1->format("Y-m-d H:i:s");
    $time3 = new DateTime("now");
    print "<p>Completed: " . $time3->format("Y-m-d H:i:s");


    $coursesSQL = join("<p>\n", $coursesSQL);
    echo $coursesSQL;
    if ($coursesSQL[0] == "") {
        print "<p>No courses added as they were already in the system</p>";
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