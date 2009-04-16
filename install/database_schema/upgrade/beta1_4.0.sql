-- *********************************************************
-- *********************************************************
-- *****   DO NOT RUN THIS FILE DIRECTLY ON THE DATABASE
-- *****   YOU WILL LOSE DATA IF YOU DO SO
-- *********************************************************
-- *********************************************************
die, and do not progress past this line!!!!; -- Added to cause the SQL interpreter to blow up if this file is directly executed.

------------------------------------------------------------------
-- Safe Execution - These lines are SAFE to run at ANY point.
------------------------------------------------------------------
-- Manage Primary and Secondary Spec instead of Role.
ALTER TABLE `wrm_chars` CHANGE `role` `pri_spec` VARCHAR( 255 ) NOT NULL;
ALTER TABLE `wrm_chars` ADD `sec_spec` VARCHAR( 255 ) ;

CREATE TABLE IF NOT EXISTS `wrm_classes` (
  `class_id` varchar(100) NOT NULL,
  `class_code` varchar(2) NOT NULL,
  `lang_index` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY  (`class_id`)
);

INSERT INTO `wrm_classes` VALUES ('Death Knight', 'dk', 'deathknight', 'images/classes/deathknight_icon.gif');
INSERT INTO `wrm_classes` VALUES ('Druid', 'dr', 'druid', 'images/classes/druid_icon.gif');
INSERT INTO `wrm_classes` VALUES ('Hunter', 'hu', 'hunter', 'images/classes/hunter_icon.gif');
INSERT INTO `wrm_classes` VALUES ('Mage', 'ma', 'mage', 'images/classes/mage_icon.gif');
INSERT INTO `wrm_classes` VALUES ('Paladin', 'pa', 'paladin', 'images/classes/paladin_icon.gif');
INSERT INTO `wrm_classes` VALUES ('Priest', 'pr', 'priest', 'images/classes/priest_icon.gif');
INSERT INTO `wrm_classes` VALUES ('Rogue', 'ro', 'rogue', 'images/classes/rogue_icon.gif');
INSERT INTO `wrm_classes` VALUES ('Shaman', 'sh', 'shaman', 'images/classes/shaman_icon.gif');
INSERT INTO `wrm_classes` VALUES ('Warlock', 'wk', 'warlock', 'images/classes/warlock_icon.gif');
INSERT INTO `wrm_classes` VALUES ('Warrior', 'wa', 'warrior', 'images/classes/warrior_icon.gif');

CREATE TABLE `wrm_class_race` (
`race_id` VARCHAR( 100 ) NOT NULL ,
`class_id` VARCHAR( 100 ) NOT NULL ,
PRIMARY KEY ( `race_id` , `class_id` )
);

