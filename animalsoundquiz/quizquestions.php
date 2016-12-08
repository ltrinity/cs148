<?php
//include top
include "top.php";
//if the form is submitted post the values
if (isset($_POST["quizquestionsbutton"])) {
    //get the user pmk
    $userPrimaryKey = htmlentities($_POST["userPrimaryKey"], ENT_QUOTES, "UTF-8");
    //get the quiz pmk
    $quizPrimaryKey = htmlentities($_POST["quizPrimaryKey"], ENT_QUOTES, "UTF-8");
}
$quizQuestionsQuery = 'SELECT fnkRightAnswerAnimalId,fnkUserChoseAnimalName FROM tblQuizzesQuestions JOIN tblQuestions ON pmkQuestionId = fnkQuestionId WHERE fnkQuizId = ?';
$data = array($quizPrimaryKey);
$questions = $thisDatabaseReader->select($quizQuestionsQuery, $data, 1);
//begin form
    print '<fieldset class = "reviewquestions">';
        
            print '<p class = "xlarge">Review Your Quiz</p>';
            print '<form  method = "post" action = "quiz.php" class ="mb">';
        //store the user pmk in a hidden input
        print '<input type="hidden" name="userPrimaryKey" value="' . $userPrimaryKey . '">';
        //print submit button
        print '<input type="submit" id="quiz" name="quiz" value="Return to your profile" tabindex="900" class = "button">';
        //end form
        print '</form>';
if($questions){
    $numQuestions = 1;
    print '<table>';
    print '<tr>';
    print '<th>Question Number</th>';
    print '<th>Correct Answer</th>';
    print '<th>Your Answer</th>';
    print '<th>Details</th>';
    print '</tr>';
    foreach($questions as $question){
        if($question['fnkUserChoseAnimalName']==$question['fnkRightAnswerAnimalId']){
        print '<tr class = "correct">';}
        else{
            print '<tr class = "incorrect">';}
        print '<td>' . $numQuestions . '</td>';
        print '<td>' . $question['fnkRightAnswerAnimalId'] . '</td>';
        print '<td>' . $question['fnkUserChoseAnimalName'] . '</td>';
        print '<td>';
        //we will now create a form that goes to a page with more information about the quiz
        //begin form
        print '<form  method = "post" action = "questionsanimals.php">';
        //store the user pmk in a hidden input
        print '<input type="hidden" name="userPrimaryKey" value="' . $userPrimaryKey . '">';
        //store the quiz pmk in a hidden input
        print '<input type="hidden" name="quizPrimaryKey" value="' . $quizPrimaryKey . '">';
        //store the quiz pmk in a hidden input
        print '<input type="hidden" name="rightAnswer" value="' . $question['fnkRightAnswerAnimalId']  . '">';
        //store the quiz pmk in a hidden input
        print '<input type="hidden" name="userAnswer" value="' . $question['fnkUserChoseAnimalName']  . '">';        //print submit button
        print '<input type="submit" id="questionsanimals" name="questionsanimals" value="Practice" tabindex="900" class = "button">';
        //end form
        print '</form>';
        print '</td>';
        print '</tr>';
        $numQuestions++;
    }
    print '</table>';

}
    print '</fieldset>';
//include footer
include "footer.php";
?>