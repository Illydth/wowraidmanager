<?php
//
//Svenska installations str�ngar
//
global $wrm_install_lang;
$wrm_install_lang['headtitle'] = 'Välkommen till installationen av WRM 4.x.x.';
//$wrm_install_lang['headbodyinfo'] = 'Vänligen notera att databasen du installerar till redan måste existera.';
$wrm_install_lang['select_lang'] = 'Select Language';//new

$wrm_install_lang['step0_system_requirements'] = 'System Requirements';//new
$wrm_install_lang['step0_property'] = 'property';//new
$wrm_install_lang['step0_required'] = 'required';//new
$wrm_install_lang['step0_status'] = 'Status';//new
$wrm_install_lang['step0_phpversion_text'] = 'PHP Version';//new
$wrm_install_lang['step0_mysqlversion'] = 'MySQL Version';//new
$wrm_install_lang['step0_active'] = 'active';//new
$wrm_install_lang['step0_nonactive'] = 'non active';//new
$wrm_install_lang['step0_writeable_config'] = 'config.php writeable?';//new

$wrm_install_lang['yes'] = 'yes';
$wrm_install_lang['no'] = 'no';
$wrm_install_lang['upgrade'] = 'Upgrade';//new
$wrm_install_lang['freshinstall'] = 'Ny Installation';
$wrm_install_lang['change'] = 'change';//new
$wrm_install_lang['database_text'] = 'Database';//new
$wrm_install_lang['dir_missing'] = 'Directory Missing';//new
$wrm_install_lang['writable'] = 'writable?';//new
$wrm_install_lang['directory'] = 'Directory: ';//new
$wrm_install_lang['all_dir_checks_passed'] = 'All Cache Directories Exist and are Writable?';//new

$wrm_install_lang['create_db'] = 'Create new Database?';//new
$wrm_install_lang['only_if_create_new_tab'] = 'only, if you has selected: "Create new Database?"';
$wrm_install_lang['default'] = 'default';//new
$wrm_install_lang['php_variables'] = 'PHP Variables';//new
$wrm_install_lang['error_found_table_titel'] = 'already, existing tables were found';//new
$wrm_install_lang['error_found_table_bd_back'] = 'Botton Back : change Table Prefix or Database';//new
$wrm_install_lang['error_found_table_bd_cont'] = 'Botton Continue : deletes all existing tables, before the new tables are installed';//new
$wrm_install_lang['permission_warning'] = '* If installing on a Windows OS, ignore the file permissions returned in "directory:" above. ' .
											'Windows does not recognize Unix permission (DRWX...) style permissions.  This causes the function ' .
											'that checks and returns permissions to always report fully writable permissions for Windows directories even ' .
											'if they are not writeable.  Make sure the ACL allows the user running the webserver to write to ' . 
											'this directory.';//new

$wrm_install_lang['install_bridge_titel'] = 'Bridge Preferences';//new
$wrm_install_lang['txt_group'] = 'Group';//new
$wrm_install_lang['txt_alt_group'] = 'Alternative Group';//new
$wrm_install_lang['upgrade_headtitle'] = 'Upgrade Modus';//new
$wrm_install_lang['expert_modus'] = 'Expert Modus';//new
$wrm_install_lang['hittingsubmit'] = 'V�nligen verifiera all information innan du forts�tter vidare!';

//botton
$wrm_install_lang['bd_continue'] = 'Fortsätt';
$wrm_install_lang['bd_submit'] = 'Fortsätt';
$wrm_install_lang['bd_reset'] = 'Återställ';
$wrm_install_lang['bd_back'] = 'Back';//new
$wrm_install_lang['bd_start'] = 'Start';//new
$wrm_install_lang['bd_scan_server'] = 'scan server';
$wrm_install_lang['bd_manuel_edit'] = 'manuel edit';
$wrm_install_lang['bd_iUMS'] = 'iUMS';

