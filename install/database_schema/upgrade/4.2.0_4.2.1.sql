-- Class Data
delete from wrm_classes;
INSERT INTO `wrm_classes` VALUES (6, 'Death Knight', 'dk', 'deathknight', 'images/wow/classes/deathknight_icon.gif');
INSERT INTO `wrm_classes` VALUES (11, 'Druid', 'dr', 'druid', 'images/wow/classes/druid_icon.gif');
INSERT INTO `wrm_classes` VALUES (3, 'Hunter', 'hu', 'hunter', 'images/wow/classes/hunter_icon.gif');
INSERT INTO `wrm_classes` VALUES (8, 'Mage', 'ma', 'mage', 'images/wow/classes/mage_icon.gif');
INSERT INTO `wrm_classes` VALUES (2, 'Paladin', 'pa', 'paladin', 'images/wow/classes/paladin_icon.gif');
INSERT INTO `wrm_classes` VALUES (5, 'Priest', 'pr', 'priest', 'images/wow/classes/priest_icon.gif');
INSERT INTO `wrm_classes` VALUES (4, 'Rogue', 'ro', 'rogue', 'images/wow/classes/rogue_icon.gif');
INSERT INTO `wrm_classes` VALUES (7, 'Shaman', 'sh', 'shaman', 'images/wow/classes/shaman_icon.gif');
INSERT INTO `wrm_classes` VALUES (9, 'Warlock', 'wk', 'warlock', 'images/wow/classes/warlock_icon.gif');
INSERT INTO `wrm_classes` VALUES (1, 'Warrior', 'wa', 'warrior', 'images/wow/classes/warrior_icon.gif');

