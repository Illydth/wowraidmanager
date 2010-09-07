#!/bin/sh

#cd ..
#cd ..
cd /tmp
# Remove Prior Package Directory and Re-Create
rm -rf package

#Creating Working Directories and Files
mkdir /tmp/package
mkdir /tmp/package/wrm
cp -R /opt/WRM/wowraidmanager/* /tmp/package/wrm
cd /tmp/package

#Remove Misc Stuff
rm -rf wrm/utilities
cp wrm/config.php.tmp wrm/config.php
rm -f wrm/config.php.*

###############################
#Start Permissions Work
###############################
cd wrm

# Remove Cache and Compilations
rm -rf armory_log/stderr.log
rm -rf raid_lua/phpRaid_Data.lua
rm -rf smarty_cache/*
rm -rf smarty_cache/admin/*
rm -rf templates_c/*
rm -rf templates_c/admin/*
rm -rf armory_cache/*

# Set Directory / File Write permissions.
chmod 777 cache/
chmod 777 cache/armory_log
chmod 777 cache/armory_cache
chmod 777 cache/raid_lua
chmod 777 cache/smarty_cache
chmod 777 cache/smarty_cache/admin
chmod 777 cache/templates_c
chmod 777 cache/templates_c/admin

chmod 777 config.php

# recursive chmod
chmod -R a-x *

cd ..

##################################################
# File Mods are now set, package up the release.
##################################################

#Build the Packages
tar -czvf wowRaidManager_v$1.tar.gz wrm/*
zip -r wowRaidManager_v$1.zip wrm

#Final Packages should be in <root>/utilities/package at this point, ready for disbursal, remove temp directories
rm -rf wrm
