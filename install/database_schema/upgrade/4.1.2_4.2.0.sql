-- Permission Type Table Creation
DROP TABLE IF EXISTS `wrm_permission_type`;
CREATE TABLE  `wrm_permission_type` (
  `permission_type_id` int(10) NOT NULL auto_increment,
  `permission_type_name` varchar(100) NOT NULL,
  `permission_type_description` varchar(100) NOT NULL,
  PRIMARY KEY  (`permission_type_id`)
) ;

-- Permission Value Table Creation
DROP TABLE IF EXISTS `wrm_permission_value`;
CREATE TABLE  `wrm_permission_value` (
  `permission_value_id` int(10) NOT NULL auto_increment,
  `permission_value_name` varchar(100) NOT NULL,
  `lang_index` varchar(100) NOT NULL,
  PRIMARY KEY  (`permission_value_id`)
) ;

-- Acces Controll List Permission Table Creation
DROP TABLE IF EXISTS `wrm_acl_permission`;
CREATE TABLE `wrm_acl_permission` (
  `permission_type_id` int(10) NOT NULL,
  `permission_value_id` int(10) NOT NULL
) ;

-- Menu Type Table Creation
DROP TABLE IF EXISTS `wrm_menu_type`;
CREATE TABLE  `wrm_menu_type` (
  `menu_type_id` int(10) NOT NULL auto_increment,
  `menu_type_title` varchar(255) NOT NULL default '',
  `menu_type_title_alt` varchar(255) NOT NULL default '',
  `show_menu_type_title_alt` int(2) NOT NULL default '0',
  `lang_index` varchar(100) NOT NULL,
  `show_area` varchar(100) NOT NULL default 'normal',
  PRIMARY KEY  (`menu_type_id`)
) ;

-- Menu Value Table Creation
DROP TABLE IF EXISTS `wrm_menu_value`;
CREATE TABLE  `wrm_menu_value` (
  `menu_value_id` int(10) NOT NULL auto_increment,
  `menu_type_id` int(10) NOT NULL,
  `lang_index` varchar(100) NOT NULL,
  `menu_value_title_alt` varchar(255) NOT NULL default '',
  `show_menu_value_title_alt` int(2) NOT NULL default '0',
  `ordering` int(10) NOT NULL,
  `filename_without_ext` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `menu_image` varchar(100) NOT NULL default '',
  `menu_image_show` varchar(2) NOT NULL default '0',
  `permission_value_id` int(10) ,
  `visible` int(2) NOT NULL default '0',
  PRIMARY KEY  (`menu_value_id`)
) ;


-- Permission Type Data
TRUNCATE `wrm_permission_type`;
INSERT INTO `wrm_permission_type` (`permission_type_id`, `permission_type_name`,`permission_type_description`) VALUES ('1','WRM Users','Generic Access');
INSERT INTO `wrm_permission_type` (`permission_type_id`, `permission_type_name`,`permission_type_description`) VALUES ('2','WRM Raid Leader','Generic + Raid Leader Access  ');
INSERT INTO `wrm_permission_type` (`permission_type_id`, `permission_type_name`,`permission_type_description`) VALUES ('3','WRM Superadmin','Full Access');


-- Permission Value Data
INSERT INTO `wrm_permission_value` (`permission_value_id`, `permission_value_name`,`lang_index`) VALUES ('1','announcements','permissions_announcements');
INSERT INTO `wrm_permission_value` (`permission_value_id`, `permission_value_name`,`lang_index`) VALUES ('2','configuration','permissions_configuration');
INSERT INTO `wrm_permission_value` (`permission_value_id`, `permission_value_name`,`lang_index`) VALUES ('3','guilds','permissions_guilds');
INSERT INTO `wrm_permission_value` (`permission_value_id`, `permission_value_name`,`lang_index`) VALUES ('4','locations','permissions_locations');
INSERT INTO `wrm_permission_value` (`permission_value_id`, `permission_value_name`,`lang_index`) VALUES ('5','profile','permissions_profile');
INSERT INTO `wrm_permission_value` (`permission_value_id`, `permission_value_name`,`lang_index`) VALUES ('6','raids','permissions_raids');

