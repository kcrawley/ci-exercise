# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.31-0+wheezy1)
# Database: ci_exercise
# Generation Time: 2013-11-14 04:28:00 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table brand_options
# ------------------------------------------------------------

DROP TABLE IF EXISTS `brand_options`;

CREATE TABLE `brand_options` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `brand_options` WRITE;
/*!40000 ALTER TABLE `brand_options` DISABLE KEYS */;

INSERT INTO `brand_options` (`id`, `name`)
VALUES
	(1,'Dell'),
	(2,'HP');

/*!40000 ALTER TABLE `brand_options` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table campaign_types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `campaign_types`;

CREATE TABLE `campaign_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `campaign_types` WRITE;
/*!40000 ALTER TABLE `campaign_types` DISABLE KEYS */;

INSERT INTO `campaign_types` (`id`, `name`)
VALUES
	(1,'Email'),
	(2,'Teledemand'),
	(3,'SSD');

/*!40000 ALTER TABLE `campaign_types` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table campaigns
# ------------------------------------------------------------

DROP TABLE IF EXISTS `campaigns`;

CREATE TABLE `campaigns` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `client_contacts_id` int(10) unsigned NOT NULL,
  `brand_options_id` int(10) unsigned NOT NULL,
  `client_names_id` int(11) DEFAULT NULL,
  `campaign_name` varchar(100) DEFAULT NULL,
  `start_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `notes` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table client_contacts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `client_contacts`;

CREATE TABLE `client_contacts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table client_contacts_to_client_names
# ------------------------------------------------------------

DROP TABLE IF EXISTS `client_contacts_to_client_names`;

CREATE TABLE `client_contacts_to_client_names` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `client_contacts_id` int(10) unsigned NOT NULL,
  `client_names_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table client_names
# ------------------------------------------------------------

DROP TABLE IF EXISTS `client_names`;

CREATE TABLE `client_names` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `client_names` WRITE;
/*!40000 ALTER TABLE `client_names` DISABLE KEYS */;

INSERT INTO `client_names` (`id`, `name`)
VALUES
	(1,'Quanta'),
	(2,'Express Lube');

/*!40000 ALTER TABLE `client_names` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table campaigns_to_campaign_types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `campaigns_to_campaign_types`;

CREATE TABLE `campaigns_to_campaign_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `campaigns_id` int(10) unsigned NOT NULL,
  `campaign_types_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
