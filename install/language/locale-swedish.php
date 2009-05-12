<?php
//
//Svenska installations str�ngar
//
global $localstr;
$localstr['headtitle'] = 'Välkommen till installationen av WRM 4.x.x.';
$localstr['headbodyinfo'] = 'Vänligen notera att databasen du installerar till redan måste existera.';

//menu
$localstr['InstallationProgress'] = 'Installations Status';
$localstr['menustep1init'] = '1. Initialiserar';
$localstr['menustep2conf'] = '2. Konfiguration';
$localstr['menustep3instab'] = '3. Installerar Tabeller';
$localstr['menustep4auth'] = '4. Autentisering';
$localstr['menustep5confauth'] = '5. Konf. Autentisering';
$localstr['menustep6final'] = '6. Avslutande';

//botton
$localstr['bd_submit'] = 'Fortsätt';
$localstr['bd_reset'] = 'Återställ';

//stuff
$localstr['hittingsubmit'] = 'Vänligen verifiera all information innan du fortsätter vidare!';
$localstr['pressbrowserpack'] ='Tryck på webbläsarens TILLBAKA knapp för att försöka igen.';
$localstr['problem'] ='Problem';
$localstr['txtusername'] = 'Användarnamn';
$localstr['txtpassword'] = 'Lösenord';
$localstr['txtemail'] = 'E-post';
$localstr['txtconfig'] = 'Konfiguration';

//step 2
$localstr['step2freshinstall'] = 'Ny Installation';
$localstr['step2upgradefrom'] = 'Uppgradera till';
$localstr['step2dbname'] = 'MySQL Databas';
$localstr['step2dbserverhostname'] = 'MySQL Värdnamn';
$localstr['step2dbserverusername'] = 'MySQL Server Användarnamn';
$localstr['step2dbserverpwd'] = 'MySQL Server Lösenord';
$localstr['step2WRMtableprefix'] = 'WRM Tabell Prefix';
$localstr['step2installtype'] = 'Installations Typ';
$localstr['step2error01'] = 'Misslyckande att göra så, kan leda till oförutseddaproblem och hjälp kommer inte att ges!';

//step 3
$localstr['step3errordbcon'] = 'Fel vid försök att kontakta databasen.'; 
$localstr['step3errorschema'] = 'Fel vid öppnandet av uppgraderings schemat';
$localstr['step3errorsql'] = 'Fel vid installation <br>Förfrågan: $sql<br>Rapporterade: ';
$localstr['step3installinfo'] = 'Om du ser detta så skedde där inga fel under installationen av tabeller!';
$localstr['step3errorversion'] = 'Mjukvarans version i version.php matchar inte databasens version i versions tabellen.';

//step 4
$localstr['step4auttype'] = 'Autentisering sätt';
$localstr['step4desc'] = 'Beskrivning';
$localstr['step4desc_e107'] = 'e107 CMS System';
$localstr['step4desc_phpBB'] = 'phpBB2 eller phpBB3';
$localstr['step4desc_iums'] = 'Inbyggt Användar Hanterings System';
$localstr['step4desc_smf'] = 'Simple Machines Forum 1.x';
$localstr['step4desc_smf2'] = 'Simple Machines Forum 2.x';
$localstr['step4desc_wbb'] = 'WoltLab Burning Board Lite 1.x.x';
$localstr['step4desc_xoops'] = 'XOOPS';
$localstr['step4unkownauth'] = '(om du är osäker, vänligen välj "IAHS")';
$localstr['step4chooseauth'] = 'Vänligen välj ett autentisering sätt.';

