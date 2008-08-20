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
$phprlang['announcements_header'] = 'Annunci';
$phprlang['announcements_new_header'] = 'Crea un nuovo Annuncio';
$phprlang['announcements_message_text'] = 'Testo';
$phprlang['announcements_title_text'] = 'Titolo';

// Calendar
$phprlang['invites'] = 'Inviti';
$phprlang['start'] = 'Inizio';
$phprlang['key'] = 'Legenda:<br>(*) = Iscritto e confermato<br>(#) = Iscritto (in coda o annullato)<br>Giorni <font color="#FFFFFF">bianchi</font> = eventi passati.<br>Giorno <font color="#FF0000">rosso</font> = eventi odierni.<br>Giorni <font color="#000000">neri</font> = eventi futuri.';

// configuration
$phprlang['configuration_addon'] = 'Sito ufficiale di WowRaidManager';
$phprlang['configuraiton_admin'] = 'Amministratori';
$phprlang['configuration_admin_email'] = 'E-mail dell\'Amministratore';
$phprlang['configuration_ampm'] = 'Formato orario di creazione dei Raid';
$phprlang['configuration_anonymous'] = 'Consenti la visualizzazione agli Utenti non registrati';
$phprlang['configuration_armory_enable'] = 'Abilita l\'integrazione con l\'Armory';
$phprlang['configuration_armory_link_text'] = 'Indirizzo dell\'Armory';
$phprlang['configuration_armory_language_text'] = 'Codice linguaggio dell\'Armory';
$phprlang['configuration_autoqueue'] = 'Impedisci l\'inserimento diretto fra le iscrizioni confermate';
$phprlang['configuration_cancel'] = 'Annulla';
$phprlang['configuration_cancel_def'] = 'Annulla = Consenti l\'inserimento fra le iscrizioni annullate';
$phprlang['configuration_cancelled'] = 'Iscrizioni annullate';
$phprlang['configuration_comments'] = 'Commenti';
$phprlang['configuration_comments_def'] = 'Commenti = Consenti la modifica dei commenti';
$phprlang['configuration_date'] = 'Formato delle date<br><a href="http://www.php.net/date/" target="_blank">(Guida)</a>';
$phprlang['configuration_description'] = 'Descrizione';
$phprlang['configuration_debug'] = 'Modalità debug';
$phprlang['configuration_default'] = 'Profilo Utente predefinito';
$phprlang['configuration_delete'] = 'Elimina';
$phprlang['configuration_delete_def'] = 'Elimina = Consenti l\'eliminazione delle iscrizioni';
$phprlang['configuration_disable'] = 'Disabilita WowRaidManager';
$phprlang['configuration_draft'] = 'Conferma';
$phprlang['configuration_draft_def'] = 'Conferma = Consenti l\'inserimento fra le iscrizioni confermate';
$phprlang['configuration_drafted'] = 'Iscrizioni confermate';
$phprlang['configuration_dst_text'] = 'Ora legale?';
$phprlang['configuration_email_header'] = 'Configurazione dell\'e-mail';
$phprlang['configuration_email_sig'] = 'Firma dell\'e-mail';
$phprlang['configuration_enable_five_man'] = 'Abilita i Gruppi<br><a href="docs/enable_groups.htm" target="_blank">(Guida)</a>';
$phprlang['configuration_eqdkp_integration_text'] = 'Integra con EqDKP<br><a href="docs/eqdkp_link.htm" target="_blank">(Guida)</a>';
$phprlang['configuration_eqdkp_link'] = 'Indirizzo base dell\'installazione di EqDKP (senza barra finale)';
$phprlang['configuration_external_links_header'] = 'Integrazione con sistemi esterni';
$phprlang['configuration_faction'] = 'Fazione';
$phprlang['configuration_freeze'] = 'Disabilita la chiusura delle iscrizioni';
$phprlang['configuration_guild_header'] = 'Configurazione della Gilda';
$phprlang['configuration_guild_name'] = 'Nome';
$phprlang['configuration_id'] = 'Visualizza l\'ID nelle tabelle';
$phprlang['configuration_language'] = 'Lingua';
$phprlang['configuration_logo'] = 'Immagine di intestazione';
$phprlang['configuration_multiple'] = 'Consenti iscrizioni multiple';
$phprlang['configuration_on_queue'] = 'Iscrizioni in coda';
$phprlang['configuration_queue'] = 'Accoda';
$phprlang['configuration_queue_def'] = 'Accoda = Consenti l\'inserimento fra le iscrizioni in coda';
$phprlang['configuration_raid_settings_header'] = 'Impostazioni inerenti i Raid';
$phprlang['configuration_raidlead'] = 'Gestori Raid';
$phprlang['configuration_resop'] = 'Rendi opzionali i dati delle resistenze';
$phprlang['configuration_register_text'] = 'Indirizzo di registrazione';
$phprlang['configuration_role_header'] = 'Configurazione dei ruoli';
$phprlang['configuration_role1_text'] = 'Ruolo #1';
$phprlang['configuration_role2_text'] = 'Ruolo #2';
$phprlang['configuration_role3_text'] = 'Ruolo #3';
$phprlang['configuration_role4_text'] = 'Ruolo #4';
$phprlang['configuration_role5_text'] = 'Ruolo #5';
$phprlang['configuration_role6_text'] = 'Ruolo #6';
$phprlang['configuration_role_limit_text'] = 'Imponi i limiti sui ruoli';
$phprlang['configuration_class_limit_text'] = 'Imponi i limiti sulle classi';
$phprlang['configuration_class_as_min'] = 'Considera i limiti sulle classi come limiti minimi';
$phprlang['configuration_roster_text'] = 'Integra con WoW Roster';
$phprlang['configuration_rss_site'] = 'RSS: indirizzo di installazione di WowRaidManager (senza barra finale)';
$phprlang['configuration_rss_export'] = 'RSS: indirizzo a cui esportare il feed RSS';
$phprlang['configuration_rss_feed_amt'] = 'RSS: numero di Raid da visualizzare';
$phprlang['configuration_server'] = 'Server';
$phprlang['configuration_show_addon'] = 'Visualizza link a WRM';
$phprlang['configuration_signup_rights_header'] = 'Permessi di iscrizione';
$phprlang['configuration_site_header'] = 'Configurazione del sito';
$phprlang['configuration_sitelink'] = 'Il link "Homepage" punta a';
$phprlang['configuration_template'] = 'Tema visuale';
$phprlang['configuration_time'] = 'Formato degli orari<br><a href="http://www.php.net/date/" target="_blank">(Guida)</a>';
$phprlang['configuration_timezone_text'] = 'Fuso orario';
$phprlang['configuration_user'] = 'Utenti';
$phprlang['configuration_user_rights_header'] = 'Permessi degli Utenti';
$phprlang['configuration_version_current'] = 'Si sta utilizzando l\'ultima versione di WowRaidManager';
$phprlang['configuration_version_info_header'] = 'Informazioni sulla versione di WRM';
$phprlang['configuration_version_outdated_header'] = 'E\' disponibile una nuova versione di WowRaidManager!';
$phprlang['configuration_version_outdated_message'] = 'La versione in uso di WowRaidManager non è l\'ultima disponibile: si consiglia vivamente di aggiornarla.<br>
													   L\'ultima versione è %s, mentre quella in uso è %s.<br>
													   Per scaricare l\'ultima versione, fare riferimento all\'area Download di <a href="http://www.wowraidmanager.net">WowRaidManager.net</a>.';
