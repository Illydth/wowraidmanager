<?php
/***************************************************************************
 *                             install.php
 *                            -------------------
 *   begin                : June 15, 2008
 *	 Dev                  : Carsten Hölbing
 *	 email                : hoelbin@gmx.de
 *
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw0@yahoo.com
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
*
****************************************************************************/
	error_reporting(0);

	$stepstr = $_GET['s'];

	//multilanguage stuff
	$lang = $_GET['lang'];

	if ($stepstr == 2){
			$lang = $_POST['classlang_type'];
	}
	if( !is_file('language/locale-'.$lang.'.php'))
		{
			$lang ='english';//en == default language
		}
	require_once('language/locale-'.$lang.'.php');

	// Is Writeable function is bugged beyond belief, it has issues with ACL and Group accesses, use this instead.
	//    will work in despite of Windows ACLs bug.
	//NOTE: use a trailing slash for folders!!!
	//see http://bugs.php.net/bug.php?id=27609
	//see http://bugs.php.net/bug.php?id=30931
	function is__writeable($path)
	{
        // Check for a directory, if the passed path is a directory create a temp file as path
        //    and try to open, otherwise just try to open that file for writing.
        $checkpath = $path;

        if ($path{strlen($path)-1}=='/')
                $checkpath = $path.uniqid(mt_rand()).'.tmp';

        if (!($f = @fopen($checkpath, 'a+')))
                return false;

        fclose($f);
        if ($checkpath != $path)
                unlink($checkpath);
        return true;
	}

	function get_mysql_version_from_phpinfo()
	{
		global $link;

		if (function_exists('mysql_get_server_info')) {
			$gd = mysql_get_server_info($link);
		} else {
			$result = @mysql_query('SELECT version()',$link);
			$gd = @mysql_result($result,0);
			@mysql_free_result($result);
		}
		return $gd;
	}

	//header
	function print_header()
	{
		global $localstr;
		echo '<html>
			  <head><title>'.$localstr['headtitle'].'</title>
			  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
			  <link rel="stylesheet" type="text/css" href="stylesheet/stylesheet.css">
			  </head>
			  <body>
			  <div class="installhead">
			     <table width="500" border="0" align="center" cellspacing="5">
                  <tr>
                    <td><img src="logo_phpRaid.jpg" align="right"></td>
                    <!-- <td><div class="installheadBigtxt">Wow Raid Manager</div></td> -->
                  </tr>
                 </table>
			     <table width="500" border="0" align="center" cellspacing="5">
                  <tr>
					'.$localstr['headtitle'].'<br/>
				    <strong>'.$localstr['headbodyinfo'].'</strong>
                  </tr>
                 </table>
			  </div>
			  <br/>';
	}

	//menu with css-style (stylesheet/stylesheet.css)
	function step($header,$c1,$c2,$c3,$c4,$c5,$c6,$content)
	{
		global $localstr;

		//create menu
		$installnavmenu = '
		<div align="left" class="installnavmenu">
		  <ul>
			<li>'.$localstr['InstallationProgress'].'</li>
			<ul>
				<li><div align="left" style="color:'.$c1.'">'.$localstr['menustep1init'].'</div></li>
				<li><div align="left" style="color:'.$c2.'">'.$localstr['menustep2conf'].'</div></li>
				<li><div align="left" style="color:'.$c3.'">'.$localstr['menustep3instab'].'</div></li>
				<li><div align="left" style="color:'.$c4.'">'.$localstr['menustep4auth'].'</div></li>
				<li><div align="left" style="color:'.$c5.'">'.$localstr['menustep5confauth'].'</div></li>
				<li><div align="left" style="color:'.$c6.'">'.$localstr['menustep6final'].'</div></li>
			</ul>
		  </ul>
		</div>';

		$installmaindiv ='<div class="installmaindiv"><h1>'.$header.'</h1><br/>'.$content.'</div>';

		//create table
		echo '<table width="790" border="0" align="center" cellspacing="3" cellpadding="1"
		 style="font-size:11px; color:#ffffff; border:1px solid #cccccc; background-color:#000000">
			  	<tr valign="top">
					<td width="22%">'.$installnavmenu .'</td>
					<td width="78%" colspan="2" scope="col">'.$installmaindiv .'</td>
			  	</tr>
			   </table>
			   </body>
			   </html>
		';
	}

	print_header();

	//step 0
	if(!isset($_GET['s']))
	{
		$error = 0;
		$content = '<br/>';
		//clearstatcache();
		// initial step<br/>
		// check if file is writeable
		//$content .= '<h1>check if file is writeable</h1><br/>';
		$content .= '<table width="90%" cellpadding="0" cellspacing="0" border="0" align="center">';
		$content .= '<tr>';
		$content .= '  <td width="10%" class="normaltxt"><strong><div align="center">Status</div></strong></td>';
		$content .= '  <td width="40%" class="normaltxt"><strong><div align="center">File</div></strong></td>';
		$content .= '  <td width="50%" class="normaltxt"><strong><div align="center">Description</div></strong></td>';
		$content .= '</tr>';
		$content .= '<tr>';

		// NOTE: BE CAREFUL WITH IS__WRITEABLE, that is NOT the built in is_writeable function. (See Double Underscore)
		if(!is__writeable('../config.php'))
		{
			$error = 1;
			$content .= '<td class="normaltxtred">Error</td>';
			$content .= '<td class="normaltxtred"><strong>config.php</strong></td>';
			$content .= '<td class="normaltxtred">is not writeable by the server.';
			$content .= 'Set proper permissions and try again</td>';
		}
		else
		{
			$content .= '  <td class="normaltxtgreen">Success</td>';
			$content .= '  <td class="normaltxtgreen">config.php</td>';
			$content .= '  <td class="normaltxtgreen">is writeable by the server</td>';
		}
		$content .= '</tr>';
		$content .= '</table>';

		$content .= '<br/><br/>';

		if(!is_dir('./database_schema'))
		{
			$error = 1;
			$content .= '<br/><font color=red>Error: directory <strong>database_schema</strong> does not exist!</font>';
		}
		else
		{
			$content .= '<br/><font color=#00ff00>Success: directory <strong>database_schema</strong> exists.</font>';
		}

		if($error == 0)
		{
				$langtype = '<select name="classlang_type" class="POST">';
				$dir = 'language';
				$dh = opendir($dir);
				while(false != ($filename = readdir($dh))) {
					$files[] = $filename;
				}

				sort($files);
				array_shift($files);
				array_shift($files);
				foreach($files as $key=>$value)
				{
					$value = substr($value, 7);
					$value = str_replace('.php','',$value);
					if ($value == 'english'){
						$langtype .= '<option value="'.$value.'" selected>'.$value.'</option>';
					}
					else {
						$langtype .= '<option value="'.$value.'">'.$value.'</option>';
					}
				}

			$langtype .= '</select>';
			$content .= '<br/><br/><form action="install.php?s=2" method="POST">';
			$content .= '<br/><br/>Select your Language: '.$langtype.'<br/><br/><br/>';
			$content .= '<input type="submit" name="submit" value="'.$localstr['bd_submit'].'" class="mainoption"></form>';
		}

		step($localstr['menustep1init'],'red','white','white','white','white','white',$content);
	}
	else if($stepstr == 2)
	{
		$dir = './database_schema/upgrade';
		$dh = opendir($dir);
		while(false !== ($filename = readdir($dh))) {
			$files[] = $filename;
		}

		sort($files);
		array_shift($files);
		array_shift($files);

		$type = '<select name="type" class="post">';
		$type .= '<option value="install/install.sql" selected>'.$localstr['step2freshinstall'].'</option>';

		foreach($files as $value)
		{
			$type .= "<option value=\"upgrade/$value\">".$localstr['step2upgradefrom']." ".substr($value,0,-4)."</option>";
		}

		$type .= '</select>';

		unset($files);

		// If the config file already exists and has something in it, we'll use it.
		include('../config.php');

		$content = '<form action="install.php?s=3&lang='.$lang.'" method="POST">';
		$content .= '<br/><br/>';
		$content .= '<table width="100%" cellpadding="0" cellspacing="0" border="0">';
		$content .= '<tr><td width="40%" class="normaltxt" align="right">'.$localstr['step2dbname'].':</td><td width="60%">';
		$content .= '<input type="text" name="name" class="post" value="'.$phpraid_config['db_name'].'"></td></tr>';
		$content .= '<tr><td class="normaltxt" align="right">'.$localstr['step2dbserverhostname'].':</td><td>';
		if (!isset($phpraid_config['db_host']))
			$content .= '<input type="text" name="hostname" class="post" value="localhost"></td></tr>';
		else
			$content .= '<input type="text" name="hostname" class="post" value="'.$phpraid_config['db_host'].'"></td></tr>';
		$content .= '<tr><td class="normaltxt" align="right">'.$localstr['step2dbserverusername'].':</td><td>';
		$content .= '<input type="text" name="username" class="post" value="'.$phpraid_config['db_user'].'"></td></tr>';
		$content .= '<tr><td class="normaltxt" align="right">'.$localstr['step2dbserverpwd'].':</td><td>';
		$content .= '<input type="text" name="password" class="post" value="'.$phpraid_config['db_pass'].'"></td></tr>';
		$content .= '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
		$content .= '<tr><td class="normaltxt" align="right">'.$localstr['step2WRMtableprefix'].':</td><td>';
		if (!isset($phpraid_config['db_prefix']))
			$content .= '<input type="text" name="prefix" class="post" value="wrm_"></td></tr>';
		else
			$content .= '<input type="text" name="prefix" class="post" value="'.$phpraid_config['db_prefix'].'"></td></tr>';

		//Insert Hidden boxes at this point to Store any other DB Information Needed from config.php.
		$content .= '<input type="hidden" name="eqdkp_db_name" class="post" value="'.$phpraid_config['eqdkp_db_name'].'"></td></tr>';
		$content .= '<input type="hidden" name="eqdkp_db_host" class="post" value="'.$phpraid_config['eqdkp_db_host'].'"></td></tr>';
		$content .= '<input type="hidden" name="eqdkp_db_user" class="post" value="'.$phpraid_config['eqdkp_db_user'].'"></td></tr>';
		$content .= '<input type="hidden" name="eqdkp_db_pass" class="post" value="'.$phpraid_config['eqdkp_db_pass'].'"></td></tr>';
		$content .= '<input type="hidden" name="eqdkp_db_prefix" class="post" value="'.$phpraid_config['eqdkp_db_prefix'].'"></td></tr>';

		$content .= '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
		$content .= '<tr><td class="normaltxt" align="right">'.$localstr['step2installtype'].': </td><td>';
		$content .= $type.'</td></tr>';
		$content .= '</table>';
		$content .= '<br/><br/><div align="center"class="normaltxt"><strong>'.$localstr['hittingsubmit'].'<br/>';
		$content .= $localstr['step2error01'].'</strong></div>';
		$content .= '<br/><br/><input type="submit" value="'.$localstr['bd_submit'].'" class="mainoption"> ';
		$content .= '<input type="reset" value="'.$localstr['bd_reset'].'" class="mainoption">';
		$content .= '</form>';
		step($localstr['menustep2conf'],'lime','red','white','white','white','white',$content);
	}
	else if($stepstr == 3)
	{
		$name = $_POST['name'];
		$hostname = $_POST['hostname'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$prefix = $_POST['prefix'];
		$eqdkp_name = $_POST['eqdkp_db_name'];
		$eqdkp_host = $_POST['eqdkp_db_host'];
		$eqdkp_user = $_POST['eqdkp_db_user'];
		$eqdkp_pass = $_POST['eqdkp_db_pass'];
		$eqdkp_prefix = $_POST['eqdkp_db_prefix'];

		$sql_file = $_POST['type'];

		$sql = '';

		// database connection
		$link = mysql_connect($hostname, $username, $password);
		if(!$link){
				die('<font color=red>'.$localstr['step3errordbcon'].$localstr['pressbrowserpack'].'</font>');
			}

		include('../version.php');

		// write config file (config.php)
		$output  = "<?php\n";
		$output .= "/*\n";
		$output .= "#**********************************************#\n";
		$output .= "#                                              #\n";
		$output .= "#     auto-generated configuration file        #\n";
		$output .= "#     WoW Raid Manager ".$version."                   #\n";
		$output .= "#     date: ".date("Y-m-d - H:i:s")."              #\n";
		$output .= "#   Do not change anything in this file!       #\n";
		$output .= "#                                              #\n";
		$output .= "#**********************************************#\n";
		$output .= "*/\n\n";
		$output .= "global ".'$phpraid_config'.";\n";
		$output .='$phpraid_config[\'db_name\']'." = '$name';\n".'$phpraid_config[\'db_host\']'." = '$hostname';\n";
		$output .='$phpraid_config[\'db_user\']'." = '$username';\n".'$phpraid_config[\'db_pass\']'." = '$password';\n";
		$output .='$phpraid_config[\'db_prefix\']'." = '$prefix';\n".'$phpraid_config[\'eqdkp_db_name\']'." = '$eqdkp_name';\n";
		$output .='$phpraid_config[\'eqdkp_db_host\']'." = '$eqdkp_host';\n".'$phpraid_config[\'eqdkp_db_user\']'." = '$eqdkp_user';\n";
		$output .='$phpraid_config[\'eqdkp_db_pass\']'." = '$eqdkp_pass';\n".'$phpraid_config[\'eqdkp_db_prefix\']'." = '$eqdkp_prefix';\n";
		$output .= "?>\n";

		$fd = fopen('../config.php','w+');
		fwrite($fd, $output);
		fclose($fd);

		mysql_select_db($name);
		if(!$fd = fopen('./database_schema/'.$sql_file, 'r'))
			die('<font color=red>'.$localstr['step3errorschema'].'.</font>');

		if ($fd) {
			while (!feof($fd)) {
				$line = fgetc($fd);
				$sql .= $line;

				if($line == ';')
				{
			  		$sql = substr(str_replace('`phpraid_','`' . $prefix, $sql), 0, -1);
					mysql_query($sql) or die($localstr['step3errorsql'].' ' . mysql_error());
					$sql = '';
				}
			}
			fclose($fd);
		}

		// Run the alter_tables.sql for setting Character Set and Collation if MySQL version > 4.1.0
		$gd = get_mysql_version_from_phpinfo();
		if (version_compare("4.1.0",$gd) == -1)
		{
			if(!$fd = fopen('./database_schema/install/alter_tables.sql', 'r'))
				die('<font color=red>'.$localstr['step3errorschema'].'.</font>');

			if ($fd) {
				while (!feof($fd)) {
					$line = fgetc($fd);
					$sql .= $line;

					if($line == ';')
					{
				  		$sql = substr(str_replace('`phpraid_','`' . $prefix, $sql), 0, -1);
						mysql_query($sql) or die($localstr['step3errorsql'].' ' . mysql_error());
						$sql = '';
					}
				}
				fclose($fd);
			}
		}

		// Make a Version Check
		$sql = "select max(version_number) from `phpraid_version`";
		$sql = str_replace('`phpraid_', '`' . $prefix, $sql);
		$result = mysql_query($sql) or die($localstr['step3errorsql'].' ' . mysql_error());
		$data = mysql_fetch_assoc($result);

		if($data['max(version_number)'] != $version)
			die('<font color=red>'.$localstr['step3errorversion'].'.</font>');

		$content  = '<font color=#00ff00>'.$localstr['step3installinfo'].'</font>';
		$content .= '<form action="install.php?s=4&lang='.$lang.'" method="POST">';
		$content .= '<br/><br/><input type="submit" value="'.$localstr['bd_submit'].'" class="mainoption"> ';
		$content .= '</form>';

		mysql_close($link);

		step($localstr['menustep3instab'],'lime','lime','red','white','white','white',$content);
	}
	else if($stepstr == 4)
	{
		// authorization types
		$dir = 'auth';
		$dh = opendir($dir);
		while(false != ($filename = readdir($dh))) {
			$files[] = $filename;
		}

		sort($files);
		array_shift($files);
		array_shift($files);
		$auth = '<select name="auth_type" class="post">';

		foreach($files as $key=>$value)
		{
			$value = substr($value, 8);
			$value = str_replace('.php','',$value);
			$auth .= '<option value="'.$value.'">'.$value.'</option>';
		}

		$auth .= '</select>';
		$content = '<table width="400" border="1" align="center">
                          <tr>
                            <td width="130" class="normaltxt"><strong>'.$localstr['step4auttype'].'</strong></td>
                            <td width="270" class="normaltxt"><strong>'.$localstr['step4desc'].'</strong></td>
                          </tr>
                          <tr>
                            <td class="normaltxt">e107</td>
                            <td class="normaltxt">'.$localstr['step4desc_e107'].'</td>
                          </tr>
						  <tr>
                            <td class="normaltxt">iUMS</td>
                            <td class="normaltxt">'.$localstr['step4desc_iums'].'</td>
                          </tr>
                          <tr>
                            <td class="normaltxt">Joomla</td>
                            <td class="normaltxt">'.$localstr['step4desc_phpBB'].'</td>
                          </tr>
                          <tr>
                            <td class="normaltxt">phpBB</td>
                            <td class="normaltxt">'.$localstr['step4desc_phpBB'].'</td>
                          </tr>
						  <tr>
                            <td class="normaltxt">SMF</td>
                            <td class="normaltxt">'.$localstr['step4desc_smf'].'</td>
                          </tr>
						  <tr>
                            <td class="normaltxt">SMF2</td>
                            <td class="normaltxt">'.$localstr['step4desc_smf2'].'</td>
                          </tr>
						  <tr>
                            <td class="normaltxt">WBB</td>
                            <td class="normaltxt">'.$localstr['step4desc_wbb'].'</td>
                          </tr>
                          <tr>
                            <td class="normaltxt">XOOPS</td>
                            <td class="normaltxt">'.$localstr['step4desc_xoops'].'</td>
                          </tr>
                        </table>';

		$content .= '<form action="install.php?s=5&lang='.$lang.'" method="POST">';
		$content .= '<br/><br/>'.$localstr['step4chooseauth'].'<br/>'.$localstr['step4unkownauth'].'<br/><br/>';
		$content .= $auth;
		$content .= '<br/><br/><br/><input type="submit" value="'.$localstr['bd_submit'].'" class="mainoption"> ';
		$content .= '</form>';

		step($localstr['menustep4auth'],'lime','lime','lime','red','white','white',$content);
	}


	else if($stepstr == 5)
	{
		$auth_type = $_POST['auth_type'];

		// get appropriate install file.
		require_once('./auth/install_' . $auth_type . '.php');

		$retval=step5($auth_type); //Calls the installer for the selected auth function.

	}
	else if($stepstr == 'done')
	{
		include ("../config.php");

		//insert default values
		$wrmserver = 'http://'.$_SERVER['SERVER_NAME'];
		$wrmserverfile = str_replace("/install/install.php","",$wrmserver. $_SERVER['PHP_SELF']);;

		$linkWRM = mysql_connect($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass']);
		mysql_select_db($phpraid_config['db_name']);
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix']. "config WHERE config_name = 'header_link'";
		$result =  mysql_query($sql) or die("Error verifying " . mysql_error());
		if((mysql_num_rows($result) == 0))
		{
			$sql = "INSERT INTO " .$phpraid_config['db_prefix'] ."config VALUES ('header_link','$wrmserver')";
			mysql_query($sql) or die("Error inserting " . mysql_error());
			$sql = "INSERT INTO " .$phpraid_config['db_prefix'] ."config VALUES ('rss_site_url', '$wrmserverfile')";
			mysql_query($sql) or die("Error inserting " . mysql_error());
			$sql = "INSERT INTO " .$phpraid_config['db_prefix'] ."config VALUES ('rss_export_url', '$wrmserverfile')";
			mysql_query($sql) or die("Error inserting " . mysql_error());
		}
		else{
			$sql = "UPDATE " .$phpraid_config['db_prefix'] ."config SET config_value='$wrmserver' WHERE config_name='header_link'";
			mysql_query($sql) or die("Error updating header_link in config table. " . mysql_error());
			$sql = "UPDATE " .$phpraid_config['db_prefix'] ."config SET config_value='$wrmserverfile' WHERE config_name='rss_site_url'";
			mysql_query($sql) or die("Error updating header_link in config table. " . mysql_error());
			$sql = "UPDATE " .$phpraid_config['db_prefix'] ."config SET config_value='$wrmserverfile' WHERE config_name='rss_export_url'";
			mysql_query($sql) or die("Error updating header_link in config table. " . mysql_error());
		}
		mysql_close($linkWRM);

		$content  = '<br/><br/>';
		$content .= $localstr['stepdonesetupcomplete'].'<br/>';
		$content .= $localstr['stepdoneremovedir'];
		$content .= '<br/><br/><br/><br/><br/>';

		step($localstr['stepdonefinished'].'!','lime','lime','lime','lime','lime','red',$content);
	}
?>