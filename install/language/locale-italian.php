<?php
//
//italian install strings
//
global $wrm_install_lang;
$wrm_install_lang['headtitle'] = 'Installazione di WRM 4.x.x.';
//$wrm_install_lang['headbodyinfo'] = 'Attenzione: il database sul quale verrà effettuata l\'installazione dev\'essere già esistente.';
$wrm_install_lang['select_lang'] = 'Select Language';//new

$wrm_install_lang['step0_system_requirements'] = 'System Requirements';//new
$wrm_install_lang['step0_property'] = 'property';//new
$wrm_install_lang['step0_required'] = 'required';//new
$wrm_install_lang['step0_exist'] = 'exist';//new
$wrm_install_lang['step0_phpversion_text'] = 'PHP Version';//new
$wrm_install_lang['step0_mysqlversion'] = 'MySQL Version';//new
$wrm_install_lang['step0_active'] = 'active';//new
$wrm_install_lang['step0_nonactive'] = 'non active';//new
$wrm_install_lang['step0_writeable_config'] = 'config.php writeable?';//new
$wrm_install_lang['writable_dir_cache_text'] = 'directory: "./cache" writable';//new

$wrm_install_lang['yes'] = 'yes';
$wrm_install_lang['no'] = 'no';
$wrm_install_lang['upgrade'] = 'Upgrade';//new
$wrm_install_lang['freshinstall'] = 'Nuova installazione';
$wrm_install_lang['change'] = 'change';//new
$wrm_install_lang['database_text'] = 'Database';//new

$wrm_install_lang['create_db'] = 'Create new Database?';//new
$wrm_install_lang['only_if_create_new_tab'] = 'only, if you has selected: "Create new Database?"';
$wrm_install_lang['default'] = 'default';//new
$wrm_install_lang['php_variables'] = 'PHP Variables';//new
$wrm_install_lang['error_found_table_titel'] = 'already, existing tables were found';//new
$wrm_install_lang['error_found_table_bd_back'] = 'Botton Back : change Table Prefix or Database';//new
$wrm_install_lang['error_found_table_bd_cont'] = "Botton Continue : deletes all existing tables, before the new tables are installed";//new

$wrm_install_lang['install_bridge_titel'] = 'Bridge Preferences';//new
$wrm_install_lang['txt_group'] = 'Group';//new
$wrm_install_lang['txt_alt_group'] = 'Alternative Group';//new
$wrm_install_lang['upgrade_headtitle'] = 'Upgrade Modus';//new
$wrm_install_lang['expert_modus'] = 'Expert Modus';//new
$wrm_install_lang['hittingsubmit'] = 'Verifica la correttezza di tutte le informazioni inserite prima di proseguire!';

//botton
$wrm_install_lang['bd_continue'] = 'Continua';
$wrm_install_lang['bd_submit'] = 'Continua';
$wrm_install_lang['bd_reset'] = 'Reset';
$wrm_install_lang['bd_back'] = 'Back';//new
$wrm_install_lang['bd_start'] = 'Start';//new

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
$wrm_install_lang['step2_sql_server_pref'] = 'SQL Server Preferences';//new
$wrm_install_lang['step2upgradefrom'] = 'Aggiornamento di';
$wrm_install_lang['step2dbname'] = 'Database MySQL';
$wrm_install_lang['step2dbserverhostname'] = 'Indirizzo del server MySQL';
$wrm_install_lang['step2dbserverusername'] = 'Username del server MySQL';
$wrm_install_lang['step2dbserverpwd'] = 'Password del server MySQL';
$wrm_install_lang['step2WRMtableprefix'] = 'Prefisso delle tabelle di WRM';
$wrm_install_lang['step2installtype'] = 'Tipo di installazione';
$wrm_install_lang['step2error01'] = 'Informazioni errate potrebbero causare errori non prevedibili per i quali non verrà fornita assistenza!';

//step 3
$wrm_install_lang['step3errordbcon'] = 'Errore di connessione al database.'; 
$wrm_install_lang['step3errorschema'] = 'Errore durante l\'aggiornamento';
$wrm_install_lang['step3errorsql'] = 'Errore d\'installazione<br>Query: $sql<br>Riportato: ';
$wrm_install_lang['step3installinfo'] = 'Tabelle create correttamente!';
$wrm_install_lang['step3errorversion'] = 'La versione del software in version.php non combacia con la versione del database nella tabella delle versioni.';

//step done
$wrm_install_lang['stepdonefinished'] = 'Finito';
$wrm_install_lang['stepdonesetupcomplete'] = 'Installazione completata.';
$wrm_install_lang['stepdoneremovedir'] = 'Rimuovi la cartella "install/" e clicka <a href="../index.php">qui</a> dopo averlo fatto.';

//stuff
$wrm_install_lang['hittingsubmit'] = 'Verifica la correttezza di tutte le informazioni inserite prima di proseguire!';
$wrm_install_lang['pressbrowserpack'] = 'Utilizza il pulsante INDIETRO del browser per riprovare.';
$wrm_install_lang['problem'] ='Problema';
$wrm_install_lang['txtusername'] = 'Username';
$wrm_install_lang['txt_admin_username'] = 'Administrator Username';//new
$wrm_install_lang['txtpassword'] = 'Password';
$wrm_install_lang['txtemail'] = 'E-mail';
$wrm_install_lang['txtconfig'] = 'Configurazione';

