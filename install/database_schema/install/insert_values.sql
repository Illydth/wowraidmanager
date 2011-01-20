-- Boss Kill Type Data
INSERT INTO `wrm_boss_kill_type` VALUES (1, 'Dungeon', 'boss_kill_type_dungeon', 2, '%', 0);
INSERT INTO `wrm_boss_kill_type` VALUES (2, 'Raid: 25 Man', 'boss_kill_type_25_man', 1, '25', 1);
INSERT INTO `wrm_boss_kill_type` VALUES (3, 'Raid: 10 Man', 'boss_kill_type_10_man', 1, '10', 0);
INSERT INTO `wrm_boss_kill_type` VALUES (4, 'Raid: 40 Man', 'boss_kill_type_40_man', 1, '40', 0);

-- Column Header Data - Raids1 View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'ID', '1', '1', NULL, 'id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Date', '1', '2', NULL, 'date', 'wrmdate');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Force Name', '1', '3', NULL, 'raid_force_name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Dungeon', '1', '4', NULL, 'raids_dungeon', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Invite Time', '1', '5', NULL, 'invite_time', 'wrmtime');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Start Time', '1', '6', NULL, 'start_time', 'wrmtime');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Creator', '1', '7', NULL, 'officer', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', '@class', '1', '8', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', '@role', '1', '9', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Totals', '1', '10', NULL, 'totals', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raids1', 'Buttons', '1', '11', NULL, 'buttons', NULL);
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
VALUES (NULL , 'index1', 'Force Name', '1', '5', NULL, 'raid_force_name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', 'Invite Time', '1', '6', NULL, 'invite_time', 'wrmtime');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', 'Start Time', '1', '7', NULL, 'start_time', 'wrmtime');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', 'Creator', '1', '8', NULL, 'officer', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', '@class', '1', '9', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', '@role', '1', '10', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'index1', 'Totals', '1', '11', NULL, 'totals', NULL);
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
VALUES (NULL , 'guild1', 'Name', '1', '2', NULL, 'guild_name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'guild1', 'Tag', '1', '3', NULL, 'guild_tag', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'guild1', 'Description', '1', '4', NULL, 'guild_description', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'guild1', 'Guild Master', '1', '5', NULL, 'guild_master', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'guild1', 'Server', '1', '6', NULL, 'guild_server', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'guild1', 'Faction', '1', '7', NULL, 'guild_faction', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'guild1', 'Armory Link', '1', '8', NULL, 'guild_armory_link', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'guild1', 'Armory Code', '1', '9', NULL, 'guild_armory_code', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'guild1', 'Buttons', '1', '10', NULL, 'buttons', NULL);
-- Column Header Data - Location1 View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'ID', '1', '1', NULL, 'id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Name', '1', '2', NULL, 'name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Dungeon', '1', '3', NULL, 'raids_dungeon', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Force Name', '1', '4', NULL, 'raid_force_name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Event Type', '1', '5', NULL, 'raids_eventtype_text', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Min Level', '1', '6', NULL, 'min_lvl', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Max Level', '1', '7', NULL, 'max_lvl', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', '@class', '1', '8', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', '@role', '1', '9', NULL, NULL, NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Raid Max', '1', '10', NULL, 'max_raiders', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Locked', '1', '11', NULL, 'locked_header', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'location1', 'Buttons', '1', '12', NULL, 'buttons', NULL);
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
VALUES (NULL , 'char1', 'Pri_Spec', '1', '12', NULL, 'pri_spec', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'char1', 'Sec_Spec', '1', '13', NULL , 'sec_spec', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'char1', 'Buttons', '1', '14', NULL, 'buttons', NULL);
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
VALUES (NULL , 'users1', 'Permission_Mod', '1', '7', NULL, 'perm_mod', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'users1', 'Buttons', '1', '8', NULL, 'buttons', NULL);
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
VALUES (NULL , 'roster1', 'Pri_Spec', '1', '12', NULL, 'pri_spec', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'roster1', 'Sec_Spec', '1', '13', NULL, 'sec_spec', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'roster1', 'Profile', '1', '14', NULL, 'profile', NULL);
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
VALUES (NULL , 'permissions1', 'Pr', '1', '10', NULL, 'profile', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'permissions1', 'Ra', '1', '12', NULL, 'raids', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'permissions1', 'Buttons', '1', '13', NULL, 'buttons', NULL);
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
VALUES (NULL , 'raidview1', 'Pri_Spec', '1', '9', NULL, 'pri_spec', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Sec_Spec', '1', '10', NULL, 'sec_spec', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Arcane', '1', '11', '/images/resistances/arcane_resistance.gif', 'arcane', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Fire', '1', '12', '/images/resistances/fire_resistance.gif', 'fire', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Nature', '1', '13', '/images/resistances/nature_resistance.gif', 'nature', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Frost', '1', '14', '/images/resistances/frost_resistance.gif', 'frost', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Shadow', '1', '15', '/images/resistances/shadow_resistance.gif', 'shadow', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Date', '1', '16', NULL, 'date', 'wrmdate');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Time', '1', '17', NULL, 'time', 'wrmtime');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview1', 'Buttons', '1', '18', NULL, 'buttons', NULL);
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
VALUES (NULL , 'raidview2', 'Date', '1', '9', NULL, 'date', 'wrmdate');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview2', 'Time', '1', '10', NULL, 'time', 'wrmtime');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview2', 'Role', '1', '11', NULL, 'role', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview2', 'Signup_Spec', '1', '12', NULL, 'signup_spec', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidview2', 'Buttons', '1', '13', NULL, 'buttons', NULL);
-- Column Header Data - Role1 View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'role1', 'ID', '1', '1', NULL, 'role_id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'role1', 'Role Name', '1', '2', NULL, 'role_name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'role1', 'Config Text', '1', '3', NULL, 'role_config', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'role1', 'Image', '1', '4', NULL, 'role_image', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'role1', 'Buttons', '1', '24', NULL, 'buttons', NULL);
-- Column Header Data - ClassRoleTalent1 View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'classroletalent1', 'Class', '1', '1', NULL, 'class', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'classroletalent1', 'Talent Tree', '1', '2', NULL, 'talent_tree', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'classroletalent1', 'Display Text', '1', '3', NULL, 'display_text', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'classroletalent1', 'Role Name', '1', '4', NULL, 'role_name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'classroletalent1', 'Buttons', '1', '5', NULL, 'buttons', NULL);
-- Column Header Data - raidforce1 View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidforce1', 'ID', '1', '1', NULL, 'raid_force_id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidforce1', 'Force Name', '1', '2', NULL, 'raid_force_name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidforce1', 'Guild ID', '1', '3', NULL, 'guild_id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidforce1', 'Guild Name', '1', '4', NULL, 'guild_name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'raidforce1', 'Buttons', '1', '24', NULL, 'buttons', NULL);
-- Column Header Data - missingprofile1 View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'missingprofile1', 'ID', '1', '1', NULL, 'id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'missingprofile1', 'Username', '1', '2', NULL, 'username', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'missingprofile1', 'E-Mail', '1', '3', NULL, 'email', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'missingprofile1', 'Last Login Date', '1', '5', NULL, 'last_login_date', 'wrmdate');
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'missingprofile1', 'Last Login Time', '1', '6', NULL, 'last_login_time', 'wrmtime');

