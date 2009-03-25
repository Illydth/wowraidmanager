#!/bin/sh

# Remove Prior Package Directory and Re-Create
rm -rf ../package

#Creating Working Directories and Files
mkdir ../package
mkdir ../package/wrm
cp -R * ../package/wrm
cd ../package

#Remove Misc Stuff
rm -rf wrm/utilities
rm -f wrm/config.php
rm -f wrm/config.php.*

###############################
#Start Permissions Work
###############################
cd wrm

# Set Directory / File Write permissions.
chmod 777 cache/
chmod 777 cache/armory_log
chmod 777 cache/raid_lua
chmod 777 cache/smarty_cache
chmod 777 cache/templates_c

# Remove Cache and Compilations
cd cache
rm -rf armory_log/stderr.log
rm -rf raid_lua/phpRaid_Data.lua
rm -rf smarty_cache/*
rm -rf templates_c/*

# Base Directory
chmod a-x *.php
chmod a-x *.ico
chmod a-x *.txt
chmod a-x README
chmod a-x .htaccess

# auth
cd auth
chmod a-x *.php
chmod a-x temp.htaccess
cd ..

# Docs
cd docs
chmod a-x *
cd ..

# Includes
cd includes
chmod a-x *.php
cd smarty/libs/
chmod a-x *.php
chmod a-x *.tpl
cd internals
chmod a-x *.php
cd ..
cd plugins
chmod a-x *.php
cd ..
cd ..
cd ..
cd wowarmory
chmod a-x *.php
chmod a-x images/*.gif
chmod a-x images/*.png
cd includes
chmod a-x *.php
chmod a-x doc/*.html
chmod a-x doc/media/*.css
chmod a-x doc/phpArmory/*.html
cd ..
chmod a-x js/*.js
chmod a-x languages/*.php
chmod a-x stats_conf/*.php
chmod a-x template/css/*.css
chmod a-x template/html/default/*.html
chmod a-x template/html/wowhead/*.html
cd ..
cd ..

# Install
cd install
chmod a-x *.php
chmod a-x logo_phpRaid.*
chmod a-x auth/*.php
chmod a-x database_schema/install/*.sql
chmod a-x database_schema/upgrade/*.sql
chmod a-x language/*.php
chmod a-x stylesheet/*.css
cd ..

# Language
cd language
chmod a-x lang_chinese/*.php
chmod a-x lang_english/*.php
chmod a-x lang_french/*.php
chmod a-x lang_german/*.php
chmod a-x lang_italian/*.php
chmod a-x lang_norwegian/*.php
chmod a-x lang_swedish/*.php
cd ..

# Scripts
cd scripts
chmod a-x *.js
cd ..

# Templates
cd templates/default
chmod a-x *.html
chmod a-x *.php
cd images
chmod a-x *.gif
chmod a-x *.jpg
chmod a-x *.ico
chmod a-x *.png
cd classes
chmod a-x *.gif
chmod a-x *.jpg
chmod a-x *.ico
chmod a-x *.png
cd ..
cd faces
chmod a-x *.gif
chmod a-x *.jpg
chmod a-x *.ico
chmod a-x *.png
cd ..
cd icons
chmod a-x *.gif
chmod a-x *.jpg
chmod a-x *.ico
chmod a-x *.png
chmod a-x *.psd
cd ..
cd resistances
chmod a-x *.gif
chmod a-x *.jpg
chmod a-x *.ico
chmod a-x *.png
cd ..
cd instances
chmod a-x *.txt
chmod a-x BC_Icons/*
chmod a-x Classic_Icons/*
chmod a-x Misc_Icons/*
chmod a-x source/*
chmod a-x WotLK_Icons/*
cd ..
cd ..
cd style
chmod a-x *.css
cd ..
cd ..
cd ..
cd ..

##################################################
# File Mods are now set, package up the release.
##################################################

#Build the Packages
tar -czvf wowRaidManager_v$1.tar.gz wrm/*
zip -r wowRaidManager_v$1.zip wrm

#Final Packages should be in <root>/utilities/package at this point, ready for disbursal, remove temp directories
rm -rf wrm