// DKP View
$phprlang['eqdkp_system_link'] = 'Link al sistema DKP:';

// guilds
$phprlang['guilds_header'] = 'Lista delle Gilde';
$phprlang['guilds_new_header'] = 'New Guild';
$phprlang['guilds_master'] = 'GuildMaster';
$phprlang['guilds_name'] = 'Nome della Gilda';
$phprlang['guilds_tag']	= 'Abbreviazione della Gilda';						

// locations
$phprlang['locations_header'] = 'Istanze configurate';
$phprlang['locations_max_lvl'] = 'Livello massimo';
$phprlang['locations_min_lvl'] = 'Livello minimo';
$phprlang['locations_limits_header'] = 'Limiti';
$phprlang['locations_long'] = 'Nome esteso';
$phprlang['locations_new'] = 'Configura una nuova Istanza';
$phprlang['locations_raid_max'] = 'Numero massimo di PG';
$phprlang['locations_short'] = 'Nome abbreviato';
$phprlang['lock_template'] = 'Profilo Istanza non modificabile?';

// lua_output
$phprlang['rim_download'] = 'Scarica RIM (Raid Information Manager)';
$phprlang['lua_download'] = 'Scarica phpRaidViewer';
$phprlang['lua_header'] = 'Codice LUA/Macro';

