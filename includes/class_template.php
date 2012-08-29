<?php
/***************************************************************************
*                               class_template.php
*                            -------------------
*   begin                : Sa, Aug 11, 2012
*   copyright            : (C) 2007-2012 Carsten Hölbing
*   email                : carsten@hoelbing.net
*
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
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
****************************************************************************/
/*
 *  Themplate / Design 
 *  - not Gamepack spec. functions
 */
class wrm_template
{

	//gerneral variables
	private $wrmdb_con;
	private $wrm_config;
	private $wrm_lang;
	private $wrmsmarty;
	private $template_setting;
	
	private $loginbox_show_status;
	private $BridgeSupportPWDChange_status;

	//
	// Constructor
	//
	public function wrm_template($wrmdb_con, $wrm_config, $wrm_lang)
	{
		$this->wrmdb_con = $wrmdb_con;	
		$this->wrm_config = $wrm_config;
		$this->wrm_lang = $wrm_lang;
		
		$this->loginbox_show_status = TRUE;
		$this->BridgeSupportPWDChange_status = FALSE;
		$this->template_setting =  array();
	}
	
	public function set_smarty($smarty_value)
	{
		$this->wrmsmarty = $smarty_value;
	}
	
	public function load_current_template_settings()
	{
		$directory = '../templates/'.$this->wrm_config['template'];
		if ($this->validate_template_settings($directory) == true)
		{
			include $directory.'/theme_cfg.php';
			
			$this->template_setting = $template_setting;
			return $this->template_setting;
		}
		else
			return false;
	}
	
	public function load_all_template_settings()
	{
		$all_available_templates = array();
		$all_directorys = array();
		$directory = '';
		
		// TEMPLATE CHECK
		// and now let's check templates
		$dir = '../templates';
		$dh = opendir($dir);
		while(false != ($directory = readdir($dh))) {
			$all_directorys[] = $directory;
		}
		
		sort($all_directorys);
		array_shift($all_directorys);
		array_shift($all_directorys);
		
		foreach($all_directorys as $directory )
		{
			$full_directory = '../templates/'.$directory;
			if (($this->validate_template_settings($full_directory) == true)
					 AND ($directory != $this->wrm_config['template'])
				)
			{
				include $full_directory."/theme_cfg.php";
				$template_setting['directory'] = $directory;
				$all_available_templates[$directory] = $template_setting;

			}
		}
		
		return $all_available_templates;
	}
	
	private function validate_template_settings($filename)
	{
		if (!file_exists($filename)) return FALSE;
		/*
		 * The temeplate is missing the theme_cfg.php file.
		 */
		if (!file_exists($filename."/theme_cfg.php")) return FALSE;
		
		/*
		 * The temeplate is missing the style.css stylesheet.
		 */
		if (!file_exists($filename."/style/stylesheet.css")) return FALSE;

		return true;
	}
	
	/*
	 * default: create (html header) settings
	*/
	private function wrm_default_head_settings()
	{
		$html_output = "";
		
		//Meta infos
		$html_output .=  '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">'."\n";

		$html_output .=  '<title>WoW Raid Manager :: '.$this->wrm_config['site_name'].' @ '.$this->wrm_config['site_server'].' :: '.$this->wrm_config['site_description'].'</title>'."\n";
		$html_output .=  '<link rel="shortcut icon" href="templates/'.$this->wrm_config['template'].'/images/favicon.ico">'."\n";
		$html_output .=  '<link rel="icon" href="templates/'.$this->wrm_config['template'].'/images/favicon.ico" type="image/x-icon">'."\n";

		// load stylesheet libs
		$html_output .=  '<link rel="stylesheet" type="text/css" href="includes/wowarmory/style.php" title="wow">'."\n";
		$html_output .=  '<link rel="stylesheet" type="text/css" href="templates/'.$this->wrm_config['template'].'/style/calendar.css">'."\n";
		$html_output .=  '<link rel="stylesheet" type="text/css" href="templates/'.$this->wrm_config['template'].'/style/stylesheet.css">'."\n";
		$html_output .=  '<link rel="stylesheet" type="text/css" href="templates/'.$this->wrm_config['template'].'/style/cssToolTips.css">'."\n";

		// load Javascript libs
		$html_output .=  '<script src="js/cal2.js" type="text/javascript"></script>'."\n";
		$html_output .=  '<script src="js/cal2_conf.js" type="text/javascript"></script>'."\n";
		$html_output .=  '<script src="js/phpRaid.js" type="text/javascript"></script>'."\n";
		
		//$html_output .=  '<script language="JavaScript" src="includes/wowarmory/js/qtip.js" type="text/JavaScript"></script>';
		//$html_output .=  '<script language="JavaScript" src="includes/wowarmory/js/tw-sack.js" type="text/JavaScript"></script>';
		//$html_output .=  '<script language="JavaScript" src="includes/wowarmory/js/ajax-dynamic-content.js" type="text/JavaScript"></script>';
		
		// RSS
		$html_output .=  '<link rel="alternate" title="'.$this->wrm_config['site_name']. " " .$this->wrm_lang['of']. " " . $this->wrm_config['site_server']." " . $this->wrm_lang['rss_feed_text'].'" type="application/rss+xml" href="rss.php">'."\n";
		
		return $html_output;
	}
	