$wrm_install_lang['install_version_text'] = 'Version';
$wrm_install_lang['install_version_current'] = 'Installation files are up to date';
$wrm_install_lang['install_version_info_header'] = 'Version Information';
$wrm_install_lang['install_version_header'] = 'new WoW Raid Manager update available!';
$wrm_install_lang['install_version_message01'] = 'Your Installation files of WoW Raid Manager is out of date.';
$wrm_install_lang['install_version_message02'] = 'Updating is strongly recommended.';
$wrm_install_lang['install_version_message03'] = 'the latest/new version is';
$wrm_install_lang['install_version_message04'] = 'this Installation files';												   
$wrm_install_lang['install_version_message05'] = 'To download, visit the <a href="http://www.wowraidmanager.net">WoW Raid Manager download</a> section.';
$wrm_install_lang['install_connect_socked_error_header'] = 'Failed to connect';
$wrm_install_lang['install_connect_socked_error'] = 'Cannot recieve version Nr from "www.wowraidmanager.net" Server';

//step 2
$wrm_install_lang['step2_sql_server_pref'] = 'SQL Server Preferences';//new
$wrm_install_lang['step2upgradefrom'] = 'Uppgradera till';
$wrm_install_lang['step2dbname'] = 'MySQL Databas';
$wrm_install_lang['step2dbserverhostname'] = 'MySQL Värdnamn';
$wrm_install_lang['step2dbserverusername'] = 'MySQL Server Användarnamn';
$wrm_install_lang['step2dbserverpwd'] = 'MySQL Server Lösenord';
$wrm_install_lang['step2WRMtableprefix'] = 'WRM Tabell Prefix';
$wrm_install_lang['step2installtype'] = 'Installations Typ';
$wrm_install_lang['step2error01'] = 'Misslyckande att göra så, kan leda till oförutseddaproblem och hjälp kommer inte att ges!';

//step 3
$wrm_install_lang['step3errordbcon'] = 'Fel vid försök att kontakta databasen.'; 
$wrm_install_lang['step3errorschema'] = 'Fel vid öppnandet av uppgraderings schemat';
$wrm_install_lang['step3errorsql'] = 'Fel vid installation <br>Förfrågan: $sql<br>Rapporterade: ';
$wrm_install_lang['step3installinfo'] = 'Om du ser detta så skedde där inga fel under installationen av tabeller!';
$wrm_install_lang['step3errorversion'] = 'Mjukvarans version i version.php matchar inte databasens version i versions tabellen.';
$wrm_install_lang['head_title_wrm_sql_server'] = "WRM Install SQL Server";
$wrm_install_lang['step3error_no_DB_found'] = "Open a Database Management Tool (like phpMyAdmin) and create a Database for WRM";
$wrm_install_lang['step3error_bad_con_parms'] = "Error connecting to Server (Servername or Username or Password incorrect) <br/>";

//step done
$wrm_install_lang['stepdonefinished'] = 'Färdigt';
$wrm_install_lang['stepdonesetupcomplete'] = 'Installationen är nu klar.';
$wrm_install_lang['stepdoneremovedir'] = 'Se till att ta bort "install/" foldern och klicka sedan <a href="../index.php">här</a> när du har gjort det.';

//stuff
$wrm_install_lang['hittingsubmit'] = 'Vänligen verifiera all information innan du fortsätter vidare!';
$wrm_install_lang['pressbrowserpack'] ='Tryck på webbläsarens TILLBAKA knapp för att försöka igen.';
$wrm_install_lang['problem'] ='Problem';
$wrm_install_lang['txtusername'] = 'Användarnamn';
$wrm_install_lang['txt_admin_username'] = 'Administratör Användarnamn';
$wrm_install_lang['txtpassword'] = 'Lösenord';
$wrm_install_lang['txtemail'] = 'E-post';
$wrm_install_lang['txtconfig'] = 'Konfiguration';

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
$wrm_install_lang['bridge_step0_error_no_found'] = "please go back and try manuel edit or iums";
//--------------------------
// Auth.
//--------------------------
$wrm_install_lang['manuel_edit_modus_titel'] = "manuel edit - modus";

