#!/bin/bash

set -e

echo ""
echo "Welcome to nZEDb Bootstrap!"
echo "----------------------------------"
echo ""
echo "Starting the installation process..."
echo ""

//exec git clone git://github.com/nZEDb/nZEDb.git
exec git clone git@77.99.35.102:li3_nzedb.git
clear;

//cd nZEDb
cd li3_nzedb

# You can comment this out if you have lithium installed else where
# Don't forget to alter the libraries.php file to set the LITHIUM_LIBRARY_PATH
git submodule add git@github.com/UnionOfRAD/lithium.git libraries/lithium

# If you're working on the code you should uncomment this and the line in
# <app>/config/libraries.php which enables it.
#git submodule add https://github.com/UnionOfRAD/li3_docs.git libraries/li3_docs

git submodule add git@github.com:michaelhue/li3_flash_message.git libraries/li3_flash_message
git submodule add git@github.com/eLod/li3_mailer.git libraries/li3_mailer
git submodule add git@github.com/UnionOfRAD/li3_quality.git libraries/li3_quality
git submodule add git@github.com/nZEDb/nZEDb.git libraries/nZEDb

echo ""
echo "Setting application directory permissions..."
chmod -R 777 resources
echo ""

echo ""
echo "Getting all necessary submodules..."
git submodule update --init --recursive
echo ""

echo ""
echo "Creating a symlink to li3 for you..."
chmod +x libraries/lithium/console/li3
ln -s libraries/lithium/console/li3 nzedb
alias nzedb='./nzedb'
echo ""

echo ""
echo "Installation complete."
echo "You now need to configure the http and database servers.
echo ""