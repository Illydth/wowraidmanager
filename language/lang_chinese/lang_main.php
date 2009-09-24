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

// data output headers
$phprlang['add_team']='點擊以增加新隊伍';
$phprlang['add_team_dropdown_text']='將新成員增加至隊伍';
$phprlang['team_global']='使隊伍可供各類團隊使用';
$phprlang['male'] = '男性';
$phprlang['female'] = '女性';
$phprlang['class'] = '職業';
$phprlang['date'] = '日期';
$phprlang['description'] = '活動內容';
$phprlang['email'] = '信箱';
$phprlang['guild'] = '公會';
$phprlang['guild_name'] = '公會名稱';
$phprlang['guild_master'] = '公會管理員';
$phprlang['guild_tag'] = '公會簡稱';
$phprlang['guild_description'] = 'Guild Description';
$phprlang['guild_server'] = 'Guild Server';
$phprlang['guild_faction'] = 'Guild Faction';
$phprlang['guild_armory_link'] = 'Armory Link';
$phprlang['guild_armory_code'] = 'Armory Code';
$phprlang['guild_id'] = 'Guild ID';
$phprlang['raid_force_id'] = 'Raid Force ID';
$phprlang['raid_force_name'] = 'Raid Force';
$phprlang['id'] = 'ID';
$phprlang['invite_time'] = '開始組隊時間';
$phprlang['level'] = '等級';
$phprlang['location'] = '活動類別';
$phprlang['max_lvl'] = '最大等級';
$phprlang['max_raiders'] = '人數限制';
$phprlang['locked_header'] = '已鎖定?';
$phprlang['message'] = '訊息';
$phprlang['min_lvl'] = '最小等級';
$phprlang['name'] = '名稱';
$phprlang['officer'] = '團隊隊長';
$phprlang['no_data'] = '<無>';
$phprlang['posted_by'] = '發佈者：';
$phprlang['race'] = '種族';
$phprlang['start_time'] = '開始時間';
$phprlang['team_name'] = '隊伍名稱';
$phprlang['time'] = '時間';
$phprlang['title'] = '標題';
$phprlang['totals'] = '總計';
$phprlang['username'] = '會員名稱';
$phprlang['records'] = '記錄';
$phprlang['to'] = '到';
$phprlang['of'] = '由';
$phprlang['total'] = '總共';
$phprlang['section'] = '選擇';
$phprlang['prev'] = '前一則';
$phprlang['next'] = '後一項';
$phprlang['earned'] = 'Earned';
$phprlang['spent'] = 'Spent';
$phprlang['adjustment'] = 'Adjustment';
$phprlang['dkp'] = 'DKP';
$phprlang['buttons'] = 'Buttons';
$phprlang['add_to_team'] = 'Add To Team';
$phprlang['create_date'] = 'Create Date';
$phprlang['create_time'] = 'Create Time';
$phprlang['pri_spec'] = 'Pri Talent';
$phprlang['sec_spec'] = 'Sec Talent';
$phprlang['signup_spec'] = 'Draft As';
$phprlang['talent_tree'] = 'Talent Tree';
$phprlang['display_text'] = 'Display Text';
$phprlang['perm_mod'] = 'Update Permissions';
$phprlang['all'] = 'All';

// Reoccurance Text Items
$phprlang['recur_header'] = 'Raid Recurrance Settings';
$phprlang['raids_recur'] = 'Recurring Raids';
$phprlang['daily'] = 'Daily (Every Day At This Time)';
$phprlang['weekly'] = 'Weekly (On This Day of the Week)';
$phprlang['monthly'] = 'Monthly (On This Day of the Month)';
$phprlang['recurrance'] = 'Recurring Raid?<br><a href="../docs/recurring_raids.html" target="_blank">help?</a>';
$phprlang['recur_interval'] = 'Recurrance Interval';
$phprlang['recur_length'] = 'Number of Intervals to Show';

// Scheduler Texts
$phprlang['scheduler_error_header'] = 'Scheduler Error';
$phprlang['scheduler_unknown'] = 'The scheduler threw an Unknown error, please post the error message to WRM support.';
$phprlang['scheduler_error_no_raid_found'] = 'No raid found when attempting to select the current recurring raid from the raids table.
												Recurring Raid was likely deleted, please reload the page.';
$phprlang['scheduler_error_schedule_raid'] = 'Error Scheduling New Raids from Recurring Raids.';
$phprlang['scheduler_error_sql_error'] = 'Generic SQL Error Occured, See Above Printed Information.';
$phprlang['scheduler_error_update_recurring'] = 'Failed to Update Timestamp on Recurring Raid.';
$phprlang['scheduler_error_class_limits_missing'] = 'Class Limits could not be retrieved for Recurring Raid.  
													Delete Recurring Raid and Try again.';
