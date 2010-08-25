<?php
//
//germany install strings
//
global $wrm_install_lang;
$wrm_install_lang['headtitle'] = 'Willkommen zu der WRM 4.x.x Installation.';
//$localstr['headbodyinfo'] = 'Bitte beachte das die Datenbank, auf welche du sie installieren willst, auch existiert.';
$wrm_install_lang['select_lang'] = 'Sprache waehlen';

$wrm_install_lang['step0_system_requirements'] = 'Systemvoraussetzungen';
$wrm_install_lang['step0_property'] = 'Eigenschaft';
$wrm_install_lang['step0_required'] = 'erforderlich';
$wrm_install_lang['step0_exist'] = 'vorhanden';
$wrm_install_lang['step0_phpversion_text'] = 'PHP Version';
$wrm_install_lang['step0_mysqlversion'] = 'MySQL Version';
$wrm_install_lang['step0_active'] = 'aktiviert';
$wrm_install_lang['step0_nonactive'] = 'deaktiviert';
$wrm_install_lang['step0_writeable_config'] = 'config.php schreibbar?';
$wrm_install_lang['writable_dir_cache_text'] = 'Verzeichniss: "./cache" schreibbar';

$wrm_install_lang['yes'] = 'ja';
$wrm_install_lang['no'] = 'nein';
$wrm_install_lang['upgrade'] = 'Upgrade';
$wrm_install_lang['freshinstall'] = 'Neue Installation';
$wrm_install_lang['change'] = 'aendern';
$wrm_install_lang['database_text'] = 'Datenbank';

$wrm_install_lang['create_db'] = 'erstelle neue Datenbank?';
$wrm_install_lang['only_if_create_new_tab'] = 'nur, wenn sie : "erstelle neue Datenbank?" angegeben haben';
$wrm_install_lang['default'] = 'Voreinstellung';
$wrm_install_lang['php_variables'] = 'PHP Variablen';
$wrm_install_lang['error_found_table_titel'] = 'fertig, es wurden existierende Tabellen gefunden';
$wrm_install_lang['error_found_table_bd_back'] = 'Knopf zur�ck : ver�ndere Tabellen Prefix oder Databank';
$wrm_install_lang['error_found_table_bd_cont'] = 'Knopf weiter : l�scht alle existierenden Tabellen, bevor sie neu nstalliert werden';

$wrm_install_lang['install_bridge_titel'] = 'Bridge Einstellungen';
$wrm_install_lang['txt_group'] = 'Gruppe';
$wrm_install_lang['txt_alt_group'] = 'Alternative Gruppe';
$wrm_install_lang['upgrade_headtitle'] = 'Upgrade Modus';
$wrm_install_lang['expert_modus'] = 'Experten-Modus';
$wrm_install_lang['hittingsubmit'] = 'Bitte kontrolliere deine Eingaben bevor du auf "weiter" klickst.';

//botton
$wrm_install_lang['bd_continue'] = 'weiter';
$wrm_install_lang['bd_submit'] = 'weiter';
$wrm_install_lang['bd_reset'] = 'zuruecksetzen';
$wrm_install_lang['bd_back'] = 'Back';
$wrm_install_lang['bd_start'] = 'Start';

$wrm_install_lang['install_version_text'] = 'Version';
$wrm_install_lang['install_version_current'] = 'Installations-Dateien sind auf dem Neuesten Stand';
$wrm_install_lang['install_version_info_header'] = 'Version Information';
$wrm_install_lang['install_version_header'] = 'Eine neuere Version von WoW Raid Manager ist verf�gbar!';
$wrm_install_lang['install_version_message01'] = 'Deine Installations-Dateien von WoW Raid Manager ist nicht aktuell.';
$wrm_install_lang['install_version_message02'] = 'Ein Update wird empfohlen';
$wrm_install_lang['install_version_message03'] = 'die letzte/neueste Version ist';
$wrm_install_lang['install_version_message04'] = 'diese Installationsversion';												   
$wrm_install_lang['install_version_message05'] = 'Zum Herunterladen besuche bitte den <a href="http://www.wowraidmanager.net/">offiziellen WRM - Downloadbereich</a>.';
$wrm_install_lang['install_connect_socked_error_header'] = 'Problem beim Verbindungsaufbau';
$wrm_install_lang['install_connect_socked_error'] = 'Es konnten keine Versionsdaten, vom "www.wowraidmanager.net" Server, empfangen werden';

