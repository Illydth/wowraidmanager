<?php
//
//english install strings
//
global $localstr;
$localstr['headtitle'] = 'Installazione di WRM 3.x.x.';
$localstr['headbodyinfo'] = 'Attenzione: il database sul quale verrà effettuata l\'installazione dev\'essere già esistente.';

//menu
$localstr['InstallationProgress'] = 'Avanzamento dell\'installazione';
$localstr['menustep1init'] = '1. Inizializzazione';
$localstr['menustep2conf'] = '2. Configurazione';
$localstr['menustep3instab'] = '3. Creazione tabelle';
$localstr['menustep4auth'] = '4. Utenti';
$localstr['menustep5confauth'] = '5. Config. Utenti';
$localstr['menustep6final'] = '6. Completamento dell\'installazione';

//botton
$localstr['bd_submit'] = 'Continua';
$localstr['bd_reset'] = 'Reset';

//stuff
$localstr['hittingsubmit'] = 'Verifica la correttezza di tutte le informazioni inserite prima di proseguire!';
$localstr['pressbrowserpack'] = 'Utilizza il pulsante INDIETRO del browser per riprovare.';
$localstr['problem'] ='Problema';
$localstr['txtusername'] = 'Username';
$localstr['txtpassword'] = 'Password';
$localstr['txtemail'] = 'E-mail';
$localstr['txtconfig'] = 'Configurazione';

//step 2
$localstr['step2freshinstall'] = 'Nuova installazione';
$localstr['step2upgradefrom'] = 'Aggiornamento da';
$localstr['step2dbname'] = 'Database MySQL';
$localstr['step2dbserverhostname'] = 'Indirizzo del server MySQL';
$localstr['step2dbserverusername'] = 'Username del server MySQL';
$localstr['step2dbserverpwd'] = 'Password del server MySQL';
$localstr['step2WRMtableprefix'] = 'Prefisso delle tabelle di WRM';
$localstr['step2installtype'] = 'Tipo di installazione';
$localstr['step2error01'] = 'Informazioni errate potrebbero causare errori non prevedibili per i quali non verrà fornita assistenza!';

//step 3
$localstr['step3errordbcon'] = 'Errore di connessione al database.'; 
$localstr['step3errorschema'] = 'Errore durante l\'aggiornamento';
$localstr['step3errorsql'] = 'Errore d\'installazione<br>Query: $sql<br>Riportato: ';
$localstr['step3installinfo'] = 'Tabelle create correttamente!';
$localstr['step3errorversion'] = 'La versione del software in version.php non combacia con la versione del database nella tabella delle versioni.';

//step 4
$localstr['step4auttype'] = 'Tipo di autenticazione';
$localstr['step4desc'] = 'Descrizione';
$localstr['step4desc_e107'] = 'Portale e107';
$localstr['step4desc_phpBB'] = 'phpBB2/phpBB3';
$localstr['step4desc_iums'] = 'Sistema di gestione Utenti integrato';
$localstr['step4desc_smf'] = 'Simple Machines Forum 1.x';
$localstr['step4desc_smf2'] = 'Simple Machines Forum 2.x';
$localstr['step4desc_wbb'] = 'WoltLab Burning Board Lite 1.x.x';
$localstr['step4desc_xoops'] = 'XOOPS';
$localstr['step4unkownauth'] = '(in caso di incertezza, selezionare il sistema di gestione Utenti integrato)';
$localstr['step4chooseauth'] = 'Seleziona uno dei tipi di autenticazione.';

//--------------------------
// Auth.
//--------------------------
$localstr['step5failconWRM'] = 'Impossibile connettersi al database di WRM';
$localstr['step5selctusername'] = 'Assegna pieni permessi allo username selezionato';
$localstr['step5sub1follval'] = 'Per completare l\'installazione, compila i seguenti campi';
$localstr['step5done'] = 'fatto';
$localstr['step5sub2usernamefullperm'] = 'Seleziona a quale username verranno garantiti pieni permessi in WowRaidManager';
$localstr['step5sub3norest'] = 'Nessuna restrizione';
$localstr['step5sub3noaddus'] = 'Nessun altro gruppo';
$localstr['step5sub2failfindfile'] = 'File di configurazione non trovato:';
$localstr['step5sub2checkdir'] = 'controlla nuovamente la cartella';
$localstr['step5sub3group01'] = 'Seleziona il gruppo base di Utenti ai quali consentire l\'accesso a WRM';
$localstr['step5sub3group02'] = 'Gli Utenti al di fuori di questo gruppo non avranno accesso a WRM';
$localstr['step5sub3group03'] = 'Seleziona "Nessuna restrizione" per consentire l\'accesso a WRM a tutti gli Utenti indipendentemente dai gruppi di appartenenza';
$localstr['step5sub3altgroup01'] = 'Seleziona un ulteriore gruppo di Utenti ai quali consentire l\'accesso a WRM';
$localstr['step5sub3altgroup02'] = 'Agli Utenti appartenenti a questo gruppo sarà consentito l\'accesso a WRM indipendentemente dall\'appartenenza anche all\'altro gruppo specificato';

