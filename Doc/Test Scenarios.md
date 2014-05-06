# Test document

In dit document worden de stappen beschreven waarin de __acceptence criteria__ van de __use cases__ getest worden. Het script dient van boven tot onder doorlopen te worden. Het is niet de bedoeling om steeds één stuk te testen. Het hele testplan moet afgelopen worden zodat zeker is dat de onderdelen onderling werkend blijven.

Het document heeft de volgende structuur.
Elk onderdeel heeft een subtitel welke aangeeft welke use case het dekt.
Daar onder staan de stappen welke doorlopen moeten worden. Deze stappen zijn altijd genummerd. Indien er achter de zin tussen haakjes en onderstreept tekst staat, dat is de betreffende __acceptence criteria__ welke gedekt wordt mocht die stap succesvol zijn afgelegd.
Onder deze stappen is het mogelijk dat er bepaalde eisen staan. Deze eisen moeten zijn voldaan voor de bovenstaande stap. Indien dat niet het geval is dan is er er een gedeelte van een __acceptence criteria__ niet behaald en daarmee dus ook de __acceptence criteria__ niet. Dit betekend dat de __use case__ niet meer correct is geimplementeerd of werkt.

## Voorbereiding

1. Leeg alle tabellen in de database met phpMyAdmin.
2. Breng de database structuur up-to-date door naar http://localhost/console.php te gaan
3. Run het commando `orm:schema-tool:update --force` te runnen.
	- [ ] Er komt geen `[FAIL]` voor in het resultaat.
4. Vul de database met test data door naar http://localhost/testData/create te gaan.
	- [ ] Er staat meerdere keren `<iets> has been added to the database successfully`
	- [ ] Er zijn geen errors
5. Run alle unit tests
	- [ ] Er mogen geen failures optreden!

## Responsiveness testen
#### (20.) As a visitor I want to see the world map so I can easiliy see which places are available for me.

1. Laad de homepage http://localhost _(Visitor must be able to view the world map)_
	- [ ] Er is een map zichtbaar
2. Vergroot en verklein het scherm
    - [ ] Tekst dient kleiner te worden blij kleinere schermen.
    - [ ] Er staan ongeveer tussen de 45 en 75 tekens op één regel
    - [ ] Bij kleine schermen (zoals voor telefoons) komen meerdere kolommen tekst onder elkaar te staan.
3. Test of de kaart werkt _(Visitor must be able to zoom in / out)_
    - [ ] Je kunt zoomen door te scrollen
    - [ ] Je kunt zoomen door met twee vingers een zoom gesture te maken.
    - [ ] Je kan de kaart verslepen met de muis of vinger.
4. De sidebar is te openen en te sluiten
    - [ ] De sidebar moet sluiten door naar links te slepen met de muis of vinger indien deze open is.
    - [ ] De sidebar moet openen door deze naar rechts te slepen met de muis of vinger indien deze gesloten is.
5. Vul de database met test data
6. Controleer of de `institute`'s op de kaart staan.
    - [ ] Kijk of de marker uit de database ook op de kaart komen te staan.
    - [ ] Een `institute` met `type` `education` dient een icoontje van een schoolhoedje te zijn.
    - [ ] Een `institute` met `type` `business` dient een icoontje van een bedrijfsgebouw te zijn.
