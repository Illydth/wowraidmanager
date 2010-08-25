<?php

//(short)Name from the BB/CMS
$bridge_type_name = "phpbb3";

$bridge_setting_value = array(

	'auth_type_name' => $bridge_type_name,
	
	/*********************************************** 
	 * Table and Column Names - change per CMS.
	 ***********************************************/
	// Column Name for the ID field for the User.
	'db_user_id' => "user_id",
	// Column Name for the ID field for the Group the User belongs to.
	'db_group_id' => "group_id",
	// Column Name for the UserName field.
	'db_user_name' => "username_clean",
	//filter: for empty name, bots
	'db_user_name_filter' => " WHERE user_email <> '' ORDER BY username_clean",
	// Column Name for the User's E-Mail Address
	'db_user_email' => "user_email",
	// Column Name for the User's Password
	'db_user_password' => "user_password",
	
	'db_table_user_name' => "users",
	'db_table_group_name' => "user_group", //only for cross table
				
	'auth_user_group_text' => $bridge_type_name . '_auth_user_group',
	'auth_alt_user_group_text' => $bridge_type_name. '_alt_auth_user_group',
	
	// Table Name were save all  Groups/Class Infos
	'db_table_allgroups' => "groups",
	// Column Name for the ID field for the Group/Class.
	'db_allgroups_id' => "group_id",
	// Column Name for the Groups/Class Name field.
	'db_allgroups_name' => "group_name",

	//utf8 Support
	'bridge_utf8_support' => "yes",

	// ------------- Optional -------------

	//bridge Major Version
	'bridge_major_name' => "phpbb",
	'bridge_major_version' => 3, //only the first nr; 
);

?>