-- Announcements Table Creation
DROP TABLE IF EXISTS `wrm_announcements`;
CREATE TABLE  `wrm_announcements` (
  `announcements_id` int(10) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `message` text NOT NULL,
  `timestamp` varchar(255) NOT NULL default '',
  `posted_by` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`announcements_id`)
) ;

-- Character Table Creation
DROP TABLE IF EXISTS `wrm_chars`;
CREATE TABLE  `wrm_chars` (
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
) ;

-- Column Header Creation
DROP TABLE IF EXISTS `wrm_column_headers`;
CREATE TABLE `wrm_column_headers` (
`ID` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`view_name` VARCHAR( 50 ) NOT NULL ,
`column_name` VARCHAR( 50 ) NOT NULL ,
`visible` TINYINT( 1 ) NOT NULL DEFAULT '1',
`position` TINYINT( 2 ) NOT NULL ,
`img_url` VARCHAR( 100 ) DEFAULT NULL,
`lang_idx_hdr` VARCHAR ( 50 ) DEFAULT NULL,
`format_code` VARCHAR ( 25 ) DEFAULT NULL,
INDEX ( `view_name` )
) ;

-- Column Header Data - Raids1 View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'ID', '1', '1', NULL, 'id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Date', '1', '2', NULL, 'date', 'wrmdate');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Dungeon', '1', '3', NULL, 'raids_dungeon', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Invite Time', '1', '4', NULL, 'invite_time', 'wrmtime');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Start Time', '1', '5', NULL, 'start_time', 'wrmtime');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Creator', '1', '6', NULL, 'officer', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Death Knight', '1', '7', 'images/classes/deathknight_icon.gif', 'deathknight', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Druid', '1', '8', 'images/classes/druid_icon.gif', 'druid', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Hunter', '1', '9', 'images/classes/hunter_icon.gif', 'hunter', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Mage', '1', '10', 'images/classes/mage_icon.gif', 'mage', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Paladin', '1', '11', 'images/classes/paladin_icon.gif', 'paladin', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Priest', '1', '12', 'images/classes/priest_icon.gif', 'priest', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Rogue', '1', '13', 'images/classes/rogue_icon.gif', 'rogue', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Shaman', '1', '14', 'images/classes/shaman_icon.gif', 'shaman', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Warlock', '1', '15', 'images/classes/warlock_icon.gif', 'warlock', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Warrior', '1', '16', 'images/classes/warrior_icon.gif', 'warrior', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', '@role1', '1', '17', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', '@role2', '1', '18', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', '@role3', '1', '19', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', '@role4', '1', '20', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', '@role5', '1', '21', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', '@role6', '1', '22', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Totals', '1', '23', NULL, 'totals', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Buttons', '1', '24', NULL, 'buttons', NULL);
-- Column Header Data - Index1 View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', 'Signup', '1', '1', NULL, 'signup', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', 'ID', '1', '2', NULL, 'id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', 'Date', '1', '3', NULL, 'date', 'wrmdate');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', 'Dungeon', '1', '4', NULL, 'raids_dungeon', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', 'Invite Time', '1', '5', NULL, 'invite_time', 'wrmtime');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', 'Start Time', '1', '6', NULL, 'start_time', 'wrmtime');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', 'Creator', '1', '7', NULL, 'officer', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', 'Death Knight', '1', '8', 'images/classes/deathknight_icon.gif', 'deathknight', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', 'Druid', '1', '9', 'images/classes/druid_icon.gif', 'druid', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', 'Hunter', '1', '10', 'images/classes/hunter_icon.gif', 'hunter', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', 'Mage', '1', '11', 'images/classes/mage_icon.gif', 'hunter', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', 'Paladin', '1', '12', 'images/classes/paladin_icon.gif', 'paladin', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', 'Priest', '1', '13', 'images/classes/priest_icon.gif', 'priest', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', 'Rogue', '1', '14', 'images/classes/rogue_icon.gif', 'rogue', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', 'Shaman', '1', '15', 'images/classes/shaman_icon.gif', 'shaman', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', 'Warlock', '1', '16', 'images/classes/warlock_icon.gif', 'warlock', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', 'Warrior', '1', '17', 'images/classes/warrior_icon.gif', 'warrior', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', '@role1', '1', '18', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', '@role2', '1', '19', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', '@role3', '1', '20', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', '@role4', '1', '21', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', '@role5', '1', '22', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', '@role6', '1', '23', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', 'Totals', '1', '24', NULL, 'totals', NULL);
-- Column Header Data - Announcements1 View
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
VALUES (NULL , 'announcements1', 'Buttons', '1', '7', NULL, 'buttons', NULL);
-- Column Header Data - DKP1 View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'dkp1', 'ID', '1', '1', NULL, 'id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'dkp1', 'Name', '1', '2', NULL, 'name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'dkp1', 'Class', '1', '3', NULL, 'class', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'dkp1', 'Earned', '1', '4', NULL, 'earned', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'dkp1', 'Spent', '1', '5', NULL, 'spent', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'dkp1', 'Adjustment', '1', '6', NULL, 'adjustment', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'dkp1', 'DKP', '1', '7', NULL, 'dkp', NULL);
-- Column Header Data - Team1 View (Remove)
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'team1', 'ID', '1', '1', NULL, 'id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'team1', 'Name', '1', '2', NULL, 'name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'team1', 'Class', '1', '3', NULL, 'class', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'team1', 'Guild', '1', '4', NULL, 'guild', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'team1', 'Level', '1', '5', NULL, 'level', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'team1', 'Team Name', '1', '6', NULL, 'team_name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'team1', 'Buttons', '1', '7', NULL, 'buttons', NULL);
-- Column Header Data - Team2 View (Add)
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'team2', 'ID', '1', '1', NULL, 'id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'team2', 'Name', '1', '2', NULL, 'name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'team2', 'Class', '1', '3', NULL, 'class', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'team2', 'Guild', '1', '4', NULL, 'guild', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'team2', 'Level', '1', '5', NULL, 'level', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'team2', 'Add To Team', '1', '7', NULL, 'add_to_team', NULL);
-- Column Header Data - Guild1 View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'guild1', 'ID', '1', '1', NULL, 'id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'guild1', 'Guild Name', '1', '2', NULL, 'guild_name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'guild1', 'Guild Tag', '1', '3', NULL, 'guild_tag', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'guild1', 'Guild Master', '1', '4', NULL, 'guild_master', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'guild1', 'Buttons', '1', '5', NULL, 'buttons', NULL);
-- Column Header Data - Location1 View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'ID', '1', '1', NULL, 'id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Name', '1', '2', NULL, 'name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Dungeon', '1', '3', NULL, 'raids_dungeon', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Event Type', '1', '4', NULL, 'raids_eventtype_text', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Min Level', '1', '5', NULL, 'min_lvl', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Max Level', '1', '6', NULL, 'max_lvl', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Death Knight', '1', '7', 'images/classes/deathknight_icon.gif', 'deathknight', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Druid', '1', '8', 'images/classes/druid_icon.gif', 'druid', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Hunter', '1', '9', 'images/classes/hunter_icon.gif', 'hunter', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Mage', '1', '10', 'images/classes/mage_icon.gif', 'hunter', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Paladin', '1', '11', 'images/classes/paladin_icon.gif', 'paladin', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Priest', '1', '12', 'images/classes/priest_icon.gif', 'priest', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Rogue', '1', '13', 'images/classes/rogue_icon.gif', 'rogue', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Shaman', '1', '14', 'images/classes/shaman_icon.gif', 'shaman', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Warlock', '1', '15', 'images/classes/warlock_icon.gif', 'warlock', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Warrior', '1', '16', 'images/classes/warrior_icon.gif', 'warrior', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', '@role1', '1', '17', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', '@role2', '1', '18', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', '@role3', '1', '19', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', '@role4', '1', '20', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', '@role5', '1', '21', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', '@role6', '1', '22', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Raid Max', '1', '23', NULL, 'max_raiders', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Locked', '1', '24', NULL, 'locked_header', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Buttons', '1', '25', NULL, 'buttons', NULL);
-- Column Header Data - Char1 View
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
VALUES (NULL , 'char1', 'Arcane', '1', '7', '/images/resistances/arcane_resistance.gif', 'arcane', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'char1', 'Fire', '1', '8', '/images/resistances/fire_resistance.gif', 'fire', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'char1', 'Frost', '1', '9', '/images/resistances/frost_resistance.gif', 'frost', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'char1', 'Nature', '1', '10', '/images/resistances/nature_resistance.gif', 'nature', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'char1', 'Shadow', '1', '11', '/images/resistances/shadow_resistance.gif', 'shadow', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'char1', 'Role', '1', '12', NULL, 'role', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'char1', 'Buttons', '1', '13', NULL, 'buttons', NULL);
-- Column Header Data - Users1 View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'users1', 'ID', '1', '1', NULL, 'id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'users1', 'Username', '1', '2', NULL, 'username', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'users1', 'E-Mail', '1', '3', NULL, 'email', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'users1', 'Privileges', '1', '4', NULL, 'priv', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'users1', 'Last Login Date', '1', '5', NULL, 'last_login_date', 'wrmdate');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'users1', 'Last Login Time', '1', '6', NULL, 'last_login_time', 'wrmtime');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'users1', 'Buttons', '1', '7', NULL, 'buttons', NULL);
-- Column Header Data - roster1 View
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
VALUES (NULL , 'roster1', 'Arcane', '1', '7', '/images/resistances/arcane_resistance.gif', 'arcane', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'roster1', 'Fire', '1', '8', '/images/resistances/fire_resistance.gif', 'fire', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'roster1', 'Frost', '1', '9', '/images/resistances/frost_resistance.gif', 'frost', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'roster1', 'Nature', '1', '10', '/images/resistances/nature_resistance.gif', 'nature', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'roster1', 'Shadow', '1', '11', '/images/resistances/shadow_resistance.gif', 'shadow', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'roster1', 'Role', '1', '12', NULL, 'role', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'roster1', 'Profile', '1', '13', NULL, 'profile', NULL);
-- Column Header Data - Permissions1 View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'permissions1', 'ID', '1', '1', NULL, 'id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'permissions1', 'Name', '1', '2', NULL, 'name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'permissions1', 'Description', '1', '3', NULL, 'Description', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'permissions1', 'An', '1', '4', NULL, 'announcements', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'permissions1', 'Co', '1', '5', NULL, 'configuration', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'permissions1', 'Gu', '1', '6', NULL, 'guilds', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'permissions1', 'Lo', '1', '7', NULL, 'locations', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'permissions1', 'Lg', '1', '8', NULL, 'logs', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'permissions1', 'Pe', '1', '9', NULL, 'permissions', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'permissions1', 'Pr', '1', '10', NULL, 'profile', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'permissions1', 'Us', '1', '11', NULL, 'users', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'permissions1', 'Ra', '1', '12', NULL, 'raids', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'permissions1', 'Buttons', '1', '13', NULL, 'buttons', NULL);
-- Column Header Data - Permissions2 View - User Details
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'permissions2', 'ID', '1', '1', NULL, 'id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'permissions2', 'Username', '1', '2', NULL, 'username', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'permissions2', 'E-Mail', '1', '3', NULL, 'email', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'permissions2', 'Buttons', '1', '4', NULL, 'buttons', NULL);
-- Column Header Data - raidview1 View
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
VALUES (NULL , 'raidview1', 'Role', '1', '9', NULL, 'role', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Arcane', '1', '10', '/images/resistances/arcane_resistance.gif', 'arcane', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Fire', '1', '11', '/images/resistances/fire_resistance.gif', 'fire', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Nature', '1', '12', '/images/resistances/nature_resistance.gif', 'nature', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Frost', '1', '13', '/images/resistances/frost_resistance.gif', 'frost', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Shadow', '1', '14', '/images/resistances/shadow_resistance.gif', 'shadow', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Date', '1', '15', NULL, 'date', 'wrmdate');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Time', '1', '16', NULL, 'time', 'wrmtime');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Buttons', '1', '17', NULL, 'buttons', NULL);
-- Column Header Data - raidview2 View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview2', 'ID', '1', '1', NULL, 'id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview2', 'Name', '1', '2', NULL, 'name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview2', 'Guild', '1', '3', NULL, 'guild', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview2', 'Comments', '1', '4', NULL, 'comments', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview2', 'Level', '1', '6', NULL, 'level', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview2', 'Race', '1', '7', NULL, 'race', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview2', 'Class', '1', '8', NULL, 'class', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview2', 'Role', '1', '9', NULL, 'role', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview2', 'Date', '1', '15', NULL, 'date', 'wrmdate');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview2', 'Time', '1', '16', NULL, 'time', 'wrmtime');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview2', 'Buttons', '1', '17', NULL, 'buttons', NULL);