$phprlang['scheduler_error_role_limits_missing'] = 'Role Limits could not be retrieved for Recurring Raid.  
													Delete Recurring Raid and Try again.';

// roles    職責
$phprlang['role_none'] = '無';

// errors
$phprlang['connect_socked_error'] = '試圖連接Socket時出現錯誤 %s';
$phprlang['invalid_group_title'] = '用戶群已經存在';
$phprlang['invalid_group_message'] = '您所選擇的用戶群已經在群組中. 請按瀏覽器的倒回鍵並再試一次.';
$phprlang['invalid_option_title'] = '輸入錯誤';
$phprlang['invalid_option_msg'] = '您正以不正確的方式訪問該頁面.';
$phprlang['no_user_msg'] = '您所試圖訪問的用戶不存在或者已經刪除.';
$phprlang['no_user_title'] = '用戶不存在';
$phprlang['print_error_critical'] = '發生一個嚴重錯誤!';
$phprlang['print_error_details'] = '細節';
$phprlang['print_error_minor'] = '警告!';
$phprlang['print_error_msg_begin'] = '抱歉，phpRaid發生了 ';
$phprlang['print_error_msg_end'] = '如果問題持續發生，請將錯誤訊息 
									<br>貼至 <a href="http://www.wowraidmanager.net/">wowraidmanager.net Forums</a> 然後
									我們會盡全力解決您的問題. 謝謝!';
$phprlang['print_error_page'] = '頁';
$phprlang['print_error_query'] = '查詢';
$phprlang['print_error_title'] = '喔哦! 你踢到鐵板了!!';
$phprlang['socket_functions_disabled'] = '連接到更新伺服器時發生錯誤.';

// forms
$phprlang['asc'] = '遞增';
$phprlang['auth_phpbb_no_groups'] = '沒有用戶群可以加入';
$phprlang['desc'] = '遞減';
$phprlang['form_error'] = '申請單遞交時發生錯誤';
$phprlang['form_select'] = '選擇...';
$phprlang['no'] = '否';
$phprlang['none'] = '<無>';
$phprlang['guild_name_missing'] = 'The Full Guild Name is missing.';
$phprlang['guild_tag_missing'] = 'The Guild Tag is missing.';
$phprlang['permissions_form_description'] = '您必須輸入描述';
$phprlang['permissions_form_name'] = '您必須輸入名稱';
$phprlang['profile_error_arcane'] = '祕法抗性只可能是數字';
$phprlang['profile_error_class'] = '您必須選擇一個職業';
$phprlang['profile_error_dupe'] = '這個名稱的角色已經存在';
$phprlang['profile_error_fire'] = '火焰抗性只可能是數字';
$phprlang['profile_error_frost'] = '冰霜抗性只可能是數字';
$phprlang['profile_error_guild'] = '您必須選擇一個公會';
$phprlang['profile_error_level'] = '等級必須是1-60之間的數字';
$phprlang['profile_error_name'] = '您必須輸入一個名字';
$phprlang['profile_error_nature'] = '自然抗性只可能是數字';
$phprlang['profile_error_race'] = '您必須選擇一個種族';
$phprlang['profile_error_role'] = '您必須輸入一個職責';
$phprlang['profile_error_shadow'] = '暗影抗性只可能是抗性';
$phprlang['raid_error_date'] = '您必須輸入一個正確的日期';
$phprlang['raid_error_description'] = '必須輸入描述';
$phprlang['raid_error_limits'] = '所有的團隊限制必須輸入且必須是數字';
$phprlang['raid_error_location'] = '輸入一個團隊活動地點';
$phprlang['view_error_signed_up'] = '這個角色報名過了';
$phprlang['view_error_role_undef'] = '請確認該角色 <a href="profile.php?mode=view">Profile</a> 已設定職責。';
$phprlang['yes'] = '是';
$phprlang['teams_error_no_team'] = 'No team is selected to add users to.';

// Buttons   按鈕
$phprlang['submit'] = '提交';
$phprlang['reset'] = '重置';
$phprlang['confirm'] = '確認';
$phprlang['update'] = '更新';
$phprlang['confirm_deletion'] = '確認刪除';
$phprlang['filter'] = '過律條件';
$phprlang['addchar'] = '新增角色';
$phprlang['updatechar'] = '更新角色';
$phprlang['login'] = '登入';
$phprlang['logout'] = '登出';
$phprlang['signup'] = '註冊';


