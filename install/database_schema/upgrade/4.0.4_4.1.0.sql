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

-- Column Header Data - missingprofile1 View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'missingprofile1', 'ID', '1', '1', NULL, 'id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'missingprofile1', 'Username', '1', '2', NULL, 'username', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'missingprofile1', 'E-Mail', '1', '3', NULL, 'email', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'missingprofile1', 'Last Login Date', '1', '5', NULL, 'last_login_date', 'wrmdate');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'missingprofile1', 'Last Login Time', '1', '6', NULL, 'last_login_time', 'wrmtime');

UPDATE `wrm_column_headers` SET `default_sort` = '1' WHERE `view_name`='missingprofile1' AND `column_name` = 'ID' LIMIT 1 ;

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
INSERT INTO `wrm_config` (`config_name`,`config_value`) VALUES ('max_lvl', '85');
INSERT INTO `wrm_config` (`config_name`,`config_value`) VALUES ('wrm_expansion', '4');
INSERT INTO `wrm_config` (`config_name`,`config_value`) VALUES ('lua_output_sort_signups', '1');
INSERT INTO `wrm_config` (`config_name`,`config_value`) VALUES ('lua_output_sort_queue', '2');
INSERT INTO `wrm_config` (`config_name`,`config_value`) VALUES ('lua_output_format', '2');
INSERT INTO `wrm_config` (`config_name`,`config_value`) VALUES ('num_old_raids_index', '20');

DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'user_queue_promote';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'user_queue_comments';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'user_queue_cancel';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'user_queue_delete';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'user_cancel_queue';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'user_cancel_promote';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'user_cancel_comments';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'user_cancel_delete';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'user_drafted_queue';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'user_drafted_comments';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'user_drafted_cancel';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'user_drafted_delete';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'rl_queue_promote';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'rl_queue_comments';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'rl_queue_cancel';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'rl_queue_delete';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'rl_cancel_queue';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'rl_cancel_promote';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'rl_cancel_comments';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'rl_cancel_delete';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'rl_drafted_queue';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'rl_drafted_comments';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'rl_drafted_cancel';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'rl_drafted_delete';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'admin_queue_promote';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'admin_queue_comments';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'admin_queue_cancel';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'admin_queue_delete';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'admin_cancel_queue';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'admin_cancel_promote';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'admin_cancel_comments';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'admin_cancel_delete';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'admin_drafted_queue';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'admin_drafted_comments';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'admin_drafted_cancel';
DELETE FROM `wrm_config` WHERE `wrm_config`.`config_name` = 'admin_drafted_delete';

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
ALTER TABLE `wrm_raids` ADD `raid_force_name` varchar( 100 ) NOT NULL DEFAULT 'All'; 
ALTER TABLE `wrm_raids` ADD `recurrance` TINYINT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE `wrm_raids` ADD `rec_interval` VARCHAR( 15 ) DEFAULT NULL;
ALTER TABLE `wrm_raids` ADD `num_recur` TINYINT( 2 ) NOT NULL DEFAULT '0';
ALTER TABLE `wrm_raids` ADD INDEX ( `raid_force_name` ); 

-- Location Table Update/Field Addition
ALTER TABLE `wrm_locations` ADD `raid_force_name` varchar( 100 ) NOT NULL DEFAULT 'All',
ADD INDEX ( raid_force_name ); 

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

INSERT INTO `wrm_acl_raid_signup_group` VALUES (1,'User',0,1,1,1,1,0,1,0,1,1,1,0);
INSERT INTO `wrm_acl_raid_signup_group` VALUES (2,'Raid Leader',1,1,0,0,0,0,1,1,1,1,0,0);
INSERT INTO `wrm_acl_raid_signup_group` VALUES (3,'Administrator',1,1,0,0,0,0,1,1,1,1,0,0);

-- Expansion Table Data
ALTER TABLE `wrm_expansion` ADD `max_lvl` TINYINT( 2 ) NOT NULL DEFAULT '60';
INSERT INTO `wrm_expansion` (`exp_id`, `exp_name`, `exp_lang_id`, `def`,`max_lvl`) VALUES (4, 'Cataclysm', 'exp_cataclysm', 1,'85');
UPDATE `wrm_expansion` SET `def` = '0' WHERE `exp_lang_id`='exp_wrath_lich_king' LIMIT 1 ;

