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

INSERT INTO `wrm_config` VALUES ('records_per_page','2');