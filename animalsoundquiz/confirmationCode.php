<?php
/* the purpose of this page is to accept the hashed date joined and primary key  
 * as passed into this page in the GET format.
 * 
 * I retreive the date joined from the table for this person and verify that 
 * they are the same. After which i update the confirmed field and acknowledge 
 * to the user they were successful. Then i send an email to the system admin 
 * to approve their membership 
 * 
 * Written By: Robert Erickson robert.erickson@uvm.edu
 * Last updated on: Nov 25, 2016
 * 
 * 
 */

include "top.php";
include "mailmessage.php";
print '<article id="main">';

print '<h1>Registration Confirmation</h1>';

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1 Initialize variables
//
// SECTION: 1a.
// variables for the classroom purposes to help find errors.
if (DEBUG)
    print "<p>DEBUG MODE IS ON</p>";
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%

$UserMessage = '';
$AdminMessage = '';

//##############################################################
//
// SECTION: 2 
// 
// process request

if (isset($_GET["q"])) {
    $keyDate = htmlentities($_GET["q"], ENT_QUOTES, "UTF-8");
    $keyId = htmlentities($_GET["w"], ENT_QUOTES, "UTF-8");

    
    
    //##############################################################
    // get the membership record 

    $query = "SELECT fldDateJoined, fldEmail FROM tblUsers WHERE pmkUserId = ? ";
    $data = array($keyId);
    $results = $thisDatabaseReader->select($query, $data, 1);

    $dateSubmitted = $results[0]["fldDateJoined"];
    $email = $results[0]["fldEmail"];
    $DateInTable = sha1($dateSubmitted);
    
    //##############################################################
    // update confirmed
    if ($keyDate == $DateInTable) {
        
        $query = "UPDATE tblUsers SET fldConfirmed = 1 WHERE pmkUserId = ?";
        $results = $thisDatabaseWriter->update($query, $data,1);
        
        //##############################################################
        // notify admin
        
        if (!$results) {
            $AdminMessage .= '<h1>Confirmed failed: Look at Registration Id: ' . $keyId . '</h1>';
        }
        
        $AdminMessage .= '<h2>The following Registration has been confirmed:</h2>';

        $AdminMessage = "<p>Click this link to approve this registration: ";
        $AdminMessage .= '<a href="http:' . DOMAIN . $PATH_PARTS["dirname"] . '/approve.php?q=' . $keyId . '">Approve Registration</a></p>';
        $AdminMessage .= "<p>or copy and paste this url into a web browser: ";
        $AdminMessage .= 'http:' . DOMAIN . $PATH_PARTS["dirname"] . '/approve.php?q=' . $keyId . "</p>";

        $to = "ltrinity@uvm.edu";
        $cc = "";
        $bcc = "";
        $from = "Animal Sound Quiz<animalsoundquiz@gmail.com>";
        $subject = "New Animal Sound Quiz Registration Confirmed: Approve?";

        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $AdminMessage);
        
        //##############################################################
        // notify user
        if ($results) {
            $to = $email;
            $cc = "";
            $bcc = "";
            $from = "Animal Sound Quiz <animalsoundquiz@gmail.com>";
            $subject = "Animal Sound Quiz Registration Confirmed";
            $UserMessage = "<p>Thank you for taking the time to confirm your registration. </p>";

            $mailed = sendMail($to, $cc, $bcc, $from, $subject, $UserMessage);

        } else {
            // update failed
            $UserMessage = "<p>I am sorry but this project cannot be confirmed at this time. Please contact ltrinity@uvm.edu for help in resolving this matter.</p>";
        }
    } else {
        $UserMessage = "<p>I am sorry but this project cannot be confirmed at this time. Please contact ltrinity@uvm.edu for help in resolving this matter.</p>";
    } // keys equal
} // ends isset get q

//##############################################################
//
// SECTION: 3 
// 
// inform user

print $UserMessage;

include "footer.php";

?>
</article>
</body>
</html>