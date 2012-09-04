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

// admin section language file
require_once('lang_admin.php');

if (empty($phprlang) || !is_array($phprlang))
	$phprlang = array();
	
$phprlang = array_merge($phprlang, array(

// data output headers
'add_team' => 'Seleziona per aggiungere al Team',
'add_team_dropdown_text' => 'Seleziona il Team a cui aggiungere i membri',
'team_global' => 'Team riutilizzabile in altri Raid',
'male' =>  'Maschio',
'female' =>  'Femmina',
'class' =>  'Classe',
'date' =>  'Data',
'description' =>  'Descrizione',
'email' =>  'E-mail',
'guild' =>  'Gilda',
'guild_name' =>  'Nome della Gilda',
'guild_master' =>  'GuildMaster',
'guild_tag' =>  'Abbreviazione della Gilda',
'guild_description' =>  'Guild Description',
'guild_server' =>  'Guild Server',
'guild_faction' =>  'Guild Faction',
'guild_armory_link' =>  'Armory Link',
'guild_armory_code' =>  'Armory Code',
'guild_id' =>  'Guild ID',
'raid_force_id' =>  'Raid Force ID',
'raid_force_name' =>  'Raid Force',
'id' =>  'ID',
'invite_time' =>  'Ora di invito',
'level' =>  'Livello',
'location' =>  'Istanza',
'max_lvl' =>  'Livello massimo',
'max_raiders' =>  'Numero massimo di PG',
'locked_header' =>  'Non modificabile?',
'message' =>  'Testo',
'min_lvl' =>  'Livello minimo',
'name' =>  'Nome',
'officer' =>  'Inserito da',
'no_data' =>  'Vuoto',
'posted_by' =>  'Inserito da',
'race' =>  'Razza',
'start_time' =>  'Ora di inizio',
'team_name' =>  'Nome del Team',
'time' =>  'Ora',
'title' =>  'Titolo',
'totals' =>  'Totali',
'username' =>  'Username',
'records' =>  'Elementi',
'to' =>  '-',
'of' =>  'di',
'total' =>  'totali',
'section' =>  'Sezione',
'prev' =>  'Prec.',
'next' =>  'Succ.',
'earned' =>  'Guadagnati',
'spent' =>  'Spesi',
'adjustment' =>  'Variazione',
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

// Recurrance Text Items
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

// roles
'role_none' =>  '-',
'role' =>  'Role', //New

// errors
'connect_socked_error' =>  'Errore di connessione: %s',
'invalid_group_title' =>  'Team già presente',
'invalid_group_message' =>  'Il Team selezionato è già stato inserito. Torna indietro e riprova.',
'invalid_option_title' =>  'Dati non validi',
'invalid_option_msg' =>  'Sono stati forniti dati non validi per questa pagina.',
'no_user_msg' =>  'L\'Utente richiesto non esiste o è stato cancellato.',
'no_user_title' =>  'Utente non valido',
'print_error_critical' =>  'un errore critico!',
'print_error_details' =>  'Dettagli',
'print_error_minor' =>  'un errore!',
'print_error_msg_begin' =>  'Spiacente, WowRaidManager ha riscontrato ',
'print_error_msg_end' =>  'Se l\'errore persiste, segnalalo ad un Amministratore, grazie!',
'print_error_page' =>  'Pagina',
'print_error_query' =>  'Richiesta',
'print_error_title' =>  'Oh oh! Errore!',
'socket_functions_disabled' =>  'Impossibile verificare la presenza di aggiornamenti.',

// forms
'asc' =>  'crescente',
'auth_phpbb_no_groups' =>  'Non ci sono gruppi da poter aggiungere',
'desc' =>  'decrescente',
'form_error' =>  'Errore di invio del modulo',
'form_select' =>  'Seleziona una voce',
'no' =>  'No',
'none' =>  'Nessuno',
'guild_name_missing' =>  'Nome della Gilda non specificato.',
'guild_tag_missing' =>  'Abbreviazione della Gilda non specificata.',
'permissions_form_description' =>  'E\' necessario specificare una descrizione',
'permissions_form_name' =>  'E\' necessario specificare un nome',
'profile_error_arcane' =>  'Il valore di resistenza Arcane deve essere numerico',
'profile_error_class' =>  'E\' necessario selezionare una classe',
'profile_error_dupe' =>  'Esiste già un Personaggio col come specificato',
'profile_error_fire' =>  'Il valore di resistenza Fire deve essere numerico',
'profile_error_frost' =>  'Il valore di resistenza Frost deve essere numerico',
'profile_error_guild' =>  'E\' necessario selezionare una Gilda',
'profile_error_level' =>  'Il livello deve essere un numero compreso fra 1 ed 80',
'profile_error_name' =>  'E\' necessario specificare un nome',
'profile_error_nature' =>  'Il valore di resistenza Nature deve essere numerico',
'profile_error_race' =>  'E\' necessario selezionare una razza',
'profile_error_role' =>  'E\' necessario selezionare un ruolo',
'profile_error_shadow' =>  'Il valore di resistenza Shadow deve essere numerico',
'raid_error_date' =>  'E\' necessario selezionare una data',
'raid_error_description' =>  'E\' necessario specificare una descrizione',
'raid_error_limits' =>  'Tutti i limiti del Raid devono essere specificati ed in formato numerico',
'raid_error_location' =>  'E\' necessario selezionare un\'Istanza',
'view_error_signed_up' =>  'Sei già iscritto con questo Personaggio',
'view_error_role_undef' =>  'Verifica che il Personaggio abbia associato un ruolo nella sezione <a href="profile.php?mode=view">Personaggi</a>.',
'yes' =>  'Sì',
'teams_error_no_team' =>  'No team is selected to add users to.',

// Buttons
'submit' =>  'Invia',
'reset' =>  'Reset',
'confirm' =>  'Conferma',
'update' =>  'Aggiorna',
'confirm_deletion' =>  'Conferma eliminazione',
'filter' =>  'Filtra',
'addchar' =>  'Aggiungi Personaggio',
'updatechar' =>  'Aggiorna Personaggio',
'login' =>  'Accedi',
'logout' =>  'Disconnettiti',
'signup' =>  'Iscriviti',
'apply' =>  'Apply Options',

// generic information
'delete_msg' =>  'ATTENZIONE: l\'eliminazione è permanente e non reversibile.<br>Clicka il pulsante sottostante se sei sicuro di voler procedere.',
'maintenance_header' =>  'Lavori in corso',
'maintenance_message' =>  'WowRaidManager è momentaneamente non disponibile per lavori in corso. Riprova più tardi.',
'disabled_header' =>  'Avviso disabilitazione sito!',
'disabled_message' =>  'Attenzione, il sito è attualmente disabilitato: gli utenti non possono accedere al sistema!<br>Vai in <u>Configurazione</u> e deseleziona l\'opzione <u>Disabilita WowRaidManager</u>',
'userclass_msg' =>  'Il tuo utente non è autorizzato ad utilizzare WowRaidManager: contatta un Amministratore per risolvere il problema.',
'priv_title' =>  'Permessi insufficienti',
'priv_msg' =>  'Non hai permessi sufficienti per visualizzare questa pagina. Accedi a WowRaidManager con i tuoi username e password se non l\'hai ancora fatto, oppure contatta un Amministratore se il problema persiste.',
'remember' =>  'Ricorda il mio Utente su questo PC',
'welcome' =>  'Benvenuto/a ',

// Login Information
'login_fail_title' =>  'Accesso fallito',
'login_fail' =>  'Username e/o password inesistenti o non validi. Riprova nuovamente.',
'login_forgot_password' =>  'Password dimenticata?',
'login_pwdreset_fail_title' =>  'Invio/reset della password fallito',
'login_pwdreset_title' =>  'Resetta password',
'login_password_reset_msg' =>  'Per resettare la password compila il seguente modulo',
'login_username_email_incorrect' =>  'Lo username o l\'indirizzo e-mail specificati non sono validi.<br><br>Torna indietro e riprova.',
'login_password_sent' =>  'La tua password di accesso a WRM è stata resettata, e la nuova password è stata inviata a:<br><br>',
'login_password_sent2' =>  '<br><br>Una mail è stata inviata all\'indirizzo e-mail sopra riportato. ' .
									'Se non l\'hai ricevuta, controlla o disattiva eventuali filtri anti-spam ' .
									'e riutilizza la funzione "Password dimenticata".',
'login_password_email_msg' =>  'QUESTO MESSAGGIO NON E\' SPAM!<br><br>Qualcuno (presumibilmente tu) ha utilizzato ' .
										'la funzione "Password dimenticata" in un\'installazione di WRM per un account ' .
										'associato al tuo indirizzo e-mail. La password di accesso a WRM è stata resettata. ' .
										'La nuova password è:<br><br>',
'login_password_email_msg2' =>  '<br><br>Accedi a WRM utilizzando la password sopra riportata, e clicka il link ' .
										 '"Modifica password" sotto il pulsante di disconnessione se desideri modificarla. ' .
										 '<br><br>Se NON sei stato tu a richiedere il reset della password contatta gli ' .
										 'amministratori di WRM per informarli dell\'abuso.<br><br>' .
										 'Dovrai in ogni caso utilizzare la nuova password sopra riportata per accedere a WRM.',
'login_password_email_sub' =>  'Notifica di reset della password di WRM',									 
'login_chpass_text' =>  'Modifica la password dell\'utente: ',
'login_chpwd' =>  'Modifica password',
'login_curr_password' =>  'Password corrente',
'login_password_conf' =>  'Conferma password',
'login_password_incorrect' =>  'Password corrente non valida, oppure la nuova password e la password di conferma ' .
										'non combaciano.<br><br>Torna indietro e riprova.',
'login_password_new' =>  'Nuova password',
'login_pwdreset_success' =>  'La tua password è stata resettata.<br><br>Dovrai utilizzare la nuova password al prossimo accesso a WRM.',

// Days of the Week
'sunday' =>  'Domenica',
'monday' =>  'Lunedì',
'tuesday' =>  'Martedì',
'wednesday' =>  'Mercoledì',
'thursday' =>  'Giovedì',
'friday' =>  'Venerdì',
'saturday' =>  'Sabato',
'2ltrsunday' =>  'Do',
'2ltrmonday' =>  'Lu',
'2ltrtuesday' =>  'Ma',
'2ltrwednesday' =>  'Me',
'2ltrthursday' =>  'Gi',
'2ltrfriday' =>  'Ve',
'2ltrsaturday' =>  'Sa',

// Months
'month' =>  'Mese',
'year' =>  'Anno',
'month1' =>  'Gennaio',
'month2' =>  'Febbraio',
'month3' =>  'Marzo',
'month4' =>  'Aprile',
'month5' =>  'Maggio',
'month6' =>  'Giugno',
'month7' =>  'Luglio',
'month8' =>  'Agosto',
'month9' =>  'Settembre',
'month10' =>  'Ottobre',
'month11' =>  'Novembre',
'month12' =>  'Dicembre',
							
// links
'announcements_link' =>  '&raquo;&nbsp;Annunci',
'configuration_link' =>  '&raquo;&nbsp;Configurazione',
'guilds_link' =>  '&raquo;&nbsp;Gilde',
'home_link' =>  '&raquo;&nbsp;Indice',
'calendar_link' =>  '&raquo;&nbsp;Calendario&nbsp;eventi',
'locations_link' =>  '&raquo;&nbsp;Istanze',
'permissions_link' =>  '&raquo;&nbsp;Profili&nbsp;Utente',
'profile_link' =>  '&raquo;&nbsp;Personaggi',
'raids_link' =>  '&raquo;&nbsp;Raid',
'register_link' =>  '&raquo;&nbsp;Registrati',
'roster_link' =>  '&raquo;&nbsp;Roster',
'users_link' =>  '&raquo;&nbsp;Utenti',
'lua_output_link' =>  '&raquo;&nbsp;Export&nbsp;LUA',
'index_link' =>  '&raquo;&nbsp;Forum',
'dkp_link' =>  '&raquo;&nbsp;DKP',
'bosstrack_link' =>  '&raquo; Boss Kill Tracking',
'raidsarchive_link' =>  '&raquo; Raids Archive',

// sorting information
'sort_text' =>  'Clicka qui per ordinare per ',
'sort_desc' => 'Clicka qui per ordinare (in ordine discendente) per ',
'sort_asc' => 'Clicka qui per ordinare (in ordine ascendente) per ', 

// tooltips
'add' =>  'Aggiungi',
'announcements' =>  'Annunci',
'calendar' =>  'Calendario',
'cancel' =>  'Annulla iscrizione',
'cancel_msg' =>  'La tua iscrizione a questo Raid è stata annullata',
'comments' =>  'Commenti',
'configuration' =>  'Configurazione',
'delete' =>  'Elimina',
'description' =>  'Descrizione',
'edit' =>  'Modifica',
'edit_comment' =>  'Modifica commento',
'frozen_msg' =>  'Le iscrizioni a questo Raid sono chiuse.',
'group_name' =>  'Nome del Team',
'group_description' =>  'Descrizione del Team',
'guilds' =>  'Gilde',
'has_permission' =>  'Ha il permesso',
'in_queue' =>  'Inserisce il Personaggio fra le iscrizioni in coda',
'last_login_date' =>  'Data di ultimo accesso',
'last_login_time' =>  'Ora di ultimo accesso',
'locations' =>  'Istanze',
'logs' =>  'Log',
'lua' =>  'Export LUA',
'mark' =>  'Imposta il Raid come passato',
'new' =>  'Imposta il Raid come in programma',
'not_signed_up' =>  'Clicka qui per iscriverti al Raid',
'out_queue' =>  'Inserisce il Personaggio fra le iscrizioni confermate',
'permissions' =>  'Profili Utente',
'priv' =>  'Profilo Utente',
'profile' =>  'Utente',
'raids' =>  'Raid',
'remove_group' =>  'Rimuovi il gruppo dal Profilo Utente',
'remove_user' =>  'Rimuovi l\'Utente dal Profilo Utente',
'signed_up' =>  'Sei iscritto a questo Raid',
'signup_add' =>  'Aggiungi l\'Utente alle iscrizioni',
'signup_delete' =>  'Elimina l\'Utente dalle iscrizioni',
'users' =>  'Utenti',

));  
?>