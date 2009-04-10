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

// data output headers
$phprlang['add_team']='Seleziona per aggiungere al Team';
$phprlang['add_team_dropdown_text']='Seleziona il Team a cui aggiungere i membri';
$phprlang['team_global']='Team riutilizzabile in altri Raid';
$phprlang['male'] = 'Maschio';
$phprlang['female'] = 'Femmina';
$phprlang['class'] = 'Classe';
$phprlang['date'] = 'Data';
$phprlang['description'] = 'Descrizione';
$phprlang['email'] = 'E-mail';
$phprlang['guild'] = 'Gilda';
$phprlang['guild_name'] = 'Nome della Gilda';
$phprlang['guild_master'] = 'GuildMaster';
$phprlang['guild_tag'] = 'Abbreviazione della Gilda';
$phprlang['id'] = 'ID';
$phprlang['invite_time'] = 'Ora di invito';
$phprlang['level'] = 'Livello';
$phprlang['location'] = 'Istanza';
$phprlang['max_lvl'] = 'Livello massimo';
$phprlang['max_raiders'] = 'Numero massimo di PG';
$phprlang['locked_header'] = 'Non modificabile?';
$phprlang['message'] = 'Testo';
$phprlang['min_lvl'] = 'Livello minimo';
$phprlang['name'] = 'Nome';
$phprlang['officer'] = 'Inserito da';
$phprlang['no_data'] = 'Vuoto';
$phprlang['posted_by'] = 'Inserito da';
$phprlang['race'] = 'Razza';
$phprlang['start_time'] = 'Ora di inizio';
$phprlang['team_name'] = 'Nome del Team';
$phprlang['time'] = 'Ora';
$phprlang['title'] = 'Titolo';
$phprlang['totals'] = 'Totali';
$phprlang['username'] = 'Username';
$phprlang['records'] = 'Elementi';
$phprlang['to'] = '-';
$phprlang['of'] = 'di';
$phprlang['total'] = 'totali';
$phprlang['section'] = 'Sezione';
$phprlang['prev'] = 'Prec.';
$phprlang['next'] = 'Succ.';
$phprlang['earned'] = 'Guadagnati';
$phprlang['spent'] = 'Spesi';
$phprlang['adjustment'] = 'Variazione';
$phprlang['dkp'] = 'DKP';
$phprlang['buttons'] = 'Buttons';
$phprlang['add_to_team'] = 'Add To Team';
$phprlang['create_date'] = 'Create Date';
$phprlang['create_time'] = 'Create Time';
$phprlang['pri_spec'] = 'Pri Talent';
$phprlang['sec_spec'] = 'Sec Talent';
$phprlang['signup_spec'] = 'Draft As';

// roles
$phprlang['role'] = 'Ruolo';
$phprlang['role_none'] = '-';
$phprlang['role_tank'] = 'Tank';
$phprlang['role_heal'] = 'Curatore';
$phprlang['role_melee'] = 'DPS Melee';
$phprlang['role_ranged'] = 'DPS Ranged';
$phprlang['role_tankmelee'] = 'Tank/DPS Melee';

$phprlang['role_tanks'] = 'Tank';
$phprlang['role_heals'] = 'Curatori';
$phprlang['role_melees'] = 'DPS Melee';
$phprlang['role_ranges'] = 'DPS Ranged';
$phprlang['role_tankmelees'] = 'Tank/DPS Melee';

$phprlang['max_tanks'] = 'Max Tank';
$phprlang['max_heals'] = 'Max Curatori';
$phprlang['max_melees'] = 'Max DPS Melee';
$phprlang['max_ranged'] = 'Max DPS Ranged';
$phprlang['max_tkmels'] = 'Max Tank/DPS Melee';

// errors
$phprlang['connect_socked_error'] = 'Errore di connessione: %s';
$phprlang['invalid_group_title'] = 'Team già presente';
$phprlang['invalid_group_message'] = 'Il Team selezionato è già stato inserito. Torna indietro e riprova.';
$phprlang['invalid_option_title'] = 'Dati non validi';
$phprlang['invalid_option_msg'] = 'Sono stati forniti dati non validi per questa pagina.';
$phprlang['no_user_msg'] = 'L\'Utente richiesto non esiste o è stato cancellato.';
$phprlang['no_user_title'] = 'Utente non valido';
$phprlang['print_error_critical'] = 'un errore critico!';
$phprlang['print_error_details'] = 'Dettagli';
$phprlang['print_error_minor'] = 'un errore!';
$phprlang['print_error_msg_begin'] = 'Spiacente, WowRaidManager ha riscontrato ';
$phprlang['print_error_msg_end'] = 'Se l\'errore persiste, segnalalo ad un Amministratore, grazie!';
$phprlang['print_error_page'] = 'Pagina';
$phprlang['print_error_query'] = 'Richiesta';
$phprlang['print_error_title'] = 'Oh oh! Errore!';
$phprlang['socket_functions_disabled'] = 'Impossibile verificare la presenza di aggiornamenti.';