-- Config Table Creation
DROP TABLE IF EXISTS `wrm_config`;
CREATE TABLE  `wrm_config` (
  `config_name` varchar(255) NOT NULL default '',
  `config_value` varchar(255) NOT NULL default ''
) ;

-- Config Table Data
INSERT INTO `wrm_config` VALUES ('admin_email','webmaster@yourdomain.com');
INSERT INTO `wrm_config` VALUES ('anon_view', '1');
INSERT INTO `wrm_config` VALUES ('auto_queue','0');
INSERT INTO `wrm_config` VALUES ('date_format','m/d/Y');
INSERT INTO `wrm_config` VALUES ('debug','0');
INSERT INTO `wrm_config` VALUES ('default_group','2');
INSERT INTO `wrm_config` VALUES ('disable','0');
INSERT INTO `wrm_config` VALUES ('disable_freeze','0');
INSERT INTO `wrm_config` VALUES ('dst','0');
INSERT INTO `wrm_config` VALUES ('email_signature','Thanks');
INSERT INTO `wrm_config` VALUES ('faction','alliance');
INSERT INTO `wrm_config` VALUES ('guild_description','raid management made easy');
INSERT INTO `wrm_config` VALUES ('guild_name','WoW Raid Manager');
INSERT INTO `wrm_config` VALUES ('guild_server','Illidan');
INSERT INTO `wrm_config` VALUES ('header_link','http://www.yourdomain.com/');
INSERT INTO `wrm_config` VALUES ('header_logo','templates/default/images/logo_phpRaid.jpg');
INSERT INTO `wrm_config` VALUES ('language','english');
INSERT INTO `wrm_config` VALUES ('multiple_signups','0');
INSERT INTO `wrm_config` VALUES ('phpraid_addon_link','http://www.wowraidmanager.net');
INSERT INTO `wrm_config` VALUES ('armory_link','http://www.wowarmory.com');
INSERT INTO `wrm_config` VALUES ('armory_language','en');
INSERT INTO `wrm_config` VALUES ('register_url','register.php');
INSERT INTO `wrm_config` VALUES ('roster_integration','0');
INSERT INTO `wrm_config` VALUES ('show_id','0');
INSERT INTO `wrm_config` VALUES ('showphpraid_addon','1');
INSERT INTO `wrm_config` VALUES ('template','default');
INSERT INTO `wrm_config` VALUES ('time_format','h:i a');
INSERT INTO `wrm_config` VALUES ('timezone','-0600');
INSERT INTO `wrm_config` VALUES ('resop', '0');
INSERT INTO `wrm_config` VALUES ('enable_five_man', '0');
INSERT INTO `wrm_config` VALUES ('user_queue_promote', '0');
INSERT INTO `wrm_config` VALUES ('user_queue_comments', '1');
INSERT INTO `wrm_config` VALUES ('user_queue_cancel', '1');
INSERT INTO `wrm_config` VALUES ('user_queue_delete', '1');
INSERT INTO `wrm_config` VALUES ('user_cancel_queue', '1');
INSERT INTO `wrm_config` VALUES ('user_cancel_promote', '0');
INSERT INTO `wrm_config` VALUES ('user_cancel_comments', '1');
INSERT INTO `wrm_config` VALUES ('user_cancel_delete', '0');
INSERT INTO `wrm_config` VALUES ('user_drafted_queue', '1');
INSERT INTO `wrm_config` VALUES ('user_drafted_comments', '1');
INSERT INTO `wrm_config` VALUES ('user_drafted_cancel', '1');
INSERT INTO `wrm_config` VALUES ('user_drafted_delete', '0');
INSERT INTO `wrm_config` VALUES ('rl_queue_promote', '1');
INSERT INTO `wrm_config` VALUES ('rl_queue_comments', '1');
INSERT INTO `wrm_config` VALUES ('rl_queue_cancel', '0');
INSERT INTO `wrm_config` VALUES ('rl_queue_delete', '0');
INSERT INTO `wrm_config` VALUES ('rl_cancel_queue', '0');
INSERT INTO `wrm_config` VALUES ('rl_cancel_promote', '0');
INSERT INTO `wrm_config` VALUES ('rl_cancel_comments', '1');
INSERT INTO `wrm_config` VALUES ('rl_cancel_delete', '1');
INSERT INTO `wrm_config` VALUES ('rl_drafted_queue', '1');
INSERT INTO `wrm_config` VALUES ('rl_drafted_comments', '1');
INSERT INTO `wrm_config` VALUES ('rl_drafted_cancel', '0');
INSERT INTO `wrm_config` VALUES ('rl_drafted_delete', '0');
INSERT INTO `wrm_config` VALUES ('admin_queue_promote', '1');
INSERT INTO `wrm_config` VALUES ('admin_queue_comments', '1');
INSERT INTO `wrm_config` VALUES ('admin_queue_cancel', '0');
INSERT INTO `wrm_config` VALUES ('admin_queue_delete', '0');
INSERT INTO `wrm_config` VALUES ('admin_cancel_queue', '0');
INSERT INTO `wrm_config` VALUES ('admin_cancel_promote', '0');
INSERT INTO `wrm_config` VALUES ('admin_cancel_comments', '1');
INSERT INTO `wrm_config` VALUES ('admin_cancel_delete', '1');
INSERT INTO `wrm_config` VALUES ('admin_drafted_queue', '1');
INSERT INTO `wrm_config` VALUES ('admin_drafted_comments', '1');
INSERT INTO `wrm_config` VALUES ('admin_drafted_cancel', '0');
INSERT INTO `wrm_config` VALUES ('admin_drafted_delete', '0');
INSERT INTO `wrm_config` VALUES ('rss_site_url', 'http://localhost/phpraid');
INSERT INTO `wrm_config` VALUES ('rss_export_url', 'http://localhost/phpraid');
INSERT INTO `wrm_config` VALUES ('rss_feed_amt', '5');
INSERT INTO `wrm_config` VALUES ('armory_link','http://www.wowarmory.com');
INSERT INTO `wrm_config` VALUES ('armory_language','en');
INSERT INTO `wrm_config` VALUES ('role1_name','tank');
INSERT INTO `wrm_config` VALUES ('role2_name','melee');
INSERT INTO `wrm_config` VALUES ('role3_name','healer');
INSERT INTO `wrm_config` VALUES ('role4_name','ranged');
INSERT INTO `wrm_config` VALUES ('role5_name','misc1');
INSERT INTO `wrm_config` VALUES ('role6_name','misc2');
INSERT INTO `wrm_config` VALUES ('enforce_role_limits', '1');
INSERT INTO `wrm_config` VALUES ('enforce_class_limits', '0');
INSERT INTO `wrm_config` VALUES ('class_as_min', '1');
INSERT INTO `wrm_config` VALUES ('enable_armory', '1');
INSERT INTO `wrm_config` VALUES ('enable_eqdkp', '0');
INSERT INTO `wrm_config` VALUES ('eqdkp_url', 'http://localhost/eqdkp');
INSERT INTO `wrm_config` VALUES ('ampm', '12');
INSERT INTO `wrm_config` VALUES ('raid_view_type','by_class');
INSERT INTO `wrm_config` VALUES ('records_per_page','2');