	/*
	 * Admin: create (html header) settings
	 */
	private function wrm_admin_head_settings()
	{
		$html_output = "";
	
		//Meta infos
		$html_output .=  '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">'."\n";
	
		$html_output .=  '<title>WoW Raid Manager ADMIN SECTION :: '.$this->wrm_config['site_name'].' @ '.$this->wrm_config['site_server'].' :: '.$this->wrm_config['site_description'].'</title>'."\n";
		$html_output .=  '<link rel="shortcut icon" href="../templates/'.$this->wrm_config['template'].'/images/favicon.ico">'."\n";
		$html_output .=  '<link rel="icon" href="../templates/'.$this->wrm_config['template'].'/images/favicon.ico" type="image/x-icon">'."\n";
	
		// load stylesheet libs
		//$html_output .=  '<link rel="stylesheet" type="text/css" href="../includes/wowarmory/style.php" title="wow">'."\n";
		$html_output .=  '<link rel="stylesheet" type="text/css" href="../templates/'.$this->wrm_config['template'].'/style/calendar.css">'."\n";
		$html_output .=  '<link rel="stylesheet" type="text/css" href="../templates/'.$this->wrm_config['template'].'/style/stylesheet.css">'."\n";
		$html_output .=  '<link rel="stylesheet" type="text/css" href="../templates/'.$this->wrm_config['template'].'/style/cssToolTips.css">'."\n";
	
		// load Javascript libs
		$html_output .=  '<script src="../js/cal2.js" type="text/javascript"></script>'."\n";
		$html_output .=  '<script src="../js/cal2_conf.js" type="text/javascript"></script>'."\n";
		$html_output .=  '<script src="../js/phpRaid.js" type="text/javascript"></script>'."\n";
	
		//$html_output .=  '<script language="JavaScript" src="includes/wowarmory/js/qtip.js" type="text/JavaScript"></script>';
		//$html_output .=  '<script language="JavaScript" src="includes/wowarmory/js/tw-sack.js" type="text/JavaScript"></script>';
		//$html_output .=  '<script language="JavaScript" src="includes/wowarmory/js/ajax-dynamic-content.js" type="text/JavaScript"></script>';
	
		// RSS
		$html_output .=  '<link rel="alternate" title="'.$this->wrm_config['site_name']. " " .$this->wrm_lang['of']. " " . $this->wrm_config['site_server']." " . $this->wrm_lang['rss_feed_text'].'" type="application/rss+xml" href="rss.php">'."\n";
	
		return $html_output;
	}
	