// forms
$phprlang['asc'] = 'crescente';
$phprlang['auth_phpbb_no_groups'] = 'Non ci sono gruppi da poter aggiungere';
$phprlang['desc'] = 'decrescente';
$phprlang['form_error'] = 'Errore di invio del modulo';
$phprlang['form_select'] = 'Seleziona una voce';
$phprlang['no'] = 'No';
$phprlang['none'] = 'Nessuno';
$phprlang['guild_name_missing'] = 'Nome della Gilda non specificato.';
$phprlang['guild_tag_missing'] = 'Abbreviazione della Gilda non specificata.';
$phprlang['permissions_form_description'] = 'E\' necessario specificare una descrizione';
$phprlang['permissions_form_name'] = 'E\' necessario specificare un nome';
$phprlang['profile_error_arcane'] = 'Il valore di resistenza Arcane deve essere numerico';
$phprlang['profile_error_class'] = 'E\' necessario selezionare una classe';
$phprlang['profile_error_dupe'] = 'Esiste già un Personaggio col come specificato';
$phprlang['profile_error_fire'] = 'Il valore di resistenza Fire deve essere numerico';
$phprlang['profile_error_frost'] = 'Il valore di resistenza Frost deve essere numerico';
$phprlang['profile_error_guild'] = 'E\' necessario selezionare una Gilda';
$phprlang['profile_error_level'] = 'Il livello deve essere un numero compreso fra 1 ed 80';
$phprlang['profile_error_name'] = 'E\' necessario specificare un nome';
$phprlang['profile_error_nature'] = 'Il valore di resistenza Nature deve essere numerico';
$phprlang['profile_error_race'] = 'E\' necessario selezionare una razza';
$phprlang['profile_error_role'] = 'E\' necessario selezionare un ruolo';
$phprlang['profile_error_shadow'] = 'Il valore di resistenza Shadow deve essere numerico';
$phprlang['raid_error_date'] = 'E\' necessario selezionare una data';
$phprlang['raid_error_description'] = 'E\' necessario specificare una descrizione';
$phprlang['raid_error_limits'] = 'Tutti i limiti del Raid devono essere specificati ed in formato numerico';
$phprlang['raid_error_location'] = 'E\' necessario selezionare un\'Istanza';
$phprlang['view_error_signed_up'] = 'Sei già iscritto con questo Personaggio';
$phprlang['view_error_role_undef'] = 'Verifica che il Personaggio abbia associato un ruolo nella sezione <a href="profile.php?mode=view">Personaggi</a>.';
$phprlang['yes'] = 'Sì';

// Buttons
$phprlang['submit'] = 'Invia';
$phprlang['reset'] = 'Reset';
$phprlang['confirm'] = 'Conferma';
$phprlang['update'] = 'Aggiorna';
$phprlang['confirm_deletion'] = 'Conferma eliminazione';
$phprlang['filter'] = 'Filtra';
$phprlang['addchar'] = 'Aggiungi Personaggio';
$phprlang['updatechar'] = 'Aggiorna Personaggio';
$phprlang['login'] = 'Accedi';
$phprlang['logout'] = 'Disconnettiti';
$phprlang['signup'] = 'Iscriviti';

// generic information
$phprlang['delete_msg'] = 'ATTENZIONE: l\'eliminazione è permanente e non reversibile.<br>Clicka il pulsante sottostante se sei sicuro di voler procedere.';
$phprlang['maintenance_header'] = 'Lavori in corso';
$phprlang['maintenance_message'] = 'WowRaidManager è momentaneamente non disponibile per lavori in corso. Riprova più tardi.';
$phprlang['disabled_header'] = 'Avviso disabilitazione sito!';
$phprlang['disabled_message'] = 'Attenzione, il sito è attualmente disabilitato: gli utenti non possono accedere al sistema!<br>Vai in <u>Configurazione</u> e deseleziona l\'opzione <u>Disabilita WowRaidManager</u>';
$phprlang['userclass_msg'] = 'Il tuo utente non è autorizzato ad utilizzare WowRaidManager: contatta un Amministratore per risolvere il problema.';
$phprlang['priv_title'] = 'Permessi insufficienti';
$phprlang['priv_msg'] = 'Non hai permessi sufficienti per visualizzare questa pagina. Accedi a WowRaidManager con i tuoi username e password se non l\'hai ancora fatto, oppure contatta un Amministratore se il problema persiste.';
$phprlang['remember'] = 'Ricorda il mio Utente su questo PC';
$phprlang['welcome'] = 'Benvenuto/a ';

