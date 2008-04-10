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
	else if($_GET['s'] == 5)
	{
		$auth_type = $_POST['auth_type'];
		
		if($auth_type == 'phpbb')
		{
			$content = 'You have selected phpBB authentication. In order to complete the installation please fill in the following values.<br><br>
						<br>';
						
						$content .= '<form action="install.php?s=done_phpbb" method="POST">';
						$content .= 'Fill in your phpBB username. This username will be given full phpRaid permissions!<br><br>';
						$content .= '<input type="text" name="username" size="20" class="post"><br><br>';
						$content .= 'For verification purposes, enter the e-mail address associated with above account.<br><br>';
						$content .= '<input type="text" name="email" size="20" class="post"><br><br>';
						$content .= 'Input the relative path to your phpBB directory (including trailing slash!)<br><br>';
						$content .= '<input type="text" name="phpbb_root_path" size="20" class="post" value="../phpBB2/"><br><br>';
						$content .= 'Finally, input the prefix to your phpBB tables<br><br>';
						$content .= '<input type="text" name="phpbb_prefix" size="20" class="post" value="phpbb_"><br><br>';
						$content .= 'Verify the above information before hitting submit!<br><br>';
						$content .= '<input type="submit" value="Submit" name="submit" class="post"></form>';
		}
		else if($auth_type = 'phpraid')
		{
			require_once('../config.php');
			
			// if profile information exists no need to recreate superuser or modify database
			$link = mysql_connect($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass']);
			mysql_select_db($phpraid_config['db_name']);
			
			// force update of auth_type
			$sql = "UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value='phpraid' WHERE config_name='auth_type'";
			mysql_query($sql);
			
			// set new permission type 
			$sql = "UPDATE " . $phpraid_config['db_prefix'] . "profile SET priv='1' WHERE priv='superadmin'";
			mysql_query($sql);
			
			$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "profile";
			$result = mysql_query($sql) or die("boooooo");
			
			if(mysql_num_rows($result) > 0)
				$exit = 1;
			
			if($exit == 1)
			{
				mysql_close($link);
				$content = 'Setup is now complete. Be sure to remove the install/ directory and click <a href="../index.php">here</a> when you have done so.';
		
				step('Finished!','lime','lime','lime','lime','lime',$content);
				exit;
			}
			
			$content = 'You have selected phpRaid authentcation. All that is left is to enter your Super Administrator information by filling out the information below.<br><br>';
			$content .= '<form action="install.php?s=done_phpraid" method="POST">';
			$content .= '<table width="100%" cellpadding="0" cellspacing="0" border="0">';
			$content .= '<tr><td width="25%"><div align="right" style="font-size:11px; color:white">Username:</td><td width="75%"><input type="text" name="username" class="post"></td></tr>';
			$content .= '<tr><td><div align="right" style="font-size:11px; color:white">Password:</td><td><input type="text" name="password" class="post"></td></tr>';
			$content .= '<tr><td><div align="right" style="font-size:11px; color:white">E-mail:</td><td><input type="text" name="email" class="post"></td></tr>';
			$content .= '</table>';
			$content .= '<br><br><div align="center"><strong>Please verify all information before hitting submit! Failure to do so could cause unforseen failure and support will not be given!</strong>';
			$content .= '<br><br><input type="submit" value="continue" class="mainoption">';
		}
		step('Step 5: Finalize','lime','lime','lime','lime','red',$content);
	}
	else if($_GET['s'] == 'done_phpbb')
	{
		$username = $_POST['username'];
		$phpbb_root_path = $_POST['phpbb_root_path'];
		$phpbb_prefix = $_POST['phpbb_prefix'];
		$email = $_POST['email'];

		// check for valid entry of previous form
		if(!is_file('../'.$phpbb_root_path.'config.php'))
		{
			echo '<font color=red>Failed to find phpBB config file.<br> Use your browsers BACK button and input proper data.</font>';
			exit;
		}
		
		require('../'.$phpbb_root_path.'config.php');
		
		// now that we have phpBB information connect to database and verify user
		$link = mysql_connect($dbhost,$dbuser,$dbpasswd);
		mysql_select_db($dbname);

		$sql = "SELECT * FROM " . $phpbb_prefix . "users WHERE username='$username' AND user_email='$email'";
		$result = mysql_query($sql) or die(mysql_error());

		if(mysql_num_rows($result) == 0)
		{
			// they did something wrong, let them know
			echo '<font color=red>Failed to find user in phpBB tables with username and email specified.<br>Use your browsers BACK button to input proper data.</font>';
			mysql_close($link);
			exit;
		}
		
		// CHECK, grab necessary values
		$data = mysql_fetch_array($result);

		$username = $data['username'];
		$email = $data['user_email'];
		$profile_id = $data['user_id'];
		$priv = 1;
		
		mysql_close($link);
		
		require_once('../config.php');

		// insert the super group or update if it exists already
		$link = mysql_connect($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass']);
		mysql_select_db($phpraid_config['db_name']);
		
		// verified user, might as well throw him in profile now if they don't already exist
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "profile WHERE username='$username'";
		$result = mysql_query($sql) or die("Error verifying " . mysql_error());

		if(mysql_num_rows($result) == 0)
		{
			$sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "profile (`profile_id`, `username`, `email`, `priv`) VALUES('$profile_id','$username','$email','1')";
			$result = mysql_query($sql) or die("Error inserting " . mysql_error());
		}
		else
		{
			$sql = "UPDATE " . $phpraid_config['db_prefix'] . "profile SET priv='1' WHERE username='$username'";
			mysql_query($sql);
		}
		
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "config WHERE config_name='phpbb_root_path'";
		$result = mysql_query($sql) or die("BOO2");

		if(mysql_num_rows($result) > 0)
		{
			// update
			$sql = "UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value='$phpbb_root_path' WHERE config_name='phpbb_root_path'";
			mysql_query($sql) or die("BOO3");
			$sql = "UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value='$phpbb_prefix' WHERE config_name='phpbb_prefix'";
			mysql_query($sql) or die("BOO4");
			$sql = "UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value='phpbb' WHERE config_name='auth_type'";
			mysql_query($sql) or die("BOO4");
		}
		else
		{
			// install
			$sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('auth_type','phpbb')";
			mysql_query($sql);
			$sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('phpbb_root_path','$phpbb_root_path')";
			mysql_query($sql) or die("BOO5");
			$sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('phpbb_prefix','$phpbb_prefix')";
			mysql_query($sql) or die("BOO6");
		}

		mysql_close($link);
		
		$content = 'Setup is now complete. Be sure to remove the install/ directory and click <a href="../index.php">here</a> when you have done so.';
		
		step('Finished!','lime','lime','lime','lime','lime',$content);
	}
	else if($_GET['s'] = 'done_phpraid')
	{
		require_once('../config.php');
		
		$email = $_POST['email'];
		$user = $_POST['username'];
		$pass = md5($_POST['password']);
			
		$link = mysql_connect($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass']);
		mysql_select_db($phpraid_config['db_name']);
		mysql_query("INSERT INTO " . $phpraid_config['db_prefix'] . "profile VALUES('0','$email','$pass','1','$user')") or die(mysql_error());
		$sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('auth_type','phpraid')";
		mysql_query($sql) or die("Error inserting auth_type phpRaid in config table");
		mysql_close($link);
		
		$content = 'Setup is now complete. Be sure to remove the install/ directory and click <a href="../index.php">here</a> when you have done so.';
		
		step('Finished!','lime','lime','lime','lime','lime',$content);
	}
?>