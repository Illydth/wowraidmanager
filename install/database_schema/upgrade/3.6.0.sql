ALTER TABLE `phpraid_locations` ADD `dk` INT(2) NOT NULL default '0';
ALTER TABLE `phpraid_locations` ADD `event_type` tinyint(1) NOT NULL default '1';
ALTER TABLE `phpraid_raids` ADD `dk_lmt` INT(2) NOT NULL default '0';
ALTER TABLE `phpraid_raids` ADD `event_type` tinyint(1) NOT NULL default '1';

INSERT INTO `phpraid_version` VALUES ('3.6.0','Version 3.6.0 of WoW Raid Manager');
