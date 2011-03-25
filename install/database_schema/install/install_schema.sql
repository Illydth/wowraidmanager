-- Announcements Table Creation
DROP TABLE IF EXISTS `wrm_announcements`;
CREATE TABLE  `wrm_announcements` (
  `announcements_id` int(10) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `message` text NOT NULL,
  `timestamp` varchar(255) NOT NULL default '',
  `posted_by` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`announcements_id`)
) ;


-- WRM Armory Cache
DROP TABLE IF EXISTS `wrm_armory_cache`;
CREATE TABLE wrm_armory (
`name` varchar(255) DEFAULT NULL,
spec varchar(255) DEFAULT NULL,
avgilvl int(5) DEFAULT NULL,
bestilvl int(5) DEFAULT NULL,
health int(10) DEFAULT NULL,
mana int(10) DEFAULT NULL,
TTL varchar(255) NOT NULL,
UNIQUE KEY `name` (`name`)
) ;

-- Boss Kill Type Table Creation
DROP TABLE IF EXISTS `wrm_boss_kill_type`;
CREATE TABLE `wrm_boss_kill_type` (
`boss_kill_type_id` TINYINT( 2 ) NOT NULL AUTO_INCREMENT,
`boss_kill_type_name` VARCHAR( 50 ) NOT NULL ,
`boss_kill_type_lang_id` VARCHAR( 50 ) NOT NULL ,
`event_type_id` INT( 10 ) NOT NULL,
`max` VARCHAR( 2 ) NOT NULL,
`def` TINYINT( 1 ) NOT NULL,
 PRIMARY KEY  (`boss_kill_type_id`)
) ;

-- Character Table Creation
DROP TABLE IF EXISTS `wrm_chars`;
CREATE TABLE  `wrm_chars` (
  `char_id` int(10) NOT NULL auto_increment,
  `profile_id` int(10) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `class` varchar(255) NOT NULL default '',
  `gender` varchar(255) NOT NULL default '',
  `guild` varchar(255) NOT NULL default '',
  `lvl` int(3) NOT NULL default '0',
  `race` varchar(255) NOT NULL default '',
  `arcane` int(5) NOT NULL default '0',
  `fire` int(5) NOT NULL default '0',
  `frost` int(5) NOT NULL default '0',
  `nature` int(5) NOT NULL default '0',
  `shadow` int(5) NOT NULL default '0',
  `pri_spec` varchar(255) NOT NULL default '',
  `sec_spec` varchar(255) default '',  
  PRIMARY KEY  (`char_id`)
) ;

-- Class Table Creation
DROP TABLE IF EXISTS `wrm_classes`;
CREATE TABLE `wrm_classes` (
  `class_index` tinyint(2) NOT NULL,
  `class_id` varchar(100) NOT NULL,
  `class_code` varchar(2) NOT NULL,
  `lang_index` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY  (`class_index`)
);

-- Race/Class Link Table Creation
DROP TABLE IF EXISTS `wrm_class_race`;
CREATE TABLE `wrm_class_race` (
`race_id` VARCHAR( 100 ) NOT NULL ,
`class_id` VARCHAR( 100 ) NOT NULL ,
PRIMARY KEY ( `race_id` , `class_id` )
);



-- Class and Role Linking Table Creation
DROP TABLE IF EXISTS `wrm_class_role`;
CREATE TABLE `wrm_class_role` (
  `class_id` varchar(100) NOT NULL,
  `subclass` varchar(100) NOT NULL,
  `lang_index` varchar(100) NOT NULL,
  `role_id` varchar(10) NOT NULL,
  PRIMARY KEY  (`class_id`,`subclass`)
);

-- Column Header Creation
DROP TABLE IF EXISTS `wrm_column_headers`;
CREATE TABLE `wrm_column_headers` (
`ID` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`view_name` VARCHAR( 50 ) NOT NULL ,
`column_name` VARCHAR( 50 ) NOT NULL ,
`visible` TINYINT( 1 ) NOT NULL DEFAULT '1',
`position` TINYINT( 2 ) NOT NULL ,
`img_url` VARCHAR( 100 ) DEFAULT NULL,
`lang_idx_hdr` VARCHAR ( 50 ) DEFAULT NULL,
`format_code` VARCHAR ( 25 ) DEFAULT NULL,
`default_sort` TINYINT( 1 ) NOT NULL DEFAULT '0',
INDEX ( `view_name` )
) ;