-- Events Table Creation
DROP TABLE IF EXISTS `wrm_events`;
CREATE TABLE `wrm_events` (
  `event_id` int(10) NOT NULL auto_increment,
  `zone_desc` varchar(50) NOT NULL,
  `max` tinyint(2) NOT NULL,
  `exp_id` tinyint(2) NOT NULL,
  `event_type_id` tinyint(2) NOT NULL,
  `wow_name` varchar(50) NOT NULL,
  `icon_path` varchar(100) NOT NULL,
  PRIMARY KEY  (`event_id`)
) ;

-- Event Table Data
INSERT INTO `wrm_events` (`event_id`, `zone_desc`, `max`, `exp_id`, `event_type_id`, `wow_name`, `icon_path`) VALUES
(1, 'Stormwind', 99, 1, 0, '', 'images/instances/Misc_Icons/LOC-Stormwind.jpg'),
(2, 'Thunder Bluff', 99, 1, 0, '', 'images/instances/Misc_Icons/LOC-Thunder-Bluff.jpg'),
(3, 'Silvermoon', 99, 2, 0, '', 'images/instances/Misc_Icons/LOC-Silvermoon.jpg'),
(4, 'Orgrimmar', 99, 1, 0, '', 'images/instances/Misc_Icons/LOC-Orgrimmar.jpg'),
(5, 'World Boss', 40, 0, 1, '', 'images/instances/Misc_Icons/40-World.jpg'),
(6, 'Undercity', 99, 1, 0, '', 'images/instances/Misc_Icons/LOC-Undercity.jpg'),
(7, 'Darnassus', 99, 1, 0, '', 'images/instances/Misc_Icons/LOC-Darnassus.jpg'),
(8, 'Ironforge', 99, 1, 0, '', 'images/instances/Misc_Icons/LOC-Ironforge.jpg'),
(9, 'Exodar', 99, 2, 0, '', 'images/instances/Misc_Icons/LOC-Exodar.jpg'),
(10, 'Dalaran', 99, 3, 0, '', 'images/instances/Misc_Icons/LOC-Dalaran.jpg'),
(11, 'Shattrath', 99, 2, 0, '', 'images/instances/Misc_Icons/LOC-Shattrath.jpg'),
(12, 'Halls of Stone', 5, 3, 2, 'Ulduar: Halls of Stone', 'images/instances/WotLK_Icons/5-Halls-Of-Stone.jpg'),
(13, 'Naxxramas', 10, 3, 1, 'Naxxramas', 'images/instances/WotLK_Icons/10-Naxxramas.jpg'),
(14, 'Nexus', 5, 3, 2, 'The Nexus', 'images/instances/WotLK_Icons/5-Nexus.jpg'),
(15, 'Oculus', 5, 3, 2, 'The Oculus', 'images/instances/WotLK_Icons/5-Oculus.jpg'),
(16, 'Utgarde Keep', 5, 3, 2, 'Utgarde Keep', 'images/instances/WotLK_Icons/5-Utgarde-Keep.jpg'),
(17, 'Eye of Eternity', 10, 3, 1, 'The Eye of Eternity', 'images/instances/WotLK_Icons/10-Eye-of-Eternity.jpg'),
(18, 'Ahn''Kahet', 5, 3, 2, 'Ahn''Kahet: The Old Kingdom', 'images/instances/WotLK_Icons/5-Ahn''Kahet.jpg'),
(19, 'Ahn''Kahet - Heroic', 5, 3, 2, 'Ahn''Kahet: The Old Kingdom', 'images/instances/WotLK_Icons/5-Ahn''Kahet-Heroic.jpg'),
(20, 'Azjol-Nerub - Heroic', 5, 3, 2, 'Azjol-Nerub', 'images/instances/WotLK_Icons/5-Azjol-Nerub-Heroic.jpg'),
(22, 'Eye of Eternity - Heroic', 25, 3, 1, 'The Eye of Eternity (Heroic)', 'images/instances/WotLK_Icons/25-Eye-of-Eternity.jpg'),
(24, 'Obsidian Sanctum', 10, 3, 1, 'The Obsidian Sanctum', 'images/instances/WotLK_Icons/10-Obsidian-Sanctum.jpg'),
(45, 'Mana Tombs - Heroic', 5, 2, 2, 'Auchindoun - Mana Tombs', 'images/instances/BC_Icons/5-Mana-Tombs-Heroic.jpg'),
(26, 'Oculus - Heroic', 5, 3, 2, 'The Oculus', 'images/instances/WotLK_Icons/5-Oculus-Heroic.jpg'),
(27, 'Violet Hold - Heroic', 5, 3, 2, 'Violet Hold', 'images/instances/WotLK_Icons/5-Violet-Hold-Heroic.jpg'),
(28, 'Obsidian Sanctum - Heroic', 25, 3, 1, 'The Obsidian Sanctum (Heroic)', 'images/instances/WotLK_Icons/25-Obsidian-Sanctum.jpg'),
(29, 'Halls Of Lightning - Heroic', 5, 3, 2, 'Ulduar: Halls of Lightning', 'images/instances/WotLK_Icons/5-Halls-Of-Lightning-Heroic.jpg'),
(30, 'Utgarde Keep - Heroic', 5, 3, 2, 'Utgarde Keep', 'images/instances/WotLK_Icons/5-Utgarde-Keep-Heroic.jpg'),
(31, 'Gundrak - Heroic', 5, 3, 2, 'Gun''Drak', 'images/instances/WotLK_Icons/5-Gundrak-Heroic.jpg'),
(32, 'Halls of Stone - Heroic', 5, 3, 2, 'Ulduar: Halls of Stone', 'images/instances/WotLK_Icons/5-Halls-Of-Stone-Heroic.jpg'),
(33, 'CoT: Culling of Stratholme', 5, 3, 2, 'Caverns of Time - The Culling of Stratholme', 'images/instances/WotLK_Icons/5-CoT-Strat.jpg'),
(34, 'Utgarde Pinnacle - Heroic', 5, 3, 2, 'Utgarde Pinnacle', 'images/instances/WotLK_Icons/5-Utgarde-Pinnacle-Heroic.jpg'),
(35, 'Azjol-Nerub', 5, 3, 2, 'Azjol-Nerub', 'images/instances/WotLK_Icons/5-Azjol-Nerub.jpg'),
(36, 'Gun''drak', 5, 3, 2, 'Gun''Drak', 'images/instances/WotLK_Icons/5-Gundrak.jpg'),
(37, 'Drak''Tharon Keep - Heroic', 5, 3, 2, 'Drak''Tharon Keep', 'images/instances/WotLK_Icons/5-Drak''Tharon-Keep-Heroic.jpg'),
(38, 'Naxxramas - Heroic', 25, 3, 1, 'Naxxramas (Heroic)', 'images/instances/WotLK_Icons/25-Naxxramas.jpg'),
(39, 'Drak''Tharon Keep', 5, 3, 2, 'Drak''Tharon Keep', 'images/instances/WotLK_Icons/5-Drak''Tharon-Keep.jpg'),
(40, 'Halls Of Lightning', 5, 3, 2, 'Ulduar: Halls of Lightning', 'images/instances/WotLK_Icons/5-Halls-Of-Lightning.jpg'),
(41, 'Violet Hold', 5, 3, 2, 'Violet Hold', 'images/instances/WotLK_Icons/5-Violet-Hold.jpg'),
(42, 'Utgarde Pinnacle', 5, 3, 2, 'Utgarde Pinnacle', 'images/instances/WotLK_Icons/5-Utgarde-Pinnacle.jpg'),
(43, 'CoT: Culling of Stratholm - Heroic', 5, 3, 2, 'Caverns of Time - The Culling of Stratholme', 'images/instances/WotLK_Icons/5-CoT-Strat-Heroic.jpg'),
(44, 'Nexus - Heroic', 5, 3, 2, 'The Nexus', 'images/instances/WotLK_Icons/5-Nexus-Heroic.jpg'),
(46, 'CoT: Durnholde Keep', 5, 2, 2, 'Caverns of Time - Durnholde', 'images/instances/BC_Icons/5-CoT-Durnholde-Keep.jpg'),
(47, 'Steamvaults', 5, 2, 2, 'Coilfang - Steam Vaults', 'images/instances/BC_Icons/5-Steamvault.jpg'),
(48, 'Black Temple', 25, 2, 1, 'Black Temple', 'images/instances/BC_Icons/25-Black-Temple.jpg'),
(49, 'Shadow Labyrinth', 5, 2, 2, 'Auchindoun - Shadow Labyrinth', 'images/instances/BC_Icons/5-Shadow-Labyrinth.jpg'),
(50, 'Mechanar - Heroic', 5, 2, 2, 'Tempest Keep - The Mechanar', 'images/instances/BC_Icons/5-Mechanar-Heroic.jpg'),
(51, 'Sunwell', 25, 2, 1, 'The Sunwell', 'images/instances/BC_Icons/25-Sunwell.jpg'),
(52, 'Botanica', 5, 2, 2, 'Tempest Keep - The Botanica', 'images/instances/BC_Icons/5-Botanica.jpg'),
(53, 'Magister''s Terrace', 5, 2, 2, 'Magister''s Terrace', 'images/instances/BC_Icons/5-Mag-Terr.jpg'),
(54, 'Underbog - Heroic', 5, 2, 2, 'Coilfang - Underbog', 'images/instances/BC_Icons/5-Underbog-Heroic.jpg'),
(55, 'Sethekk Halls - Heroic', 5, 2, 2, 'Auchindoun - Sethekk Halls', 'images/instances/BC_Icons/5-Sethekk-Halls-Heroic.jpg'),
(56, 'Auchenai Crypts - Heroic', 5, 2, 2, 'Auchindoun - Auchenai Crypts', 'images/instances/BC_Icons/5-Auchenai-Crypts-Heroic.jpg'),
(57, 'Arcatraz - Heroic', 5, 2, 2, 'Tempest Keep - The Arcatraz', 'images/instances/BC_Icons/5-Arcatraz-Heroic.jpg'),
(58, 'Sethekk Halls', 5, 2, 2, 'Auchindoun - Sethekk Halls\r\n', 'images/instances/BC_Icons/5-Sethekk-Halls.jpg'),
(59, 'Ramparts - Heroic', 5, 2, 2, 'Hellfire Citadel - Hellfire Ramparts', 'images/instances/BC_Icons/5-Ramparts-Heroic.jpg'),
(60, 'Steamvaults - Heroic', 5, 2, 2, 'Coilfang - Steam Vaults', 'images/instances/BC_Icons/5-Steamvault-Heroic.jpg'),
(61, 'Arcatraz', 5, 2, 2, 'Tempest Keep - The Arcatraz', 'images/instances/BC_Icons/5-Arcatraz.jpg'),
(62, 'Blood Furnace - Heroic', 5, 2, 2, 'Hellfire Citadel - Blood Furnace', 'images/instances/BC_Icons/5-Blood-Furnace-Heroic.jpg'),
(63, 'Shattered Halls', 5, 2, 2, 'Hellfire Citadel - Shattered Halls', 'images/instances/BC_Icons/5-Shattered-Halls.jpg'),
(64, 'Karazhan', 10, 2, 1, 'Karazhan', 'images/instances/BC_Icons/10-Kara.jpg'),
(65, 'CoT: Black Morass - Heroic', 5, 2, 2, 'Caverns of Time - Dark Portal', 'images/instances/BC_Icons/5-CoT-Black-Morass-Heroic.jpg'),
(66, 'Botanica - Heroic', 5, 2, 2, 'Tempest Keep - The Botanica', 'images/instances/BC_Icons/5-Botanica-Heroic.jpg'),
(67, 'Gruul''s Lair', 25, 2, 1, 'Gruul''s Lair', 'images/instances/BC_Icons/25-Gruul.jpg'),
(68, 'Slave Pens', 5, 2, 2, 'Coilfang - Slave Pens', 'images/instances/BC_Icons/5-Slave-Pens.jpg'),
(69, 'Mana Tombs', 5, 2, 2, 'Auchindoun - Mana Tombs', 'images/instances/BC_Icons/5-Mana-Tombs.jpg'),
(70, 'CoT: Durnholde Keep - Heroic', 5, 2, 2, 'Caverns of Time - Durnholde', 'images/instances/BC_Icons/5-CoT-Durnholde-Keep-Heroic.jpg'),
(71, 'Blood Furnace', 5, 2, 2, 'Hellfire Citadel - Blood Furnace', 'images/instances/BC_Icons/5-Blood-Furnace.jpg'),
(72, 'CoT: Black Morass', 5, 2, 2, 'Caverns of Time - Dark Portal', 'images/instances/BC_Icons/5-CoT-Black-Morass.jpg'),
(73, 'Magister''s Terrace - Heroic', 5, 2, 2, 'Magister''s Terrace', 'images/instances/BC_Icons/5-Mag-Terr-Heroic.jpg'),
(74, 'CoT: Mt. Hyjal', 25, 2, 1, 'Hyjal Past', 'images/instances/BC_Icons/25-CoT-Hyjal.jpg'),
(75, 'Underbog', 5, 2, 2, 'Coilfang - Underbog', 'images/instances/BC_Icons/5-Underbog.jpg'),
(76, 'Mechanar', 5, 2, 2, 'Tempest Keep - The Mechanar', 'images/instances/BC_Icons/5-Mechanar.jpg'),
(77, 'Shattered Halls - Heroic', 5, 2, 2, 'Hellfire Citadel - Shattered Halls', 'images/instances/BC_Icons/5-Shattered-Halls-Heroic.jpg'),
(78, 'Serpentshrine Cavern', 25, 2, 1, 'Serpentshrine Cavern', 'images/instances/BC_Icons/25-Serpentshrine-Cavern.jpg'),
(79, 'Tempest Keep', 25, 2, 1, 'Tempest Keep', 'images/instances/BC_Icons/25-Tempest-Keep.jpg'),
(80, 'Magtheridon''s Lair', 25, 2, 1, 'Magtheridon''s Lair', 'images/instances/BC_Icons/25-Mags-Lair.jpg'),
(81, 'Shadow Labyrinth - Heroic', 5, 2, 2, 'Auchindoun - Shadow Labyrinth', 'images/instances/BC_Icons/5-Shadow-Labyrinth-Heroic.jpg'),
(82, 'Slave Pens - Heroic', 5, 2, 2, 'Coilfang - Slave Pens', 'images/instances/BC_Icons/5-Slave-Pens-Heroic.jpg'),
(83, 'Zul''Aman', 10, 2, 1, 'Zul''Aman', 'images/instances/BC_Icons/10-ZulAman.jpg'),
(84, 'Auchenai Crypts', 5, 2, 2, 'Auchindoun - Auchenai Crypts', 'images/instances/BC_Icons/5-Auchenai-Crypts.jpg'),
(85, 'Ramparts', 5, 2, 2, 'Hellfire Citadel - Hellfire Ramparts', 'images/instances/BC_Icons/5-Ramparts.jpg'),
(86, 'Stratholme', 5, 1, 2, 'Stratholme', 'images/instances/Classic_Icons/5-Stratholme.jpg'),
(87, 'Scarlet Monestary - Armory', 10, 1, 2, 'Scarlet Monastery - Armory', 'images/instances/Classic_Icons/10-Scarlet-Monestary-Armory.jpg'),
(88, 'Shadowfang Keep', 10, 1, 2, 'Shadowfang Keep', 'images/instances/Classic_Icons/10-Shadowfang-Keep.jpg'),
(89, 'Scholomance', 5, 1, 2, 'Scholomance', 'images/instances/Classic_Icons/5-Scholomance.jpg'),
(90, 'Onyxia''s Lair', 40, 1, 1, 'Onyxia''s Lair', 'images/instances/Classic_Icons/40-Onyxias-Lair.jpg'),
(91, 'Blackwing Lair', 40, 1, 1, 'Blackwing Lair', 'images/instances/Classic_Icons/40-Blackwing-Lair.jpg'),
(92, 'Blackfathom Deeps', 10, 1, 2, 'Blackfathom Deeps', 'images/instances/Classic_Icons/10-Blackfathom-Deeps.jpg'),
(93, 'Stockades', 10, 1, 2, 'Stormwind Stockades', 'images/instances/Classic_Icons/10-Stockade.jpg'),
(94, 'Uldaman', 10, 1, 2, 'Uldaman', 'images/instances/Classic_Icons/10-Uldaman.jpg'),
(95, 'Zul''Gurub', 10, 1, 1, 'Zul''Gurub', 'images/instances/Classic_Icons/10-Zul-Gurub.jpg'),
(96, 'Molten Core', 40, 1, 1, 'Molten Core', 'images/instances/Classic_Icons/40-Molten-Core.jpg'),
(97, 'Wailing Caverns', 10, 1, 2, 'Wailing Caverns', 'images/instances/Classic_Icons/10-Wailing-Caverns.jpg'),
(98, 'Scarlet Monestary - Graveyard', 10, 1, 2, 'Scarlet Monastery - Graveyard', 'images/instances/Classic_Icons/10-Scarlet-Monestary-Graveyard.jpg'),
(99, 'Deadmines', 10, 1, 2, 'Deadmines', 'images/instances/Classic_Icons/10-Deadmines.jpg'),
(100, 'Lower Blackrock Spire', 10, 1, 2, 'Lower Blackrock Spire', 'images/instances/Classic_Icons/10-Lower-Blackrock-Spire.jpg'),
(101, 'Zul''Farak', 10, 1, 2, 'Zul''Farrak', 'images/instances/Classic_Icons/10-Zul-Farak.jpg'),
(102, 'Blackrock Depths', 5, 1, 2, 'Blackrock Depths', 'images/instances/Classic_Icons/5-Blackrock Depths.jpg'),
(103, 'Dire Maul - West', 5, 1, 2, 'Dire Maul - West', 'images/instances/Classic_Icons/5-Dire-Maul-West.jpg'),
(104, 'Upper Blackrock Spire', 10, 1, 1, 'Upper Blackrock Spire', 'images/instances/Classic_Icons/10-Upper-Blackrock-Spire.jpg'),
(105, 'Gnomeregan', 10, 1, 2, 'Gnomeregan', 'images/instances/Classic_Icons/10-Gnomeregan.jpg'),
(106, 'Temple Of Ahn''Qiraj', 40, 1, 1, 'Ahn''Qiraj Temple', 'images/instances/Classic_Icons/40-Temple-Of-AhnQiraj.jpg'),
(107, 'Scarlet Monestary - Library', 10, 1, 2, 'Scarlet Monastery - Library', 'images/instances/Classic_Icons/10-Scarlet-Monestary-Library.jpg'),
(108, 'Scarlet Monestary - Cathedral', 10, 1, 2, 'Scarlet Monastery - Cathedral', 'images/instances/Classic_Icons/10-Scarlet-Monestary-Cathedral.jpg'),
(109, 'Sunken Temple', 10, 1, 2, 'Sunken Temple', 'images/instances/Classic_Icons/10-Sunken-Temple.jpg'),
(110, 'Maraudon', 10, 1, 2, 'Maraudon', 'images/instances/Classic_Icons/10-Maraudon.jpg'),
(111, 'Ragefire Chasm', 10, 1, 2, 'Ragefire Chasm', 'images/instances/Classic_Icons/10-Ragefire-Chasm.jpg'),
(112, 'Dire Maul - East', 5, 1, 2, 'Dire Maul - East', 'images/instances/Classic_Icons/5-Dire-Maul-East.jpg'),
(113, 'Dire Maul - North', 5, 1, 2, 'Dire Maul - North', 'images/instances/Classic_Icons/5-Dire-Maul-North.jpg'),
(114, 'Ruins Of Ahn''Qiraj', 20, 1, 1, 'Ahn''Qiraj Ruins', 'images/instances/Classic_Icons/20-Ruins-Of-AhnQiraj.jpg'),
(115, 'Razorfen Downs', 10, 1, 2, 'Razorfen Downs', 'images/instances/Classic_Icons/10-Razorfen-Downs.jpg'),
(116, 'Razorfen Kraul', 10, 1, 2, 'Razorfen Kraul', 'images/instances/Classic_Icons/10-Razorfen-Kraul.jpg'),
(117, 'Vault of Archavon', 10, 3, 1, 'Vault of Archavon', 'images/instances/WotLK_Icons/10-Vault-of-Archavon.jpg'),
(118, 'Vault of Archavon - Heroic', 25, 3, 1, 'Vault of Archavon (Heroic)', 'images/instances/WotLK_Icons/25-Vault-of-Archavon.jpg'),
(119, 'Generic Event', 99, 0, 5, '', 'images/instances/Misc_Icons/GEN-Event.jpg'),
(120, 'PvP Event', 40, 0, 3, '', 'images/instances/Misc_Icons/GEN-PvP.jpg'),
(121, 'Meeting', 99, 0, 4, '', 'images/instances/Misc_Icons/GEN-Meeting.jpg');