7. Klik op de marker in ``s-Hertogenbosch`
    - [ ] De sidebar is nu geopend indien deze gesloten was.
8. Klik op de naam `Kees Jansen`  _(Visitor must be able to see all reviews or internships on the map.)_
	- [ ] De tekst van de review is `Good things happend here`
	- [ ] De review heeft 4 van de 5 sterren.


## Login
#### (33.) As a informant I want to login so I can make sure no other people can modify my reviews.
### Correcte inlog:

1.	Laad de homepage http://localhost/account/login/
    - [ ] Er is een inlogscherm zichtbaar
2.	Vul als gebruikersnaam `hbakker` en wachtwoord `password` in
3.	Klik op de knop `login` _(Informant must be able to login)_
	- [ ] Je wordt doorgestuurd naar de homepage
    - [ ] Rechtst bovenin de balk is de voornaam `harry` van de test gebruiker zichtbaar.

### Uitloggen:
1.	Klik rechtsboven op `Log uit`
	- [ ] Je wordt doorgestuurd naar de homepage
        - [ ] Rechtst bovenin de balk staan er weer twee knoppen `Registreren` en `Log in`

### Foutieve inlog:

1.	Laad de homepage http://localhost/account/login/
    - [ ] Er is een inlogscherm zichtbaar
2.	Vul als gebruikersnaam `hbakker` en wachtwoord `ongeldig` in
3.	Klik op de knop `login`
	- [ ] Het login veld wordt geleegd.
	- [ ] Je wordt niet doorgestuurd naar een andere pagina.

### Bruteforce inlog:

1.	Laad de homepage http://localhost/account/login/
    - [ ] Er is een inlogscherm zichtbaar
2.	Vul als gebruikersnaam `hbakker` en wachtwoord `ongeldig` in
3.	Klik op de knop `login`
	- [ ] Het login veld wordt geleegd.
	- [ ] Je wordt niet doorgestuurd naar een andere pagina.
4.	Vul als gebruikersnaam `hbakker` en wachtwoord `ongeldig` in
5.	Klik op de knop `login`
	- [ ] Het login veld wordt geleegd.
	- [ ] Je wordt niet doorgestuurd naar een andere pagina.
6.	Vul als gebruikersnaam `hbakker` en wachtwoord `ongeldig` in
7.	Klik op de knop `login`
	- [ ] Het login veld wordt geleegd.
	- [ ] Je wordt niet doorgestuurd naar een andere pagina.
8.	Vul als gebruikersnaam `hbakker` en wachtwoord `password` in
9.	Klik op de knop `login`
	- [ ] Het login veld wordt geleegd.
	- [ ] Je wordt niet doorgestuurd naar een andere pagina.
	- [ ] Je wordt niet ingelogd aangezien je de aantal pogingen hebt overschreven.
10. Ga naar de homepagine op http://localhost
	- [ ] Rechtst bovenin de balk staat nogsteeds de knop `Log in`

### Inloggen na bruteforce:

1. Leeg de tabel `loginattempt` in phpMyAdmin
2.	Laad de homepage http://localhost/account/login/
    - [ ] Er is een inlogscherm zichtbaar
3.	Vul als gebruikersnaam `hbakker` en wachtwoord `password` in
4.	Klik op de knop `login` _(Informant must be able to login)_
	- [ ] Je wordt doorgestuurd naar de homepage
    - [ ] Rechtst bovenin de balk is de voornaam `harry` van de test gebruiker zichtbaar.

## Register
### Correct Access Code Genereren:
1.	Laad de homepage http://localhost/Management/CreateUser/
    - [ ] Er is een genereer scherm zichtbaar
2.  Vul in beide velden in: `test@toip.nl`
3.  Klik op de knop `Create Access Code`
	- [ ] In het scherm komt een melding met de tekst: `Created access code succesfully`.

### Incorrect Access Code Genereren:
1.	Laad de homepage http://localhost/Management/CreateUser/
    - [ ] Er is een genereer scherm zichtbaar
2.  Vul in het `E-Mail` veld in: `test@toip.nl`
    - Vul in het `Repeat E-Mail` veld in: `test1@toip.nl`
3.  Klik op de knop `Create Access Code`
	- [ ] In het scherm komt een melding met de tekst: `E-Mail fiels do not match.`.
3.  Maak een van de twee velden leeg en klik op de knop `Create Access Code`
	- [ ] In het scherm komt een melding met de tekst: `Not everything is filled in`.

### Incorrect registreren:

1. Laad de homepage http://localhost/account/register/
    - [ ] Er is een registreerscherm zichtbaar
2. Vul de gegevens in volgens bijlage 1.
3. Klik op de knop `Register`
	- [ ] Er komt een error op het scherm dat de gebruikers naam al ingebruik is.

### Correct registreren:

1. Laad de homepage http://localhost/account/register/
    - [ ] Er is een registreerscherm zichtbaar
2. Vul de gegevens in volgens bijlage 2.
2. Zoek in PhpMyAdmin, in de tabel `registrationcode` op welke code bij `test@toip.nl` hoort.
    -   Vul deze code in bij het veld: `Registration Code`
3. Klik op de knop `Register`
	- [ ] Je wordt doorgestuurd naar de homepage
4. Klik op de knop `Log in` rechtsboven in de balk.
    - [ ] Er is een inlogscherm zichtbaar
5.	Vul als gebruikersnaam `patrick` en wachtwoord `iscool` in
6.	Klik op de knop `login` _(Informant must be able to login)_
	- [ ] Je wordt doorgestuurd naar de homepage
    - [ ] Rechtst bovenin de balk is de voornaam `Patrick` van de test gebruiker zichtbaar.

## Contact
#### (19.) As an visitor I want to be able to get in contact with an informant so I can Ask him questions about the place he went.

### Correcte verzenden:

1.	Op de review van `Kees Jansen` van de `Avans Hogeschool` in `s-Hertogenbosch.
2.	Klik naast `Neem contact op met` op `Kees` _(Visitor can view a review and press a contact button)_
	- [ ] Er is een contact formulier zichtbaar
	- [ ] In het veld `Aan` staat `Kees Jansen`