INSERT INTO `wrm_class_race` VALUES ('Draenei', 'Priest');
INSERT INTO `wrm_class_race` VALUES ('Draenei', 'Warrior');
INSERT INTO `wrm_class_race` VALUES ('Draenei', 'Hunter');
INSERT INTO `wrm_class_race` VALUES ('Draenei', 'Mage');
INSERT INTO `wrm_class_race` VALUES ('Draenei', 'Shaman');
INSERT INTO `wrm_class_race` VALUES ('Draenei', 'Paladin');
INSERT INTO `wrm_class_race` VALUES ('Draenei', 'Death Knight');
INSERT INTO `wrm_class_race` VALUES ('Dwarf', 'Priest');
INSERT INTO `wrm_class_race` VALUES ('Dwarf', 'Rogue');
INSERT INTO `wrm_class_race` VALUES ('Dwarf', 'Warrior');
INSERT INTO `wrm_class_race` VALUES ('Dwarf', 'Hunter');
INSERT INTO `wrm_class_race` VALUES ('Dwarf', 'Paladin');
INSERT INTO `wrm_class_race` VALUES ('Dwarf', 'Death Knight');
INSERT INTO `wrm_class_race` VALUES ('Human', 'Priest');
INSERT INTO `wrm_class_race` VALUES ('Human', 'Rogue');
INSERT INTO `wrm_class_race` VALUES ('Human', 'Warrior');
INSERT INTO `wrm_class_race` VALUES ('Human', 'Mage');
INSERT INTO `wrm_class_race` VALUES ('Human', 'Warlock');
INSERT INTO `wrm_class_race` VALUES ('Human', 'Paladin');
INSERT INTO `wrm_class_race` VALUES ('Human', 'Death Knight');
INSERT INTO `wrm_class_race` VALUES ('Gnome', 'Rogue');
INSERT INTO `wrm_class_race` VALUES ('Gnome', 'Warrior');
INSERT INTO `wrm_class_race` VALUES ('Gnome', 'Mage');
INSERT INTO `wrm_class_race` VALUES ('Gnome', 'Warlock');
INSERT INTO `wrm_class_race` VALUES ('Gnome', 'Death Knight');
INSERT INTO `wrm_class_race` VALUES ('Night Elf', 'Priest');
INSERT INTO `wrm_class_race` VALUES ('Night Elf', 'Rogue');
INSERT INTO `wrm_class_race` VALUES ('Night Elf', 'Warrior');
INSERT INTO `wrm_class_race` VALUES ('Night Elf', 'Druid');
INSERT INTO `wrm_class_race` VALUES ('Night Elf', 'Hunter');
INSERT INTO `wrm_class_race` VALUES ('Night Elf', 'Death Knight');
INSERT INTO `wrm_class_race` VALUES ('Blood Elf', 'Priest');
INSERT INTO `wrm_class_race` VALUES ('Blood Elf', 'Rogue');
INSERT INTO `wrm_class_race` VALUES ('Blood Elf', 'Mage');
INSERT INTO `wrm_class_race` VALUES ('Blood Elf', 'Hunter');
INSERT INTO `wrm_class_race` VALUES ('Blood Elf', 'Warlock');
INSERT INTO `wrm_class_race` VALUES ('Blood Elf', 'Paladin');
INSERT INTO `wrm_class_race` VALUES ('Blood Elf', 'Death Knight');
INSERT INTO `wrm_class_race` VALUES ('Orc', 'Rogue');
INSERT INTO `wrm_class_race` VALUES ('Orc', 'Warrior');
INSERT INTO `wrm_class_race` VALUES ('Orc', 'Hunter');
INSERT INTO `wrm_class_race` VALUES ('Orc', 'Warlock');
INSERT INTO `wrm_class_race` VALUES ('Orc', 'Shaman');
INSERT INTO `wrm_class_race` VALUES ('Orc', 'Death Knight');
INSERT INTO `wrm_class_race` VALUES ('Tauren', 'Warrior');
INSERT INTO `wrm_class_race` VALUES ('Tauren', 'Druid');
INSERT INTO `wrm_class_race` VALUES ('Tauren', 'Shaman');
INSERT INTO `wrm_class_race` VALUES ('Tauren', 'Hunter');
INSERT INTO `wrm_class_race` VALUES ('Tauren', 'Death Knight');
INSERT INTO `wrm_class_race` VALUES ('Troll', 'Priest');
INSERT INTO `wrm_class_race` VALUES ('Troll', 'Rogue');
INSERT INTO `wrm_class_race` VALUES ('Troll', 'Warrior');
INSERT INTO `wrm_class_race` VALUES ('Troll', 'Mage');
INSERT INTO `wrm_class_race` VALUES ('Troll', 'Hunter');
INSERT INTO `wrm_class_race` VALUES ('Troll', 'Shaman');
INSERT INTO `wrm_class_race` VALUES ('Troll', 'Death Knight');
INSERT INTO `wrm_class_race` VALUES ('Undead', 'Priest');
INSERT INTO `wrm_class_race` VALUES ('Undead', 'Rogue');
INSERT INTO `wrm_class_race` VALUES ('Undead', 'Warrior');
INSERT INTO `wrm_class_race` VALUES ('Undead', 'Mage');
INSERT INTO `wrm_class_race` VALUES ('Undead', 'Warlock');
INSERT INTO `wrm_class_race` VALUES ('Undead', 'Death Knight');