-- Event Table Data
delete from wrm_events;
INSERT INTO `wrm_events` ( `zone_desc`, `max`, `exp_id`, `event_type_id`, `wow_name`, `icon_path`) VALUES
('Stormwind', 99, 1, 0, '', 'images/wow/instances/Misc_Icons/LOC-Stormwind.jpg'),
('Thunder Bluff', 99, 1, 0, '', 'images/wow/instances/Misc_Icons/LOC-Thunder-Bluff.jpg'),
('Silvermoon', 99, 2, 0, '', 'images/wow/instances/Misc_Icons/LOC-Silvermoon.jpg'),
('Orgrimmar', 99, 1, 0, '', 'images/wow/instances/Misc_Icons/LOC-Orgrimmar.jpg'),
('World Boss', 40, 0, 1, '', 'images/wow/instances/Misc_Icons/40-World.jpg'),
('Undercity', 99, 1, 0, '', 'images/wow/instances/Misc_Icons/LOC-Undercity.jpg'),
('Darnassus', 99, 1, 0, '', 'images/wow/instances/Misc_Icons/LOC-Darnassus.jpg'),
('Ironforge', 99, 1, 0, '', 'images/wow/instances/Misc_Icons/LOC-Ironforge.jpg'),
('Exodar', 99, 2, 0, '', 'images/wow/instances/Misc_Icons/LOC-Exodar.jpg'),
('Dalaran', 99, 3, 0, '', 'images/wow/instances/Misc_Icons/LOC-Dalaran.jpg'),
('Shattrath', 99, 2, 0, '', 'images/wow/instances/Misc_Icons/LOC-Shattrath.jpg'),
('Halls of Stone', 5, 3, 2, 'Ulduar: Halls of Stone', 'images/wow/instances/WotLK_Icons/5-Halls-Of-Stone.jpg'),
('Naxxramas', 10, 3, 1, 'Naxxramas', 'images/wow/instances/WotLK_Icons/10-Naxxramas.jpg'),
('Nexus', 5, 3, 2, 'The Nexus', 'images/wow/instances/WotLK_Icons/5-Nexus.jpg'),
('Oculus', 5, 3, 2, 'The Oculus', 'images/wow/instances/WotLK_Icons/5-Oculus.jpg'),
('Utgarde Keep', 5, 3, 2, 'Utgarde Keep', 'images/wow/instances/WotLK_Icons/5-Utgarde-Keep.jpg'),
('Eye of Eternity', 10, 3, 1, 'The Eye of Eternity', 'images/wow/instances/WotLK_Icons/10-Eye-of-Eternity.jpg'),
('Ahn''Kahet', 5, 3, 2, 'Ahn''Kahet: The Old Kingdom', 'images/wow/instances/WotLK_Icons/5-Ahn''Kahet.jpg'),
('Ahn''Kahet - Heroic', 5, 3, 2, 'Ahn''Kahet: The Old Kingdom', 'images/wow/instances/WotLK_Icons/5-Ahn''Kahet-Heroic.jpg'),
('Azjol-Nerub - Heroic', 5, 3, 2, 'Azjol-Nerub', 'images/wow/instances/WotLK_Icons/5-Azjol-Nerub-Heroic.jpg'),
('Eye of Eternity - Heroic', 25, 3, 1, 'The Eye of Eternity (Heroic)', 'images/wow/instances/WotLK_Icons/25-Eye-of-Eternity.jpg'),
('Obsidian Sanctum', 10, 3, 1, 'The Obsidian Sanctum', 'images/wow/instances/WotLK_Icons/10-Obsidian-Sanctum.jpg'),
('Mana Tombs - Heroic', 5, 2, 2, 'Auchindoun - Mana Tombs', 'images/wow/instances/BC_Icons/5-Mana-Tombs-Heroic.jpg'),
('Oculus - Heroic', 5, 3, 2, 'The Oculus', 'images/wow/instances/WotLK_Icons/5-Oculus-Heroic.jpg'),
('Violet Hold - Heroic', 5, 3, 2, 'Violet Hold', 'images/wow/instances/WotLK_Icons/5-Violet-Hold-Heroic.jpg'),
('Obsidian Sanctum - Heroic', 25, 3, 1, 'The Obsidian Sanctum (Heroic)', 'images/wow/instances/WotLK_Icons/25-Obsidian-Sanctum.jpg'),
('Halls Of Lightning - Heroic', 5, 3, 2, 'Ulduar: Halls of Lightning', 'images/wow/instances/WotLK_Icons/5-Halls-Of-Lightning-Heroic.jpg'),
('Utgarde Keep - Heroic', 5, 3, 2, 'Utgarde Keep', 'images/wow/instances/WotLK_Icons/5-Utgarde-Keep-Heroic.jpg'),
('Gundrak - Heroic', 5, 3, 2, 'Gun''Drak', 'images/wow/instances/WotLK_Icons/5-Gundrak-Heroic.jpg'),
('Halls of Stone - Heroic', 5, 3, 2, 'Ulduar: Halls of Stone', 'images/wow/instances/WotLK_Icons/5-Halls-Of-Stone-Heroic.jpg'),
('CoT: Culling of Stratholme', 5, 3, 2, 'Caverns of Time - The Culling of Stratholme', 'images/wow/instances/WotLK_Icons/5-CoT-Strat.jpg'),
('Utgarde Pinnacle - Heroic', 5, 3, 2, 'Utgarde Pinnacle', 'images/wow/instances/WotLK_Icons/5-Utgarde-Pinnacle-Heroic.jpg'),
('Azjol-Nerub', 5, 3, 2, 'Azjol-Nerub', 'images/wow/instances/WotLK_Icons/5-Azjol-Nerub.jpg'),
('Gun''drak', 5, 3, 2, 'Gun''Drak', 'images/wow/instances/WotLK_Icons/5-Gundrak.jpg'),
('Drak''Tharon Keep - Heroic', 5, 3, 2, 'Drak''Tharon Keep', 'images/wow/instances/WotLK_Icons/5-Drak''Tharon-Keep-Heroic.jpg'),
('Naxxramas - Heroic', 25, 3, 1, 'Naxxramas (Heroic)', 'images/wow/instances/WotLK_Icons/25-Naxxramas.jpg'),
('Drak''Tharon Keep', 5, 3, 2, 'Drak''Tharon Keep', 'images/wow/instances/WotLK_Icons/5-Drak''Tharon-Keep.jpg'),
('Halls Of Lightning', 5, 3, 2, 'Ulduar: Halls of Lightning', 'images/wow/instances/WotLK_Icons/5-Halls-Of-Lightning.jpg'),
('Violet Hold', 5, 3, 2, 'Violet Hold', 'images/wow/instances/WotLK_Icons/5-Violet-Hold.jpg'),
('Utgarde Pinnacle', 5, 3, 2, 'Utgarde Pinnacle', 'images/wow/instances/WotLK_Icons/5-Utgarde-Pinnacle.jpg'),
('CoT: Culling of Stratholm - Heroic', 5, 3, 2, 'Caverns of Time - The Culling of Stratholme', 'images/wow/instances/WotLK_Icons/5-CoT-Strat-Heroic.jpg'),
('Nexus - Heroic', 5, 3, 2, 'The Nexus', 'images/wow/instances/WotLK_Icons/5-Nexus-Heroic.jpg'),
('CoT: Durnholde Keep', 5, 2, 2, 'Caverns of Time - Durnholde', 'images/wow/instances/BC_Icons/5-CoT-Durnholde-Keep.jpg'),
('Steamvaults', 5, 2, 2, 'Coilfang - Steam Vaults', 'images/wow/instances/BC_Icons/5-Steamvault.jpg'),
('Black Temple', 25, 2, 1, 'Black Temple', 'images/wow/instances/BC_Icons/25-Black-Temple.jpg'),
('Shadow Labyrinth', 5, 2, 2, 'Auchindoun - Shadow Labyrinth', 'images/wow/instances/BC_Icons/5-Shadow-Labyrinth.jpg'),
('Mechanar - Heroic', 5, 2, 2, 'Tempest Keep - The Mechanar', 'images/wow/instances/BC_Icons/5-Mechanar-Heroic.jpg'),
('Sunwell', 25, 2, 1, 'The Sunwell', 'images/wow/instances/BC_Icons/25-Sunwell.jpg'),
('Botanica', 5, 2, 2, 'Tempest Keep - The Botanica', 'images/wow/instances/BC_Icons/5-Botanica.jpg'),
('Magister''s Terrace', 5, 2, 2, 'Magister''s Terrace', 'images/wow/instances/BC_Icons/5-Mag-Terr.jpg'),
('Underbog - Heroic', 5, 2, 2, 'Coilfang - Underbog', 'images/wow/instances/BC_Icons/5-Underbog-Heroic.jpg'),
('Sethekk Halls - Heroic', 5, 2, 2, 'Auchindoun - Sethekk Halls', 'images/wow/instances/BC_Icons/5-Sethekk-Halls-Heroic.jpg'),
('Auchenai Crypts - Heroic', 5, 2, 2, 'Auchindoun - Auchenai Crypts', 'images/wow/instances/BC_Icons/5-Auchenai-Crypts-Heroic.jpg'),
('Arcatraz - Heroic', 5, 2, 2, 'Tempest Keep - The Arcatraz', 'images/wow/instances/BC_Icons/5-Arcatraz-Heroic.jpg'),
('Sethekk Halls', 5, 2, 2, 'Auchindoun - Sethekk Halls\r\n', 'images/wow/instances/BC_Icons/5-Sethekk-Halls.jpg'),
('Ramparts - Heroic', 5, 2, 2, 'Hellfire Citadel - Hellfire Ramparts', 'images/wow/instances/BC_Icons/5-Ramparts-Heroic.jpg'),
('Steamvaults - Heroic', 5, 2, 2, 'Coilfang - Steam Vaults', 'images/wow/instances/BC_Icons/5-Steamvault-Heroic.jpg'),
('Arcatraz', 5, 2, 2, 'Tempest Keep - The Arcatraz', 'images/wow/instances/BC_Icons/5-Arcatraz.jpg'),
('Blood Furnace - Heroic', 5, 2, 2, 'Hellfire Citadel - Blood Furnace', 'images/wow/instances/BC_Icons/5-Blood-Furnace-Heroic.jpg'),
('Shattered Halls', 5, 2, 2, 'Hellfire Citadel - Shattered Halls', 'images/wow/instances/BC_Icons/5-Shattered-Halls.jpg'),
('Karazhan', 10, 2, 1, 'Karazhan', 'images/wow/instances/BC_Icons/10-Kara.jpg'),
('CoT: Black Morass - Heroic', 5, 2, 2, 'Caverns of Time - Dark Portal', 'images/wow/instances/BC_Icons/5-CoT-Black-Morass-Heroic.jpg'),
('Botanica - Heroic', 5, 2, 2, 'Tempest Keep - The Botanica', 'images/wow/instances/BC_Icons/5-Botanica-Heroic.jpg'),
('Gruul''s Lair', 25, 2, 1, 'Gruul''s Lair', 'images/wow/instances/BC_Icons/25-Gruul.jpg'),
('Slave Pens', 5, 2, 2, 'Coilfang - Slave Pens', 'images/wow/instances/BC_Icons/5-Slave-Pens.jpg'),
('Mana Tombs', 5, 2, 2, 'Auchindoun - Mana Tombs', 'images/wow/instances/BC_Icons/5-Mana-Tombs.jpg'),
('CoT: Durnholde Keep - Heroic', 5, 2, 2, 'Caverns of Time - Durnholde', 'images/wow/instances/BC_Icons/5-CoT-Durnholde-Keep-Heroic.jpg'),
('Blood Furnace', 5, 2, 2, 'Hellfire Citadel - Blood Furnace', 'images/wow/instances/BC_Icons/5-Blood-Furnace.jpg'),
('CoT: Black Morass', 5, 2, 2, 'Caverns of Time - Dark Portal', 'images/wow/instances/BC_Icons/5-CoT-Black-Morass.jpg'),
('Magister''s Terrace - Heroic', 5, 2, 2, 'Magister''s Terrace', 'images/wow/instances/BC_Icons/5-Mag-Terr-Heroic.jpg'),
('CoT: Mt. Hyjal', 25, 2, 1, 'Hyjal Past', 'images/wow/instances/BC_Icons/25-CoT-Hyjal.jpg'),
('Underbog', 5, 2, 2, 'Coilfang - Underbog', 'images/wow/instances/BC_Icons/5-Underbog.jpg'),
('Mechanar', 5, 2, 2, 'Tempest Keep - The Mechanar', 'images/wow/instances/BC_Icons/5-Mechanar.jpg'),
('Shattered Halls - Heroic', 5, 2, 2, 'Hellfire Citadel - Shattered Halls', 'images/wow/instances/BC_Icons/5-Shattered-Halls-Heroic.jpg'),
('Serpentshrine Cavern', 25, 2, 1, 'Serpentshrine Cavern', 'images/wow/instances/BC_Icons/25-Serpentshrine-Cavern.jpg'),
('Tempest Keep', 25, 2, 1, 'Tempest Keep', 'images/wow/instances/BC_Icons/25-Tempest-Keep.jpg'),
('Magtheridon''s Lair', 25, 2, 1, 'Magtheridon''s Lair', 'images/wow/instances/BC_Icons/25-Mags-Lair.jpg'),
('Shadow Labyrinth - Heroic', 5, 2, 2, 'Auchindoun - Shadow Labyrinth', 'images/wow/instances/BC_Icons/5-Shadow-Labyrinth-Heroic.jpg'),
('Slave Pens - Heroic', 5, 2, 2, 'Coilfang - Slave Pens', 'images/wow/instances/BC_Icons/5-Slave-Pens-Heroic.jpg'),
('Zul''Aman', 10, 2, 1, 'Zul''Aman', 'images/wow/instances/BC_Icons/10-ZulAman.jpg'),
('Auchenai Crypts', 5, 2, 2, 'Auchindoun - Auchenai Crypts', 'images/wow/instances/BC_Icons/5-Auchenai-Crypts.jpg'),
('Ramparts', 5, 2, 2, 'Hellfire Citadel - Hellfire Ramparts', 'images/wow/instances/BC_Icons/5-Ramparts.jpg'),
('Stratholme', 5, 1, 2, 'Stratholme', 'images/wow/instances/Classic_Icons/5-Stratholme.jpg'),
('Scarlet Monestary - Armory', 10, 1, 2, 'Scarlet Monastery - Armory', 'images/wow/instances/Classic_Icons/10-Scarlet-Monestary-Armory.jpg'),
('Shadowfang Keep', 10, 1, 2, 'Shadowfang Keep', 'images/wow/instances/Classic_Icons/10-Shadowfang-Keep.jpg'),
('Scholomance', 5, 1, 2, 'Scholomance', 'images/wow/instances/Classic_Icons/5-Scholomance.jpg'),
('Onyxia''s Lair', 40, 1, 1, 'Onyxia''s Lair', 'images/wow/instances/Classic_Icons/40-Onyxias-Lair.jpg'),
('Blackwing Lair', 40, 1, 1, 'Blackwing Lair', 'images/wow/instances/Classic_Icons/40-Blackwing-Lair.jpg'),
('Blackfathom Deeps', 10, 1, 2, 'Blackfathom Deeps', 'images/wow/instances/Classic_Icons/10-Blackfathom-Deeps.jpg'),
('Stockades', 10, 1, 2, 'Stormwind Stockades', 'images/wow/instances/Classic_Icons/10-Stockade.jpg'),
('Uldaman', 10, 1, 2, 'Uldaman', 'images/wow/instances/Classic_Icons/10-Uldaman.jpg'),
('Zul''Gurub', 10, 1, 1, 'Zul''Gurub', 'images/wow/instances/Classic_Icons/10-Zul-Gurub.jpg'),
('Molten Core', 40, 1, 1, 'Molten Core', 'images/wow/instances/Classic_Icons/40-Molten-Core.jpg'),
('Wailing Caverns', 10, 1, 2, 'Wailing Caverns', 'images/wow/instances/Classic_Icons/10-Wailing-Caverns.jpg'),
('Scarlet Monestary - Graveyard', 10, 1, 2, 'Scarlet Monastery - Graveyard', 'images/wow/instances/Classic_Icons/10-Scarlet-Monestary-Graveyard.jpg'),
('Deadmines', 10, 1, 2, 'Deadmines', 'images/wow/instances/Classic_Icons/10-Deadmines.jpg'),
('Lower Blackrock Spire', 10, 1, 2, 'Lower Blackrock Spire', 'images/wow/instances/Classic_Icons/10-Lower-Blackrock-Spire.jpg'),
('Zul''Farak', 10, 1, 2, 'Zul''Farrak', 'images/wow/instances/Classic_Icons/10-Zul-Farak.jpg'),
('Blackrock Depths', 5, 1, 2, 'Blackrock Depths', 'images/wow/instances/Classic_Icons/5-Blackrock Depths.jpg'),
('Dire Maul - West', 5, 1, 2, 'Dire Maul - West', 'images/wow/instances/Classic_Icons/5-Dire-Maul-West.jpg'),
('Upper Blackrock Spire', 10, 1, 1, 'Upper Blackrock Spire', 'images/wow/instances/Classic_Icons/10-Upper-Blackrock-Spire.jpg'),
('Gnomeregan', 10, 1, 2, 'Gnomeregan', 'images/wow/instances/Classic_Icons/10-Gnomeregan.jpg'),
('Temple Of Ahn''Qiraj', 40, 1, 1, 'Ahn''Qiraj Temple', 'images/wow/instances/Classic_Icons/40-Temple-Of-AhnQiraj.jpg'),
('Scarlet Monestary - Library', 10, 1, 2, 'Scarlet Monastery - Library', 'images/wow/instances/Classic_Icons/10-Scarlet-Monestary-Library.jpg'),
('Scarlet Monestary - Cathedral', 10, 1, 2, 'Scarlet Monastery - Cathedral', 'images/wow/instances/Classic_Icons/10-Scarlet-Monestary-Cathedral.jpg'),
('Sunken Temple', 10, 1, 2, 'Sunken Temple', 'images/wow/instances/Classic_Icons/10-Sunken-Temple.jpg'),
('Maraudon', 10, 1, 2, 'Maraudon', 'images/wow/instances/Classic_Icons/10-Maraudon.jpg'),
('Ragefire Chasm', 10, 1, 2, 'Ragefire Chasm', 'images/wow/instances/Classic_Icons/10-Ragefire-Chasm.jpg'),
('Dire Maul - East', 5, 1, 2, 'Dire Maul - East', 'images/wow/instances/Classic_Icons/5-Dire-Maul-East.jpg'),
('Dire Maul - North', 5, 1, 2, 'Dire Maul - North', 'images/wow/instances/Classic_Icons/5-Dire-Maul-North.jpg'),
('Ruins Of Ahn''Qiraj', 20, 1, 1, 'Ahn''Qiraj Ruins', 'images/wow/instances/Classic_Icons/20-Ruins-Of-AhnQiraj.jpg'),
('Razorfen Downs', 10, 1, 2, 'Razorfen Downs', 'images/wow/instances/Classic_Icons/10-Razorfen-Downs.jpg'),
('Razorfen Kraul', 10, 1, 2, 'Razorfen Kraul', 'images/wow/instances/Classic_Icons/10-Razorfen-Kraul.jpg'),
('Vault of Archavon', 10, 3, 1, 'Vault of Archavon', 'images/wow/instances/WotLK_Icons/10-Vault-of-Archavon.jpg'),
('Vault of Archavon - Heroic', 25, 3, 1, 'Vault of Archavon (Heroic)', 'images/wow/instances/WotLK_Icons/25-Vault-of-Archavon.jpg'),
('Generic Event', 99, 0, 5, '', 'images/wow/instances/Misc_Icons/GEN-Event.jpg'),
('PvP Event', 40, 0, 3, '', 'images/wow/instances/Misc_Icons/GEN-PvP.jpg'),
('Meeting', 99, 0, 4, '', 'images/wow/instances/Misc_Icons/GEN-Meeting.jpg'),
('Ulduar', 10, 3, 1, 'Ulduar', 'images/wow/instances/WotLK_Icons/10-Ulduar.jpg'),
('Ulduar - Heroic', 25, 3, 1, 'Ulduar (Heroic)', 'images/wow/instances/WotLK_Icons/25-Ulduar.jpg'),
('Trial - Champion', 5, 3, 2, 'Trial of the Champion', 'images/wow/instances/WotLK_Icons/5-Trial-of-the-Champion.jpg'),
('Trial - Champion - Heroic', 5, 3, 2, 'Trial of the Champion (Heroic)', 'images/wow/instances/WotLK_Icons/5-Trial-of-the-Champion-Heroic.jpg'), 
('Trial - Crusader - 10 man', 10, 3, 1, 'Trial of the Crusader (10)', 'images/wow/instances/WotLK_Icons/10-Trial-of-the-Crusader.jpg'),
('Trial - Crusader - 25 man', 25, 3, 1, 'Trial of the Crusader (25)', 'images/wow/instances/WotLK_Icons/25-Trial-of-the-Crusader.jpg'),
('Trial - Grand Crusader - 10 man', 10, 3, 1, 'Trial of the Grand Crusader (10)', 'images/wow/instances/WotLK_Icons/10-Trial-of-the-Grand-Crusader.jpg'),
('Trial - Grand Crusader - 25 man', 25, 3, 1, 'Trial of the Grand Crusader (25)', 'images/wow/instances/WotLK_Icons/25-Trial-of-the-Grand-Crusader.jpg'),
('Forge of Souls', 5, 3, 2, 'The Forge of Souls', 'images/wow/instances/WotLK_Icons/5-Forge-Of-Souls.jpg'),
('Forge of Souls - Heroic', 5, 3, 2, 'The Forge of Souls (Heroic)', 'images/wow/instances/WotLK_Icons/5-Forge-Of-Souls-Heroic.jpg'), 
('Pit of Saron', 5, 3, 2, 'Pit of Saron', 'images/wow/instances/5-Pit-Of-Saron.jpg'),
('Pit of Saron - Heroic', 5, 3, 2, 'Pit of Saron (Heroic)', 'images/wow/instances/WotLK_Icons/5-Pit-Of-Saron-Heroic.jpg'), 
('Halls of Reflection', 5, 3, 2, 'Halls of Reflection', 'images/wow/instances/5-Halls-Of-Reflection.jpg'),
('Halls of Reflection - Heroic', 5, 3, 2, 'Halls of Reflection (Heroic)', 'images/wow/instances/WotLK_Icons/5-Halls-Of-Reflection-Heroic.jpg'), 
('Icecrown Citadel - 10 man', 10, 3, 1, 'Icecrown Citadel (10)', 'images/wow/instances/WotLK_Icons/10-Icecrown-Citadel.jpg'),
('Icecrown Citadel - 25 man', 25, 3, 1, 'Icecrown Citadel (25)', 'images/wow/instances/WotLK_Icons/25-Icecrown-Citadel.jpg');

