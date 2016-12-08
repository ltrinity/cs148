<?php

//include top
include "top.php";
//if the form is submitted post the values
if (isset($_POST["questionSubmitButton"])) {
    //get the correct Answer
    $correctAnswer = htmlentities($_POST["hiddenCorrectAnimal"], ENT_QUOTES, "UTF-8");
    //get the user answer
    $chosenAnswer = htmlentities($_POST["animalSelection"], ENT_QUOTES, "UTF-8");
    //get question Id
    $priorQuestionId = htmlentities($_POST["questionIdPrior"], ENT_QUOTES, "UTF-8");
    //get user Id
    $userPrimaryKey = htmlentities($_POST["userPrimaryKey"], ENT_QUOTES, "UTF-8");
    //get quiz Id
    $quizPrimaryKey = htmlentities($_POST["quizPrimaryKey"], ENT_QUOTES, "UTF-8");

    print '<fieldset id = "answerPageFS">';

    if ($correctAnswer == $chosenAnswer) {
        print '<p class="large">Correct!</p>';
        print '<p class="large">Answer: ' . $correctAnswer . '</p>';
    } else {
        print '<p class="large">Incorrect!</p>';
        print '<p class="large">Answer: ' . $correctAnswer . '</p>';
    }
    $pmkArray = array($userPrimaryKey);
    //test if we have another question
    //check for level up
    $currentLevelQuery = 'SELECT fldLevel FROM tblUsers WHERE pmkUserId = ?';
    $currentLevel = $thisDatabaseReader->select($currentLevelQuery, $pmkArray, 1);
    $newQuestionData = array($quizPrimaryKey, $currentLevel[0][0]);
    $testForQuestionQuery = 'SELECT pmkAnimalName FROM tblAnimals WHERE pmkAnimalName NOT IN (SELECT fnkRightAnswerAnimalId FROM tblQuestions JOIN tblQuizzesQuestions ON pmkQuestionId = fnkQuestionId JOIN tblQuizzes ON pmkQuizId = tblQuizzesQuestions.fnkQuizId WHERE pmkQuizId = ?) AND tblAnimals.fldLevel = ?';
    $nextQuestion = $thisDatabaseReader->select($testForQuestionQuery, $newQuestionData, 2, 2);
    if ($nextQuestion[1][0] != "") {
//begin form to start new question
        print '<form  method = "post" action = "question.php">';
//store the user pmk in a hidden input
        print '<input type="hidden" name="userPrimaryKey" value="' . $userPrimaryKey . '">';
//store the quiz id in a hidden input
        print '<input type="hidden" name="quizPrimaryKey" value="' . $quizPrimaryKey . '">';
//print submit button
        print '<input type="submit" id="newquestion" name="newquestion" value="Next Question" tabindex="900" class = "button">';
//end form
        print '</form>';
    }

//begin form to end quiz
    print '<form  method = "post" action = "quiz.php">';
//store the user pmk in a hidden input
    print '<input type="hidden" name="userPrimaryKey" value="' . $userPrimaryKey . '">';
//print submit button
    print '<input type="submit" id="endquiz" name="endquiz" value="End Quiz" tabindex="900" class = "button">';
//end form
    print '</form>';
    //form data array for quiz question query
    $userSelection = array($quizPrimaryKey, $priorQuestionId, $chosenAnswer);
    //insert into tblQuizzesQuestions what the user chose
    $storeUserSelectionQuery2 = "INSERT INTO tblQuizzesQuestions (`fnkQuizId`, `fnkQuestionId`, `fnkUserChoseAnimalName`) VALUES (?, ?, ?)";
    $thisDatabaseWriter->insert($storeUserSelectionQuery2, $userSelection, 0);
    //get the previous number of questions and correct answers
    $getQuizStatusQuery = 'SELECT fldTotalQuestions,fldNumberCorrect FROM tblUsersQuizzes WHERE fnkUserId = ? AND fnkQuizId = ?';
    $userquizarray = array($userPrimaryKey, $quizPrimaryKey);
    $totals = $thisDatabaseReader->select($getQuizStatusQuery, $userquizarray, 1, 1);
    //increment number of questions
    $totalQuestions = $totals[0][0] + 1;
    //check if answer is correct and increment number correct if necessary
    if ($correctAnswer == $chosenAnswer) {
        $numberCorrect = $totals[0][1] + 1;
    } else {
        $numberCorrect = $totals[0][1];
    }
    $updateUserQuizData = array($totalQuestions, $numberCorrect, $userPrimaryKey, $quizPrimaryKey);
    //we will now update tblUsersQuizzes
    $updateNumberQuestionsQuery = 'UPDATE tblUsersQuizzes SET fldTotalQuestions = ?, fldNumberCorrect = ? WHERE fnkUserId = ? AND fnkQuizId = ?';
    $thisDatabaseWriter->update($updateNumberQuestionsQuery, $updateUserQuizData, 1, 1);

    //get the quizzes the current user has taken
    $quizInformationQuery = 'SELECT SUM(fldNumberCorrect) FROM tblUsersQuizzes JOIN tblQuizzes ON pmkQuizId = fnkQuizId WHERE fnkUserId = ?';
    $quizzes = $thisDatabaseReader->select($quizInformationQuery, $pmkArray, 1);
    switch ($quizzes[0]['SUM(fldNumberCorrect)']) {
        case(5):
            $currentLevelQuery = 'SELECT fldLevel FROM tblUsers WHERE pmkUserId = ?';
            $currentLevel = $thisDatabaseReader->select($currentLevelQuery, $pmkArray, 1);
            if ($currentLevel[0][0] == 1) {
                print '<p class ="xlarge">Level Up!</p>';
                //we will now update tblUsers
                $updateLevelQuery = 'UPDATE tblUsers SET fldLevel = 2 WHERE pmkUserId = ?';
                $thisDatabaseWriter->update($updateLevelQuery, $pmkArray, 1);
            }
            break;
        case(10):
            $currentLevelQuery = 'SELECT fldLevel FROM tblUsers WHERE pmkUserId = ?';
            $currentLevel = $thisDatabaseReader->select($currentLevelQuery, $pmkArray, 1);
            if ($currentLevel[0][0] == 2) {
                print '<p class="large">Level Up!</p>';
                //we will now update tblUsers
                $updateLevelQuery = 'UPDATE tblUsers SET fldLevel = 3 WHERE pmkUserId = ?';
                $thisDatabaseWriter->update($updateLevelQuery, $pmkArray, 1);
            }
            break;
        case(15):
            $currentLevelQuery = 'SELECT fldLevel FROM tblUsers WHERE pmkUserId = ?';
            $currentLevel = $thisDatabaseReader->select($currentLevelQuery, $pmkArray, 1);
            if ($currentLevel[0][0] == 3) {
                print '<p class="large">Level Up!</p>';
                //we will now update tblUsers
                $updateLevelQuery = 'UPDATE tblUsers SET fldLevel = 4 WHERE pmkUserId = ?';
                $thisDatabaseWriter->update($updateLevelQuery, $pmkArray, 1);
            }
            break;
    }
    print '</fieldset>';
    //display photo
    print '<img src="photos/' . $correctAnswer . '.jpg" class = "animal">';
}

//include footer
include "footer.php";
?>