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
INSERT IGNORE INTO `wrm_config` VALUES ('auto_mark_raids_old', '4');
INSERT IGNORE INTO `wrm_config` VALUES ('recurrance_enabled', '1');
INSERT IGNORE INTO `wrm_config` VALUES ('armory_cache_timeout', '48');
INSERT IGNORE INTO `wrm_config` VALUES ('freeze_status_draft', '0');
INSERT IGNORE INTO `wrm_config` VALUES ('freeze_status_queue', '0');
INSERT IGNORE INTO `wrm_config` VALUES ('freeze_status_cancel', '0');
INSERT IGNORE INTO `wrm_config` VALUES ('debug', '0');

UPDATE `wrm_config` SET config_value = 'database' WHERE config_name = 'armory_cache_setting';

INSERT IGNORE INTO `wrm_events` (`event_id`, `zone_desc`, `max`, `exp_id`, `event_type_id`, `wow_name`, `icon_path`) VALUES ('165', 'ZulGurub - 5 Man', '5', '4', '2', 'ZulGurub (5)', 'images/instances/Cataclysm_Icons/dungeons/5-ZulGurub.jpg');
INSERT IGNORE INTO `wrm_events` (`event_id`, `zone_desc`, `max`, `exp_id`, `event_type_id`, `wow_name`, `icon_path`) VALUES ('166', 'ZulGurub - 5 Man Heroic', '5', '4', '2', 'ZulGurub (5)', 'images/instances/Cataclysm_Icons/dungeons/5-ZulGurub-Heoric.jpg');
INSERT IGNORE INTO `wrm_events` (`event_id`, `zone_desc`, `max`, `exp_id`, `event_type_id`, `wow_name`, `icon_path`) VALUES ('167', 'Firelands - 10 Man', '10', '4', '1', 'Firelands (10)', 'images/instances/Cataclysm_Icons/raids/10-Firelands.jpg');
INSERT IGNORE INTO `wrm_events` (`event_id`, `zone_desc`, `max`, `exp_id`, `event_type_id`, `wow_name`, `icon_path`) VALUES ('168', 'Firelands - 25 Man', '25', '4', '1', 'Firelands (25)', 'images/instances/Cataclysm_Icons/raids/25-Firelands.jpg');


INSERT INTO `wrm_version` VALUES ('4.2.0','Version 4.2.0 of WoW Raid Manager');
