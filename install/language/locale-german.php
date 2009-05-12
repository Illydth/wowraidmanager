<?php
//
//germany install strings
//
global $localstr;
$localstr['headtitle'] = 'Willkommen zu der WRM 4.x.x Installation.';
$localstr['headbodyinfo'] = 'Bitte beachte, dass die Datenbank, in der du WRM installieren willst, auch existiert!';

//menu
$localstr['InstallationProgress'] = 'Fortschritt der Installation';
$localstr['menustep1init'] = '1. Initialisierung';
$localstr['menustep2conf'] = '2. Konfiguration';
$localstr['menustep3instab'] = '3. Tabellen installieren';
$localstr['menustep4auth'] = '4. Berechtigungsschema';
$localstr['menustep5confauth'] = '5. Konf. Berechtigungsschema';
$localstr['menustep6final'] = '6. Abschlie�en';

//botton
$localstr['bd_submit'] = 'weiter';
$localstr['bd_reset'] = 'zur�cksetzen';
$localstr['bd_yes'] = 'Ja';
$localstr['bd_no'] = 'Nein';

//stuff
$localstr['hittingsubmit'] = 'Bitte kontrolliere deine Eingaben bevor du auf "weiter" klickst.';
$localstr['pressbrowserpack'] ='Bitte benutze in deinem Browser die "zur�ck" Taste und gebe die Daten erneut ein.';
$localstr['problem'] ='Problem';
$localstr['txtusername'] = 'Benutzername';
$localstr['txtpassword'] = 'Passwort';
$localstr['txtemail'] = 'E-Mail';
$localstr['txtconfig'] = 'Konfiguration';

//step 2
$localstr['step2freshinstall'] = 'Neue Installation';
$localstr['step2upgradefrom'] = 'Upgrade zur';
$localstr['step2dbname'] = 'MySQL-Datenbankname';
$localstr['step2dbserverhostname'] = 'MySQL-Hostname';
$localstr['step2dbserverusername'] = 'MySQL-Server Benutzername';
$localstr['step2dbserverpwd'] = 'MySQL-Server Passwort';
$localstr['step2WRMtableprefix'] = 'WRM Tabellenprefix';
$localstr['step2installtype'] = 'Art der Installation';
$localstr['step2error01'] = 'Bei falschen Eingaben k�nnte es zu unvorhersehbaren Auswirkungen kommen, eine Hilfe wird nicht angeboten!';

//step 3
$localstr['step3errordbcon'] = 'Fehler: konnte keine Verbindung zur angegeben Datenbank herstellen.<br>';
$localstr['step3errorschema'] = 'Fehler: das Upgrade-Schema konnte nicht ge�ffnet werden';
$localstr['step3errorsql'] = 'Fehler bei der Installation :<br> SQL-String: $sql<br> Bericht: ';
$localstr['step3installinfo'] = 'Wenn du dies hier lesen kannst, sind keine Fehler bei der Installation der SQL-Tabellen aufgetreten!';
$localstr['step3errorversion'] = 'Die Software-Version in version.php entsprich nicht der Version der Datenbank in der Version-Tabelle.';

//step 4
$localstr['step4auttype'] = 'Berechtigungsschema';
$localstr['step4desc'] = 'Beschreibung';
$localstr['step4desc_e107'] = 'e107 CMS System';
$localstr['step4desc_phpBB'] = 'phpBB2 oder phpBB3';
$localstr['step4desc_iums'] = 'integriertes Benutzermanagement-System (iUMS)';
$localstr['step4desc_smf'] = 'Simple Machines Forum 1.x';
$localstr['step4desc_smf2'] = 'Simple Machines Forum 2.x';
$localstr['step4desc_wbb'] = 'WoltLab Burning Board Lite 1.x.x';
$localstr['step4desc_xoops'] = 'XOOPS';
$localstr['step4unkownauth'] = '(wenn du nicht sicher bist, w�hle bitte "iUMS")';
$localstr['step4chooseauth'] = 'Bitte w�hle dein Berechtigungsschema aus.';

