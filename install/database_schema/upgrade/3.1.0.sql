INSERT INTO `phpraid_config` VALUES ('enable_five_man', '0');

ALTER TABLE `phpraid_locations` ADD `locked` TINYINT( 1 ) NOT NULL DEFAULT '0';

DROP TABLE IF EXISTS `phpraid_teams`;
CREATE TABLE  `phpraid_teams` (
  `team_id` int(10) NOT NULL auto_increment,
  `raid_id` int(10) NOT NULL default '0',
  `team_name` varchar(255) NOT NULL default '',
  `char_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`team_id`)
);