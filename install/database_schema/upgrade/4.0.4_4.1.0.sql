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

INSERT INTO `wrm_boss_kill_type` VALUES (1, 'Dungeon', 'boss_kill_type_dungeon', 2, 0, 0);
INSERT INTO `wrm_boss_kill_type` VALUES (2, 'Raid: 25 Man', 'boss_kill_type_25_man', 1, 25, 1);
INSERT INTO `wrm_boss_kill_type` VALUES (3, 'Raid: 10 Man', 'boss_kill_type_10_man', 1, 10, 0);
INSERT INTO `wrm_boss_kill_type` VALUES (4, 'Raid: 40 Man', 'boss_kill_type_40_man', 1, 40, 0);

-- Column Header Data - Role1 View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'role1', 'ID', '1', '1', NULL, 'role_id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'role1', 'Role Name', '1', '2', NULL, 'role_name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'role1', 'Config Text', '1', '3', NULL, 'role_config', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'role1', 'Image', '1', '4', NULL, 'role_image', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'role1', 'Buttons', '1', '24', NULL, 'buttons', NULL);
-- Column Header Data - ClassRoleTalent1 View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'classroletalent1', 'Class', '1', '1', NULL, 'class', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'classroletalent1', 'Talent Tree', '1', '2', NULL, 'talent_tree', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'classroletalent1', 'Display Text', '1', '3', NULL, 'display_text', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'classroletalent1', 'Role Name', '1', '4', NULL, 'role_name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'classroletalent1', 'Buttons', '1', '5', NULL, 'buttons', NULL);
-- Column Header Data - raidforce1 View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidforce1', 'ID', '1', '1', NULL, 'raid_force_id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidforce1', 'Force Name', '1', '2', NULL, 'raid_force_name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidforce1', 'Guild ID', '1', '3', NULL, 'guild_id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidforce1', 'Guild Name', '1', '4', NULL, 'guild_name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidforce1', 'Buttons', '1', '24', NULL, 'buttons', NULL);
-- Column Header Data - raid1 View UPDATE
UPDATE `wrm_column_headers` SET `position` = '11' WHERE `column_name` = 'Buttons' and `view_name` = 'raids1' LIMIT 1 ;
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Force Name', '1', '10', NULL, 'raid_force_name', NULL);
-- Column Header Data - location1 View UPDATE
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Force Name', '1', '10', NULL, 'raid_force_name', NULL);
-- Column Header Data - index1 View UPDATE
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', 'Force Name', '1', '19', NULL, 'raid_force_name', NULL);

-- Add row to Users1 view and move buttons down a priority.
UPDATE `wrm_column_headers` SET `position` = '8' WHERE `view_name` = 'users1' AND `column_name` = 'Buttons' LIMIT 1 ;
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'users1', 'Permission_Mod', '1', '7', NULL, 'perm_mod', NULL);

-- Remove "Permissions" Permission since you have to have "configuration" permission to get there.
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'permissions1' AND `column_name` = 'Pe' LIMIT 1;
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'permissions1' AND `column_name` = 'Lg' LIMIT 1;
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'permissions1' AND `column_name` = 'Us' LIMIT 1;

-- Remove the Entirety of permissions2 view since the "Details" part of permission assignment is handled in 
--    a completely different way.
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'permissions2' AND `column_name` = 'ID' LIMIT 1;
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'permissions2' AND `column_name` = 'Username' LIMIT 1;
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'permissions2' AND `column_name` = 'E-Mail' LIMIT 1;
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'permissions2' AND `column_name` = 'Buttons' LIMIT 1;

ALTER TABLE `wrm_permissions` DROP `permissions`;
ALTER TABLE `wrm_permissions` DROP `logs`;
ALTER TABLE `wrm_permissions` DROP `users`;

UPDATE `wrm_column_headers` SET `default_sort` = '1' WHERE `view_name`='role1' AND `column_name` = 'ID' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `default_sort` = '1' WHERE `view_name`='classroletalent1' AND `column_name` = 'Class' LIMIT 1 ;

-- Guild Update: Add new fields and add to view.
ALTER TABLE `wrm_guilds` ADD `guild_description` VARCHAR( 255 );
ALTER TABLE `wrm_guilds` ADD `guild_server` VARCHAR( 255 ) NOT NULL;
ALTER TABLE `wrm_guilds` ADD `guild_faction` VARCHAR( 50 ) NOT NULL DEFAULT 'None';
ALTER TABLE `wrm_guilds` ADD `guild_armory_link` VARCHAR( 255 );
ALTER TABLE `wrm_guilds` ADD `guild_armory_code` VARCHAR( 4 );