//step 2
$wrm_install_lang['step2_sql_server_pref'] = 'SQL Server Einstellungen';
$wrm_install_lang['step2upgradefrom'] = 'Upgrade zur';
$wrm_install_lang['step2dbname'] = 'SQL Datenbank';
$wrm_install_lang['step2dbserverhostname'] = 'SQL Hostname';
$wrm_install_lang['step2dbserverusername'] = 'SQL Server Benutzername';
$wrm_install_lang['step2dbserverpwd'] = 'SQL Server Passwort';
$wrm_install_lang['step2WRMtableprefix'] = 'WRM Tabellen Prefix';
$wrm_install_lang['step2installtype'] = 'Art der Installation';
$wrm_install_lang['step2error01'] = 'Bei falschen Eingaben k�nnte es zu unvorhersehbaren Auswirkungen kommen, eine Hilfe wird nicht angeboten!';

//step 3
$wrm_install_lang['step3errordbcon'] = 'Fehler: konnte keine Verbindung zur angegeben Datenbank herstellen.<br>';
$wrm_install_lang['step3errorschema'] = 'Fehler: das Upgrade Schema konnte nicht geoffnet werden';
$wrm_install_lang['step3errorsql'] = 'Fehler bei der Installation :<br> SQL String: $sql<br> Bericht: ';
$wrm_install_lang['step3installinfo'] = 'Wenn du dies hier lesen kannst, sind keine Fehler bei der Installation der SQL-Tabellen aufgetreten!';
$wrm_install_lang['step3errorversion'] = 'Die Software-Version in version.php entsprich nicht der Version der Datenbank in der Version-Tabelle.';

//step done
$wrm_install_lang['stepdonefinished'] = 'Fertig';
$wrm_install_lang['stepdonesetupcomplete'] = 'Das Setup ist nun komplett.';
$wrm_install_lang['stepdoneremovedir'] = 'Loschen Sie bitte das "install/" Verzeichnis und klicken sie anschliessend <a href="../index.php">hier</a> drauf wenn sie fertig sind.';

//stuff
$wrm_install_lang['hittingsubmit'] = 'Bitte kontrolliere deine Eingabe bevor du auf "weiter" drueckst.';
$wrm_install_lang['pressbrowserpack'] = 'Bitte benutze, in deinem Browsers, die "zurck" Taste und gebe die Daten erneut ein.';
$wrm_install_lang['problem'] = 'Problem';
$wrm_install_lang['txtusername'] = 'Benutzername';
$wrm_install_lang['txt_admin_username'] = 'Administrator Benutzername';
$wrm_install_lang['txtpassword'] = 'Password';
$wrm_install_lang['txtemail'] = 'E-mail';
$wrm_install_lang['txtconfig'] = 'Konfiguration';

//errors
$wrm_install_lang['connect_socked_error'] = 'Fehler beim Aufbau der Socket-Verbindung:  %s';
$wrm_install_lang['invalid_group_title'] = 'Gruppe existiert';
$wrm_install_lang['invalid_group_message'] = 'Die ausgew�hlte Gruppe ist bereits ein Teil dieses Sets. Bitte benutze in deinem Browser die "Zur�ck"-Taste und versuche es erneut.';
$wrm_install_lang['invalid_option_title'] = 'Ung�ltigte Eingabe f�r die Seite';
$wrm_install_lang['invalid_option_msg'] = 'Du hast versucht, diese Seite mit ung�ltigen Eingaben aufzurufen.';
$wrm_install_lang['no_user_msg'] = 'Der Benutzer, den du dir ansehen mchtest, existiert nicht oder wurde gelscht.';
$wrm_install_lang['no_user_title'] = 'Benutzer existiert nicht';
$wrm_install_lang['print_error_critical'] = 'kritischen Fehler entdeckt!';
$wrm_install_lang['print_error_details'] = 'Details';
$wrm_install_lang['print_error_minor'] = 'kleinen Fehler entdeckt!';
$wrm_install_lang['print_error_msg_begin'] = 'Entschuldigung, WRM hat einen ';
$wrm_install_lang['print_error_msg_end'] = 'Wenn der Fehler weiter auftritt, erzeuge bitte ein Posting
									mit dieser Nachricht <br>in den <a href="http://www.wowraidmanager.net/">wowraidmanager.net-Forums</a> und
									wir werden unser Bestes geben, um ihn zu beheben. Danke!';
$wrm_install_lang['print_error_page'] = 'Seite';
$wrm_install_lang['print_error_query'] = 'Anfrage';
$wrm_install_lang['print_error_title'] = 'Oh-oh! Da ist ein Fehler passiert';