CREATE TABLE IF NOT EXISTS `wrm_class_role` (
  `class_id` varchar(100) NOT NULL,
  `subclass` varchar(100) NOT NULL,
  `lang_index` varchar(100) NOT NULL,
  `role_id` varchar(10) default NULL,
  PRIMARY KEY  (`class_id`,`subclass`)
);

DELETE FROM `wrm_column_headers` WHERE `view_name` = 'raids1' AND `column_name` = 'Death Knight' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'raids1' AND `column_name` = 'Druid' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'raids1' AND `column_name` = 'Hunter' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'raids1' AND `column_name` = 'Mage' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'raids1' AND `column_name` = 'Paladin' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'raids1' AND `column_name` = 'Priest' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'raids1' AND `column_name` = 'Rogue' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'raids1' AND `column_name` = 'Shaman' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'raids1' AND `column_name` = 'Warlock' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'raids1' AND `column_name` = 'Warrior' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'raids1' AND `column_name` = '@role1' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'raids1' AND `column_name` = '@role2' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'raids1' AND `column_name` = '@role3' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'raids1' AND `column_name` = '@role4' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'raids1' AND `column_name` = '@role5' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'raids1' AND `column_name` = '@role6' LIMIT 1
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', '@class', '1', '7', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', '@role', '1', '17', NULL, NULL, NULL);

DELETE FROM `wrm_column_headers` WHERE `view_name` = 'index1' AND `column_name` = 'Death Knight' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'index1' AND `column_name` = 'Druid' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'index1' AND `column_name` = 'Hunter' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'index1' AND `column_name` = 'Mage' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'index1' AND `column_name` = 'Paladin' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'index1' AND `column_name` = 'Priest' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'index1' AND `column_name` = 'Rogue' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'index1' AND `column_name` = 'Shaman' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'index1' AND `column_name` = 'Warlock' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'index1' AND `column_name` = 'Warrior' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'index1' AND `column_name` = '@role1' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'index1' AND `column_name` = '@role2' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'index1' AND `column_name` = '@role3' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'index1' AND `column_name` = '@role4' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'index1' AND `column_name` = '@role5' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'index1' AND `column_name` = '@role6' LIMIT 1
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', '@class', '1', '8', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', '@role', '1', '18', NULL, NULL, NULL);

DELETE FROM `wrm_column_headers` WHERE `view_name` = 'location1' AND `column_name` = 'Death Knight' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'location1' AND `column_name` = 'Druid' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'location1' AND `column_name` = 'Hunter' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'location1' AND `column_name` = 'Mage' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'location1' AND `column_name` = 'Paladin' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'location1' AND `column_name` = 'Priest' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'location1' AND `column_name` = 'Rogue' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'location1' AND `column_name` = 'Shaman' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'location1' AND `column_name` = 'Warlock' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'location1' AND `column_name` = 'Warrior' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'location1' AND `column_name` = '@role1' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'location1' AND `column_name` = '@role2' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'location1' AND `column_name` = '@role3' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'location1' AND `column_name` = '@role4' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'location1' AND `column_name` = '@role5' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'location1' AND `column_name` = '@role6' LIMIT 1
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', '@class', '1', '7', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', '@role', '1', '17', NULL, NULL, NULL);

DELETE FROM `wrm_column_headers` WHERE `view_name` = 'char1' AND `column_name` = 'Role' LIMIT 1
DELETE FROM `wrm_column_headers` WHERE `view_name` = 'char1' AND `column_name` = 'Buttons' LIMIT 1
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'char1', 'Pri_Spec', '1', '12', NULL, 'pri_spec', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'char1', 'Sec_Spec', '1', '13', NULL, 'sec_spec', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'char1', 'Buttons', '1', '14', NULL, 'buttons', NULL);