-- Config Table Creation
DROP TABLE IF EXISTS `wrm_config`;
CREATE TABLE  `wrm_config` (
  `config_name` varchar(255) NOT NULL default '',
  `config_value` varchar(255) NOT NULL default ''
) ;

-- Events Table Creation
DROP TABLE IF EXISTS `wrm_events`;
CREATE TABLE `wrm_events` (
  `event_id` int(10) NOT NULL auto_increment,
  `zone_desc` varchar(50) NOT NULL,
  `max` tinyint(2) NOT NULL,
  `exp_id` tinyint(2) NOT NULL,
  `event_type_id` tinyint(2) NOT NULL,
  `wow_name` varchar(50) NOT NULL,
  `icon_path` varchar(100) NOT NULL,
  PRIMARY KEY  (`event_id`)
) ;


-- Event Type Table Creation
DROP TABLE IF EXISTS `wrm_event_type`;
CREATE TABLE `wrm_event_type` (
  `event_type_id` tinyint(2) NOT NULL auto_increment,
  `event_type_name` varchar(50) NOT NULL,
  `event_type_lang_id` varchar(50) NOT NULL,
  `def` tinyint(1) NOT NULL,
  PRIMARY KEY  (`event_type_id`)
) ;

-- Expansion Table Creation
DROP TABLE IF EXISTS `wrm_expansion`;
CREATE TABLE `wrm_expansion` (
  `exp_id` tinyint(2) NOT NULL auto_increment,
  `exp_name` varchar(50) NOT NULL,
  `exp_lang_id` varchar(50) NOT NULL,
  `def` tinyint(1) NOT NULL,
  `max_lvl` tinyint(2) NOT NULL DEFAULT '60',
  PRIMARY KEY  (`exp_id`)
) ;

-- Faction Table Creation
DROP TABLE IF EXISTS `wrm_faction`;
CREATE TABLE `wrm_faction` (
`faction_name` VARCHAR( 255 ) NOT NULL ,
`lang_index` VARCHAR( 255 ) NOT NULL ,
PRIMARY KEY ( `faction_name` )
) ;

-- Gender Table Creation
DROP TABLE IF EXISTS `wrm_gender`;
CREATE TABLE `wrm_gender` (
  `gender_id` varchar(10) NOT NULL,
  `lang_index` varchar(100) NOT NULL,
  PRIMARY KEY  (`gender_id`)
);

-- Guilds Table Creation
DROP TABLE IF EXISTS `wrm_guilds`;
CREATE TABLE `wrm_guilds` (
  `guild_id` int(10) NOT NULL auto_increment,
  `guild_master` varchar(80) NOT NULL default '',
  `guild_name` varchar(30) NOT NULL default '',
  `guild_tag` varchar(20) NOT NULL default '',
  `guild_description` VARCHAR(255),
  `guild_server` VARCHAR(255) NOT NULL default '',
  `guild_faction` VARCHAR(50) NOT NULL default 'None',
  `guild_armory_link` VARCHAR(255),
  `guild_armory_code` VARCHAR(4),
  PRIMARY KEY  (`guild_id`)
) ;

-- Locations Table Creation
DROP TABLE IF EXISTS `wrm_locations`;
CREATE TABLE `wrm_locations` (
  `location_id` int(10) NOT NULL auto_increment,
  `location` varchar(255) NOT NULL default '',
  `min_lvl` int(2) NOT NULL default '0',
  `max_lvl` int(2) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `max` int(2) NOT NULL default '0',
  `locked` tinyint(1) NOT NULL default '0',
  `event_type` tinyint(2) NOT NULL default '1',
  `event_id` int(10) NOT NULL default '119',
  `raid_force_name` varchar(100) NOT NULL default 'All',
  PRIMARY KEY  (`location_id`),
  KEY `raid_force_name` (`raid_force_name`)
) ;

-- Locations Data

-- Location / Class Limit Link Table Creation
DROP TABLE IF EXISTS `wrm_loc_class_lmt`;
CREATE TABLE `wrm_loc_class_lmt` (
  `location_id` int(10) NOT NULL,
  `class_id` varchar(100) NOT NULL,
  `lmt` int(2) NOT NULL,
  PRIMARY KEY  (`location_id`,`class_id`)
);

-- Location / Role Limit Link Table Creation
DROP TABLE IF EXISTS `wrm_loc_role_lmt`;
CREATE TABLE `wrm_loc_role_lmt` (
  `location_id` int(10) NOT NULL,
  `role_id` varchar(10) NOT NULL,
  `lmt` int(2) NOT NULL,
  PRIMARY KEY  (`location_id`,`role_id`)
);