//--------------------------
// Auth.
//--------------------------
$localstr['step5failconWRM'] = 'Verbindung zur WRM-Datenbank nicht m�glich';
$localstr['step5selctusername'] = 'dieser Benutzer bekommt vollen Zugriff auf das WRM';
$localstr['step5sub1follval'] = 'Um die Installation abzuschlie�en, f�lle bitte die folgenden Felder aus';
$localstr['step5done'] = 'fertig';
$localstr['step5sub2usernamefullperm'] = 'w�hle bitte den Benutzer aus, der vollen Zugriff auf das WRM bekommt';
$localstr['step5sub3norest'] = 'Keine Einschr�nkung';
$localstr['step5sub3noaddus'] = 'Keine zus�tzliche Benutzergruppe';
$localstr['step5sub2failfindfile'] = 'konnte die Konfigurationsdatei nich finden:';
$localstr['step5sub2checkdir'] = '�berpr�fe das Verzeichnis noch mal';
$localstr['step5sub3group01'] = 'W�hle die Benutzergruppe aus, welche Zugang zur Nutzung von WRM hat';
$localstr['step5sub3group02'] = 'Benutztern die nicht in dieser Benutzergruppe sind, ist es nicht m�glich sich anzumelden';
$localstr['step5sub3group03'] = 'Wenn du willst, dass alle Benutzer unabh�ngig von der Benutzergruppe sich im WRM anmelden k�nnen, w�hle "Keine Einschr�nkung" aus.';
$localstr['step5sub3altgroup01'] = 'W�hle eine alternative Benutzergruppe aus, welcher den Zugang zu WRM auch erlaubt ist';
$localstr['step5sub3altgroup02'] = 'mit dieser alternativen Gruppe ist es Benutzern m�glich, sich unabh�ngig davon anzumelden, ob sie in der oben genannten Benutzergruppe sind oder nicht ';

// phpBB
$localstr['step5phpBBdesc'] = 'phpBB';
$localstr['step5phpBBsub1desc'] = 'Du hast phpBB-Authentifizierung ausgew�hlt';
$localstr['step5phpBBsub1inputdir'] = 'Gebe den relativen Pfad zu deinem phpBB-Verzeichnis ein (einschlie�lich des abschlie�enden Schr�gstriches!)';
$localstr['step5phpBBsub2failincdir'] = 'Dein angegebenes phpBB-Verzeichnis ist falsch';
$localstr['step5phpBBsub2failfindautfile'] = 'konnte die Konfigurationsdatei "../auth/auth_phpbb3.php" nicht finden';
$localstr['step5phpBBsub2faildownautfile'] = 'bitte lade sie dir herunter (von der WRM-Homepage) und kopiere sie nach "/auth".';
$localstr['step5phpBBsub2founddb'] = 'gefunden phpBB-Datebank';
$localstr['step5phpBBsub2readconffile'] = 'lese phpBB-Konfigurationsdatei';
$localstr['step5phpBBsub3errorretusergroup'] = 'Fehler beim Abrufen der Benutzergruppe aus der phpBB3-Datebank';
$localstr['step5phpBBsub3errorretusername'] = 'Fehler beim Abrufen der Benutzernamen aus der phpBB3-Datebank';
$localstr['step5phpBBsub4wantimport'] = 'M�chtest du alle Benutzter aus dem phpBB Forum/Board importieren';
$localstr['step5phpBBsub4srynotsupport'] = 'Endschuldigung: der Import der Benutzer aus dem phpBB Forum/Board wird bei phpBB2 nicht unterst�tzt';
$localstr['step5phpBBsub5import'] = 'Import';
$localstr['step5phpBBfailconphpBB'] = 'Verbindung zur phpBB-Datenbank nicht m�glich';

// e107
$localstr['step5e107desc'] = 'e107';
$localstr['step5e107sub1desc'] = 'Du hast e107-Authentifizierung ausgew�hlt';
$localstr['step5e107sub1inputdir'] = 'Gebe den relativen Pfad zu deinem e107-Verzeichnis ein (einschlie�lich des abschlie�enden Schr�gstriches!)';
$localstr['step5e107sub2failincdir'] = 'Dein Angegebenes e107-Verzeichnis ist falsch';
$localstr['step5e107sub2readconffile'] = 'lese e107-Konfigurationsdatei';
$localstr['step5e107sub3errorretusername'] = 'Fehler beim Abrufen der Benutzernamen aus der e107-Datebank';
$localstr['step5e107sub3errorretuserclass'] = 'Fehler beim Abrufen der Benutzergruppe aus der e107-Datebank';
$localstr['step5e107failcone107'] = 'Verbindung zur e107-Datenbank nicht m�glich';

// iums = integrated User Management System
$localstr['step5iumsdesc'] = 'integriertes Benutzermanagement-System';
$localstr['step5iumssub1desc'] = 'Du hast "integriertes Benutzermanagement-System"-Authentifizierung ausgew�hlt';
$localstr['step5sub1iumsfilladmindesc'] = 'f�lle alle Werte f�r den Benutzter des Super-Administrator aus.';