-- Acces Controll List Permission Data
INSERT INTO `wrm_acl_permission` (`permission_type_id`, `permission_value_id`) VALUES ('1','1');
INSERT INTO `wrm_acl_permission` (`permission_type_id`, `permission_value_id`) VALUES ('1','2');
INSERT INTO `wrm_acl_permission` (`permission_type_id`, `permission_value_id`) VALUES ('1','3');
INSERT INTO `wrm_acl_permission` (`permission_type_id`, `permission_value_id`) VALUES ('1','4');
INSERT INTO `wrm_acl_permission` (`permission_type_id`, `permission_value_id`) VALUES ('1','5');
INSERT INTO `wrm_acl_permission` (`permission_type_id`, `permission_value_id`) VALUES ('1','6');
INSERT INTO `wrm_acl_permission` (`permission_type_id`, `permission_value_id`) VALUES ('2','5');
INSERT INTO `wrm_acl_permission` (`permission_type_id`, `permission_value_id`) VALUES ('3','5');
INSERT INTO `wrm_acl_permission` (`permission_type_id`, `permission_value_id`) VALUES ('3','6');

-- Add Column Header Data - Admin_Menubar1 View
DELETE FROM `wrm_column_headers` WHERE `wrm_column_headers`.`view_name` = 'admin_menubar1';
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'admin_menubar1', 'ID', '1', '1', NULL, 'id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'admin_menubar1', 'Lang_index', '1', '2', NULL, 'admin_menu_lang_index_text', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'admin_menubar1', 'Link', '1', '3', NULL, 'admin_menu_link_text', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'admin_menubar1', 'Button', '1', '4', NULL, 'buttons', NULL);

-- Modify Column Header Data - Admin_Permissions View
DELETE FROM `wrm_column_headers` WHERE `wrm_column_headers`.`view_name` = 'permissions1';
DELETE FROM `wrm_column_headers` WHERE `wrm_column_headers`.`view_name` = 'admin_permissions1';
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'admin_permissions1', 'ID', '1', '1', NULL, 'id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'admin_permissions1', 'Name', '1', '2', NULL, 'name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'admin_permissions1', 'Description', '1', '3', NULL, 'description', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'admin_permissions1', 'buttons', '1', '13', NULL, 'buttons', NULL);

-- Modify/Add Column Header Data - Announcements View
DELETE FROM `wrm_column_headers` WHERE `wrm_column_headers`.`view_name` = 'announcements1';
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'announcements1', 'ID', '1', '1', NULL, 'id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'announcements1', 'Title', '1', '2', NULL, 'title', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'announcements1', 'Message', '1', '3', NULL, 'message', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'announcements1', 'Posted By', '1', '4', NULL, 'posted_by', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'announcements1', 'Create Date', '1', '5', NULL, 'create_date', 'wrmdate');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'announcements1', 'Create Time', '1', '6', NULL, 'create_time', 'wrmtime');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'announcements1', 'visible', '1', '7', NULL, 'visible', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'announcements1', 'Buttons', '1', '8', NULL, 'buttons', NULL);

-- Menu Type Data
-- INSERT INTO `wrm_menu_type` ( `menu_type_id`, `menu_type_title`,`menu_type_title_alt`,`show_menu_type_title_alt`, `lang_index`,`show_area`) 
INSERT INTO `wrm_menu_type` VALUES ('1', 'menu_admin_main','','0','admin_menu_header','admin');
INSERT INTO `wrm_menu_type` VALUES ('2', 'menu_admin_gen_conf','','0','gen_conf_menu_header','admin');
INSERT INTO `wrm_menu_type` VALUES ('3', 'menu_admin_style_conf','','0','style_menu_header','admin');
INSERT INTO `wrm_menu_type` VALUES ('4', 'menu_admin_user_mgt','','0','user_mgt_menu_header','admin');
INSERT INTO `wrm_menu_type` VALUES ('5', 'menu_admin_table_conf','','0','table_conf_menu_header','admin');
INSERT INTO `wrm_menu_type` VALUES ('6', 'menu_admin_logs', '','0','logs_menu_header','admin');

