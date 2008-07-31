DROP TABLE IF EXISTS `phpraid_announcements`;
CREATE TABLE  `phpraid_announcements` (
  `announcements_id` int(10) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `message` text NOT NULL,
  `timestamp` varchar(255) NOT NULL default '',
  `posted_by` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`announcements_id`)
) DEFAULT CHARACTER SET 'UTF8' COLLATE=utf8_bin ;

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
  `role` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`char_id`)
) DEFAULT CHARACTER SET 'UTF8' COLLATE=utf8_bin ;

DROP TABLE IF EXISTS `phpraid_config`;
CREATE TABLE  `phpraid_config` (
  `config_name` varchar(255) NOT NULL default '',
  `config_value` varchar(255) NOT NULL default ''
)DEFAULT CHARACTER SET 'UTF8' COLLATE=utf8_bin ;

DROP TABLE IF EXISTS `phpraid_guilds`;
CREATE TABLE  `phpraid_guilds` (
  `guild_id` int(10) NOT NULL auto_increment,
  `guild_master` varchar(80) NOT NULL default '',
  `guild_name` varchar(30) NOT NULL default '',
  `guild_tag` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`guild_id`)
)DEFAULT CHARACTER SET 'UTF8' COLLATE=utf8_bin ;

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
  `role1` int(2) NOT NULL default '0',
  `role2` int(2) NOT NULL default '0',
  `role3` int(2) NOT NULL default '0',
  `role4` int(2) NOT NULL default '0',
  `role5` int(2) NOT NULL default '0',
  `role6` int(2) NOT NULL default '0',
  `max` int(2) NOT NULL default '0',
  `locked` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`location_id`)
)DEFAULT CHARACTER SET 'UTF8' COLLATE=utf8_bin ;

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
)DEFAULT CHARACTER SET 'UTF8' COLLATE=utf8_bin ;

DROP TABLE IF EXISTS `phpraid_logs_delete`;
CREATE TABLE  `phpraid_logs_delete` (
  `log_id` int(11) NOT NULL auto_increment,
  `profile_id` int(11) NOT NULL default '0',
  `ip` varchar(45) NOT NULL default '',
  `timestamp` varchar(45) NOT NULL default '',
  `type` varchar(45) NOT NULL default '',
  `delete_name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`log_id`)
)DEFAULT CHARACTER SET 'UTF8' COLLATE=utf8_bin ;

DROP TABLE IF EXISTS `phpraid_logs_hack`;
CREATE TABLE  `phpraid_logs_hack` (
  `log_id` int(10) unsigned NOT NULL auto_increment,
  `ip` varchar(45) NOT NULL default '0',
  `message` text NOT NULL,
  `timestamp` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`log_id`)
)DEFAULT CHARACTER SET 'UTF8' COLLATE=utf8_bin ;

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
)DEFAULT CHARACTER SET 'UTF8' COLLATE=utf8_bin ;

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
)DEFAULT CHARACTER SET 'UTF8' COLLATE=utf8_bin ;

DROP TABLE IF EXISTS `phpraid_profile`;
CREATE TABLE  `phpraid_profile` (
  `profile_id` int(10) NOT NULL auto_increment,
  `email` varchar(255) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `priv` varchar(255) NOT NULL default '',
  `username` varchar(255) NOT NULL default '',
  `last_login_time` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`profile_id`)
)DEFAULT CHARACTER SET 'UTF8' COLLATE=utf8_bin ;

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
  `role1_lmt` int(2) NOT NULL default '0',
  `role2_lmt` int(2) NOT NULL default '0',
  `role3_lmt` int(2) NOT NULL default '0',
  `role4_lmt` int(2) NOT NULL default '0',
  `role5_lmt` int(2) NOT NULL default '0',
  `role6_lmt` int(2) NOT NULL default '0',
  `min_lvl` int(2) NOT NULL default '0',
  `max_lvl` int(2) NOT NULL default '0',
  `max` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`raid_id`)
)DEFAULT CHARACTER SET 'UTF8' COLLATE=utf8_bin ;

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
)DEFAULT CHARACTER SET 'UTF8' COLLATE=utf8_bin ;

DROP TABLE IF EXISTS `phpraid_teams`;
CREATE TABLE  `phpraid_teams` (
  `team_id` int(10) NOT NULL auto_increment,
  `raid_id` int(10) NOT NULL default '0',
  `team_name` varchar(255) NOT NULL default '',
  `char_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`team_id`)
)DEFAULT CHARACTER SET 'UTF8' COLLATE=utf8_bin ;