-- Ruby Sanctum
INSERT INTO `wrm_events` (`event_id`, `zone_desc`, `max`, `exp_id`, `event_type_id`, `wow_name`, `icon_path`) VALUES ('138', 'Ruby Sanctum - 10 man', '10', '3', '1', 'Ruby Sanctum (10)', 'images/wow/instances/WotLK_Icons/10-Ruby-Sanctum.jpg');
INSERT INTO `wrm_events` (`event_id`, `zone_desc`, `max`, `exp_id`, `event_type_id`, `wow_name`, `icon_path`) VALUES ('139', 'Ruby Sanctum - 25 man', '25', '3', '1', 'Ruby Sanctum (25)', 'images/wow/instances/WotLK_Icons/25-Ruby-Sanctum.jpg');

-- Cataclysm Events
INSERT INTO `wrm_events` ( `zone_desc`, `max`, `exp_id`, `event_type_id`, `wow_name`, `icon_path`) VALUES
('Abyssal Maw', 5, 4, 2, 'Abyssal Maw', 'images/wow/instances/Cataclysm_Icons/dungeons/5-Abyssal-Maw.jpg'), 
('Abyssal Maw - Heroic', 5, 4, 2, 'Abyssal Maw (Heroic)', 'images/wow/instances/Cataclysm_Icons/dungeons/5-Abyssal-Maw-Heroic.jpg'),
('Blackrock Caverns', 5, 4, 2, 'Blackrock Caverns', 'images/wow/instances/Cataclysm_Icons/dungeons/5-Blackrock-Caverns.jpg'), 
('Blackrock Caverns - Heroic', 5, 4, 2, 'Blackrock Caverns (Heroic)', 'images/wow/instances/Cataclysm_Icons/dungeons/5-Blackrock-Caverns-Heroic.jpg'), 
('Grim Batol', 5, 4, 2, 'Grim Batol', 'images/wow/instances/Cataclysm_Icons/dungeons/5-Grim-Batol.jpg'), 
('Grim Batol - Heroic', 5, 4, 2, 'Grim Batol (Heroic)', 'images/wow/instances/Cataclysm_Icons/dungeons/5-Grim-Batol-Heroic.jpg'), 
('Halls of Origination', 5, 4, 2, 'Halls of Origination', 'images/wow/instances/Cataclysm_Icons/dungeons/5-Halls-Of-Origination.jpg'), 
('Halls of Origination - Heroic', 5, 4, 2, 'Halls of Origination (Heroic)', 'images/wow/instances/Cataclysm_Icons/dungeons/5-Halls-Of-Origination-Heroic.jpg'), 
('Lost City of Tolvir', 5, 4, 2, 'Lost City of Tolvir', 'images/wow/instances/Cataclysm_Icons/dungeons/5-Lost-City-Of-Tolvir.jpg'), 
('Lost City of Tolvir - Heroic', 5, 4, 2, 'Lost City of Tolvir (Heroic)', 'images/wow/instances/Cataclysm_Icons/dungeons/5-Lost-City-Of-Tolvir-Heroic.jpg'), 
('Stonecore', 5, 4, 2, 'Stonecore', 'images/wow/instances/Cataclysm_Icons/dungeons/5-Stonecore.jpg'), 
('Stonecore - Heroic', 5, 4, 2, 'Stonecore (Heroic)', 'images/wow/instances/Cataclysm_Icons/dungeons/5-Stonecore-Heroic.jpg'), 
('Throne of Tides', 5, 4, 2, 'Throne of Tides', 'images/wow/instances/Cataclysm_Icons/dungeons/5-Throne-Of-Tides.jpg'), 
('Throne of Tides - Heroic', 5, 4, 2, 'Throne of Tides (Heroic)', 'images/wow/instances/Cataclysm_Icons/dungeons/5-Throne-Of-Tides-Heroic.jpg'), 
('Vortex Pinnacle', 5, 4, 2, 'Vortex Pinnacle', 'images/wow/instances/Cataclysm_Icons/dungeons/5-Vortex-Pinnacle.jpg'),
('Vortex Pinnacle - Heroic', 5, 4, 2, 'Vortex Pinnacle (Heroic)', 'images/wow/instances/Cataclysm_Icons/dungeons/5-Vortex-Pinnacle-Heroic.jpg'),
('Bastion Of Twilight - 10 man', 10, 4, 1, 'Bastion Of Twilight (10)', 'images/wow/instances/Cataclysm_Icons/raids/10-Bastion-Of-Twilight.jpg'),
('Blackwing Descent - 10 man', 10, 4, 1, 'Blackwing Descent (10)', 'images/wow/instances/Cataclysm_Icons/raids/10-Blackwing-Descent.jpg'),
('Throne Of Four Winds - 10 man', 10, 4, 1, 'Throne Of Four Winds (10)', 'images/wow/instances/Cataclysm_Icons/raids/10-Throne-Of-Four-Winds.jpg'),
('Bastion Of Twilight - 25 man', 10, 4, 1, 'Bastion Of Twilight (25)', 'images/wow/instances/Cataclysm_Icons/raids/25-Bastion-Of-Twilight.jpg'),
('Blackwing Descent - 25 man', 10, 4, 1, 'Blackwing Descent (25)', 'images/wow/instances/Cataclysm_Icons/raids/25-Blackwing-Descent.jpg'),
('Throne Of Four Winds - 25 man', 10, 4, 1, 'Throne Of Four Winds (25)', 'images/wow/instances/Cataclysm_Icons/raids/25-Throne-Of-Four-Winds.jpg');

