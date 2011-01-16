<?php
/* * *************************************************************************
 *                               index.php
 *                            -------------------
 *   begin                : Sunday, Apr 19, 2009
 *   copyright            : (C) 2005 FlintmanComputers
 *   email                :  flintman@FlintmanComputers.com
 *
 *
 * ************************************************************************* */

/* * *************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 * ************************************************************************* */
// commons
define("IN_PHPRAID", true);
require_once('./common.php');
require_once('./includes/functions_android.php');

$version = "2";

//Gets you Logged in 
if ($_POST['action'] == "login") {
    $username = scrub_input($_POST['var1']);
    $password = scrub_input($_POST['var2']);
    echo CheckLog($username, $password);
}

//Checks version of website
elseif ($_POST['action'] == "check_version") {
    $version_pull = scrub_input($_POST['var1']);
    if ($version_pull == $version)
        echo "correct";
    else
        echo "wrong";
}

//Gets Raids List that haven't expired or are frozen and you anrn't signuped to
elseif ($_POST['action'] == "getraidlist") {
    $username = scrub_input($_POST['var1']);
    $password = scrub_input($_POST['var2']);
    $limit = scrub_input($_POST['var3']);
    $raid_array = array();

    if (CheckLog($username, $password) == "logged") {
        // load configuration variables into configuration array
        $profile_id = GetUserID($username);
        $raid_array = array();
        $time = time();
        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids
                WHERE invite_time > '" . $time . "' AND old = '0' LIMIT " . $limit . "";
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        array_push($raid_array, array('test' => $tes));
        while ($data = $db_raid->sql_fetchrow($result, true)) {
            $show_signup = 1;
            // check if raid is frozen
            if ($phpraid_config['disable_freeze'] == 0) {
                if (check_frozen($data['raid_id'])) {
                    $show_signup = 0;
                }
            }

            //Checks if you are already signed up
            $sql2 = "SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id='" . $data['raid_id'] . "'
                AND profile_id='" . $profile_id . "'";
            $result2 = $db_raid->sql_query($sql2) or print_error($sql2, $db_raid->sql_error(), 1);
            if ($db_raid->sql_numrows($result2) > 0) {
                $show_signup = 0;
            }

            //Checkes if Raid Force is enabled and if you have a toon in that guild
            if ($data['raid_force_name'] != 'All') {
                $sql3 = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raid_force WHERE raid_force_name='" . $data['raid_force_name'] . "'";
                $raid_force_result = $db_raid->sql_query($sql3) or print_error($sql3, $db_raid->sql_error(), 1);
                $char_in_guild_check = false;
                while ($raid_force_data = $db_raid->sql_fetchrow($raid_force_result, true)) {
                    $sql4 = "SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE
								profile_id='" . $profile_id . "' AND guild='" . $raid_force_data['guild_id'] . "'";
                    $char_in_guild_result = $db_raid->sql_query($sql4) or print_error($sql4, $db_raid->sql_error(), 1);
                    $char_count = $db_raid->sql_numrows($char_in_guild_result);
                    if ($char_count <= 0)
                        $show_signup = 0;
                }
            }
            //Checks if you have any Toons within the level
            $sql5 = "SELECT * FROM " . $phpraid_config['db_prefix'] . "chars " .
                    "	WHERE profile_id='" . $profile_id . "' AND lvl<='" . $data['max_lvl'] . "'
                                AND lvl>='" . $data['max_lvl'] . "'";
            $result3 = $db_raid->sql_query($sql5) or print_error($sql5, $db_raid->sql_error(), 1);
            $char_count = $db_raid->sql_numrows($result3);
            if ($char_count <= 0) {
                $show_signup = 0;
            }


            // setup array for data output as long as you have someone that can sign up
            if ($show_signup != 0) {
                array_push($raid_array, array(
                    'raid_id' => $data['raid_id'],
                    'location' => $data['location'],
                    'invite_time' => new_date($phpraid_config['date_format'], $data['invite_time'], $phpraid_config['timezone'] + $phpraid_config['dst']) . ' ' .
                    new_date($phpraid_config['time_format'], $data['invite_time'], $phpraid_config['timezone'] + $phpraid_config['dst']),
                    'description' => strip_tags($data['description'])));
            }
        }
        $raid_array = parseArrayToObject($raid_array);
        header('Content-type: application/json');
        $raid = json_encode($raid_array);
        echo $raid;
    } else {
        echo "Hack Attempt";
    }
}

