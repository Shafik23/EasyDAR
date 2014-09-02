#!/bin/bash
#
# "Deploys" this current EasyDAR application to a pre-existing "phpdesktop" installation. This is done
# by providing the entire "www/" dir, along with the settings.json file.
#
# Note: phpdesktop is standalone php-app environment. For more information, see here: https://code.google.com/p/phpdesktop/


if [[ $1 == "" ]]
then 
   echo "Usage: $0 <destination phpdesktop root-folder>"
fi


