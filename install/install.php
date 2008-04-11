<?php
	error_reporting(0);

	function print_header()
	{
		echo '<html><head><title>Welcome to the phpRaid 3.x.x Installation</title>
			  <link rel="stylesheet" type="text/css" href="../templates/SpiffyJr/style/stylesheet.css">
			  </head><body><div align="center"><div id="content" style="color:ffffff; font-size:11px;">
			  <div id="contentBody"><img src="logo_phpRaid.gif"><br><br>Welcome to the phpRaid 3.x.x Installation</div><br>
			  <div id="contentBody">Thank you for choosing phpRaid. In order to complete this install please fill
			  out the details requested below. <br><strong>Please note that the database you install into should already exist.</strong></div><br>';
	}

	function step($header,$c1,$c2,$c3,$c4,$c5,$content)
	{
			echo '<table width="850" border="0" cellspacing="3" cellpadding="1" style="font-size:11px; color:#ffffff; border:1px solid #cccccc; background-color:#000000">
			  <tr valign="top">
				<td width="25%"><div align="left">Installation Progress</div></td>
				<td width="75%" colspan="2" scope="col"><div align="left">'.$header.'</div></td>
			  </tr>
			  <tr valign="top">
				<td width="25%" scope="col"><div align="left"></div></td>
				<td colspan="2" rowspan="7" scope="col">
					'.$content.'
				</td>
			  </tr>
			   <tr valign="top">
				<td width="25%" scope="col"><div align="left" style="color:'.$c1.'">1. Initialization</div></td>
			  </tr>
			  <tr valign="top">
				<td width="25%" scope="col"><div align="left" style="color:'.$c2.'">2. Configuration</div></td>
			  </tr>
			  <tr valign="top">
				<td width="25%" scope="col"><div align="left" style="color:'.$c3.'">3. Install Tables</div></td>
			  </tr>
			  <tr valign="top">
				<td width="25%" scope="col"><div align="left" style="color:'.$c4.'">4. Authorization</div></td>
			  </tr>
			  <tr valign="top">
				<td width="25%" scope="col"><div align="left" style="color:'.$c5.'">5. Finalize</div></td>
			  </tr>
			  <tr valign="top">
				<td width="25%" scope="col"><div align="left"></div></td>
			  </tr>
			</table>';
	}

	print_header();

	if(!isset($_GET['s']))
	{
		$error = 0;

		// initial step
		// check if config is writeable
		if(!is_writeable('../config.php'))
		{
			$error = 1;
			$content = '<font color=red>Error: <strong>config.php</strong> is not writeable by the server. Set proper permissions and try again.';
		}
		else
		{
			$content = '<font color=#00ff00>Success: <strong>config.php</strong> is writeable by the server.</font>';
		}

		if(!is_dir('./database_schema'))
		{
			$error = 1;
			$content .= '<br><font color=red>Error: directory <strong>database_schema</strong> does not exist!</font>';
		}
		else
		{
			$content .= '<br><font color=#00ff00>Success: directory <strong>database_schema</strong> exists.</font>';
		}

		if($error == 0)
		{
			$content .= '<br><form action="install.php?s=2" method="POST"><input type="submit" name="submit" value="Continue" class="mainoption"></form>';
		}

		step('Step 1: Initialization','red','white','white','white','white',$content);
	}
	else if($_GET['s'] == 2)
	{
		$dir = './database_schema/upgrade';
		$dh = opendir($dir);
		while(false != ($filename = readdir($dh))) {
			$files[] = $filename;
		}

		sort($files);
		array_shift($files);
		array_shift($files);

		$type = '<select name="type" class="post"><option value="install/install.sql" selected>Fresh Install</option>';

		foreach($files as $value)
		{
			$type .= "<option value=\"upgrade/$value\">Upgrade from ".substr($value,0,-4)."</option>";
		}

		$type .= '</select>';

		unset($files);

		$content = '<form action="install.php?s=3" method="POST">';
		$content .= '<table width="100%" cellpadding="0" cellspacing="0" border="0">';
		$content .= '<tr><td width="40%"><div align="right" style="font-size:11px; color:white">Database Name:</td><td width="60%"><input type="text" name="name" class="post"></td></tr>';
		$content .= '<tr><td><div align="right" style="font-size:11px; color:white">Database Server Hostname:</td><td><input type="text" name="hostname" class="post" value="localhost"></td></tr>';
		$content .= '<tr><td><div align="right" style="font-size:11px; color:white">Database Server Username:</td><td><input type="text" name="username" class="post"></td></tr>';
		$content .= '<tr><td><div align="right" style="font-size:11px; color:white">Database Server Password:</td><td><input type="text" name="password" class="post"></td></tr>';
		$content .= '<tr><td><div align="right" style="font-size:11px; color:white">phpRaid Table Prefix:</td><td><input type="text" name="prefix" class="post" value="phpraid_"></td></tr>';
		$content .= '<tr><td><div align="right" style="font-size:11px; color:white">Install Type: </td><td>'.$type.'</td></tr>';
		$content .= '</table>';
		$content .= '<br><br><div align="center"><strong>Please verify all information before hitting submit! Failure to do so could cause unforseen failure and support will not be given!</strong>';
		$content .= '<br><br><input type="submit" value="continue" class="mainoption">';
		step('Step 2: Configuration','lime','red','white','white','white',$content);
	}
	else if($_GET['s'] == 3)
	{
		$name = $_POST['name'];
		$hostname = $_POST['hostname'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$prefix = $_POST['prefix'];
		$sql_file = $_POST['type'];

		$sql = '';

		// config file
		$output = "<?php\nglobal ".'$phpraid_config'.";\n".'$phpraid_config[\'db_name\']'." = '$name';\n".'$phpraid_config[\'db_host\']'." = '$hostname';\n".'$phpraid_config[\'db_user\']'." = '$username';\n".'$phpraid_config[\'db_pass\']'." = '$password';\n".'$phpraid_config[\'db_prefix\']'." = '$prefix';\n?>";

		$fd = fopen('../config.php','w+');
		fwrite($fd, $output);
		fclose($fd);

		// database connection
		if(!($link = mysql_connect($hostname, $username, $password)))
			die("<font color=red>Error connecting to database. Press your browsers BACK button to try again.</font>");

		mysql_select_db($name);
		if(!$fd = fopen('./database_schema/'.$sql_file, 'r'))
			die("<font color=red>Error opening upgrade schema.");

		if ($fd) {
			while (!feof($fd)) {
				$line = fgetc($fd);
				$sql .= $line;

				if($line == ';')
				{
			  		$sql = substr(str_replace('`phpraid_','`' . $prefix, $sql), 0, -1);
					mysql_query($sql) or die("Error installing<br>Query: $sql<br>Reported: " . mysql_error());
					$sql = '';
				}
			}
			fclose($fd);
		}

		$content = '<font color=#00ff00>If you are seeing this then no errors occured during table installation!</font>';
		$content .= '<br><br><form action="install.php?s=4" method="POST"><input type="submit" value="Continue" name="submit" class="post"></form>';

		mysql_close($link);

		step('Step 3: Install Tables','lime','lime','red','white','white',$content);
	}
	else if($_GET['s'] == 4)
	{
		// authorization types
		$dir = '../auth';
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
			$value = substr($value, 5);
			$value = str_replace('.php','',$value);
			$auth .= "<option value=\"$value\">$value</option>";
		}

		$auth .= '</select>';

		$content = 'Please choose an authorization type. If you need more information determining which authorization is best for you please refer to the documentation at <a href="http://www.spiffyjr.com/phpraid_documentat.php">http://www.spiffyjr.com/phpraid_documentation.php</a>.';
		$content .= '<br><br><form action="install.php?s=5" method="POST">'.$auth.' <input type="submit" value="Continue" name="submit" class="post"></form>';
		step('Step 4: Authorization Setup','lime','lime','lime','red','white',$content);
	}

	// From here down (step 5 and finish) the functionality is handled by each of the respective install files for each authentication
	//   system.  The code below is generic to all auth systems.  Please see install/auth/install_xxx.php files for the code that is
	//   executed below.

	else if($_GET['s'] == 5)
	{
		$auth_type = $_POST['auth_type'];

		// get appropriate install file.
		require_once('./auth/install_' . $auth_type . '.php');

		$retval=step5($auth_type); //Calls the installer for the selected auth function.

	}
	else if($_GET['s'] == 'done')
	{
		$auth_type = $_POST['auth_type'];

		// get appropriate install file.
		require_once('./auth/install_' . $auth_type . '.php');

		$retval=done($auth_type); //Calls the installer for the selected auth function.
	}
?>