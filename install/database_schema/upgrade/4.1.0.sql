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

UPDATE `wrm_column_headers` SET `default_sort` = '1' WHERE `view_name`='role1' AND `column_name` = 'ID' LIMIT 1 ;