3. Vul je eigen email adres in
4. Typ een onderwerp
5. Typ een bericht
6. Klik op de knop `send` _(Visitor can email the informant)_
	- [ ] In het resultaat staat `Email send`

## Zoeken
#### (34.) As a visitor I want to search so I can get a specific project review.

### Zoeken naar bestaande review:

1. Laad de homepage http://localhost/
    - [ ] Rechts boven is een zoekformulier zichtbaar.
2. Vul het woord `things` _(Visitor must be able to insert a keyword.)_
	- [ ] Er komt een dropdown met gevonden reviews.
3. Klik op een resultaat  _(Results will be shown if found.)_
	- [ ] De sidebar wordt geopend en de betreffende review wordt er in getoont.

### Zoeken naar bestaande locatie:

1. Laad de homepage http://localhost/
    - [ ] Rechts boven is een zoekformulier zichtbaar.
2. Vul het woord `Avans` _(Visitor must be able to insert a keyword.)_
	- [ ] Er komt een dropdown met `Avans Hogeschool` als resultaat.
3. Klik op een resultaat  _(Results will be shown if found.)_
	- [ ] De sidebar wordt geopend en de betreffende locatie wordt getoont.
	- [ ] Het is mogelijk om vanaf hier de reviews van `Avans` de bekijken.


### Zoeken naar niet bestaande review:

1. Laad de homepage http://localhost/
    - [ ] Rechts boven is een zoekformulier zichtbaar.
2. Vul het woord `nope`
	- [ ] Er komt een dropdownp.
	- [ ] In de dropdown staat `No search results found`


## Coördinator:
### Wachtwoord succesvol veranderen:
1.	Laad de homepage http://localhost/Management/ChangePassword
    - [ ] Er is een overzicht zichtbaar om je gegevens aan te passen
2.	Druk op de knop `Change Password`
	* Vul `password` in.
	* Vul `pasword` in.
	* Vul `pasword` in.
	- [ ] U krijgt de tekst `Change password succesfully.` te zien

### Wachtwoord niet succesvol veranderen:
1.	Laad de homepage http://localhost/Management/ChangePassword
    - [ ] Er is een overzicht zichtbaar om je gegevens aan te passen
2.	Druk op de knop `Change Password`
	* Vul 'password' in.
	* Vul `password` in.
	* Vul `password` in.
	* Druk op `save`
    - [ ] U krijgt de tekst `Old password didn't match.` te zien

1.	Laad de homepage http://localhost/Management/ChangePassword
    - [ ] Er is een overzicht zichtbaar om je gegevens aan te passen
2.	Druk op de knop `Change Password`
	* Vul `pasword` in.
	* Vul `passsword` in.
	* Vul `password` in.
	* Druk op `save`
	- [ ] U krijgt de tekst `New passwords didn't match.` te zien
3.	Druk op de knop `Change Password`
	* Vul 'pasword' in.
	* Vul 'pasword' in.
	* Vul 'pasword' in.
	* Druk op  `save`
    - [ ] U krijgt de tekst `New password can't be the same as the old password.` te zien
4.	Verander het wachtwoord terug naar het orgineel door op de knop `Change Password` te drukken.
	* Vul 'pasword' in.
	* Vul 'password' in.
	* Vul 'password' in.
	* Druk op  `save`
    - [ ] U krijgt de tekst `Change password succesfully.` te zien

