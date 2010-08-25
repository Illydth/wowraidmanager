<?php
//
//english install strings
//
global $wrm_install_lang;
$wrm_install_lang['headtitle'] = 'Welcome to the WRM 4.x.x Installation.';
//$wrm_install_lang['headbodyinfo'] = 'Please note that the database you install into should already exist.';
$wrm_install_lang['select_lang'] = 'Select Language';

$wrm_install_lang['step0_system_requirements'] = 'System Requirements';
$wrm_install_lang['step0_property'] = 'Property';
$wrm_install_lang['step0_required'] = 'Required';
$wrm_install_lang['step0_exist'] = 'Exist';
$wrm_install_lang['step0_phpversion_text'] = 'PHP Version';
$wrm_install_lang['step0_mysqlversion'] = 'MySQL Version';
$wrm_install_lang['step0_active'] = 'active';
$wrm_install_lang['step0_nonactive'] = 'non active';
$wrm_install_lang['step0_writeable_config'] = 'config.php writable?';
$wrm_install_lang['writable_dir_cache_text'] = 'directory: "./cache" writable';

$wrm_install_lang['yes'] = 'yes';
$wrm_install_lang['no'] = 'no';
$wrm_install_lang['upgrade'] = 'Upgrade';
$wrm_install_lang['freshinstall'] = 'Fresh Install';
$wrm_install_lang['change'] = 'change';
$wrm_install_lang['database_text'] = 'Database';

$wrm_install_lang['create_db'] = 'Create new Database?';
$wrm_install_lang['only_if_create_new_tab'] = 'only, if you has selected: "Create new Database?"';
$wrm_install_lang['default'] = 'default';
$wrm_install_lang['php_variables'] = 'PHP Variables';
$wrm_install_lang['error_found_table_titel'] = 'already, existing tables were found';
$wrm_install_lang['error_found_table_bd_back'] = 'Button Back : change Table Prefix or Database';
$wrm_install_lang['error_found_table_bd_cont'] = 'Button Continue : deletes all existing tables, before the new tables are installed';

$wrm_install_lang['install_bridge_titel'] = 'Bridge Preferences';
$wrm_install_lang['txt_group'] = 'Group';
$wrm_install_lang['txt_alt_group'] = 'Alternative Group';
$wrm_install_lang['upgrade_headtitle'] = 'Upgrade Modus';
$wrm_install_lang['expert_modus'] = 'Expert Modus';
$wrm_install_lang['hittingsubmit'] = 'Please verify all information before hitting submit!';

//botton
$wrm_install_lang['bd_continue'] = 'Continue';
$wrm_install_lang['bd_submit'] = 'Submit';
$wrm_install_lang['bd_reset'] = 'Reset';
$wrm_install_lang['bd_back'] = 'Back';
$wrm_install_lang['bd_start'] = 'Start';

$wrm_install_lang['install_version_text'] = 'Version';
$wrm_install_lang['install_version_current'] = 'Installation files are up to date';
$wrm_install_lang['install_version_info_header'] = 'Version Information';
$wrm_install_lang['install_version_header'] = 'WoW Raid Manager update available!';
$wrm_install_lang['install_version_message01'] = 'Your Installation files of WoW Raid Manager is out of date.';
$wrm_install_lang['install_version_message02'] = 'Updating is strongly recommended.';
$wrm_install_lang['install_version_message03'] = 'the latest/new version is';
$wrm_install_lang['install_version_message04'] = 'this Installation files';												   
$wrm_install_lang['install_version_message05'] = 'To download, visit the <a href="http://www.wowraidmanager.net">WoW Raid Manager download</a> section.';
$wrm_install_lang['install_connect_socked_error_header'] = 'Failed to connect';
$wrm_install_lang['install_connect_socked_error'] = 'Cannot recieve version Nr from "www.wowraidmanager.net" Server';

//step 2
$wrm_install_lang['step2_sql_server_pref'] = 'SQL Server Preferences';
$wrm_install_lang['step2upgradefrom'] = 'Upgrade to';
$wrm_install_lang['step2dbname'] = 'SQL Database';
$wrm_install_lang['step2dbserverhostname'] = 'SQL Hostname';
$wrm_install_lang['step2dbserverusername'] = 'SQL Server Username';
$wrm_install_lang['step2dbserverpwd'] = 'SQL Server Password';
$wrm_install_lang['step2WRMtableprefix'] = 'WRM Table Prefix';
$wrm_install_lang['step2installtype'] = 'Install Type';
$wrm_install_lang['step2error01'] = 'Failure to do so could cause unforeseen failure and support will not be given!';

//step 3
$wrm_install_lang['step3errordbcon'] = 'Error connecting to database.'; 
$wrm_install_lang['step3errorschema'] = 'Error opening upgrade schema';
//$wrm_install_lang['step3errorsql'] = 'Error installing<br>Query: $sql<br>Reported: ';
$wrm_install_lang['step3installinfo'] = 'If you are seeing this then no errors occurred during table installation!';
$wrm_install_lang['step3errorversion'] = 'The software version in version.php doesn\'t match database version in version table.';

//step done
$wrm_install_lang['stepdonefinished'] = 'Finished';
$wrm_install_lang['stepdonesetupcomplete'] = 'Setup is now complete.';
$wrm_install_lang['stepdoneremovedir'] = 'Be sure to remove the "install/" directory and click <a href="../index.php">here</a> when you have done so.';