-- So as not to have to add a 0 or 1 on to the end of everything above, we'll do this separately.
UPDATE `wrm_column_headers` SET `default_sort` = '1' WHERE `view_name`='raids1' AND `column_name` = 'Date' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `default_sort` = '1' WHERE `view_name`='index1' AND `column_name` = 'Date' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `default_sort` = '1' WHERE `view_name`='announcements1' AND `column_name` = 'ID' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `default_sort` = '1' WHERE `view_name`='dkp1' AND `column_name` = 'Name' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `default_sort` = '1' WHERE `view_name`='team1' AND `column_name` = 'Name' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `default_sort` = '1' WHERE `view_name`='team2' AND `column_name` = 'Name' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `default_sort` = '1' WHERE `view_name`='guild1' AND `column_name` = 'Guild Name' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `default_sort` = '1' WHERE `view_name`='location1' AND `column_name` = 'Name' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `default_sort` = '1' WHERE `view_name`='char1' AND `column_name` = 'Name' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `default_sort` = '1' WHERE `view_name`='users1' AND `column_name` = 'Username' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `default_sort` = '1' WHERE `view_name`='roster1' AND `column_name` = 'Name' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `default_sort` = '1' WHERE `view_name`='permissions1' AND `column_name` = 'ID' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `default_sort` = '1' WHERE `view_name`='permissions2' AND `column_name` = 'Username' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `default_sort` = '1' WHERE `view_name`='raidview1' AND `column_name` = 'Name' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `default_sort` = '1' WHERE `view_name`='raidview2' AND `column_name` = 'Name' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `default_sort` = '1' WHERE `view_name`='role1' AND `column_name` = 'ID' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `default_sort` = '1' WHERE `view_name`='classroletalent1' AND `column_name` = 'Class' LIMIT 1 ;
UPDATE `wrm_column_headers` SET `default_sort` = '1' WHERE `view_name`='missingprofile1' AND `column_name` = 'ID' LIMIT 1 ;