### Mijn account aanpassen:
1.	Laad de homepage http://localhost/Management/MyAccount
    - [ ] Er is een overzicht zichtbaar om je gegevens aan te passen
2.	Druk op de knop `My Account`
        * Druk op de knop `Save`
    - [ ]  U krijgt de tekst `Successfully saved.` te zien

###Correct een nieuwe Locatie aanmaken:
1.	Laad de pagina: http://localhost/Management/MyLocations/
    - [ ] Er is een overzicht zichtbaar om je gegevens aan te passen
2.    Druk op de knop `Create New Location`
3.    Vul de gegevens in volgens Bijlage 3.
	* Je krijgt een scherm te zien om een nieuwe locatie aan te maken.
	* Druk op de knop `Create Location`
    - [ ] Het scherm verdwijnt en er wordt een nieuwe locatie aangemaakt.

###Incorrect een nieuwe Locatie aanmaken:
1.    Laad de pagina: http://localhost/Management/MyLocations/
    - [ ] Er is een overzicht zichtbaar om je gegevens aan te passen
2.    Druk op de knop `Create New Location`
    * Vul dezelfde gegevens in als uit Bijlage 3. van `Correct een nieuwe Locatie aanmaken`
    * Maak willekeurig een van de zojuist ingevulde, verplichte, velden leeg.
    * Druk op de knop `Create Location`
    - [ ] Bovenaan zou de error `Not everything is filled in` moeten verschijnen.
3.    Vul het zojuist leeg gemaakte veld in met de eerder genoemde waarden.
    * Vul bij het veld `Company's House Number` een letter in I.P.V. een getal.
    * Druk op de knop `Create Location`
    - [ ] Bovenaan zou de error `Streetnumber is not a number` moeten verschijnen.
4.    Maak van het `Company's House Number` veld weer een getal
5.    Probeer van de ingevulde adres gegevens een niet bestaand adres te maken:
	* Vul bij `company city` de waarde: `NietBestaandeStad` in.
	* Vul bij `company street` de waarde: `DummyStraat` in.
	* Vul bij `company house number` de waarde: `666` in.
	* Vul bij `company postal code` de waarde: `5000AA` in.
    * Druk op de knop `Create Location`
    - [ ] Bovenaan zou de error `Could not Geocode. Location was not created.` moeten verschijnen.

###Correct een nieuwe Locatie aanpassen:
1.	Laad de pagina: http://localhost/Management/MyLocations/
    - [ ] Er is een overzicht zichtbaar om je gegevens aan te passen
2.    Druk op de knop potlood icoontje achter de Locatie McDonald's
3.    Volg `Incorrect een nieuwe Locatie aanmaken` vanaf stap 2.
    * Je hoeft niet op de `Create New Location` Knop te drukken
    * De `Create Location` knop bestaat niet, maar heet nu `Update Location`.
    - [ ] Bovenstaand is met succes uitgevoerd.

###Incorrect een nieuwe Locatie aanpassen:
1.	Laad de pagina: http://localhost/Management/MyLocations/
    - [ ] Er is een overzicht zichtbaar om je gegevens aan te passen
2.    Druk op de knop potlood icoontje achter de Locatie McDonald's
3.    Controleer of de gegevens kloppen volgens Bijlage 3.
4.    Vul bij `Company's Name` 'Mc-Donald's' in.
    * Druk op de knop `Update Location`
    - [ ] Het scherm verdwijnt en de locatie word met succes aangepast.

###Incorrect een nieuw Project aanmaken:
1.	Laad de pagina: http://localhost/Management/MyProjects/
    - [ ] Er is een overzicht zichtbaar om je gegevens aan te passen
    * De Pagina laad, en de `Create Project` knop is zichtbaar
2.    Druk op de knop `Create Project`
    * Vul dezelfde gegevens in als bij stap 2 van `Correct een nieuw Project aanmaken`
    * Maak willekeurig een van de zojuist ingevulde, verplichte, velden leeg.
    * Druk op de knop `Create Project`
	- [ ] Je krijgt een scherm te zien om een nieuw project aan te maken.
3.    Vul het zojuist leeg gemaakte veld in met de eerder genoemde waarden.
    * Selecteer bij `start date` als jaar `2013` en als maand `Januari`
    * Druk op de knop `Create Project`
    - [ ] Bovenaan zou de error `Start date cannot be after Stop date` moeten verschijnen.

