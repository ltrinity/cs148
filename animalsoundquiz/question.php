<?php
//initialize database connection
include "top.php";
?>
<!--script to show button when an animal is selected
prompt user to select an animal if they have not-->
<script>
    function showhide(element) {
        //show the submit button
        document.getElementById("questionSubmitButton").hidden = "";
        document.getElementById("questionSubmitButton").style.display = "block";
        //hide the prompt to select an animal
        document.getElementById("promptToPickAnimal").hidden = "hidden";
        //get the id of the element passed in to the function
        //use this id to create the id of the label below the image
        var id = element.id
        var label = "label";
        var labelId = id.concat(label);
        //get all the text itmes
        var textarray = document.getElementsByClassName("textunder");
        //make sure the old selection returns to normal size
        for (var i = 0; i < textarray.length; i++) {
            textarray[i].style.fontSize = "large";
            textarray[i].style.textShadow = "";
        }
        //make the selected animal larger
        document.getElementById(labelId).style.fontSize = "xx-large";
        document.getElementById(labelId).style.textShadow= "0px -1px black";
    }
</script>
<?php
//when the user is sent from the answer page to get a new question
if (isset($_POST["newquestion"])) {
    //get user Id
    $userPrimaryKey = htmlentities($_POST["userPrimaryKey"], ENT_QUOTES, "UTF-8");
    //get quiz Id
    $quizPrimaryKey = htmlentities($_POST["quizPrimaryKey"], ENT_QUOTES, "UTF-8");
}
//when the user starts a new quiz
if (isset($_POST["quizSubmit"])) {
    //get the pmk
    $userPrimaryKey = htmlentities($_POST["userPrimaryKey"], ENT_QUOTES, "UTF-8");
    //get the quiz name
    $quizName = htmlentities($_POST["quizName"], ENT_QUOTES, "UTF-8");
    $quizArray = array($quizName);
    //insert into tblQuizzes new quiz
    $storeUserSelectionQuery = 'INSERT INTO tblQuizzes SET fldQuizName = ?';
    $thisDatabaseWriter->insert($storeUserSelectionQuery, $quizArray);
    //get the last ID created
    $quizPrimaryKey = $thisDatabaseWriter->lastInsert();
    //insert the foreign keys of the user and the quiz into tblUsersQuizzes
    $userQuizInsertionQuery = "INSERT INTO tblUsersQuizzes SET fnkUserId = ?, fnkQuizId = ?";
    $userQuizAttributes = array($userPrimaryKey, $quizPrimaryKey);
    $thisDatabaseWriter->insert($userQuizInsertionQuery, $userQuizAttributes);
}


//we will now get the user level
$getUserLevelQuery = 'SELECT fldLevel FROM tblUsers WHERE pmkUserId = ?';
$pmk = array($userPrimaryKey);
$level = $thisDatabaseReader->select($getUserLevelQuery, $pmk, 1);
$levelArray = array($quizPrimaryKey,  $level[0][0]);
//We will now create a question
////get the last ID created
//select a random animal and insert it into tblQuestions as a foreign key
$getRightAnswerAnimalIdQuery = 'INSERT INTO tblQuestions (fnkRightAnswerAnimalId) SELECT pmkAnimalName FROM tblAnimals WHERE pmkAnimalName NOT IN (SELECT fnkRightAnswerAnimalId FROM tblQuestions JOIN tblQuizzesQuestions ON pmkQuestionId = fnkQuestionId JOIN tblQuizzes ON pmkQuizId = tblQuizzesQuestions.fnkQuizId WHERE pmkQuizId = ?) AND tblAnimals.fldLevel = ? ORDER BY RAND() LIMIT 1';
$thisDatabaseWriter->insert($getRightAnswerAnimalIdQuery, $levelArray, 2, 3);
//get the last ID created
$lastId = array($thisDatabaseWriter->lastInsert());
//get the sound for the current question based on the animal name of the last inserted id
$getCorrectAnswerAnimalNameQuery = "SELECT fnkRightAnswerAnimalId from tblQuestions WHERE pmkQuestionId = ?";
$correctAnimal = $thisDatabaseReader->select($getCorrectAnswerAnimalNameQuery, $lastId, 1);
print '<fieldset class = "audioFieldset">';
print '<p class="xlarge" id = "promptToPickAnimal">Click to choose an animal</p>';
//inform user how to hear sound
print '<p class="moderate">Click the play button to hear the sound again</p>';
//display the sound for the correct animal
print '<audio controls autoplay>';
print'<source src="sounds/';
print $correctAnimal[0][0];
print '.mp3" type="audio/mpeg">';
print'Your browser does not support the audio element.';
print '</audio>';

//this query will get two animals that are not the correct animal
$getIncorrectAnimalsQuery = "SELECT pmkAnimalName FROM tblAnimals WHERE pmkAnimalName != ? AND fldLevel = ? ORDER BY RAND() LIMIT 2";
$IncorrectAnimalsQueryData = array($correctAnimal[0][0],$level[0][0]);
$incorrectAnimals = $thisDatabaseReader->select($getIncorrectAnimalsQuery, $IncorrectAnimalsQueryData, 1, 3);
//insert the question id and the two incorrect animals to tblQuestionsAnimals
$questionsAnimalsQuery = 'INSERT INTO tblQuestionsAnimals (fnkQuestionId,fnkAnimalName) VALUES (?, ?)';
$questionFnk = $thisDatabaseWriter->lastInsert();
$questionsAnimalsData = array($questionFnk,$incorrectAnimals[0][0]);
$questionsAnimalsData2 = array($questionFnk,$incorrectAnimals[1][0]);
$thisDatabaseWriter->insert($questionsAnimalsQuery, $questionsAnimalsData);
$thisDatabaseWriter->insert($questionsAnimalsQuery, $questionsAnimalsData2);
//create an array of the correct and incorrect animals
$animalsToDisplay = array($correctAnimal[0][0], $incorrectAnimals[0][0], $incorrectAnimals[1][0]);
//randomize the array
shuffle($animalsToDisplay);
//begin the form
print '<form  method = "post" action = "answer.php">';

//print submit button
print '<input type="submit" id="questionSubmitButton" name="questionSubmitButton" hidden = "hidden" value="Confirm Answer" tabindex="900" class = "button">';
//store the prev question id
print '<input type="text" name="questionIdPrior" hidden = "hidden" value="' . $lastId[0] . '">';
//store the correct animal in a hidden input
print '<input type="hidden" name="hiddenCorrectAnimal" value="' . $correctAnimal[0][0] . '">';
//store the user pmk in a hidden input
print '<input type="hidden" name="userPrimaryKey" value="' . $userPrimaryKey . '">';
//store the quiz pmk in a hidden input
print '<input type="hidden" name="quizPrimaryKey" value="' . $quizPrimaryKey . '">';

//display each animals photo
foreach ($animalsToDisplay as $animal) {
    //wrap the image and text in a div
   print '<div class = "imagetext">';
    print '<label>';
    //create a hidden radio button
    print '<input type="radio" name="animalSelection" onclick="showhide(this)" class="none" value = "' . $animal . '" id = "' . $animal . '"/>';
    //display photo
        //this text will display the animal name under its photo
    
    print '<span class = "textunder" id = "' . $animal . 'label"><strong>' . $animal . '</strong></span>';
    
    print '<img alt="image" src="photos/' . $animal . '.jpg" class = "animal">';

    print '</label>';
    print '</div>';
}


//end form
print '</form>';
print '</fieldset>';
//include footer
include "footer.php";
?>