//Gets Raids List that haven't expired that you are signed up too
elseif ($_POST['action'] == "getsignraidlist") {
    $username = scrub_input($_POST['var1']);
    $password = scrub_input($_POST['var2']);
    $raid_array = array();
    if (CheckLog($username, $password) == "logged") {
        // load configuration variables into configuration array
        $profile_id = GetUserID($username);
        $raid_array = array();
        $time = time();
        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids
                WHERE invite_time > '" . $time . "' AND old = '0'";
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        array_push($raid_array, array('test' => $tes));

        while ($data = $db_raid->sql_fetchrow($result, true)) {
            $sql2 = "SELECT * FROM " . $phpraid_config['db_prefix'] . "signups
                WHERE profile_id = '" . $profile_id . "' AND raid_id = '" . $data['raid_id'] . "' AND cancel ='0'";
            $result2 = $db_raid->sql_query($sql2) or print_error($sql2, $db_raid->sql_error(), 1);
            $char_count = $db_raid->sql_numrows($result2);
            // setup array for data output as long as you have someone that can sign up
            if ($char_count != 0) {
                array_push($raid_array, array(
                    'raid_id' => $data['raid_id'],
                    'location' => $data['location'],
                    'invite_time' => new_date($phpraid_config['date_format'], $data['invite_time'], $phpraid_config['timezone'] + $phpraid_config['dst']) . ' ' .
                    new_date($phpraid_config['time_format'], $data['invite_time'], $phpraid_config['timezone'] + $phpraid_config['dst']),
                    'description' => strip_tags($data['description'])));
            }
        }
        $raid_array = parseArrayToObject($raid_array);
        header('Content-type: application/json');
        $raid = json_encode($raid_array);
        echo $raid;
    } else {
        echo "Hack Attempt";
    }
}

//Gets Toons signed up for raid
elseif ($_POST['action'] == "getsigntoonlist") {
    $username = scrub_input($_POST['var1']);
    $password = scrub_input($_POST['var2']);
    $raid_id = scrub_input($_POST['var3']);
    $toon_array = array();
    if (CheckLog($username, $password) == "logged") {
        // load configuration variables into configuration array
        $profile_id = GetUserID($username);
        $toon_array = array();
        $time = time();
        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "signups
                WHERE raid_id = '" . $raid_id . "' AND cancel = '0' AND queue = '0'";
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        array_push($toon_array, array('test' => $tes));

        while ($data = $db_raid->sql_fetchrow($result, true)) {
            $sql2 = "SELECT * FROM " . $phpraid_config['db_prefix'] . "chars
                WHERE char_id = '" . $data['char_id'] . "'";
            $result2 = $db_raid->sql_query($sql2) or print_error($sql2, $db_raid->sql_error(), 1);
            $char_data = $db_raid->sql_fetchrow($result2, true);

            array_push($toon_array, array(
                'toon_id' => $char_data['char_id'],
                'name' => $char_data['name'],
                'lvl' => $char_data['lvl'],
                'class' => $char_data['class'],
            ));
        }
        $toon_array = parseArrayToObject($toon_array);
        header('Content-type: application/json');
        $toon = json_encode($toon_array);
        echo $toon;
    } else {
        echo "Hack Attempt";
    }
}