###Correct een nieuwe Review aanmaken:
1.    Laad de pagina: http://localhost/Management/MyReviews/
    * De Pagina laad, en de `Write review` knop is zichtbaar
2.    Druk op de knop `Write review`
	* Je krijgt een scherm te zien om een nieuwe review aan te maken.
	* Selecteer bij `project` de waarde: 'Avans Hogeschool ('s-Hertogenbosch) - Internship'
	* Selecteer bij `assignment score` de waarde: 'Not Relevant'
	* Selecteer bij `guidance score` de waarde: '2'
	* Selecteer bij `accomodation score` de waarde: '3'
	* Selecteer bij `overall score` de waarde: '3'
	* Vul bij `review` de tekst: 'Dit is een test review.' in.
	* Druk op de knop `Create Review`
	- [ ] Het scherm verdwijnt en er wordt een nieuwe review aangemaakt.

###Incorrect een nieuwe Review aanmaken:
1.    Laad de pagina: http://localhost/Management/MyReviews/
    * De Pagina laad, en de `Write review` knop is zichtbaar
2.    Druk op de knop `Write review`
    * Vul dezelfde gegevens in als bij stap 2 van `Correct een nieuwe Review aanmaken`
    * Maak willekeurig een van de zojuist ingevulde, verplichte, velden leeg.
    * Druk op de knop `Write review``
    - [ ] Bovenaan zou de error `Not everything is filled in` moeten verschijnen.

###Incorrect een User aanpassen:
1.    Laad de pagina: http://localhost/Management/Users/
    * De Pagina laad, en een overzicht van gebruikers is zichtbaar.
2.    Druk op het potloodje achter de gebruiker `Kees Jansen`
    * Maak een willekeurig veld leeg en klik op `Update User`
    - [ ] Bovenaan zou de error `Not everything is filled in` moeten verschijnen.
3.      Vul het veld weer met de orginele waarde.
    * Zet in het veld `Username` de tekst `hbakker`.
    - [ ] Bovenaan zou de error `This username isn't unique` moeten verschijnen.

###Correct een User aanpassen:
1.    Laad de pagina: http://localhost/Management/Users/
    * De Pagina laad, en een overzicht van gebruikers is zichtbaar.
2.    Druk op het potloodje achter de gebruiker `Kees Jansen`
    * Maak van het veld `Firstname` de waarde `Thijs` en klik op `Update User`
    - [ ] Het scherm verdwijnt en de voornaam van de gebruiker Jansen wordt verandert naar Thijs.

###Een Locatie verwijderen:
1.	Laad de pagina: http://localhost/Management/MyLocations/
    - [ ] Er is een overzicht zichtbaar om je gegevens aan te passen
2.    Druk op het 'X' icoontje achter de locatie McDonald's.
	* Je krijgt een scherm te zien met daarin de info over de te verwijderen locatie.
3.    Controlleer dat de getoonde informatie klopt.
	* Druk op de knop `Remove`
	- [ ] Het scherm verdwijnt en de locatie wordt verwijdert.



## Bijlage
### 1. Incorrecte registreren waarden
Veld|Waarde
--------|--------
Username|hbakker
Password|pass
E-mail|jan@example.com
First Name|Harry
Surname|Bakker
City|Arnhem
Zipcode|6000AA
Street|Straatnaam
Streetnumber|12
Addition|[leeg]
Registration Code | [leeg]

### 2. Correcte registreren waarden
Veld|Waarde
--------|--------
Username|patrick
Password|iscool
E-mail|test@toip.nl
First Name|Patrick
Surname|Berenschot
City|Arnhem
Zipcode|6000AA
Street|Straatnaam
Streetnumber|12
Addition|[leeg]

###3. Correcte nieuwe locatie
Veld|Waarde
--------|--------
company name|Avans Hogeschool
company country|Netherlands
company city|'s-Hertogenbosch
company street|Onderwijsboulevard
company house number|215
company postal code|5223DE
company email|contact@toip.nl
company telephone number|0123456

###4. Incorrect adres voor nieuwe locatie
Veld|Waarde
--------|--------
company city|NietBestaandeStad
company street|DummyStraat
company house number|666
company postal code|5000AA
