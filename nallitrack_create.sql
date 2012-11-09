-- ******************************************************
--	nallitrack.sql
--
--	Loader script for nallitrack
--
-- ******************************************************

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';
-- DROP SCHEMA IF EXISTS `nallimc1_nallitrack` ;
-- CREATE SCHEMA IF NOT EXISTS `nallimc1_nallitrack` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
-- USE `nallimc1_nallitrack` ;

-- ******************************************************
-- DROP TABLES
-- ******************************************************
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblAthleteEvents` ;
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblPB`;
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblRelayTeamMembers` ;
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblResults` ;
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblRelayTeams` ;
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblSeasonSchedules` ;
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblMeetParticipants` ;
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblAthletes` ;
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblOrganizations` ;
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`user_autologin` ;
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`login_attempts` ;
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`ci_sessions` ;
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblScheduleEntries` ;
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblMeetEvents` ;
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblAllEvents` ;
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblDivisions` ;
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblDates` ;
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblMeets` ;
-- DROP TABLE IF EXISTS `nallimc1_nallitrack`.`user_profiles` ;
-- DROP TABLE IF EXISTS `nallimc1_nallitrack`.`users` ;

-- -----------------------------------------------------
-- Table `nallimc1_nallitrack`.`users`
-- -----------------------------------------------------
/*
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`users` ;

CREATE  TABLE IF NOT EXISTS `nallimc1_nallitrack`.`users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `password` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `email` VARCHAR(100) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `activated` TINYINT(1) NOT NULL DEFAULT '1' ,
  `banned` TINYINT(1) NOT NULL DEFAULT '0' ,
  `ban_reason` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NULL DEFAULT NULL ,
  `new_password_key` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NULL DEFAULT NULL ,
  `new_password_requested` DATETIME NULL DEFAULT NULL ,
  `new_email` VARCHAR(100) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NULL DEFAULT NULL ,
  `new_email_key` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NULL DEFAULT NULL ,
  `last_ip` VARCHAR(40) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `last_login` DATETIME NOT NULL ,
  `created` DATETIME NOT NULL ,
  `modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 3101
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;
*/

-- -----------------------------------------------------
-- Table `nallimc1_nallitrack`.`tblMeets`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblMeets` ;

