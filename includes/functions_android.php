<?php

/* * *************************************************************************
 *                               functions_android.php
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

//Converts array to Object
function parseArrayToObject($array) {
    $object = new stdClass();
    if (is_array($array) && count($array) > 0) {
        foreach ($array as $name => $value) {
            $name = strtolower(trim($name));
            if (!empty($name)) {
                $object->$name = $value;
            }
        }
    }
    return $object;
}

//Checks username and password
function CheckLog($username, $password) {
    global $phpraid_config;
    global $db_raid;
    $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "profile WHERE username='" . $username . "'";
    $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
    $data = $db_raid->sql_fetchrow($result, true);

    if ($data['username'] == $username && $data['password'] == $password)
        return "logged";
    else
        return "failed";
}

//Gets Profile ID
function GetUserID($username) {
    global $phpraid_config;
    global $db_raid;
    $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "profile WHERE username='" . $username . "'";
    $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
    $data = $db_raid->sql_fetchrow($result, true);
    return $data['profile_id'];
}

//Gets Guild name from ID
function GetGuildName($guild_id) {
    global $phpraid_config;
    global $db_raid;
    $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "guilds
        WHERE guild_id='" . $guild_id . "'";
    $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
    $data = $db_raid->sql_fetchrow($result, true);
    return $data['guild_name'];
}

//Checks and makes sure you can sign up
function CheckmultiSigns($raid_id, $profile_id) {
    global $db_raid;
    global $phpraid_config;
    if ($phpraid_config['multiple_signups'] == 0) {
        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "signups
                    WHERE raid_id='" . $raid_id . "' AND profile_id='" . $profile_id . "'";
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        if ($db_raid->sql_numrows($result) > 0) {
            return 0;
        } else {
            return 1;
        }
    }
}

//Checks if raidforce is enabled and if is checks if guild is good
function CheckraidForce($raid_force, $guild_id) {
    global $db_raid;
    global $phpraid_config;
    if ($raid_force != 'All') {

        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raid_force
                    WHERE raid_force_name='" . $raid_force . "'";
        $raid_force_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        while ($raid_force_data = $db_raid->sql_fetchrow($raid_force_result, true)) {
            if ($raid_force_data['guild_id'] != $guild_id) {
                $show_signup = 0;
            } else {
                $show_signup = 1;
            }
        }
        if ($show_signup) {
            return 1;
        } else {
            return 0;
        }
    } else {
        return 1;
    }
}

//Checks and makes sure the raid isn't full or class/role is full
function CheckraidFull($raid_id, $char_id, $queue) {
    global $db_raid;
    global $phpraid_config;
    if (!$queue) {
        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "chars
                WHERE char_id = '" . $char_id . "'";
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        $char_data = $db_raid->sql_fetchrow($result, true);

        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids
                WHERE raid_id = '" . $raid_id . "'";
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        $raid_data = $db_raid->sql_fetchrow($result, true);

        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "class_role
                WHERE subclass = '" . $char_data['pri_spec'] . "' AND class_id ='" . $char_data['class'] . "'";
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        $role_data = $db_raid->sql_fetchrow($result, true);
        $role_id = $role_data['role_id'];

        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "signups
                WHERE raid_id = '" . $raid_id . "' AND selected_spec = '" . $char_data['pri_spec'] . "'";
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        $role_signed_up = $db_raid->sql_numrows($result);

        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "signups
                WHERE raid_id = '" . $raid_id . "' AND cancel = '0' AND queue = '0'";
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        $total_signed_up = $db_raid->sql_numrows($result);

        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "signups
                WHERE raid_id = '" . $raid_id . "'";
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        $x = 0;
        while ($signup_result = $db_raid->sql_fetchrow($result, true)) {
            $sql2 = "SELECT * FROM " . $phpraid_config['db_prefix'] . "chars
                WHERE char_id = '" . $signup_result['char_id'] . "'";
            $result2 = $db_raid->sql_query($sql2) or print_error($sql2, $db_raid->sql_error(), 1);
            $signedtoon = $db_raid->sql_fetchrow($result2, true);
            if ($signedtoon['class'] == $char_data['class']) {
                $x++;
            }
        }

        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raid_role_lmt
                WHERE raid_id = '" . $raid_id . "' AND role_id ='" . $role_id . "'";
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        $role_lmt_data = $db_raid->sql_fetchrow($result, true);

        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raid_class_lmt
                WHERE raid_id = '" . $raid_id . "' AND class_id ='" . $char_data['class'] . "'";
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        $class_lmt_data = $db_raid->sql_fetchrow($result, true);

        if ($phpraid_config['enforce_role_limits']) {
            If ($role_lmt_data['lmt'] <= $role_signed_up) {
                $queue = 1;
            }
        }
        if ($phpraid_config['enforce_class_limits']) {
            If ($class_lmt_data['lmt'] <= $x) {
                $queue = 1;
            }
        }
        if ($total_signed_up >= $raid_data['max']) {
            $queue = 1;
        }
    } else {
        $queue = 1;
    }
    return $queue;
}

//Converts Guild id into Guild Faction
function GetGuildFaction($guild_id) {
    global $db_raid;
    global $phpraid_config;
    if (!$queue) {
        $sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "guilds
                WHERE guild_id = '" . $guild_id . "'";
        $result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
        $guild_data = $db_raid->sql_fetchrow($result, true);
    }
    return $guild_data['guild_faction'];
}
?>
