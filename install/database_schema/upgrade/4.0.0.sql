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

UPDATE `wrm_config` SET `config_value` = 'us' WHERE 'armory_language' = 'en' LIMIT 1 ;
INSERT INTO `wrm_config` VALUES ('armory_cache_setting', 'none');

INSERT INTO `wrm_config` VALUES ('records_per_page','25');
INSERT INTO `wrm_version` VALUES ('3.9.9.1.1','4.0 Beta 1 Release 1');
INSERT INTO `wrm_version` VALUES ('3.9.9.1.2','4.0 Beta 1 Release 2');