-- Event Type Table Creation
DROP TABLE IF EXISTS `wrm_event_type`;
CREATE TABLE `wrm_event_type` (
  `event_type_id` tinyint(2) NOT NULL auto_increment,
  `event_type_name` varchar(50) NOT NULL,
  `event_type_lang_id` varchar(50) NOT NULL,
  `def` tinyint(1) NOT NULL,
  PRIMARY KEY  (`event_type_id`)
) ;

-- Event Type Table Data
INSERT INTO `wrm_event_type` (`event_type_id`, `event_type_name`, `event_type_lang_id`, `def`) VALUES
(1, 'Raid', 'event_type_raid', 1),
(2, 'Dungeon', 'event_type_dungeon', 0),
(3, 'PvP Event', 'event_type_pvp', 0),
(4, 'Meeting', 'event_type_meeting', 0),
(5, 'Other', 'event_type_other', 0);

-- Expansion Table Creation
DROP TABLE IF EXISTS `wrm_expansion`;
CREATE TABLE `wrm_expansion` (
  `exp_id` tinyint(2) NOT NULL auto_increment,
  `exp_name` varchar(50) NOT NULL,
  `exp_lang_id` varchar(50) NOT NULL,
  `def` tinyint(1) NOT NULL,
  PRIMARY KEY  (`exp_id`)
) ;