INSERT INTO `wrm_menu_type` VALUES ('7', 'menu_main', '','0','main_menu_header','normal');
INSERT INTO `wrm_menu_type` VALUES ('8', 'menu_user', '','0','user_menu_header','normal');

-- Menu Value Data
-- INSERT INTO `wrm_menu_value` ( `menu_value_id`, `menu_type_id`, `lang_index`, `menu_value_title_alt`, `show_menu_value_title_alt`, `ordering`, `link`,`filename_without_ext` `menu_image`, `menu_image_show`, `permission_value_id`, `visible` )
-- admin data
INSERT INTO `wrm_menu_value` VALUES ('1','1','admin_site_link','','0','1','','../index.php','','0','2' ,'1');
INSERT INTO `wrm_menu_value` VALUES ('2','1','admin_main_link','','0','2','admin_index','admin_index.php','','0','2','1');
INSERT INTO `wrm_menu_value` VALUES ('3','2','admin_general_config','','0','1','admin_generalcfg','admin_generalcfg.php','','0','2' ,'1');
INSERT INTO `wrm_menu_value` VALUES ('4','2','admin_general_rss_cfg','','0','2','admin_general_rss_cfg','admin_general_rss_cfg.php','','0','2' ,'1');
INSERT INTO `wrm_menu_value` VALUES ('5','2','admin_general_email_cfg','','0','3','admin_general_email_cfg','admin_general_email_cfg.php','','0','2' ,'1');
INSERT INTO `wrm_menu_value` VALUES ('6','2','admin_time_config','','0','4','admin_timecfg','admin_timecfg.php"','','0','2' ,'1');
INSERT INTO `wrm_menu_value` VALUES ('7','2','admin_raid_settings','','0','5','admin_raidsettings','admin_raidsettings.php"','','0','2' ,'1');
INSERT INTO `wrm_menu_value` VALUES ('8','2','admin_external_config','','0','6','admin_externcfg','admin_externcfg.php"','','0','2' ,'1');
INSERT INTO `wrm_menu_value` VALUES ('9','2','admin_game_settings','','0','7','admin_general_game_settings','admin_general_game_settings.php"','','0','2' ,'1');
INSERT INTO `wrm_menu_value` VALUES ('10','2','admin_general_lua_output_cfg','','0','11','admin_general_lua_output_cfg','admin_general_lua_output_cfg.php','','0','6','1');
INSERT INTO `wrm_menu_value` VALUES ('11','3','admin_style_conf','','0','1','admin_style_cfg','admin_style_cfg.php?mode=view','','0','2' ,'1');
INSERT INTO `wrm_menu_value` VALUES ('12','3','admin_menubar_mgt_link','','0','2','admin_style_menubar_mgt', 'admin_style_menubar_mgt.php?mode=view','','0','2','1');
INSERT INTO `wrm_menu_value` VALUES ('13','4','admin_user_management','','0','1','admin_usermgt','admin_usermgt.php?mode=view','','0','2' ,'1');
INSERT INTO `wrm_menu_value` VALUES ('14','4','admin_permissions','','0','2','admin_permissions','admin_permissions.php?mode=view','','0','2' ,'1');
INSERT INTO `wrm_menu_value` VALUES ('16','4','admin_user_settings','','0','4','admin_usersettings','admin_usersettings.php','','0','2' ,'1');
INSERT INTO `wrm_menu_value` VALUES ('17','5','admin_datatablecfg_link','','0','1','admin_datatablecfg','admin_datatablecfg.php','','0','2' ,'1');
INSERT INTO `wrm_menu_value` VALUES ('18','5','admin_rolecfg_link','','0','2','admin_rolecfg', 'admin_rolecfg.php?mode=view','','0','2' ,'1');
INSERT INTO `wrm_menu_value` VALUES ('19','5','admin_roletalent_config','','0','3','admin_roletalent','admin_roletalent.php?mode=view','','0','2' ,'1');
INSERT INTO `wrm_menu_value` VALUES ('20','6','admin_logs_link','','0','1','admin_logs','admin_logs.php?mode=view"','','0', '2','1');
-- normal data
INSERT INTO `wrm_menu_value` VALUES ('40','7','index_link','','0','1','index','index.php','','0',NULL,'1');
INSERT INTO `wrm_menu_value` VALUES ('41','7','calendar_link','','0','1','calendar','calendar.php','','0',NULL,'1');
INSERT INTO `wrm_menu_value` VALUES ('42','7','roster_link','','0','2','roster','roster.php','','0',NULL,'1');
INSERT INTO `wrm_menu_value` VALUES ('43','7','dkp_link','EQ-DKP','1','3','dkp_view','dkp_view.php','','0',NULL,'0');
INSERT INTO `wrm_menu_value` VALUES ('44','7','raidsarchive_link','','0','4','raidsarchive','raidsarchive.php?mode=view','','0',NULL,'1');
INSERT INTO `wrm_menu_value` VALUES ('45','7','bosstrack_link','','0','5','bosstracking','bosstracking.php?mode=view','','0',NULL,'0');
INSERT INTO `wrm_menu_value` VALUES ('46','7','announcements_link','','0','6','announcements','announcements.php?mode=view','','0','1','1');
INSERT INTO `wrm_menu_value` VALUES ('47','7','guilds_link','','0','7','guilds','guilds.php?mode=view','','0','3','1');
INSERT INTO `wrm_menu_value` VALUES ('48','7','locations_link','','0','8','locations','locations.php?mode=view','','0','4','1');
INSERT INTO `wrm_menu_value` VALUES ('49','7','raids_link','','0','9','raids','raids.php?mode=view','','0','6','1');
INSERT INTO `wrm_menu_value` VALUES ('50','7','lua_output_link','','0','10','lua_output_new','lua_output_new.php?mode=lua','','0','6','1');
INSERT INTO `wrm_menu_value` VALUES ('70','8','profile_link','','0','1','profile','profile.php?mode=view','','0','5','1');
INSERT INTO `wrm_menu_value` VALUES ('71','8','profile_char_link','','0','2','profile_char','profile_char.php?mode=view','','0','5','1');
INSERT INTO `wrm_menu_value` VALUES ('72','8','profile_raid_link','','0','3','profile_raid','profile_raid.php?mode=view','','0','5','1');

