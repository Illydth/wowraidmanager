DROP TABLE IF EXISTS `phpraid_events`;
CREATE TABLE `phpraid_events` (
  `zone_id` int(10) NOT NULL auto_increment,
  `zone_desc` varchar(50) NOT NULL,
  `exp_id` tinyint(2) NOT NULL,
  `event_type_id` tinyint(2) NOT NULL,
  `wow_name` varchar(50) NOT NULL,
  `icon_path` varchar(100) NOT NULL,
  PRIMARY KEY  (`zone_id`)
) ;

INSERT INTO `phpraid_events` (`zone_id`, `zone_desc`, `exp_id`, `event_type_id`, `wow_name`, `icon_path`) VALUES
(1, 'Stormwind', 1, 0, '', 'images/instances/Misc_Icons/LOC-Stormwind.jpg'),
(2, 'Thunder Bluff', 1, 0, '', 'images/instances/Misc_Icons/LOC-Thunder-Bluff.jpg'),
(3, 'Silvermoon', 2, 0, '', 'images/instances/Misc_Icons/LOC-Silvermoon.jpg'),
(4, 'Orgrimmar', 1, 0, '', 'images/instances/Misc_Icons/LOC-Orgrimmar.jpg'),
(5, 'World Boss', 0, 1, '', 'images/instances/Misc_Icons/40-World.jpg'),
(6, 'Undercity', 1, 0, '', 'images/instances/Misc_Icons/LOC-Undercity.jpg'),
(7, 'Darnassus', 1, 0, '', 'images/instances/Misc_Icons/LOC-Darnassus.jpg'),
(8, 'Ironforge', 1, 0, '', 'images/instances/Misc_Icons/LOC-Ironforge.jpg'),
(9, 'Exodar', 2, 0, '', 'images/instances/Misc_Icons/LOC-Exodar.jpg'),
(10, 'Dalaran', 3, 0, '', 'images/instances/Misc_Icons/LOC-Dalaran.jpg'),
(11, 'Shattrath', 2, 0, '', 'images/instances/Misc_Icons/LOC-Shattrath.jpg'),
(12, 'Halls of Stone', 3, 2, 'Ulduar: Halls of Stone', 'images/instances/WotLK_Icons/5-Halls-Of-Stone.jpg'),
(13, 'Naxxramas', 3, 1, 'Naxxramas', 'images/instances/WotLK_Icons/10-Naxxramas.jpg'),
(14, 'Nexus', 3, 2, 'The Nexus', 'images/instances/WotLK_Icons/5-Nexus.jpg'),
(15, 'Oculus', 3, 2, 'The Oculus', 'images/instances/WotLK_Icons/5-Oculus.jpg'),
(16, 'Utgarde Keep', 3, 2, 'Utgarde Keep', 'images/instances/WotLK_Icons/5-Utgarde-Keep.jpg'),
(17, 'Eye of Eternity', 3, 1, 'The Eye of Eternity', 'images/instances/WotLK_Icons/10-Eye-of-Eternity.jpg'),
(18, 'Ahn''Kahet', 3, 2, 'Ahn''Kahet: The Old Kingdom', 'images/instances/WotLK_Icons/5-Ahn''Kahet.jpg'),
(19, 'Ahn''Kahet - Heroic', 3, 2, 'Ahn''Kahet: The Old Kingdom', 'images/instances/WotLK_Icons/5-Ahn''Kahet-Heroic.jpg'),
(20, 'Azjol-Nerub - Heroic', 3, 2, 'Azjol-Nerub', 'images/instances/WotLK_Icons/5-Azjol-Nerub-Heroic.jpg'),
(22, 'Eye of Eternity - Heroic', 3, 1, 'The Eye of Eternity (Heroic)', 'images/instances/WotLK_Icons/25-Eye-of-Eternity.jpg'),
(24, 'Obsidian Sanctum', 3, 1, 'The Obsidian Sanctum', 'images/instances/WotLK_Icons/10-Obsidian-Sanctum.jpg'),
(45, 'Mana Tombs - Heroic', 2, 2, 'Auchindoun - Mana Tombs', 'images/instances/BC_Icons/5-Mana-Tombs-Heroic.jpg'),
(26, 'Oculus - Heroic', 3, 2, 'The Oculus', 'images/instances/WotLK_Icons/5-Oculus-Heroic.jpg'),
(27, 'Violet Hold - Heroic', 3, 2, 'Violet Hold', 'images/instances/WotLK_Icons/5-Violet-Hold-Heroic.jpg'),
(28, 'Obsidian Sanctum - Heroic', 3, 1, 'The Obsidian Sanctum (Heroic)', 'images/instances/WotLK_Icons/25-Obsidian-Sanctum.jpg'),
(29, 'Halls Of Lightning - Heroic', 3, 2, 'Ulduar: Halls of Lightning', 'images/instances/WotLK_Icons/5-Halls-Of-Lightning-Heroic.jpg'),
(30, 'Utgarde Keep - Heroic', 3, 2, 'Utgarde Keep', 'images/instances/WotLK_Icons/5-Utgarde-Keep-Heroic.jpg'),
(31, 'Gundrak - Heroic', 3, 2, 'Gun''Drak', 'images/instances/WotLK_Icons/5-Gundrak-Heroic.jpg'),
(32, 'Halls of Stone - Heroic', 3, 2, 'Ulduar: Halls of Stone', 'images/instances/WotLK_Icons/5-Halls-Of-Stone-Heroic.jpg'),
(33, 'CoT: Culling of Stratholme', 3, 2, 'Caverns of Time - The Culling of Stratholme', 'images/instances/WotLK_Icons/5-CoT-Strat.jpg'),
(34, 'Utgarde Pinnacle - Heroic', 3, 2, 'Utgarde Pinnacle', 'images/instances/WotLK_Icons/5-Utgarde-Pinnacle-Heroic.jpg'),
(35, 'Azjol-Nerub', 3, 2, 'Azjol-Nerub', 'images/instances/WotLK_Icons/5-Azjol-Nerub.jpg'),
(36, 'Gun''drak', 3, 2, 'Gun''Drak', 'images/instances/WotLK_Icons/5-Gundrak.jpg'),
(37, 'Drak''Tharon Keep - Heroic', 3, 2, 'Drak''Tharon Keep', 'images/instances/WotLK_Icons/5-Drak''Tharon-Keep-Heroic.jpg'),
(38, 'Naxxramas - Heroic', 3, 1, 'Naxxramas (Heroic)', 'images/instances/WotLK_Icons/25-Naxxramas.jpg'),
(39, 'Drak''Tharon Keep', 3, 2, 'Drak''Tharon Keep', 'images/instances/WotLK_Icons/5-Drak''Tharon-Keep.jpg'),
(40, 'Halls Of Lightning', 3, 2, 'Ulduar: Halls of Lightning', 'images/instances/WotLK_Icons/5-Halls-Of-Lightning.jpg'),
(41, 'Violet Hold', 3, 2, 'Violet Hold', 'images/instances/WotLK_Icons/5-Violet-Hold.jpg'),
(42, 'Utgarde Pinnacle', 3, 2, 'Utgarde Pinnacle', 'images/instances/WotLK_Icons/5-Utgarde-Pinnacle.jpg'),
(43, 'CoT: Culling of Stratholm - Heroic', 3, 2, 'Caverns of Time - The Culling of Stratholme', 'images/instances/WotLK_Icons/5-CoT-Strat-Heroic.jpg'),
(44, 'Nexus - Heroic', 3, 2, 'The Nexus', 'images/instances/WotLK_Icons/5-Nexus-Heroic.jpg'),
(46, 'CoT: Durnholde Keep', 2, 2, 'Caverns of Time - Durnholde', 'images/instances/BC_Icons/5-CoT-Durnholde-Keep.jpg'),
(47, 'Steamvaults', 2, 2, 'Coilfang - Steam Vaults', 'images/instances/BC_Icons/5-Steamvault.jpg'),
(48, 'Black Temple', 2, 1, 'Black Temple', 'images/instances/BC_Icons/25-Black-Temple.jpg'),
(49, 'Shadow Labyrinth', 2, 2, 'Auchindoun - Shadow Labyrinth', 'images/instances/BC_Icons/5-Shadow-Labyrinth.jpg'),
(50, 'Mechanar - Heroic', 2, 2, 'Tempest Keep - The Mechanar', 'images/instances/BC_Icons/5-Mechanar-Heroic.jpg'),
(51, 'Sunwell', 2, 1, 'The Sunwell', 'images/instances/BC_Icons/25-Sunwell.jpg'),
(52, 'Botanica', 2, 2, 'Tempest Keep - The Botanica', 'images/instances/BC_Icons/5-Botanica.jpg'),
(53, 'Magisters Terrace', 2, 2, 'Magister''s Terrace', 'images/instances/BC_Icons/5-Mag-Terr.jpg'),
(54, 'Underbog - Heroic', 2, 2, 'Coilfang - Underbog', 'images/instances/BC_Icons/5-Underbog-Heroic.jpg'),
(55, 'Sethekk Halls - Heroic', 2, 2, 'Auchindoun - Sethekk Halls', 'images/instances/BC_Icons/5-Sethekk-Halls-Heroic.jpg'),
(56, 'Auchenai Crypts - Heroic', 2, 2, 'Auchindoun - Auchenai Crypts', 'images/instances/BC_Icons/5-Auchenai-Crypts-Heroic.jpg'),
(57, 'Arcatraz - Heroic', 2, 2, 'Tempest Keep - The Arcatraz', 'images/instances/BC_Icons/5-Arcatraz-Heroic.jpg'),
(58, 'Sethekk Halls', 2, 2, 'Auchindoun - Sethekk Halls\r\n', 'images/instances/BC_Icons/5-Sethekk-Halls.jpg'),
(59, 'Ramparts - Heroic', 2, 2, 'Hellfire Citadel - Hellfire Ramparts', 'images/instances/BC_Icons/5-Ramparts-Heroic.jpg'),
(60, 'Steamvaults - Heroic', 2, 2, 'Coilfang - Steam Vaults', 'images/instances/BC_Icons/5-Steamvault-Heroic.jpg'),
(61, 'Arcatraz', 2, 2, 'Tempest Keep - The Arcatraz', 'images/instances/BC_Icons/5-Arcatraz.jpg'),
(62, 'Blood Furnace - Heroic', 2, 2, 'Hellfire Citadel - Blood Furnace', 'images/instances/BC_Icons/5-Blood-Furnace-Heroic.jpg'),
(63, 'Shattered Halls', 2, 2, 'Hellfire Citadel - Shattered Halls', 'images/instances/BC_Icons/5-Shattered-Halls.jpg'),
(64, 'Karazhan', 2, 1, 'Karazhan', 'images/instances/BC_Icons/10-Kara.jpg'),
(65, 'CoT: Black Morass - Heroic', 2, 2, 'Caverns of Time - Dark Portal', 'images/instances/BC_Icons/5-CoT-Black-Morass-Heroic.jpg'),
(66, 'Botanica - Heroic', 2, 2, 'Tempest Keep - The Botanica', 'images/instances/BC_Icons/5-Botanica-Heroic.jpg'),
(67, 'Gruul''s Lair', 2, 1, 'Gruul''s Lair', 'images/instances/BC_Icons/25-Gruul.jpg'),
(68, 'Slave Pens', 2, 2, 'Coilfang - Slave Pens', 'images/instances/BC_Icons/5-Slave-Pens.jpg'),
(69, 'Mana Tombs', 2, 2, 'Auchindoun - Mana Tombs', 'images/instances/BC_Icons/5-Mana-Tombs.jpg'),
(70, 'CoT: Durnholde Keep - Heroic', 2, 2, 'Caverns of Time - Durnholde', 'images/instances/BC_Icons/5-CoT-Durnholde-Keep-Heroic.jpg'),
(71, 'Blood Furnace', 2, 2, 'Hellfire Citadel - Blood Furnace', 'images/instances/BC_Icons/5-Blood-Furnace.jpg'),
(72, 'CoT: Black Morass', 2, 2, 'Caverns of Time - Dark Portal', 'images/instances/BC_Icons/5-CoT-Black-Morass.jpg'),
(73, 'Magister''s Terrace - Heroic', 2, 2, 'Magister''s Terrace', 'images/instances/BC_Icons/5-Mag-Terr-Heroic.jpg'),
(74, 'CoT: Mt. Hyjal', 2, 1, 'Hyjal Past', 'images/instances/BC_Icons/25-CoT-Hyjal.jpg'),
(75, 'Underbog', 2, 2, 'Coilfang - Underbog', 'images/instances/BC_Icons/5-Underbog.jpg'),
(76, 'Mechanar', 2, 2, 'Tempest Keep - The Mechanar', 'images/instances/BC_Icons/5-Mechanar.jpg'),
(77, 'Shattered Halls - Heroic', 2, 2, 'Hellfire Citadel - Shattered Halls', 'images/instances/BC_Icons/5-Shattered-Halls-Heroic.jpg'),
(78, 'Serpentshrine Cavern', 2, 1, 'Serpentshrine Cavern', 'images/instances/BC_Icons/25-Serpentshrine-Cavern.jpg'),
(79, 'Tempest Keep', 2, 1, 'Tempest Keep', 'images/instances/BC_Icons/25-Tempest-Keep.jpg'),
(80, 'Magtheridon''s Lair', 2, 1, 'Magtheridon''s Lair', 'images/instances/BC_Icons/25-Mags-Lair.jpg'),
(81, 'Shadow Labyrinth - Heroic', 2, 2, 'Auchindoun - Shadow Labyrinth', 'images/instances/BC_Icons/5-Shadow-Labyrinth-Heroic.jpg'),
(82, 'Slave Pens - Heroic', 2, 2, 'Coilfang - Slave Pens', 'images/instances/BC_Icons/5-Slave-Pens-Heroic.jpg'),
(83, 'Zul''Aman', 2, 1, 'Zul''Aman', 'images/instances/BC_Icons/10-ZulAman.jpg'),
(84, 'Auchenai Crypts', 2, 2, 'Auchindoun - Auchenai Crypts', 'images/instances/BC_Icons/5-Auchenai-Crypts.jpg'),
(85, 'Ramparts', 2, 2, 'Hellfire Citadel - Hellfire Ramparts', 'images/instances/BC_Icons/5-Ramparts.jpg'),
(86, 'Stratholme', 1, 2, 'Stratholme', 'images/instances/Classic_Icons/5-Stratholme.jpg'),
(87, 'Scarlet Monestary - Armory', 1, 2, 'Scarlet Monastery - Armory', 'images/instances/Classic_Icons/10-Scarlet-Monestary-Armory.jpg'),
(88, 'Shadowfang Keep', 1, 2, 'Shadowfang Keep', 'images/instances/Classic_Icons/10-Shadowfang-Keep.jpg'),
(89, 'Scholomance', 1, 2, 'Scholomance', 'images/instances/Classic_Icons/5-Scholomance.jpg'),
(90, 'Onyxia''s Lair', 1, 1, 'Onyxia''s Lair', 'images/instances/Classic_Icons/40-Onyxias-Lair.jpg'),
(91, 'Blackwing Lair', 1, 1, 'Blackwing Lair', 'images/instances/Classic_Icons/40-Blackwing-Lair.jpg'),
(92, 'Blackfathom Deeps', 1, 2, 'Blackfathom Deeps', 'images/instances/Classic_Icons/10-Blackfathom-Deeps.jpg'),
(93, 'Stockades', 1, 2, 'Stormwind Stockades', 'images/instances/Classic_Icons/10-Stockade.jpg'),
(94, 'Uldaman', 1, 2, 'Uldaman', 'images/instances/Classic_Icons/10-Uldaman.jpg'),
(95, 'Zul''Gurub', 1, 1, 'Zul''Gurub', 'images/instances/Classic_Icons/10-Zul-Gurub.jpg'),
(96, 'Molten Core', 1, 1, 'Molten Core', 'images/instances/Classic_Icons/40-Molten-Core.jpg'),
(97, 'Wailing Caverns', 1, 2, 'Wailing Caverns', 'images/instances/Classic_Icons/10-Wailing-Caverns.jpg'),
(98, 'Scarlet Monestary - Graveyard', 1, 2, 'Scarlet Monastery - Graveyard', 'images/instances/Classic_Icons/10-Scarlet-Monestary-Graveyard.jpg'),
(99, 'Deadmines', 1, 2, 'Deadmines', 'images/instances/Classic_Icons/10-Deadmines.jpg'),
(100, 'Lower Blackrock Spire', 1, 2, 'Lower Blackrock Spire', 'images/instances/Classic_Icons/10-Lower-Blackrock-Spire.jpg'),
(101, 'Zul''Farak', 1, 2, 'Zul''Farrak', 'images/instances/Classic_Icons/10-Zul-Farak.jpg'),
(102, 'Blackrock Depths', 1, 2, 'Blackrock Depths', 'images/instances/Classic_Icons/5-Blackrock Depths.jpg'),
(103, 'Dire Maul - West', 1, 2, 'Dire Maul - West', 'images/instances/Classic_Icons/5-Dire-Maul-West.jpg'),
(104, 'Upper Blackrock Spire', 1, 1, 'Upper Blackrock Spire', 'images/instances/Classic_Icons/10-Upper-Blackrock-Spire.jpg'),
(105, 'Gnomeregan', 1, 2, 'Gnomeregan', 'images/instances/Classic_Icons/10-Gnomeregan.jpg'),
(106, 'Temple Of Ahn''Qiraj', 1, 1, 'Ahn''Qiraj Temple', 'images/instances/Classic_Icons/40-Temple-Of-AhnQiraj.jpg'),
(107, 'Scarlet Monestary - Library', 1, 2, 'Scarlet Monastery - Library', 'images/instances/Classic_Icons/10-Scarlet-Monestary-Library.jpg'),
(108, 'Scarlet Monestary - Cathedral', 1, 2, 'Scarlet Monastery - Cathedral', 'images/instances/Classic_Icons/10-Scarlet-Monestary-Cathedral.jpg'),
(109, 'Sunken Temple', 1, 2, 'Sunken Temple', 'images/instances/Classic_Icons/10-Sunken-Temple.jpg'),
(110, 'Maraudon', 1, 2, 'Maraudon', 'images/instances/Classic_Icons/10-Maraudon.jpg'),
(111, 'Ragefire Chasm', 1, 2, 'Ragefire Chasm', 'images/instances/Classic_Icons/10-Ragefire-Chasm.jpg'),
(112, 'Dire Maul - East', 1, 2, 'Dire Maul - East', 'images/instances/Classic_Icons/5-Dire-Maul-East.jpg'),
(113, 'Dire Maul - North', 1, 2, 'Dire Maul - North', 'images/instances/Classic_Icons/5-Dire-Maul-North.jpg'),
(114, 'Ruins Of Ahn''Qiraj', 1, 1, 'Ahn''Qiraj Ruins', 'images/instances/Classic_Icons/20-Ruins-Of-AhnQiraj.jpg'),
(115, 'Razorfen Downs', 1, 2, 'Razorfen Downs', 'images/instances/Classic_Icons/10-Razorfen-Downs.jpg'),
(116, 'Razorfen Kraul', 1, 2, 'Razorfen Kraul', 'images/instances/Classic_Icons/10-Razorfen-Kraul.jpg'),
(117, 'Vault of Archavon', 3, 1, 'Vault of Archavon', 'images/instances/WotLK_Icons/10-Vault-of-Archavon.jpg'),
(118, 'Vault of Archavon - Heroic', 3, 1, 'Vault of Archavon (Heroic)', 'images/instances/WotLK_Icons/25-Vault-of-Archavon.jpg'),
(119, 'Generic Event', 0, 5, '', 'images/instances/Misc_Icons/GEN-Event.jpg'),
(120, 'PvP Event', 0, 3, '', 'images/instances/Misc_Icons/GEN-PvP.jpg'),
(121, 'Meeting', 0, 4, '', 'images/instances/Misc_Icons/GEN-Meeting.jpg');