-- Expansion Table Data
INSERT INTO `wrm_expansion` (`exp_id`, `exp_name`, `exp_lang_id`, `def`) VALUES
(1, 'Generic', 'exp_generic_wow', 0),
(2, 'BC', 'exp_burning_crusade', 0),
(3, 'WotLK', 'exp_wrath_lich_king', 1);

-- Guilds Table Creation
DROP TABLE IF EXISTS `wrm_guilds`;
CREATE TABLE  `wrm_guilds` (
  `guild_id` int(10) NOT NULL auto_increment,
  `guild_master` varchar(80) NOT NULL default '',
  `guild_name` varchar(30) NOT NULL default '',
  `guild_tag` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`guild_id`)
) ;

-- Locations Table Creation
DROP TABLE IF EXISTS `wrm_locations`;
CREATE TABLE  `wrm_locations` (
  `location_id` int(10) NOT NULL auto_increment,
  `location` varchar(255) NOT NULL default '',
  `min_lvl` int(2) NOT NULL default '0',
  `max_lvl` int(2) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `dk` int(2) NOT NULL default '0',
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
  `event_type` tinyint(2) NOT NULL default '1',
  `event_id` int(10) NOT NULL default '119',
  PRIMARY KEY  (`location_id`)
) ;

-- Locations Data