-- Raid Permission Type Table Creation
-- INSERT INTO `wrm_raid_permission_type` VALUES ( `raid_permission_type_id`, `raid_permission_type_name`,`lang_index`);
INSERT INTO `wrm_raid_permission_type` VALUES ('1','on_queue_draft','configuration_draft');
INSERT INTO `wrm_raid_permission_type` VALUES ('2','on_queue_comments','comments_row_header');
INSERT INTO `wrm_raid_permission_type` VALUES ('3','on_queue_cancel','cancel_row_header');
INSERT INTO `wrm_raid_permission_type` VALUES ('4','on_queue_delete','delete_row_header');
INSERT INTO `wrm_raid_permission_type` VALUES ('5','cancelled_status_queue','queue_row_header');
INSERT INTO `wrm_raid_permission_type` VALUES ('6','cancelled_status_draft','draft_row_header');
INSERT INTO `wrm_raid_permission_type` VALUES ('7','cancelled_status_comments','comments_row_header');
INSERT INTO `wrm_raid_permission_type` VALUES ('8','cancelled_status_delete','delete_row_header');
INSERT INTO `wrm_raid_permission_type` VALUES ('9','drafted_queue','queue_row_header');
INSERT INTO `wrm_raid_permission_type` VALUES ('10','drafted_comments','comments_row_header');
INSERT INTO `wrm_raid_permission_type` VALUES ('11','drafted_cancel','cancel_row_header');
INSERT INTO `wrm_raid_permission_type` VALUES ('12','drafted_delete','delete_row_header');