-- Event Table Data
INSERT INTO `wrm_events` (`event_id`, `zone_desc`, `max`, `exp_id`, `event_type_id`, `wow_name`, `icon_path`) VALUES
('136', 'Icecrown Citadel - 10 man', '10', '3', '1', 'Icecrown Citadel (10)', 'images/instances/WotLK_Icons/10-Icecrown-Citadel.jpg'),
('137', 'Icecrown Citadel - 25 man', '25', '3', '1', 'Icecrown Citadel (25)', 'images/instances/WotLK_Icons/25-Icecrown-Citadel.jpg');
-- Cataclysm Events
INSERT INTO `wrm_events` ( `zone_desc`, `max`, `exp_id`, `event_type_id`, `wow_name`, `icon_path`) VALUES
('Abyssal Maw', 5, 4, 2, 'Abyssal Maw', 'images/instances/Cataclysm_Icons/dungeons/5-Abyssal-Maw.jpg'), 
('Abyssal Maw - Heroic', 5, 4, 2, 'Abyssal Maw (Heroic)', 'images/instances/Cataclysm_Icons/dungeons/5-Abyssal-Maw-Heroic.jpg'),
('Blackrock Caverns', 5, 4, 2, 'Blackrock Caverns', 'images/instances/Cataclysm_Icons/dungeons/5-Blackrock-Caverns.jpg'), 
('Blackrock Caverns - Heroic', 5, 4, 2, 'Blackrock Caverns (Heroic)', 'images/instances/Cataclysm_Icons/dungeons/5-Blackrock-Caverns-Heroic.jpg'), 
('Grim Batol', 5, 4, 2, 'Grim Batol', 'images/instances/Cataclysm_Icons/dungeons/5-Grim-Batol.jpg'), 
('Grim Batol - Heroic', 5, 4, 2, 'Grim Batol (Heroic)', 'images/instances/Cataclysm_Icons/dungeons/5-Grim-Batol-Heroic.jpg'), 
('Halls of Origination', 5, 4, 2, 'Halls of Origination', 'images/instances/Cataclysm_Icons/dungeons/5-Halls-Of-Origination.jpg'), 
('Halls of Origination - Heroic', 5, 4, 2, 'Halls of Origination (Heroic)', 'images/instances/Cataclysm_Icons/dungeons/5-Halls-Of-Origination-Heroic.jpg'), 
('Lost City of Tolvir', 5, 4, 2, 'Lost City of Tolvir', 'images/instances/Cataclysm_Icons/dungeons/5-Lost-City-Of-Tolvir.jpg'), 
('Lost City of Tolvir - Heroic', 5, 4, 2, 'Lost City of Tolvir (Heroic)', 'images/instances/Cataclysm_Icons/dungeons/5-Lost-City-Of-Tolvir-Heroic.jpg'), 
('Stonecore', 5, 4, 2, 'Stonecore', 'images/instances/Cataclysm_Icons/dungeons/5-Stonecore.jpg'), 
('Stonecore - Heroic', 5, 4, 2, 'Stonecore', 'images/instances/Cataclysm_Icons/dungeons/5-Stonecore-Heroic.jpg'), 
('Throne of Tides', 5, 4, 2, 'Throne of Tides', 'images/instances/Cataclysm_Icons/dungeons/5-Throne-Of-Tides.jpg'), 
('Throne of Tides - Heroic', 5, 4, 2, 'Throne of Tides (Heroic)', 'images/instances/Cataclysm_Icons/dungeons/5-Throne-Of-Tides-Heroic.jpg'), 
('Vortex Pinnacle', 5, 4, 2, 'Vortex Pinnacle', 'images/instances/Cataclysm_Icons/dungeons/5-Vortex-Pinnacle.jpg'),
('Vortex Pinnacle - Heroic', 5, 4, 2, 'Vortex Pinnacle (Heroic)', 'images/instances/Cataclysm_Icons/dungeons/5-Vortex-Pinnacle-Heroic.jpg'),
('Bastion Of Twilight - 10 man', 10, 4, 1, 'Bastion Of Twilight (10)', 'images/instances/Cataclysm_Icons/raids/10-Bastion-Of-Twilight.jpg'),
('Blackwing Descent - 10 man', 10, 4, 1, 'Blackwing Descent (10)', 'images/instances/Cataclysm_Icons/raids/10-Blackwing-Descent.jpg'),
('Throne Of Four Winds - 10 man', 10, 4, 1, 'Throne Of Four Winds (10)', 'images/instances/Cataclysm_Icons/raids/10-Throne-Of-Four-Winds.jpg'),
('Bastion Of Twilight - 25 man', 10, 4, 1, 'Bastion Of Twilight (25)', 'images/instances/Cataclysm_Icons/raids/25-Bastion-Of-Twilight.jpg'),
('Blackwing Descent - 25 man', 10, 4, 1, 'Blackwing Descent (25)', 'images/instances/Cataclysm_Icons/raids/25-Blackwing-Descent.jpg'),
('Throne Of Four Winds - 25 man', 10, 4, 1, 'Throne Of Four Winds (25)', 'images/instances/Cataclysm_Icons/raids/25-Throne-Of-Four-Winds.jpg');

