# ************************************************************
# Sequel Pro SQL dump
# Version 4500
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Hôte: 127.0.0.1 (MySQL 5.5.42)
# Base de données: featherbb
# Temps de génération: 2016-02-13 18:45:49 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Affichage de la table market_plugins
# ------------------------------------------------------------

DROP TABLE IF EXISTS `market_plugins`;

CREATE TABLE `market_plugins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL DEFAULT 'New plugin',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `homepage` varchar(120) NOT NULL,
  `vendor_name` varchar(120) NOT NULL DEFAULT '',
  `author` varchar(120) NOT NULL DEFAULT '',
  `description` varchar(120) DEFAULT NULL,
  `keywords` varchar(120) DEFAULT NULL,
  `readme` mediumtext,
  `last_version` varchar(10) DEFAULT NULL,
  `last_update` int(11) DEFAULT NULL,
  `nb_downloads` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `vendor_name` (`vendor_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `market_plugins` WRITE;
/*!40000 ALTER TABLE `market_plugins` DISABLE KEYS */;

INSERT INTO `market_plugins` (`id`, `name`, `status`, `homepage`, `vendor_name`, `author`, `description`, `keywords`, `readme`, `last_version`, `last_update`, `nb_downloads`)
VALUES
	(3,'Private messages',2,'https://github.com/featherbb/private-messages','private-messages','blade','Send private messages to other users of community.','a:3:{i:0;s:9:\"featherbb\";i:1;s:15:\"private message\";i:2;s:9:\"messaging\";}','# FeatherBB Private Messages\nManage your private conversations with other members of the community. \n\n## Description\n\nUse this plugin to send private messages to your friends on FeatherBB forums.\n\n## Features\n\n* Multiple receivers per message.\n* Configurable (groups authorizations, max number of messages...)\n\n## Changelog\n\nNothing mutch to say here, this is a sample README. More to come soon !\n','0.1.0',1455465137,1);

/*!40000 ALTER TABLE `market_plugins` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
