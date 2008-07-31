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
$phprlang['announcements_msg_txt'] = '內容';
$phprlang['announcements_title_txt'] = '標題';

// Calendar
$phprlang['invites'] = '邀請';
$phprlang['start'] = '開始';
$phprlang['key'] = '代表符號: <br>(*) = 已報名並列入團隊 <br>(#) = 已報名，但未列入團隊 (已列入後補或已取消)<br><font color="#FFFFFF">White</font> 日期已過。<br><font color="#FF0000">Red</font> 日期為今日。 <br><font color="#000000">Black</font> 日期於未來。';

// configuration
$phprlang['configuration_addon'] = '插件鏈結位址';
$phprlang['configuraiton_admin'] = '管理者';
$phprlang['configuration_admin_email'] = '管理者信箱';
$phprlang['configuration_anonymous'] = '允許遊客瀏覽';
$phprlang['configuration_armory_enable'] = 'Enable Armory Lookups';
$phprlang['configuration_armory_link_text'] = '正確伺服器ARMORY連結';
$phprlang['configuration_armory_language_text'] = 'Armory語言碼';
$phprlang['configuration_autoqueue'] = '報名時自動進入候補';
$phprlang['configuration_cancel'] = '取消';
$phprlang['configuration_cancel_def'] = '取消 = 將使用者移動至取消區域';
$phprlang['configuration_cancelled'] = '取消狀態';
$phprlang['configuration_comments'] = '建議';
$phprlang['configuration_comments_def'] = '建議 = 允許使用者編輯建議';
$phprlang['configuration_date'] = '日期格式<br><a href="http://www.php.net/date/" target="_blank">幫助?</a>';
$phprlang['configuration_description'] = '描述';
$phprlang['configuration_debug'] = '除蟲模式';
$phprlang['configuration_default'] = '預設群組';
$phprlang['configuration_delete'] = '刪除';
$phprlang['configuration_delete_def'] = '刪除 = 完全移除使用者登記';
$phprlang['configuration_disable'] = '關閉活動報名系統';
$phprlang['configuration_draft_def'] = '參加 = 將使用者放置於參予團隊區';
$phprlang['configuration_draft'] = '參加';
$phprlang['configuration_drafted'] = '參加 (已列入團隊)';
$phprlang['configuration_dst_text'] = '日光節約時間?';
$phprlang['configuration_email_header'] = '信箱設定';
$phprlang['configuration_email_sig'] = '信箱簽名檔';
$phprlang['configuration_enable_five_man'] = '允許五人隊伍<br><a href="docs/enable_groups.htm" target="_blank">help?</a>';
$phprlang['configuration_eqdkp_integration_text'] = 'Integrate with EqDKP<br><a href="docs/eqdkp_link.htm" target="_blank">help?</a>';
$phprlang['configuration_eqdkp_link'] = 'URL to Base of EqDKP Installation (No Trailing /)';
$phprlang['configuration_external_links_header'] = 'Integration with External Systems';
$phprlang['configuration_faction'] = '陣營';
$phprlang['configuration_freeze'] = '關閉報名至檢查時間';
$phprlang['configuration_guild_header'] = '公會設定';
$phprlang['configuration_guild_name'] = '名稱';
$phprlang['configuration_id'] = '在列表中顯示ID';
$phprlang['configuration_language'] = '語言';
$phprlang['configuration_logo'] = 'Logo鏈結位址';
$phprlang['configuration_multiple'] = '允許多重報名';
$phprlang['configuration_on_queue'] = '後補中';
$phprlang['configuration_queue'] = '後補';
$phprlang['configuration_queue_def'] = '候補 = 將使用者放置於候補區';
$phprlang['configuration_raid_settings_header'] = '團隊設定';
$phprlang['configuration_raidlead'] = '團隊指揮';
$phprlang['configuration_resop'] = '使韌性成為非必須選項';
$phprlang['configuration_register_text'] = '登寄網址';
$phprlang['configuration_role_header'] = '角色設定';
$phprlang['configuration_role1_text'] = '職業職責 #1';
$phprlang['configuration_role2_text'] = '職業職責 #2';
$phprlang['configuration_role3_text'] = '職業職責 #3';
$phprlang['configuration_role4_text'] = '職業職責 #4';
$phprlang['configuration_role5_text'] = '職業職責 #5';
$phprlang['configuration_role6_text'] = '職業職責 #6';
$phprlang['configuration_role_limit_text'] = '強制團隊職責限制';
$phprlang['configuration_class_limit_text'] = '強制團隊職業數量限制';
$phprlang['configuration_class_as_min'] = '各職業限制最少數量';
$phprlang['configuration_roster_text'] = '與WoW Roster整合';
$phprlang['configuration_rss_site'] = 'RSS:phpRaid安裝網址 (網址尾端不得輸入 /)';
$phprlang['configuration_rss_export'] = 'RSS:輸出RSS資料至網站';
$phprlang['configuration_rss_feed_amt'] = 'RSS:於RSS資料顯示之團隊數量';
$phprlang['configuration_server'] = '伺服器';
$phprlang['configuration_show_addon'] = '顯示插件連結';
$phprlang['configuration_signup_rights_header'] = '報名權限';
$phprlang['configuration_site_header'] = '網站設定';
$phprlang['configuration_sitelink'] = '"頁首" 連結';
$phprlang['configuration_template'] = '版面';
$phprlang['configuration_time'] = '時間格式 <br><a href="http://www.php.net/date/" target="_blank">help?</a>';
$phprlang['configuration_timezone_text'] = '時區';
$phprlang['configuration_user'] = '使用者';
$phprlang['configuration_user_rights_header'] = '使用者權限';
$phprlang['configuration_version_current'] = '您現在使用的是最新版的phpRaid';
$phprlang['configuration_version_info_header'] = '版本資訊';
$phprlang['configuration_version_outdated_header'] = '有新版的phpRaid可以更新!';
$phprlang['configuration_version_outdated_message'] = '您的phpRaid已經是舊版的了. 強烈建議您立即更新.<br>
													   最新的版本號是 %s 您目前的版本是 %s.<br>
													   請到後面的鏈結下載 <a href="http://www.phpraider.com/index.php?option=com_smf&Itemid=2&topic=567.0">phpRaid for BC</a>.';

// DKP View
$phprlang['eqdkp_system_link'] = 'Direct link to Associated DKP System:';

// guilds
$phprlang['guilds_header'] = '公會列表';
$phprlang['guilds_master'] = '公會管理員';
$phprlang['guilds_name'] = '公會全名';
$phprlang['guilds_tag']	= '公會簡稱';						

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

// lua_output
$phprlang['rim_download'] = '下載 RIM (團隊資料管理者)';
$phprlang['lua_download'] = '下載phpRaidViewer';
$phprlang['lua_header'] = 'LUA/Macro匯出';

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
?>