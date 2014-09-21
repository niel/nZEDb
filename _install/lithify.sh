#!/bin/bash

set -e

clear;

echo ""
echo "Welcome to nZEDb's Bootstrap!"
echo "---------------------------"
echo ""
echo "Starting the installation process..."

GIT_PHP="Git.php"
LI3_DOCS="li3_docs"
LI3_FLASH="li3_flash_message"
LI3_MAILER="li3_mailer"
LI3_QUALITY="li3_quality"
LIBS="libraries"
LITHIUM="lithium"
NZEDB="nZEDb"

newgrp www-data

if [ ! -e ${LIBS} ] || [ ! -d ${LIBS} ]
then
	mkdir ${LIBS}
fi

cd ${LIBS}

# TODO make script take a master/dev (defaulting to master) parameter and do this automatically.
# If you are developing the code, uncomment the following to have the documentation
# and quality plugins installed. The application will detect and enable them automatically.
#
#if [ ! -e ${LI3_DOCS} ] || [ ! -d ${LI3_DOCS} ]
#then
#	echo ""
#	git clone git@github.com:UnionOfRAD/li3_docs.git
#fi
#
#if [ ! -e ${LI3_QUALITY} ] || [ ! -d ${LI3_QUALITY} ]
#then
#	echo ""
#	git clone git@github.com:UnionOfRAD/li3_quality.git
#fi

if [ ! -e ${LI3_FLASH} ] || [ ! -d ${LI3_FLASH} ]
then
	echo ""
	git clone git@github.com:michaelhue/li3_flash_message.git
fi

if [ ! -e ${LI3_MAILER} ] || [ ! -d ${LI3_MAILER} ]
then
	echo ""
	git clone git@github.com:eLod/li3_mailer.git
fi

if [ ! -e ${LITHIUM} ] || [ ! -d ${LITHIUM} ]
then
	echo ""
	git clone git@github.com:UnionOfRAD/lithium.git
fi

if [ ! -e ${GIT_PHP} ] || [ ! -d ${GIT_PHP} ]
then
	echo ""
	git clone git@github.com:kbjr/Git.php.git
fi

# End of libraries

cd ../

if [ ! -e ${NZEDB} ] || [ ! -d ${NZEDB} ]
then
	echo ""
	git clone git@github.com:nZEDb/nZEDb.git
	#git clone git://github.com/niel/nZEDb.git
fi

cd ${NZEDB}


echo ""
echo "Setting application directory permissions..."
chmod +x ./
chmod -R 775 resources
chmod 775 ./libs/smarty/templates_c
chmod 775 ./www

if [ ! -e 'zed' ] && [ ! -d 'zed' ]
then
	echo ""
	echo "Creating a symlink to li3 for you..."
	chmod +x ../libraries/lithium/console/li3
	ln -s ../libraries/lithium/console/li3 zed
	alias zed='./zed'
fi

echo ""
echo "Installation complete."
echo ""
echo "You now need to configure the http and database servers."
echo "For Debian based servers, point your http server at:"
echo "  /var/www/${NZEDB}/app/webroot, for li3 served pages or"
echo "  /var/www/${NZEDB}/www, for smarty served pages."
echo "Then open the site in your browser."
echo ""
echo "You should see either a list of problems to fix, or a"
echo "summary of your site's environment."
echo ""