//--------------------------
// Auth.
//--------------------------
$localstr['step5failconWRM'] = 'Uppkoppling till WRM DB misslyckades';
$localstr['step5selctusername'] = 'Sätt fulla rättigheter till det valda Användarnamnet';
$localstr['step5sub1follval'] = 'Vänligen fyll i följande värden för att kunna fullfölja installationen';
$localstr['step5done'] = 'klart';
$localstr['step5sub2usernamefullperm'] = 'Välj det användarnamn som kommer att få full rättigheter till wowRaidManager';
$localstr['step5sub3norest'] = 'Inga Restriktioner';
$localstr['step5sub3noaddus'] = 'Inga Ytterliggare Användargrupper';
$localstr['step5sub2failfindfile'] = 'Misslyckades med att hitta konfigurationsfilen:';
$localstr['step5sub2checkdir'] = 'verifiera foldern/sökvägen igen';
$localstr['step5sub3group01'] = 'Välj grund gruppen/klassen som har tillgång attnyttja WRM';
$localstr['step5sub3group02'] = 'Alla användare utan denna grupp kommer inte atttillåtas logga in';
$localstr['step5sub3group03'] = 'Vänligen völj "Inga Restriktioner" här om du vill att alla användare oavsett grupp/klass skall kunna logga in och nyttja WRM';
$localstr['step5sub3altgroup01'] = 'Välj en alternativ grupp/klass som kan nyttja WRM';
$localstr['step5sub3altgroup02'] = 'Alla användare i denna grupp kommer att tillåtas att logga in, oavsett om de är i ovanstående grupp/klass eller inte';

// phpBB
$localstr['step5phpBBdesc'] = 'phpBB';
$localstr['step5phpBBsub1desc'] = 'Du har valt phpBB autentisering';
$localstr['step5phpBBsub1inputdir'] = 'Skriv in den relativa sökvägen till din phpBB folder (inkluderat det efterföljande snedstrecket!)';
$localstr['step5phpBBsub2failincdir'] = 'din phpBB folder är felaktig';
$localstr['step5phpBBsub2failfindautfile'] = 'Misslyckades med att hitta "../auth/auth_phpbb3.php" konfiguationsfilen';
$localstr['step5phpBBsub2faildownautfile'] = 'vänligen ladda ner (från WRM-hemsidan) och kopiera till "/auth".';
$localstr['step5phpBBsub2founddb'] = 'phpBB DB funnen';
$localstr['step5phpBBsub2readconffile'] = 'phpBB konfigurationsfil läst';
$localstr['step5phpBBsub3errorretusergroup'] = 'Fel vid hämtning av användargrupp från phpBB3';
$localstr['step5phpBBsub3errorretusername'] = 'Fel vid hämtning av användarnamn från phpBB3';
$localstr['step5phpBBsub4wantimport'] = 'vill du importera alla användare från phpBB Forumet';
$localstr['step5phpBBsub4srynotsupport'] = 'FÖRLÅT import från phpBB Forumet: inget stöd för phpBB2';
$localstr['step5phpBBsub5import'] = 'Importera';
$localstr['step5phpBBfailconphpBB'] = 'Uppkoppling till phpBB DB misslyckades';

// e107
$localstr['step5e107desc'] = 'e107';
$localstr['step5e107sub1desc'] = 'Du har valt e107 autentisering';
$localstr['step5e107sub1inputdir'] = 'Skriv in den relativa sökvägen till din e107 folder (inkluderat det efterföljande snedstrecket!)';
$localstr['step5e107sub2failincdir'] = 'din e107 folder är felaktig';
$localstr['step5e107sub2readconffile'] = 'e107 konfigurationsfil läst';
$localstr['step5e107sub3errorretusername'] = 'Fel vid hämtning av användarnamn från e107';
$localstr['step5e107sub3errorretuserclass'] = 'Fel vid hämtning av användarklassfrån e107';
$localstr['step5e107failcone107'] = 'Uppkoppling till e107 DB misslyckades';

// iums = integrated User Management System
$localstr['step5iumsdesc'] = 'Inbyggt Användar Hanterings System';
$localstr['step5iumssub1desc'] = 'Du har valt "Inbyggt Användar Hanterings System" autentisering';
$localstr['step5sub1iumsfilladmindesc'] = 'Allt som kvarstår är att fylla i din information för Super Administratör nedan.';

