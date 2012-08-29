<?php
// this defines whether to use the test in language.php or images for all links
// if set to 0, then it pulls information from lang_main.php
// NOTE: DO NOT SET THIS TO 1, there ARE NO IMAGES.
$use_images = 0;

// image locations
// only if above is set to 1, else do not modify
$image_admin_site_link = "<img src=\"../templates/" . $phpraid_config['template'] . "/images/admin/index.gif\" border=\"0\">";
$image_admin_main_link = "<img src=\"../templates/" . $phpraid_config['template'] . "/images/admin/site.gif\" border=\"0\">";
$image_admin_logs = "<img src=\"..templates/" . $phpraid_config['template'] . "/images/admin/logs.gif\" border=\"0\">";
$image_admin_rolecfg_link = "<img src=\"..templates/" . $phpraid_config['template'] . "/images/admin/rolecfg.gif\" border=\"0\">";
$image_admin_datatablecfg_link = "<img src=\"..templates/" . $phpraid_config['template'] . "/images/admin/datatablecfg.gif\" border=\"0\">";
$image_admin_lua_output_cfg_link = "<img src=\"..templates/" . $phpraid_config['template'] . "/images/admin/lua_output.gif\" border=\"0\">";
$image_permissions_link = "<img src=\"../templates/" . $phpraid_config['template'] . "/images/admin/permissions.gif\" border=\"0\">";
$image_signup_rights_link = "<img src=\"../templates/" . $phpraid_config['template'] . "/images/admin/signup.gif\" border=\"0\">";
$image_user_settings_link = "<img src=\"../templates/" . $phpraid_config['template'] . "/images/admin/usersettings.gif\" border=\"0\">";
$image_user_mgt_link = "<img src=\"../templates/" . $phpraid_config['template'] . "/images/admin/usermgt.gif\" border=\"0\">";
$image_generalcfg_link = "<img src=\"../templates/" . $phpraid_config['template'] . "/images/admin/generalcfg.gif\" border=\"0\">";
$image_timecfg_link = "<img src=\"../templates/" . $phpraid_config['template'] . "/images/admin/timecfg.gif\" border=\"0\">";
$image_raid_settings_link = "<img src=\"../templates/" . $phpraid_config['template'] . "/images/admin/raidsettings.gif\" border=\"0\">";
$image_externcfg_link = "<img src=\"../templates/" . $phpraid_config['template'] . "/images/admin/extern.gif\" border=\"0\">";
$image_roletalent_link = "<img src=\"../templates/" . $phpraid_config['template'] . "/images/admin/roletalent.gif\" border=\"0\">";
$image_rss_link = "<img src=\"../templates/" . $phpraid_config['template'] . "/images/admin/rss.gif\" border=\"0\">";
$image_email_link = "<img src=\"../templates/" . $phpraid_config['template'] . "/images/admin/email.gif\" border=\"0\">";
$image_game_settings_link = "<img src=\"../templates/" . $phpraid_config['template'] . "/images/admin/gamesettings.gif\" border=\"0\">";
$image_stylecfg_link = "<img src=\"../templates/" . $phpraid_config['template'] . "/images/admin/stylecfg.gif\" border=\"0\">";
$image_menubarmgt_link = "<img src=\"../templates/" . $phpraid_config['template'] . "/images/admin/menubarmgt.gif\" border=\"0\">";

// no further editing necessary
if($use_images == 0) {
	$theme_admin_site_link = $phprlang[''];
	$theme_admin_main_link = $phprlang['admin_main_link'];
	$theme_admin_logs_link = $phprlang[''];
	$theme_admin_rolecfg_link = $phprlang[''];
	$theme_admin_datatablecfg_link = $phprlang[''];
	$theme_admin_permissions_link = $phprlang[''];
	$theme_admin_signuprights_link = $phprlang['admin_signup_rights'];
	$theme_admin_usersettings_link = $phprlang[''];
	$theme_admin_usermgt_link = $phprlang[''];
	
	$theme_admin_generalcfg_link = $phprlang[''];
	$theme_admin_general_rss_cfg_link = $phprlang[''];
	$theme_admin_general_email_cfg_link = $phprlang[''];
	$theme_admin_general_lua_output_cfg_link = $phprlang[''];
	
	$theme_admin_timecfg_link = $phprlang[''];
	
	$theme_admin_raid_settings_link = $phprlang[''];
	$theme_admin_raid_signupgroups_link = $phprlang[''];
	$theme_admin_externcfg_link = $phprlang[''];
	$theme_admin_roletalent_link = $phprlang[''];
	

	$theme_admin_general_game_settings_link = $phprlang[''];
	$theme_admin_style_conf_link = $phprlang[''];
	$theme_admin_style_menubar_mgt_link = $phprlang[''];
} else {
	$theme_admin_site_link = $image_admin_site_link;
	$theme_admin_main_link = $image_admin_main_link;
	$theme_admin_logs_link = $image_admin_logs;
	$theme_admin_rolecfg_link = $image_admin_rolecfg_link;
	$theme_admin_datatablecfg_link = $image_admin_datatablecfg_link;
	$theme_admin_permissions_link = $image_permissions_link;
	$theme_admin_signuprights_link = $image_signup_rights_link;
	$theme_admin_usersettings_link = $image_user_settings_link;
	$theme_admin_usermgt_link = $image_user_mgt_link;
	$theme_admin_generalcfg_link = $image_generalcfg_link;
	$theme_admin_general_rss_cfg_link = $image_rss_link;
	$theme_admin_general_email_cfg_link = $image_email_link;
	$theme_admin_general_lua_output_cfg_link = $image_admin_lua_output_cfg_link;
	$theme_admin_timecfg_link = $image_timecfg_link;
	$theme_admin_raid_settings_link = $image_raid_settings_link;
	$theme_admin_externcfg_link = $image_externcfg_link;
	$theme_admin_roletalent_link = $image_roletalent_link;
	$theme_admin_raid_signupgroups_link = $image_signup_rights_link;
	$theme_admin_general_game_settings_link = $image_game_settings_link;
	$theme_admin_style_conf_link = $image_stylecfg_link;
	$theme_admin_style_menubar_mgt_link = $image_menubarmgt_link;
}
?>
