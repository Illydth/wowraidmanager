ALTER TABLE `phpraid_chars` ADD `role` VARCHAR(255) NOT NULL default '';
ALTER TABLE `phpraid_locations` ADD `role1` INT(2) NOT NULL default '0';
ALTER TABLE `phpraid_locations` ADD `role2` INT(2) NOT NULL default '0';
ALTER TABLE `phpraid_locations` ADD `role3` INT(2) NOT NULL default '0';
ALTER TABLE `phpraid_locations` ADD `role4` INT(2) NOT NULL default '0';
ALTER TABLE `phpraid_locations` ADD `role5` INT(2) NOT NULL default '0';
ALTER TABLE `phpraid_locations` ADD `role6` INT(2) NOT NULL default '0';
ALTER TABLE `phpraid_profile` ADD `last_login_time` VARCHAR( 25 ) NOT NULL ;
ALTER TABLE `phpraid_raids` ADD `role1_lmt` INT(2) NOT NULL default '0';
ALTER TABLE `phpraid_raids` ADD `role2_lmt` INT(2) NOT NULL default '0';
ALTER TABLE `phpraid_raids` ADD `role3_lmt` INT(2) NOT NULL default '0';
ALTER TABLE `phpraid_raids` ADD `role4_lmt` INT(2) NOT NULL default '0';
ALTER TABLE `phpraid_raids` ADD `role5_lmt` INT(2) NOT NULL default '0';
ALTER TABLE `phpraid_raids` ADD `role6_lmt` INT(2) NOT NULL default '0';

INSERT INTO `phpraid_config` VALUES ('role1_name','tank');
INSERT INTO `phpraid_config` VALUES ('role2_name','melee');
INSERT INTO `phpraid_config` VALUES ('role3_name','healer');
INSERT INTO `phpraid_config` VALUES ('role4_name','ranged');
INSERT INTO `phpraid_config` VALUES ('role5_name','misc1');
INSERT INTO `phpraid_config` VALUES ('role6_name','misc2');
INSERT INTO `phpraid_config` VALUES ('enforce_role_limits', '1');
INSERT INTO `phpraid_config` VALUES ('enforce_class_limits', '0');
INSERT INTO `phpraid_config` VALUES ('class_as_min', '1');
INSERT INTO `phpraid_config` VALUES ('enable_armory', '1');
INSERT INTO `phpraid_config` VALUES ('enable_eqdkp', '0');
INSERT INTO `phpraid_config` VALUES ('eqdkp_url', 'http://localhost/eqdkp');
INSERT INTO `phpraid_config` VALUES ('ampm', '12');

DROP TABLE IF EXISTS `phpraid_version`;
CREATE TABLE `phpraid_version` (
`version_number` VARCHAR( 20 ) NOT NULL ,
`version_desc` VARCHAR( 255 ) NOT NULL ,
PRIMARY KEY ( `version_number` )
) ;

INSERT INTO `phpraid_version` VALUES ('3.0.9.2','Version 3.0.9.2 of phpRaid');
INSERT INTO `phpraid_version` VALUES ('3.1.0','Version 3.1.0 of phpRaid (Beta)');
INSERT INTO `phpraid_version` VALUES ('3.1.1','Version 3.1.1 of phpRaid');
INSERT INTO `phpraid_version` VALUES ('3.1.2','Version 3.1.2 of WoW Raid Manager');
INSERT INTO `phpraid_version` VALUES ('3.2.0','Version 3.2.0 of WoW Raid Manager');
INSERT INTO `phpraid_version` VALUES ('3.2.1','Version 3.2.1 of WoW Raid Manager');
INSERT INTO `phpraid_version` VALUES ('3.5.0','Version 3.5.0 of WoW Raid Manager');