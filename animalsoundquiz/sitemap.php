<?php
//initialize database connection
include "top.php";
print '<fieldset class = "reviewquestions">';
print '<p class = "large"><a href="git.pdf">Commits</a></p>';
print '</fieldset>';
print '<fieldset class = "reviewquestions">';
print '<p class = "large"><a href="specs.pdf">Specifications</a></p>';
print '</fieldset>';
print '<fieldset class = "reviewquestions">';
print '<p class = "large"><a href="er.php">ER Diagram</a></p>';
print '</fieldset>';
print '<fieldset class = "reviewquestions">';
print '<p class = "large"><a href="schema.sql">Schema</a></p>';
print '</fieldset>';
print '<fieldset class = "reviewquestions">';
print '<p class = "large"><a href="datadictionary.php">Data Dictionary</a></p>';
print '</fieldset>';
//include footer
include "footer.php";
?>