$wrm_install_lang['step2errordbcon_titel'] = "Fehler beim Herstellen einer Verbindung zum Server (Servername oder Benutzername oder Passwort falsch)";
//--------------------------
// Auth.
//--------------------------
$wrm_install_lang['expert_modus'] = "Experten-Modus";

$wrm_install_lang['step5failconWRM'] = 'Verbindung zur WRM Datenbank nicht möglich';
$wrm_install_lang['step5selctusername'] = 'dieser Benutzer bekommt vollen Zugriff auf das WRM';
$wrm_install_lang['step5sub1follval'] = 'Um die Installation abzuschließen füllen Sie bitte die folgenden Werte aus';
$wrm_install_lang['step5done'] = 'fertig';
$wrm_install_lang['step5sub2usernamefullperm'] = 'wählen bitte den Benutzer aus, der vollen Zugriff auf das WRM bekommt';
$wrm_install_lang['step5sub3norest'] = 'Keine Einschränkung';
$wrm_install_lang['step5sub3noaddus'] = 'Keine zusätzlichen Benutzergruppe';
$wrm_install_lang['step5sub2failfindfile'] = 'konnte die Konfigurationsdatei nich finden:';
$wrm_install_lang['step5sub2checkdir'] = 'überprüfe das Verzeichnis noch mal';
$wrm_install_lang['step5sub3group01'] = 'Wählen die Benutzergruppe aus, welche Zugang zur Nutzung von WRM hat';
$wrm_install_lang['step5sub3group02'] = 'Benutzter die nicht in dieser Benutzergruppe sind, ist es nicht möglich, sich anzumelden';
$wrm_install_lang['step5sub3group03'] = 'Wenn du willst, dass alle Benutzer unabhängig von der Benutzergruppe sich im WRM anmelden können, wähle "Keine Einschränkung" aus.';
$wrm_install_lang['step5sub3altgroup01'] = 'Wählen eine alternative Benutzergruppe aus, welcher den Zugang zu WRM auch erlaubt ist';
$wrm_install_lang['step5sub3altgroup02'] = 'mit dieser alternativen Gruppe ist es dem Benutzer möglich, sich unabhngig davon anzumelden, ob sie in der oben genannten Benutzergruppe sind oder nicht ';

//bridge mode
$wrm_install_lang['db_name_text'] = 'SQL Datenbank';
$wrm_install_lang['table_prefix_text'] = 'Tabellen Prefix';
$wrm_install_lang['bridge_name_text'] = 'Name';
$wrm_install_lang['bridge_users_found_text'] = 'gefundene Benutzer';

$wrm_install_lang['bridge_step0_unknown_auth'] = '(wenn sie sich nicht sicher sind, wähle bitte "iUMS")';
$wrm_install_lang['bridge_step0_choose_auth'] = 'Bitte wähle dein Berechtigungssystem aus.';

$wrm_install_lang['found_user_from_bridge']= "gefundene Benutzer von dem Berechtigungssystem";
$wrm_install_lang['question_wantimport'] = 'möchten sie alle Benutzter aus dem Forum/Board importieren';
$wrm_install_lang['import_not_support'] = 'Endschuldigung: der Import, der Benutzer aus dem Forum/Board: wird nicht unterstützt';
$wrm_install_lang['import'] = 'Import';

// iums = integrated User Management System
$wrm_install_lang['step5iumsdesc'] = 'integrierte Benutzer Management-System';
$wrm_install_lang['bridge_step1_iumssub1desc'] = 'Du hast "integrierte Benutzer Management-System"-Authentifizierung ausgewählt';
$wrm_install_lang['bridge_step1_iumsfilladmindesc'] = 'füllen sie alle Werte für denn Benutzter des Super Administrator aus.';

//update
$wrm_install_lang['wrm_versions_nr_current_text'] = "WRM (@Server) Version Nr";
$wrm_install_lang['wrm_versions_nr_from_install_text'] = "Installation Version Nr";
$wrm_install_lang['wrm_up_to_date'] = "Deine WoW Raid Manager Version ist auf dem aktuellsten Stand";
$wrm_install_lang['error_install_version_to_old_text'] = "Installation (WRM) Version ist ui alt f�r ein Upgrade";

//install_bridges
$wrm_install_lang['bridge_step0_titel'] = "Scan-Ergebnis (@ dein Server): Gefundene Bridges ";

//Default armory language, link
$wrm_install_lang['default_armory_language_value'] = "de";
$wrm_install_lang['default_armory_link_value'] = "http://eu.wowarmory.com";
?>