	/*
	 * default : Header
	*/
	public function show_page_default_header()
	{
		// time variables
		$guild_time = new_date($this->wrm_config['time_format'],time(),$this->wrm_config['timezone'] + $this->phpraid_config['dst']);
		$guild_date = new_date($this->wrm_config['date_format'],time(),$this->wrm_config['timezone'] + $this->phpraid_config['dst']);
		
		$login_form = $this->wrm_show_loginbox_gethtmlstring();

		$path_images = "templates/".$this->wrm_config['template']."/images";
		$path_style = "templates/".$this->wrm_config['template']."/style";

		$this->wrmsmarty->assign('page_header_data',
				array(

						'path_images' => $path_images,
						'path_style' => $path_style,
						
						'login_form' => $login_form,
						'guild_time' => $guild_time,
						'guild_date' => $guild_date,
						'guild_time_string' => $this->wrm_lang['guild_time_string'],
						'body_width'  => $this->wrm_config['template_body_width'],
						'header_link' => $this->wrm_config['header_link'],
						'default_values' => $this->wrm_default_head_settings()
				)
		);
		
		$this->wrmsmarty->display('header.html');

	}
	
	/*
	 * Admin : Header
	 */
	public function show_page_admin_header()
	{
		// time variables
		$guild_time = new_date($this->wrm_config['time_format'],time(),$this->wrm_config['timezone'] + $this->phpraid_config['dst']);
		$guild_date = new_date($this->wrm_config['date_format'],time(),$this->wrm_config['timezone'] + $this->phpraid_config['dst']);
	
		$login_form = $this->wrm_show_loginbox_gethtmlstring();
	
		$path_images = "../templates/".$this->wrm_config['template']."/images";
		$path_style = "../templates/".$this->wrm_config['template']."/style";
	
		$this->wrmsmarty->assign('page_header_data',
				array(
	
						'path_images' => $path_images,
						'path_style' => $path_style,
	
						'login_form' => $login_form,
						'guild_time' => $guild_time,
						'guild_date' => $guild_date,
						'guild_time_string' => $this->wrm_lang['guild_time_string'],
						'body_width'  => $this->wrm_config['template_body_width'],
						'header_link' => $this->wrm_config['header_link'],
						'default_values' => $this->wrm_admin_head_settings()
				)
		);
	
		$this->wrmsmarty->display('admin_header.html');
	
	}
	
	/**
	 * Parse and show the overall footer
	 */
	public function show_page_footer()
	{
		//load version number
		require('version.php');
		
		//
		// Parse and show the overall footer.
		//
		$this->wrmsmarty->assign('version',$version);
		
		$this->wrmsmarty->display('footer.html');
	}

	/*
	 * ------------------- Login Box
	 */
	private function wrm_show_loginbox_gethtmlstring()
	{
		if ($this->loginbox_show_status == FALSE)
		{
			$login_form = "";
		}
		else
		{
			$wrm_db_user_name = "username";
			$wrm_table_prefix = $this->wrm_config['db_prefix'];
			$wrm__db_table_user_name = "profile";
		
			$phpraid_dir = "./";
			$login_form = "";
		
			$priv_config = scrub_input($_SESSION['priv_configuration']);
			$logged_in = scrub_input($_SESSION['session_logged_in']);
			$profile_id = scrub_input($_SESSION['profile_id']);
		
			//database
			$sql = sprintf(	"SELECT ". $wrm_db_user_name .
					" FROM " . $wrm_table_prefix . $wrm__db_table_user_name.
					" WHERE profile_id = %s", quote_smart($profile_id)
			);
			$result = $this->wrmdb_con->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			$data = $this->wrmdb_con->sql_fetchrow($result, true);
			$login_username_name = $data[$wrm_db_user_name];
		
			/**************************************************************
			 * Show Login Box / Field
			**************************************************************/
			// now for the links
			if($logged_in != 1)
			{
				$login_form_open = '<form action="login.php" method="POST">';
				$login_username = '<input name="username" type="text" value="username" size="15" maxlength="45" onFocus="if(this.value==\'username\')this.value=\'\';" class="post">';
				$login_password = '<input name="password" type="password" value="password" size="15" onFocus="if(this.value==\'password\')this.value=\'\';" class="post">';
				$login_button = ' <input type="submit" name="login" value="'.$this->wrm_lang['login'].'" style="font-size:10px" class="mainoption">';
				//$login_remember = '<input type="checkbox" checked="checked" name="autologin">';
				$login_remember_hidden = '<input type="hidden" value="1" name="autologin">';
					
				//$BridgeSupportPWDChange came from the bridge
				if ($this->BridgeSupportPWDChange_status == TRUE)
				{
					$login_change_pass = '<a href="login.php?mode=new_pwd">'.$this->wrm_lang['login_forgot_password'].'</a>';
				}
					
				$login_form_close = '</form>';
			}
			else
			{
				$login_form_open = '<form action="login.php?logout=true" method="POST">';
				$login_username = $login_username_name;
				$login_password = '';
				$login_button = '<input type="submit" name="login" value="'.$this->wrm_lang['logout'].'" style="font-size:10px" class="mainoption">';
				//$login_remember = '';
				$login_remember_hidden = '';
					
				//$BridgeSupportPWDChange came from the bridge
				if ($this->BridgeSupportPWDChange_status == TRUE)
				{
					$login_change_pass = '<a href="login.php?mode=ch_pwd">'.$this->wrm_lang['login_chpwd'].'</a>';
				}
		
				if ( $priv_config )
				{
					$SIDURL = htmlspecialchars(SID);
					$admin_config_link = '<a href="admin/admin_index.php?'.$SIDURL.'">'.$this->wrm_lang['admin_section_link'].'</a>';
				}
				$login_form_close = '</form>';
			}
				
			$login_form .= '<div align="right" style="margin-right:3px; font-size:10px; color:#ffffff">';
			$login_form .= $login_form_open;
			$login_form .= '<strong>' . $login_username . '</strong>';
			$login_form .= $login_password;
			$login_form .= $login_remember_hidden;
			$login_form .= $login_button;
			$login_form .= '<br>';
			$login_form .= $login_change_pass;
			$login_form .= '<br>';
			$login_form .= $admin_config_link;
			$login_form .= $login_form_close;
			$login_form .= '</div>';

		}
		//return this HTML - String
		return $login_form;
	}
	
