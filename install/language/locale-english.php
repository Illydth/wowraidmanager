<?php
//
//english install strings
//
global $localstr;
$localstr['headtitle'] = 'Welcome to the WRM 3.x.x Installation.';
$localstr['headbodyinfo'] = 'Please note that the database you install into should already exist.';

//menu
$localstr['InstallationProgress'] = 'Installation Progress';
$localstr['menustep1init'] = '1. Initialization';
$localstr['menustep2conf'] = '2. Configuration';
$localstr['menustep3instab'] = '3. Install Tables';
$localstr['menustep4auth'] = '4. Authorization';
$localstr['menustep5confauth'] = '5. conf. Authorization';
$localstr['menustep6final'] = '6. Finalize';

//botton
$localstr['bd_submit'] = 'Continue';
$localstr['bd_reset'] = 'Reset';

//stuff
$localstr['hittingsubmit'] = 'Please verify all information before hitting submit!';
$localstr['pressbrowserpack'] ='Press your browsers BACK button to try again.';
$localstr['problem'] ='Problem';
$localstr['txtusername'] = 'Username';
$localstr['txtpassword'] = 'Password';
$localstr['txtemail'] = 'E-mail';
$localstr['txtconfig'] = 'config';

//step 2
$localstr['step2freshinstall'] = 'Fresh Install';
$localstr['step2upgradefrom'] = 'Upgrade to';
$localstr['step2dbname'] = 'MySQL Database';
$localstr['step2dbserverhostname'] = 'MySQL Hostname';
$localstr['step2dbserverusername'] = 'MySQL Server Username';
$localstr['step2dbserverpwd'] = 'MySQL Server Password';
$localstr['step2WRMtableprefix'] = 'WRM Table Prefix';
$localstr['step2installtype'] = 'Install Type';
$localstr['step2error01'] = 'Failure to do so could cause unforeseen failure and support will not be given!';

//step 3
$localstr['step3errordbcon'] = 'Error connecting to database.'; 
$localstr['step3errorschema'] = 'Error opening upgrade schema';
$localstr['step3errorsql'] = 'Error installing<br>Query: $sql<br>Reported: ';
$localstr['step3installinfo'] = 'If you are seeing this then no errors occurred during table installation!';
$localstr['step3errorversion'] = 'The software version in version.php doesn\'t match database version in version table.';

//step 4
$localstr['step4auttype'] = 'authorization type';
$localstr['step4desc'] = 'Description';
$localstr['step4desc_e107'] = 'e107 CMS System';
$localstr['step4desc_phpBB'] = 'phpBB2 or phpBB3';
$localstr['step4desc_iums'] = 'integrated User Management System';
$localstr['step4desc_smf'] = 'Simple Machines Forum 1.x';
$localstr['step4desc_smf2'] = 'Simple Machines Forum 2.x';
$localstr['step4desc_wbb'] = 'WoltLab Burning Board Lite 1.x.x';
$localstr['step4desc_xoops'] = 'XOOPS';
$localstr['step4unkownauth'] = '(if you are not sure, please select "iUMS")';
$localstr['step4chooseauth'] = 'Please choose an authorization type.';

//--------------------------
// Auth.
//--------------------------
$localstr['step5failconWRM'] = 'Unable to connect to WRM DB';
$localstr['step5selctusername'] = 'set full permissions to selected Username';
$localstr['step5sub1follval'] = 'In order to complete the installation please fill in the following values';
$localstr['step5done'] = 'done';
$localstr['step5sub2usernamefullperm'] = 'Select the username will be given full wowRaidManager permissions';
$localstr['step5sub3norest'] = 'No Restrictions';
$localstr['step5sub3noaddus'] = 'No Additional UserGroup';
$localstr['step5sub2failfindfile'] = 'Failed to find config file:';
$localstr['step5sub2checkdir'] = 'check the directory again';
$localstr['step5sub3group01'] = 'Select the base user group/class that has access to use WRM';
$localstr['step5sub3group02'] = 'Any user without this group set will not be allowed to log in';
$localstr['step5sub3group03'] = 'Please select "No Restrictios" here if you want all users regardless of group/class to be able to login to WRM';
$localstr['step5sub3altgroup01'] = 'Select an alternate user group/class that can access WRM';
$localstr['step5sub3altgroup02'] = 'Any user tagged with this group will be allowed to log in regardless of whether they are in the above user group/class or not';

