-- Column Header Creation
DROP TABLE IF EXISTS `wrm_column_headers`;
CREATE TABLE `wrm_column_headers` (
`ID` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`view_name` VARCHAR( 50 ) NOT NULL ,
`column_name` VARCHAR( 50 ) NOT NULL ,
`visible` TINYINT( 1 ) NOT NULL DEFAULT '1',
`position` TINYINT( 2 ) NOT NULL ,
`img_url` VARCHAR( 100 ) DEFAULT NULL,
INDEX ( `view_name` )
) ;

-- Column Header Data
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url` )
VALUES (NULL , 'raids1', 'ID', '1', '1', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url` )
VALUES (NULL , 'raids1', 'Date', '1', '2', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url` )
VALUES (NULL , 'raids1', 'Dungeon', '1', '3', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url` )
VALUES (NULL , 'raids1', 'Invite Time', '1', '4', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url` )
VALUES (NULL , 'raids1', 'Start Time', '1', '5', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url` )
VALUES (NULL , 'raids1', 'Creator', '1', '6', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url` )
VALUES (NULL , 'raids1', 'Death Knight', '1', '7', 'images/classes/deathknight_icon.gif');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url` )
VALUES (NULL , 'raids1', 'Druid', '1', '8', 'images/classes/druid_icon.gif');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url` )
VALUES (NULL , 'raids1', 'Hunter', '1', '9', 'images/classes/hunter.gif');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url` )
VALUES (NULL , 'raids1', 'Mage', '1', '10', 'images/classes/mage_icon.gif');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url` )
VALUES (NULL , 'raids1', 'Paladin', '1', '11', 'images/classes/paladin_icon.gif');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url` )
VALUES (NULL , 'raids1', 'Priest', '1', '12', 'images/classes/priest_icon.gif');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url` )
VALUES (NULL , 'raids1', 'Rogue', '1', '13', 'images/classes/rogue_icon.gif');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url` )
VALUES (NULL , 'raids1', 'Shaman', '1', '14', 'images/classes/shaman_icon.gif');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url` )
VALUES (NULL , 'raids1', 'Warlock', '1', '15', 'images/classes/warlock_icon.gif');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url` )
VALUES (NULL , 'raids1', 'Warrior', '1', '16', 'images/classes/warrior_icon.gif');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url` )
VALUES (NULL , 'raids1', '@role1', '1', '17', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url` )
VALUES (NULL , 'raids1', '@role2', '1', '18', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url` )
VALUES (NULL , 'raids1', '@role3', '1', '19', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url` )
VALUES (NULL , 'raids1', '@role4', '1', '20', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url` )
VALUES (NULL , 'raids1', '@role5', '1', '21', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url` )
VALUES (NULL , 'raids1', '@role6', '1', '22', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url` )
VALUES (NULL , 'raids1', 'Totals', '1', '23', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url` )
VALUES (NULL , 'raids1', 'Buttons', '1', '24', NULL);