// Joomla germany
$localstr['step5joomladesc'] = 'Joomla';
$localstr['step5joomlasub1desc'] = 'Du hast Joomla-Authentifizierung ausgew�hlt';
$localstr['step5joomlasub1inputdir'] = 'Gebe den relativen Pfad zu deinem Joomla-Verzeichnis ein (einschlie�lich des abschlie�enden Schr�gstriches!)';
$localstr['step5joomlasub2failincdir'] = 'Dein angegebenes Joomla-Verzeichnis ist falsch';
$localstr['step5joomlasub2readconffile'] = 'lese Joomla-Konfigurationsdatei';
$localstr['step5joomlasub3errorretusername'] = 'Fehler beim Abrufen der Benutzernamen aus der Joomla-Datebank';
$localstr['step5joomlasub3errorretuserclass'] = 'Fehler beim Abrufen der Benutzergruppe aus der Joomla-Datebank';
$localstr['step5joomlafailconejoomla'] = 'Verbindung zur Joomla-Datenbank nicht m�glich';

// SMF = Simple Machines Forum
$localstr['step5smfdesc'] = 'SMF';
$localstr['step5smfsub1desc'] = 'Du hast SMF-Authentifizierung ausgew�hlt';
$localstr['step5smfsub1inputdir'] = 'Gebe den relativen Pfad zu deinem SMF-Verzeichnis ein (einschlie�lich des abschlie�enden Schr�gstriches!)';
$localstr['step5smfsub2failincdir'] = 'Dein angegebenes SMF-Verzeichnis ist falsch';
$localstr['step5smfsub2readconffile'] = 'lese SMF-Konfigurationsdatei';
$localstr['step5smfsub3errorretusername'] = 'Fehler beim Abrufen der Benutzernamen aus der SMF-Datebank';
$localstr['step5smfsub3errorretuserclass'] = 'Fehler beim Abrufen der Benutzergruppe aus der SMF-Datebank';
$localstr['step5smffailconesmf'] = 'Verbindung zur SMF-Datenbank nicht m�glich';

// WoltLab Burning Board Lite 1.x.x = wbb
$localstr['step5wbbdesc'] = 'WoltLab Burning Board';
$localstr['step5wbbsub1desc'] = 'Du hast WBB-Authentifizierung ausgew�hlt';
$localstr['step5wbbsub1inputdir'] = 'Gebe den relativen Pfad zu deinem WBB-Verzeichnis ein (einschlie�lich des abschlie�enden Schr�gstriches!)';
$localstr['step5wbbsub2failincdir'] = 'Dein angegebenes WBB-Verzeichnis ist falsch';
$localstr['step5wbbsub2readconffile'] = 'lese WBB-Konfigurationsdatei';
$localstr['step5wbbsub3errorretusername'] = 'Fehler beim Abrufen der Benutzernamen aus der WBB-Datebank';
$localstr['step5wbbsub3errorretuserclass'] = 'Fehler beim Abrufen der Benutzergruppe aus der WBB-Datebank';
$localstr['step5wbbfailconesmf'] = 'Verbindung zur WBB-Datenbank nicht m�glich';

// XOOPS
$localstr['step5xoopsdesc'] = 'XOOPS';
$localstr['step5xoopssub1desc'] = 'Du hast XOOPS-Authentifizierung ausgew�hlt';
$localstr['step5xoopssub1inputdir'] = 'Gebe den relativen Pfad zu deinem XOOPS-Verzeichnis ein (einschlie�lich des abschlie�enden Schr�gstriches!)';
$localstr['step5xoopssub2failincdir'] = 'dein angegebenes XOOPS-Verzeichnis ist falsch';
$localstr['step5xoopssub2readconffile'] = 'lese XOOPS-Konfigurationsdatei';
$localstr['step5xoopssub3errorretusername'] = 'Fehler beim Abrufen der Benutzernamen aus der XOOPS-Datebank';
$localstr['step5xoopssub3errorretuserclass'] = 'Fehler beim Abrufen der Benutzergruppe aus der XOOPS-Datebank';
$localstr['step5xoopsfailconesmf'] = 'Verbindung zur XOOPS-Datenbank nicht m�glich';

//----------------------------------------------
//step done
$localstr['stepdonefinished'] = 'Fertig';
$localstr['stepdonesetupcomplete'] = 'Die Installtion ist nun komplett.';
$localstr['stepdoneremovedir'] = 'L�sche bitte das "install/"-Verzeichnis und klicke anschlie�end <a href="../index.php">auf diesen Link</a> wenn du fertig bist.';

?>