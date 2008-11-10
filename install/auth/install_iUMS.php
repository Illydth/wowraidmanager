<?php
/***************************************************************************
 *                             auth_xoops.php
 *                            -------------------
 *   begin                : June 18, 2008
 *	 Dev                  : Carsten Hölbing
 *	 email                : hoelbin@gmx.de
 *
 *	 based on 			  : install_phpraid.php @ Douglas Wagner
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw0@yahoo.com
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

 /**************************************************************************
  *
  *   The functions in this file serve the installer to specifically configure
  * 	the WRM system for WRM's default authentication system.
  *
  *   this functions below have a specific use as laid out:
  *
  *   ---step5----
  *   substep 0 - ..
  *		 - This function retrieves any system specific information that
  * 		may be needed by the installer or system later in the process.
  * 		Things like getting the base directory for the master CMS system,
  * 		getting the default admin user, or setting the table prefix for
  * 		the CMS system would be examples of information obtained here.
  *
  *   substep 'done'
  *		  - This function completes processing for the installer.  Typically
  * 		this function takes the information provided in step5 above and
  * 		processes it in some way.  Generally this means storing the various
  * 		configuration options into the config table or other processing.
  * 		NOTE: It is VASTLY important to include a piece to set the default
  * 		authentication system in the config table.  Without doing this the
  * 		system will default to WRM authentication and what you expect
  * 		to happen probably won't.  Make sure that you are updating/inserting
  * 		auth_type for the authentication type you selected in step 4.
  *
  *****************************************************************************/


function step5($auth_type)
{
	//multilanguage stuff
	$lang = $_GET['lang'];
	
	if( !is_file('language/locale-'.$lang.'.php')) 
		{
			$lang ='english';//en == default language
		}
	require_once('./language/locale-'.$lang.'.php');
	
	global $localstr;
	
	require_once('../config.php');

	$step5_substep = $_POST['substep'];

	if ($step5_substep == "")
	{
		$content  = '<br>';
		$content .=  $localstr['step5iumssub1desc'].'.<br>';
		$content .=  $localstr['step5sub1iumsfilladmindesc'].'.<br>';
		$content .= '<br>------------------------------------------------------------------<br><br>';
		$content .= '<form action="install.php?s=5&lang='.$lang.'" method="POST">';
		$content .= '<input type="hidden" name="auth_type" value="' . $auth_type . '" class="post">';
		$content .= '<input type="hidden" name="substep" value="done" class="post">';
		$content .= '<br><br>';
		$content .= '<table width="400" border="0" align="center" cellspacing="5">
                          <tr>
                            <td width="150" class="normaltxt"><div align="right">'.$localstr['txtusername'].':</div></td>
                            <td width="250" class="normaltxt">
							  <input type="text" name="iums_useradmin_name" size="20" class="post" value="">
							 </td>
                          </tr>
                          <tr>
                            <td class="normaltxt"><div align="right">'.$localstr['txtpassword'].':</div></td>
                            <td class="normaltxt">
							  <input type="text" name="iums_useradmin_password" size="20" class="post" value="">
							</td>
                          </tr>
                          <tr>
                            <td class="normaltxt"><div align="right">'.$localstr['txtemail'].':</div></td>
                            <td class="normaltxt">
							  <input type="text" name="iums_useradmin_email" size="40" class="post" value="">
							</td>
                          </tr>
                          <tr>
                        </table>';
		$content .= '<br><br><br>';
		$content .= '<br>------------------------------------------------------------------<br>';	
		$content .= $localstr['hittingsubmit'].'<br>';
		$content .= $localstr['step2error01'].'<br><br>';
		$content .= '<input type="submit" value="'.$localstr['bd_submit'].'" name="submit" class="post">  ';
		$content .= '<input type="reset" value="'.$localstr['bd_reset'].'" class="mainoption">';
		$content .= '</form>';

	}
	else if ($step5_substep == "done")
	{
		$iums_useradmin_name = $_POST['iums_useradmin_name'];
		$iums_useradmin_password = md5($_POST['iums_useradmin_password']);
		$iums_useradmin_email = $_POST['iums_useradmin_email'];
		
		$linkWRM = mysql_connect($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass']);
		if (!$linkWRM) {
			echo '<font color=red>'.$localstr['step5failconWRM'].'<br>';
			echo $localstr['problem']. mysql_error().'<br>';
			echo $localstr['pressbrowserpack'].'</font>';
			exit;
		}

		mysql_select_db($phpraid_config['db_name']);
	
		$sql = printf("SELECT username FROM " . $phpraid_config['db_prefix']. "profile WHERE username = %s", quote_smart($iums_useradmin_name));
		
		$result = mysql_query($sql) or die("Error verifying " . mysql_error());
		$sqlresultdata = mysql_fetch_assoc($result);
		
		if((mysql_num_rows($result) == 0))
		{
			$sql = printf("INSERT INTO " . $phpraid_config['db_prefix'] . "profile ( `username`, `email`,`password`, `priv`) VALUES(%s,%s,%s,'1')", quote_smart($iums_useradmin_name), quote_smart($iums_useradmin_email), quote_smart($iums_useradmin_password));
			$result = mysql_query($sql) or die("Error inserting " . mysql_error());
		}
		else
		{
			$sql = printf("UPDATE " . $phpraid_config['db_prefix'] . "profile SET priv='1' WHERE username=%s", quote_smart($iums_useradmin_name));
			mysql_query($sql)or die("Error updating " . mysql_error());
		}
	
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "config WHERE config_name='auth_type'";
		$result = mysql_query($sql) or die("BOO2: ". mysql_error());
		if(mysql_num_rows($result) > 0)
		{

			$sql = "UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value='iums' WHERE config_name='auth_type'";
			mysql_query($sql) or die("Error updateing auth_type in config table. " . mysql_error());
		}else{
			$sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('auth_type','iums')";
			mysql_query($sql);
		}
		
		mysql_close($linkWRM);
		
		$content = '<br><br>';
		$content .= '<br>------------------------------------------------------------------<br><br>';	
		$content .= '<form action="install.php?s=done&lang='.$lang.'" method="POST">';
		$content .= '<input type="hidden" name="auth_type" value="' . $auth_type . '" class="post">';
		$content .= '<input type="hidden" name="substep" value="done" class="post">';

		$content .= $localstr['step5iumsdesc'] .' '. $localstr['txtconfig'];
		$content .= ': <font color=green>'.$localstr['step5done'].'</font><br><br>';
		$content .= '<input type="submit" value="'.$localstr['bd_submit'].'" name="submit" class="post"></form>';

	}

	step($localstr['menustep5confauth'].' ('.$localstr['step5iumsdesc'].')','lime','lime','lime','lime','red','white',$content);
}


?>