-- Zul'Gurub Patch
INSERT INTO `wrm_events` (`event_id`, `zone_desc`, `max`, `exp_id`, `event_type_id`, `wow_name`, `icon_path`) VALUES ('165', 'ZulGurub - 5 Man', '5', '4', '2', 'ZulGurub (5)', 'images/wow/instances/Cataclysm_Icons/dungeons/5-ZulGurub.jpg');
INSERT INTO `wrm_events` (`event_id`, `zone_desc`, `max`, `exp_id`, `event_type_id`, `wow_name`, `icon_path`) VALUES ('166', 'ZulGurub - 5 Man Heroic', '5', '4', '2', 'ZulGurub (5)', 'images/wow/instances/Cataclysm_Icons/dungeons/5-ZulGurub-Heoric.jpg');

-- Firelands Patch 4.2
INSERT INTO `wrm_events` (`event_id`, `zone_desc`, `max`, `exp_id`, `event_type_id`, `wow_name`, `icon_path`) VALUES ('167', 'Firelands - 10 Man', '10', '4', '1', 'Firelands (10)', 'images/wow/instances/Cataclysm_Icons/raids/10-Firelands.jpg');
INSERT INTO `wrm_events` (`event_id`, `zone_desc`, `max`, `exp_id`, `event_type_id`, `wow_name`, `icon_path`) VALUES ('168', 'Firelands - 25 Man', '25', '4', '1', 'Firelands (25)', 'images/wow/instances/Cataclysm_Icons/raids/25-Firelands.jpg');