//Gets Toons queued up for raid
elseif ($_POST['action'] == "getqueuetoonlist") {
    $username = scrub_input($_POST['var1']);
    $password = scrub_input($_POST['var2']);
    $raid_id = scrub_input($_POST['var3']);
    $toon_array = array();
    if (CheckLog($username, $password) == "logged") {
        // load configuration variables into configuration array
        $profile_id = GetUserID($username);
        $toon_array = array();
        $time = time();
        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "signups
                WHERE raid_id = '" . $raid_id . "' AND cancel = '0' AND queue = '1'";
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        array_push($toon_array, array('test' => $tes));

        while ($data = $db_raid->sql_fetchrow($result, true)) {
            $sql2 = "SELECT * FROM " . $phpraid_config['db_prefix'] . "chars
                WHERE char_id = '" . $data['char_id'] . "'";
            $result2 = $db_raid->sql_query($sql2) or print_error($sql2, $db_raid->sql_error(), 1);
            $char_data = $db_raid->sql_fetchrow($result2, true);

            array_push($toon_array, array(
                'toon_id' => $char_data['char_id'],
                'name' => $char_data['name'],
                'lvl' => $char_data['lvl'],
                'class' => $char_data['class'],
            ));
        }
        $toon_array = parseArrayToObject($toon_array);
        header('Content-type: application/json');
        $toon = json_encode($toon_array);
        echo $toon;
    } else {
        echo "Hack Attempt";
    }
}


//Gets Toons 
elseif ($_POST['action'] == "gettoonlist") {
    $username = scrub_input($_POST['var1']);
    $password = scrub_input($_POST['var2']);
    $char_id = scrub_input($_POST['var3']);
    if (CheckLog($username, $password) == "logged") {
        // load configuration variables into configuration array
        $profile_id = GetUserID($username);
        $toon_array = array();
        if ($char_id == "") {
            $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "chars
        WHERE profile_id = '" . $profile_id . "'";
        } else {
            $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "chars
        WHERE char_id = '" . $char_id . "' AND profile_id = '" . $profile_id . "'";
        }
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        array_push($toon_array, array('test' => $tes));
        while ($data = $db_raid->sql_fetchrow($result, true)) {
            // setup array for data output
            $guild_name = GetGuildName($data['guild']);
            array_push($toon_array, array(
                'toon_id' => $data['char_id'],
                'toon_name' => $data['name'],
                'toon_lvl' => $data['lvl'],
                'race_name' => $data['race'],
                'guild_name' => $guild_name,
                'guild_id' => $data['guild'],
                'class_name' => $data['class'],
                'gender_name' => $data['gender'],
                'arcane' => $data['arcane'],
                'fire' => $data['fire'],
                'frost' => $data['frost'],
                'nature' => $data['nature'],
                'shadow' => $data['shadow'],
                'pri_spec' => $data['pri_spec'],
                'sec_spec' => $data['sec_spec']
            ));
        }
        $toon_array = parseArrayToObject($toon_array);
        header('Content-type: application/json');
        $toon = json_encode($toon_array);
        echo $toon;
    } else {
        echo "Hack Attempt";
    }
}

