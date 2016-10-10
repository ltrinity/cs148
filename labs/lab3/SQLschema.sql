CREATE TABLE IF NOT EXISTS tblCourses ( 
pmkCourseId int(11) NOT NULL AUTO_INCREMENT, fldDepartment varchar(5) NULL, 
fldCourseNumber int(11) NULL, fldCourseTitle varchar(250) NULL, 
fldCredits varchar(10) NULL DEFAULT '3',PRIMARY KEY (pmkCourseId)) ENGINE=InnoDB DEFAULT CHARSET=utf8

CREATE TABLE IF NOT EXISTS tblTeachers ( 
pmkNetId varchar(12) NOT NULL, fldLastName varchar(100) NOT NULL, 
fldFirstName varchar(100) NOT NULL, fldEmail varchar(100) NOT NULL, 
PRIMARY KEY (pmkNetId)) ENGINE=InnoDB DEFAULT CHARSET=utf8

CREATE TABLE IF NOT EXISTS tblSections ( 
pmkSectionId int(11) NOT NULL AUTO_INCREMENT, 
fldComputerNumber int(11) NULL, fldSection varchar(3) NULL, 
fldLectureLab varchar(5) NULL, fldCampCode varchar(5) NULL, 
fldMaxEnrollment int(11) NULL, fldCurrentEnrollment int(11) NULL, 
fldStart varchar(11), fldStop varchar(11), fldDays varchar(11) NULL, 
fldCredits_ varchar(15) NULL, fldBuilding varchar(6) NULL, fldRoom varchar(9) NULL, 
fnkCourseId int(11) NOT NULL, fnkTeacherNetId varchar(12) NULL, PRIMARY KEY (pmkSectionId)) 
ENGINE=InnoDB DEFAULT CHARSET=utf8