-- Log Create Table Creation
DROP TABLE IF EXISTS `wrm_logs_create`;
CREATE TABLE  `wrm_logs_create` (
  `log_id` int(11) NOT NULL auto_increment,
  `create_id` int(11) NOT NULL default '0',
  `profile_id` int(11) NOT NULL default '0',
  `ip` varchar(45) NOT NULL default '',
  `timestamp` varchar(45) NOT NULL default '',
  `type` varchar(45) NOT NULL default '',
  `create_name` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`log_id`)
) ;

-- Log Delete Table Creation
DROP TABLE IF EXISTS `wrm_logs_delete`;
CREATE TABLE  `wrm_logs_delete` (
  `log_id` int(11) NOT NULL auto_increment,
  `profile_id` int(11) NOT NULL default '0',
  `ip` varchar(45) NOT NULL default '',
  `timestamp` varchar(45) NOT NULL default '',
  `type` varchar(45) NOT NULL default '',
  `delete_name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`log_id`)
) ;

-- Log Hack Table Creation 
DROP TABLE IF EXISTS `wrm_logs_hack`;
CREATE TABLE  `wrm_logs_hack` (
  `log_id` int(10) unsigned NOT NULL auto_increment,
  `ip` varchar(45) NOT NULL default '0',
  `message` text NOT NULL,
  `timestamp` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`log_id`)
) ;

-- Log Raid Table Creation
DROP TABLE IF EXISTS `wrm_logs_raid`;
CREATE TABLE  `wrm_logs_raid` (
  `log_id` int(10) NOT NULL auto_increment,
  `char_id` int(10) NOT NULL default '0',
  `profile_id` int(10) NOT NULL default '0',
  `raid_id` int(10) NOT NULL default '0',
  `ip` varchar(45) NOT NULL default '',
  `timestamp` varchar(45) NOT NULL default '',
  `type` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`log_id`)
) ;

-- Permissions Table Creation
DROP TABLE IF EXISTS `wrm_permissions`;
CREATE TABLE  `wrm_permissions` (
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
) ;

-- Permissions Data
INSERT INTO `wrm_permissions` (`name`,`description`,`announcements`,`configuration`,`guilds`,`locations`,`permissions`,`profile`,`raids`,`logs`,`users`) VALUES ('WRM Superadmin','Full Access','1','1','1','1','1','1','1','1','1');
INSERT INTO `wrm_permissions` (`name`,`description`,`announcements`,`configuration`,`guilds`,`locations`,`permissions`,`profile`,`raids`,`logs`,`users`) VALUES ('WRM Users','Generic Access','0','0','0','0','0','1','0','0','0');

-- Profile Table Creation
DROP TABLE IF EXISTS `wrm_profile`;
CREATE TABLE  `wrm_profile` (
  `profile_id` int(10) NOT NULL auto_increment,
  `email` varchar(255) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `priv` varchar(255) NOT NULL default '',
  `username` varchar(255) NOT NULL default '',
  `last_login_time` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`profile_id`)
) ;

-- Raid Table Creation
DROP TABLE IF EXISTS `wrm_raids`;
CREATE TABLE  `wrm_raids` (
  `raid_id` int(10) NOT NULL auto_increment,
  `description` text NOT NULL,
  `freeze` int(10) NOT NULL default '0',
  `invite_time` varchar(255) NOT NULL default '',
  `location` varchar(255) NOT NULL default '',
  `officer` varchar(255) NOT NULL default '',
  `old` tinyint(1) NOT NULL default '0',
  `start_time` varchar(255) NOT NULL default '',
  `dk_lmt` int(2) NOT NULL default '0',
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
  `event_type` tinyint(1) NOT NULL default '1',
  `event_id` int(10) NOT NULL default '119',
  PRIMARY KEY  (`raid_id`)
) ;

-- Signup Table Creation
DROP TABLE IF EXISTS `wrm_signups`;
CREATE TABLE  `wrm_signups` (
  `signup_id` int(10) NOT NULL auto_increment,
  `char_id` int(10) NOT NULL default '0',
  `profile_id` int(10) NOT NULL default '0',
  `raid_id` int(10) NOT NULL default '0',
  `comments` varchar(255) NOT NULL default '',
  `cancel` int(1) NOT NULL default '0',
  `queue` int(1) NOT NULL default '0',
  `timestamp` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`signup_id`)
) ;

-- Team Table Creation
DROP TABLE IF EXISTS `wrm_teams`;
CREATE TABLE  `wrm_teams` (
  `team_id` int(10) NOT NULL auto_increment,
  `raid_id` int(10) NOT NULL default '0',
  `team_name` varchar(255) NOT NULL default '',
  `char_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`team_id`)
) ;