-- Log Create Table Creation
DROP TABLE IF EXISTS `wrm_logs_create`;
CREATE TABLE `wrm_logs_create` (
  `log_id` int(11) NOT NULL auto_increment,
  `create_id` int(11) NOT NULL default '0',
  `profile_id` int(11) NOT NULL default '0',
  `ip` varchar(45) NOT NULL default '',
  `timestamp` varchar(45) NOT NULL default '',
  `type` varchar(45) NOT NULL default '',
  `create_name` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`log_id`)
) ;

-- Log Delete Table Creation
DROP TABLE IF EXISTS `wrm_logs_delete`;
CREATE TABLE `wrm_logs_delete` (
  `log_id` int(11) NOT NULL auto_increment,
  `profile_id` int(11) NOT NULL default '0',
  `ip` varchar(45) NOT NULL default '',
  `timestamp` varchar(45) NOT NULL default '',
  `type` varchar(45) NOT NULL default '',
  `delete_name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`log_id`)
) ;

-- Log Hack Table Creation 
DROP TABLE IF EXISTS `wrm_logs_hack`;
CREATE TABLE `wrm_logs_hack` (
  `log_id` int(10) unsigned NOT NULL auto_increment,
  `ip` varchar(45) NOT NULL default '0',
  `message` text NOT NULL,
  `timestamp` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`log_id`)
) ;

-- Log Raid Table Creation
DROP TABLE IF EXISTS `wrm_logs_raid`;
CREATE TABLE `wrm_logs_raid` (
  `log_id` int(10) NOT NULL auto_increment,
  `char_id` int(10) NOT NULL default '0',
  `profile_id` int(10) NOT NULL default '0',
  `raid_id` int(10) NOT NULL default '0',
  `ip` varchar(45) NOT NULL default '',
  `timestamp` varchar(45) NOT NULL default '',
  `type` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`log_id`)
) ;

-- Permissions Table Creation
DROP TABLE IF EXISTS `wrm_permissions`;
CREATE TABLE `wrm_permissions` (
  `permission_id` int(10) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `announcements` int(1) NOT NULL default '0',
  `configuration` int(1) NOT NULL default '0',
  `guilds` int(1) NOT NULL default '0',
  `locations` int(1) NOT NULL default '0',
  `profile` int(1) NOT NULL default '0',
  `raids` int(1) NOT NULL default '0',
  PRIMARY KEY  (`permission_id`)
) ;

-- Profile Table Creation
DROP TABLE IF EXISTS `wrm_profile`;
CREATE TABLE `wrm_profile` (
  `profile_id` int(10) NOT NULL auto_increment,
  `email` varchar(255) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `priv` varchar(255) NOT NULL default '',
  `username` varchar(255) NOT NULL default '',
  `last_login_time` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`profile_id`)
) ;

-- Race Table Creation
DROP TABLE IF EXISTS `wrm_races`;
CREATE TABLE `wrm_races` (
  `race_id` varchar(100) NOT NULL,
  `faction` varchar(100) NOT NULL,
  `lang_index` varchar(100) NOT NULL,
  PRIMARY KEY  (`race_id`)
);

-- Race/Gender Link Table Creation
DROP TABLE IF EXISTS `wrm_race_gender`;
CREATE TABLE `wrm_race_gender` (
  `race_id` varchar(100) NOT NULL,
  `gender_id` varchar(10) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY  (`race_id`,`gender_id`)
);

-- Raid Table Creation
DROP TABLE IF EXISTS `wrm_raids`;
CREATE TABLE `wrm_raids` (
  `raid_id` int(10) NOT NULL auto_increment,
  `description` text NOT NULL,
  `freeze` int(10) NOT NULL default '0',
  `invite_time` varchar(255) NOT NULL default '',
  `location` varchar(255) NOT NULL default '',
  `officer` varchar(255) NOT NULL default '',
  `old` tinyint(1) NOT NULL default '0',
  `start_time` varchar(255) NOT NULL default '',
  `min_lvl` int(2) NOT NULL default '0',
  `max_lvl` int(2) NOT NULL default '0',
  `max` varchar(255) NOT NULL default '',
  `event_type` tinyint(1) NOT NULL default '1',
  `event_id` int(10) NOT NULL default '119',
  `raid_force_name` varchar(100) NOT NULL DEFAULT 'All',
  `recurrance` TINYINT(1) NOT NULL DEFAULT '0',
  `rec_interval` VARCHAR(15) DEFAULT NULL,
  `num_recur` TINYINT(2) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`raid_id`),
  KEY `raid_force_name` (`raid_force_name`)
  );

-- Class Limits per Raid Table
DROP TABLE IF EXISTS `wrm_raid_class_lmt`;
CREATE TABLE `wrm_raid_class_lmt` (
  `raid_id` int(10) NOT NULL,
  `class_id` varchar(100) NOT NULL,
  `lmt` int(2) NOT NULL,
  PRIMARY KEY  (`raid_id`,`class_id`)
);

-- Raid Force Table
DROP TABLE IF EXISTS `wrm_raid_force`;
CREATE TABLE `wrm_raid_force` (
`raid_force_id` INT( 10 ) NOT NULL AUTO_INCREMENT,
`raid_force_name` VARCHAR( 100 ) NOT NULL,
`guild_id` INT( 10 ) NOT NULL ,
PRIMARY KEY ( `raid_force_name`, `guild_id` ),
UNIQUE ( `raid_force_id` )
);

-- Role Limits per Raid Table
DROP TABLE IF EXISTS `wrm_raid_role_lmt`;
CREATE TABLE IF NOT EXISTS `wrm_raid_role_lmt` (
  `raid_id` int(10) NOT NULL,
  `role_id` varchar(10) NOT NULL,
  `lmt` int(2) NOT NULL,
  PRIMARY KEY  (`raid_id`,`role_id`)
);

-- Role Table Creation
DROP TABLE IF EXISTS `wrm_roles`;
CREATE TABLE IF NOT EXISTS `wrm_roles` (
  `role_id` varchar(10) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `lang_index` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY  (`role_id`)
);

-- Signup Table Creation
DROP TABLE IF EXISTS `wrm_signups`;
CREATE TABLE `wrm_signups` (
  `signup_id` int(10) NOT NULL auto_increment,
  `char_id` int(10) NOT NULL default '0',
  `profile_id` int(10) NOT NULL default '0',
  `raid_id` int(10) NOT NULL default '0',
  `comments` varchar(5000) NOT NULL default '',
  `cancel` int(1) NOT NULL default '0',
  `queue` int(1) NOT NULL default '0',
  `timestamp` varchar(255) NOT NULL default '',
  `selected_spec` varchar(100) NOT NULL,
  PRIMARY KEY  (`signup_id`)
) ;

-- Team Table Creation
DROP TABLE IF EXISTS `wrm_teams`;
CREATE TABLE `wrm_teams` (
  `team_id` int(10) NOT NULL auto_increment,
  `raid_id` int(10) NOT NULL default '0',
  `team_name` varchar(255) NOT NULL default '',
  `char_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`team_id`)
) ;