// Login Information
$phprlang['login_fail_title'] = 'Accesso fallito';
$phprlang['login_fail'] = 'Username e/o password inesistenti o non validi. Riprova nuovamente.';
$phprlang['login_forgot_password'] = 'Password dimenticata?';
$phprlang['login_pwdreset_fail_title'] = 'Invio/reset della password fallito';
$phprlang['login_pwdreset_title'] = 'Resetta password';
$phprlang['login_password_reset_msg']= 'Per resettare la password compila il seguente modulo';
$phprlang['login_username_email_incorrect'] = 'Lo username o l\'indirizzo e-mail specificati non sono validi.<br><br>Torna indietro e riprova.';
$phprlang['login_password_sent'] = 'La tua password di accesso a WRM è stata resettata, e la nuova password è stata inviata a:<br><br>';
$phprlang['login_password_sent2'] = '<br><br>Una mail è stata inviata all\'indirizzo e-mail sopra riportato. ' .
									'Se non l\'hai ricevuta, controlla o disattiva eventuali filtri anti-spam ' .
									'e riutilizza la funzione "Password dimenticata".';
$phprlang['login_password_email_msg'] = 'QUESTO MESSAGGIO NON E\' SPAM!<br><br>Qualcuno (presumibilmente tu) ha utilizzato ' .
										'la funzione "Password dimenticata" in un\'installazione di WRM per un account ' .
										'associato al tuo indirizzo e-mail. La password di accesso a WRM è stata resettata. ' .
										'La nuova password è:<br><br>';
$phprlang['login_password_email_msg2'] = '<br><br>Accedi a WRM utilizzando la password sopra riportata, e clicka il link ' .
										 '"Modifica password" sotto il pulsante di disconnessione se desideri modificarla. ' .
										 '<br><br>Se NON sei stato tu a richiedere il reset della password contatta gli ' .
										 'amministratori di WRM per informarli dell\'abuso.<br><br>' .
										 'Dovrai in ogni caso utilizzare la nuova password sopra riportata per accedere a WRM.';
$phprlang['login_password_email_sub'] = 'Notifica di reset della password di WRM'.										 
$phprlang['login_chpass_text'] = 'Modifica la password dell\'utente: ';
$phprlang['login_chpwd'] = 'Modifica password';
$phprlang['login_curr_password'] = 'Password corrente';
$phprlang['login_password_conf'] = 'Conferma password';
$phprlang['login_password_incorrect'] = 'Password corrente non valida, oppure la nuova password e la password di conferma ' .
										'non combaciano.<br><br>Torna indietro e riprova.';
$phprlang['login_password_new'] = 'Nuova password';
$phprlang['login_pwdreset_success'] = 'La tua password è stata resettata.<br><br>Dovrai utilizzare la nuova password al prossimo accesso a WRM.';

// Days of the Week
$phprlang['sunday'] = 'Domenica';
$phprlang['monday'] = 'Lunedì';
$phprlang['tuesday'] = 'Martedì';
$phprlang['wednesday'] = 'Mercoledì';
$phprlang['thursday'] = 'Giovedì';
$phprlang['friday'] = 'Venerdì';
$phprlang['saturday'] = 'Sabato';
$phprlang['2ltrsunday'] = 'Do';
$phprlang['2ltrmonday'] = 'Lu';
$phprlang['2ltrtuesday'] = 'Ma';
$phprlang['2ltrwednesday'] = 'Me';
$phprlang['2ltrthursday'] = 'Gi';
$phprlang['2ltrfriday'] = 'Ve';
$phprlang['2ltrsaturday'] = 'Sa';

// Months
$phprlang['month'] = 'Mese';
$phprlang['year'] = 'Anno';
$phprlang['month1'] = 'Gennaio';
$phprlang['month2'] = 'Febbraio';
$phprlang['month3'] = 'Marzo';
$phprlang['month4'] = 'Aprile';
$phprlang['month5'] = 'Maggio';
$phprlang['month6'] = 'Giugno';
$phprlang['month7'] = 'Luglio';
$phprlang['month8'] = 'Agosto';
$phprlang['month9'] = 'Settembre';
$phprlang['month10'] = 'Ottobre';
$phprlang['month11'] = 'Novembre';
$phprlang['month12'] = 'Dicembre';
							
