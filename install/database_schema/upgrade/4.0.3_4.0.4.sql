DELETE FROM `wrm_column_headers` WHERE `view_name` = 'roster1' AND column_name = 'Role' LIMIT 1;
INSERT INTO `wrm_column_headers` (`view_name`, `column_name`, `visible`, `position`, `img_url`, `lang_idx_hdr`, `format_code`, `default_sort`) VALUES ('roster1', 'Pri_Spec', '1', '12', NULL, 'pri_spec', NULL, '0'); 
INSERT INTO `wrm_column_headers` (`view_name`, `column_name`, `visible`, `position`, `img_url`, `lang_idx_hdr`, `format_code`, `default_sort`) VALUES ('roster1', 'Sec_Spec', '1', '13', NULL, 'sec_spec', NULL, '0');
UPDATE `wrm_column_headers` SET `position` = '14' WHERE view_name = 'roster1' AND column_name = 'Profile' LIMIT 1 ;

INSERT INTO `wrm_version` VALUES ('4.0.4','Version 4.0.4 of WoW Raid Manager');