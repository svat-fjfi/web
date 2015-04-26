SVAT
========

##Instalace

###Zajistit právo PHP zapisovat do adresářů

* application/log
* application/temp
* files

###Konfigurace

* vyplnit v souboru *application/app/config/config.local.neon.template* přístupy k databázi
* přejmenovat jej na *application/app/config/config.local.neon*
* přejmenovat *.htaccess.template* na *.htaccess*

###Instalace závislostí

* Composer: http://getcomposer.org

```sh
composer install
```

###Databáze

* vytvořit MySQL DB s porovnáváním UTF8_CZECH_CI
* importovat strukturu z *application/database/structure.sql*

###Vytvoření uživatelů

```sh
php application/bin/create-user.php <jméno> <heslo>
```