/*
SQLyog - Free MySQL GUI v5.02
Host - 5.0.18-nt : Database - tcshl
*********************************************************************
Server version : 5.0.18-nt
*/


create database if not exists `tcshl`;

USE `tcshl`;

SET FOREIGN_KEY_CHECKS=0;

/*Table structure for table `announcements` */

DROP TABLE IF EXISTS `announcements`;

CREATE TABLE `announcements` (
  `announceId` int(5) unsigned NOT NULL auto_increment,
  `announceTitle` varchar(80) NOT NULL,
  `announcement` text NOT NULL,
  `announceBeginDate` int(11) NOT NULL,
  `announceEndDate` int(11) NOT NULL,
  `userID` int(6) unsigned NOT NULL,
  PRIMARY KEY  (`announceId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `draft` */

DROP TABLE IF EXISTS `draft`;

CREATE TABLE `draft` (
  `seasonId` int(10) unsigned NOT NULL,
  `playerId` int(11) NOT NULL,
  `teamId` int(11) NOT NULL,
  `round` tinyint(4) NOT NULL,
  PRIMARY KEY  (`seasonId`,`playerId`,`teamId`,`round`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `dst` */

DROP TABLE IF EXISTS `dst`;

CREATE TABLE `dst` (
  `year` int(4) unsigned NOT NULL,
  `startDate` timestamp NULL default '0000-00-00 00:00:00',
  `endDate` timestamp NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`year`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `game` */

DROP TABLE IF EXISTS `game`;

CREATE TABLE `game` (
  `seasonId` int(3) unsigned NOT NULL,
  `gameID` int(6) unsigned NOT NULL auto_increment,
  `gameTime` int(11) NOT NULL,
  `gameGuestTeam` int(3) NOT NULL,
  `gameGuestScore` tinyint(2) unsigned default NULL,
  `gameHomeTeam` int(3) NOT NULL,
  `gameHomeScore` tinyint(2) unsigned default NULL,
  `gameReferee1` int(11) default NULL,
  `gameReferee2` int(11) default NULL,
  `postponed` tinyint(1) NOT NULL default '0',
  `announcementID` int(11) default NULL,
  PRIMARY KEY  (`gameID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `notifylist` */

DROP TABLE IF EXISTS `notifylist`;

CREATE TABLE `notifylist` (
  `playerID` int(3) NOT NULL,
  `teamID` int(3) NOT NULL,
  PRIMARY KEY  (`playerID`,`teamID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `player` */

DROP TABLE IF EXISTS `player`;

CREATE TABLE `player` (
  `playerID` int(5) unsigned NOT NULL auto_increment,
  `playerFName` text NOT NULL,
  `playerLName` text NOT NULL,
  `playerSkillLevel` tinyint(1) NOT NULL,
  `registrationId` int(10) unsigned NOT NULL,
  `seasonId` int(3) unsigned NOT NULL,
  `jerseyNumber` tinyint(2) unsigned default NULL,
  PRIMARY KEY  (`playerID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `refereesofseasons` */

DROP TABLE IF EXISTS `refereesofseasons`;

CREATE TABLE `refereesofseasons` (
  `seasonID` int(3) NOT NULL,
  `playerID` int(5) NOT NULL,
  PRIMARY KEY  (`seasonID`,`playerID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `registereduser` */

DROP TABLE IF EXISTS `registereduser`;

CREATE TABLE `registereduser` (
  `userID` int(6) unsigned NOT NULL auto_increment,
  `firstName` varchar(15) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `eMail` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `registeredDate` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `accessLevel` tinyint(1) unsigned NOT NULL default '0',
  `verificationKey` varchar(32) NOT NULL,
  `requestedPlayerStats` tinyint(1) NOT NULL default '0',
  `playerId` int(11) default NULL,
  PRIMARY KEY  (`userID`,`eMail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `registration` */

DROP TABLE IF EXISTS `registration`;

CREATE TABLE `registration` (
  `registrationId` int(10) unsigned NOT NULL auto_increment,
  `seasonId` int(11) NOT NULL,
  `playerId` int(11) default NULL,
  `fName` text NOT NULL,
  `lName` text NOT NULL,
  `addressOne` text NOT NULL,
  `addressTwo` text,
  `city` text NOT NULL,
  `state` text NOT NULL,
  `postalCode` text NOT NULL,
  `eMail` text,
  `position` text NOT NULL,
  `jerseySize` tinytext NOT NULL,
  `jerseyNumberOne` tinyint(2) NOT NULL,
  `jerseyNumberTwo` tinyint(2) NOT NULL,
  `jerseyNumberThree` tinyint(2) NOT NULL,
  `homePhone` text,
  `workPhone` text,
  `cellPhone` text,
  `skillLevel` tinyint(1) NOT NULL default '1',
  `wantToSub` tinyint(1) NOT NULL default '0',
  `subSunday` tinyint(1) NOT NULL default '0',
  `subMonday` tinyint(1) NOT NULL default '0',
  `subTuesday` tinyint(1) NOT NULL default '0',
  `subWednesday` tinyint(1) NOT NULL default '0',
  `subThursday` tinyint(1) NOT NULL default '0',
  `subFriday` tinyint(1) NOT NULL default '0',
  `subSaturday` tinyint(1) NOT NULL default '0',
  `travelingWithWho` tinytext,
  `wantToBeATeamRep` tinyint(1) NOT NULL default '0',
  `wantToBeARef` tinyint(1) NOT NULL default '0',
  `paymentPlan` tinyint(1) NOT NULL default '1',
  `notes` text,
  `registrationApproved` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`registrationId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `rostersofteamsofseasons` */

DROP TABLE IF EXISTS `rostersofteamsofseasons`;

CREATE TABLE `rostersofteamsofseasons` (
  `seasonID` int(3) NOT NULL,
  `teamID` int(3) NOT NULL,
  `playerID` int(5) NOT NULL,
  `jerseyNumber` tinyint(2) unsigned default NULL,
  PRIMARY KEY  (`seasonID`,`teamID`,`playerID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `seasons` */

DROP TABLE IF EXISTS `seasons`;

CREATE TABLE `seasons` (
  `seasonId` int(3) unsigned NOT NULL auto_increment,
  `seasonName` varchar(50) NOT NULL,
  PRIMARY KEY  (`seasonId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `skilllevels` */

DROP TABLE IF EXISTS `skilllevels`;

CREATE TABLE `skilllevels` (
  `skillLevelID` tinyint(1) unsigned NOT NULL auto_increment,
  `skillLevelName` tinytext NOT NULL,
  `skillLevelDescription` tinytext NOT NULL,
  PRIMARY KEY  (`skillLevelID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `sponsors` */

DROP TABLE IF EXISTS `sponsors`;

CREATE TABLE `sponsors` (
  `sponsorID` int(3) unsigned NOT NULL auto_increment,
  `sponsorName` varchar(40) NOT NULL,
  `sponsorImageName` tinytext,
  `sponsorURL` text,
  `sponsorAbout` text,
  PRIMARY KEY  (`sponsorID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `sponsorsofseasons` */

DROP TABLE IF EXISTS `sponsorsofseasons`;

CREATE TABLE `sponsorsofseasons` (
  `seasonID` int(3) unsigned NOT NULL,
  `teamID` int(3) NOT NULL,
  `sponsorID` int(3) unsigned NOT NULL,
  PRIMARY KEY  (`seasonID`,`sponsorID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `teams` */

DROP TABLE IF EXISTS `teams`;

CREATE TABLE `teams` (
  `teamID` int(3) unsigned NOT NULL auto_increment,
  `teamName` varchar(40) NOT NULL,
  PRIMARY KEY  (`teamID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `teamsofseasons` */

DROP TABLE IF EXISTS `teamsofseasons`;

CREATE TABLE `teamsofseasons` (
  `seasonID` int(3) NOT NULL,
  `teamID` int(3) NOT NULL,
  `teamRep` tinyint(1) default NULL,
  PRIMARY KEY  (`seasonID`,`teamID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

SET FOREIGN_KEY_CHECKS=1;
