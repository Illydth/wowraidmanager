-- WRM Armory Cache
DROP TABLE IF EXISTS `wrm_armory`;
DROP TABLE IF EXISTS `wrm_armory_cache`;
CREATE TABLE wrm_armory_cache (
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
INSERT INTO `wrm_config` VALUES ('recurrance_enabled', '1');
INSERT INTO `wrm_config` VALUES ('armory_cache_timeout', '48');
INSERT INTO `wrm_config` VALUES ('freeze_status_draft', '0');
INSERT INTO `wrm_config` VALUES ('freeze_status_queue', '0');
INSERT INTO `wrm_config` VALUES ('freeze_status_cancel', '0');
INSERT INTO `wrm_config` VALUES ('debug', '0');

UPDATE `wrm_config` SET config_value = 'database' WHERE config_name = 'armory_cache_setting';

INSERT INTO `wrm_version` VALUES ('4.1.4','Version 4.1.4 of WoW Raid Manager');