-- Column Header Data - Guild1 View
DELETE FROM `wrm_column_headers` WHERE view_name = 'guild1';
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'guild1', 'ID', '1', '1', NULL, 'id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'guild1', 'Name', '1', '2', NULL, 'guild_name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'guild1', 'Tag', '1', '3', NULL, 'guild_tag', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'guild1', 'Description', '1', '4', NULL, 'guild_description', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'guild1', 'Guild Master', '1', '5', NULL, 'guild_master', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'guild1', 'Server', '1', '6', NULL, 'guild_server', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'guild1', 'Faction', '1', '7', NULL, 'guild_faction', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'guild1', 'Armory Link', '1', '8', NULL, 'guild_armory_link', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'guild1', 'Armory Code', '1', '9', NULL, 'guild_armory_code', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'guild1', 'Buttons', '1', '10', NULL, 'buttons', NULL);

-- Faction Table Creation
DROP TABLE IF EXISTS `wrm_faction`;
CREATE TABLE `wrm_faction` (
`faction_name` VARCHAR( 255 ) NOT NULL ,
`lang_index` VARCHAR( 255 ) NOT NULL ,
PRIMARY KEY ( `faction_name` )
) ;

-- Data for Faction Table
INSERT INTO `wrm_faction` (`faction_name` , `lang_index`) VALUES ('Alliance', 'alliance'), ('Horde', 'horde'), ('None', 'none');

-- Config Table Cleanup.
DELETE FROM `wrm_config` WHERE `config_name` = 'faction';
DELETE FROM `wrm_config` WHERE `config_name` = 'guild_description';
DELETE FROM `wrm_config` WHERE `config_name` = 'guild_name';
DELETE FROM `wrm_config` WHERE `config_name` = 'guild_server';
DELETE FROM `wrm_config` WHERE `config_name` = 'armory_link';
DELETE FROM `wrm_config` WHERE `config_name` = 'armory_language';
INSERT INTO `wrm_config` (`config_name`,`config_value`) VALUES ('site_name', 'WRM');
INSERT INTO `wrm_config` (`config_name`,`config_value`) VALUES ('site_description', 'WRM');
INSERT INTO `wrm_config` (`config_name`,`config_value`) VALUES ('site_server', 'Localhost');
INSERT INTO `wrm_config` (`config_name`,`config_value`) VALUES ('persistent_db', '1');
INSERT INTO `wrm_config` (`config_name`,`config_value`) VALUES ('wrm_created_on', '1');
INSERT INTO `wrm_config` (`config_name`,`config_value`) VALUES ('wrm_updated_on', '1');

-- Raid Force Table Creation
DROP TABLE IF EXISTS `wrm_raid_force`;
CREATE TABLE `wrm_raid_force` (
`raid_force_id` INT( 10 ) NOT NULL AUTO_INCREMENT,
`raid_force_name` VARCHAR( 100 ) NOT NULL,
`guild_id` INT( 10 ) NOT NULL ,
PRIMARY KEY ( `raid_force_name`, `guild_id` ),
UNIQUE ( `raid_force_id` )
);

-- Raid Table Update/Field Additions
ALTER TABLE `wrm_raids` ADD `raid_force_id` INT( 10 ) NOT NULL DEFAULT '0'; 
ALTER TABLE `wrm_raids` ADD `recurrance` TINYINT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE `wrm_raids` ADD `rec_interval` VARCHAR( 15 ) DEFAULT NULL;
ALTER TABLE `wrm_raids` ADD `num_recur` TINYINT( 2 ) NOT NULL DEFAULT '0';
ALTER TABLE `wrm_raids` ADD INDEX ( `raid_force_id` ); 

-- Location Table Update/Field Addition
ALTER TABLE `wrm_locations` ADD `raid_force_id` INT( 10 ) NOT NULL DEFAULT '0',
ADD INDEX ( raid_force_id ); 

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

INSERT INTO `wrm_acl_raid_signup_group` VALUES (1,"User",0,1,1,1,1,0,1,0,1,1,1,0);
INSERT INTO `wrm_acl_raid_signup_group` VALUES (2,"Raid Leader",1,1,0,0,0,0,1,1,1,1,0,0);
INSERT INTO `wrm_acl_raid_signup_group` VALUES (3,"Administrator",1,1,0,0,0,0,1,1,1,1,0,0);

INSERT INTO `wrm_version` VALUES ('4.1.0','Version 4.1.0 of WoW Raid Manager');