-- Acces Controll List Permission Table Creation
-- INSERT INTO `wrm_acl_raid_permission` VALUES ( `raid_permission_type_id`, `permission_type_id`);
-- WRM - Superadmin
INSERT INTO `wrm_acl_raid_permission` VALUES ('2','1');
INSERT INTO `wrm_acl_raid_permission` VALUES ('3','1');
INSERT INTO `wrm_acl_raid_permission` VALUES ('4','1');
INSERT INTO `wrm_acl_raid_permission` VALUES ('7','1');
INSERT INTO `wrm_acl_raid_permission` VALUES ('10','1');
INSERT INTO `wrm_acl_raid_permission` VALUES ('11','1');
INSERT INTO `wrm_acl_raid_permission` VALUES ('12','1');
-- WRM - Raid Leader 
INSERT INTO `wrm_acl_raid_permission` VALUES ('1','2');
INSERT INTO `wrm_acl_raid_permission` VALUES ('2','2');
INSERT INTO `wrm_acl_raid_permission` VALUES ('3','2');
INSERT INTO `wrm_acl_raid_permission` VALUES ('4','2');
INSERT INTO `wrm_acl_raid_permission` VALUES ('5','2');
INSERT INTO `wrm_acl_raid_permission` VALUES ('6','2');
INSERT INTO `wrm_acl_raid_permission` VALUES ('7','2');
INSERT INTO `wrm_acl_raid_permission` VALUES ('8','2');
INSERT INTO `wrm_acl_raid_permission` VALUES ('9','2');
INSERT INTO `wrm_acl_raid_permission` VALUES ('10','2');
INSERT INTO `wrm_acl_raid_permission` VALUES ('11','2');
INSERT INTO `wrm_acl_raid_permission` VALUES ('12','2');
-- WRM - Superadmin
INSERT INTO `wrm_acl_raid_permission` VALUES ('1','3');
INSERT INTO `wrm_acl_raid_permission` VALUES ('2','3');
INSERT INTO `wrm_acl_raid_permission` VALUES ('3','3');
INSERT INTO `wrm_acl_raid_permission` VALUES ('4','3');
INSERT INTO `wrm_acl_raid_permission` VALUES ('5','3');
INSERT INTO `wrm_acl_raid_permission` VALUES ('6','3');
INSERT INTO `wrm_acl_raid_permission` VALUES ('7','3');
INSERT INTO `wrm_acl_raid_permission` VALUES ('8','3');
INSERT INTO `wrm_acl_raid_permission` VALUES ('9','3');
INSERT INTO `wrm_acl_raid_permission` VALUES ('10','3');
INSERT INTO `wrm_acl_raid_permission` VALUES ('11','3');
INSERT INTO `wrm_acl_raid_permission` VALUES ('12','3');

DROP TABLE IF EXISTS `wrm_permissions`;
DROP TABLE IF EXISTS `wrm_acl_raid_signup_group`;

-- Add Colum in Table `announcements`
ALTER TABLE `wrm_announcements` ADD `visible` INT( 2 ) NOT NULL default '1';

-- Resistance Table Creation
DROP TABLE IF EXISTS `wrm_resistance`;
CREATE TABLE  `wrm_resistance` (
  `resistance_id` int(10) NOT NULL auto_increment,
  `resistance_name` varchar(10) NOT NULL,
  `lang_index` varchar(100) NOT NULL,
  `font_color` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY  (`resistance_id`)
);

