CREATE DATABASE IF NOT EXISTS `college_search`;

USE college_search;

DROP TABLE IF EXISTS `users`; 
CREATE TABLE `users` (
	`ID` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`Email` VARCHAR(100) NOT NULL,
	`Password` CHAR(64) NOT NULL,
	`FirstName` VARCHAR(50) NOT NULL,
	`LastName` VARCHAR(50) DEFAULT NULL,
	PRIMARY KEY (`ID`),
	UNIQUE KEY (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `users_info`;
CREATE TABLE `users_info` (
	`UserID` INT(10) UNSIGNED NOT NULL,
	`GPA` DOUBLE PRECISION(2,1) UNSIGNED DEFAULT NULL,
	`SATMath` SMALLINT(3) UNSIGNED DEFAULT NULL,
	`SATReading` SMALLINT(3) UNSIGNED DEFAULT NULL,
	`ACT` TINYINT(3) UNSIGNED DEFAULT NULL,
	`ZIP` CHAR(5) DEFAULT NULL,
	`HSRank` INT(10) UNSIGNED DEFAULT NULL,
	`State` CHAR(2) DEFAULT NULL,
	`Country` CHAR(2) DEFAULT NULL,
	`Results` SMALLINT(3) UNSIGNED DEFAULT 10,
	PRIMARY KEY (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `institutions`;
CREATE TABLE `institutions` (
	`ID` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`Name` VARCHAR(255) DEFAULT NULL,
	`Address` VARCHAR(255) DEFAULT NULL,
	`City` VARCHAR(50) DEFAULT NULL,
	`State` CHAR(2) DEFAULT NULL,
	`Country` CHAR(2) DEFAULT NULL,
	`Population` INT(10) UNSIGNED DEFAULT NULL,
	`ZIP` CHAR(5) DEFAULT NULL,
	`ClassSize` SMALLINT(5) UNSIGNED DEFAULT NULL,
	`Retention` DOUBLE PRECISION(4,1) UNSIGNED DEFAULT NULL,
	`Image` VARCHAR(255) DEFAULT NULL,
	`Acceptance` DOUBLE PRECISION(4,1) UNSIGNED DEFAULT NULL,
	`Phone` CHAR(13) DEFAULT NULL,
	`Type` ENUM('public', 'private') DEFAULT 'private',
	PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `institutions_scores`;
CREATE TABLE `institutions_scores` (
	`InstID` INT(10) UNSIGNED NOT NULL,
	`Walk` TINYINT(2) UNSIGNED DEFAULT NULL,
	`GPA` DOUBLE PRECISION(2,1) UNSIGNED DEFAULT NULL,
	`SATMath` SMALLINT(3) UNSIGNED DEFAULT NULL,
	`SATReading` SMALLINT(3) UNSIGNED DEFAULT NULL,
	`ACT` TINYINT(2) UNSIGNED DEFAULT NULL,
	PRIMARY KEY (`InstID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `users_favorites`;
CREATE TABLE `users_favorites` (
	`UserID` int(10) NOT NULL,
	`InstID` int(10) NOT NULL,
	PRIMARY KEY (`UserID`, `InstID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
