<?php

//(short)Name from the BB/CMS
$bridge_type_name = "e107";

$bridge_setting_value = array(

	'auth_type_name' => $bridge_type_name,
		
	/*********************************************** 
	 * Table and Column Names - change per CMS.
	 ***********************************************/
	// Column Name for the ID field for the User.
	'db_user_id' => 'user_id',
	// Column Name for the ID field for the Group the User belongs to.
	'db_group_id' => "user_class",
	// Column Name for the UserName field.
	'db_user_name' => "user_loginname",
	//filter: for empty name, bots
	'db_user_name_filter' => " ORDER BY user_loginname",
	// Column Name for the User's E-Mail Address
	'db_user_email' => "user_email",
	// Column Name for the User's Password
	'db_user_password' => "user_password",
	
	'db_table_user_name' => "user",
	'db_table_group_name' => "user", //only for cross table
				
	'auth_user_group_text' => $bridge_type_name . '_auth_user_group',
	'auth_alt_user_group_text' => $bridge_type_name. '_alt_auth_user_group',
	
	// Table Name were save all  Groups/Class Infos
	'db_table_allgroups' => "userclass_classes",
	// Column Name for the ID field for the Group/Class.
	'db_allgroups_id' => "userclass_id",
	// Column Name for the Groups/Class Name field.
	'db_allgroups_name' => "userclass_name",

	//utf8 Support
	'bridge_utf8_support' => "yes",

);

?>