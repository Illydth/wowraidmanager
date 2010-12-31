#!/bin/sh

cd ..
cd ..
#cd /home/neme/WRM
# Remove Prior Package Directory and Re-Create
rm -rf package

#Creating Working Directories and Files
#mkdir /home/neme/WRM/package
#mkdir /home/neme/WRM/package/wrm
#cp -R /home/neme/WRM/wowraidmanager/* /home/neme/WRM/package/wrm
#cd /home/neme/WRM/package

mkdir package
mkdir package/wrm
cp -R wowraidmanager/* package/wrm
cd package

#Remove Misc Stuff
rm -rf wrm/utilities

#Create (empty) config.php
cp wrm/config.php.tmp wrm/config.php
rm -f wrm/config.php.*

###############################
#Start Permissions Work
###############################
cd wrm

# Remove Cache and Compilations
rm -rf cache
rm -rf install/cache


# Create Directory
mkdir install/cache
mkdir install/cache/smarty_cache
mkdir install/cache/templates_c

mkdir cache
mkdir cache/armory_log
mkdir cache/armory_cache
mkdir cache/raid_lua
mkdir cache/templates_c
mkdir cache/templates_c/admin
mkdir cache/smarty_cache
mkdir cache/smarty_cache/admin

# Set Directory / File Write permissions.
chmod 777 cache/
chmod 777 cache/armory_log
chmod 777 cache/armory_cache
chmod 777 cache/raid_lua
chmod 777 cache/smarty_cache
chmod 777 cache/smarty_cache/admin
chmod 777 cache/templates_c
chmod 777 cache/templates_c/admin
chmod 777 install/cache
chmod 777 install/cache/smarty_cache
chmod 777 install/cache/templates_c

chmod 666 config.php

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
#chmod -R +w *
rm -rf wrm

echo "Please check that Smarty Debug has been turned off in Common.php."
echo "Please also check that error_reporting has been set to Error, Warning and Parse ONLY in common.php."
echo "If this is not the case, please correct these settings and re-build the package."