// phpBB
$localstr['step5phpBBdesc'] = 'phpBB';
$localstr['step5phpBBsub1desc'] = 'You have selected phpBB authentication';
$localstr['step5phpBBsub1inputdir'] = 'Input the path to your phpBB directory (including trailing slash!)';
$localstr['step5phpBBsub2failincdir'] = 'your phpBB directory is incorect';
$localstr['step5phpBBsub2failfindautfile'] = 'Failed to find "../auth/auth_phpbb3.php" config file';
$localstr['step5phpBBsub2faildownautfile'] = 'please download (from WRM-Homepage) and copy to "/auth".';
$localstr['step5phpBBsub2founddb'] = 'found phpBB DB';
$localstr['step5phpBBsub2readconffile'] = 'read phpBB config file';
$localstr['step5phpBBsub3errorretusergroup'] = 'Error retrieving usergroup from phpBB3';
$localstr['step5phpBBsub3errorretusername'] = 'Error retrieving username from phpBB3';
$localstr['step5phpBBsub4wantimport'] = 'Do you want to import all users from your phpBB Forum?';
$localstr['step5phpBBsub4srynotsupport'] = 'Import from phpBB Forum/Board: not supported with phpBB2';
$localstr['step5phpBBsub5import'] = 'Import';
$localstr['step5phpBBfailconphpBB'] = 'Unable to connect to phpBB DB';

// e107
$localstr['step5e107desc'] = 'e107';
$localstr['step5e107sub1desc'] = 'You have selected e107 authentication';
$localstr['step5e107sub1inputdir'] = 'Input the relative path to your e107 directory (including trailing slash!)';
$localstr['step5e107sub2failincdir'] = 'your e107 directory is incorect';
$localstr['step5e107sub2readconffile'] = 'read e107 config file';
$localstr['step5e107sub3errorretusername'] = 'Error retrieving username from e107';
$localstr['step5e107sub3errorretuserclass'] = 'Error retrieving userclass from e107';
$localstr['step5e107failcone107'] = 'Unable to connect to e107 DB';

// iums = integrated User Management System
$localstr['step5iumsdesc'] = 'integrated User Management System';
$localstr['step5iumssub1desc'] = 'You have selected "integrated User Management System" authentication';
$localstr['step5sub1iumsfilladmindesc'] = 'All that is left is to enter your Super Administrator information by filling out the information below.';

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
$localstr['step5smfsub1desc'] = 'You have selected SMF authentication';
$localstr['step5smfsub1inputdir'] = 'Input the relative path to your SMF directory (including trailing slash!)';
$localstr['step5smfsub2failincdir'] = 'your SMF directory is incorect';
$localstr['step5smfsub2readconffile'] = 'read SMF config file';
$localstr['step5smfsub3errorretusername'] = 'Error retrieving username from SMF';
$localstr['step5smfsub3errorretuserclass'] = 'Error retrieving userclass from SMF';
$localstr['step5smffailconesmf'] = 'Unable to connect to SMF DB';

// WoltLab Burning Board Lite 1.x.x = wbb
$localstr['step5wbbdesc'] = 'WoltLab Burning Board';
$localstr['step5wbbsub1desc'] = 'You have selected wbb authentication';
$localstr['step5wbbsub1inputdir'] = 'Input the relative path to your wbb directory (including trailing slash!)';
$localstr['step5wbbsub2failincdir'] = 'your wbb directory is incorect';
$localstr['step5wbbsub2readconffile'] = 'read wbb config file';
$localstr['step5wbbsub3errorretusername'] = 'Error retrieving username from wbb';
$localstr['step5wbbsub3errorretuserclass'] = 'Error retrieving userclass from wbb';
$localstr['step5wbbfailconesmf'] = 'Unable to connect to wbb DB';

// XOOPS
$localstr['step5xoopsdesc'] = 'XOOPS';
$localstr['step5xoopssub1desc'] = 'You have selected XOOPS authentication';
$localstr['step5xoopssub1inputdir'] = 'Input the relative path to your XOOPS directory (including trailing slash!)';
$localstr['step5xoopssub2failincdir'] = 'your XOOPS directory is incorect';
$localstr['step5xoopssub2readconffile'] = 'read XOOPS config file';
$localstr['step5xoopssub3errorretusername'] = 'Error retrieving username from XOOPS';
$localstr['step5xoopssub3errorretuserclass'] = 'Error retrieving userclass from XOOPS';
$localstr['step5xoopsfailconesmf'] = 'Unable to connect to XOOPS DB';

//----------------------------------------------
//step 6
$localstr['stepdonefinished'] = 'Finished';
$localstr['stepdonesetupcomplete'] = 'Setup is now complete.';
$localstr['stepdoneremovedir'] = 'Be sure to remove the "install/" directory and click <a href="../index.php">here</a> when you have done so.';
?>