// permissions
$phprlang['permissions_add'] = 'Aggiungi al Profilo Utente';
$phprlang['permissions_announcements'] = 'Annunci';
$phprlang['permissions_configuration'] = 'Configurazione';
$phprlang['permissions_details_users_header'] = 'Permessi dettagliati';
$phprlang['permissions_edit_header'] = 'Modifica Profilo Utente';
$phprlang['permissions_description'] = 'Descrizione';
$phprlang['permissions_details_header'] = 'Dettaglio dei Permessi';
$phprlang['permissions_guilds'] = 'Gilde';
$phprlang['permissions_header'] = 'Profili Utente';
$phprlang['permissions_locations'] = 'Istanze';
$phprlang['permissions_logs'] = 'Log';
$phprlang['permissions_name'] = 'Nome';
$phprlang['permissions_permissions'] = 'Profili Utente';
$phprlang['permissions_profile'] = 'Personaggi';
$phprlang['permissions_raids'] = 'Raid';
$phprlang['permissions_new'] = 'Crea un nuovo Profilo Utente';
$phprlang['permissions_users'] = 'Utenti';
$phprlang['permissions_users_header'] = 'Utenti che utilizzano questo Profilo';

// profile
$phprlang['profile_arcane'] = 'Resistenza Arcane';
$phprlang['profile_class'] = 'Classe';
$phprlang['profile_create_header'] = 'Non è possibile definire nuovi Personaggi';
$phprlang['profile_create_msg'] = 'Non è possibile definire Personaggi fino a quando non viene inserita almeno una Gilda';
$phprlang['profile_fire'] = 'Resistenza Fire';
$phprlang['profile_frost'] = 'Resistenza Frost';
$phprlang['profile_gender'] = 'Genere';
$phprlang['profile_guild'] = 'Gilda';
$phprlang['profile_role'] = 'Ruolo';
$phprlang['profile_header'] = 'Personaggi';
$phprlang['profile_level'] = 'Livello';
$phprlang['profile_name'] = 'Nome';
$phprlang['profile_nature'] = 'Resistenza Nature';
$phprlang['profile_raid'] = 'Storico Raid';
$phprlang['profile_race'] = 'Razza';
$phprlang['profile_shadow'] = 'Resistenza Shadow';

// raids
$phprlang['raids_date'] = 'Data';
$phprlang['raids_description'] = 'Descrizione';
$phprlang['raids_dungeon'] = 'Istanza';
$phprlang['raids_freeze'] = 'Anticipo chiusura delle iscrizioni (in ore)';
$phprlang['raids_invite'] = 'Ora di invito';
$phprlang['raids_limits'] = 'Limiti del Raid';
$phprlang['raids_location'] = 'Istanze preconfigurate';
$phprlang['raids_max'] = 'Numero massimo di PG';
$phprlang['raids_max_lvl'] = 'Livello massimo';
$phprlang['raids_min_lvl'] = 'Livello minimo';
$phprlang['raids_old'] = 'Raid passati';
$phprlang['raids_new'] = 'Raid in programma';
$phprlang['raids_new_header'] = 'Nuovo Raid';
$phprlang['raids_start'] = 'Ora di inizio';

// roster
$phprlang['roster_header'] = 'Roster di Gilda';

