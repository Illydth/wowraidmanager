<?php
// form variables
$phprlang['log_create_text'] = 'creations';
$phprlang['log_date'] = 'date';
$phprlang['log_delete_text'] = 'deletions';
$phprlang['log_hack_text'] = 'hack attempts';
$phprlang['log_id'] = 'id';
$phprlang['log_in'] = ' in ';
$phprlang['log_order'] = ' order and show';
$phprlang['log_raid_text'] = 'raid activity';
$phprlang['log_sort_by'] = 'Sort by ';
$phprlang['log_type'] = 'type';

// cancellation
$phprlang['log_cancel_message'] = '[USER CANCEL]';

// hack
$phprlang['log_hack_header'] = 'Hacking attempt detected';
$phprlang['log_hack_message'] = 'A hacking attempt has been detected and is logged with the following details<br><br>
							<strong>Attempted Hack:</strong> %s<br>
							<strong>Date/Time:</strong> %s<br>
							<strong>User IP:</strong> %s<br><br>
							An administrator has been notified and may result in a ban.';
							
// headers
$phprlang['log_header'] = 'Log Output';
$phprlang['log_create_header'] = 'Creation Logs';
$phprlang['log_delete_header'] = 'Deletion Logs';
$phprlang['log_hack_header'] = 'Hack Logs';
$phprlang['log_raid_header'] = 'Raid Activity Logs';
$phprlang['log_sort_header'] = 'Choose filter options';
							
// output text
$phprlang['log_create'] = '%s - %s: user [%s (%s)] CREATED %s with ID [%s] and NAME [%s]';
$phprlang['log_delete'] = '%s - %s: user [%s (%s)] DELETED %s with NAME [%s]';
$phprlang['log_hack'] = '%s - %s: user with IP [%s] ATTEMPTED hack with [%s]';
$phprlang['log_raid'] = '%s - %s: user [%s (%s)] altered RAID %s BY %s with CHARACTER %s';
?>