-- Version Table Creation
DROP TABLE IF EXISTS `wrm_version`;
CREATE TABLE `wrm_version` (
`version_number` VARCHAR( 20 ) NOT NULL ,
`version_desc` VARCHAR( 255 ) NOT NULL ,
PRIMARY KEY ( `version_number` )
) ;

-- Version Data
INSERT INTO `wrm_version` VALUES ('3.0.9.2','Version 3.0.9.2 of phpRaid');
INSERT INTO `wrm_version` VALUES ('3.1.0','Version 3.1.0 of phpRaid (Beta)');
INSERT INTO `wrm_version` VALUES ('3.1.1','Version 3.1.1 of phpRaid');
INSERT INTO `wrm_version` VALUES ('3.1.2','Version 3.1.2 of WoW Raid Manager');
INSERT INTO `wrm_version` VALUES ('3.2.0','Version 3.2.0 of WoW Raid Manager');
INSERT INTO `wrm_version` VALUES ('3.2.1','Version 3.2.1 of WoW Raid Manager');
INSERT INTO `wrm_version` VALUES ('3.5.0','Version 3.5.0 of WoW Raid Manager');
INSERT INTO `wrm_version` VALUES ('3.5.1','Version 3.5.1 of WoW Raid Manager');
INSERT INTO `wrm_version` VALUES ('3.6.0','Version 3.6.0 of WoW Raid Manager');
INSERT INTO `wrm_version` VALUES ('3.6.0.1','Version 3.6.0.1 of WoW Raid Manager');
INSERT INTO `wrm_version` VALUES ('3.6.0.2','Version 3.6.0.2 of WoW Raid Manager');
INSERT INTO `wrm_version` VALUES ('3.6.1','Version 3.6.1 of WoW Raid Manager');
INSERT INTO `wrm_version` VALUES ('4.0.0','Version 4.0.0 of WoW Raid Manager');