DROP TABLE IF EXISTS `phpraid_event_type`;
CREATE TABLE `phpraid_event_type` (
  `event_type_id` tinyint(2) NOT NULL auto_increment,
  `event_type_name` varchar(50) NOT NULL,
  `event_type_lang_id` varchar(50) NOT NULL,
  PRIMARY KEY  (`event_type_id`)
) ;

INSERT INTO `phpraid_event_type` (`event_type_id`, `event_type_name`, `event_type_lang_id`) VALUES
(1, 'Raid', 'event_type_raid'),
(2, 'Dungeon', 'event_type_dungeon'),
(3, 'PvP Event', 'event_type_pvp'),
(4, 'Meeting', 'event_type_meeting'),
(5, 'Other', 'event_type_other');

DROP TABLE IF EXISTS `phpraid_expansion`;
CREATE TABLE `phpraid_expansion` (
  `exp_id` tinyint(2) NOT NULL auto_increment,
  `exp_name` varchar(50) NOT NULL,
  `exp_lang_id` varchar(50) NOT NULL,
  PRIMARY KEY  (`exp_id`)
) ;

INSERT INTO `phpraid_expansion` (`exp_id`, `exp_name`, `exp_lang_id`) VALUES
(1, 'Generic', 'exp_generic_wow'),
(2, 'BC', 'exp_burning_crusade'),
(3, 'WotLK', 'exp_wrath_lich_king');

INSERT INTO `phpraid_version` VALUES ('3.6.0','Version 3.6.0 of WoW Raid Manager');
INSERT INTO `phpraid_version` VALUES ('3.6.0.1','Version 3.6.0.1 of WoW Raid Manager');
INSERT INTO `phpraid_version` VALUES ('3.6.0.2','Version 3.6.0.2 of WoW Raid Manager');
INSERT INTO `phpraid_version` VALUES ('3.6.1','Version 3.6.1 of WoW Raid Manager');