#!/bin/bash

set -e

echo ""
echo "Welcome to nZEDb Bootstrap!"
echo "---------------------------"
echo ""
echo "Starting the installation process..."
echo ""


BASE="li3_nzedb"
LIBS="libraries"


//exec git clone git://github.com/nZEDb/nZEDb.git
exec git clone git@77.99.35.102:li3_nzedb.git
clear;


if [ ! -e ${LIBS} ] || [ ! -d ${LIBS} ]
then
	mkdir ${LIBS}
fi

cd ${LIBS}

git clone git@github.com:UnionOfRAD/li3_docs.git
git clone git@github.com:michaelhue/li3_flash_message.git
git clone git@github.com:eLod/li3_mailer.git
git clone git@github.com:UnionOfRAD/li3_quality.git
git clone git@github.com:UnionOfRAD/lithium.git
git clone git@github.com:nZEDb/nZEDb.git


cd ../${BASE}


echo ""
echo "Setting application directory permissions..."
chmod -R 777 resources
echo ""

echo ""
echo "Creating a symlink to li3 for you..."
chmod +x ../libraries/lithium/console/li3
ln -s ../libraries/lithium/console/li3 nzedb
alias nzedb='./nzedb'
echo ""

echo ""
echo "Installation complete."
echo "You now need to configure the http and database servers."
echo "For Debian based servers, point your http server at:"
echo "  /var/www/${BASE}/webroot"
echo "or wherever you cloned, then open the site in your browser."
echo "You should see either a list of problems to fix, or a"
echo "summary of your site's environment."
echo ""