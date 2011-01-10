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
$phprlang['announcements_header'] = '公告訊息';
$phprlang['announcements_new_header'] = '新增公告';
$phprlang['announcements_message_text'] = '內容';
$phprlang['announcements_title_text'] = '標題';

// Calendar
$phprlang['invites'] = '邀請';
$phprlang['start'] = '開始';
$phprlang['key'] = 'Key:<br>White Border = Not Signed Up<br>Green Border = Signed Up & Drafted<br>Blue Border = Signed Up, Not Drafted (queued)<br>Red Border = Signup Cancelled<br><span class="priorDay">TEXT</span> dates are in the past.<br><span class="currentDay">TEXT</span> date is today.<br><span class="postDay">TEXT</span> dates are in the future.'; //New
$phprlang['calendar_month_select_header'] = 'Select Month and Year to View';

// DKP View
$phprlang['eqdkp_system_link'] = 'Direct link to Associated DKP System:';

// guilds
$phprlang['guilds_header'] = '公會列表';
$phprlang['guilds_new_header'] = 'New Guild';
$phprlang['guilds_master'] = '公會管理員';
$phprlang['guilds_name'] = '公會全名';
$phprlang['guilds_tag']	= '公會簡稱';						
$phprlang['guilds_description'] = 'Guild Description';
$phprlang['guilds_server'] = 'Guild Server';
$phprlang['guilds_faction'] = 'Guild Faction';
$phprlang['guilds_armory_code'] = 'Armory Code for Guild';
$phprlang['armory_lang_US'] = 'US : http://us.battle.net/wow/ : English'; //New
$phprlang['armory_lang_EU'] = 'EU : http://eu.battle.net/wow/ : English'; //New
$phprlang['armory_lang_DE'] = 'DE : http://eu.battle.net/wow/ : German'; //New
$phprlang['armory_lang_ES'] = 'ES : http://eu.battle.net/wow/ : Spanish'; //New
$phprlang['armory_lang_FR'] = 'FR : http://eu.battle.net/wow/ : French'; //New
$phprlang['armory_lang_KR'] = 'KR : http://kr.battle.net/wow/ : Korean'; //New
$phprlang['armory_lang_TW'] = 'TW : http://tw.battle.net/wow/ : Taiwainese'; //New
$phprlang['armory_lang_none'] = 'No Armory or Not Applicable'; //New

// locations
$phprlang['locations_header'] = '活動類別';
$phprlang['locations_max_lvl'] = '最大等級';
$phprlang['locations_min_lvl'] = '最小等級';
$phprlang['locations_limits_header'] = '職業人數限制';
$phprlang['locations_long'] = '活動名稱';
$phprlang['locations_new'] = '新增類別';
$phprlang['locations_raid_max'] = '人數限制';
$phprlang['locations_short'] = '活動簡稱';	
$phprlang['lock_template'] = '已鎖定的風格?';
$phprlang['locations_ro_text'] = 'Read Only: Populated With WoW Official Name for Instance';
$phprlang['locations_expansion_text'] = 'Expansion';
$phprlang['locations_events_text'] = 'Event Name';

// lua_output
$phprlang['rim_download'] = '下載 RIM (團隊資料管理者)';
$phprlang['phprv_download'] = '下載phpRaidViewer';
$phprlang['lua_header'] = 'LUA/Macro匯出';
$phprlang['sort_name'] = 'Name';
$phprlang['sort_date'] = 'Date';
$phprlang['output_rim'] = 'RIM (Raid Invite Manager)';
$phprlang['output_phprv'] = 'PHP Raid Viewer';
$phprlang['sort_signups_text'] = 'Sort Signups By:';
$phprlang['sort_queue_text'] = 'Sort Queue By:';
$phprlang['output_format_text'] = 'Output Format:';
$phprlang['options_header'] = 'Options';
$phprlang['lua_output_header'] = 'Beginning LUA Output';
$phprlang['lua_show_all_raids'] = 'Output all Open Raids';
$phprlang['lua_failed_to_write'] = 'LUA file could not be created due to failure to write.</b><br/>' .
									'Please set logging level to display warnings (E_WARNING or better) ' .
									'to see the issue.<br>' .
									'Use this for copy+paste:<br>';
$phprlang['lua_rim_write_success'] = '<b>LUA file created.</b><br>' . 
									'Download <a href="cache/raid_lua/phpRaid_Data.lua">phpRaid_Data.lua</a> and save 
									it to [wow-dir]\interface\addons\RIM\<br>' .
									'or use this for copy+paste:<br>';
