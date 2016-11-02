CREATE TABLE IF NOT EXISTS tblAdvisors( 
pmkAdvisorNetId varchar(20) NOT NULL, 
fldAdvisorFirstName varchar(15) NOT NULL, 
fldAdvisorLastName varchar(15) NOT NULL,
fldAdvisorEmail varchar(20) NOT NULL,
PRIMARY KEY (pmkAdvisorNetId))

CREATE TABLE IF NOT EXISTS tblStudents( 
pmkStudentNetId varchar(20) NOT NULL, 
fldStudentFirstName varchar(15) NOT NULL, 
fldStudentLastName varchar(15) NOT NULL,
fldStudentEmail varchar(20) NOT NULL,
fldYearEntered int(4) NOT NULL,
PRIMARY KEY (pmkStudentNetId))

CREATE TABLE IF NOT EXISTS tblPlans(
pmkPlanId int(11) NOT NULL AUTO_INCREMENT,
fnkStudentNetId varchar(20) NOT NULL,
fnkAdvisorNetId varchar(20) NOT NULL,
fldDegree varchar(30) NOT NULL,
fldDateCreated varchar(20) NOT NULL,
fldCatalogYear varchar(10) NOT NULL,
fldPlanCredits int(3) NOT NULL,
PRIMARY KEY (pmkPlanId))

CREATE TABLE IF NOT EXISTS tblSemesters(
fnkPlanId int(11) NOT NULL,
fldTerm varchar(15) NOT NULL,
fldTermYear int(4) NOT NULL,
fldSemesterCredits int(2) NOT NULL,
CONSTRAINT pmkSemesterId PRIMARY KEY(fnkPlanId,fldTerm,fldTermYear))

CREATE TABLE IF NOT EXISTS tblCourses(
pmkCourseId int(11) NOT NULL AUTO_INCREMENT,
fldSubject varchar(20) NOT NULL,
fldCourseNumber int(4) NOT NULL,
fldCourseCredits int(2) NOT NULL,
PRIMARY KEY(pmkCourseId))

CREATE TABLE IF NOT EXISTS tblSemestersCourses(
fldRequirement varchar(20) NOT NULL,
fnkCourseId int(11) NOT NULL,
fnkPlanId int(11) NOT NULL,
fnkTerm varchar(15) NOT NULL,
fnkTermYear int(4) NOT NULL,
CONSTRAINT pmkSemesterCourseId PRIMARY KEY(fnkCourseId,fnkPlanId,fnkTerm,fnkTermYear))