<?php
include "top.php";
?>
   <h2>tblAnimals</h2>
<table  class="print"><tr><th >Column</th><th >Type</th><th >Null</th><th >Default</th>    <th>Links to</th>
    <th>Comments</th>
</tr><tr class="odd"><td class="nowrap">pmkAnimalName <em>(Primary)</em></td><td class="nowrap" lang="en" dir="ltr">varchar(20)</td><td>No</td><td class="nowrap"></td>    <td></td>
    <td></td>
</tr><tr class="even"><td class="nowrap">fldLevel</td><td class="nowrap" lang="en" dir="ltr">int(11)</td><td>No</td><td class="nowrap"></td>    <td></td>
    <td></td>
</tr></table><h2>tblQuestions</h2>
<table  class="print"><tr><th >Column</th><th >Type</th><th >Null</th><th >Default</th>    <th>Links to</th>
    <th>Comments</th>
</tr><tr class="odd"><td class="nowrap">pmkQuestionId <em>(Primary)</em></td><td class="nowrap" lang="en" dir="ltr">int(11)</td><td>No</td><td class="nowrap"></td>    <td></td>
    <td></td>
</tr><tr class="even"><td class="nowrap">fnkRightAnswerAnimalId</td><td class="nowrap" lang="en" dir="ltr">varchar(20)</td><td>No</td><td class="nowrap"></td>    <td></td>
    <td></td>
</tr></table><h2>tblQuestionsAnimals</h2>
<table  class="print"><tr><th >Column</th><th >Type</th><th >Null</th><th >Default</th>    <th>Links to</th>
    <th>Comments</th>
</tr><tr class="odd"><td class="nowrap">fnkQuestionId <em>(Primary)</em></td><td class="nowrap" lang="en" dir="ltr">int(11)</td><td>No</td><td class="nowrap"></td>    <td></td>
    <td></td>
</tr><tr class="even"><td class="nowrap">fnkAnimalName <em>(Primary)</em></td><td class="nowrap" lang="en" dir="ltr">varchar(20)</td><td>No</td><td class="nowrap"></td>    <td></td>
    <td></td>
</tr></table><h2>tblQuizzes</h2>
<table  class="print"><tr><th >Column</th><th >Type</th><th >Null</th><th >Default</th>    <th>Links to</th>
    <th>Comments</th>
</tr><tr class="odd"><td class="nowrap">pmkQuizId <em>(Primary)</em></td><td class="nowrap" lang="en" dir="ltr">int(11)</td><td>No</td><td class="nowrap"></td>    <td></td>
    <td></td>
</tr><tr class="even"><td class="nowrap">fldDateCreated</td><td class="nowrap" lang="en" dir="ltr">timestamp</td><td>Yes</td><td class="nowrap">CURRENT_TIMESTAMP</td>    <td></td>
    <td></td>
</tr><tr class="odd"><td class="nowrap">fldQuizName</td><td class="nowrap" lang="en" dir="ltr">varchar(20)</td><td>Yes</td><td class="nowrap"><i>NULL</i></td>    <td></td>
    <td></td>
</tr></table><h2>tblQuizzesQuestions</h2>
<table  class="print"><tr><th >Column</th><th >Type</th><th >Null</th><th >Default</th>    <th>Links to</th>
    <th>Comments</th>
</tr><tr class="odd"><td class="nowrap">fnkQuizId <em>(Primary)</em></td><td class="nowrap" lang="en" dir="ltr">int(11)</td><td>No</td><td class="nowrap"></td>    <td></td>
    <td></td>
</tr><tr class="even"><td class="nowrap">fnkQuestionId <em>(Primary)</em></td><td class="nowrap" lang="en" dir="ltr">int(11)</td><td>No</td><td class="nowrap"></td>    <td></td>
    <td></td>
</tr><tr class="odd"><td class="nowrap">fnkUserChoseAnimalName</td><td class="nowrap" lang="en" dir="ltr">varchar(20)</td><td>No</td><td class="nowrap"></td>    <td></td>
    <td></td>
</tr></table><h2>tblUsers</h2>
<table  class="print"><tr><th >Column</th><th >Type</th><th >Null</th><th >Default</th>    <th>Links to</th>
    <th>Comments</th>
</tr><tr class="odd"><td class="nowrap">pmkUserId <em>(Primary)</em></td><td class="nowrap" lang="en" dir="ltr">int(11)</td><td>No</td><td class="nowrap"></td>    <td></td>
    <td></td>
</tr><tr class="even"><td class="nowrap">fldFirstName</td><td class="nowrap" lang="en" dir="ltr">varchar(15)</td><td>Yes</td><td class="nowrap"><i>NULL</i></td>    <td></td>
    <td></td>
</tr><tr class="odd"><td class="nowrap">fldLastName</td><td class="nowrap" lang="en" dir="ltr">varchar(15)</td><td>Yes</td><td class="nowrap"><i>NULL</i></td>    <td></td>
    <td></td>
</tr><tr class="even"><td class="nowrap">fnkFavoriteAnimalName</td><td class="nowrap" lang="en" dir="ltr">varchar(20)</td><td>No</td><td class="nowrap">tiger</td>    <td></td>
    <td></td>
</tr><tr class="odd"><td class="nowrap">fldEmail</td><td class="nowrap" lang="en" dir="ltr">varchar(40)</td><td>No</td><td class="nowrap"></td>    <td></td>
    <td></td>
</tr><tr class="even"><td class="nowrap">fldDateJoined</td><td class="nowrap" lang="en" dir="ltr">timestamp</td><td>No</td><td class="nowrap">CURRENT_TIMESTAMP</td>    <td></td>
    <td></td>
</tr><tr class="odd"><td class="nowrap">fldLevel</td><td class="nowrap" lang="en" dir="ltr">int(1)</td><td>No</td><td class="nowrap">1</td>    <td></td>
    <td></td>
</tr><tr class="even"><td class="nowrap">fldConfirmed</td><td class="nowrap" lang="en" dir="ltr">int(1)</td><td>No</td><td class="nowrap">0</td>    <td></td>
    <td></td>
</tr><tr class="odd"><td class="nowrap">fldApproved</td><td class="nowrap" lang="en" dir="ltr">int(1)</td><td>No</td><td class="nowrap">0</td>    <td></td>
    <td></td>
</tr></table><h2>tblUsersQuizzes</h2>
<table  class="print"><tr><th >Column</th><th >Type</th><th >Null</th><th >Default</th>    <th>Links to</th>
    <th>Comments</th>
</tr><tr class="odd"><td class="nowrap">fnkUserId <em>(Primary)</em></td><td class="nowrap" lang="en" dir="ltr">int(11)</td><td>No</td><td class="nowrap"></td>    <td></td>
    <td></td>
</tr><tr class="even"><td class="nowrap">fnkQuizId <em>(Primary)</em></td><td class="nowrap" lang="en" dir="ltr">int(11)</td><td>No</td><td class="nowrap"></td>    <td></td>
    <td></td>
</tr><tr class="odd"><td class="nowrap">fldNumberCorrect</td><td class="nowrap" lang="en" dir="ltr">int(3)</td><td>No</td><td class="nowrap">0</td>    <td></td>
    <td></td>
</tr><tr class="even"><td class="nowrap">fldTotalQuestions</td><td class="nowrap" lang="en" dir="ltr">int(3)</td><td>No</td><td class="nowrap"></td>    <td></td>
    <td></td>
</tr></table>    <?php
include "footer.php";
?>