$phprlang['lua_prv_write_success'] = '<b>LUA file created.</b><br>' . 
									'Download <a href="cache/raid_lua/phpRaid_Data.lua">phpRaid_Data.lua</a> and save 
									it to [wow-dir]\interface\addons\phpraidviewer\<br>' .
									'or use this for copy+paste:<br>';

// permissions
$phprlang['permissions_add'] = '加入群組';
$phprlang['permissions_announcements'] = '公告';
$phprlang['permissions_configuration'] = '設定';
$phprlang['permissions_details_users_header'] = '權限細節';
$phprlang['permissions_edit_header'] = '編輯群組';
$phprlang['permissions_description'] = '描述';
$phprlang['permissions_details_header'] = '權限細節';
$phprlang['permissions_guilds'] = '公會';
$phprlang['permissions_header'] = '權限群組';
$phprlang['permissions_locations'] = '活動類別';
$phprlang['permissions_logs'] = '紀錄';
$phprlang['permissions_name'] = '名字';
$phprlang['permissions_permissions'] = '權限';
$phprlang['permissions_profile'] = '個人資料';
$phprlang['permissions_raids'] = '團隊';
$phprlang['permissions_new'] = '新增群組';
$phprlang['permissions_users'] = '用戶';
$phprlang['permissions_users_header'] = '群組中的用戶';

// profile
$phprlang['profile_arcane'] = '祕法抗性';
$phprlang['profile_class'] = '職業';
$phprlang['profile_create_header'] = '無法新增角色';
$phprlang['profile_create_msg'] = '在管理者新增一個公會之前無法新增角色';
$phprlang['profile_fire'] = '火焰抗性';
$phprlang['profile_frost'] = '冰霜抗性';
$phprlang['profile_gender'] = '性別';
$phprlang['profile_guild'] = '加入公會';
$phprlang['profile_role'] = '職責';
$phprlang['profile_header'] = '角色';
$phprlang['profile_level'] = '等級';
$phprlang['profile_name'] = '名字';
$phprlang['profile_nature'] = '自然抗性';
$phprlang['profile_raid'] = '團隊參與';
$phprlang['profile_race'] = '種族';
$phprlang['profile_shadow'] = '暗影抗性';

// raids
$phprlang['raids_date'] = '日期';
$phprlang['raids_description'] = '活動內容';
$phprlang['raids_dungeon'] = '活動名稱';
$phprlang['raids_freeze'] = '報名截止時間 (離開始組隊多少小時)';
$phprlang['raids_invite'] = '組隊時間';
$phprlang['raids_limits'] = '活動限制';
$phprlang['raids_location'] = '活動類別';
$phprlang['raids_max'] = '人數限制';
$phprlang['raids_max_lvl'] = '最大等級';
$phprlang['raids_min_lvl'] = '最小等級';
$phprlang['raids_old'] = '活動歷史';
$phprlang['raids_new'] = '最新活動';
$phprlang['raids_new_header'] = '新增活動';
$phprlang['raids_start'] = '開始時間';
$phprlang['raids_eventtype_text'] = 'Event Type';
$phprlang['raids_mark_selected_raids_to_old'] = "all mark raids are closed and over";
		
// event types
$phprlang['event_type_raid'] = 'Raid (10/25 man)';
$phprlang['event_type_dungeon'] = 'Dungeon (5 man Instance)';
$phprlang['event_type_pvp'] = 'PvP Event';
$phprlang['event_type_meeting'] = 'Meeting (online/offline)';
$phprlang['event_type_other'] = 'Other';

// expansions
$phprlang['exp_generic_wow'] = 'Generic World of Warcraft';
$phprlang['exp_burning_crusade'] = 'The Burning Crusade';
$phprlang['exp_wrath_lich_king'] = 'Wrath of the Lich King';
$phprlang['exp_cataclysm'] = 'Cataclysm';

// roster
$phprlang['roster_header'] = '公會名冊';