// generic information
$phprlang['delete_msg'] = '注意: 刪除後無法回復資料 <br>點擊下面的按鈕確認刪除.';
$phprlang['maintenance_header'] = '系統維護中';
$phprlang['maintenance_message'] = 'WoW Raid Manager系統現在維護中. 請稍候再試一次.';
$phprlang['disabled_header'] = 'Site Disabled Notice!';
$phprlang['disabled_message'] = 'Please note, your site is disabled. Visitors can\'t use the system right now!<br>Go to <u>Configuration</u> and then uncheck <u>Disable phpRaid</u>';
$phprlang['userclass_msg'] = '您的使用者帳號未被授權,請聯繫系統管理者.';
$phprlang['priv_title'] = '權限不足';
$phprlang['priv_msg'] = '您沒有足夠的權限訪問該頁面. 如果您認為應該擁有此權限，請與管理者聯繫.';
$phprlang['remember'] = '在這台電腦上記住我';
$phprlang['welcome'] = '歡迎 ';

// Login Information
$phprlang['login_fail_title'] = '登入失敗';
$phprlang['login_fail'] = '您輸入了錯誤的用戶名稱或密碼. 請再試一次.';
$phprlang['login_forgot_password'] = 'Forgot Your Password?';
$phprlang['login_pwdreset_fail_title'] = 'Failed to Send/Reset Password';
$phprlang['login_pwdreset_title'] = 'Reset Password';
$phprlang['login_password_reset_msg']= 'To Reset Your Password Please Enter the Following Information';
$phprlang['login_username_email_incorrect'] = 'The Entered Username and/or Email Address is Incorrect.<br><br>Please Click the Back Button and Try Again.';
$phprlang['login_password_sent'] = 'Your WRM password has been reset and the new password has been sent to:<br><br>';
$phprlang['login_password_sent2'] = '<br><br>Please check the E-Mail address listed above for a message from this system. ' .
									'If you do not see the message please check your spam folder and/or turn off ' .
									'your spam filter and use the "Forgot My Password" link again.';
$phprlang['login_password_email_msg'] = 'THIS MESSAGE IS NOT SPAM!<br><br>Someone (hopefully you) has clicked the ' .
										'"Forgot My Password" link on a WRM installation and entered an account with ' .
										'your e-mail address.  Your WRM Password has been reset by the WRM system.  The ' .
										'new password is:<br><br>';
$phprlang['login_password_email_msg2'] = '<br><br>Please login to the WRM system using the above supplied password and click the ' .
										 '"Click to Change Password" link under the Log Out button to reset your password ' .
										 'to something more memorable.<br><br>If you were NOT the one to click this link please ' .
										 'contact your WRM administrator to inform them that the reset link is being abused.<br><br>' .
										 'You will still need to use the new password supplied above to access your WRM account.';
$phprlang['login_password_email_sub'] = 'WRM Password Reset Notification'.										 
$phprlang['login_chpass_text'] = 'Change Password For User: ';
$phprlang['login_chpwd'] = 'Click to Change Password';
$phprlang['login_curr_password'] = 'Current Password';
$phprlang['login_password_conf'] = 'Confirm Password';
$phprlang['login_password_incorrect'] = 'Either the current password for the listed username is incorrect or the new password and ' .
										'confirm password do not match.<br><br>Please Click the Back Button and Try Again.';
$phprlang['login_password_new'] = 'New Password';
$phprlang['login_pwdreset_success'] = 'Your password HAS BEEN correctly reset.<br><br>You will need to use the new password the next time you login.';

// Days of the Week
$phprlang['sunday'] = '星期日';
$phprlang['monday'] = '星期一';
$phprlang['tuesday'] = '星期二';
$phprlang['wednesday'] = '星期三';
$phprlang['thursday'] = '星期四';
$phprlang['friday'] = '星期五';
$phprlang['saturday'] = '星期六';
$phprlang['2ltrsunday'] = 'Su';
$phprlang['2ltrmonday'] = 'Mo';
$phprlang['2ltrtuesday'] = 'Tu';
$phprlang['2ltrwednesday'] = 'We';
$phprlang['2ltrthursday'] = 'Th';
$phprlang['2ltrfriday'] = 'Fr';
$phprlang['2ltrsaturday'] = 'Sa';

