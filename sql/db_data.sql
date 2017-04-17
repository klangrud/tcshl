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
(1,'2017 - 2018');

/*Data for the table `skilllevels` */

insert into `skilllevels` values 
(1,'Novice','Novice or Beginner.  Has never played before or has played very little.  Normally less than a years worth of experience.'),
(2,'Beginner','Intermediate type of playing level.  About 2-3 years experience.'),
(3,'Intermediate','Intermediate type of playing level.  About 2-3 years experience.'),
(4,'Advanced','Advanced type play level.  3+ years experience.'),
(5,'Elite','Elite type.  Played high school hockey, maybe some college.');

/*Data for the table `dst` */

insert into `dst` values 
(2016,'2016-03-13 07:00:00','2016-11-06 08:00:00'),
(2017,'2017-03-12 07:00:00','2017-11-05 08:00:00'),
(2018,'2018-03-11 07:00:00','2018-11-04 08:00:00'),
(2019,'2019-03-10 07:00:00','2019-11-03 08:00:00');
/*!40000 ALTER TABLE `dst` ENABLE KEYS */;

/*Data for the table `marquee` */

insert into `marquee` values ('Marquee Message');

/*Data for the table `paymentdates` */

insert into `paymentdates` values 
(1,'2017-09-14 07:00:00','2017-10-31 07:00:00','2017-12-15 07:00:00','2018-02-01 07:00:00'),
(2,'2018-09-14 07:00:00','2018-10-31 07:00:00','2018-12-15 07:00:00','2019-02-01 07:00:00');

/*Data for the table `paymentdatesalt` */

insert into `paymentdatesalt` values 
(1,'2017-08-28 07:00:00','2017-11-15 07:00:00','2018-01-15 07:00:00'),
(2,'2018-08-28 07:00:00','2018-11-15 07:00:00','2019-01-15 07:00:00');

/*Data for the table `values` */

insert into `variables` values 
('DRAFT',0),
('MAINTENANCE',0),
('MARQUEE',0),
('REGISTRATION',0),
('SEASON',1);

SET FOREIGN_KEY_CHECKS=1;