//Gets site anouncments
elseif ($_POST['action'] == "getannouncement") {
    $username = scrub_input($_POST['var1']);
    $password = scrub_input($_POST['var2']);
    $limit = scrub_input($_POST['var3']);

    if (CheckLog($username, $password) == "logged") {
        $announcement_array = array();
        array_push($announcement_array, array('test' => $tes));
        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "announcements ORDER BY timestamp DESC LIMIT " . $limit . "";
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        while ($data = $db_raid->sql_fetchrow($result, true)) {
            array_push($announcement_array,
                    array(
                        'title' => strip_tags($data['title']),
                        'msg' => strip_tags($data['message']),
                        'announcements_id' => $data['announcements_id'],
                        'timestamp' => new_date($phpraid_config['date_format'], $data['timestamp'], $phpraid_config['timezone'] + $phpraid_config['dst']) . ' '
                        . new_date($phpraid_config['time_format'], $data['timestamp'], $phpraid_config['timezone'] + $phpraid_config['dst']),
                    )
            );
        }
        $announcement_array = parseArrayToObject($announcement_array);
        header('Content-type: application/json');
        $announce = json_encode($announcement_array);
        echo $announce;
    } else {
        echo "Hack Attempt";
    }
}
//Gets Raids Info
elseif ($_POST['action'] == "getraidinfo") {
    $username = scrub_input($_POST['var1']);
    $password = scrub_input($_POST['var2']);
    $raid_id = scrub_input($_POST['var3']);
    $raid_array = array();

    if (CheckLog($username, $password) == "logged") {
        // load configuration variables into configuration array
        $raid_array = array();

        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids
        WHERE raid_id = '" . $raid_id . "'";
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        $raid_data = $db_raid->sql_fetchrow($result, true);

        //Gets total Signed up
        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "signups
        WHERE raid_id ='" . $raid_id . "' AND queue = '0' AND cancel = '0'";
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        $totalsigned = $db_raid->sql_numrows($result, true);

        //Gets total Signed up
        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "signups
        WHERE raid_id ='" . $raid_id . "' AND queue = '1' AND cancel = '0'";
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        $totalqueue = $db_raid->sql_numrows($result, true);

        array_push($raid_array, array('test' => $tes));
        array_push($raid_array, array(
            'raid_id' => $raid_data['raid_id'],
            'location' => $raid_data['location'],
            'invite_time' => new_date($phpraid_config['date_format'], $raid_data['invite_time'], $phpraid_config['timezone'] + $phpraid_config['dst']) . ' ' .
            new_date($phpraid_config['time_format'], $raid_data['invite_time'], $phpraid_config['timezone'] + $phpraid_config['dst']),
            'description' => strip_tags($raid_data['description']),
            'maximum' => $raid_data['max'],
            'raid_leader' => $raid_data['officer'],
            'maximum_level' => $raid_data['max_lvl'],
            'minimum_level' => $raid_data['min_lvl'],
            'total_signed' => $totalsigned,
            'total_queue' => $totalqueue,
        ));

        $raid_array = parseArrayToObject($raid_array);
        header('Content-type: application/json');
        $test = json_encode($raid_array);
        echo $test;
    } else {
        echo "Hack Attempt";
    }
}
//Gets toons that can sign up for raid
elseif ($_POST['action'] == "gettoonsforraid") {
    $username = scrub_input($_POST['var1']);
    $password = scrub_input($_POST['var2']);
    $raid_id = scrub_input($_POST['var3']);
    $toon_array = array();
    if (CheckLog($username, $password) == "logged") {
        // load configuration variables into configuration array
        $profile_id = GetUserID($username);
        $time = time();

        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids
                WHERE raid_id = '" . $raid_id . "'";
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        $raid_data = $db_raid->sql_fetchrow($result, true);
        array_push($toon_array, array('test' => $tes));

        $sql2 = "SELECT * FROM " . $phpraid_config['db_prefix'] . "chars
                WHERE profile_id = '" . $profile_id . "' AND lvl >='" . $raid_data['min_lvl'] . "'
                    AND lvl <='" . $raid_data['max_lvl'] . "'";
        $result2 = $db_raid->sql_query($sql2) or print_error($sql2, $db_raid->sql_error(), 1);

        while ($char_data = $db_raid->sql_fetchrow($result2, true)) {
            $show_signup = 1;
            // check if already signed up
            if (CheckmultiSigns($raid_id, $profile_id)) {
                if (CheckraidForce($raid_data['raid_force_name'], $char_data['guild'])) {
                    array_push($toon_array, array(
                        'toon_id' => $char_data['char_id'],
                        'name' => $char_data['name'],
                    ));
                }
            }
        }
        $toon_array = parseArrayToObject($toon_array);
        //  header('Content-type: application/json');
        $toon = json_encode($toon_array);
        echo $toon;
    } else {
        echo "Hack Attempt";
    }
}

