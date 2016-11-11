<?php
//initialize database connection
include	"top.php";
include "nav.php";?>
<!--this table is copied from mywebdb-->
<h2>tblAdvisors</h2>
<table  class="print"><tr><th >Column</th><th >Type</th><th >Null</th><th >Default</th>    <th>Links to</th>
        <th>Comments</th>
    </tr><tr class="odd"><td class="nowrap">pmkAdvisorNetId <em>(Primary)</em></td><td class="nowrap" lang="en" dir="ltr">varchar(20)</td><td>No</td><td class="nowrap"></td>    <td></td>
        <td></td>
    </tr><tr class="even"><td class="nowrap">fldAdvisorFirstName</td><td class="nowrap" lang="en" dir="ltr">varchar(15)</td><td>No</td><td class="nowrap"></td>    <td></td>
        <td></td>
    </tr><tr class="odd"><td class="nowrap">fldAdvisorLastName</td><td class="nowrap" lang="en" dir="ltr">varchar(15)</td><td>No</td><td class="nowrap"></td>    <td></td>
        <td></td>
    </tr><tr class="even"><td class="nowrap">fldAdvisorEmail</td><td class="nowrap" lang="en" dir="ltr">varchar(20)</td><td>No</td><td class="nowrap"></td>    <td></td>
        <td></td>
    </tr></table><h3>Indexes</h3><div class='no_indexes_defined hide'><div class="notice"> No index defined!</div></div><table ><thead><tr><th>Keyname</th><th>Type</th><th>Unique</th><th>Packed</th><th>Column</th><th>Cardinality</th><th>Collation</th><th>Null</th><th>Comment</th></tr></thead><tbody><tr class="noclick odd"><td  rowspan="1" >PRIMARY</td><td  rowspan="1" >BTREE</td><td  rowspan="1" >Yes</td><td  rowspan="1" >No</td><td>pmkAdvisorNetId</td><td>0</td><td>A</td><td>No</td><td  rowspan="1" ></td></tr></tbody></table><div>
    <h2>tblCourses</h2>
    <table  class="print"><tr><th >Column</th><th >Type</th><th >Null</th><th >Default</th>    <th>Links to</th>
            <th>Comments</th>
        </tr><tr class="odd"><td class="nowrap">pmkCourseId <em>(Primary)</em></td><td class="nowrap" lang="en" dir="ltr">int(11)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr><tr class="even"><td class="nowrap">fldSubject</td><td class="nowrap" lang="en" dir="ltr">varchar(20)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr><tr class="odd"><td class="nowrap">fldCourseNumber</td><td class="nowrap" lang="en" dir="ltr">int(4)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr><tr class="odd"><td class="nowrap">fldCourseCredits</td><td class="nowrap" lang="en" dir="ltr">int(2)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr></table><h3>Indexes</h3><div class='no_indexes_defined hide'><div class="notice"> No index defined!</div></div><table ><thead><tr><th>Keyname</th><th>Type</th><th>Unique</th><th>Packed</th><th>Column</th><th>Cardinality</th><th>Collation</th><th>Null</th><th>Comment</th></tr></thead><tbody><tr class="noclick odd"><td  rowspan="1" >PRIMARY</td><td  rowspan="1" >BTREE</td><td  rowspan="1" >Yes</td><td  rowspan="1" >No</td><td>pmkCourseId</td><td>2516</td><td>A</td><td>No</td><td  rowspan="1" ></td></tr></tbody></table></div><div>
    <h2>tblPlans</h2>
    <table  class="print"><tr><th >Column</th><th >Type</th><th >Null</th><th >Default</th>    <th>Links to</th>
            <th>Comments</th>
        </tr><tr class="odd"><td class="nowrap">pmkPlanId <em>(Primary)</em></td><td class="nowrap" lang="en" dir="ltr">int(11)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr><tr class="even"><td class="nowrap">fnkStudentNetId</td><td class="nowrap" lang="en" dir="ltr">varchar(20)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr><tr class="odd"><td class="nowrap">fnkAdvisorNetId</td><td class="nowrap" lang="en" dir="ltr">varchar(20)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr><tr class="even"><td class="nowrap">fldDegree</td><td class="nowrap" lang="en" dir="ltr">varchar(30)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr><tr class="odd"><td class="nowrap">fldDateCreated</td><td class="nowrap" lang="en" dir="ltr">varchar(20)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr><tr class="even"><td class="nowrap">fldCatalogYear</td><td class="nowrap" lang="en" dir="ltr">varchar(10)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr><tr class="odd"><td class="nowrap">fldPlanCredits</td><td class="nowrap" lang="en" dir="ltr">int(3)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr></table><h3>Indexes</h3><div class='no_indexes_defined hide'><div class="notice"> No index defined!</div></div><table ><thead><tr><th>Keyname</th><th>Type</th><th>Unique</th><th>Packed</th><th>Column</th><th>Cardinality</th><th>Collation</th><th>Null</th><th>Comment</th></tr></thead><tbody><tr class="noclick odd"><td  rowspan="1" >PRIMARY</td><td  rowspan="1" >BTREE</td><td  rowspan="1" >Yes</td><td  rowspan="1" >No</td><td>pmkPlanId</td><td>0</td><td>A</td><td>No</td><td  rowspan="1" ></td></tr></tbody></table></div><div>
    <h2>tblSemesters</h2>
    <table  class="print"><tr><th >Column</th><th >Type</th><th >Null</th><th >Default</th>    <th>Links to</th>
            <th>Comments</th>
        </tr><tr class="odd"><td class="nowrap">fnkPlanId <em>(Primary)</em></td><td class="nowrap" lang="en" dir="ltr">int(11)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr><tr class="even"><td class="nowrap">fldTerm <em>(Primary)</em></td><td class="nowrap" lang="en" dir="ltr">varchar(15)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr><tr class="odd"><td class="nowrap">fldTermYear <em>(Primary)</em></td><td class="nowrap" lang="en" dir="ltr">int(4)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr><tr class="even"><td class="nowrap">fldSemesterCredits</td><td class="nowrap" lang="en" dir="ltr">int(2)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr></table><h3>Indexes</h3><div class='no_indexes_defined hide'><div class="notice"> No index defined!</div></div><table ><thead><tr><th>Keyname</th><th>Type</th><th>Unique</th><th>Packed</th><th>Column</th><th>Cardinality</th><th>Collation</th><th>Null</th><th>Comment</th></tr></thead><tbody><tr class="noclick odd"><td  rowspan="3" >PRIMARY</td><td  rowspan="3" >BTREE</td><td  rowspan="3" >Yes</td><td  rowspan="3" >No</td><td>fnkPlanId</td><td>0</td><td>A</td><td>No</td><td  rowspan="3" ></td></tr><tr class="noclick odd"><td>fldTerm</td><td>0</td><td>A</td><td>No</td></tr><tr class="noclick odd"><td>fldTermYear</td><td>0</td><td>A</td><td>No</td></tr></tbody></table></div><div>
    <h2>tblSemestersCourses</h2>
    <table  class="print"><tr><th >Column</th><th >Type</th><th >Null</th><th >Default</th>    <th>Links to</th>
            <th>Comments</th>
        </tr><tr class="odd"><td class="nowrap">fldRequirement</td><td class="nowrap" lang="en" dir="ltr">varchar(20)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr><tr class="even"><td class="nowrap">fnkCourseId <em>(Primary)</em></td><td class="nowrap" lang="en" dir="ltr">int(11)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr><tr class="odd"><td class="nowrap">fnkPlanId <em>(Primary)</em></td><td class="nowrap" lang="en" dir="ltr">int(11)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr><tr class="even"><td class="nowrap">fnkTerm <em>(Primary)</em></td><td class="nowrap" lang="en" dir="ltr">varchar(15)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr><tr class="odd"><td class="nowrap">fnkTermYear <em>(Primary)</em></td><td class="nowrap" lang="en" dir="ltr">int(4)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr></table><h3>Indexes</h3><div class='no_indexes_defined hide'><div class="notice"> No index defined!</div></div><table ><thead><tr><th>Keyname</th><th>Type</th><th>Unique</th><th>Packed</th><th>Column</th><th>Cardinality</th><th>Collation</th><th>Null</th><th>Comment</th></tr></thead><tbody><tr class="noclick odd"><td  rowspan="4" >PRIMARY</td><td  rowspan="4" >BTREE</td><td  rowspan="4" >Yes</td><td  rowspan="4" >No</td><td>fnkCourseId</td><td>0</td><td>A</td><td>No</td><td  rowspan="4" ></td></tr><tr class="noclick odd"><td>fnkPlanId</td><td>0</td><td>A</td><td>No</td></tr><tr class="noclick odd"><td>fnkTerm</td><td>0</td><td>A</td><td>No</td></tr><tr class="noclick odd"><td>fnkTermYear</td><td>0</td><td>A</td><td>No</td></tr></tbody></table></div><div>
    <h2>tblStudents</h2>
    <table  class="print"><tr><th >Column</th><th >Type</th><th >Null</th><th >Default</th>    <th>Links to</th>
            <th>Comments</th>
        </tr><tr class="odd"><td class="nowrap">pmkStudentNetId <em>(Primary)</em></td><td class="nowrap" lang="en" dir="ltr">varchar(20)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr><tr class="even"><td class="nowrap">fldStudentFirstName</td><td class="nowrap" lang="en" dir="ltr">varchar(15)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr><tr class="odd"><td class="nowrap">fldStudentLastName</td><td class="nowrap" lang="en" dir="ltr">varchar(15)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr><tr class="even"><td class="nowrap">fldStudentEmail</td><td class="nowrap" lang="en" dir="ltr">varchar(20)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr><tr class="odd"><td class="nowrap">fldYearEntered</td><td class="nowrap" lang="en" dir="ltr">int(4)</td><td>No</td><td class="nowrap"></td>    <td></td>
            <td></td>
        </tr></table><h3>Indexes</h3><div class='no_indexes_defined hide'><div class="notice"> No index defined!</div></div><table ><thead><tr><th>Keyname</th><th>Type</th><th>Unique</th><th>Packed</th><th>Column</th><th>Cardinality</th><th>Collation</th><th>Null</th><th>Comment</th></tr></thead><tbody><tr class="noclick odd"><td  rowspan="1" >PRIMARY</td><td  rowspan="1" >BTREE</td><td  rowspan="1" >Yes</td><td  rowspan="1" >No</td><td>pmkStudentNetId</td><td>0</td><td>A</td><td>No</td><td  rowspan="1" ></td></tr></tbody></table></div>
    <?php
    include "footer.php";
?>