// Joomla
$localstr['step5joomladesc'] = 'Joomla';
$localstr['step5joomlasub1desc'] = 'You have selected Joomla authentication';
$localstr['step5joomlasub1inputdir'] = 'Input the relative path to your Joomla directory (including trailing slash!)';
$localstr['step5joomlasub2failincdir'] = 'your Joomla directory is incorect';
$localstr['step5joomlasub2readconffile'] = 'read Joomla config file';
$localstr['step5joomlasub3errorretusername'] = 'Error retrieving username from Joomla';
$localstr['step5joomlasub3errorretuserclass'] = 'Error retrieving userclass from Joomla';
$localstr['step5joomlafailconejoomla'] = 'Unable to connect to Joomla DB';

// SMF = Simple Machines Forum
$localstr['step5smfdesc'] = 'SMF';
$localstr['step5smfsub1desc'] = 'Du har valt SMF autentisering';
$localstr['step5smfsub1inputdir'] = 'Skriv in den relativa sökvägen till din SMFfolder (inkluderat det efterföljande snedstrecket!)';
$localstr['step5smfsub2failincdir'] = 'din SMF folder är felaktig';
$localstr['step5smfsub2readconffile'] = 'SMF konfigurationsfil läst';
$localstr['step5smfsub3errorretusername'] = 'Fel vid hämtning av användarnamn från SMF';
$localstr['step5smfsub3errorretuserclass'] = 'Fel vid hämtning av användarklass från SMF';
$localstr['step5smffailconesmf'] = 'Uppkoppling till SMF DB misslyckades';

// WoltLab Burning Board Lite 1.x.x = wbb
$localstr['step5wbbdesc'] = 'WoltLab Burning Board';
$localstr['step5wbbsub1desc'] = 'Du har valt WBB autentisering';
$localstr['step5wbbsub1inputdir'] = 'Skriv in den relativa sökvägen till din wbbfolder (inkluderat det efterföljande snedstrecket!)';
$localstr['step5wbbsub2failincdir'] = 'din WBB folder är felaktig';
$localstr['step5wbbsub2readconffile'] = 'WBB konfigurationsfil läst';
$localstr['step5wbbsub3errorretusername'] = 'Fel vid hämtning av användarnamn från WBB';
$localstr['step5wbbsub3errorretuserclass'] = 'Fel vid hämtning av användarklass från WBB';
$localstr['step5wbbfailconesmf'] = 'Uppkoppling till WBB DB misslyckades';

// XOOPS
$localstr['step5xoopsdesc'] = 'XOOPS';
$localstr['step5xoopssub1desc'] = 'Du har valt XOOPS autentisering';
$localstr['step5xoopssub1inputdir'] = 'Skriv in den relativa sökvägen till din XOOPS folder (inkluderat det efterföljande snedstrecket!)';
$localstr['step5xoopssub2failincdir'] = 'din XOOPS folder är felaktig';
$localstr['step5xoopssub2readconffile'] = 'XOOPS konfigurationsfil läst';
$localstr['step5xoopssub3errorretusername'] = 'Fel vid hämtning av användarnamn från XOOPS';
$localstr['step5xoopssub3errorretuserclass'] = 'Fel vid hämtning av användarklass från from XOOPS';
$localstr['step5xoopsfailconesmf'] = 'Uppkoppling till XOOPS DB misslyckades';

//----------------------------------------------
//step 6
$localstr['stepdonefinished'] = 'Färdigt';
$localstr['stepdonesetupcomplete'] = 'Installationen är nu klar.';
$localstr['stepdoneremovedir'] = 'Se till att ta bort "install/" foldern och klicka sedan <a href="../index.php">här</a> när du har gjort det.';
?>