//Sign up
elseif ($_POST['action'] == "signupraid") {
    $username = scrub_input($_POST['var1']);
    $password = scrub_input($_POST['var2']);
    $raid_id = scrub_input($_POST['var3']);
    $char_id = scrub_input($_POST['var4']);
    $status_id = scrub_input($_POST['var5']);
    $comments = escapePOPUP(scrub_input($_POST['var6']));
    $time = time();

    if (CheckLog($username, $password) == "logged") {
        // load configuration variables into configuration array
        $profile_id = GetUserID($username);
        if ($status_id == "Queue") {
            $queue = 1;
        } elseif ($status_id == "Signup") {
            $queue = 0;
        }
        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids
                WHERE raid_id = '" . $raid_id . "'";
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        $raid_data = $db_raid->sql_fetchrow($result, true);

        $sql2 = "SELECT * FROM " . $phpraid_config['db_prefix'] . "chars
                WHERE char_id = '" . $char_id . "'";
        $result2 = $db_raid->sql_query($sql2) or print_error($sql2, $db_raid->sql_error(), 1);
        $char_data = $db_raid->sql_fetchrow($result2, true);
        // check if already signed up
        if (CheckmultiSigns($raid_id, $profile_id)) {
            if (CheckraidForce($raid_data['raid_force_name'], $char_data['guild'])) {
                $queue = CheckraidFull($raid_id, $char_id, $queue);
                $sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "signups
                            	(`char_id`,`profile_id`,`raid_id`,`comments`,`queue`,`timestamp`,`cancel`,`selected_spec`)
                              VALUES('" . $char_id . "','" . $profile_id . "','" . $raid_id . "','" . $comments . "', '" . $queue . "','" . $time . "','0','" . $char_data['pri_spec'] . "')";
                $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
                echo "All signed up";
            } else {
                echo "You arn't in the right guild";
            }
        } else {
            echo "You all ready have a toon signed up";
        }
    } else {
        echo "Hack Attempt";
    }
}

//Cancel Signups
elseif ($_POST['action'] == "cancelsignup") {
    $username = scrub_input($_POST['var1']);
    $password = scrub_input($_POST['var2']);
    $raid_id = scrub_input($_POST['var3']);
    if (CheckLog($username, $password) == "logged") {
        // load configuration variables into configuration array
        $profile_id = GetUserID($username);
        $toon_array = array();
        $sql = "UPDATE " . $phpraid_config['db_prefix'] . "signups set cancel='1'
            WHERE profile_id='" . $profile_id . "' AND raid_id='" . $raid_id . "'";
        $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

        echo "You canceled from this raid";
    } else {
        echo "Hack Attempt";
    }
}

//Gets guild list
elseif ($_POST['action'] == "getguildlist") {
    $username = scrub_input($_POST['var1']);
    $password = scrub_input($_POST['var2']);
    if (CheckLog($username, $password) == "logged") {
        $guild_array = array();
        array_push($guild_array, array('test' => $tes));
        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "guilds";
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        while ($data = $db_raid->sql_fetchrow($result, true)) {
            array_push($guild_array,
                    array(
                        'guild_id' => $data['guild_id'],
                        'guild_name' => $data['guild_name'],
                    )
            );
        }
        $guild_array = parseArrayToObject($guild_array);
        header('Content-type: application/json');
        $guild = json_encode($guild_array);
        echo $guild;
    } else {
        echo "Hack Attempt";
    }
}

//Gets race list
elseif ($_POST['action'] == "getracelist") {
    $username = scrub_input($_POST['var1']);
    $password = scrub_input($_POST['var2']);
    $guild_id = scrub_input($_POST['var3']);
    if (CheckLog($username, $password) == "logged") {
        $faction = GetGuildFaction($guild_id);
        $race_array = array();
        array_push($race_array, array('test' => $tes));
        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "races WHERE faction = '" . $faction . "'";
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        while ($data = $db_raid->sql_fetchrow($result, true)) {
            array_push($race_array,
                    array(
                        'race_id' => $data['race_id'],
                    )
            );
        }
        $race_array = parseArrayToObject($race_array);
        header('Content-type: application/json');
        $race = json_encode($race_array);
        echo $race;
    } else {
        echo "Hack Attempt";
    }
}