	public function set_loginbox_show_status($status)
	{
		$this->loginbox_show_status = $status;
	}
	
	public function set_BridgeSupportPWDChange_status($status)
	{
		$this->BridgeSupportPWDChange_status = $status;
	}
	
	/******************************************************
	 *  Default : Menu Section - Create the Left Side Menu
	*******************************************************/
	private function wrm_load_default_menu()
	{
		$array_wrm_menu = array();
		$array_wrm_menu[0]['div_class_menuHeader'] = 'menuHeader';
		$array_wrm_menu[0]['div_class_menuHeader_text'] = $this->wrm_lang['menu_header_text'];
		$array_wrm_menu[0]['div_class'] = 'navContainer';
		$array_wrm_menu[0]['ul_class'] = 'navList';
		
		// Show Guild Link
		$array_wrm_menu[0][0] = array(
							'href' => $this->wrm_config['header_link'],
							'url_text' => $this->wrm_lang['index_link'],
							'images' =>'',
							'show_status' => TRUE
							);
		// Show Index Link
		$array_wrm_menu[0][1] = array(
							'href' => 'index.php',
							'url_text' => $this->wrm_lang['home_link'],
							'images' =>'',
							'show_status' => TRUE
					);
		// Show Calendar Link
		$array_wrm_menu[0][2] = array(
							'href' => 'calendar.php',
							'url_text' => $this->wrm_lang['calendar_link'],
							'images' =>'',
							'show_status' => TRUE
							);
		
		// Show Announcements Link
		if (scrub_input($_SESSION['priv_announcements']) == 1)
			$show_status = TRUE;
		else
			$show_status = FALSE;
		$array_wrm_menu[0][3] = array(
				'href' => 'announcements.php?mode=view',
				'url_text' => $this->wrm_lang['announcements_link'],
				'images' =>'',
				'show_status' => $show_status
		);
		
		// Show Guild Link
		if (scrub_input($_SESSION['priv_guilds']) == 1)
			$show_status = TRUE;
		else
			$show_status = FALSE;
		$array_wrm_menu[0][4] = array(
				'href' => 'guilds.php?mode=view',
				'url_text' => $this->wrm_lang['guilds_link'],
				'images' =>'',
				'show_status' => $show_status
		);
		
		// Show Locations Link
		if (scrub_input($_SESSION['priv_locations']) == 1)
			$show_status = TRUE;
		else
			$show_status = FALSE;
		$array_wrm_menu[0][5] = array(
				'href' => 'locations.php?mode=view',
				'url_text' => $this->wrm_lang['locations_link'],
				'images' =>'',
				'show_status' => $show_status
		);
		
		// Show Register Link
		if ($this->wrm_config['auth_type'] == "iums")
			$show_status = TRUE;
		else
			$show_status = FALSE;
		$array_wrm_menu[0][6] = array(
				'href' => $this->wrm_config['register_url'],
				'url_text' => $this->wrm_lang['register_link'],
				'images' =>'',
				'show_status' => $show_status
		);
		
		// Show Profile Link
		if (scrub_input($_SESSION['priv_profile']) == 1)
			$show_status = TRUE;
		else
			$show_status = FALSE;
		$array_wrm_menu[0][7] = array(
				'href' => 'profile.php?mode=view',
				'url_text' => $this->wrm_lang['profile_link'],
				'images' =>'',
				'show_status' => $show_status
		);
		
		// Show Raids and lua_output Link
		if ( scrub_input($_SESSION['priv_raids']) OR ($this->wrm_config['enable_five_man'] AND scrub_input($_SESSION['priv_profile'])))
			$show_status = TRUE;
		else
			$show_status = FALSE;
		$array_wrm_menu[0][8] = array(
				'href' => 'raids.php?mode=view',
				'url_text' => $this->wrm_lang['raids_link'],
				'images' =>'',
				'show_status' => $show_status
		);
		$array_wrm_menu[0][9] = array(
				'href' => 'lua_output_new.php?mode=lua',
				'url_text' => $this->wrm_lang['lua_output_link'],
				'images' =>'',
				'show_status' => $show_status // same as raids
		);
		
		// Show Roster Link
		$array_wrm_menu[0][10] = array(
				'href' => 'roster.php',
				'url_text' => $this->wrm_lang['roster_link'],
				'images' =>''
		);
		// If integration with EQDKP is enabled, add a link here.
		$array_wrm_menu[0][11] = array(
				'href' => 'dkp_view.php',
				'url_text' => $this->wrm_lang['dkp_link'],
				'images' =>'',
				'show_status' => TRUE
		);
		
		// Show Boss Kill Tracking Link
		$array_wrm_menu[0][12] = array(
				'href' => 'bosstracking.php?mode=view',
				'url_text' => $this->wrm_lang['bosstrack_link'],
				'images' =>'',
				'show_status' => FALSE
		);
		
		// Show Raids Archives Link
		$array_wrm_menu[0][13] = array(
				'href' => 'raidsarchive.php?mode=view',
				'url_text' => $this->wrm_lang['raidsarchive_link'],
				'images' =>'',
				'show_status' => TRUE
		);
		
		return $array_wrm_menu;
	}
	
