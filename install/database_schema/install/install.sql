DROP TABLE IF EXISTS `phpraid_announcements`;
CREATE TABLE  `phpraid_announcements` (
  `announcements_id` int(10) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `message` text NOT NULL,
  `timestamp` varchar(255) NOT NULL default '',
  `posted_by` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`announcements_id`)
);

DROP TABLE IF EXISTS `phpraid_chars`;
CREATE TABLE  `phpraid_chars` (
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
  PRIMARY KEY  (`char_id`)
);

DROP TABLE IF EXISTS `phpraid_config`;
CREATE TABLE  `phpraid_config` (
  `config_name` varchar(255) NOT NULL default '',
  `config_value` varchar(255) NOT NULL default ''
);

DROP TABLE IF EXISTS `phpraid_guilds`;
CREATE TABLE  `phpraid_guilds` (
  `guild_id` int(10) NOT NULL auto_increment,
  `guild_master` varchar(80) NOT NULL default '',
  `guild_name` varchar(30) NOT NULL default '',
  `guild_tag` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`guild_id`)
);

DROP TABLE IF EXISTS `phpraid_locations`;
CREATE TABLE  `phpraid_locations` (
  `location_id` int(10) NOT NULL auto_increment,
  `location` varchar(255) NOT NULL default '',
  `min_lvl` int(2) NOT NULL default '0',
  `max_lvl` int(2) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `dr` int(2) NOT NULL default '0',
  `hu` int(2) NOT NULL default '0',
  `ma` int(2) NOT NULL default '0',
  `pa` int(2) NOT NULL default '0',
  `pr` int(2) NOT NULL default '0',
  `ro` int(2) NOT NULL default '0',
  `sh` int(2) NOT NULL default '0',
  `wk` int(2) NOT NULL default '0',
  `wa` int(2) NOT NULL default '0',
  `max` int(2) NOT NULL default '0',
  PRIMARY KEY  (`location_id`)
);

DROP TABLE IF EXISTS `phpraid_logs_create`;
CREATE TABLE  `phpraid_logs_create` (
  `log_id` int(11) NOT NULL auto_increment,
  `create_id` int(11) NOT NULL default '0',
  `profile_id` int(11) NOT NULL default '0',
  `ip` varchar(45) NOT NULL default '',
  `timestamp` varchar(45) NOT NULL default '',
  `type` varchar(45) NOT NULL default '',
  `create_name` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`log_id`)
);