//Gets class list
elseif ($_POST['action'] == "getclasslist") {
    $username = scrub_input($_POST['var1']);
    $password = scrub_input($_POST['var2']);
    $race_id = scrub_input($_POST['var3']);
    if (CheckLog($username, $password) == "logged") {
        $class_array = array();
        array_push($class_array, array('test' => $tes));
        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "class_race WHERE race_id = '" . $race_id . "'";
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        while ($data = $db_raid->sql_fetchrow($result, true)) {
            array_push($class_array,
                    array(
                        'class_id' => $data['class_id'],
                    )
            );
        }
        $class_array = parseArrayToObject($class_array);
        header('Content-type: application/json');
        $class = json_encode($class_array);
        echo $class;
    } else {
        echo "Hack Attempt";
    }
}

//Gets role for class list
elseif ($_POST['action'] == "getrolelist") {
    $username = scrub_input($_POST['var1']);
    $password = scrub_input($_POST['var2']);
    $class_id = scrub_input($_POST['var3']);
    if (CheckLog($username, $password) == "logged") {
        $role_array = array();
        array_push($role_array, array('test' => $tes));
        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "class_role WHERE class_id = '" . $class_id . "'";
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        while ($data = $db_raid->sql_fetchrow($result, true)) {
            array_push($role_array,
                    array(
                        'role_id' => $data['subclass'],
                    )
            );
        }
        $role_array = parseArrayToObject($role_array);
        header('Content-type: application/json');
        $role = json_encode($role_array);
        echo $role;
    } else {
        echo "Hack Attempt";
    }
}

//updates or adds new toon
elseif ($_POST['action'] == "new_edit_toon") {
    $username = scrub_input($_POST['var1']);
    $password = scrub_input($_POST['var2']);
    $action = scrub_input(strtolower($_POST['var3']));
    if (CheckLog($username, $password) == "logged") {
        $profile_id = GetUserID($username);
        $toon_name = scrub_input($_POST['var4']);
        $toon_lvl = scrub_input($_POST['var5']);
        $toon_guild = scrub_input($_POST['var6']);
        $toon_race = scrub_input($_POST['var7']);
        $toon_class = scrub_input($_POST['var8']);
        $toon_gender = scrub_input($_POST['var9']);
        $toon_arcane = scrub_input($_POST['var10']);
        $toon_fire = scrub_input($_POST['var11']);
        $toon_frost = scrub_input($_POST['var12']);
        $toon_nature = scrub_input($_POST['var13']);
        $toon_shadow = scrub_input($_POST['var14']);
        $toon_role1 = scrub_input($_POST['var15']);
        $toon_role2 = scrub_input($_POST['var16']);
        $toon_id = scrub_input($_POST['var17']);

        if ($action == "edit") {
            char_edit($toon_name, $toon_lvl, $toon_race, $toon_class, $toon_gender, $toon_guild,
                    $toon_arcane, $toon_nature, $toon_shadow, $toon_fire, $toon_frost, $toon_role1,
                    $toon_role2, $toon_id);
            echo $toon_name . " has been updated";
        } else {
            char_addnew($profile_id, $toon_name, $toon_class, $toon_gender, $toon_guild, $toon_lvl,
                    $toon_race, $toon_arcane, $toon_fire, $toon_frost, $toon_nature,
                    $toon_shadow, $toon_role1, $toon_role2);
            echo $toon_name . " has been Added";
        }
    } else {
        echo "Hack Attempt";
    }
}else{
   echo "Hack Attempt";
}
?>
