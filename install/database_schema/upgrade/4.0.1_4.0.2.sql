INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview2', 'Role', '1', '11', NULL, 'role', NULL);
UPDATE `wrm_column_headers` SET `position` = '12' WHERE `view_name` = 'raidview2' and `column_name` = 'Signup_Spec' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `position` = '13' WHERE `view_name` = 'raidview2' and `column_name` = 'Buttons' LIMIT 1 ;

INSERT INTO `wrm_version` VALUES ('4.0.2','Version 4.0.2 of WoW Raid Manager');
