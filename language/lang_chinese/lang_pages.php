<?php
/***************************************************************************
 *                             lang_pages.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: lang_pages.php,v 2.00 2008/03/07 13:49:54 psotfx Exp $
 *
 ***************************************************************************/

/***************************************************************************
*
*    WoW Raid Manager - Raid Management Software for World of Warcraft
*    Copyright (C) 2007-2008 Douglas Wagner
*
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
****************************************************************************/
// announcements


if (empty($phprlang) || !is_array($phprlang))
	$phprlang = array();
	
$phprlang = array_merge($phprlang, array(



'announcements_header' =>  '公告訊息',
'announcements_new_header' =>  '新增公告',
'announcements_message_text' =>  '內容',
'announcements_title_text' =>  '標題',

// Calendar
'invites' =>  '邀請',
'start' =>  '開始',
'key' =>  'Key:<br>White Border = Not Signed Up<br>Green Border = Signed Up & Drafted<br>Blue Border = Signed Up, Not Drafted (queued)<br>Red Border = Signup Cancelled<br><span class="priorDay">TEXT</span> dates are in the past.<br><span class="currentDay">TEXT</span> date is today.<br><span class="postDay">TEXT</span> dates are in the future.', //New
'calendar_month_select_header' =>  'Select Month and Year to View',

// DKP View
'eqdkp_system_link' =>  'Direct link to Associated DKP System:',

// guilds
'guilds_header' =>  '公會列表',
'guilds_new_header' =>  'New Guild',
'guilds_master' =>  '公會管理員',
'guilds_name' =>  '公會全名',
'guilds_tag'	=> '公會簡稱',						
'guilds_description' =>  'Guild Description',
'guilds_server' =>  'Guild Server',
'guilds_faction' =>  'Guild Faction',
'guilds_armory_code' =>  'Armory Code for Guild',
'raid_force_header' =>  'Raid Force Listing',
'raid_force_select_text' =>  'Select Raid Force: ',
'raid_force_name_box_text' =>  'Raid Force Name',
'raid_force_guild_options_text' =>  'Guild',
'raid_force_new_header' =>  'New Raid Force Link',
'raid_force_name_missing' =>  'Raid Force Name must not be blank or NULL.',
'raid_force_duplicate' =>  'Duplicate Raid Force Name/Guild Record.',
'raid_force_guild_id_missing' =>  'Guild ID must not be blank or NULL',
'armory_lang_US' =>  'US : http://us.battle.net/wow/ : English', //New
'armory_lang_EU' =>  'EU : http://eu.battle.net/wow/ : English', //New
'armory_lang_DE' =>  'DE : http://eu.battle.net/wow/ : German', //New
'armory_lang_ES' =>  'ES : http://eu.battle.net/wow/ : Spanish', //New
'armory_lang_FR' =>  'FR : http://eu.battle.net/wow/ : French', //New
'armory_lang_KR' =>  'KR : http://kr.battle.net/wow/ : Korean', //New
'armory_lang_TW' =>  'TW : http://tw.battle.net/wow/ : Taiwainese', //New
'armory_lang_none' =>  'No Armory or Not Applicable', //New

// locations
'locations_header' =>  '活動類別',
'locations_max_lvl' =>  '最大等級',
'locations_min_lvl' =>  '最小等級',
'locations_limits_header' =>  '職業人數限制',
'locations_long' =>  '活動名稱',
'locations_new' =>  '新增類別',
'locations_raid_max' =>  '人數限制',
'locations_short' =>  '活動簡稱',	
'lock_template' =>  '已鎖定的風格?',
'locations_ro_text' =>  'Read Only: Populated With WoW Official Name for Instance',
'locations_expansion_text' =>  'Expansion',
'locations_events_text' =>  'Event Name',

// lua_output
'rim_download' =>  '下載 RIM (團隊資料管理者)',
'phprv_download' =>  '下載phpRaidViewer',
'lua_header' =>  'LUA/Macro匯出',
'sort_name' =>  'Name',
'sort_date' =>  'Date',
'output_rim' =>  'RIM (Raid Invite Manager)',
'output_phprv' =>  'PHP Raid Viewer',
'sort_signups_text' =>  'Sort Signups By:',
'sort_queue_text' =>  'Sort Queue By:',
'output_format_text' =>  'Output Format:',
'options_header' =>  'Options',
'lua_output_header' =>  'Beginning LUA Output',
'lua_show_all_raids' =>  'Output all Open Raids',
'lua_failed_to_write' =>  'LUA file could not be created due to failure to write.</b><br/>' .
									'Please set logging level to display warnings (E_WARNING or better) ' .
									'to see the issue.<br>' .
									'Use this for copy+paste:<br>',
'lua_rim_write_success' =>  '<b>LUA file created.</b><br>' . 
									'Download <a href="cache/raid_lua/phpRaid_Data.lua">phpRaid_Data.lua</a> and save 
									it to [wow-dir]\interface\addons\RIM\<br>' .
									'or use this for copy+paste:<br>',
'lua_prv_write_success' =>  '<b>LUA file created.</b><br>' . 
									'Download <a href="cache/raid_lua/phpRaid_Data.lua">phpRaid_Data.lua</a> and save 
									it to [wow-dir]\interface\addons\phpraidviewer\<br>' .
									'or use this for copy+paste:<br>',
'lua_drafted' =>  'Drafted Users',
'lua_queued' =>  'Queued Users',
'lua_macro_header' =>  'Macro output listing...',
'lua_macro_footer' =>  '<br>Macro output listing complete.<br>Copy and paste the above to a macro and run in-game.',

// permissions
'permissions_add' =>  '加入群組',
'permissions_announcements' =>  '公告',
'permissions_configuration' =>  '設定',
'permissions_details_users_header' =>  '權限細節',
'permissions_edit_header' =>  '編輯群組',
'permissions_description' =>  '描述',
'permissions_details_header' =>  '權限細節',
'permissions_guilds' =>  '公會',
'permissions_header' =>  '權限群組',
'permissions_locations' =>  '活動類別',
'permissions_logs' =>  '紀錄',
'permissions_name' =>  '名字',
'permissions_permissions' =>  '權限',
'permissions_profile' =>  '個人資料',
'permissions_raids' =>  '團隊',
'permissions_new' =>  '新增群組',
'permissions_users' =>  '用戶',
'permissions_users_header' =>  '群組中的用戶',

// profile
'profile_arcane' =>  '祕法抗性',
'profile_class' =>  '職業',
'profile_create_header' =>  '無法新增角色',
'profile_create_msg' =>  '在管理者新增一個公會之前無法新增角色',
'profile_fire' =>  '火焰抗性',
'profile_frost' =>  '冰霜抗性',
'profile_gender' =>  '性別',
'profile_guild' =>  '加入公會',
'profile_role' =>  '職責',
'profile_header' =>  '角色',
'profile_level' =>  '等級',
'profile_name' =>  '名字',
'profile_nature' =>  '自然抗性',
'profile_raid' =>  '團隊參與',
'profile_race' =>  '種族',
'profile_shadow' =>  '暗影抗性',
'iLvL' =>  "iLvL (Equipped, Best)", //New
'health' =>  "Health", //New
'mana' =>  "Mana", //New

// raids
'raids_date' =>  '日期',
'raids_description' =>  '活動內容',
'raids_dungeon' =>  '活動名稱',
'raids_freeze' =>  '報名截止時間 (離開始組隊多少小時)',
'raids_invite' =>  '組隊時間',
'raids_limits' =>  '活動限制',
'raids_location' =>  '活動類別',
'raids_max' =>  '人數限制',
'raids_max_lvl' =>  '最大等級',
'raids_min_lvl' =>  '最小等級',
'raids_old' =>  '活動歷史',
'raids_new' =>  '最新活動',
'raids_new_header' =>  '新增活動',
'raids_edit_header' =>  'Edit Raid', //new
'raids_start' =>  '開始時間',
'raids_eventtype_text' =>  'Event Type',
'raids_mark_selected_raids_to_old' =>  "all mark raids are closed and over",
		
// event types
'event_type_raid' =>  'Raid (10/25 man)',
'event_type_dungeon' =>  'Dungeon (5 man Instance)',
'event_type_pvp' =>  'PvP Event',
'event_type_meeting' =>  'Meeting (online/offline)',
'event_type_other' =>  'Other',

// expansions
'exp_generic_wow' =>  'Generic World of Warcraft',
'exp_burning_crusade' =>  'The Burning Crusade',
'exp_wrath_lich_king' =>  'Wrath of the Lich King',
'exp_cataclysm' =>  'Cataclysm',

// roster
'roster_header' =>  '公會名冊',

// registration
'register_complete_header' =>  '註冊成功',
'register_complete_msg' =>  '您已經註冊. 在管理者開啟您的權限之前無法創建角色，但是請自由登入並且調整您的設定.',
'register_confirm' =>  '您的密碼輸入不正確.',
'register_confirm_text' =>  '請再輸入一次密碼',
'register_email_header' =>  '註冊信箱',
'register_email_empty' =>  '您必須輸入一個正確的信箱地址',
'register_email_exists' =>  '這個信箱已經註冊過了',
'register_email_greeting' =>  '歡迎',
'register_email_subject' =>  '這封信是用來確認您的註冊的. 請不用回覆，不會有人處理您的回信.',
'register_email_text' =>  '信箱地址',
'register_error' =>  '註冊失敗',
'register_header' =>  '用戶註冊',
'register_pass_empty' =>  '您必須輸入一個密碼',
'register_password_text' =>  '密碼',
'register_user_empty' =>  '您必須輸入一個用戶名稱',
'register_user_exists' =>  '這個用戶名稱已經有人使用',
'register_username_text' =>  '用戶名稱',

// users
'users_assign' =>  '權限指定',
'users_char_header' =>  '使用者角色',
'users_header' =>  '使用者',

// view
'view_approved' =>  '正式報名人數',
'view_cancel_header' =>  '取消報名名單',
'view_character' =>  '角色名稱',
'view_comments' =>  '備註',
'view_create' =>  '新增一個角色然後報名',
'view_date' =>  '日期',
'view_description_header' =>  '活動內容',
'view_frozen' =>  '報名已經截止',
'view_information_header' =>  '活動訊息',
'view_invite' =>  '組隊時間',
'view_location' =>  '活動名稱',
'view_login' =>  '登入後才能報名',
'view_new' =>  '報名參加這次活動',
'view_max' =>  '人數限制',
'view_max_lvl' =>  '最大等級',
'view_min_lvl' =>  '最小等級',
'view_missing_signups_link_text' =>  'View Profles who have NOT signed up for this raid.',
'view_officer' =>  '團隊隊長',
'view_ok' =>  '開放報名',
'view_queue' =>  '選擇報名類別',
'view_queue_header' =>  '候補報名名單',
'view_queued' =>  '候補報名人數',
'view_raid_cancel_text' =>  '取消報名人數',
'view_signed' =>  '您已經報名',
'view_signup' =>  '報名狀態',
'view_signup_queue' =>  '報名為候補',
'view_signup_cancel' =>  '不出席',
'view_signup_draft' =>  '直接報名',
'view_start' =>  '開始時間',
'view_statistics_header' =>  '統計訊息',
'view_teams_link_text' =>  '建立並指定隊伍供該團隊使用',
'view_total' =>  '報名總計',
'view_username' =>  '用戶名稱',
'view_missing_signups_return_to_view' =>  'Back to Raid View', //New

// main page
'main_previous_raids' =>  '活動歷史',
'main_upcoming_raids' =>  '最新活動',
'signup' =>  '報名',
'rss_feed_text' =>  '團隊報名RSS回報',
'guild_time_string' =>  '工會時間',
'menu_header_text' =>  'WRM 選單',

// teams
'team_new_header' =>  '建立新隊伍',
'team_add_header' =>  '為隊伍增加成員',
'team_remove_header' =>  '自隊伍移除成員',
'teams_raid_view_text' =>  '返回至團隊檢視',
'team_cur_teams_header' =>  '已建立隊伍',
'team_page_header' =>  '隊伍',

// Boss Kill Tracking
'boss_kill_type_dungeon' =>  'Dungeon (5/10 Man)',
'boss_kill_type_25_man' =>  '25 Man Raid',
'boss_kill_type_10_man' =>  '10 Man Raid',
'boss_kill_type_40_man' =>  '40 Man Raid',
'bosskill_header' =>  'Track Named (Boss) Accomplishments',

//Raids Archive
'raidsarchive_header' =>  'Raids Archive',
));  ?>