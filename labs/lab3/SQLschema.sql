            CREATE TABLE IF NOT EXISTS tblTeachers (
            pmkNetId varchar(12) NOT NULL,  
            fldLastName varchar(100) NOT NULL,
            fldFirstName varchar(100) NOT NULL,
            fldEmail varchar(100) NOT NULL,
            PRIMARY KEY (pmkNetId)
            );

            CREATE TABLE IF NOT EXISTS tblCourses (
            pmkCourseId int(11) NOT NULL AUTO_INCREMENT,
            fldCourseNumber int(11) NOT NULL,
            fldCourseName varchar(250) NOT NULL,
            fldDepartment varchar(5) NOT NULL,
            fldCredits varchar(100) NOT NULL DEFAULT "3",
            PRIMARY KEY (pmkCourseId)
            );
            CREATE TABLE IF NOT EXISTS tblTeachersCourses (
            pmkTeachersCoursesId int(20) NOT NULL AUTO_INCREMENT,
            fnkNetId varchar(12) NOT NULL,
            fnkCourseId int(11) NOT NULL,
            fldCompNumb int(10) NOT NULL,
            fldSection varchar(5) NOT NULL,
            fldLecLab varchar(10) NOT NULL,
            fldCampCode varchar(10) NOT NULL,
            fldMaxEnrollment int(15) NOT NULL,
            fldCurrentEnrollment int(15) NOT NULL,
            fldStartTime varchar(20) NOT NULL,
            fldEndTime varchar(20) NOT NULL DEFAULT "TBA",
            fldDays varchar(20) NOT NULL DEFAULT "TBA",
            fldBldg varchar(20) NOT NULL DEFAULT "TBA",
            fldRoom varchar(20) NOT NULL DEFAULT "TBA",
            PRIMARY KEY (pmkTeachersCoursesId)
            );