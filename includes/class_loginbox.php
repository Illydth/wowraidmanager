<?php
/***************************************************************************
*                            class_loginbox.php
*                            -------------------
*   begin                : Monday, Aug 23, 2010
*   copyright            : (C) 2007-2010 Carsten Hölbing
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
 *  Menu Stuff
 */
class wrm_loginbox
{
	//gerneral stuff
	var $db_raid;
	var $phpraid_config;
	var $phprlang;
	var $wrmsmarty;
	
	var $loginbox_show_status;
	var $BridgeSupportPWDChange_status;
	//
	// Constructor
	//
	function wrm_loginbox($db_raid, $phpraid_config, $phprlang, $wrmsmarty)
	{
		$this->db_raid = $db_raid;	
		$this->phpraid_config = $phpraid_config;
		$this->phprlang = $phprlang;
		$this->wrmsmarty = $wrmsmarty;
		
		$this->loginbox_show_status = TRUE;
		$this->BridgeSupportPWDChange = FALSE;
	}
	
	function wrm_show_loginbox_gethtmlstring()
	{
		$phpraid_dir = "./";
		$phprlang = $this->phprlang;
		$login_form = "";
		
		$priv_config = scrub_input($_SESSION['priv_configuration']);
		$logged_in = scrub_input($_SESSION['session_logged_in']);
		
		/**************************************************************
		 * Show Login Box / Field
		 **************************************************************/
		// now for the links
		if($logged_in != 1)
		{
			$login_form_open = '<form action="login.php" method="POST">';
			$login_username = '<input name="username" type="text" value="username" size="15" maxlength="45" onFocus="if(this.value==\'username\')this.value=\'\';" class="post">';
			$login_password = '<input name="password" type="password" value="password" size="15" onFocus="if(this.value==\'password\')this.value=\'\';" class="post">';
			$login_button = '<input type="submit" name="login" value="'.$phprlang['login'].'" style="font-size:10px" class="mainoption">';
			$login_remember = '<input type="checkbox" checked="checked" name="autologin">';
			$login_remember_hidden = '<input type="hidden" value="1" name="autologin">';
			
			//$BridgeSupportPWDChange came from the bridge
			if ($this->BridgeSupportPWDChange_status == TRUE)
			{
				$login_change_pass = '<a href="login.php?mode=new_pwd">'.$phprlang['login_forgot_password'].'</a>';
			}
			
			$login_form_close = '</form>';
		}
		else
		{
			$login_form_open = '<form action="login.php?logout=true" method="POST">';
			$login_username = scrub_input($_SESSION['username']);
			$login_password = '';
			$login_button = '<input type="submit" name="login" value="'.$phprlang['logout'].'" style="font-size:10px" class="mainoption">';
			$login_remember = '';
			$login_remember_hidden = '';
			
			//$BridgeSupportPWDChange came from the bridge
			if ($this->BridgeSupportPWDChange_status == TRUE)
			{
				$login_change_pass = '<a href="login.php?mode=ch_pwd">'.$phprlang['login_chpwd'].'</a>';
			}

			if ( $priv_config )
				$admin_config_link = '<a href="admin/admin_index.php?'.SID.'">'.$phprlang['admin_section_link'].'</a>';
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

		if ($this->loginbox_show_status == FALSE)
		{
			$login_form = "";
		}
		
		//return this HTML - String
		return $login_form;
	}
	
	function set_loginbox_show_status($status)
	{
		$this->loginbox_show_status = $status;
	}
	
	function set_BridgeSupportPWDChange_status($status)
	{
		$this->BridgeSupportPWDChange_status = $status;
	}
	
	/**************************************************************
	 * Show Login Box / Field
	 **************************************************************/
	/*
	// not work yet, future feature
	function wrm_show_loginbox()
	{		
		$this->wrmsmarty->assign('login_form',wrm_show_loginbox_gethtmlstring());
		$this->wrmsmarty->display('login_form.html');
		
	}
	*/
	
}  //end class wrm_menu

?>