-- Config Table Data
INSERT INTO `wrm_config` VALUES ('site_name', 'WRM');
INSERT INTO `wrm_config` VALUES ('site_description', 'WRM');
INSERT INTO `wrm_config` VALUES ('site_server', 'Localhost');
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
INSERT INTO `wrm_config` VALUES ('header_link','http://www.yourdomain.com/');
INSERT INTO `wrm_config` VALUES ('header_logo','templates/default/images/logo_phpRaid.jpg');
INSERT INTO `wrm_config` VALUES ('language','english');
INSERT INTO `wrm_config` VALUES ('multiple_signups','0');
INSERT INTO `wrm_config` VALUES ('phpraid_addon_link','http://www.wowraidmanager.net');
INSERT INTO `wrm_config` VALUES ('register_url','register.php');
INSERT INTO `wrm_config` VALUES ('roster_integration','0');
INSERT INTO `wrm_config` VALUES ('show_id','0');
INSERT INTO `wrm_config` VALUES ('showphpraid_addon','1');
INSERT INTO `wrm_config` VALUES ('template','default');
INSERT INTO `wrm_config` VALUES ('time_format','h:i a');
INSERT INTO `wrm_config` VALUES ('timezone','-0600');
INSERT INTO `wrm_config` VALUES ('resop', '0');
INSERT INTO `wrm_config` VALUES ('enable_five_man', '1');
INSERT INTO `wrm_config` VALUES ('rss_site_url', 'http://localhost/phpraid');
INSERT INTO `wrm_config` VALUES ('rss_export_url', 'http://localhost/phpraid');
INSERT INTO `wrm_config` VALUES ('rss_feed_amt', '5');
INSERT INTO `wrm_config` VALUES ('enforce_role_limits', '1');
INSERT INTO `wrm_config` VALUES ('enforce_class_limits', '0');
INSERT INTO `wrm_config` VALUES ('class_as_min', '1');
INSERT INTO `wrm_config` VALUES ('enable_armory', '1');
INSERT INTO `wrm_config` VALUES ('enable_eqdkp', '0');
INSERT INTO `wrm_config` VALUES ('eqdkp_url', 'http://localhost/eqdkp');
INSERT INTO `wrm_config` VALUES ('ampm', '12');
INSERT INTO `wrm_config` VALUES ('raid_view_type','by_class');
INSERT INTO `wrm_config` VALUES ('records_per_page','25');
INSERT INTO `wrm_config` VALUES ('armory_cache_setting', 'none');
INSERT INTO `wrm_config` VALUES ('persistent_db', '1');
INSERT INTO `wrm_config` VALUES ('wrm_created_on', '1');
INSERT INTO `wrm_config` VALUES ('wrm_updated_on', '1');
INSERT INTO `wrm_config` VALUES ('max_lvl', '85');
INSERT INTO `wrm_config` VALUES ('wrm_expansion', '4');
INSERT INTO `wrm_config` VALUES ('lua_output_sort_signups', '1');
INSERT INTO `wrm_config` VALUES ('lua_output_sort_queue', '2');
INSERT INTO `wrm_config` VALUES ('lua_output_format', '2');
INSERT INTO `wrm_config` VALUES ('num_old_raids_index', '20');
INSERT INTO `wrm_config` VALUES ('wrm_utf8_support', '1');
INSERT INTO `wrm_config` VALUES ('template_body_width', 'width_normal');

