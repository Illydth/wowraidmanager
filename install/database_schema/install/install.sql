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
`format_code` VARCHAR ( 25 ) DEFAULT NULL,
INDEX ( `view_name` )
) ;

-- Column Header Data - Raids1 View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'raids1', 'ID', '1', '1', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'raids1', 'Date', '1', '2', NULL, 'wrmdate');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'raids1', 'Dungeon', '1', '3', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'raids1', 'Invite Time', '1', '4', NULL, 'wrmtime');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'raids1', 'Start Time', '1', '5', NULL, 'wrmtime');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'raids1', 'Creator', '1', '6', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'raids1', 'Death Knight', '1', '7', 'images/classes/deathknight_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'raids1', 'Druid', '1', '8', 'images/classes/druid_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'raids1', 'Hunter', '1', '9', 'images/classes/hunter_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'raids1', 'Mage', '1', '10', 'images/classes/mage_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'raids1', 'Paladin', '1', '11', 'images/classes/paladin_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'raids1', 'Priest', '1', '12', 'images/classes/priest_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'raids1', 'Rogue', '1', '13', 'images/classes/rogue_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'raids1', 'Shaman', '1', '14', 'images/classes/shaman_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'raids1', 'Warlock', '1', '15', 'images/classes/warlock_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'raids1', 'Warrior', '1', '16', 'images/classes/warrior_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'raids1', '@role1', '1', '17', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'raids1', '@role2', '1', '18', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'raids1', '@role3', '1', '19', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'raids1', '@role4', '1', '20', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'raids1', '@role5', '1', '21', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'raids1', '@role6', '1', '22', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'raids1', 'Totals', '1', '23', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'raids1', 'Buttons', '1', '24', NULL, NULL);
-- Column Header Data - Index1 View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'index1', 'Signup', '1', '1', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'index1', 'ID', '1', '2', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'index1', 'Date', '1', '3', NULL, 'wrmdate');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'index1', 'Dungeon', '1', '4', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'index1', 'Invite Time', '1', '5', NULL, 'wrmtime');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'index1', 'Start Time', '1', '6', NULL, 'wrmtime');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'index1', 'Creator', '1', '7', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'index1', 'Death Knight', '1', '8', 'images/classes/deathknight_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'index1', 'Druid', '1', '9', 'images/classes/druid_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'index1', 'Hunter', '1', '10', 'images/classes/hunter_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'index1', 'Mage', '1', '11', 'images/classes/mage_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'index1', 'Paladin', '1', '12', 'images/classes/paladin_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'index1', 'Priest', '1', '13', 'images/classes/priest_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'index1', 'Rogue', '1', '14', 'images/classes/rogue_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'index1', 'Shaman', '1', '15', 'images/classes/shaman_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'index1', 'Warlock', '1', '16', 'images/classes/warlock_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'index1', 'Warrior', '1', '17', 'images/classes/warrior_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'index1', '@role1', '1', '18', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'index1', '@role2', '1', '19', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'index1', '@role3', '1', '20', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'index1', '@role4', '1', '21', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'index1', '@role5', '1', '22', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'index1', '@role6', '1', '23', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'index1', 'Totals', '1', '24', NULL, NULL);
-- Column Header Data - Announcements1 View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'announcements1', 'ID', '1', '1', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'announcements1', 'Title', '1', '2', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'announcements1', 'Message', '1', '3', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'announcements1', 'Posted By', '1', '4', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'announcements1', 'Create Date', '1', '5', NULL, 'wrmdate');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'announcements1', 'Create Time', '1', '6', NULL, 'wrmtime');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'announcements1', 'Buttons', '1', '7', NULL, NULL);
-- Column Header Data - DKP1 View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'dkp1', 'ID', '1', '1', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'dkp1', 'Name', '1', '2', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'dkp1', 'Class', '1', '3', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'dkp1', 'Earned', '1', '4', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'dkp1', 'Spent', '1', '5', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'dkp1', 'Adjustment', '1', '6', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'dkp1', 'DKP', '1', '7', NULL, NULL);
-- Column Header Data - Team1 View (Remove)
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'team1', 'ID', '1', '1', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'team1', 'Name', '1', '2', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'team1', 'Class', '1', '3', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'team1', 'Guild', '1', '4', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'team1', 'Level', '1', '5', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'team1', 'Team Name', '1', '6', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'team1', 'Actions', '1', '7', NULL, NULL);
-- Column Header Data - Team2 View (Add)
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'team2', 'ID', '1', '1', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'team2', 'Name', '1', '2', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'team2', 'Class', '1', '3', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'team2', 'Guild', '1', '4', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'team2', 'Level', '1', '5', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'team2', 'Add To Team', '1', '7', NULL, NULL);
-- Column Header Data - Guild1 View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'guild1', 'ID', '1', '1', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'guild1', 'Guild Name', '1', '2', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'guild1', 'Guild Tag', '1', '3', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'guild1', 'Guild Master', '1', '4', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'guild1', 'Actions', '1', '5', NULL, NULL);
-- Column Header Data - Location1 View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', 'ID', '1', '1', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', 'Name', '1', '2', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', 'Dungeon', '1', '3', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', 'Event Type', '1', '4', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', 'Min Level', '1', '5', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', 'Max Level', '1', '6', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', 'Death Knight', '1', '7', 'images/classes/deathknight_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', 'Druid', '1', '8', 'images/classes/druid_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', 'Hunter', '1', '9', 'images/classes/hunter_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', 'Mage', '1', '10', 'images/classes/mage_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', 'Paladin', '1', '11', 'images/classes/paladin_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', 'Priest', '1', '12', 'images/classes/priest_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', 'Rogue', '1', '13', 'images/classes/rogue_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', 'Shaman', '1', '14', 'images/classes/shaman_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', 'Warlock', '1', '15', 'images/classes/warlock_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', 'Warrior', '1', '16', 'images/classes/warrior_icon.gif', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', '@role1', '1', '17', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', '@role2', '1', '18', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', '@role3', '1', '19', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', '@role4', '1', '20', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', '@role5', '1', '21', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', '@role6', '1', '22', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', 'Raid Max', '1', '23', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', 'Locked', '1', '24', NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `format_code`)
VALUES (NULL , 'location1', 'Buttons', '1', '25', NULL, NULL);

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
INSERT INTO `wrm_config` VALUES ('header_logo','templates/SpiffyJr/images/logo_phpRaid.jpg');
INSERT INTO `wrm_config` VALUES ('language','english');
INSERT INTO `wrm_config` VALUES ('multiple_signups','0');
INSERT INTO `wrm_config` VALUES ('phpraid_addon_link','http://www.wowraidmanager.net');
INSERT INTO `wrm_config` VALUES ('armory_link','http://www.wowarmory.com');
INSERT INTO `wrm_config` VALUES ('armory_language','en');
INSERT INTO `wrm_config` VALUES ('register_url','register.php');
INSERT INTO `wrm_config` VALUES ('roster_integration','0');
INSERT INTO `wrm_config` VALUES ('show_id','0');
INSERT INTO `wrm_config` VALUES ('showphpraid_addon','1');
INSERT INTO `wrm_config` VALUES ('template','SpiffyJr');
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
  `event_type` tinyint(1) NOT NULL default '1',
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
INSERT INTO `wrm_version` VALUES ('4.0.0','Version 4.0.0 of WoW Raid Manager');