// Months
$phprlang['month'] = 'Month';
$phprlang['year'] = 'Year';
$phprlang['month1'] = 'January';
$phprlang['month2'] = 'February';
$phprlang['month3'] = 'March';
$phprlang['month4'] = 'April';
$phprlang['month5'] = 'May';
$phprlang['month6'] = 'June';
$phprlang['month7'] = 'July';
$phprlang['month8'] = 'August';
$phprlang['month9'] = 'September';
$phprlang['month10'] = 'October';
$phprlang['month11'] = 'November';
$phprlang['month12'] = 'December';
							
// links
$phprlang['announcements_link'] = '&raquo; 活動公告';
$phprlang['configuration_link'] = '&raquo; 系統配置';
$phprlang['guilds_link'] = '&raquo; 公會';
$phprlang['home_link'] = '&raquo; 活動報名首頁';
$phprlang['calendar_link'] = '&raquo; 檢視行事曆';
$phprlang['locations_link'] = '&raquo; 活動類別';
$phprlang['permissions_link'] = '&raquo; 權限';
$phprlang['profile_link'] = '&raquo; 個人資料';
$phprlang['raids_link'] = '&raquo; 活動列表';
$phprlang['register_link'] = '&raquo; 註冊';
$phprlang['roster_link'] = '&raquo; 名冊';
$phprlang['users_link'] = '&raquo; 用戶';
$phprlang['lua_output_link'] = '&raquo; Lua匯出';
$phprlang['index_link'] = '&raquo; 公會網站首頁';
$phprlang['dkp_link'] = '&raquo; DKP';

// sorting information
$phprlang['sort_text'] = '排序依照';
$phprlang['sort_desc']='Click here to sort (in descending order) by ';
$phprlang['sort_asc']='Click here to sort (in ascending order) by '; 

// tooltips
$phprlang['add'] = '新增';
$phprlang['announcements'] = '活動公告';
$phprlang['arcane'] = '祕法抗性';
$phprlang['calendar'] = '日曆';
$phprlang['cancel'] = '取消報名';
$phprlang['cancel_msg'] = '您已經取消這次活動的報名';
$phprlang['comments'] = '備註';
$phprlang['configuration'] = '設定';
$phprlang['deathknight_icon'] = 'Click to see Death Knights';
$phprlang['delete'] = '刪除';
$phprlang['description'] = '活動內容';
$phprlang['druid_icon'] = '點擊這裡查看德魯伊';
$phprlang['edit'] = '編輯';
$phprlang['edit_comment'] = '編輯備註';
$phprlang['fire'] = '火焰抗性';
$phprlang['frost'] = '冰霜抗性';
$phprlang['frozen_msg'] = '報名已經截止';
$phprlang['group_name'] = '團隊名稱';
$phprlang['group_description'] = '團隊描述';
$phprlang['guilds'] = '公會';
$phprlang['has_permission'] = '擁有權限';
$phprlang['hunter_icon'] = '點擊這裡查看獵人';
$phprlang['in_queue'] = '調整為候補隊員';
$phprlang['last_login_date'] = '最近一次登入日期';
$phprlang['last_login_time'] = '最近一次登入時間';
$phprlang['locations'] = '活動地點';
$phprlang['logs'] = '紀錄';
$phprlang['lua'] = 'LUA/Macro匯出';
$phprlang['mage_icon'] = '點擊這裡查看法師';
$phprlang['mark'] = '標記為歷史活動';
$phprlang['nature'] = '自然抗性';
$phprlang['new'] = '標記為最新活動';
$phprlang['not_signed_up'] = '點擊這裡進行報名';
$phprlang['out_queue'] = '調整為正式隊員';
$phprlang['paladin_icon'] = '點擊這裡查看聖騎士';
$phprlang['permissions'] = '權限';
$phprlang['priest_icon'] = '點擊這裡查看牧師';
$phprlang['priv'] = '權限';
$phprlang['profile'] = '個人資料';
$phprlang['raids'] = '團隊';
$phprlang['remove_group'] = '從群組中移除用戶群';
$phprlang['remove_user'] = '從群組中移除用戶';
$phprlang['rogue_icon'] = '點擊這裡查看盜賊';
$phprlang['shadow'] = '暗影抗性';
$phprlang['shaman_icon'] = '點擊這裡查看薩滿';
$phprlang['signed_up'] = '您已經報名了';
$phprlang['signup_add'] = '將會員加入報名清單';
$phprlang['signup_delete'] = '將會員從報名清單移除 (無法恢復)';
$phprlang['users'] = '會員';
$phprlang['warlock_icon'] = '點擊這裡查看術士';
$phprlang['warrior_icon'] = '點擊這裡查看戰士';

?>
