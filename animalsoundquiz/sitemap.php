<?php
//initialize database connection
include "top.php";
print '<fieldset class = "reviewquestions" >';
print '<img alt="image" src="luke.jpg" class = "animal" id = "pleaseFloat">';
print "<p class = 'large'>About</p>";
print "<p class = 'moderate' id = 'pleaseFloat2'>Luke Trinity is a junior in the Honors College at the University of Vermont majoring in computer science. Originally from Washington, D.C., he loves the beautiful scenery and nature of Vermont. Since last summer, Luke has been employed by the Social Economic Gaming Simulation Lab. During the summer as part of the North East Water Resource Network, he created a game to study farmer's decision-making using Unity and C#. His current project is developing a compliance game to understand how pig industry workers weigh risk and reward.</p>";
print '<strong><a href="http://www.uvm.edu/~segs/node/74">Click here to go to the SEGS website</a></strong>';
print '</fieldset>';
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
