-- Skill Finder SQL Dump 
--
-- Host: localhost
-- Generation Date: Jan 10, 2018 at 12:39 PM
-- MySQL Version: 5.7.11-log
-- PHP Version: 7.1.10

DROP TABLE IF EXISTS `job_applications`;

CREATE ALGORITHM=UNDEFINED DEFINER=`skill_finder`@`localhost` SQL SECURITY DEFINER VIEW `job_applications` AS select concat_ws(', ',`js`.`first_name`,`js`.`last_name`) AS `applicant`,`ja`.`date_applied` AS `date_applied`,`j`.`job_code` AS `job_code`,`j`.`job_description` AS `job_description` from ((`tbljob_applications` `ja` join `tbljobs` `j` on((`ja`.`job` = `j`.`job_id`))) join `tbljob_seekers` `js` on(`js`.`job_seeker_id`));

INSERT INTO `job_applications` ( `applicant`, `date_applied`, `job_code`, `job_description`) VALUES
('Douglas, Nhunzvi','2018-01-10 11:53:19','7YTOEGRFEG','Senior Web Developer'),
('Douglas, Nhunzvi','2018-01-10 11:51:18','D77D1HYLSF','It Manager');

-- ------------------------------------------------ 

DROP TABLE IF EXISTS `tbljob_applications`;

CREATE TABLE IF NOT EXISTS `tbljob_applications` (
  `application_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `job` bigint(20) unsigned NOT NULL,
  `job_seeker` int(11) unsigned NOT NULL,
  `date_applied` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`application_id`),
  KEY `job` (`job`),
  KEY `job_seeker` (`job_seeker`),
  CONSTRAINT `tbljob_applications_ibfk_1` FOREIGN KEY (`job`) REFERENCES `tbljobs` (`job_id`),
  CONSTRAINT `tbljob_applications_ibfk_2` FOREIGN KEY (`job_seeker`) REFERENCES `tbljob_seekers` (`job_seeker_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO `tbljob_applications` ( `application_id`, `job`, `job_seeker`, `date_applied`) VALUES
(2,6,2890,'2018-01-10 11:51:18'),
(3,5,2890,'2018-01-10 11:53:19');

-- ------------------------------------------------ 

DROP TABLE IF EXISTS `tbljob_seekers`;

CREATE TABLE IF NOT EXISTS `tbljob_seekers` (
  `job_seeker_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` char(60) NOT NULL,
  `gender` enum('Female','Male') NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` text NOT NULL,
  `member_pass` char(60) NOT NULL,
  `date_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`job_seeker_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2891 DEFAULT CHARSET=utf8;

INSERT INTO `tbljob_seekers` ( `job_seeker_id`, `first_name`, `last_name`, `email`, `gender`, `date_of_birth`, `address`, `member_pass`, `date_registered`) VALUES
(2890,'Douglas','Nhunzvi','dinhunzvi@live.com','Male','1986-06-06','7 Chedgelow Road\r\nLogan Park \r\nHatfield \r\nHarare','$2y$10$IuuMLLT0SrZkqlLdEXfQx.viQA1H/8uiyHY5eFHENCmAVDIIn5l/2','2018-01-10 10:19:49');

-- ------------------------------------------------ 

DROP TABLE IF EXISTS `tbljobs`;

CREATE TABLE IF NOT EXISTS `tbljobs` (
  `job_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `job_code` char(10) NOT NULL,
  `job_description` varchar(100) NOT NULL,
  `job_qualifications` text NOT NULL,
  `job_skills` text NOT NULL,
  `salary` decimal(8,2) unsigned NOT NULL,
  `job_status` enum('Open','Closed') NOT NULL DEFAULT 'Open',
  `job_creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`job_id`),
  UNIQUE KEY `job_code` (`job_code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

INSERT INTO `tbljobs` ( `job_id`, `job_code`, `job_description`, `job_qualifications`, `job_skills`, `salary`, `job_status`, `job_creation_date`) VALUES
(5,'7YTOEGRFEG','Senior Web Developer','Bsc Information Systems or equivalent','Web Designing, Web Development, CSS, HTML, Bootstrap, Database Design And Development',800.00,'Open','2018-01-10 10:54:34'),
(6,'D77D1HYLSF','It Manager','Msc Computer science or equivalent','Drafting It Policies, Managing Email Server, Good Planner, Ability To Repair Hardware',1500.00,'Open','2018-01-10 11:03:02');

-- ------------------------------------------------ 

DROP TABLE IF EXISTS `tblresumes`;

CREATE TABLE IF NOT EXISTS `tblresumes` (
  `resume_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `job_seeker` int(11) unsigned NOT NULL,
  `resume_document` char(60) NOT NULL,
  PRIMARY KEY (`resume_id`),
  UNIQUE KEY `resume_document` (`resume_document`),
  KEY `job_seeker` (`job_seeker`),
  CONSTRAINT `tblresumes_ibfk_1` FOREIGN KEY (`job_seeker`) REFERENCES `tbljob_seekers` (`job_seeker_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `tblresumes` ( `resume_id`, `job_seeker`, `resume_document`) VALUES
(1,2890,'2ukfrcxymnadodtomeyrgzsns2kh3qdtbzkzlutnbirwoxip1xsiq6h.pdf');

-- ------------------------------------------------ 

DROP TABLE IF EXISTS `tblusers`;

CREATE TABLE IF NOT EXISTS `tblusers` (
  `user_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(60) NOT NULL,
  `user_pass` char(60) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

INSERT INTO `tblusers` ( `user_id`, `first_name`, `last_name`, `email`, `user_pass`) VALUES
(50,'Douglas','Nhunzvi','dougiedj@gmail.com','$2y$10$sPHJMcJdQHLb.2.6RH4Ahu0.CB1VhNNEH.WkHhvvTv0.UClQyaLD6');

-- ------------------------------------------------ 