// registration
$phprlang['register_complete_header'] = '註冊成功';
$phprlang['register_complete_msg'] = '您已經註冊. 在管理者開啟您的權限之前無法創建角色，但是請自由登入並且調整您的設定.';
$phprlang['register_confirm'] = '您的密碼輸入不正確.';
$phprlang['register_confirm_text'] = '請再輸入一次密碼';
$phprlang['register_email_header'] = '註冊信箱';
$phprlang['register_email_empty'] = '您必須輸入一個正確的信箱地址';
$phprlang['register_email_exists'] = '這個信箱已經註冊過了';
$phprlang['register_email_greeting'] = '歡迎';
$phprlang['register_email_subject'] = '這封信是用來確認您的註冊的. 請不用回覆，不會有人處理您的回信.';
$phprlang['register_email_text'] = '信箱地址';
$phprlang['register_error'] = '註冊失敗';
$phprlang['register_header'] = '用戶註冊';
$phprlang['register_pass_empty'] = '您必須輸入一個密碼';
$phprlang['register_password_text'] = '密碼';
$phprlang['register_user_empty'] = '您必須輸入一個用戶名稱';
$phprlang['register_user_exists'] = '這個用戶名稱已經有人使用';
$phprlang['register_username_text'] = '用戶名稱';

// users
$phprlang['users_assign'] = '權限指定';
$phprlang['users_char_header'] = '使用者角色';
$phprlang['users_header'] = '使用者';

// view
$phprlang['view_approved'] = '正式報名人數';
$phprlang['view_cancel_header'] = '取消報名名單';
$phprlang['view_character'] = '角色名稱';
$phprlang['view_comments'] = '備註';
$phprlang['view_create'] = '新增一個角色然後報名';
$phprlang['view_date'] = '日期';
$phprlang['view_description_header'] = '活動內容';
$phprlang['view_frozen'] = '報名已經截止';
$phprlang['view_information_header'] = '活動訊息';
$phprlang['view_invite'] = '組隊時間';
$phprlang['view_location'] = '活動名稱';
$phprlang['view_login'] = '登入後才能報名';
$phprlang['view_new'] = '報名參加這次活動';
$phprlang['view_max'] = '人數限制';
$phprlang['view_max_lvl'] = '最大等級';
$phprlang['view_min_lvl'] = '最小等級';
$phprlang['view_missing_signups_link_text'] = 'View Profles who have NOT signed up for this raid.';
$phprlang['view_officer'] = '團隊隊長';
$phprlang['view_ok'] = '開放報名';
$phprlang['view_queue'] = '選擇報名類別';
$phprlang['view_queue_header'] = '候補報名名單';
$phprlang['view_queued'] = '候補報名人數';
$phprlang['view_raid_cancel_text'] = '取消報名人數';
$phprlang['view_signed'] = '您已經報名';
$phprlang['view_signup'] = '報名狀態';
$phprlang['view_signup_queue'] = '報名為候補';
$phprlang['view_signup_cancel'] = '不出席';
$phprlang['view_signup_draft'] = '直接報名';
$phprlang['view_start'] = '開始時間';
$phprlang['view_statistics_header'] = '統計訊息';
$phprlang['view_teams_link_text'] = '建立並指定隊伍供該團隊使用';
$phprlang['view_total'] = '報名總計';
$phprlang['view_username'] = '用戶名稱';
$phprlang['view_missing_signups_return_to_view']= 'Back to Raid View'; //New

// main page
$phprlang['main_previous_raids'] = '活動歷史';
$phprlang['main_upcoming_raids'] = '最新活動';
$phprlang['signup'] = '報名';
$phprlang['rss_feed_text'] = '團隊報名RSS回報';
$phprlang['guild_time_string'] = '工會時間';
$phprlang['menu_header_text'] = 'WRM 選單';

// teams
$phprlang['team_new_header'] = '建立新隊伍';
$phprlang['team_add_header'] = '為隊伍增加成員';
$phprlang['team_remove_header'] = '自隊伍移除成員';
$phprlang['teams_raid_view_text'] = '返回至團隊檢視';
$phprlang['team_cur_teams_header'] = '已建立隊伍';
$phprlang['team_page_header'] = '隊伍';

// Boss Kill Tracking
$phprlang['boss_kill_type_dungeon'] = 'Dungeon (5/10 Man)';
$phprlang['boss_kill_type_25_man'] = '25 Man Raid';
$phprlang['boss_kill_type_10_man'] = '10 Man Raid';
$phprlang['boss_kill_type_40_man'] = '40 Man Raid';
$phprlang['bosskill_header'] = 'Track Named (Boss) Accomplishments';

//Raids Archive
$phprlang['raidsarchive_header'] = 'Raids Archive';
?>