-- Version Table Creation
DROP TABLE IF EXISTS `wrm_version`;
CREATE TABLE `wrm_version` (
`version_number` VARCHAR( 20 ) NOT NULL ,
`version_desc` VARCHAR( 255 ) NOT NULL ,
PRIMARY KEY ( `version_number` )
) ;

-- Raid signup Group Table Creation
DROP TABLE IF EXISTS `wrm_acl_raid_signup_group`;
CREATE TABLE `wrm_acl_raid_signup_group` (
`signup_group_id` TINYINT( 2 ) NOT NULL AUTO_INCREMENT,
`signup_group_name` VARCHAR( 50 ) NOT NULL ,
`on_queue_draft` TINYINT( 2 ) NOT NULL ,
`on_queue_comments` TINYINT( 2 ) NOT NULL ,
`on_queue_cancel` TINYINT( 2 ) NOT NULL ,
`on_queue_delete` TINYINT( 2 ) NOT NULL ,
`cancelled_status_queue` TINYINT( 2 ) NOT NULL ,
`cancelled_status_draft` TINYINT( 2 ) NOT NULL ,
`cancelled_status_comments` TINYINT( 2 ) NOT NULL ,
`cancelled_status_delete` TINYINT( 2 ) NOT NULL ,
`drafted_queue` TINYINT( 2 ) NOT NULL ,
`drafted_comments` TINYINT( 2 ) NOT NULL ,
`drafted_cancel` TINYINT( 2 ) NOT NULL ,
`drafted_delete` TINYINT( 2 ) NOT NULL ,
 PRIMARY KEY  (`signup_group_id`)
) ;
