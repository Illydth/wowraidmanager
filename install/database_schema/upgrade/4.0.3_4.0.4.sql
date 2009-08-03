DELETE FROM `wrm_column_headers` WHERE `view_name` = 'roster1' AND column_name = 'Role' LIMIT 1;
INSERT INTO `wrm_column_headers` (`view_name`, `column_name`, `visible`, `position`, `img_url`, `lang_idx_hdr`, `format_code`, `default_sort`) VALUES ('roster1', 'Pri_Spec', '1', '12', NULL, 'pri_spec', NULL, '0'); 
INSERT INTO `wrm_column_headers` (`view_name`, `column_name`, `visible`, `position`, `img_url`, `lang_idx_hdr`, `format_code`, `default_sort`) VALUES ('roster1', 'Sec_Spec', '1', '13', NULL, 'sec_spec', NULL, '0');
UPDATE `wrm_column_headers` SET `position` = '14' WHERE view_name = 'roster1' AND column_name = 'Profile' LIMIT 1 ;

-- Issue with faction being different case between Config and Race tables.
UPDATE `wrm_config` SET `config_value` = 'Alliance' WHERE `config_name` = 'faction' AND `config_value` = 'alliance' LIMIT 1 ;
UPDATE `wrm_config` SET `config_value` = 'Horde' WHERE `config_name` = 'faction' AND `config_value` = 'horde' LIMIT 1 ;

INSERT INTO `wrm_version` VALUES ('4.0.4','Version 4.0.4 of WoW Raid Manager');