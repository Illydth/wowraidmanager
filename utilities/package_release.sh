#!/bin/sh

# Set Directory / File Write permissions.
chmod 777 raid_lua
chmod 777 wowchar-tooltips/cache
chmod 777 wowitem-tooltips/cache

# Remove Prior Package Directory
rm -rf package

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

# db
cd db
chmod a-x *.php
cd ..

# Docs
cd docs
chmod a-x *
cd ..

# Includes
cd includes
chmod a-x *.php
cd ..

# Install
cd install
chmod a-x *.php
chmod a-x logo_phpRaid.gif
cd auth
chmod a-x *.php
cd ..
cd database_schema
cd install
chmod a-x *.sql
cd ..
cd upgrade
chmod a-x *.sql
cd ..
cd ..
cd ..

# Language
cd language
cd lang_english
chmod a-x *.php
cd ..
cd lang_german
chmod a-x *.php
cd ..
cd ..

# raid_lua
cd raid_lua
chmod a-x *.lua
cd ..

# Templates
cd templates
cd SpiffyJr
chmod a-x *.htm
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
cd ..
cd resistances
chmod a-x *.gif
chmod a-x *.jpg
chmod a-x *.ico
chmod a-x *.png
cd ..
cd ..
cd scripts
chmod a-x *.js
cd ..
cd style
chmod a-x *.php
cd ..
cd ..
cd ..

# wowchar-tooltip
cd wowchar-tooltip
chmod a-x *.php
cd css
chmod a-x *.css
cd ..
cd image
chmod a-x *.gif
cd icons
cd class
chmod a-x *.png
cd ..
cd race
chmod a-x *.png
cd ..
cd ..
cd portraits
cd 1-59
chmod a-x *.gif
cd ..
cd 60-69
chmod a-x *.gif
cd ..
cd 70
chmod a-x *.gif
cd ..
cd ..
cd ..
cd js
chmod a-x *.js
cd ..
cd lang
chmod a-x *.php
cd ..
cd ..

# wowitem-tooltip
cd wowitem-tooltip
chmod a-x *.php
cd css
chmod a-x *.css
cd ..
cd image
chmod a-x *.gif
chmod a-x *.png
cd ..
cd js
chmod a-x *.js
cd ..
cd ..

##################################################
# File Mods are now set, package up the release.
##################################################

#Creating Working Directories and Files
mkdir package
mkdir package/wrm
cp -R * package/wrm
cd package

#Remove Misc Stuff
rm -rf wrm/utilities
rm -rf wrm/package
rm -f wrm/config.php
rm -f wrm/wowitem-tooltip/cache/*
rm -f wrm/wowchar-tooltip/cache/*

#Build the Packages
tar -czvf wowRaidManager_v$1.tar.gz wrm/*
zip -r wowRaidManager_v$1.zip wrm

#Final Packages should be in <root>/package at this point, ready for disbursal, remove temp directories
rm -rf wrm