// phpBB
$localstr['step5phpBBdesc'] = 'phpBB';
$localstr['step5phpBBsub1desc'] = 'Hai selezionato l\'autenticazione phpBB';
$localstr['step5phpBBsub1inputdir'] = 'Percorso della cartella base di phpBB (relativo alla cartella di WRM, inclusa la barra finale!)';
$localstr['step5phpBBsub2failincdir'] = 'il percorso della cartella di phpBB è arrato';
$localstr['step5phpBBsub2failfindautfile'] = 'Impossibile trovare il file di configurazione "../auth/auth_phpbb3.php"';
$localstr['step5phpBBsub2faildownautfile'] = 'scaricalo (dal sito ufficiale di WRM) e copialo in "/auth".';
$localstr['step5phpBBsub2founddb'] = 'Trovato il database di phpBB';
$localstr['step5phpBBsub2readconffile'] = 'Lettura del file di configurazione di phpBB';
$localstr['step5phpBBsub3errorretusergroup'] = 'Errore durante la lettura dei gruppi Utenti di phpBB3';
$localstr['step5phpBBsub3errorretusername'] = 'Errore durante la lettura degli username di phpBB3';
$localstr['step5phpBBsub4wantimport'] = 'Vuoi importare tutti gli Utenti di phpBB?';
$localstr['step5phpBBsub4srynotsupport'] = 'Importazione da phpBB2 non supportata';
$localstr['step5phpBBsub5import'] = 'Importa';
$localstr['step5phpBBfailconphpBB'] = 'Impossibile connettersi al database di phpBB';

// e107
$localstr['step5e107desc'] = 'e107';
$localstr['step5e107sub1desc'] = 'Hai selezionato l\'autenticazione e107';
$localstr['step5e107sub1inputdir'] = 'Percorso della cartella base di e107 (relativo alla cartella di WRM, inclusa la barra finale!)';;
$localstr['step5e107sub2failincdir'] = 'il percorso della cartella di e107 è arrato';
$localstr['step5e107sub2readconffile'] = 'Lettura del file di configurazione di e107';
$localstr['step5e107sub3errorretusername'] = 'Errore durante la lettura degli username di e107';
$localstr['step5e107sub3errorretuserclass'] = 'Errore durante la lettura dei gruppi Utenti di e107';
$localstr['step5e107failcone107'] = 'Impossibile connettersi al database di e107';

// iums = integrated User Management System
$localstr['step5iumsdesc'] = 'Sistema di gestione Utenti integrato';
$localstr['step5iumssub1desc'] = 'Hai selezionato l\'autenticazione attraverso il sistema di gestione Utenti integrato';
$localstr['step5sub1iumsfilladmindesc'] = 'Inserisci i dati per il profilo di Super Admin.';

// SMF = Simple Machines Forum
$localstr['step5smfdesc'] = 'Simple Machines Forum (SMF)';
$localstr['step5smfsub1desc'] = 'Hai selezionato l\'autenticazione SMF';
$localstr['step5smfsub1inputdir'] = 'Percorso della cartella base di SMF (relativo alla cartella di WRM, inclusa la barra finale!)';
$localstr['step5smfsub2failincdir'] = 'il percorso della cartella di SMF è arrato';
$localstr['step5smfsub2readconffile'] = 'Lettura del file di configurazione di SMF';
$localstr['step5smfsub3errorretusername'] = 'Errore durante la lettura degli username di SMF';
$localstr['step5smfsub3errorretuserclass'] = 'Errore durante la lettura dei gruppi Utenti di SMF';
$localstr['step5smffailconesmf'] = 'Impossibile connettersi al database di SMF';

// WoltLab Burning Board Lite 1.x.x = wbb
$localstr['step5wbbdesc'] = 'WoltLab Burning Board';
$localstr['step5wbbsub1desc'] = 'Hai selezionato l\'autenticazione WBB';
$localstr['step5wbbsub1inputdir'] = 'Percorso della cartella base di WBB (relativo alla cartella di WRM, inclusa la barra finale!)';
$localstr['step5wbbsub2failincdir'] = 'il percorso della cartella di WBB è arrato';
$localstr['step5wbbsub2readconffile'] = 'Lettura del file di configurazione di WBB';
$localstr['step5wbbsub3errorretusername'] = 'Errore durante la lettura degli username di WBB';
$localstr['step5wbbsub3errorretuserclass'] = 'Errore durante la lettura dei gruppi Utenti di WBB';
$localstr['step5wbbfailconesmf'] = 'Impossibile connettersi al database di WBB';

// XOOPS
$localstr['step5xoopsdesc'] = 'XOOPS';
$localstr['step5xoopssub1desc'] = 'Hai selezionato l\'autenticazione XOOPS';
$localstr['step5xoopssub1inputdir'] = 'Percorso della cartella base di XOOPS (relativo alla cartella di WRM, inclusa la barra finale!)';
$localstr['step5xoopssub2failincdir'] = 'il percorso della cartella di XOOPS è arrato';
$localstr['step5xoopssub2readconffile'] = 'Lettura del file di configurazione di XOOPS';
$localstr['step5xoopssub3errorretusername'] = 'Errore durante la lettura degli username di XOOPS';
$localstr['step5xoopssub3errorretuserclass'] = 'Errore durante la lettura dei gruppi Utenti di XOOPS';
$localstr['step5xoopsfailconesmf'] = 'Impossibile connettersi al database di XOOPS';

//----------------------------------------------
//step 6
$localstr['stepdonefinished'] = 'Finito';
$localstr['stepdonesetupcomplete'] = 'Installazione completata.';
$localstr['stepdoneremovedir'] = 'Rimuovi la cartella "install/" e clicka <a href="../index.php">qui</a> dopo averlo fatto.';
?>