// registration
$phprlang['register_complete_header'] = 'Registrazione effettuata con successo';
$phprlang['register_complete_msg'] = 'Ora sei un Utente registrato. Potrebbe esser necessario attendere l\'abilitazione definitiva da parte di un Amministratore prima di poter utilizzare tutte le funzioni di WowRaidManager.';
$phprlang['register_confirm'] = 'Le password non corrispondono.';
$phprlang['register_confirm_text'] = 'Inserisci nuovamente la password';
$phprlang['register_email_header'] = 'Registrazione a';
$phprlang['register_email_empty'] = 'E\' necessario inserire un indirizzo e-mail';
$phprlang['register_email_exists'] = 'L\'indirizzo e-mail specificato è già in uso';
$phprlang['register_email_greeting'] = 'Benvenuto';
$phprlang['register_email_subject'] = 'E-mail di conferma della registrazione. Non necessita di risposta.';
$phprlang['register_email_text'] = 'Indirizzo e-mail';
$phprlang['register_error'] = 'Errore in fase di registrazione';
$phprlang['register_header'] = 'Registrazione Utente';
$phprlang['register_pass_empty'] = 'E\' necessario inserire una password';
$phprlang['register_password_text'] = 'Password';
$phprlang['register_user_empty'] = 'E\' necessario inserire uno username';
$phprlang['register_user_exists'] = 'Lo username specificato è già in uso';
$phprlang['register_username_text'] = 'Username';

// users
$phprlang['users_assign'] = 'Assegna';
$phprlang['users_char_header'] = 'Personaggi degli Utenti';
$phprlang['users_header'] = 'Utenti';

// view
$phprlang['view_approved'] = 'Iscrizioni confermate';
$phprlang['view_cancel_header'] = 'Iscrizioni annullate';
$phprlang['view_character'] = 'Personaggio';
$phprlang['view_comments'] = 'Commenti';
$phprlang['view_create'] = 'Definisci un Personaggio da iscrivere';
$phprlang['view_date'] = 'Data';
$phprlang['view_description_header'] = 'Descrizione del Raid';
$phprlang['view_frozen'] = 'Le iscrizioni per questo Raid sono chiuse';
$phprlang['view_information_header'] = 'Informazioni';
$phprlang['view_invite'] = 'Ora di invito';
$phprlang['view_location'] = 'Istanza';
$phprlang['view_login'] = 'Accedi a WowRaidManager con i tuoi username e password per poterti iscrivere';
$phprlang['view_new'] = 'Iscriviti a questo Raid';
$phprlang['view_max'] = 'Numero massimo di PG';
$phprlang['view_max_lvl'] = 'Livello massimo';
$phprlang['view_min_lvl'] = 'Livello minimo';
$phprlang['view_missing_signups_link_text'] = 'Visualizza gli Utenti che NON risultano iscritti a questo Raid';
$phprlang['view_officer'] = 'Inserito da';
$phprlang['view_ok'] = 'Iscrizioni aperte';
$phprlang['view_queue'] = 'Tipo di iscrizione';
$phprlang['view_queue_header'] = 'Iscrizioni in coda';
$phprlang['view_queued'] = 'Iscrizioni in coda';
$phprlang['view_raid_cancel_text'] = 'Iscrizioni annullate';
$phprlang['view_signed'] = 'Già iscritto';
$phprlang['view_signup'] = 'Stato delle iscrizioni';
$phprlang['view_signup_queue'] = 'In coda (disponibile per il Raid)';
$phprlang['view_signup_cancel'] = 'Annullata (non disponibile per il Raid)';
$phprlang['view_signup_draft'] = 'Confermata (nella formazione del Raid)';
$phprlang['view_start'] = 'Ora di inizio';
$phprlang['view_statistics_header'] = 'Statistiche';
$phprlang['view_teams_link_text'] = 'Crea ed assegna i Team per questo Raid';
$phprlang['view_total'] = 'Iscrizioni totali';
$phprlang['view_username'] = 'Utente';

// main page
$phprlang['main_previous_raids'] = 'Eventi passati';
$phprlang['main_upcoming_raids'] = 'Eventi in programma';
$phprlang['signup'] = 'Iscriviti';
$phprlang['rss_feed_text'] = 'Feed RSS delle iscrizioni ai Raid';
$phprlang['guild_time_string'] = 'Orario di gilda';
$phprlang['menu_header_text'] = 'Menù di WRM';

// teams
$phprlang['team_new_header'] = 'Crea un nuovo Team';
$phprlang['team_add_header'] = 'Aggiungi membri al Team';
$phprlang['team_remove_header'] = 'Rimuovi membri dal Team';
$phprlang['teams_raid_view_text'] = 'Torna alla visualizzazione del Raid';
$phprlang['team_cur_teams_header'] = 'Team creati';
$phprlang['team_page_header'] = 'Team';
?>