	/****************************************************
	*  ADMIN : Menu Section - Create the Left Side Menu
	*****************************************************/
	private function wrm_load_admin_menu()
	{
	
		// *** MAIN MENU CONFIG ITEMS ***
		$array_wrm_menu = array();
		
		$array_wrm_menu[0]['div_class_menuHeader'] = 'menuHeader';
		$array_wrm_menu[0]['div_class_menuHeader_text'] = $this->wrm_lang['admin_menu_header'];
		$array_wrm_menu[0]['div_class'] = 'navContainer';
		$array_wrm_menu[0]['ul_class'] = 'navList';
	
		// Show Guild Link
		$array_wrm_menu[0][0] = array(
				'href' => '../index.php',
				'url_text' => $this->wrm_lang['admin_site_link'],
				'images' =>'',
				'show_status' => TRUE
		);
		// Show Index Link
		$array_wrm_menu[0][1] = array(
				'href' => 'admin_index.php',
				'url_text' => $this->wrm_lang['home_link'],
				'images' =>'',
				'show_status' => TRUE
		);
		
		// *** General Configuration Menu Items ***
		$array_wrm_menu[1]['div_class_menuHeader'] = 'menuHeader';
		$array_wrm_menu[1]['div_class_menuHeader_text'] = $this->wrm_lang['gen_conf_menu_header'];
		$array_wrm_menu[1]['div_class'] = 'navContainer';
		$array_wrm_menu[1]['ul_class'] = 'navList';
		
		//
		$array_wrm_menu[1][0] = array(
				'href' => 'admin_generalcfg.php',
				'url_text' => $this->wrm_lang['admin_general_config'],
				'images' =>'',
				'show_status' => TRUE
		);
		//
		$array_wrm_menu[1][1] = array(
				'href' => 'admin_general_rss_cfg.php',
				'url_text' => $this->wrm_lang['admin_general_rss_cfg'],
				'images' =>'',
				'show_status' => TRUE
		);
		$array_wrm_menu[1][2] = array(
				'href' => 'admin_general_email_cfg.php',
				'url_text' => $this->wrm_lang['admin_general_email_cfg'],
				'images' =>'',
				'show_status' => TRUE
		);
		$array_wrm_menu[1][3] = array(
				'href' => 'admin_timecfg.php',
				'url_text' => $this->wrm_lang['admin_time_config'],
				'images' =>'',
				'show_status' => TRUE
		);
		$array_wrm_menu[1][4] = array(
				'href' => 'admin_raidsettings.php',
				'url_text' => $this->wrm_lang['admin_raid_settings'],
				'images' =>'',
				'show_status' => TRUE
		);
		$array_wrm_menu[1][5] = array(
				'href' => 'admin_externcfg.php',
				'url_text' => $this->wrm_lang['admin_external_config'],
				'images' =>'',
				'show_status' => TRUE
		);
		$array_wrm_menu[1][6] = array(
				'href' => 'admin_general_game_settings.php',
				'url_text' => $this->wrm_lang['admin_game_settings'],
				'images' =>'',
				'show_status' => TRUE
		);
		$array_wrm_menu[1][7] = array(
				'href' => 'admin_general_lua_output_cfg.php',
				'url_text' => $this->wrm_lang['admin_general_lua_output_cfg'],
				'images' =>'',
				'show_status' => TRUE
		);
		
		// *** Style Menu Items ***
		$array_wrm_menu[2]['div_class_menuHeader'] = 'menuHeader';
		$array_wrm_menu[2]['div_class_menuHeader_text'] = $this->wrm_lang['style_menu_header'];
		$array_wrm_menu[2]['div_class'] = 'navContainer';
		$array_wrm_menu[2]['ul_class'] = 'navList';
		
		//
		$array_wrm_menu[2][0] = array(
				'href' => 'admin_style_cfg.php',
				'url_text' => $this->wrm_lang['admin_style_conf'],
				'images' =>'',
				'show_status' => TRUE
		);
		$array_wrm_menu[2][1] = array(
				'href' => 'admin_style_menubar_mgt.php',
				'url_text' => $this->wrm_lang['admin_menubar_mgt_link'],
				'images' =>'',
				'show_status' => TRUE
		);
		
		// *** User Management Menu Items ***
		$array_wrm_menu[3]['div_class_menuHeader'] = 'menuHeader';
		$array_wrm_menu[3]['div_class_menuHeader_text'] = $this->wrm_lang['user_mgt_menu_header'];
		$array_wrm_menu[3]['div_class'] = 'navContainer';
		$array_wrm_menu[3]['ul_class'] = 'navList';
		
		//
		$array_wrm_menu[3][0] = array(
				'href' => 'admin_usermgt.php',
				'url_text' => $this->wrm_lang['admin_user_management'],
				'images' =>'',
				'show_status' => TRUE
		);
		$array_wrm_menu[3][1] = array(
				'href' => 'admin_permissions.php',
				'url_text' => $this->wrm_lang['admin_permissions'],
				'images' =>'',
				'show_status' => TRUE
		);
		$array_wrm_menu[3][3] = array(
				'href' => 'admin_raid_signupgroups.php',
				'url_text' => $this->wrm_lang['admin_raid_signupgroups'],
				'images' =>'',
				'show_status' => TRUE
		);
		$array_wrm_menu[3][4] = array(
				'href' => 'admin_usersettings.php',
				'url_text' => $this->wrm_lang['admin_user_settings'],
				'images' =>'',
				'show_status' => TRUE
		);
		
		// *** Table Configuration Menu Items ***
		$array_wrm_menu[4]['div_class_menuHeader'] = 'menuHeader';
		$array_wrm_menu[4]['div_class_menuHeader_text'] = $this->wrm_lang['table_conf_menu_header'];
		$array_wrm_menu[4]['div_class'] = 'navContainer';
		$array_wrm_menu[4]['ul_class'] = 'navList';
		
		//
		$array_wrm_menu[4][0] = array(
				'href' => 'admin_datatablecfg.php',
				'url_text' => $this->wrm_lang['admin_datatablecfg_link'],
				'images' =>'',
				'show_status' => TRUE
		);
		$array_wrm_menu[4][1] = array(
				'href' => 'admin_rolecfg.php',
				'url_text' => $this->wrm_lang['admin_rolecfg_link'],
				'images' =>'',
				'show_status' => TRUE
		);
		$array_wrm_menu[4][3] = array(
				'href' => 'admin_roletalent.php',
				'url_text' => $this->wrm_lang['admin_roletalent_config'],
				'images' =>'',
				'show_status' => TRUE
		);
		
		// *** Log Menu Items ***
		$array_wrm_menu[5]['div_class_menuHeader'] = 'menuHeader';
		$array_wrm_menu[5]['div_class_menuHeader_text'] = $this->wrm_lang['logs_menu_header'];
		$array_wrm_menu[5]['div_class'] = 'navContainer';
		$array_wrm_menu[5]['ul_class'] = 'navList';
		
		//
		$array_wrm_menu[5][0] = array(
				'href' => 'admin_logs.php',
				'url_text' => $this->wrm_lang['admin_logs_link'],
				'images' =>'',
				'show_status' => TRUE
		);

		return $array_wrm_menu;
	}
	