UPDATE `wrm_column_headers` SET `column_name` = 'Pri_Spec', `lang_idx_hdr` = 'pri_spec' WHERE `view_name` = 'raidview1' and `column_name` = 'Role' LIMIT 1 ;
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Sec_Spec', '1', '10', NULL, 'sec_spec', NULL);
UPDATE `wrm_column_headers` SET `position` = '11' WHERE `view_name` = 'raidview1' and `column_name` = 'Arcane' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `position` = '12' WHERE `view_name` = 'raidview1' and `column_name` = 'Fire' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `position` = '13' WHERE `view_name` = 'raidview1' and `column_name` = 'Nature' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `position` = '14' WHERE `view_name` = 'raidview1' and `column_name` = 'Frost' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `position` = '15' WHERE `view_name` = 'raidview1' and `column_name` = 'Shadow' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `position` = '16' WHERE `view_name` = 'raidview1' and `column_name` = 'Date' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `position` = '17' WHERE `view_name` = 'raidview1' and `column_name` = 'Time' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `position` = '18' WHERE `view_name` = 'raidview1' and `column_name` = 'Buttons' LIMIT 1 ;

DELETE FROM `wrm_column_headers` WHERE `view_name` = 'raidview2' AND `column_name` = 'Role' LIMIT 1
UPDATE `wrm_column_headers` SET `position` = '9' WHERE `view_name` = 'raidview2' and `column_name` = 'Date' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `position` = '10' WHERE `view_name` = 'raidview2' and `column_name` = 'Time' LIMIT 1 ;
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview2', 'Signup_Spec', '1', '11', NULL, 'signup_spec', NULL);
UPDATE `wrm_column_headers` SET `position` = '12' WHERE `view_name` = 'raidview2' and `column_name` = 'Buttons' LIMIT 1 ;

UPDATE `wrm_config` SET `config_value` = 'us' WHERE 'armory_language' = 'en' LIMIT 1 ;
INSERT INTO `wrm_config` VALUES ('armory_cache_setting', 'none');
DELETE FROM `wrm_config` WHERE `config_name` = 'role1_name';
DELETE FROM `wrm_config` WHERE `config_name` = 'role2_name';
DELETE FROM `wrm_config` WHERE `config_name` = 'role3_name';
DELETE FROM `wrm_config` WHERE `config_name` = 'role4_name';
DELETE FROM `wrm_config` WHERE `config_name` = 'role5_name';
DELETE FROM `wrm_config` WHERE `config_name` = 'role6_name';

INSERT INTO `wrm`.`wrm_events` (`event_id`, `zone_desc`, `max`, `exp_id`, `event_type_id`, `wow_name`, `icon_path`) VALUES ('122', 'Ulduar', '10', '3', '1', 'Ulduar', 'images/instances/WotLK_Icons/10-Ulduar.jpg');
INSERT INTO `wrm`.`wrm_events` (`event_id`, `zone_desc`, `max`, `exp_id`, `event_type_id`, `wow_name`, `icon_path`) VALUES ('123', 'Ulduar - Heroic', '25', '3', '1', 'Ulduar (Heroic)', 'images/instances/WotLK_Icons/25-Ulduar.jpg');

-- Gender Table Creation
CREATE TABLE IF NOT EXISTS `wrm_gender` (
  `gender_id` varchar(10) NOT NULL,
  `lang_index` varchar(100) NOT NULL,
  PRIMARY KEY  (`gender_id`)
);

-- Gender Table Data
INSERT INTO `wrm_gender` VALUES ('male', 'male');
INSERT INTO `wrm_gender` VALUES ('female', 'female');

-- Take all xx_lmt values from location table and expand into wrm_loc_class_lmt.
CREATE TABLE IF NOT EXISTS `wrm_loc_class_lmt` (
  `location_id` int(10) NOT NULL,
  `class_id` varchar(100) NOT NULL,
  `lmt` int(2) NOT NULL,
  PRIMARY KEY  (`location_id`,`class_id`)
);

-- Take all roleX_lmt values from location table and expand into wrm_loc_role_lmt.
CREATE TABLE IF NOT EXISTS `wrm_loc_role_lmt` (
  `location_id` int(10) NOT NULL,
  `role_id` varchar(10) NOT NULL,
  `lmt` int(2) NOT NULL,
  PRIMARY KEY  (`location_id`,`role_id`)
);