INSERT INTO `wrm_events` ( `zone_desc`, `max`, `exp_id`, `event_type_id`, `wow_name`, `icon_path`) VALUES
('Skywall', 5, 4, 2, 'Skywall', 'images/wow/instances/Cataclysm_Icons/dungeons/5-Skywall.jpg'),
('Skywall - Heroic', 5, 4, 2, 'Skywall (Heroic)', 'images/wow/instances/Cataclysm_Icons/dungeons/5-Skywall-Heroic.jpg'),
('Skywall - 10 Man', 10, 4, 1, 'Skywall (10)', 'images/wow/instances/Cataclysm_Icons/raids/10-Skywall.jpg'),
('Skywall - 25 Man', 10, 4, 1, 'Skywall (25)', 'images/wow/instances/Cataclysm_Icons/raids/25-Skywall.jpg');

INSERT INTO `wrm_events` ( `zone_desc`, `max`, `exp_id`, `event_type_id`, `wow_name`, `icon_path`) VALUES
('Generic - 5 Man', 5, 4, 2, 'Generic Group', 'images/wow/instances/Misc_Icons/GEN-Event.jpg'),
('Generic - 5 Man Heroic', 5, 4, 2, 'Generic Group (Heroic)', 'images/wow/instances/Misc_Icons/GEN-Event.jpg'),
('Generic - 10 Man', 10, 4, 1, 'Generic Raid (10)', 'images/wow/instances/Misc_Icons/GEN-Event.jpg'),
('Generic - 25 Man', 25, 4, 1, 'Generic Raid (25)', 'images/wow/instances/Misc_Icons/GEN-Event.jpg');

