<?php
/***************************************************************************
 *                             lang_main.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: lang_main.php,v 2.00 2008/03/07 13:46:51 psotfx Exp $
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
global $phprlang;

// logging language file
require_once('lang_log.php');

// page specific language file
require_once('lang_pages.php');

// world of warcraft language file
require_once('lang_wow.php');

// admin section language file
require_once('lang_admin.php');

if (empty($phprlang) || !is_array($phprlang))
	$phprlang = array();
	
$phprlang = array_merge($phprlang, array(

// data output headers
'add_team' => '點擊以增加新隊伍',
'add_team_dropdown_text' => '將新成員增加至隊伍',
'team_global' => '使隊伍可供各類團隊使用',
'male' =>  '男性',
'female' =>  '女性',
'class' =>  '職業',
'date' =>  '日期',
'description' =>  '活動內容',
'email' =>  '信箱',
'guild' =>  '公會',
'guild_name' =>  '公會名稱',
'guild_master' =>  '公會管理員',
'guild_tag' =>  '公會簡稱',
'guild_description' =>  'Guild Description',
'guild_server' =>  'Guild Server',
'guild_faction' =>  'Guild Faction',
'guild_armory_link' =>  'Armory Link',
'guild_armory_code' =>  'Armory Code',
'guild_id' =>  'Guild ID',
'raid_force_id' =>  'Raid Force ID',
'raid_force_name' =>  'Raid Force',
'id' =>  'ID',
'invite_time' =>  '開始組隊時間',
'level' =>  '等級',
'location' =>  '活動類別',
'max_lvl' =>  '最大等級',
'max_raiders' =>  '人數限制',
'locked_header' =>  '已鎖定?',
'message' =>  '訊息',
'min_lvl' =>  '最小等級',
'name' =>  '名稱',
'officer' =>  '團隊隊長',
'no_data' =>  '<無>',
'posted_by' =>  '發佈者：',
'race' =>  '種族',
'start_time' =>  '開始時間',
'team_name' =>  '隊伍名稱',
'time' =>  '時間',
'title' =>  '標題',
'totals' =>  '總計',
'username' =>  '會員名稱',
'records' =>  '記錄',
'to' =>  '到',
'of' =>  '由',
'total' =>  '總共',
'section' =>  '選擇',
'prev' =>  '前一則',
'next' =>  '後一項',
'earned' =>  'Earned',
'spent' =>  'Spent',
'adjustment' =>  'Adjustment',
'dkp' =>  'DKP',
'buttons' =>  'Buttons',
'add_to_team' =>  'Add To Team',
'create_date' =>  'Create Date',
'create_time' =>  'Create Time',
'pri_spec' =>  'Pri Talent',
'sec_spec' =>  'Sec Talent',
'signup_spec' =>  'Draft As',
'talent_tree' =>  'Talent Tree',
'display_text' =>  'Display Text',
'perm_mod' =>  'Update Permissions',
'all' =>  'All',

// Reoccurance Text Items
'recur_header' =>  'Raid Recurrance Settings',
'raids_recur' =>  'Recurring Raids',
'daily' =>  'Daily (Every Day At This Time)',
'weekly' =>  'Weekly (On This Day of the Week)',
'monthly' =>  'Monthly (On This Day of the Month)',
'recurrance' =>  'Recurring Raid?<br><a href="../docs/recurring_raids.html" target="_blank">help?</a>',
'recur_interval' =>  'Recurrance Interval',
'recur_length' =>  'Number of Intervals to Show',

// Scheduler Texts
'scheduler_error_header' =>  'Scheduler Error',
'scheduler_unknown' =>  'The scheduler threw an Unknown error, please post the error message to WRM support.',
'scheduler_error_no_raid_found' =>  'No raid found when attempting to select the current recurring raid from the raids table.
												Recurring Raid was likely deleted, please reload the page.',
'scheduler_error_schedule_raid' =>  'Error Scheduling New Raids from Recurring Raids.',
'scheduler_error_sql_error' =>  'Generic SQL Error Occured, See Above Printed Information.',
'scheduler_error_update_recurring' =>  'Failed to Update Timestamp on Recurring Raid.',
'scheduler_error_class_limits_missing' =>  'Class Limits could not be retrieved for Recurring Raid.  
													Delete Recurring Raid and Try again.',
'scheduler_error_role_limits_missing' =>  'Role Limits could not be retrieved for Recurring Raid.  
													Delete Recurring Raid and Try again.',

// roles    職責
'role_none' =>  '無',
'role' =>  'Role', //New

// errors
'connect_socked_error' =>  '試圖連接Socket時出現錯誤 %s',
'invalid_group_title' =>  '用戶群已經存在',
'invalid_group_message' =>  '您所選擇的用戶群已經在群組中. 請按瀏覽器的倒回鍵並再試一次.',
'invalid_option_title' =>  '輸入錯誤',
'invalid_option_msg' =>  '您正以不正確的方式訪問該頁面.',
'no_user_msg' =>  '您所試圖訪問的用戶不存在或者已經刪除.',
'no_user_title' =>  '用戶不存在',
'print_error_critical' =>  '發生一個嚴重錯誤!',
'print_error_details' =>  '細節',
'print_error_minor' =>  '警告!',
'print_error_msg_begin' =>  '抱歉，WRM發生了 ',
'print_error_msg_end' =>  '如果問題持續發生，請將錯誤訊息 
									<br>貼至 <a href="http://www.wowraidmanager.net/">wowraidmanager.net Forums</a> 然後
									我們會盡全力解決您的問題. 謝謝!',
'print_error_page' =>  '頁',
'print_error_query' =>  '查詢',
'print_error_title' =>  '喔哦! 你踢到鐵板了!!',
'socket_functions_disabled' =>  '連接到更新伺服器時發生錯誤.',

// forms
'asc' =>  '遞增',
'auth_phpbb_no_groups' =>  '沒有用戶群可以加入',
'desc' =>  '遞減',
'form_error' =>  '申請單遞交時發生錯誤',
'form_select' =>  '選擇...',
'no' =>  '否',
'none' =>  '<無>',
'guild_name_missing' =>  'The Full Guild Name is missing.',
'guild_tag_missing' =>  'The Guild Tag is missing.',
'permissions_form_description' =>  '您必須輸入描述',
'permissions_form_name' =>  '您必須輸入名稱',
'profile_error_arcane' =>  '祕法抗性只可能是數字',
'profile_error_class' =>  '您必須選擇一個職業',
'profile_error_dupe' =>  '這個名稱的角色已經存在',
'profile_error_fire' =>  '火焰抗性只可能是數字',
'profile_error_frost' =>  '冰霜抗性只可能是數字',
'profile_error_guild' =>  '您必須選擇一個公會',
'profile_error_level' =>  '等級必須是1-60之間的數字',
'profile_error_name' =>  '您必須輸入一個名字',
'profile_error_nature' =>  '自然抗性只可能是數字',
'profile_error_race' =>  '您必須選擇一個種族',
'profile_error_role' =>  '您必須輸入一個職責',
'profile_error_shadow' =>  '暗影抗性只可能是抗性',
'raid_error_date' =>  '您必須輸入一個正確的日期',
'raid_error_description' =>  '必須輸入描述',
'raid_error_limits' =>  '所有的團隊限制必須輸入且必須是數字',
'raid_error_location' =>  '輸入一個團隊活動地點',
'view_error_signed_up' =>  '這個角色報名過了',
'view_error_role_undef' =>  '請確認該角色 <a href="profile.php?mode=view">Profile</a> 已設定職責。',
'yes' =>  '是',
'teams_error_no_team' =>  'No team is selected to add users to.',

// Buttons   按鈕
'submit' =>  '提交',
'reset' =>  '重置',
'confirm' =>  '確認',
'update' =>  '更新',
'confirm_deletion' =>  '確認刪除',
'filter' =>  '過律條件',
'addchar' =>  '新增角色',
'updatechar' =>  '更新角色',
'login' =>  '登入',
'logout' =>  '登出',
'signup' =>  '註冊',
'apply' =>  'Apply Options',

// generic information
'delete_msg' =>  '注意: 刪除後無法回復資料 <br>點擊下面的按鈕確認刪除.',
'maintenance_header' =>  '系統維護中',
'maintenance_message' =>  'WoW Raid Manager系統現在維護中. 請稍候再試一次.',
'disabled_header' =>  'Site Disabled Notice!',
'disabled_message' =>  'Please note, your site is disabled. Visitors can\'t use the system right now!<br>Go to <u>Configuration</u> and then uncheck <u>Disable WRM</u>',
'userclass_msg' =>  '您的使用者帳號未被授權,請聯繫系統管理者.',
'priv_title' =>  '權限不足',
'priv_msg' =>  '您沒有足夠的權限訪問該頁面. 如果您認為應該擁有此權限，請與管理者聯繫.',
'remember' =>  '在這台電腦上記住我',
'welcome' =>  '歡迎 ',

// Login Information
'login_fail_title' =>  '登入失敗',
'login_fail' =>  '您輸入了錯誤的用戶名稱或密碼. 請再試一次.',
'login_forgot_password' =>  'Forgot Your Password?',
'login_pwdreset_fail_title' =>  'Failed to Send/Reset Password',
'login_pwdreset_title' =>  'Reset Password',
'login_password_reset_msg' =>  'To Reset Your Password Please Enter the Following Information',
'login_username_email_incorrect' =>  'The Entered Username and/or Email Address is Incorrect.<br><br>Please Click the Back Button and Try Again.',
'login_password_sent' =>  'Your WRM password has been reset and the new password has been sent to:<br><br>',
'login_password_sent2' =>  '<br><br>Please check the E-Mail address listed above for a message from this system. ' .
									'If you do not see the message please check your spam folder and/or turn off ' .
									'your spam filter and use the "Forgot My Password" link again.',
'login_password_email_msg' =>  'THIS MESSAGE IS NOT SPAM!<br><br>Someone (hopefully you) has clicked the ' .
										'"Forgot My Password" link on a WRM installation and entered an account with ' .
										'your e-mail address.  Your WRM Password has been reset by the WRM system.  The ' .
										'new password is:<br><br>',
'login_password_email_msg2' =>  '<br><br>Please login to the WRM system using the above supplied password and click the ' .
										 '"Click to Change Password" link under the Log Out button to reset your password ' .
										 'to something more memorable.<br><br>If you were NOT the one to click this link please ' .
										 'contact your WRM administrator to inform them that the reset link is being abused.<br><br>' .
										 'You will still need to use the new password supplied above to access your WRM account.',
'login_password_email_sub' =>  'WRM Password Reset Notification',			 
'login_chpass_text' =>  'Change Password For User: ',
'login_chpwd' =>  'Click to Change Password',
'login_curr_password' =>  'Current Password',
'login_password_conf' =>  'Confirm Password',
'login_password_incorrect' =>  'Either the current password for the listed username is incorrect or the new password and ' .
										'confirm password do not match.<br><br>Please Click the Back Button and Try Again.',
'login_password_new' =>  'New Password',
'login_pwdreset_success' =>  'Your password HAS BEEN correctly reset.<br><br>You will need to use the new password the next time you login.',

// Days of the Week
'sunday' =>  '星期日',
'monday' =>  '星期一',
'tuesday' =>  '星期二',
'wednesday' =>  '星期三',
'thursday' =>  '星期四',
'friday' =>  '星期五',
'saturday' =>  '星期六',
'2ltrsunday' =>  'Su',
'2ltrmonday' =>  'Mo',
'2ltrtuesday' =>  'Tu',
'2ltrwednesday' =>  'We',
'2ltrthursday' =>  'Th',
'2ltrfriday' =>  'Fr',
'2ltrsaturday' =>  'Sa',

// Months
'month' =>  'Month',
'year' =>  'Year',
'month1' =>  'January',
'month2' =>  'February',
'month3' =>  'March',
'month4' =>  'April',
'month5' =>  'May',
'month6' =>  'June',
'month7' =>  'July',
'month8' =>  'August',
'month9' =>  'September',
'month10' =>  'October',
'month11' =>  'November',
'month12' =>  'December',
							
// links
'announcements_link' =>  '&raquo; 活動公告',
'configuration_link' =>  '&raquo; 系統配置',
'guilds_link' =>  '&raquo; 公會',
'home_link' =>  '&raquo; 活動報名首頁',
'calendar_link' =>  '&raquo; 檢視行事曆',
'locations_link' =>  '&raquo; 活動類別',
'permissions_link' =>  '&raquo; 權限',
'profile_link' =>  '&raquo; 個人資料',
'raids_link' =>  '&raquo; 活動列表',
'register_link' =>  '&raquo; 註冊',
'roster_link' =>  '&raquo; 名冊',
'users_link' =>  '&raquo; 用戶',
'lua_output_link' =>  '&raquo; Lua匯出',
'index_link' =>  '&raquo; 公會網站首頁',
'dkp_link' =>  '&raquo; DKP',
'bosstrack_link' =>  '&raquo; Boss Kill Tracking',
'raidsarchive_link' =>  '&raquo; Raids Archive',

// sorting information
'sort_text' =>  '排序依照',
'sort_desc' => 'Click here to sort (in descending order) by ',
'sort_asc' => 'Click here to sort (in ascending order) by ', 

// tooltips
'add' =>  '新增',
'announcements' =>  '活動公告',
'arcane' =>  '祕法抗性',
'calendar' =>  '日曆',
'cancel' =>  '取消報名',
'cancel_msg' =>  '您已經取消這次活動的報名',
'comments' =>  '備註',
'configuration' =>  '設定',
'deathknight_icon' =>  'Click to see Death Knights',
'delete' =>  '刪除',
'description' =>  '活動內容',
'druid_icon' =>  '點擊這裡查看德魯伊',
'edit' =>  '編輯',
'edit_comment' =>  '編輯備註',
'fire' =>  '火焰抗性',
'frost' =>  '冰霜抗性',
'frozen_msg' =>  '報名已經截止',
'group_name' =>  '團隊名稱',
'group_description' =>  '團隊描述',
'guilds' =>  '公會',
'has_permission' =>  '擁有權限',
'hunter_icon' =>  '點擊這裡查看獵人',
'in_queue' =>  '調整為候補隊員',
'last_login_date' =>  '最近一次登入日期',
'last_login_time' =>  '最近一次登入時間',
'locations' =>  '活動地點',
'logs' =>  '紀錄',
'lua' =>  'LUA/Macro匯出',
'mage_icon' =>  '點擊這裡查看法師',
'mark' =>  '標記為歷史活動',
'nature' =>  '自然抗性',
'new' =>  '標記為最新活動',
'not_signed_up' =>  '點擊這裡進行報名',
'out_queue' =>  '調整為正式隊員',
'paladin_icon' =>  '點擊這裡查看聖騎士',
'permissions' =>  '權限',
'priest_icon' =>  '點擊這裡查看牧師',
'priv' =>  '權限',
'profile' =>  '個人資料',
'raids' =>  '團隊',
'remove_group' =>  '從群組中移除用戶群',
'remove_user' =>  '從群組中移除用戶',
'rogue_icon' =>  '點擊這裡查看盜賊',
'shadow' =>  '暗影抗性',
'shaman_icon' =>  '點擊這裡查看薩滿',
'signed_up' =>  '您已經報名了',
'signup_add' =>  '將會員加入報名清單',
'signup_delete' =>  '將會員從報名清單移除 (無法恢復)',
'users' =>  '會員',
'warlock_icon' =>  '點擊這裡查看術士',
'warrior_icon' =>  '點擊這裡查看戰士',

));  ?>