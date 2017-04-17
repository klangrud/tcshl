-- MySQL dump 10.11
--
-- Host:    Database: tcshl
-- ------------------------------------------------------
-- Server version	5.0.91-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

create database if not exists `tcshl`;

USE `tcshl`;

SET FOREIGN_KEY_CHECKS=0;

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `announcements` (
  `announceId` int(5) unsigned NOT NULL auto_increment,
  `announceTitle` varchar(80) NOT NULL,
  `announcement` text NOT NULL,
  `announceBeginDate` int(11) NOT NULL,
  `announceEndDate` int(11) NOT NULL,
  `userID` int(6) unsigned NOT NULL,
  PRIMARY KEY  (`announceId`)
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `awards`
--

DROP TABLE IF EXISTS `awards`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `awards` (
  `awardID` int(10) unsigned NOT NULL auto_increment,
  `seasonID` int(11) NOT NULL default '0',
  `award` varchar(256) NOT NULL,
  `about` text,
  `recipient` varchar(256) NOT NULL,
  `priority` tinyint(4) NOT NULL default '5',
  `image` mediumblob,
  `imageWidth` mediumint(9) default NULL,
  `imageHeight` mediumint(9) default NULL,
  PRIMARY KEY  (`awardID`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `boardmember`
--

DROP TABLE IF EXISTS `boardmember`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `boardmember` (
  `boardMemberID` tinyint(3) unsigned NOT NULL auto_increment,
  `boardMemberFirstName` text NOT NULL,
  `boardMemberLastName` text NOT NULL,
  `boardMemberEmail` varchar(50) default NULL,
  `boardMemberHomePhone` varchar(50) default NULL,
  `boardMemberWorkPhone` varchar(50) default NULL,
  `boardMemberCellPhone` varchar(50) default NULL,
  `boardMemberDuties` text,
  `boardMemberImage` blob,
  `boardMemberImageWidth` int(11) default NULL,
  `boardMemberImageHeight` int(11) default NULL,
  PRIMARY KEY  (`boardMemberID`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `draft`
--

DROP TABLE IF EXISTS `draft`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `draft` (
  `seasonId` int(10) unsigned NOT NULL,
  `playerId` int(11) NOT NULL,
  `teamId` int(11) NOT NULL,
  `round` tinyint(4) NOT NULL,
  PRIMARY KEY  (`seasonId`,`playerId`,`teamId`,`round`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `dst`
--

DROP TABLE IF EXISTS `dst`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `dst` (
  `year` int(4) unsigned NOT NULL,
  `startDate` timestamp NULL default '0000-00-00 00:00:00',
  `endDate` timestamp NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`year`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `emailarchive`
--

DROP TABLE IF EXISTS `emailarchive`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `emailarchive` (
  `eMail` varchar(50) NOT NULL,
  PRIMARY KEY  (`eMail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `game`
--

DROP TABLE IF EXISTS `game`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `game` (
  `seasonId` int(3) unsigned NOT NULL,
  `gameID` int(6) unsigned NOT NULL auto_increment,
  `gameType` varchar(6) NOT NULL default 'season',
  `gameTime` int(11) NOT NULL,
  `gameGuestTeam` int(3) NOT NULL,
  `gameGuestScore` tinyint(2) unsigned default NULL,
  `gameHomeTeam` int(3) NOT NULL,
  `gameHomeScore` tinyint(2) unsigned default NULL,
  `gameReferee1` int(11) default NULL,
  `gameReferee2` int(11) default NULL,
  `gameReferee3` int(11) default NULL,
  `postponed` tinyint(1) NOT NULL default '0',
  `announcementID` int(11) default NULL,
  PRIMARY KEY  (`gameID`),
  KEY `seasonId` (`seasonId`),
  KEY `gameGuestTeam` (`gameGuestTeam`),
  KEY `gameGuestScore` (`gameGuestScore`),
  KEY `gameHomeScore` (`gameHomeScore`),
  KEY `gameTime` (`gameTime`),
  KEY `gameType` (`gameType`)
) ENGINE=InnoDB AUTO_INCREMENT=467 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `goaliestat`
--

DROP TABLE IF EXISTS `goaliestat`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `goaliestat` (
  `gameID` int(6) unsigned NOT NULL,
  `playerID` int(5) unsigned NOT NULL,
  `teamID` int(3) unsigned NOT NULL,
  `shots` int(3) unsigned NOT NULL default '0',
  `goalsagainst` int(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`gameID`,`playerID`,`teamID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `marquee`
--

DROP TABLE IF EXISTS `marquee`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `marquee` (
  `marquee` varchar(256) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `notifylist`
--

DROP TABLE IF EXISTS `notifylist`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `notifylist` (
  `playerID` int(3) NOT NULL,
  `teamID` int(3) NOT NULL,
  PRIMARY KEY  (`playerID`,`teamID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `paymentdates`
--

DROP TABLE IF EXISTS `paymentdates`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `paymentdates` (
  `seasonID` int(11) NOT NULL,
  `paymentOneDate` timestamp NOT NULL default '0000-00-00 00:00:00',
  `paymentTwoDate` timestamp NOT NULL default '0000-00-00 00:00:00',
  `paymentThreeDate` timestamp NOT NULL default '0000-00-00 00:00:00',
  `paymentFourDate` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`seasonID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `paymentdatesalt`
--

DROP TABLE IF EXISTS `paymentdatesalt`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `paymentdatesalt` (
  `seasonID` int(11) NOT NULL,
  `paymentOneDate` timestamp NOT NULL default '0000-00-00 00:00:00',
  `paymentTwoDate` timestamp NOT NULL default '0000-00-00 00:00:00',
  `paymentThreeDate` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`seasonID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `paymentplanfour`
--

DROP TABLE IF EXISTS `paymentplanfour`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `paymentplanfour` (
  `registrationID` int(11) NOT NULL default '0',
  `paymentOneDate` timestamp NULL default NULL,
  `p1_checknum` tinytext,
  `audit1` tinyint(4) default NULL,
  `paymentTwoDate` timestamp NULL default NULL,
  `p2_checknum` tinytext,
  `audit2` tinyint(4) default NULL,
  `paymentThreeDate` timestamp NULL default NULL,
  `p3_checknum` tinytext,
  `audit3` tinyint(4) default NULL,
  `paymentFourDate` timestamp NULL default NULL,
  `p4_checknum` tinytext,
  `audit4` tinyint(4) default NULL,
  PRIMARY KEY  (`registrationID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `paymentplanone`
--

DROP TABLE IF EXISTS `paymentplanone`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `paymentplanone` (
  `registrationID` int(11) NOT NULL default '0',
  `paymentOneDate` timestamp NULL default NULL,
  `p1_checknum` tinytext,
  `audit1` tinyint(4) default NULL,
  PRIMARY KEY  (`registrationID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `paymentplanthree`
--

DROP TABLE IF EXISTS `paymentplanthree`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `paymentplanthree` (
  `registrationID` int(11) NOT NULL default '0',
  `paymentOneDate` timestamp NULL default NULL,
  `p1_checknum` tinytext,
  `audit1` tinyint(4) default NULL,
  `paymentTwoDate` timestamp NULL default NULL,
  `p2_checknum` tinytext,
  `audit2` tinyint(4) default NULL,
  `paymentThreeDate` timestamp NULL default NULL,
  `p3_checknum` tinytext,
  `audit3` tinyint(4) default NULL,
  PRIMARY KEY  (`registrationID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `paymentplantwo`
--

DROP TABLE IF EXISTS `paymentplantwo`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `paymentplantwo` (
  `registrationID` int(11) NOT NULL default '0',
  `paymentOneDate` timestamp NULL default NULL,
  `p1_checknum` tinytext,
  `audit1` tinyint(4) default NULL,
  `paymentTwoDate` timestamp NULL default NULL,
  `p2_checknum` tinytext,
  `audit2` tinyint(4) default NULL,
  PRIMARY KEY  (`registrationID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `player`
--

DROP TABLE IF EXISTS `player`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `player` (
  `playerID` int(5) unsigned NOT NULL auto_increment,
  `playerFName` text NOT NULL,
  `playerLName` text NOT NULL,
  `playerSkillLevel` tinyint(1) NOT NULL,
  `registrationId` int(10) unsigned NOT NULL,
  `seasonId` int(3) unsigned NOT NULL,
  PRIMARY KEY  (`playerID`),
  KEY `seasonId` (`seasonId`)
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `playerstat`
--

DROP TABLE IF EXISTS `playerstat`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `playerstat` (
  `gameID` int(6) unsigned NOT NULL,
  `playerID` int(5) unsigned NOT NULL,
  `teamID` int(3) unsigned NOT NULL,
  `goals` int(3) unsigned NOT NULL default '0',
  `assists` int(3) unsigned NOT NULL default '0',
  `pim` int(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`gameID`,`playerID`,`teamID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `refereesofseasons`
--

DROP TABLE IF EXISTS `refereesofseasons`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `refereesofseasons` (
  `seasonID` int(3) NOT NULL,
  `playerID` int(5) NOT NULL,
  `level` tinyint(4) NOT NULL,
  PRIMARY KEY  (`seasonID`,`playerID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `registereduser`
--

DROP TABLE IF EXISTS `registereduser`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `registereduser` (
  `userID` int(6) unsigned NOT NULL auto_increment,
  `firstName` varchar(15) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `eMail` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `registeredDate` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `accessLevel` tinyint(1) unsigned NOT NULL default '0',
  `verificationKey` varchar(32) NOT NULL,
  `requestedPlayerStats` tinyint(1) NOT NULL default '0',
  `playerId` int(11) default NULL,
  PRIMARY KEY  (`userID`,`eMail`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `registration`
--

DROP TABLE IF EXISTS `registration`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
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
  `drilLeague` tinyint(1) NOT NULL default '1',
  `payToday` tinyint(1) NOT NULL default '0',
  `usaHockeyMembership` tinytext,
  PRIMARY KEY  (`registrationId`)
) ENGINE=InnoDB AUTO_INCREMENT=407 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `rostersofteamsofseasons`
--

DROP TABLE IF EXISTS `rostersofteamsofseasons`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `rostersofteamsofseasons` (
  `seasonID` int(3) NOT NULL,
  `teamID` int(3) NOT NULL,
  `playerID` int(5) NOT NULL,
  `jerseyNumber` tinyint(2) unsigned default NULL,
  PRIMARY KEY  (`seasonID`,`teamID`,`playerID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `seasons`
--

DROP TABLE IF EXISTS `seasons`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `seasons` (
  `seasonId` int(3) unsigned NOT NULL auto_increment,
  `seasonName` varchar(50) NOT NULL,
  PRIMARY KEY  (`seasonId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `skilllevels`
--

DROP TABLE IF EXISTS `skilllevels`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `skilllevels` (
  `skillLevelID` tinyint(1) unsigned NOT NULL auto_increment,
  `skillLevelChar` tinytext NOT NULL,
  `skillLevelName` tinytext NOT NULL,
  `skillLevelDescription` tinytext NOT NULL,
  PRIMARY KEY  (`skillLevelID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `sponsors`
--

DROP TABLE IF EXISTS `sponsors`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sponsors` (
  `sponsorID` int(3) unsigned NOT NULL auto_increment,
  `sponsorName` varchar(75) NOT NULL,
  `sponsorLogo` mediumblob,
  `sponsorLogoWidth` mediumint(9) default NULL,
  `sponsorLogoHeight` mediumint(9) default NULL,
  `sponsorURL` text,
  `sponsorAbout` text,
  PRIMARY KEY  (`sponsorID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `sponsorsofseasons`
--

DROP TABLE IF EXISTS `sponsorsofseasons`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sponsorsofseasons` (
  `seasonID` int(3) unsigned NOT NULL,
  `teamID` int(3) NOT NULL,
  `sponsorID` int(3) unsigned NOT NULL,
  PRIMARY KEY  (`seasonID`,`teamID`,`sponsorID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `teams` (
  `teamID` int(3) unsigned NOT NULL auto_increment,
  `teamShortName` varchar(15) NOT NULL,
  `teamName` varchar(50) NOT NULL,
  `teamFGColor` varchar(6) default 'FFFFFF',
  `teamBGColor` varchar(6) default '000000',
  PRIMARY KEY  (`teamID`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `teamsofseasons`
--

DROP TABLE IF EXISTS `teamsofseasons`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `teamsofseasons` (
  `seasonID` int(3) NOT NULL,
  `teamID` int(3) NOT NULL,
  `teamRep` int(3) default NULL,
  PRIMARY KEY  (`seasonID`,`teamID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `variables`
--

DROP TABLE IF EXISTS `variables`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `variables` (
  `variable` varchar(25) NOT NULL,
  `value` tinyint(1) NOT NULL,
  PRIMARY KEY  (`variable`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

SET FOREIGN_KEY_CHECKS=1;


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-09-13  8:00:15