//stuff
$wrm_install_lang['hittingsubmit'] = 'Please verify all information before hitting submit!';
$wrm_install_lang['pressbrowserpack'] = 'Press your browsers BACK button to try again.';
$wrm_install_lang['problem'] = 'Problem';
$wrm_install_lang['txtusername'] = 'Username';
$wrm_install_lang['txt_admin_username'] = 'Administrator Username';
$wrm_install_lang['txtpassword'] = 'Password';
$wrm_install_lang['txtemail'] = 'E-mail';
$wrm_install_lang['txtconfig'] = 'config';

//errors
$wrm_install_lang['connect_socked_error'] = 'Failed to connect to socket with error %s';
$wrm_install_lang['invalid_group_title'] = 'Group exists';
$wrm_install_lang['invalid_group_message'] = 'The group selected is already part of this set. Press your browsers BACK button to try again.';
$wrm_install_lang['invalid_option_title'] = 'Invalid input for page';
$wrm_install_lang['invalid_option_msg'] = 'You have tried to access this page using invalid input.';
$wrm_install_lang['no_user_msg'] = 'The user you are trying to view does not exist or has been deleted.';
$wrm_install_lang['no_user_title'] = 'User does not exist';
$wrm_install_lang['print_error_critical'] = 'a critical error!';
$wrm_install_lang['print_error_details'] = 'Details';
$wrm_install_lang['print_error_minor'] = 'a minor error!';
$wrm_install_lang['print_error_msg_begin'] = 'Sorry, WRM has encountered ';
$wrm_install_lang['print_error_msg_end'] = 'If this error persists, please make a post 
									with this message <br>on the <a href="http://www.wowraidmanager.net/">wowraidmanager.net Forums</a> and
									we will do our best to get it corrected. Thanks!';
$wrm_install_lang['print_error_page'] = 'Page';
$wrm_install_lang['print_error_query'] = 'Query';
$wrm_install_lang['print_error_title'] = 'Uh oh! You hit a boo boo';

$wrm_install_lang['step2errordbcon_titel'] = "Error connecting to Server (Servername or Username or Password incorrect)";
//--------------------------
// Auth.
//--------------------------
$wrm_install_lang['expert_modus'] = "Expert Modus";

$wrm_install_lang['step5failconWRM'] = 'Unable to connect to WRM DB';
$wrm_install_lang['step5selctusername'] = 'set full permissions to selected Username';
$wrm_install_lang['step5sub1follval'] = 'In order to complete the installation please fill in the following values';
$wrm_install_lang['step5done'] = 'done';
$wrm_install_lang['step5sub2usernamefullperm'] = 'Select the username will be given full wowRaidManager permissions';
$wrm_install_lang['step5sub3norest'] = 'No Restrictions';
$wrm_install_lang['step5sub3noaddus'] = 'No Additional UserGroup';
$wrm_install_lang['step5sub2failfindfile'] = 'Failed to find config file:';
$wrm_install_lang['step5sub2checkdir'] = 'check the directory again';
$wrm_install_lang['step5sub3group01'] = 'Select the base user group that has access to use WRM';
$wrm_install_lang['step5sub3group02'] = 'Any user without this group set will not be allowed to log in';
$wrm_install_lang['step5sub3group03'] = 'Please select "No Restrictions" here if you want all users regardless of group to be able to login to WRM';
$wrm_install_lang['step5sub3altgroup01'] = 'Select an Additional user group/class that can access WRM';
$wrm_install_lang['step5sub3altgroup02'] = 'Any user tagged with this group will be allowed to log in regardless of whether they are in the above user group or not';

//bridge mode
$wrm_install_lang['db_name_text'] = 'SQL Database';
$wrm_install_lang['table_prefix_text'] = 'Table Prefix';
$wrm_install_lang['bridge_name_text'] = 'Name';
$wrm_install_lang['bridge_users_found_text'] = 'Users found';

$wrm_install_lang['bridge_step0_unknown_auth'] = '(if you are not sure, please select "iUMS")';
$wrm_install_lang['bridge_step0_choose_auth'] = 'Please choose an authorization type.';

$wrm_install_lang['found_user_from_bridge']= "found user from bridge system";
$wrm_install_lang['question_wantimport'] = 'Do you want take over, all users from your CMS/BB System?';
$wrm_install_lang['import_not_support'] = 'UserDaten Import: not supported';
$wrm_install_lang['import'] = 'Import';

// iums = integrated User Management System
$wrm_install_lang['step5iumsdesc'] = 'integrated User Management System';
$wrm_install_lang['bridge_step1_iumssub1desc'] = 'You have selected "integrated User Management System" authentication';
$wrm_install_lang['bridge_step1_iumsfilladmindesc'] = 'All that is left is to enter your Super Administrator information by filling out the information below.';

//update
$wrm_install_lang['wrm_versions_nr_current_text'] = "WRM (@Server) Version Nr";
$wrm_install_lang['wrm_versions_nr_from_install_text'] = "Install Version Nr";
$wrm_install_lang['wrm_up_to_date'] = "your WoW Raid Manager Version is up to date";
$wrm_install_lang['error_install_version_to_old_text'] = "install (WRM) Version is to old for Upgrade";

//install_bridges
$wrm_install_lang['bridge_step0_titel'] = "Scan Result (@ your Server): Found Bridges ";

//Default armory language, link
$wrm_install_lang['default_armory_language_value'] = "en";
$wrm_install_lang['default_armory_link_value'] = "http://www.wowarmory.com";
?>