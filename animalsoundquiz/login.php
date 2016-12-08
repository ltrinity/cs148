<?php
//initialize database connection
include "top.php";
//include mail message function
include "mailmessage.php";
// define security variable
$yourURL = DOMAIN . PHP_SELF;
//initialize variables
$firstName = "";
$lastName = "";
$email = "";
$favoriteAnimal = "";
$mailed = false;
$messageA = "";
$messageB = "";
$messageC = "";
//create error message boolean variables and array to hold error messages
$emailERROR = false;
$firstNameERROR = false;
$lastNameERROR = false;
$errorMsg = array();
//when a user submits the form to register
if (isset($_GET["register"])) {
    //get the first name
    $firstName = htmlentities($_GET["firstName"], ENT_QUOTES, "UTF-8");
    //get the last name
    $lastName = htmlentities($_GET["lastName"], ENT_QUOTES, "UTF-8");
    //get the email
    $email = htmlentities($_GET["email"], ENT_QUOTES, "UTF-8");
    //get the email
    $favoriteAnimal = htmlentities($_GET["favoriteAnimal"], ENT_QUOTES, "UTF-8");
    //if they do not enter an email
    if(strlen($email)>40){
        $errorMsg[] = "Email address too longs";
        print '<p class = "error">Email address too long</p>';
        $emailERROR = true;
    }
    if(strlen($firstName)>15){
        $errorMsg[] = "First name too long";
        print '<p class = "error">First name too long</p>';
        $firstNameERROR = true;
    }
    if(strlen($lastName)>15){
        $errorMsg[] = "Last name too long";
        print '<p class = "error">Last name too long</p>';
        $lastNameERROR = true;
    }
    if ($email == "") {
        $errorMsg[] = "Please enter your email address";
        print '<p class = "error">Please enter your email address</p>';
        $emailERROR = true;
    }
    //if they do not enter a first name
    if ($firstName == "") {
        $errorMsg[] = "Please enter your first name";
        print '<p class = "error">Please enter your first name</p>';
        $firstNameERROR = true;
    }
    //if they do not enter an email
    if ($lastName == "") {
        $errorMsg[] = "Please enter your last name";
        print '<p class = "error">Please enter your last name</p>';
        $lastNameERROR = true;
    }
    //if there is no error
    if (!$errorMsg) {
        //test if user exists
        $userQuery = 'SELECT pmkUserId FROM tblUsers WHERE fldFirstName LIKE ? AND fldLastName LIKE ? AND fldEmail LIKE ?';
        $userAttributes = array($firstName, $lastName, $email);
        $exists = $thisDatabaseReader->select($userQuery, $userAttributes, 1, 2);
        //if they exist print a link to the existing user login page
        if (!($exists[0][0] == "")) {
            if($favoriteAnimal!=""){
                //we will now update tblUsers if needed for a new favorite animal
                $favAnimalData = array($favoriteAnimal,$exists[0][0]);
                $updateFavoriteAnimalQuery = 'UPDATE tblUsers SET fnkFavoriteAnimalName = ? WHERE pmkUserId = ?';
                $thisDatabaseWriter->update($updateFavoriteAnimalQuery, $favAnimalData, 1);
            }
            header('Location: https://ltrinity.w3.uvm.edu/cs148_develop/animalsoundquiz/quiz.php?firstName=' . $firstName . '&lastName=' . $lastName . '&email=' . $email . '&favoriteAnimal=' . $favoriteAnimal  . '&register=Register'); 
            exit();
            return;
        }
        //default primary key value
        $userPrimaryKey = "";
        //insert the user into the table
        if($favoriteAnimal==""){
            $createUserQuery = 'INSERT INTO tblUsers SET fldEmail = ?, fldFirstName = ?, fldLastName = ?';
        $userAttributes = array($email, $firstName, $lastName);
        $results = $thisDatabaseWriter->insert($createUserQuery, $userAttributes);
        }else{
        $createUserQuery = 'INSERT INTO tblUsers SET fldEmail = ?, fldFirstName = ?, fldLastName = ?, fnkFavoriteAnimalName = ?';
        $userAttributes = array($email, $firstName, $lastName, $favoriteAnimal);
        $results = $thisDatabaseWriter->insert($createUserQuery, $userAttributes);}
        //get their primary key
        $userPrimaryKey = $thisDatabaseWriter->lastInsert();
        // create a key value for confirmation
        $getDateJoinedQuery = "SELECT fldDateJoined FROM tblUsers WHERE pmkUserId = ? ";
        $userId = array($userPrimaryKey);
        $dateArray = $thisDatabaseReader->select($getDateJoinedQuery, $userId);
        $dateSubmitted = $dateArray[0]["fldDateJoined"];
        $key1 = sha1($dateSubmitted);
        $key2 = $userPrimaryKey;
        //generate messages
        $messageA = '<h2>Thank you for registering.</h2>';
        $messageA .= '<p>Please check your mail for instructions.</p>';

        $messageB = "<p>Click this link to confirm your registration: ";
        $messageB .= '<a href="http:' . DOMAIN . $PATH_PARTS["dirname"] . '/confirmationCode.php?q=' . $key1 . '&amp;w=' . $key2 . '">Confirm Registration</a></p>';
        $messageB .= "<p>or copy and paste this url into a web browser: ";
        $messageB .= 'http:' . DOMAIN . $PATH_PARTS["dirname"] . '/confirmationCode.php?q=' . $key1 . '&amp;w=' . $key2 . "</p>";

        $messageC .= "<p><b>Email Address:</b><i>   " . $email . "</i></p>";


        // email the form's information
        $to = $email; // the person who filled out the form
        $cc = "";
        $bcc = "";
        $from = "Animal Sound Quiz<animalsoundquiz@gmail.com>";
        $subject = "Thank you for registering";
        $message = $messageB;
        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);

        // remove click to confirm
        $message = $messageA . $messageC;
        print '<fieldset id= "userRegistered">';
        //inform the user
        print '<p>' . $message . '</p>';
        //begin form that sends user primary key to quiz page
        print '<form method = "post" action="quiz.php">';
        //store the user pmk in a hidden input
        print '<input type="text" name="userPrimaryKey" hidden = "hidden" value="' . $userPrimaryKey . '">';
        //print submit button
        print '<input type="submit" id="quiz" name="quiz" value="Click Here To Login" tabindex="900" class = "button">';
        //end form
        print '</form>';
        print '</fieldset>';
    } 
}print '<fieldset id ="loginForm">';
print '<p class="xlarge">Enter your information below</p>';
//here is the main form to register
print '<form method = "get" action="login.php">';
//user enter their first name, last name, and email
print '<p class="moderate">Enter your first name</p>';
print '<input id="firstName" maxlength="45" name="firstName" onfocus=this.select() placeholder = "William" autofocus type="text" value="' . $firstName . '">';
print '<p class="moderate">Enter your last name</p>';
print '<input id="lastName" maxlength="45" name="lastName" onfocus=this.select() placeholder = "Clark" type="text" value="' . $lastName . '">';
print '<p class="moderate">Enter your email</p>';
print '<input id="email" maxlength="45" name="email" onfocus=this.select() placeholder = "William.Clark@uvm.edu" type="text" value="' . $email . '">';
print '<p class="moderate">Select your favorite animal from the list</p>';
//query to select distinct animal names from tblAnimals
$distinctAnimalQuery = 'SELECT DISTINCT pmkAnimalName FROM tblAnimals';
$animals = $thisDatabaseReader->select($distinctAnimalQuery, "", 0);
print '<select name="favoriteAnimal">';
            if (is_array($animals)) {
                print '<option';
                //get selected to preserve from previous submission
                if ("" == $favoriteAnimal) {
                    print ' selected="selected"';
                }
                print ' value ="">Choose your favorite animal</option>';
                foreach ($animals as $animal) {
                    print '<option';
                    if ($animal[0] == $favoriteAnimal) {
                        print ' selected="selected"';
                    }
                    print ' value = "';
                    print $animal[0];
                    print '">';
                    print $animal[0];
                    print '</option>';
                }
            }
        print '</select>';
        print '<p class="moderate">Click the button to register or login</p>';
//print submit button
print '<input type="submit" id="register" name="register" value="Submit" tabindex="900" class = "button">';
//end the form
print '</form>';
print '</fieldset>';
//include footer
include "footer.php";
?>