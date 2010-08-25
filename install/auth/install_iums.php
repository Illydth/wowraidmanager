<?php

//(short)Name from the BB/CMS
$bridge_type_name = "iums";

$bridge_setting_value = array(

	'auth_type_name' => $bridge_type_name,
	
	/*********************************************** 
	 * Table and Column Names - change per CMS.
	 ***********************************************/
	// Column Name for the ID field for the User.
	'db_user_id' => 'profile_id',
	// Column Name for the ID field for the Group the User belongs to.
	'db_group_id' => "",
	// Column Name for the UserName field.
	'db_user_name' => "username",
	//filter: for empty name, bots
	'db_user_name_filter' => " ORDER BY username",
	// Column Name for the User's E-Mail Address
	'db_user_email' => "email",
	// Column Name for the User's Password
	'db_user_password' => "password",
	
	'db_table_user_name' => "profile",
	'db_table_group_name' => "", //only for cross table
				
	'auth_user_group_text' => "",//$bridge_type_name . '_auth_user_group',
	'auth_alt_user_group_text' => "",// $bridge_type_name. '_alt_auth_user_group',
	
	// Table Name were save all  Groups/Class Infos
	'db_table_allgroups' => "",
	// Column Name for the ID field for the Group/Class.
	'db_allgroups_id' => "",
	// Column Name for the Groups/Class Name field.
	'db_allgroups_name' => "",

	//utf8 Support
	'bridge_utf8_support' => "yes",

);

?>