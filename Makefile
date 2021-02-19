.DEFAULT_GOAL := help
.PHONY: help clear
.PHONY: create_db migrate model mysql
.PHONY: debug-bar delete-ui ide-helper passport
.PHONY: phpunit_feature phpunit_unit
.PHONY: start watch

#export USER_ID=$(shell id -u)
#export GROUP_ID=$(shell id -g)
#
include .env

help:									## Show this help.
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":|##"}; {printf "\033[32m%-30s\033[0m %s\n", $$2, $$4}' | sed -e 's/\[32m##/[33m/' | sort

clear:									## Clear route, config and cache
	php artisan route:clear && \
	php artisan view:clear && \
	php artisan config:cache && \
	php artisan config:cache --env=testing && \
	php artisan cache:clear && \
	php artisan config:clear

create_db:								## Create DB (locally).
	mysql -uroot -p -e "CREATE DATABASE IF NOT EXISTS ${DB_DATABASE} CHARACTER SET utf8 COLLATE utf8_general_ci"

import_db:
	mysql -u root -p info_clubstravel_ee_backend < ~/Downloads/cTravel/info_clubstravel_ee_backend_2020-10-13_13-17-16.sql

debug-bar:								## Set Debug bar for dev env
	composer require barryvdh/laravel-debugbar --dev

ide-helper:								## Set PHPStorm IDE Healper and add some file to .gitignore
	composer require --dev barryvdh/laravel-ide-helper && \
	php artisan clear-compiled && \
	php artisan ide-helper:generate	&& \
	php artisan ide-helper:meta && \
	echo ".idea" >> .gitignore && \
	echo ".phpstorm.meta.php" >> .gitignore && \
	echo "_ide_helper.php" >> .gitignore
#	add to composer.json:
#	"scripts":{
#        "post-update-cmd": [
#            "Illuminate\\Foundation\\ComposerScripts::postUpdate",
#            "@php artisan ide-helper:generate",
#            "@php artisan ide-helper:meta"
#        ]
#    },
#
#	add a composer script to regenerate all of Laravel's IDE helper files
#	https://twitter.com/AlexVanderbist/status/1289131868860944385/photo/1
#	add to composer.json:
#	"scripts":{
#        "ide-helper": [
#            "@php artisan ide-helper:eloquent",
#            "@php artisan ide-helper:generate",
#            "@php artisan ide-helper:meta",
#            "@php artisan ide-helper:models --nowrite"
#        ]
#    },
#
#	then in terminal:
#	composer run ide-helper

# make git m="your message"
git:									## Git add, commit and push all in one command
	git add .
	git commit -m "$m"
	#git push
	git status
    #git push -u origin master

migrate:								## Run migration
	php artisan migrate

migrate-refresh:						## Run migration refresh (truncate all data in DB)
	php artisan migrate:refresh --seed

# -m, --migration   Create a new migration file for the model
# -c, --controller  Create a new controller for the model
# -r, --resource    Indicates if the generated controller should be a resource controller
# -f, --factory     Create a new factory for the model
# -a, --all         Generate a migration, factory, and resource controller for the model
# example: make model name=Post   make model name=Article flags=mc
model:									## Create Model with different mode
	php artisan make:model $(name) -$(flags) --api

seeder:									## Create seeder
	php artisan make:seeder $(name)

seeder-only-one:
	php artisan db:seed --class=UsersWithRolesAndBUSeeder

start:									## Start App
	php artisan serve --port=8001

tinker: 								## Start Tinker
	php artisan tinker
# factory(App\User::class)->create(['name'=>'Eugene Yavgel','email'=>'eugene.yavgel@gmail.com','password'=>bcrypt('password')]);