CREATE TABLE IF NOT EXISTS `wrm_races` (
  `race_id` varchar(100) NOT NULL,
  `faction` varchar(100) NOT NULL,
  `lang_index` varchar(100) NOT NULL,
  PRIMARY KEY  (`race_id`)
);

INSERT INTO `wrm_races` VALUES ('Draenei', 'Alliance', 'draenei');
INSERT INTO `wrm_races` VALUES ('Dwarf', 'Alliance', 'dwarf');
INSERT INTO `wrm_races` VALUES ('Human', 'Alliance', 'human');
INSERT INTO `wrm_races` VALUES ('Gnome', 'Alliance', 'gnome');
INSERT INTO `wrm_races` VALUES ('Night Elf', 'Alliance', 'night_elf');
INSERT INTO `wrm_races` VALUES ('Blood Elf', 'Horde', 'blood_elf');
INSERT INTO `wrm_races` VALUES ('Orc', 'Horde', 'orc');
INSERT INTO `wrm_races` VALUES ('Tauren', 'Horde', 'tauren');
INSERT INTO `wrm_races` VALUES ('Troll', 'Horde', 'troll');
INSERT INTO `wrm_races` VALUES ('Undead', 'Horde', 'undead');

CREATE TABLE IF NOT EXISTS `wrm_race_gender` (
  `race_id` varchar(100) NOT NULL,
  `gender_id` varchar(10) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY  (`race_id`,`gender_id`)
);

INSERT INTO `wrm_race_gender` VALUES ('Draenei', 'male', '/images/faces/dr_male.gif');
INSERT INTO `wrm_race_gender` VALUES ('Draenei', 'female', '/images/faces/dr_female.gif');
INSERT INTO `wrm_race_gender` VALUES ('Dwarf', 'male', '/images/faces/dw_male.gif');
INSERT INTO `wrm_race_gender` VALUES ('Dwarf', 'female', '/images/faces/dw_female.gif');
INSERT INTO `wrm_race_gender` VALUES ('Human', 'male', '/images/faces/hu_male.gif');
INSERT INTO `wrm_race_gender` VALUES ('Human', 'female', '/images/faces/hu_female.gif');
INSERT INTO `wrm_race_gender` VALUES ('Gnome', 'male', '/images/faces/gn_male.gif');
INSERT INTO `wrm_race_gender` VALUES ('Gnome', 'female', '/images/faces/gn_female.gif');
INSERT INTO `wrm_race_gender` VALUES ('Night Elf', 'male', '/images/faces/ne_male.gif');
INSERT INTO `wrm_race_gender` VALUES ('Night Elf', 'female', '/images/faces/ne_female.gif');
INSERT INTO `wrm_race_gender` VALUES ('Blood Elf', 'male', '/images/faces/be_male.gif');
INSERT INTO `wrm_race_gender` VALUES ('Blood Elf', 'female', '/images/faces/be_female.gif');
INSERT INTO `wrm_race_gender` VALUES ('Orc', 'male', '/images/faces/or_male.gif');
INSERT INTO `wrm_race_gender` VALUES ('Orc', 'female', '/images/faces/or_female.gif');
INSERT INTO `wrm_race_gender` VALUES ('Tauren', 'male', '/images/faces/ta_male.gif');
INSERT INTO `wrm_race_gender` VALUES ('Tauren', 'female', '/images/faces/ta_female.gif');
INSERT INTO `wrm_race_gender` VALUES ('Troll', 'male', '/images/faces/tr_male.gif');
INSERT INTO `wrm_race_gender` VALUES ('Troll', 'female', '/images/faces/tr_female.gif');
INSERT INTO `wrm_race_gender` VALUES ('Undead', 'male', '/images/faces/un_male.gif');
INSERT INTO `wrm_race_gender` VALUES ('Undead', 'female', '/images/faces/un_female.gif');

-- Take all xx_lmt values from raid table and expand into wrm_raid_class_lmt.
CREATE TABLE IF NOT EXISTS `wrm_raid_class_lmt` (
  `raid_id` int(10) NOT NULL,
  `class_id` varchar(100) NOT NULL,
  `lmt` int(2) NOT NULL,
  PRIMARY KEY  (`raid_id`,`class_id`)
);