INSERT INTO `wrm_class_race` VALUES ('Human', 'Hunter');
INSERT INTO `wrm_class_race` VALUES ('Dwarf', 'Mage');
INSERT INTO `wrm_class_race` VALUES ('Dwarf', 'Shaman');
INSERT INTO `wrm_class_race` VALUES ('Dwarf', 'Warlock');
INSERT INTO `wrm_class_race` VALUES ('Night Elf', 'Mage');
INSERT INTO `wrm_class_race` VALUES ('Gnome', 'Priest');
INSERT INTO `wrm_class_race` VALUES ('Worgen', 'Death Knight');
INSERT INTO `wrm_class_race` VALUES ('Worgen', 'Warlock');
INSERT INTO `wrm_class_race` VALUES ('Worgen', 'Rogue');
INSERT INTO `wrm_class_race` VALUES ('Worgen', 'Hunter');
INSERT INTO `wrm_class_race` VALUES ('Worgen', 'Druid');
INSERT INTO `wrm_class_race` VALUES ('Worgen', 'Mage');
INSERT INTO `wrm_class_race` VALUES ('Worgen', 'Priest');
INSERT INTO `wrm_class_race` VALUES ('Orc', 'Mage');
INSERT INTO `wrm_class_race` VALUES ('Undead', 'Hunter');
INSERT INTO `wrm_class_race` VALUES ('Tauren', 'Paladin');
INSERT INTO `wrm_class_race` VALUES ('Tauren', 'Priest');
INSERT INTO `wrm_class_race` VALUES ('Troll', 'Warlock');
INSERT INTO `wrm_class_race` VALUES ('Troll', 'Druid');
INSERT INTO `wrm_class_race` VALUES ('Blood Elf', 'Warrior');
INSERT INTO `wrm_class_race` VALUES ('Goblin', 'Warrior');
INSERT INTO `wrm_class_race` VALUES ('Goblin', 'Rogue');
INSERT INTO `wrm_class_race` VALUES ('Goblin', 'Shaman');
INSERT INTO `wrm_class_race` VALUES ('Goblin', 'Mage');
INSERT INTO `wrm_class_race` VALUES ('Goblin', 'Priest');
INSERT INTO `wrm_class_race` VALUES ('Goblin', 'Warlock');
INSERT INTO `wrm_class_race` VALUES ('Goblin', 'Hunter');
INSERT INTO `wrm_class_race` VALUES ('Goblin', 'Death Knight');

INSERT INTO `wrm_races` VALUES ('Worgen', 'Alliance', 'worgen');
INSERT INTO `wrm_races` VALUES ('Goblin', 'Horde', 'goblin');

INSERT INTO `wrm_race_gender` VALUES ('Worgen', 'Male', '/images/faces/wg_male.gif');
INSERT INTO `wrm_race_gender` VALUES ('Worgen', 'Female', '/images/faces/wg_female.gif');
INSERT INTO `wrm_race_gender` VALUES ('Goblin', 'Male', '/images/faces/gb_male.gif');
INSERT INTO `wrm_race_gender` VALUES ('Goblin', 'Female', '/images/faces/gb_female.gif');

INSERT INTO `wrm_version` VALUES ('4.1.0','Version 4.1.0 of WoW Raid Manager');
