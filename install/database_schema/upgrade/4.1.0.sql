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
