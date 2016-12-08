CREATE TABLE IF NOT EXISTS tblUsers(
pmkUserId int(11) NOT NULL AUTO_INCREMENT,
fldFirstName varchar(15) NULL,
fldLastName varchar(15) NULL,
fnkFavoriteAnimalName varchar(20) NOT NULL DEFAULT 'tiger',
fldEmail varchar(40) NOT NULL,
fldDateJoined  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
fldLevel int(1) NOT NULL DEFAULT '1',
fldConfirmed int(1) NOT NULL DEFAULT '0',
fldApproved int(1) NOT NULL DEFAULT '0',
PRIMARY KEY (pmkUserId))

CREATE TABLE IF NOT EXISTS tblUsersQuizzes(
fnkUserId int(11) NOT NULL,
fnkQuizId int(11) NOT NULL,
fldNumberCorrect int(3) NOT NULL DEFAULT '0',
fldTotalQuestions int(3) NOT NULL,
CONSTRAINT pmkUsersQuizzesId PRIMARY KEY(fnkUserId,fnkQuizId))

CREATE TABLE IF NOT EXISTS tblQuizzes(
pmkQuizId int(11) NOT NULL AUTO_INCREMENT,
fldDateCreated varchar(20) NOT NULL,
fldQuizName timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (pmkQuizId))

CREATE TABLE IF NOT EXISTS tblQuizzesQuestions(
fnkQuizId int(11) NOT NULL,
fnkQuestionId int(11) NOT NULL,
fnkUserChoseAnimalName varchar(20) NOT NULL,
CONSTRAINT pmkQuizzesQuestionsId PRIMARY KEY(fnkQuizId,fnkQuestionId))

CREATE TABLE IF NOT EXISTS tblQuestions(
pmkQuestionId int(11) NOT NULL AUTO_INCREMENT,
fnkRightAnswerAnimalId varchar(20) NOT NULL,
PRIMARY KEY (pmkQuestionId))

CREATE TABLE IF NOT EXISTS tblQuestionsAnimals(
fnkQuestionId int(11) NOT NULL,
fnkAnimalName varchar(20) NOT NULL,
CONSTRAINT pmkQuestionsAnimalsId PRIMARY KEY(fnkQuestionId))

CREATE TABLE IF NOT EXISTS tblAnimals(
pmkAnimalName varchar(20) NOT NULL,
fldLevel int(1) NOT NULL,
PRIMARY KEY (pmkAnimalName))
