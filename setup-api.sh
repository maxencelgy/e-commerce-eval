#!/bin/bash
echo create api with symfony
echo -p "enter a project name :" 
read  name
symfony new $name
cd $name
composer require jms/serializer-bundle
composer require friendsofsymfony/rest-bundle
composer require symfony/maker-bundle
composer require symfony/orm-pack:^2.1