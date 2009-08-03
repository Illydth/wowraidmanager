<?php
// this defines whether to use the test in language.php or images for all links
// if set to 0, then it pulls information from lang_main.php
// NOTE: DO NOT SET THIS TO 1, there ARE NO IMAGES.
$use_images = 0;

// image locations
// only if above is set to 1, else do not modify
$image_index = "<img src=\"templates/" . $phpraid_config['template'] . "/images/index.gif\" border=\"0\">";
$image_roster = "<img src=\"templates/" . $phpraid_config['template'] . "/images/member_list.gif\" border=\"0\">";
$image_guild = "<img src=\"templates/" . $phpraid_config['template'] . "/images/guilds.gif\" border=\"0\">";
$image_home = "<img src=\"templates/" . $phpraid_config['template'] . "/images/home.gif\" border=\"0\">";
$image_announcement = "<img src=\"templates/" . $phpraid_config['template'] . "/images/announcements.gif\" border=\"0\">";
$image_raids = "<img src=\"templates/" . $phpraid_config['template'] . "/images/manage_raids.gif\" border=\"0\">";
$image_locations = "<img src=\"templates/" . $phpraid_config['template'] . "/images/locations.gif\" border=\"0\">";
$image_profile = "<img src=\"templates/" . $phpraid_config['template'] . "/images/my_profile.gif\" border=\"0\">";
$image_register = "<img src=\"templates/" . $phpraid_config['template'] . "/images/register.gif\" border=\"0\">";
$image_rss = "<img src=\"templates/" . $phpraid_config['template'] . "/images/rss.png\" border=\"0\">";
$image_lua_output = "<img src=\"templates/" . $phpraid_config['template'] . "/images/lua_output.gif\" border=\"0\">";
$image_dkp_link = "<img src=\"templates/" . $phpraid_config['template'] . "/images/dkp_link.gif\" border=\"0\">";
$image_bosstrack_link = "<img src=\"templates/" . $phpraid_config['template'] . "/images/bosstrack_link.gif\" border=\"0\">";

// no further editing necessary
if($use_images == 0) {
	$theme_index_link = $phprlang['index_link'];
	$theme_lua_output_link = $phprlang['lua_output_link'];
	$theme_guild_link = $phprlang['guilds_link'];
	$theme_home_link = $phprlang['home_link'];
	$theme_calendar_link = $phprlang['calendar_link'];
	$theme_announcement_link = $phprlang['announcements_link'];
	$theme_raids_link = $phprlang['raids_link'];
	$theme_locations_link = $phprlang['locations_link'];
	$theme_profile_link = $phprlang['profile_link'];
	$theme_users_link = $phprlang['users_link'];
	$theme_register_link = $phprlang['register_link'];
	$theme_roster_link = $phprlang['roster_link'];
	$theme_dkp_link = $phprlang['dkp_link'];
	$theme_bosstrack_link = $phprlang['bosstrack_link'];
} else {
	$theme_index_link = $image_index;
	$theme_guild_link = $image_guild;
	$theme_home_link = $image_home;
	$theme_announcement_link = $image_announcement;
	$theme_raids_link = $image_raids;
	$theme_calendar_link = $image_calendar;
	$theme_locations_link = $image_locations;
	$theme_profile_link = $image_profile;
	$theme_users_link = $image_users;
	$theme_register_link = $image_register;
	$theme_roster_link = $image_roster;
	$theme_lua_output_link = $image_lua_output;
	$theme_dkp_link = $image_dkp_link;
	$theme_bosstrack_link = $image_bosstrack_link;
}
?>