-- Char Resistance Table Creation
DROP TABLE IF EXISTS `wrm_char_resistance`;
CREATE TABLE  `wrm_char_resistance` (
  `resistance_id` int(10) NOT NULL,
  `char_id` int(10) NOT NULL,
  `resistance_value` int(10) default '0'
);
INSERT INTO `wrm_resistance` ( `resistance_name`,`lang_index`,`font_color`,`image`) VALUES ('arcane','arcane','CCFFCC','images/resistances/arcane_resistance.gif');
INSERT INTO `wrm_resistance` ( `resistance_name`,`lang_index`,`font_color`,`image`) VALUES ('fire','fire','FF0000','images/resistances/fire_resistance.gif');
INSERT INTO `wrm_resistance` ( `resistance_name`,`lang_index`,`font_color`,`image`) VALUES ('frost','frost','0000FF','images/resistances/frost_resistance.gif');
INSERT INTO `wrm_resistance` ( `resistance_name`,`lang_index`,`font_color`,`image`) VALUES ('nature','nature','009900','images/resistances/nature_resistance.gif');
INSERT INTO `wrm_resistance` ( `resistance_name`,`lang_index`,`font_color`,`image`) VALUES ('shadow','shadow','663366','images/resistances/shadow_resistance.gif');

-- Modify/Add Column Header Data - Char1 View
DELETE FROM `wrm_column_headers` WHERE `wrm_column_headers`.`view_name` = 'char1';
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'char1', 'ID', '1', '1', NULL, 'id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'char1', 'Name', '1', '2', NULL, 'name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'char1', 'Guild', '1', '3', NULL, 'guild', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'char1', 'Level', '1', '4', NULL, 'level', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'char1', 'Race', '1', '5', NULL, 'race', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'char1', 'Class', '1', '6', NULL, 'class', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'char1', '@resistance', '1', '7', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'char1', 'Pri_Spec', '1', '12', NULL, 'pri_spec', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'char1', 'Sec_Spec', '1', '13', NULL , 'sec_spec', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'char1', 'Buttons', '1', '14', NULL, 'buttons', NULL);

-- Modify/Add Column Header Data - Roster1 View
DELETE FROM `wrm_column_headers` WHERE `wrm_column_headers`.`view_name` = 'roster1';
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'roster1', 'ID', '1', '1', NULL, 'id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'roster1', 'Name', '1', '2', NULL, 'name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'roster1', 'Guild', '1', '3', NULL, 'guild', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'roster1', 'Level', '1', '4', NULL, 'level', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'roster1', 'Race', '1', '5', NULL, 'race', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'roster1', 'Class', '1', '6', NULL, 'class', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'roster1', '@resistance', '1', '7', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'roster1', 'Pri_Spec', '1', '12', NULL, 'pri_spec', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'roster1', 'Sec_Spec', '1', '13', NULL, 'sec_spec', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'roster1', 'Profile', '1', '14', NULL, 'profile', NULL);

-- Modify/Add Column Header Data - Raidview1 View
DELETE FROM `wrm_column_headers` WHERE `wrm_column_headers`.`view_name` = 'raidview1';
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'ID', '1', '1', NULL, 'id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Name', '1', '2', NULL, 'name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Guild', '1', '3', NULL, 'guild', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Comments', '1', '4', NULL, 'comments', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Team Name', '1', '5', NULL, 'team_name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Level', '1', '6', NULL, 'level', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Race', '1', '7', NULL, 'race', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Class', '1', '8', NULL, 'class', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Pri_Spec', '1', '9', NULL, 'pri_spec', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Sec_Spec', '1', '10', NULL, 'sec_spec', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', '@resistance', '1', '7', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Date', '1', '16', NULL, 'date', 'wrmdate');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Time', '1', '17', NULL, 'time', 'wrmtime');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Buttons', '1', '18', NULL, 'buttons', NULL);

ALTER TABLE `wrm_chars`DROP `arcane`;
ALTER TABLE `wrm_chars`DROP `fire`;
ALTER TABLE `wrm_chars`DROP `frost`;
ALTER TABLE `wrm_chars`DROP `nature`;
ALTER TABLE `wrm_chars` DROP `shadow` 

INSERT INTO `wrm_version` VALUES ('4.2.0','Version 4.2.0 of WoW Raid Manager');
