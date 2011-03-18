-- WRM Armory Cache
DROP TABLE IF EXISTS `wrm_armory`;
CREATE TABLE wrm_armory (
`name` varchar(255) DEFAULT NULL,
spec varchar(255) DEFAULT NULL,
avgilvl int(5) DEFAULT NULL,
bestilvl int(5) DEFAULT NULL,
health int(10) DEFAULT NULL,
mana int(10) DEFAULT NULL,
TTL varchar(255) NOT NULL,
UNIQUE KEY `name` (`name`)
);

ALTER TABLE `wrm_signups` CHANGE `comments` `comments` VARCHAR( 5000 );
INSERT INTO `wrm_config` VALUES ('auto_mark_raids_old', '4');

INSERT INTO `wrm_version` VALUES ('4.1.4','Version 4.1.4 of WoW Raid Manager');
