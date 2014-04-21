#Installatie handleiding
Er zijn twee installatie handeleidingen.
De eerste is voor een basis of demo installatie. De tweede is een development installatie met automatische deployment.


###Basis eisen:
 * Webserver met o.a.:
  * Php 5.4
  * Apache 2
  * Mysql 5
 * Basis kennis voor het hosten van websites.
 * Basis kennis Php.

###Deployment eisen:
 * Root rechten op de server
 * Phpunit
 * Beheer rechten van DNS-records.
 * Kennis van Debian gebaseerde systemen.
 * Kennis van Apache2 en werken met virtual hosts.
 * Basis kennis van SSH
 * Toegang tot de Github Deployment Hooks.


##Basis of Demo installatie:
###Uploaden
1. Upload de volgende mappen naar de webfolder op de server:
 * Classes
 * Doctrine
 * css
 * images
 * js
2. Upload de volgende bestanden naar de webfolder:
 * .htaccess
 * Bootstrap.php
 * index.php
 * console.php

###Database
3. Open het bestand `Classes/PROJ/Helper/DoctrineHelper.php`
4. Pas de database gegevens aan zoals in onderstaand voorbeeld:

```php
		$connectionOptions = array(
            'dbname' => 'DATABASE_NAAM',
            'user' => 'DATABASE_GEBRUIKER',
            'password' => 'DATABASE_WACHTWOORD',
            'host' => 'localhost',
            'driver' => 'pdo_mysql'
        );
```
5. Ga naar `/console.php` op de webserver. Bijvoorbeeld `http://example.com/console.php`.
6. Run het volgende commando `orm:schema-tool:update --force`. Dit creeert de database tabellen.

###Demo data

5. Ga naar `/testData` op de website. Bijvoorbeeld `http://example.com/testData`
6. Zodra deze pagina klaar is met laden dan is de demo data aangemaakt in de database.
7. De website is nu klaar voor gebruik.


##Development installatie:
1. Zet alleen de inhoud van de deployment directory op de server. En behoud hiermee de mappenstructuur.
3. Voeg de WWW-Data toe aan de SUDO'ers zodat dit commando's zonder wachtwoord uitgevoerd kunnen worden. Dit doe je door het volgende commando uit te voeren: `www-data ALL = NOPASSWD:/usr/bin/git`
4. Activeer de sites door het volgende commando uit te voeren: 
 * `a2ensite stable`
 * `a2ensite dev`
 * `a2ensite api`
5. Maak DNS records aan voor de ServerName uit de Virtual Hosts. Je kan er ook voor kiezen om de Virtual Host aan te passen.
6. Maak SSH communicatie werkend voor de `www-data` gebruiker zodat deze met github kan praten.
7. Set op github een post receive hook in voor pushes naar de API virtual hosts. Bijvoorbeeld (http://api.toip.nl).
8. Bezoek de virtual host en wacht totdat deze klaar is en je de volgende message krijgt : Pulling repository
9. Volg de database instructies van de Basis Installatie hierboven.
10. Er zijn nu drie websites werkend. De API endpoint waarmee Github communiseerd zodra er een nieuwe push wordt gedaan.
Een stable host waarmee de laatste versie van de branch `master` zichtbaar is.
Een development host waarmee de laatste versie van de branch `dev` zichtbaar is.