-- Race/Gender Link Table Data
delete from wrm_race_gender;
INSERT INTO `wrm_race_gender` VALUES ('Draenei', 'Male', '/images/wow/faces/dr_male.gif');
INSERT INTO `wrm_race_gender` VALUES ('Draenei', 'Female', '/images/wow/faces/dr_female.gif');
INSERT INTO `wrm_race_gender` VALUES ('Dwarf', 'Male', '/images/wow/faces/dw_male.gif');
INSERT INTO `wrm_race_gender` VALUES ('Dwarf', 'Female', '/images/wow/faces/dw_female.gif');
INSERT INTO `wrm_race_gender` VALUES ('Human', 'Male', '/images/wow/faces/hu_male.gif');
INSERT INTO `wrm_race_gender` VALUES ('Human', 'Female', '/images/wow/faces/hu_female.gif');
INSERT INTO `wrm_race_gender` VALUES ('Gnome', 'Male', '/images/wow/faces/gn_male.gif');
INSERT INTO `wrm_race_gender` VALUES ('Gnome', 'Female', '/images/wow/faces/gn_female.gif');
INSERT INTO `wrm_race_gender` VALUES ('Night Elf', 'Male', '/images/wow/faces/ne_male.gif');
INSERT INTO `wrm_race_gender` VALUES ('Night Elf', 'Female', '/images/wow/faces/ne_female.gif');
INSERT INTO `wrm_race_gender` VALUES ('Worgen', 'Male', '/images/wow/faces/wg_male.gif');
INSERT INTO `wrm_race_gender` VALUES ('Worgen', 'Female', '/images/wow/faces/wg_female.gif');
INSERT INTO `wrm_race_gender` VALUES ('Blood Elf', 'Male', '/images/wow/faces/be_male.gif');
INSERT INTO `wrm_race_gender` VALUES ('Blood Elf', 'Female', '/images/wow/faces/be_female.gif');
INSERT INTO `wrm_race_gender` VALUES ('Goblin', 'Male', '/images/wow/faces/gb_male.gif');
INSERT INTO `wrm_race_gender` VALUES ('Goblin', 'Female', '/images/wow/faces/gb_female.gif');
INSERT INTO `wrm_race_gender` VALUES ('Orc', 'Male', '/images/wow/faces/or_male.gif');
INSERT INTO `wrm_race_gender` VALUES ('Orc', 'Female', '/images/wow/faces/or_female.gif');
INSERT INTO `wrm_race_gender` VALUES ('Tauren', 'Male', '/images/wow/faces/ta_male.gif');
INSERT INTO `wrm_race_gender` VALUES ('Tauren', 'Female', '/images/wow/faces/ta_female.gif');
INSERT INTO `wrm_race_gender` VALUES ('Troll', 'Male', '/images/wow/faces/tr_male.gif');
INSERT INTO `wrm_race_gender` VALUES ('Troll', 'Female', '/images/wow/faces/tr_female.gif');
INSERT INTO `wrm_race_gender` VALUES ('Undead', 'Male', '/images/wow/faces/un_male.gif');
INSERT INTO `wrm_race_gender` VALUES ('Undead', 'Female', '/images/wow/faces/un_female.gif');

