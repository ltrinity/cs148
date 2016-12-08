<?php

include "top.php";
////include mail message function
include "mailmessage.php";
//error from existing user page if they dont exist
$existsError = false;
$firstNameERROR = false;
$lastNameERROR = false;
$firstName="";
$lastName="";
$favoriteAnimal="";
$animalError=false;
$errorMsg = array();
//if the form is submitted on the new user page post the value
if (isset($_POST["quiz"])) {
    //get the user id for a new user
    $userPrimaryKey = htmlentities($_POST["userPrimaryKey"], ENT_QUOTES, "UTF-8");
    //we are going to display the information available about the current user
    $userAttributesQuery = 'SELECT fldFirstName,fldLastName,fnkFavoriteAnimalName FROM tblUsers WHERE pmkUserId = ?';
//store the primary key in an array
    $pmkArray = array($userPrimaryKey);
    $userAttributes = $thisDatabaseReader->select($userAttributesQuery, $pmkArray, 1);
}
//if a user ended a quiz
if (isset($_POST["endquiz"])) {
    //get the user id for a new user
    $userPrimaryKey = htmlentities($_POST["userPrimaryKey"], ENT_QUOTES, "UTF-8");
}

//if the form is submitted on the existing user page get the pmk
if (isset($_GET["register"])) {
    //get the first name
    $firstName = htmlentities($_GET["firstName"], ENT_QUOTES, "UTF-8");
    //get the last name
    $lastName = htmlentities($_GET["lastName"], ENT_QUOTES, "UTF-8");
    //get the email
    $email = htmlentities($_GET["email"], ENT_QUOTES, "UTF-8");
    //get the primary key of this user
    $getuserIdQuery = 'SELECT pmkUserId from tblUsers WHERE fldFirstName = ? AND fldLastName = ? AND fldEmail = ?';
    $userAttributes = array($firstName, $lastName, $email);
    $pmkUserId = $thisDatabaseReader->select($getuserIdQuery, $userAttributes, 1, 2);
    $userPrimaryKey = $pmkUserId[0][0];
    if ($userPrimaryKey == "") {
        $existsError = true;
        print '<p><a href="login.php">An error occurred, click here to return.</a></p>';
    }
}
//if the user updates their information
if (isset($_POST["update"])) {
    //get the first name
    $firstName = htmlentities($_POST["firstName"], ENT_QUOTES, "UTF-8");
    //get the last name
    $lastName = htmlentities($_POST["lastName"], ENT_QUOTES, "UTF-8");
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
    //get the primary key of this user
    //get the email
    $favoriteAnimal = htmlentities($_POST["favoriteAnimal"], ENT_QUOTES, "UTF-8");
    if ($favoriteAnimal == "") {
        $errorMsg[] = "Please enter your favorite animal";
        print '<p class = "error">Please enter your favorite animal</p>';
        $animalError = true;
    }
    $userPrimaryKey = htmlentities($_POST["userPrimaryKey"], ENT_QUOTES, "UTF-8");
           if (!$errorMsg) {
    //we will now update tblUsers if needed for a new favorite animal
    $favAnimalData = array($favoriteAnimal,$firstName,$lastName, $userPrimaryKey);
    $updateFavoriteAnimalQuery = 'UPDATE tblUsers SET fnkFavoriteAnimalName = ?,fldFirstName = ?, fldLastName = ? WHERE pmkUserId = ?';
           $thisDatabaseWriter->update($updateFavoriteAnimalQuery, $favAnimalData, 1);}
}
if (!$existsError) {
//we are going to display the information available about the current user
    $userAttributesQuery = 'SELECT fldFirstName,fldLastName,fnkFavoriteAnimalName,fldEmail, fldDateJoined, fldLevel, fldConfirmed, fldApproved FROM tblUsers WHERE pmkUserId = ?';
//store the primary key in an array
    $pmkArray = array($userPrimaryKey);
    $userAttributes = $thisDatabaseReader->select($userAttributesQuery, $pmkArray, 1);
//display their information
    print '<fieldset id = "userInformation">';
    print '<p class ="xlarge"><strong>' . $userAttributes[0]['fldFirstName'] . '</strong></p>';
    print '<p class ="xlarge"><strong>'     .   $userAttributes[0]['fldLastName'] . '</strong></p>';
        print '<p class = "xlarge">Level: ' . $userAttributes[0]['fldLevel'] . '</p>';
//display photo
    print '<img alt="image" src="photos/' . $userAttributes[0]['fnkFavoriteAnimalName'] . '.jpg" class = "animal" id = "profile">';

    print '<p class = "moderate">Email: ' . $userAttributes[0]['fldEmail'] . '</p>';
    print '<p class = "moderate">Account Created: ' . substr($userAttributes[0]['fldDateJoined'], 0, 10) . '</p>';
    if ($userAttributes[0]['fldConfirmed'] == 1) {
        print '<p class = "moderate">Confirmed: Yes -';
    } else {
        print '<p class = "moderate">Confirmed: No -';
    }
    if ($userAttributes[0]['fldApproved'] == 1) {
        print ' Approved: Yes</p>';
    } else {
        print ' Approved: No</p>';
    }
//form to update user information
    print '</fieldset>';
    print '<fieldset id ="userProfileEdit">';
    print '<p class="xlarge">Edit Profile</p>';
//begin form
    print '<form  method = "post" action = "quiz.php">';
//let user choose name of quiz
    print '<p class="moderate">Enter a new first name</p>';
    print '<input id="firstName" maxlength="45" name="firstName" value="' . $userAttributes[0]['fldFirstName'] . '" onfocus=this.select() type="text">';
    print '<p class="moderate">Enter a new last name</p>';
    print '<input id="lastName" maxlength="45" name="lastName" value="' . $userAttributes[0]['fldLastName'] . '" onfocus=this.select() type="text">';
//store the user pmk in a hidden input
    print '<input type="hidden" name="userPrimaryKey" value="' . $userPrimaryKey . '">';
    print '<p class="moderate">Select your favorite animal</p>';
//query to select distinct animal names from tblAnimals
$distinctAnimalQuery = 'SELECT DISTINCT pmkAnimalName FROM tblAnimals';
$animals = $thisDatabaseReader->select($distinctAnimalQuery, "", 0);
print '<select name="favoriteAnimal">';
            if (is_array($animals)) {
                print '<option';
                //get selected to preserve from previous submission
                if ("" == $userAttributes[0]['fnkFavoriteAnimalName']) {
                    print ' selected="selected"';
                }
                print ' value ="">Choose your favorite animal</option>';
                foreach ($animals as $animal) {
                    print '<option';
                    if ($animal[0] == $userAttributes[0]['fnkFavoriteAnimalName']) {
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
//let user choose name of quiz
    print '<p class="moderate">Click here to update</p>';
//print submit button
    print '<input type="submit" id="update" name="update" value="Update" tabindex="900" class = "button">';
//end form
    print '</form>';
    print '</fieldset>';
//get the quizzes the current user has taken
    $quizInformationQuery = 'SELECT fldNumberCorrect,fldTotalQuestions,fldQuizName,fldDateCreated,pmkQuizId FROM tblUsersQuizzes JOIN tblQuizzes ON pmkQuizId = fnkQuizId WHERE fnkUserId = ?';
    $quizzes = $thisDatabaseReader->select($quizInformationQuery, $pmkArray, 1);
    print '<fieldset id ="startQuiz">';
    print '<p class="xlarge">Start a Quiz</p>';
//begin form
    print '<form  method = "post" action = "question.php">';
//let user choose name of quiz
    print '<p class="moderate">Enter your quiz name</p>';
    print '<input id="quizName" maxlength="45" name="quizName" placeholder = "My First Quiz" onfocus=this.select() type="text">';
//store the user pmk in a hidden input
    print '<input type="hidden" name="userPrimaryKey" value="' . $userPrimaryKey . '">';
//let user choose name of quiz
    print '<p class="moderate">Click here to start a new quiz</p>';
//print submit button
    print '<input type="submit" id="quizSubmit" name="quizSubmit" value="Start a Quiz" tabindex="900" class = "button">';
//end form
    print '</form>';
    print '<p class="moderate">Click here to practice</p>';
    //begin form to end quiz
    print '<form  method = "post" action = "practice.php">';
//store the user pmk in a hidden input
    print '<input type="hidden" name="userPrimaryKey" value="' . $userPrimaryKey . '">';
//print submit button
    print '<input type="submit" id="practicebutton" name="practicebutton" value="Practice" tabindex="900" class = "button">';
//end form
    print '</form>';
    print '</fieldset>';
    $counter=0;
    //show all the highscores
    $scoresQuery = 'SELECT fldFirstName,fldLastName,fnkFavoriteAnimalName,fldLevel FROM tblUsers ORDER BY fldLevel DESC';
    $scores = $thisDatabaseReader->select($scoresQuery, "", 0,1);
    if($scores){
    print '<fieldset id = "highScores">';
    print '<p class = "xlarge">User Scoreboard</p>';
        print '<table>';
        print '<tr>';
        print '<th>User</th>';
        print '<th>Level</th>';
        print '</tr>';
    foreach($scores as $score){
        if ($counter == 0) {
                print '<tr class = "even">';
            } else {
                print '<tr class = "odd">';
            }
             print '<td>';
             //display photo
                print '<img alt="image" src="photos/' . $score['fnkFavoriteAnimalName'] . '.jpg" class = "highScorePhoto">';
            print '<p class="moderate">' . $score['fldFirstName'] . ' ' . $score['fldLastName'] . '</p></td>';
            print '<td><p class="moderate">' . $score['fldLevel'] . '</p></td>';
            print '</tr>';
            //use a counter to show alternating rows in different colors
            if ($counter == 0) {
                $counter++;
            } else {
                $counter--;
            }
        }
                print '</table>';
        print '</fieldset>';
    }
//if they have taken a quiz display the information we have about it
    if ($quizzes) {
        print '<fieldset id = "reviewquizzes">';
        $counter = 0;
        print '<p class = "xlarge">Review Past Quizzes</p>';
        print '<table>';
        print '<tr>';
        print '<th>Name</th>';
        print '<th>Date</th>';
        print '<th>Length</th>';
        print '<th>Correct</th>';
        print '<th>Review</th>';
        print '</tr>';
        foreach ($quizzes as $quiz) {
            if ($counter == 0) {
                print '<tr class = "even">';
            } else {
                print '<tr class = "odd">';
            }
            print '<td>' . $quiz['fldQuizName'] . '</td>';
            print '<td>' . $quiz['fldDateCreated'] . '</td>';
            print '<td>' . $quiz['fldTotalQuestions'] . '</td>';
            print '<td>' . $quiz['fldNumberCorrect'] . '</td>';
            print '<td>';
            //we will now create a form that goes to a page with more information about the quiz
            //begin form
            print '<form  method = "post" action = "quizquestions.php">';
            //store the user pmk in a hidden input
            print '<input type="hidden" name="userPrimaryKey" value="' . $userPrimaryKey . '">';
            //store the quiz pmk in a hidden input
            print '<input type="hidden" name="quizPrimaryKey" value="' . $quiz['pmkQuizId'] . '">';
            //print submit button
            print '<input type="submit" class="quizquestionsbutton" name="quizquestionsbutton" value="Review" tabindex="900">';
            //end form
            print '</form>';
            print '</td>';
            print '</tr>';
            //use a counter to show alternating rows in different colors
            if ($counter == 0) {
                $counter++;
            } else {
                $counter--;
            }
        }
        print '</table>';
        print '</fieldset>';
    }
    
}
?>