-- Take all roleX_lmt values from raid table and expand into wrm_raid_role_lmt.
CREATE TABLE IF NOT EXISTS `wrm_raid_role_lmt` (
  `raid_id` int(10) NOT NULL,
  `role_id` varchar(10) NOT NULL,
  `lmt` int(2) NOT NULL,
  PRIMARY KEY  (`raid_id`,`role_id`)
);

CREATE TABLE IF NOT EXISTS `wrm_roles` (
  `role_id` varchar(10) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `lang_index` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY  (`role_id`)
);

-- Add selected spec to the signups field.
ALTER TABLE `wrm_signups` ADD `selected_spec` VARCHAR( 100 ) NOT NULL ;

INSERT INTO `wrm_version` VALUES ('3.9.9.2.1','4.0 Beta 2 Release 1');

UPDATE `wrm_config` SET `config_value` = 'us' WHERE `config_name` = 'armory_language' AND `config_value` = 'en' LIMIT 1;
UPDATE `wrm_config` SET `config_value` = 'default' WHERE `config_name` = 'template' AND `config_value` = 'SpiffyJr' LIMIT 1;

-------------------------------------------------------------------
-- Manual Changes - The lines below MUST be modified manually to make
--    sense for YOUR environment.
-------------------------------------------------------------------
-- Edit Role Names (middle column) below for roles you support.  Remove/Blank roles you 
--  do not need. (i.e. Role 5 and 6 below can be removed if not needed).  Add lines for 
--  roles you need to add (more than 6 supported).  First column MUST be role# where # is
--  a string of digits (role7, role8, role10, etc.), and make sure the last column
--  (configuration_...) is in your language files for the language(s) you use.
INSERT INTO `wrm_roles` VALUES ('role1', 'Tank', 'configuration_role1_text','');
INSERT INTO `wrm_roles` VALUES ('role2', 'Melee', 'configuration_role2_text','');
INSERT INTO `wrm_roles` VALUES ('role3', 'Healing', 'configuration_role3_text','');
INSERT INTO `wrm_roles` VALUES ('role4', 'Ranged', 'configuration_role4_text','');
INSERT INTO `wrm_roles` VALUES ('role5', 'misc1', 'configuration_role5_text','');
INSERT INTO `wrm_roles` VALUES ('role6', 'misc2', 'configuration_role6_text','');

