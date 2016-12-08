<?php
//include top
include "top.php";
//if a user ended a quiz
if (isset($_POST["practicebutton"])) {
    //get the user id for a new user
    $userPrimaryKey = htmlentities($_POST["userPrimaryKey"], ENT_QUOTES, "UTF-8");
}
//begin form to end quiz
    print '<form  method = "post" action = "quiz.php" class ="mb">';
//store the user pmk in a hidden input
    print '<input type="hidden" name="userPrimaryKey" value="' . $userPrimaryKey . '">';
//print submit button
    print '<input type="submit" id="endquiz" name="endquiz" value="Return to Profile" tabindex="900" class = "button">';
//end form
    print '</form>';
//query to select distinct animal names from tblAnimals
$distinctAnimalQuery = 'SELECT DISTINCT pmkAnimalName FROM tblAnimals';
$animals = $thisDatabaseReader->select($distinctAnimalQuery, "", 0);
foreach($animals as $animal){
    print '<fieldset class = "reviewquestions">';
print '<div class = "imagetext">';
print '<label>';
//display photo
print '<img alt = "image" src="photos/' . $animal[0] . '.jpg" class = "animal">';
//this text will display the animal name under its photo

print '<span class = "textunder" id = "' . $animal[0] . 'label"><strong>' . $animal[0] . '</strong></span>';

print '</label>';
print '</div>';
//inform user how to hear sound
print '<p class = "moderate">Click the play button to hear the sound </p>';
//display the sound for the correct animal
print '<audio controls>';
print'<source src="sounds/';
print $animal[0];
print '.mp3" type="audio/mpeg">';
print'Your browser does not support the audio element.';
print '</audio>';
print '</fieldset>';
}

//include footer
include "footer.php";
?>