	/**************************************************************
	 * setup menu
	**************************************************************/
	private function create_menu($menu_array)
	{
		$menu = '';
		
		for ($menu_counter=0; $menu_counter<count($menu_array); $menu_counter++)
		{

			$menu .= "\n".'<div class="'.$menu_array[$menu_counter]['div_class_menuHeader'].'">'.$menu_array[$menu_counter]['div_class_menuHeader_text'].'</div>'."\n";
			$menu .= "\n".'<div align="left" class="'.$menu_array[$menu_counter]['div_class'].'">'."\n";
			$menu .= '<ul class="'.$menu_array[$menu_counter]['ul_class'].'">'."\n";
			$menu .= $this->create_menu_entry($menu_array[$menu_counter]);
			$menu .="\n";
			
			$menu .= '</ul></div>';
			$menu .= '<br/>';
		}

		return $menu;
	}
	
	private function create_menu_entry($menu_array)
	{
		$menu = '';

		for ($i=0; $i<count($menu_array); $i++)
		{
			if ($menu_array[$i]['show_status'] == TRUE)
			{
				$href_link = '<a href="'.$menu_array[$i]['href'].'">'.$menu_array[$i]['url_text'].'</a>';
				$href_shortname = substr($menu_array[$i]['href'], 0, strpos($menu_array[$i]['href'],"."));

				if (preg_match("/(.*)".$href_shortname."\.php(.*)/", $_SERVER['PHP_SELF']) AND  $href_shortname != "") {
					$menu .= '<li class="active">' . $href_link . '</li>'."\n";
				} else {
					$menu .= '<li>' . $href_link . '</li>'."\n";
				}
			}
		}

		return $menu;
	}
	
	/*
	 *  Default: Menu load Array with menu all entry and show it (HTML Code)
	*/
	public function wrm_show_default_menus()
	{
		$menu =	$this->create_menu($this->wrm_load_default_menu());
		//echo "test"; 
		$this->wrmsmarty->assign('menu_data', 
			array(
				'menu_header_text' => $this->wrm_lang['menu_header_text'],
				'menu'=> $menu
			)
		);
		$this->wrmsmarty->display('menu.html');
	}
	
	/*
	 *  Admin: Menu load Array with menu all entry and show it (HTML Code)
	*/
	public function wrm_show_admin_menus()
	{
		$menu =	$this->create_menu($this->wrm_load_admin_menu());

		$this->wrmsmarty->assign('menu_data',
				array(
						'menu_header_text' => $this->wrm_lang['menu_header_text'],
						'menu'=> $menu
				)
		);
		$this->wrmsmarty->display('admin_menu.html');
	
	}
}  //end class wrm_template

?>