$wrm_install_lang['step5failconWRM'] = 'Uppkoppling till WRM DB misslyckades';
$wrm_install_lang['step5selctusername'] = 'Sätt fulla rättigheter till det valda Användarnamnet';
$wrm_install_lang['step5sub1follval'] = 'Vänligen fyll i följande värden för att kunna fullfölja installationen';
$wrm_install_lang['step5done'] = 'klart';
$wrm_install_lang['step5sub2usernamefullperm'] = 'Välj det användarnamn som kommer att få full rättigheter till wowRaidManager';
$wrm_install_lang['step5sub3norest'] = 'Inga Restriktioner';
$wrm_install_lang['step5sub3noaddus'] = 'Inga Ytterliggare Användargrupper';
$wrm_install_lang['step5sub2failfindfile'] = 'Misslyckades med att hitta konfigurationsfilen:';
$wrm_install_lang['step5sub2checkdir'] = 'verifiera foldern/sökvägen igen';
$wrm_install_lang['step5sub3group01'] = 'Välj grund gruppen/klassen som har tillgång attnyttja WRM';
$wrm_install_lang['step5sub3group02'] = 'Alla användare utan denna grupp kommer inte atttillåtas logga in';
$wrm_install_lang['step5sub3group03'] = 'Vänligen völj "Inga Restriktioner" här om du vill att alla användare oavsett grupp/klass skall kunna logga in och nyttja WRM';
$wrm_install_lang['step5sub3altgroup01'] = 'Välj en alternativ grupp/klass som kan nyttja WRM';
$wrm_install_lang['step5sub3altgroup02'] = 'Alla användare i denna grupp kommer att tillåtas att logga in, oavsett om de är i ovanstående grupp/klass eller inte';

//bridge mode
$wrm_install_lang['bridge_step0_look_for_a_valid_Auth'] = "look for a valid Auth. System in the Server (this way is recommended)";
$wrm_install_lang['bridge_step0_conf_the_Auth_System'] = "configure the Auth. System";
$wrm_install_lang['bridge_step0_manual_edit_text'] = "values for the auth system must be entered by yourself (this way is recommended if the scan is faulty)";

$wrm_install_lang['db_name_text'] = 'SQL Database';
$wrm_install_lang['table_prefix_text'] = 'Table Prefix';
$wrm_install_lang['bridge_name_text'] = 'Name';
$wrm_install_lang['bridge_users_found_text'] = 'Users found';

$wrm_install_lang['bridge_step0_unknown_auth'] = 'om du är osäker, vänligen välj "IAHS"';
$wrm_install_lang['bridge_step0_choose_auth'] = 'Vänligen välj ett autentisering sätt.';

$wrm_install_lang['found_user_from_bridge']= "found user from bridge system";//new
$wrm_install_lang['question_wantimport'] = 'vill du importera alla användare från Forumet';
$wrm_install_lang['import_not_support'] = 'FÖRLÅT import från Forumet: inget stöd för';
$wrm_install_lang['import'] = 'Importera';

// iums = integrated User Management System
$wrm_install_lang['step5iumsdesc'] = 'Inbyggt Användar Hanterings System';
$wrm_install_lang['bridge_step1_iumssub1desc'] = 'Du har valt "Inbyggt Användar Hanterings System" autentisering';
$wrm_install_lang['bridge_step1_iumsfilladmindesc'] = 'Allt som kvarstår är att fylla i din information för Super Administratör nedan.';

//update
$wrm_install_lang['wrm_versions_nr_current_text'] = "WRM (@Server) Version Nr";
$wrm_install_lang['wrm_versions_nr_from_install_text'] = "Install Version Nr";
$wrm_install_lang['wrm_up_to_date'] = "your WoW Raid Manager Version is up to date";
$wrm_install_lang['error_install_version_to_old_text'] = "install (WRM) Version is to old for Upgrade";

//install_bridges
$wrm_install_lang['bridge_step0_titel'] = "Scan Result (@ your Server): Found Bridges ";

//Default armory language, link
//$wrm_install_lang['default_armory_language_value'] = "en";
//$wrm_install_lang['default_armory_link_value'] = "http://eu.wowarmory.com";

?>
