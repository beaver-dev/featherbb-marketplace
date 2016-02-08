# ************************************************************
# Sequel Pro SQL dump
# Version 4500
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Hôte: 127.0.0.1 (MySQL 5.5.42)
# Base de données: marketplace
# Temps de génération: 2016-02-08 13:38:23 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Affichage de la table plugins
# ------------------------------------------------------------

DROP TABLE IF EXISTS `plugins`;

CREATE TABLE `plugins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `homepage` varchar(120) NOT NULL,
  `vendor_name` varchar(120) NOT NULL DEFAULT '',
  `name` varchar(120) NOT NULL,
  `readme` mediumtext,
  `keywords` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `plugins` WRITE;
/*!40000 ALTER TABLE `plugins` DISABLE KEYS */;

INSERT INTO `plugins` (`id`, `status`, `homepage`, `vendor_name`, `name`, `readme`, `keywords`)
VALUES
	(1,2,'https://github.com/featherbb/private-messages','private-messages','test','# FeatherBB Readme\n\n[![Join the chat at https://gitter.im/featherbb/featherbb](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/featherbb/featherbb?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)\n\n## Description\n\nFeatherBB is an open source forum application released under the GNU General Public\nLicence. It is free to download and use and will remain so. FeatherBB is a fork of\nFluxBB 1.5 based on Slim Framework and designed to be simple and very lightweight,\nwith modern features: MVC architecture, PDO, OOP and a plugin system. Maybe more?\nYou are more than welcome to join the development :-)\n\n## Changelog\n\nThis is __FeatherBB v1.0.0 Beta__. It is intended for testing purposes only and not\nfor use in a production environment. Please report all the bugs you may encounter to\nthe forums or in the GitHub bug tracker.\n\n### Beta 3 (2015-09-09)\n* Plugin system and some hooks [[beaver](http://github.com/beaver-dev)] [[adaur](http://github.com/adaur)] \n* New architecture ready for Composer [[beaver](http://github.com/beaver-dev)]\n* New template system [[capkokoon](http://github.com/capkokoon)] [[adaur](http://github.com/adaur)]\n* Gettext implemented [[adaur](http://github.com/adaur)]\n* Dynamic URLs within code [[beaver](http://github.com/beaver-dev)]\n* Better permission handling [[adaur](http://github.com/adaur)]\n* OOP parser [[adaur](http://github.com/adaur)]\n* Major namespaces cleanup [[adaur](http://github.com/adaur)]\n* New caching system [[capkokoon](http://github.com/capkokoon)]\n* New error handler [[capkokoon](http://github.com/capkokoon)]\n* New installer [[capkokoon](http://github.com/capkokoon)]\n* Static functions files converted to OOP [[capkokoon](http://github.com/capkokoon)] [[beaver](http://github.com/beaver-dev)] [[adaur](http://github.com/adaur)]\n\n### Beta 2 (2015-08-11)\n\n* New DB Layer [[adaur](http://github.com/adaur)]\n* Flash messages [[beaver](http://github.com/beaver-dev)]\n* BBCode editor [[beaver](http://github.com/beaver-dev)]\n* CSRF tokens [[capkokoon](http://github.com/capkokoon)]\n* Cookie encryption improved [[capkokoon](http://github.com/capkokoon)]\n* htaccess management improved [[adaur](http://github.com/adaur)]\n\n### Beta 1  (2015-07-09)\n\n* Integration with Slim Framework v2.6.2 [[adaur](http://github.com/adaur)]\n* New parser [[ridgerunner](http://github.com/ridgerunner)]\n* MVC architecture [[adaur](http://github.com/adaur)]\n* URL rewriting [[adaur](http://github.com/adaur)]\n* Routing system [[adaur](http://github.com/adaur)]\n* Responsive default style [[Magicalex](http://github.com/Magicalex)]\n* Database schema compatible with FluxBB [[adaur](http://github.com/adaur)]\n* Antispam protection [[adaur](http://github.com/adaur)]\n* Themes fully customizables [[adaur](http://github.com/adaur)]\n* PHP 4 support dropped [[adaur](http://github.com/adaur)]\n* PSR-2 compliant [[Magicalex](http://github.com/magicalex)]\n\n## Requirements\n\n* A webserver\n* PHP 5.3.0 or later\n* A database such as MySQL 4.1.2 or later, PostgreSQL 7.0 or later, SQLite 2 or later\n\n## Recommendations\n\n* Make use of a PHP accelerator such as OPCache\n* Make sure PHP has the zlib module installed to allow FeatherBB to gzip output\n\n## Links\n\n* Homepage: http://featherbb.org\n* Documentation: http://featherbb.org/docs/\n* Community: http://featherbb.org/forums/\n* Chat: https://gitter.im/featherbb/featherbb\n* Development: http://github.com/featherbb/featherbb\n\n## Contributors\n\n* [[adaur](http://github.com/adaur)] Project leader\n* [[capkokoon](http://github.com/capkokoon)] contributor\n* [[beaver](http://github.com/beaver-dev)] contributor\n* [[Magicalex](http://github.com/magicalex)] contributor\n',NULL),
	(2,2,'https://github.com/featherbb/private-messages','private-messages','fr',NULL,NULL),
	(3,0,'https://github.com/featherbb/REPLACEME','','de',NULL,NULL);

/*!40000 ALTER TABLE `plugins` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