-- Event Type Table Data
INSERT INTO `wrm_event_type` (`event_type_id`, `event_type_name`, `event_type_lang_id`, `def`) VALUES
(1, 'Raid', 'event_type_raid', 1),
(2, 'Dungeon', 'event_type_dungeon', 0),
(3, 'PvP Event', 'event_type_pvp', 0),
(4, 'Meeting', 'event_type_meeting', 0),
(5, 'Other', 'event_type_other', 0);

-- Gender Table Data
INSERT INTO `wrm_gender` VALUES ('Male', 'male');
INSERT INTO `wrm_gender` VALUES ('Female', 'female');

-- Role Table Data
INSERT INTO `wrm_roles` VALUES ('role1', 'Tank', 'configuration_role1_text','');
INSERT INTO `wrm_roles` VALUES ('role2', 'Melee', 'configuration_role2_text','');
INSERT INTO `wrm_roles` VALUES ('role3', 'Healing', 'configuration_role3_text','');
INSERT INTO `wrm_roles` VALUES ('role4', 'Ranged', 'configuration_role4_text','');
INSERT INTO `wrm_roles` VALUES ('role5', 'misc1', 'configuration_role5_text','');
INSERT INTO `wrm_roles` VALUES ('role6', 'misc2', 'configuration_role6_text','');

-- Permission Type Data
INSERT INTO `wrm_permission_type` (`permission_type_id`, `permission_type_name`,`permission_type_description`) VALUES ('1','WRM Superadmin','Full Access');
INSERT INTO `wrm_permission_type` (`permission_type_id`, `permission_type_name`,`permission_type_description`) VALUES ('2','WRM Users','Generic Access');
INSERT INTO `wrm_permission_type` (`permission_type_id`, `permission_type_name`,`permission_type_description`) VALUES ('3','WRM Raid Manager','Generic + Raid Manager Access  ');

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
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'admin_menubar1', 'ID', '1', '1', NULL, 'id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'admin_menubar1', 'Lang_index', '1', '2', NULL, 'admin_menu_lang_index_text', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'admin_menubar1', 'Link', '1', '3', NULL, 'admin_menu_link_text', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'admin_menubar1', 'Button', '1', '4', NULL, 'buttons', NULL);