-- Based upon Role Names above, edit the last column for each class Talent Spec to match
--   the role you want that spec to provide.  For instance in the first line below, in the
--   "Priest" class, a "Discipline" priest is considered Role3 (Healing from above).  If 
--   instead you wanted a Discipline priest to be "Ranged" you would change the text 'role3'
--   to 'role4'.
INSERT INTO `wrm_class_role` VALUES ('Priest', 'Discipline', 'disc', 'role3');
INSERT INTO `wrm_class_role` VALUES ('Priest', 'Holy', 'holy', 'role3');
INSERT INTO `wrm_class_role` VALUES ('Priest', 'Shadow', 'shadow', 'role4');
INSERT INTO `wrm_class_role` VALUES ('Rogue', 'Assassination', 'assassination', 'role2');
INSERT INTO `wrm_class_role` VALUES ('Rogue', 'Combat', 'combat', 'role2');
INSERT INTO `wrm_class_role` VALUES ('Rogue', 'Subtlety', 'subtlety', 'role2');
INSERT INTO `wrm_class_role` VALUES ('Warrior', 'Arms', 'arms', 'role2');
INSERT INTO `wrm_class_role` VALUES ('Warrior', 'Fury', 'fury', 'role2');
INSERT INTO `wrm_class_role` VALUES ('Warrior', 'Protection', 'prot', 'role1');
INSERT INTO `wrm_class_role` VALUES ('Mage', 'Arcane', 'arcane', 'role4');
INSERT INTO `wrm_class_role` VALUES ('Mage', 'Fire', 'fire', 'role4');
INSERT INTO `wrm_class_role` VALUES ('Mage', 'Frost', 'frost', 'role4');
INSERT INTO `wrm_class_role` VALUES ('Druid', 'Balance', 'balance', 'role4');
INSERT INTO `wrm_class_role` VALUES ('Druid', 'Feral (Cat)', 'cat', 'role2');
INSERT INTO `wrm_class_role` VALUES ('Druid', 'Feral (Bear)', 'bear', 'role1');
INSERT INTO `wrm_class_role` VALUES ('Druid', 'Restoration', 'resto', 'role3');
INSERT INTO `wrm_class_role` VALUES ('Hunter', 'Beast Mastery', 'bm', 'role4');
INSERT INTO `wrm_class_role` VALUES ('Hunter', 'Marksmanship', 'marks', 'role4');
INSERT INTO `wrm_class_role` VALUES ('Hunter', 'Survival', 'survival', 'role4');
INSERT INTO `wrm_class_role` VALUES ('Warlock', 'Affliction', 'affliction', 'role4');
INSERT INTO `wrm_class_role` VALUES ('Warlock', 'Demonology', 'demon', 'role4');
INSERT INTO `wrm_class_role` VALUES ('Warlock', 'Destruction', 'destro', 'role4');
INSERT INTO `wrm_class_role` VALUES ('Shaman', 'Elemental', 'elemental', 'role4');
INSERT INTO `wrm_class_role` VALUES ('Shaman', 'Enhancement', 'enhance', 'role2');
INSERT INTO `wrm_class_role` VALUES ('Shaman', 'Restoration', 'resto', 'role3');
INSERT INTO `wrm_class_role` VALUES ('Paladin', 'Holy', 'holy', 'role3');
INSERT INTO `wrm_class_role` VALUES ('Paladin', 'Protection', 'prot', 'role1');
INSERT INTO `wrm_class_role` VALUES ('Paladin', 'Retribution', 'ret', 'role2');
INSERT INTO `wrm_class_role` VALUES ('Death Knight', 'Blood', 'blood', 'role2');
INSERT INTO `wrm_class_role` VALUES ('Death Knight', 'Frost', 'frost', 'role1');
INSERT INTO `wrm_class_role` VALUES ('Death Knight', 'Unholy', 'unholy', 'role2');

-------------------------------------------------------------------
-- Data Migration Prior to Run - DO NOT RUN these lines till you have
--    executed "migrate.php" from your web browser.
-------------------------------------------------------------------
-- Take all xx_lmt values from location table and expand into wrm_loc_class_lmt.
-- Take all roleX_lmt values from location table and expand into wrm_loc_role_lmt.
-- Take all xx_lmt values from raid table and expand into wrm_raid_class_lmt.
-- Take all roleX_lmt values from raid table and expand into wrm_raid_role_lmt.

-- Move all location limit data to loc_limits
ALTER TABLE `wrm_locations`
  DROP `dk`, DROP `dr`,  DROP `hu`,  DROP `ma`,  DROP `pa`,  DROP `pr`,  DROP `ro`,  
  DROP `sh`, DROP `wk`,  DROP `wa`,  DROP `role1`,  DROP `role2`,  DROP `role3`,  
  DROP `role4`,  DROP `role5`,  DROP `role6`;

-- Move all raid limit data to raid_limits
ALTER TABLE `wrm_raids`
  DROP `dk_lmt`, DROP `dr_lmt`, DROP `hu_lmt`, DROP `ma_lmt`, DROP `pa_lmt`, DROP `pr_lmt`, 
  DROP `sh_lmt`, DROP `ro_lmt`, DROP `wk_lmt`, DROP `wa_lmt`, DROP `role1_lmt`, 
  DROP `role2_lmt`, DROP `role3_lmt`, DROP `role4_lmt`, DROP `role5_lmt`, DROP `role6_lmt`;  

-------------------------------------------------------------------
-- Other Migration Notes - These are things that MUST be done by your
--    users.
-------------------------------------------------------------------
-- 1) All Characters must be edited and re-roled.
-- 2) All Roles must be gone back over to check for proper location limit data.
-- 3) All Raids must be gone back over to check for proper limit data.