-- Resistance Table Creation
DROP TABLE IF EXISTS `wrm_resistance`;
CREATE TABLE IF NOT EXISTS `wrm_resistance` (
  `resistance_name` varchar(25) NOT NULL,
  `lang_index` varchar(100) NOT NULL,
  `font_color` varchar(8) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY  (`resistance_name`)
);

-- Resistance Data
INSERT INTO `wrm_resistance` ( `resistance_name`,`lang_index`,`font_color`,`image`) VALUES ('arcane','arcane','CCFFCC','images/wow/resistances/arcane_resistance.gif');
INSERT INTO `wrm_resistance` ( `resistance_name`,`lang_index`,`font_color`,`image`) VALUES ('fire','fire','FF0000','images/wow/resistances/fire_resistance.gif');
INSERT INTO `wrm_resistance` ( `resistance_name`,`lang_index`,`font_color`,`image`) VALUES ('frost','frost','0000FF','images/wow/resistances/frost_resistance.gif');
INSERT INTO `wrm_resistance` ( `resistance_name`,`lang_index`,`font_color`,`image`) VALUES ('nature','nature','009900','images/wow/resistances/nature_resistance.gif');
INSERT INTO `wrm_resistance` ( `resistance_name`,`lang_index`,`font_color`,`image`) VALUES ('shadow','shadow','663366','images/wow/resistances/shadow_resistance.gif');

-- WRM Armory Cache
INSERT INTO `wrm_version` VALUES ('4.2.1','Version 4.2.1 of WoW Raid Manager');