CREATE  TABLE IF NOT EXISTS `nallimc1_nallitrack`.`tblMeets` (
  `meetID` INT(11) NOT NULL AUTO_INCREMENT ,
  `user_id` INT(11) NOT NULL ,
  `meetTitle` VARCHAR(90) NULL ,
  `meetType` VARCHAR(4) NULL ,
  `venue` VARCHAR(60) NULL ,
  `address1` VARCHAR(45) NULL ,
  `address2` VARCHAR(45) NULL ,
  `city` VARCHAR(45) NULL ,
  `state` VARCHAR(2) NULL ,
  `zip` VARCHAR(5) NULL ,
  `country` VARCHAR(2) NULL ,
  `contactName` VARCHAR(45) NULL ,
  `contactPhone` VARCHAR(15) NULL ,
  `contactEmail` VARCHAR(45) NULL ,
  `scores` TEXT NULL ,
  `participantInfo` TEXT NULL ,
  `spectatorInfo` TEXT NULL ,
  `points1st` INT NULL ,
  `points2nd` INT NULL ,
  `points3rd` INT NULL ,
  `points4th` INT NULL ,
  `points5th` INT NULL ,
  `points6th` INT NULL ,
  `points7th` INT NULL ,
  `points8th` INT NULL ,
  `points9th` INT NULL ,
  `points10th` INT NULL ,
  `published` TINYINT(1) NULL ,
  `showTimeColumn` TINYINT(1) NULL ,
  PRIMARY KEY (`meetID`) ,
  INDEX `state` (`state` ASC) ,
  INDEX `fk_user_id_tblMeets` (`user_id` ASC) ,
  CONSTRAINT `fk_user_id_tblMeets`
    FOREIGN KEY (`user_id` )
    REFERENCES `nallimc1_nallitrack`.`users` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 5101
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;


-- -----------------------------------------------------
-- Table `nallimc1_nallitrack`.`tblDates`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblDates` ;

CREATE  TABLE IF NOT EXISTS `nallimc1_nallitrack`.`tblDates` (
  `meetID` INT(11) NOT NULL ,
  `day` INT(11) NOT NULL ,
  `startDate` DATE NULL ,
  `startTime` TIME NULL ,
  `startTimeTE` TIME NULL ,
  `startTimeFE` TIME NULL ,
  PRIMARY KEY (`meetID`, `day`) ,
  INDEX `fk_meetID_tblDates` (`meetID` ASC) ,
  INDEX `startDate` (`startDate` ASC) ,
  CONSTRAINT `fk_meetID_tblDates`
    FOREIGN KEY (`meetID` )
    REFERENCES `nallimc1_nallitrack`.`tblMeets` (`meetID` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;


-- -----------------------------------------------------
-- Table `nallimc1_nallitrack`.`tblDivisions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblDivisions` ;

CREATE  TABLE IF NOT EXISTS `nallimc1_nallitrack`.`tblDivisions` (
  `meetID` INT(11) NOT NULL ,
  `divisionID` INT(11) NOT NULL ,
  `gender` VARCHAR(10) NOT NULL ,
  `description` VARCHAR(45) NULL ,
  PRIMARY KEY (`divisionID`, `meetID`) ,
  INDEX `fk_meetID_tblDivisions` (`meetID` ASC) ,
  CONSTRAINT `fk_meetID_tblDivisions`
    FOREIGN KEY (`meetID` )
    REFERENCES `nallimc1_nallitrack`.`tblMeets` (`meetID` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;


-- -----------------------------------------------------
-- Table `nallimc1_nallitrack`.`tblAllEvents`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblAllEvents` ;

CREATE  TABLE IF NOT EXISTS `nallimc1_nallitrack`.`tblAllEvents` (
  `eventID` VARCHAR(3) NOT NULL ,
  `order` INT(11) NULL ,
  `eventName` VARCHAR(30) NULL ,
  `eventCategory` VARCHAR(15) NULL ,
  `subCategory` VARCHAR(15) NULL ,
  `forMen` BINARY NULL ,
  `forWomen` BINARY NULL ,
  `forIndoorSeason` BINARY NULL ,
  `forOutdoorSeason` BINARY NULL ,
  `allocatedTime` INT(11) NULL ,
  PRIMARY KEY (`eventID`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;


-- -----------------------------------------------------
-- Table `nallimc1_nallitrack`.`tblMeetEvents`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblMeetEvents` ;

CREATE  TABLE IF NOT EXISTS `nallimc1_nallitrack`.`tblMeetEvents` (
  `meetid` INT(11) NOT NULL ,
  `eventid` VARCHAR(3) NOT NULL ,
  PRIMARY KEY (`meetid`, `eventid`) ,
  INDEX `fk_eventID_tblMeetEvents` (`eventid` ASC) ,
  CONSTRAINT `fk_meetID_tblMeetEvents`
    FOREIGN KEY (`meetid` )
    REFERENCES `nallimc1_nallitrack`.`tblMeets` (`meetID` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_eventID_tblMeetEvents`
    FOREIGN KEY (`eventid` )
    REFERENCES `nallimc1_nallitrack`.`tblAllEvents` (`eventID` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;


-- -----------------------------------------------------
-- Table `nallimc1_nallitrack`.`tblScheduleEntries`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblScheduleEntries` ;

CREATE  TABLE IF NOT EXISTS `nallimc1_nallitrack`.`tblScheduleEntries` (
  `seID` INT(11) NOT NULL AUTO_INCREMENT ,
  `meetID` INT(11) NOT NULL ,
  `day` INT(11) NULL ,
  `eventOrder` INT(11) NULL ,
  `allocatedTime` INT(11) NULL ,
  `eventID` VARCHAR(3) NULL ,
  `divisionID` INT(11) NOT NULL ,
  `heatDesc` VARCHAR(30) NULL ,
  `seSummary` TEXT NULL ,
  PRIMARY KEY (`seID`) ,
  INDEX `fk_meetid_divisionid_tblSE` (`meetID` ASC, `divisionID` ASC) ,
  INDEX `fk_meetid_day_tblSE` (`meetID` ASC, `day` ASC) ,
  INDEX `fk_meetid_eventid_tblSE` (`meetID` ASC, `eventID` ASC) ,
  CONSTRAINT `fk_meetid_divisionid_tblSE`
    FOREIGN KEY (`meetID` , `divisionID` )
    REFERENCES `nallimc1_nallitrack`.`tblDivisions` (`meetID` , `divisionID` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_meetid_day_tblSE`
    FOREIGN KEY (`meetID` , `day` )
    REFERENCES `nallimc1_nallitrack`.`tblDates` (`meetID` , `day` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_meetid_eventid_tblSE`
    FOREIGN KEY (`meetID` , `eventID` )
    REFERENCES `nallimc1_nallitrack`.`tblMeetEvents` (`meetid` , `eventid` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 7101
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;


-- -----------------------------------------------------
-- Table `nallimc1_nallitrack`.`ci_sessions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`ci_sessions` ;

CREATE  TABLE IF NOT EXISTS `nallimc1_nallitrack`.`ci_sessions` (
  `session_id` VARCHAR(40) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL DEFAULT '0' ,
  `ip_address` VARCHAR(16) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL DEFAULT '0' ,
  `user_agent` VARCHAR(150) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `last_activity` INT(10) UNSIGNED NOT NULL DEFAULT '0' ,
  `user_data` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  PRIMARY KEY (`session_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;


-- -----------------------------------------------------
-- Table `nallimc1_nallitrack`.`login_attempts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`login_attempts` ;

CREATE  TABLE IF NOT EXISTS `nallimc1_nallitrack`.`login_attempts` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `ip_address` VARCHAR(40) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `login` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;


-- -----------------------------------------------------
-- Table `nallimc1_nallitrack`.`user_autologin`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`user_autologin` ;

CREATE  TABLE IF NOT EXISTS `nallimc1_nallitrack`.`user_autologin` (
  `key_id` CHAR(32) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `user_id` INT(11) NOT NULL DEFAULT '0' ,
  `user_agent` VARCHAR(150) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `last_ip` VARCHAR(40) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `last_login` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
  PRIMARY KEY (`key_id`, `user_id`) ,
  INDEX `fk_user_id_user_autologin` (`user_id` ASC) ,
  CONSTRAINT `fk_user_id_user_autologin`
    FOREIGN KEY (`user_id` )
    REFERENCES `nallimc1_nallitrack`.`users` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;


-- -----------------------------------------------------
-- Table `nallimc1_nallitrack`.`user_profiles`
-- -----------------------------------------------------
/*
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`user_profiles` ;

CREATE  TABLE IF NOT EXISTS `nallimc1_nallitrack`.`user_profiles` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `user_id` INT(11) NOT NULL ,
  `orgName` VARCHAR(45) NULL ,
  `type` VARCHAR(2) NULL ,
  `mascot` VARCHAR(45) NULL ,
  `venue` VARCHAR(60) NULL ,
  `address1` VARCHAR(45) NULL ,
  `address2` VARCHAR(45) NULL ,
  `city` VARCHAR(45) NULL ,
  `state` VARCHAR(2) NULL ,
  `zip` VARCHAR(5) NULL ,
  `country` VARCHAR(2) NULL ,
  `contactName` VARCHAR(45) NULL ,
  `contactPhone` VARCHAR(12) NULL ,
  `contactEmail` VARCHAR(45) NULL ,
  `website` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_user_id_user_profiles` (`user_id` ASC) ,
  CONSTRAINT `fk_user_id_user_profiles`
    FOREIGN KEY (`user_id` )
    REFERENCES `nallimc1_nallitrack`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;
*/


-- -----------------------------------------------------
-- Table `nallimc1_nallitrack`.`tblOrganizations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblOrganizations` ;

CREATE  TABLE IF NOT EXISTS `nallimc1_nallitrack`.`tblOrganizations` (
  `teamid` INT(11) NOT NULL AUTO_INCREMENT ,
  `user_id` INT(11) NULL ,
  `orgName` VARCHAR(45) NULL ,
  `type` VARCHAR(2) NULL ,
  `mascot` VARCHAR(45) NULL ,
  `venue` VARCHAR(60) NULL ,
  `address1` VARCHAR(45) NULL ,
  `address2` VARCHAR(45) NULL ,
  `city` VARCHAR(45) NULL ,
  `state` VARCHAR(2) NULL ,
  `zip` VARCHAR(5) NULL ,
  `country` VARCHAR(2) NULL ,
  `contactName` VARCHAR(45) NULL ,
  `contactPhone` VARCHAR(12) NULL ,
  `contactEmail` VARCHAR(45) NULL ,
  `website` VARCHAR(90) NULL ,
  PRIMARY KEY (`teamid`) ,
  INDEX `fk_user_id_tblOrganizations` (`user_id` ASC) ,
  CONSTRAINT `fk_user_id_tblOrganizations`
    FOREIGN KEY (`user_id` )
    REFERENCES `nallimc1_nallitrack`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 9101;


-- -----------------------------------------------------
-- Table `nallimc1_nallitrack`.`tblAthletes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblAthletes` ;

CREATE  TABLE IF NOT EXISTS `nallimc1_nallitrack`.`tblAthletes` (
  `athleteid` INT(11) NOT NULL AUTO_INCREMENT ,
  `teamid` INT(11) NOT NULL ,
  `firstName` VARCHAR(20) NULL ,
  `lastName` VARCHAR(20) NULL ,
  `gender` VARCHAR(1) NULL ,
  `dob` DATE NULL ,
  `academicYear` VARCHAR(10) NULL ,
  `contactEmail` VARCHAR(45) NULL ,
  `contactPhone` VARCHAR(12) NULL ,
  `alternateContact` VARCHAR(45) NULL ,
  `alternateEmail` VARCHAR(45) NULL ,
  `alternatePhone` VARCHAR(12) NULL ,
  `relationship` VARCHAR(20) NULL ,  
  `published` TINYINT(1) NULL ,
  PRIMARY KEY (`athleteid`) ,
  INDEX `fk_teamid_tblAthletes` (`teamid` ASC) ,
  CONSTRAINT `fk_teamid_tblAthletes`
    FOREIGN KEY (`teamid` )
    REFERENCES `nallimc1_nallitrack`.`tblOrganizations` (`teamid` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nallimc1_nallitrack`.`tblMeetParticipants`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblMeetParticipants` ;

CREATE  TABLE IF NOT EXISTS `nallimc1_nallitrack`.`tblMeetParticipants` (
  `meetid` INT(11) NOT NULL ,
  `athleteid` INT(11) NOT NULL ,
  `participantNo` VARCHAR(10) NULL ,
  PRIMARY KEY (`meetid`, `athleteid`) ,
  INDEX `fk_meetid_tblMeetParticipants` (`meetid` ASC) ,
  INDEX `fk_athleteid_tblMeetParticipants` (`athleteid` ASC) ,
  CONSTRAINT `fk_meetid_tblMeetParticipants`
    FOREIGN KEY (`meetid` )
    REFERENCES `nallimc1_nallitrack`.`tblMeets` (`meetID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_athleteid_tblMeetParticipants`
    FOREIGN KEY (`athleteid` )
    REFERENCES `nallimc1_nallitrack`.`tblAthletes` (`athleteid` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nallimc1_nallitrack`.`tblSeasonSchedules`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblSeasonSchedules` ;

CREATE  TABLE IF NOT EXISTS `nallimc1_nallitrack`.`tblSeasonSchedules` (
  `teamid` INT(11) NOT NULL ,
  `meetid` INT(11) NOT NULL ,
  PRIMARY KEY (`meetid`, `teamid`) ,
  INDEX `fk_meetid_tblSeasonSched` (`meetid` ASC) ,
  INDEX `fk_teamid_tblSeasonSched` (`teamid` ASC) ,
  CONSTRAINT `fk_meetid_tblSeasonSched`
    FOREIGN KEY (`meetid` )
    REFERENCES `nallimc1_nallitrack`.`tblMeets` (`meetID` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_teamid_tblSeasonSched`
    FOREIGN KEY (`teamid` )
    REFERENCES `nallimc1_nallitrack`.`tblOrganizations` (`teamid` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nallimc1_nallitrack`.`tblRelayTeams`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblRelayTeams` ;

CREATE  TABLE IF NOT EXISTS `nallimc1_nallitrack`.`tblRelayTeams` (
  `relayteamid` INT(11) NOT NULL ,
  `meetid` INT(11) NULL ,
  `teamid` INT(11) NULL ,
  PRIMARY KEY (`relayteamid`) ,
  INDEX `fk_teamid_meet_id_tblRelayTeams` (`meetid` ASC, `teamid` ASC) ,
  CONSTRAINT `fk_teamid_meet_id_tblRelayTeams`
    FOREIGN KEY (`meetid` )
    REFERENCES `nallimc1_nallitrack`.`tblSeasonSchedules` (`meetid` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nallimc1_nallitrack`.`tblResults`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblResults` ;

CREATE  TABLE IF NOT EXISTS `nallimc1_nallitrack`.`tblResults` (
  `resultid` INT NOT NULL ,
  `seid` INT(11) NULL ,
  `meetid` INT(11) NULL ,
  `athleteid` INT(11) NULL ,
  `relayteamid` INT(11) NULL ,
  `lane` INT NULL ,
  `performance` FLOAT NULL ,
  PRIMARY KEY (`resultid`) ,
  INDEX `fk_seid_tblresults` (`seid` ASC) ,
  INDEX `fk_meetid_athleteid_tblresults` (`meetid` ASC, `athleteid` ASC) ,
  INDEX `fk_relayteamid_tblresults` (`relayteamid` ASC) ,
  CONSTRAINT `fk_seid_tblresults`
    FOREIGN KEY (`seid` )
    REFERENCES `nallimc1_nallitrack`.`tblScheduleEntries` (`seID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_meetid_athleteid_tblresults`
    FOREIGN KEY (`meetid` , `athleteid` )
    REFERENCES `nallimc1_nallitrack`.`tblMeetParticipants` (`meetid` , `athleteid` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_relayteamid_tblresults`
    FOREIGN KEY (`relayteamid` )
    REFERENCES `nallimc1_nallitrack`.`tblRelayTeams` (`relayteamid` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nallimc1_nallitrack`.`tblRelayTeamMembers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblRelayTeamMembers` ;

CREATE  TABLE IF NOT EXISTS `nallimc1_nallitrack`.`tblRelayTeamMembers` (
  `relayteamid` INT(11) NOT NULL ,
  `leg` INT NOT NULL ,
  `meetid` INT(11) NULL ,
  `athleteid` INT(11) NULL ,
  `split` FLOAT NULL ,
  PRIMARY KEY (`relayteamid`, `leg`) ,
  INDEX `fk_relayteamid_tblRelayTeamMembers` (`relayteamid` ASC) ,
  CONSTRAINT `fk_relayteamid_tblRelayTeamMembers`
    FOREIGN KEY (`relayteamid` )
    REFERENCES `nallimc1_nallitrack`.`tblRelayTeams` (`relayteamid` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `nallimc1_nallitrack`.`tblPB`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblPB` ;

CREATE  TABLE IF NOT EXISTS `nallimc1_nallitrack`.`tblPB` (
  `athleteid` INT(11) NOT NULL ,
  `eventID` VARCHAR(3) NOT NULL ,
  `performance` VARCHAR(45) NULL ,
  PRIMARY KEY (`athleteid`, `eventID`) ,
  INDEX `fk_athleteid_tbPB` (`athleteid` ASC) ,
  INDEX `fk_eventID_tblPB` (`eventID` ASC) ,
  CONSTRAINT `fk_athleteid_tbPB`
    FOREIGN KEY (`athleteid` )
    REFERENCES `nallimc1_nallitrack`.`tblAthletes` (`athleteid` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_eventID_tblPB`
    FOREIGN KEY (`eventID` )
    REFERENCES `nallimc1_nallitrack`.`tblAllEvents` (`eventID` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `nallimc1_nallitrack`.`tblAthleteEvents`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nallimc1_nallitrack`.`tblAthleteEvents` ;

CREATE  TABLE IF NOT EXISTS `nallimc1_nallitrack`.`tblAthleteEvents` (
  `athleteid` INT(11) NOT NULL ,
  `eventID` VARCHAR(3) NOT NULL ,
  PRIMARY KEY (`athleteid`, `eventID`) ,
  INDEX `fk_athleteid_tblAthleteEvents` (`athleteid` ASC) ,
  INDEX `fk_eventID_tblAthleteEvents` (`eventID` ASC) ,
  CONSTRAINT `fk_athleteid_tblAthleteEvents`
    FOREIGN KEY (`athleteid` )
    REFERENCES `nallimc1_nallitrack`.`tblAthletes` (`athleteid` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_eventID_tblAthleteEvents`
    FOREIGN KEY (`eventID` )
    REFERENCES `nallimc1_nallitrack`.`tblAllEvents` (`eventID` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