-- Modify Column Header Data - Admin_Permissions View
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'admin_permissions1', 'ID', '1', '1', NULL, 'id', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'admin_permissions1', 'Name', '1', '2', NULL, 'name', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'admin_permissions1', 'Description', '1', '3', NULL, 'description', NULL);
INSERT INTO `wrm_column_headers` ( `ID` , `view_name` , `column_name` , `visible` , `position`, `img_url`, `lang_idx_hdr`, `format_code`)
VALUES (NULL , 'admin_permissions1', 'buttons', '1', '13', NULL, 'buttons', NULL);

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
-- INSERT INTO `wrm_menu_value` ( `menu_type_id`, `lang_index`, `menu_value_title_alt`, `show_menu_value_title_alt`, `ordering`, `link`, `menu_image`, `menu_image_show`, `permission_value_id`, `visible` ) 
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
INSERT INTO `wrm_menu_value` VALUES ('15','4','admin_raid_signupgroups','','0','3','admin_raid_signupgroups','admin_raid_signupgroups.php?mode=view','','0','2' ,'1');
INSERT INTO `wrm_menu_value` VALUES ('16','4','admin_user_settings','','0','4','admin_usersettings','admin_usersettings.php','','0','2' ,'1');
INSERT INTO `wrm_menu_value` VALUES ('17','5','admin_datatablecfg_link','','0','1','admin_datatablecfg','admin_datatablecfg.php','','0','2' ,'1');
INSERT INTO `wrm_menu_value` VALUES ('18','5','admin_rolecfg_link','','0','2','admin_rolecfg', 'admin_rolecfg.php?mode=view','','0','2' ,'1');
INSERT INTO `wrm_menu_value` VALUES ('19','5','admin_roletalent_config','','0','3','admin_roletalent','admin_roletalent.php?mode=view','','0','2' ,'1');
INSERT INTO `wrm_menu_value` VALUES ('20','6','admin_logs_link','','0','1','admin_logs','admin_logs.php?mode=view"','','0', '2','1');
-- normal data
INSERT INTO `wrm_menu_value` VALUES ('31','7','index_link','','0','1','index','index.php','','0',NULL,'1');
INSERT INTO `wrm_menu_value` VALUES ('32','7','calendar_link','','0','1','calendar','calendar.php','','0',NULL,'1');
INSERT INTO `wrm_menu_value` VALUES ('33','7','roster_link','','0','2','roster','roster.php','','0',NULL,'1');
INSERT INTO `wrm_menu_value` VALUES ('34','7','dkp_link','EQ-DKP','1','3','dkp_view','dkp_view.php','','0',NULL,'0');
INSERT INTO `wrm_menu_value` VALUES ('35','7','raidsarchive_link','','0','4','raidsarchive','raidsarchive.php?mode=view','','0',NULL,'1');
INSERT INTO `wrm_menu_value` VALUES ('36','7','bosstrack_link','','0','5','bosstracking','bosstracking.php?mode=view','','0',NULL,'0');
INSERT INTO `wrm_menu_value` VALUES ('37','7','announcements_link','','0','6','announcements','announcements.php?mode=view','','0','1','1');
INSERT INTO `wrm_menu_value` VALUES ('38','7','guilds_link','','0','7','guilds','guilds.php?mode=view','','0','3','1');
INSERT INTO `wrm_menu_value` VALUES ('39','7','locations_link','','0','8','locations','locations.php?mode=view','','0','4','1');
INSERT INTO `wrm_menu_value` VALUES ('40','7','raids_link','','0','9','raids','raids.php?mode=view','','0','6','1');
INSERT INTO `wrm_menu_value` VALUES ('41','7','lua_output_link','','0','10','lua_output_new','lua_output_new.php?mode=lua','','0','6','1');
INSERT INTO `wrm_menu_value` VALUES ('30','8','profile_link','','0','1','profile','profile.php?mode=view','','0','5','1');

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
INSERT INTO `wrm_acl_raid_permission` VALUES ('1','1');
INSERT INTO `wrm_acl_raid_permission` VALUES ('2','1');
INSERT INTO `wrm_acl_raid_permission` VALUES ('3','1');
INSERT INTO `wrm_acl_raid_permission` VALUES ('4','1');
INSERT INTO `wrm_acl_raid_permission` VALUES ('5','1');
INSERT INTO `wrm_acl_raid_permission` VALUES ('6','1');
INSERT INTO `wrm_acl_raid_permission` VALUES ('7','1');
INSERT INTO `wrm_acl_raid_permission` VALUES ('8','1');
INSERT INTO `wrm_acl_raid_permission` VALUES ('9','1');
INSERT INTO `wrm_acl_raid_permission` VALUES ('10','1');
INSERT INTO `wrm_acl_raid_permission` VALUES ('11','1');
INSERT INTO `wrm_acl_raid_permission` VALUES ('12','1');
-- WRM - Users
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
-- WRM - Raid Manager
INSERT INTO `wrm_acl_raid_permission` VALUES ('1','3');
INSERT INTO `wrm_acl_raid_permission` VALUES ('2','3');
INSERT INTO `wrm_acl_raid_permission` VALUES ('3','3');

-- Version Data
INSERT INTO `wrm_version` VALUES ('4.0.0','Version 4.0.0 of WoW Raid Manager');
INSERT INTO `wrm_version` VALUES ('4.0.1','Version 4.0.1 of WoW Raid Manager');
INSERT INTO `wrm_version` VALUES ('4.0.2','Version 4.0.2 of WoW Raid Manager');
INSERT INTO `wrm_version` VALUES ('4.0.3','Version 4.0.3 of WoW Raid Manager');
INSERT INTO `wrm_version` VALUES ('4.0.4','Version 4.0.4 of WoW Raid Manager');
INSERT INTO `wrm_version` VALUES ('4.1.0','Version 4.1.0 of WoW Raid Manager');
INSERT INTO `wrm_version` VALUES ('4.1.1','Version 4.1.1 of WoW Raid Manager');
INSERT INTO `wrm_version` VALUES ('4.1.2','Version 4.1.2 of WoW Raid Manager');
INSERT INTO `wrm_version` VALUES ('4.2.0','Version 4.2.0 of WoW Raid Manager');
