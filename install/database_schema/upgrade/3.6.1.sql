DROP TABLE IF EXISTS `phpraid_events`;
CREATE TABLE `phpraid_events` (
  `event_id` int(10) NOT NULL auto_increment,
  `zone_desc` varchar(50) NOT NULL,
  `max` tinyint(2) NOT NULL,
  `exp_id` tinyint(2) NOT NULL,
  `event_type_id` tinyint(2) NOT NULL,
  `wow_name` varchar(50) NOT NULL,
  `icon_path` varchar(100) NOT NULL,
  PRIMARY KEY  (`event_id`)
) ;

INSERT INTO `phpraid_events` (`event_id`, `zone_desc`, `max`, `exp_id`, `event_type_id`, `wow_name`, `icon_path`) VALUES
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

DROP TABLE IF EXISTS `phpraid_event_type`;
CREATE TABLE `phpraid_event_type` (
  `event_type_id` tinyint(2) NOT NULL auto_increment,
  `event_type_name` varchar(50) NOT NULL,
  `event_type_lang_id` varchar(50) NOT NULL,
  `def` tinyint(1) NOT NULL,
  PRIMARY KEY  (`event_type_id`)
) ;

INSERT INTO `phpraid_event_type` (`event_type_id`, `event_type_name`, `event_type_lang_id`) VALUES
(1, 'Raid', 'event_type_raid', 1),
(2, 'Dungeon', 'event_type_dungeon', 0),
(3, 'PvP Event', 'event_type_pvp', 0),
(4, 'Meeting', 'event_type_meeting', 0),
(5, 'Other', 'event_type_other', 0);

DROP TABLE IF EXISTS `phpraid_expansion`;
CREATE TABLE `phpraid_expansion` (
  `exp_id` tinyint(2) NOT NULL auto_increment,
  `exp_name` varchar(50) NOT NULL,
  `exp_lang_id` varchar(50) NOT NULL,
  `def` tinyint(1) NOT NULL,
  PRIMARY KEY  (`exp_id`)
) ;

INSERT INTO `phpraid_expansion` (`exp_id`, `exp_name`, `exp_lang_id`) VALUES
(1, 'Generic', 'exp_generic_wow', 0),
(2, 'BC', 'exp_burning_crusade', 0),
(3, 'WotLK', 'exp_wrath_lich_king', 1);

ALTER TABLE `phpraid_locations` ADD `event_id` INT( 10 ) NOT NULL default '119';
ALTER TABLE `phpraid_locations` CHANGE `event_type` `event_type` TINYINT( 2 ) NOT NULL DEFAULT '1';
ALTER TABLE `phpraid_raids` ADD `event_id` INT( 10 ) NOT NULL DEFAULT '119';

UPDATE `phpraid_config` SET `config_value` = 'iums' WHERE `config_name` = 'auth_type' AND `config_value` = 'phpraid' LIMIT 1;

INSERT INTO `phpraid_version` VALUES ('3.6.0','Version 3.6.0 of WoW Raid Manager');
INSERT INTO `phpraid_version` VALUES ('3.6.0.1','Version 3.6.0.1 of WoW Raid Manager');
INSERT INTO `phpraid_version` VALUES ('3.6.0.2','Version 3.6.0.2 of WoW Raid Manager');
INSERT INTO `phpraid_version` VALUES ('3.6.1','Version 3.6.1 of WoW Raid Manager');