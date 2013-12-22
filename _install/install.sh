#!/bin/bash

echo ""
echo "Welcome to nZEDb Bootstrap!"
echo "----------------------------------"
echo ""
echo "Starting the installation process..."
echo ""

//exec git clone git://github.com/nZEDb/nZEDb.git
exec git clone git@77.99.35.102:li3_nzedb.git
clear;

cd nZEDb

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
ln -s libraries/lithium/console/li3 li3
alias li3='./li3'
echo ""

echo ""
echo "Installation complete."
echo "You now need to configure the http and database servers.
echo ""