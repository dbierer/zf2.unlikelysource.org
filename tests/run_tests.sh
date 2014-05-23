#!/bin/bash

# store current dir
cd ..
BASEDIR=$PWD

# check to see if module name given on command line
if [ $# -eq 0 ] 
then 
    # no command line argument given
    echo 
    echo Usage: run_tests.sh [MODULE_NAME] or [all]
    echo 
    echo "all" = all tests are run
    echo MODULE_NAME runs only 1 test on that module
    echo 
else
    if [ "$1" = "all" ]
    then
		# test all modules
		for MODULE in Application Cache CheckOrder Forum PhpUnit QandA ServiceManagerDemo SimpleAuth TimeLog ViewTest Zf2f
		do
		  cd $BASEDIR/module/$MODULE/tests
		  php $BASEDIR/tests/phpunit.phar -c phpunit.xml
		done
	else
	    # test only 1 module
	    cd $BASEDIR/module/$1/tests
	    php $BASEDIR/tests/phpunit.phar -c phpunit.xml
	fi
fi