// links
$phprlang['announcements_link'] = '&raquo;&nbsp;Annunci';
$phprlang['configuration_link'] = '&raquo;&nbsp;Configurazione';
$phprlang['guilds_link'] = '&raquo;&nbsp;Gilde';
$phprlang['home_link'] = '&raquo;&nbsp;Indice';
$phprlang['calendar_link'] = '&raquo;&nbsp;Calendario&nbsp;eventi';
$phprlang['locations_link'] = '&raquo;&nbsp;Istanze';
$phprlang['logs_link'] = '&raquo;&nbsp;Log';
$phprlang['permissions_link'] = '&raquo;&nbsp;Profili&nbsp;Utente';
$phprlang['profile_link'] = '&raquo;&nbsp;Personaggi';
$phprlang['raids_link'] = '&raquo;&nbsp;Raid';
$phprlang['register_link'] = '&raquo;&nbsp;Registrati';
$phprlang['roster_link'] = '&raquo;&nbsp;Roster';
$phprlang['users_link'] = '&raquo;&nbsp;Utenti';
$phprlang['lua_output_link'] = '&raquo;&nbsp;Export&nbsp;LUA';
$phprlang['index_link'] = '&raquo;&nbsp;Forum';
$phprlang['dkp_link'] = '&raquo;&nbsp;DKP';

// sorting information
$phprlang['sort_text'] = 'Clicka qui per ordinare per ';
$phprlang['sort_desc']='Clicka qui per ordinare (in ordine discendente) per ';
$phprlang['sort_asc']='Clicka qui per ordinare (in ordine ascendente) per '; 

// tooltips
$phprlang['add'] = 'Aggiungi';
$phprlang['announcements'] = 'Annunci';
$phprlang['arcane'] = 'Arcane';
$phprlang['calendar'] = 'Calendario';
$phprlang['cancel'] = 'Annulla iscrizione';
$phprlang['cancel_msg'] = 'La tua iscrizione a questo Raid è stata annullata';
$phprlang['comments'] = 'Commenti';
$phprlang['configuration'] = 'Configurazione';
$phprlang['deathknight_icon'] = 'Clicka per visualizzare i Death Knight';
$phprlang['delete'] = 'Elimina';
$phprlang['description'] = 'Descrizione';
$phprlang['druid_icon'] = 'Clicka per visualizzare i Druidi';
$phprlang['edit'] = 'Modifica';
$phprlang['edit_comment'] = 'Modifica commento';
$phprlang['fire'] = 'Fire';
$phprlang['frost'] = 'Frost';
$phprlang['frozen_msg'] = 'Le iscrizioni a questo Raid sono chiuse.';
$phprlang['group_name'] = 'Nome del Team';
$phprlang['group_description'] = 'Descrizione del Team';
$phprlang['guilds'] = 'Gilde';
$phprlang['has_permission'] = 'Ha il permesso';
$phprlang['hunter_icon'] = 'Clicka per visualizzare i Cacciatori';
$phprlang['in_queue'] = 'Inserisce il Personaggio fra le iscrizioni in coda';
$phprlang['last_login_date'] = 'Data di ultimo accesso';
$phprlang['last_login_time'] = 'Ora di ultimo accesso';
$phprlang['locations'] = 'Istanze';
$phprlang['logs'] = 'Log';
$phprlang['lua'] = 'Export LUA';
$phprlang['mage_icon'] = 'Clicka per visualizzare i Maghi';
$phprlang['mark'] = 'Imposta il Raid come passato';
$phprlang['nature'] = 'Nature';
$phprlang['new'] = 'Imposta il Raid come in programma';
$phprlang['not_signed_up'] = 'Clicka qui per iscriverti al Raid';
$phprlang['out_queue'] = 'Inserisce il Personaggio fra le iscrizioni confermate';
$phprlang['paladin_icon'] = 'Clicka per visualizzare i Paladini';
$phprlang['permissions'] = 'Profili Utente';
$phprlang['priest_icon'] = 'Clicka per visualizzare i Preti';
$phprlang['priv'] = 'Profilo Utente';
$phprlang['profile'] = 'Utente';
$phprlang['raids'] = 'Raid';
$phprlang['remove_group'] = 'Rimuovi il gruppo dal Profilo Utente';
$phprlang['remove_user'] = 'Rimuovi l\'Utente dal Profilo Utente';
$phprlang['rogue_icon'] = 'Clicka per visualizzare i Ladri';
$phprlang['shadow'] = 'Shadow';
$phprlang['shaman_icon'] = 'Clicka per visualizzare gli Sciamani';
$phprlang['signed_up'] = 'Sei iscritto a questo Raid';
$phprlang['signup_add'] = 'Aggiungi l\'Utente alle iscrizioni';
$phprlang['signup_delete'] = 'Elimina l\'Utente dalle iscrizioni';
$phprlang['users'] = 'Utenti';
$phprlang['warlock_icon'] = 'Clicka per visualizzare i Warlock';
$phprlang['warrior_icon'] = 'Clicka per visualizzare i Guerrieri';
?>