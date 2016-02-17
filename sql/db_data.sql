/*
SQLyog - Free MySQL GUI v5.02
Host - 5.0.18-nt : Database - tcshl
*********************************************************************
Server version : 5.0.18-nt
*/


create database if not exists `tcshl`;

USE `tcshl`;

SET FOREIGN_KEY_CHECKS=0;

/*Data for the table `registereduser` */

insert into `registereduser` values 
(1,'Admin','Admin','admin@example.com','21232f297a57a5a743894a0e4a801fc3','2007-08-30 12:40:57',2,'1e4113dca6e9c6bd7cb09040cc18f05e',0,NULL);

/*Data for the table `seasons` */

insert into `seasons` values 
(1,'2007 - 2008');

/*Data for the table `skilllevels` */

insert into `skilllevels` values 
(1,'Novice','Novice or Beginner.  Has never played before or has played very little.  Normally less than a years worth of experience.'),
(2,'Beginner','Intermediate type of playing level.  About 2-3 years experience.'),
(3,'Intermediate','Intermediate type of playing level.  About 2-3 years experience.'),
(4,'Advanced','Advanced type play level.  3+ years experience.'),
(5,'Elite','Elite type.  Played high school hockey, maybe some college.');

SET FOREIGN_KEY_CHECKS=1;
