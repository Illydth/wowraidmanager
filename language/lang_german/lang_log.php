<?php
// form variables
$phprlang['log_create_text'] = 'Erstellungen';
$phprlang['log_date'] = 'Datum';
$phprlang['log_delete_text'] = 'Löschungen';
$phprlang['log_hack_text'] = 'Hack-Versuche';
$phprlang['log_id'] = 'ID';
$phprlang['log_in'] = ' in ';
$phprlang['log_order'] = ' Reihenfolge und zeige';
$phprlang['log_raid_text'] = 'Raidaktivitäten';
$phprlang['log_sort_by'] = 'Sortiere nach ';
$phprlang['log_type'] = 'Typ';

// cancellation
// unused ... $phprlang['log_cancel_message'] = '[USER CANCEL]';

// hack
$phprlang['log_hack_header'] = 'Hack-Versuch erkannt';			// will not be used as declared again below
$phprlang['log_hack_message'] = 'Ein Hack-Versuch wurde erkannt und mit folgenden Details protokolliert:<br><br>
							<strong>Versuchter Hack:</strong> %s<br>
							<strong>Datum/Uhrzeit:</strong> %s<br>
							<strong>Benutzer-IP:</strong> %s<br><br>
							Ein Administrator wurde benachrichtigt, das kann zu einem Bann führen.';
							
// headers
$phprlang['log_header'] = 'Protokoll';
$phprlang['log_create_header'] = 'Protokoll der Erstellungen';
$phprlang['log_delete_header'] = 'Protokoll der Löschungen';
$phprlang['log_hack_header'] = 'Protokoll der Hack-Versuche';
$phprlang['log_raid_header'] = 'Protokoll der Raidaktivitäten';
$phprlang['log_sort_header'] = 'Filteroptionen';
							
// output text
$phprlang['log_create'] = '%s - %s: Benutzer [%s (%s)] ERZEUGTE %s mit ID [%s] und NAME [%s]';
$phprlang['log_delete'] = '%s - %s: Benutzer [%s (%s)] LÖSCHTE %s mit NAME [%s]';
$phprlang['log_hack'] = '%s - %s: Benutzer mit IP [%s] VERSUCHTE einen HACK mit [%s]';
// unused ... $phprlang['log_raid'] = '%s - %s: Benutzer [%s (%s)] änderte RAID %s nach %s mit CHARAKTER %s';
?>