// errors
$wrm_install_lang['connect_socked_error'] = 'Errore di connessione: %s';
$wrm_install_lang['invalid_group_title'] = 'Team gi presente';
$wrm_install_lang['invalid_group_message'] = 'Il Team selezionato  gi stato inserito. Torna indietro e riprova.';
$wrm_install_lang['invalid_option_title'] = 'Dati non validi';
$wrm_install_lang['invalid_option_msg'] = 'Sono stati forniti dati non validi per questa pagina.';
$wrm_install_lang['no_user_msg'] = 'L\'Utente richiesto non esiste o  stato cancellato.';
$wrm_install_lang['no_user_title'] = 'Utente non valido';
$wrm_install_lang['print_error_critical'] = 'un errore critico!';
$wrm_install_lang['print_error_details'] = 'Dettagli';
$wrm_install_lang['print_error_minor'] = 'un errore!';
$wrm_install_lang['print_error_msg_begin'] = 'Spiacente, WowRaidManager ha riscontrato ';
$wrm_install_lang['print_error_msg_end'] = 'Se l\'errore persiste, segnalalo ad un Amministratore, grazie!';


$wrm_install_lang['print_error_page'] = 'Pagina';
$wrm_install_lang['print_error_query'] = 'Richiesta';
$wrm_install_lang['print_error_title'] = 'Oh oh! Errore!';

$wrm_install_lang['step2errordbcon_titel'] = "Error connecting to Server (Servername or Username or Password incorrect)";
//--------------------------
// Auth.
//--------------------------
$wrm_install_lang['expert_modus'] = "Expert Modus";

$wrm_install_lang['step5failconWRM'] = 'Impossibile connettersi al database di WRM';
$wrm_install_lang['step5selctusername'] = 'Assegna pieni permessi allo username selezionato';
$wrm_install_lang['step5sub1follval'] = 'Per completare l\'installazione, compila i seguenti campi';
$wrm_install_lang['step5done'] = 'fatto';
$wrm_install_lang['step5sub2usernamefullperm'] = 'Seleziona a quale username verranno garantiti pieni permessi in WowRaidManager';
$wrm_install_lang['step5sub3norest'] = 'Nessuna restrizione';
$wrm_install_lang['step5sub3noaddus'] = 'Nessun altro gruppo';
$wrm_install_lang['step5sub2failfindfile'] = 'File di configurazione non trovato:';
$wrm_install_lang['step5sub2checkdir'] = 'controlla nuovamente la cartella';
$wrm_install_lang['step5sub3group01'] = 'Seleziona il gruppo base di Utenti ai quali consentire l\'accesso a WRM';
$wrm_install_lang['step5sub3group02'] = 'Gli Utenti al di fuori di questo gruppo non avranno accesso a WRM';
$wrm_install_lang['step5sub3group03'] = 'Seleziona "Nessuna restrizione" per consentire l\'accesso a WRM a tutti gli Utenti indipendentemente dai gruppi di appartenenza';
$wrm_install_lang['step5sub3altgroup01'] = 'Seleziona un ulteriore gruppo di Utenti ai quali consentire l\'accesso a WRM';
$wrm_install_lang['step5sub3altgroup02'] = 'Agli Utenti appartenenti a questo gruppo sarà consentito l\'accesso a WRM indipendentemente dall\'appartenenza anche all\'altro gruppo specificato';

//bridge mode
$wrm_install_lang['db_name_text'] = 'SQL Database';
$wrm_install_lang['table_prefix_text'] = 'Table Prefix';
$wrm_install_lang['bridge_name_text'] = 'Name';
$wrm_install_lang['bridge_users_found_text'] = 'Users found';

$wrm_install_lang['bridge_step0_unknown_auth'] = '(in caso di incertezza, selezionare il sistema di gestione Utenti integrato)';
$wrm_install_lang['bridge_step0_choose_auth'] = 'Seleziona uno dei tipi di autenticazione.';

$wrm_install_lang['found_user_from_bridge']= "found user from bridge system";//new
$wrm_install_lang['question_wantimport'] = 'Vuoi importare tutti gli Utenti di?';
$wrm_install_lang['import_not_support'] = 'Importazione da non supportata';
$wrm_install_lang['import'] = 'Importa';

// iums = integrated User Management System
$wrm_install_lang['step5iumsdesc'] = 'Sistema di gestione Utenti integrato';
$wrm_install_lang['bridge_step1_iumssub1desc'] = 'Hai selezionato l\'autenticazione attraverso il sistema di gestione Utenti integrato';
$wrm_install_lang['bridge_step1_iumsfilladmindesc'] = 'Inserisci i dati per il profilo di Super Admin.';

//update
$wrm_install_lang['wrm_versions_nr_current_text'] = "WRM (@Server) Version Nr";
$wrm_install_lang['wrm_versions_nr_from_install_text'] = "Install Version Nr";
$wrm_install_lang['wrm_up_to_date'] = "your WoW Raid Manager Version is up to date";
$wrm_install_lang['error_install_version_to_old_text'] = "install (WRM) Version is to old for Upgrade";

//install_bridges
$wrm_install_lang['bridge_step0_titel'] = "Scan Result (@ your Server): Found Bridges ";

//Default armory language, link
$wrm_install_lang['default_armory_language_value'] = "en";
$wrm_install_lang['default_armory_link_value'] = "http://eu.wowarmory.com";
?>