DROP TABLE IF EXISTS `phpraid_version`;
CREATE TABLE `phpraid_version` (
`version_number` VARCHAR( 20 ) NOT NULL ,
`version_desc` VARCHAR( 255 ) NOT NULL ,
PRIMARY KEY ( `version_number` )
) DEFAULT CHARACTER SET 'UTF8' COLLATE=utf8_bin;

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
INSERT INTO `phpraid_config` VALUES ('guild_name','WoW Raid Manager');
INSERT INTO `phpraid_config` VALUES ('guild_server','Illidan');
INSERT INTO `phpraid_config` VALUES ('header_link','http://www.yourdomain.com/');
INSERT INTO `phpraid_config` VALUES ('header_logo','templates/SpiffyJr/images/logo_phpRaid.jpg');
INSERT INTO `phpraid_config` VALUES ('language','english');
INSERT INTO `phpraid_config` VALUES ('multiple_signups','0');
INSERT INTO `phpraid_config` VALUES ('phpraid_addon_link','http://www.wowraidmanager.net');
INSERT INTO `phpraid_config` VALUES ('armory_link','http://www.wowarmory.com');
INSERT INTO `phpraid_config` VALUES ('armory_language','en');
INSERT INTO `phpraid_config` VALUES ('register_url','register.php');
INSERT INTO `phpraid_config` VALUES ('roster_integration','0');
INSERT INTO `phpraid_config` VALUES ('show_id','0');
INSERT INTO `phpraid_config` VALUES ('showphpraid_addon','1');
INSERT INTO `phpraid_config` VALUES ('template','SpiffyJr');
INSERT INTO `phpraid_config` VALUES ('time_format','h:i a');
INSERT INTO `phpraid_config` VALUES ('timezone','-0600');
INSERT INTO `phpraid_config` VALUES ('resop', '0');
INSERT INTO `phpraid_config` VALUES ('enable_five_man', '0');
INSERT INTO `phpraid_config` VALUES ('user_queue_promote', '0');
INSERT INTO `phpraid_config` VALUES ('user_queue_comments', '1');
INSERT INTO `phpraid_config` VALUES ('user_queue_cancel', '1');
INSERT INTO `phpraid_config` VALUES ('user_queue_delete', '1');
INSERT INTO `phpraid_config` VALUES ('user_cancel_queue', '1');
INSERT INTO `phpraid_config` VALUES ('user_cancel_promote', '0');
INSERT INTO `phpraid_config` VALUES ('user_cancel_comments', '1');
INSERT INTO `phpraid_config` VALUES ('user_cancel_delete', '0');
INSERT INTO `phpraid_config` VALUES ('user_drafted_queue', '1');
INSERT INTO `phpraid_config` VALUES ('user_drafted_comments', '1');
INSERT INTO `phpraid_config` VALUES ('user_drafted_cancel', '1');
INSERT INTO `phpraid_config` VALUES ('user_drafted_delete', '0');
INSERT INTO `phpraid_config` VALUES ('rl_queue_promote', '1');
INSERT INTO `phpraid_config` VALUES ('rl_queue_comments', '1');
INSERT INTO `phpraid_config` VALUES ('rl_queue_cancel', '0');
INSERT INTO `phpraid_config` VALUES ('rl_queue_delete', '0');
INSERT INTO `phpraid_config` VALUES ('rl_cancel_queue', '0');
INSERT INTO `phpraid_config` VALUES ('rl_cancel_promote', '0');
INSERT INTO `phpraid_config` VALUES ('rl_cancel_comments', '1');
INSERT INTO `phpraid_config` VALUES ('rl_cancel_delete', '1');
INSERT INTO `phpraid_config` VALUES ('rl_drafted_queue', '1');
INSERT INTO `phpraid_config` VALUES ('rl_drafted_comments', '1');
INSERT INTO `phpraid_config` VALUES ('rl_drafted_cancel', '0');
INSERT INTO `phpraid_config` VALUES ('rl_drafted_delete', '0');
INSERT INTO `phpraid_config` VALUES ('admin_queue_promote', '1');
INSERT INTO `phpraid_config` VALUES ('admin_queue_comments', '1');
INSERT INTO `phpraid_config` VALUES ('admin_queue_cancel', '0');
INSERT INTO `phpraid_config` VALUES ('admin_queue_delete', '0');
INSERT INTO `phpraid_config` VALUES ('admin_cancel_queue', '0');
INSERT INTO `phpraid_config` VALUES ('admin_cancel_promote', '0');
INSERT INTO `phpraid_config` VALUES ('admin_cancel_comments', '1');
INSERT INTO `phpraid_config` VALUES ('admin_cancel_delete', '1');
INSERT INTO `phpraid_config` VALUES ('admin_drafted_queue', '1');
INSERT INTO `phpraid_config` VALUES ('admin_drafted_comments', '1');
INSERT INTO `phpraid_config` VALUES ('admin_drafted_cancel', '0');
INSERT INTO `phpraid_config` VALUES ('admin_drafted_delete', '0');
INSERT INTO `phpraid_config` VALUES ('rss_site_url', 'http://localhost/phpraid');
INSERT INTO `phpraid_config` VALUES ('rss_export_url', 'http://localhost/phpraid');
INSERT INTO `phpraid_config` VALUES ('rss_feed_amt', '5');
INSERT INTO `phpraid_config` VALUES ('armory_link','http://www.wowarmory.com');
INSERT INTO `phpraid_config` VALUES ('armory_language','en');
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

INSERT INTO `phpraid_permissions` (`name`,`description`,`announcements`,`configuration`,`guilds`,`locations`,`permissions`,`profile`,`raids`,`logs`,`users`) VALUES ('WRM Superadmin','Full access','1','1','1','1','1','1','1','1','1');

INSERT INTO `phpraid_version` VALUES ('3.0.9.2','Version 3.0.9.2 of phpRaid');
INSERT INTO `phpraid_version` VALUES ('3.1.0','Version 3.1.0 of phpRaid (Beta)');
INSERT INTO `phpraid_version` VALUES ('3.1.1','Version 3.1.1 of phpRaid');
INSERT INTO `phpraid_version` VALUES ('3.1.2','Version 3.1.2 of WoW Raid Manager');
INSERT INTO `phpraid_version` VALUES ('3.2.0','Version 3.2.0 of WoW Raid Manager');
INSERT INTO `phpraid_version` VALUES ('3.2.1','Version 3.2.1 of WoW Raid Manager');
INSERT INTO `phpraid_version` VALUES ('3.5.0','Version 3.5.0 of WoW Raid Manager');