DROP TABLE IF EXISTS `phpraid_logs_delete`;
CREATE TABLE  `phpraid_logs_delete` (
  `log_id` int(11) NOT NULL auto_increment,
  `profile_id` int(11) NOT NULL default '0',
  `ip` varchar(45) NOT NULL default '',
  `timestamp` varchar(45) NOT NULL default '',
  `type` varchar(45) NOT NULL default '',
  `delete_name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`log_id`)
);

DROP TABLE IF EXISTS `phpraid_logs_hack`;
CREATE TABLE  `phpraid_logs_hack` (
  `log_id` int(10) unsigned NOT NULL auto_increment,
  `ip` varchar(45) NOT NULL default '0',
  `message` text NOT NULL,
  `timestamp` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`log_id`)
);

DROP TABLE IF EXISTS `phpraid_logs_raid`;
CREATE TABLE  `phpraid_logs_raid` (
  `log_id` int(10) NOT NULL auto_increment,
  `char_id` int(10) NOT NULL default '0',
  `profile_id` int(10) NOT NULL default '0',
  `raid_id` int(10) NOT NULL default '0',
  `ip` varchar(45) NOT NULL default '',
  `timestamp` varchar(45) NOT NULL default '',
  `type` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`log_id`)
);

DROP TABLE IF EXISTS `phpraid_permissions`;
CREATE TABLE  `phpraid_permissions` (
  `permission_id` int(10) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `announcements` int(1) NOT NULL default '0',
  `configuration` int(1) NOT NULL default '0',
  `guilds` int(1) NOT NULL default '0',
  `locations` int(1) NOT NULL default '0',
  `permissions` int(1) NOT NULL default '0',
  `profile` int(1) NOT NULL default '0',
  `raids` int(1) NOT NULL default '0',
  `logs` int(1) NOT NULL default '0',
  `users` int(1) NOT NULL default '0',
  PRIMARY KEY  (`permission_id`)
);

DROP TABLE IF EXISTS `phpraid_profile`;
CREATE TABLE  `phpraid_profile` (
  `profile_id` int(10) NOT NULL auto_increment,
  `email` varchar(255) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `priv` varchar(255) NOT NULL default '',
  `username` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`profile_id`)
);

DROP TABLE IF EXISTS `phpraid_raids`;
CREATE TABLE  `phpraid_raids` (
  `raid_id` int(10) NOT NULL auto_increment,
  `description` text NOT NULL,
  `freeze` int(10) NOT NULL default '0',
  `invite_time` varchar(255) NOT NULL default '',
  `location` varchar(255) NOT NULL default '',
  `officer` varchar(255) NOT NULL default '',
  `old` tinyint(1) NOT NULL default '0',
  `start_time` varchar(255) NOT NULL default '',
  `dr_lmt` int(2) NOT NULL default '0',
  `hu_lmt` int(2) NOT NULL default '0',
  `ma_lmt` int(2) NOT NULL default '0',
  `pa_lmt` int(2) NOT NULL default '0',
  `pr_lmt` int(2) NOT NULL default '0',
  `sh_lmt` int(2) NOT NULL default '0',
  `ro_lmt` int(2) NOT NULL default '0',
  `wk_lmt` int(2) NOT NULL default '0',
  `wa_lmt` int(2) NOT NULL default '0',
  `min_lvl` int(2) NOT NULL default '0',
  `max_lvl` int(2) NOT NULL default '0',
  `max` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`raid_id`)
);

DROP TABLE IF EXISTS `phpraid_signups`;
CREATE TABLE  `phpraid_signups` (
  `signup_id` int(10) NOT NULL auto_increment,
  `char_id` int(10) NOT NULL default '0',
  `profile_id` int(10) NOT NULL default '0',
  `raid_id` int(10) NOT NULL default '0',
  `comments` varchar(255) NOT NULL default '',
  `cancel` int(1) NOT NULL default '0',
  `queue` int(1) NOT NULL default '0',
  `timestamp` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`signup_id`)
);

INSERT INTO `phpraid_config` VALUES ('admin_email','webmaster@yourdomain.com');
INSERT INTO `phpraid_config` VALUES ('anon_view', '1');
INSERT INTO `phpraid_config` VALUES ('auto_queue','0');
INSERT INTO `phpraid_config` VALUES ('date_format','m/d/Y');
INSERT INTO `phpraid_config` VALUES ('debug','0');
INSERT INTO `phpraid_config` VALUES ('default_group','nil');
INSERT INTO `phpraid_config` VALUES ('disable','0');
INSERT INTO `phpraid_config` VALUES ('disable_freeze','0');
INSERT INTO `phpraid_config` VALUES ('dst','0');
INSERT INTO `phpraid_config` VALUES ('email_signature','Thanks');
INSERT INTO `phpraid_config` VALUES ('faction','alliance');
INSERT INTO `phpraid_config` VALUES ('guild_description','raid management made easy');
INSERT INTO `phpraid_config` VALUES ('guild_name','phpRaid');
INSERT INTO `phpraid_config` VALUES ('guild_server','Illidan');
INSERT INTO `phpraid_config` VALUES ('header_link','http://www.yourdomain.com/');
INSERT INTO `phpraid_config` VALUES ('header_logo','templates/SpiffyJr/images/logo_phpRaid.jpg');
INSERT INTO `phpraid_config` VALUES ('language','english');
INSERT INTO `phpraid_config` VALUES ('multiple_signups','0');
INSERT INTO `phpraid_config` VALUES ('phpraid_addon_link','http://www.spiffyjr.com/forums/viewtopic.php?t=1073');
INSERT INTO `phpraid_config` VALUES ('register_url','register.php');
INSERT INTO `phpraid_config` VALUES ('roster_integration','0');
INSERT INTO `phpraid_config` VALUES ('show_id','0');
INSERT INTO `phpraid_config` VALUES ('showphpraid_addon','1');
INSERT INTO `phpraid_config` VALUES ('template','SpiffyJr');
INSERT INTO `phpraid_config` VALUES ('time_format','h:i a');
INSERT INTO `phpraid_config` VALUES ('timezone','-0600');
INSERT INTO `phpraid_config` VALUES ('putonqueue', '0');
INSERT INTO `phpraid_config` VALUES ('resop', '0');

INSERT INTO `phpraid_permissions` (`name`,`description`,`announcements`,`configuration`,`guilds`,`locations`,`permissions`,`profile`,`raids`,`logs`,`users`) VALUES ('phpRaid Superadmin','Full access','1','1','1','1','1','1','1','1','1');