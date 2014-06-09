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
4. Vul de database met test data door naar http://localhost/testData te gaan.
    - [ ] Er staat meerdere keren `<iets> with the following data has been succesfully added to the database:`
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
    - [ ] Bij kleine schermen (zoals voor telefoons) komen meerdere rijen tekst onder elkaar te staan.
3. Test of de kaart werkt _(Visitor must be able to zoom in / out)_
    - [ ] Je kunt zoomen door te scrollen
    - [ ] Je kunt zoomen door met twee vingers een zoom gesture te maken.
    - [ ] Je kan de kaart verslepen met de muis of vinger.
4. De sidebar is te openen en te sluiten
    - [ ] De sidebar moet sluiten door naar links te slepen met de muis of vinger indien deze open is.
    - [ ] De sidebar moet openen door deze naar rechts te slepen met de muis of vinger indien deze gesloten is.
5. Controleer of de `institute`'s op de kaart staan.
    - [ ] Er zijn markers te zien op de kaart waarvan de locatie uit de database gehaald zijn, mits deze geaccepteerd zijn door de coördinator.
    - [ ] Een `institute` met `type` `education` dient een icoontje van een schoolhoedje te zijn.
    - [ ] Een `institute` met `type` `business` dient een icoontje van een bedrijfsgebouw te zijn.
6. Klik op de marker in `'s-Hertogenbosch`
    - [ ] De sidebar is nu geopend indien deze gesloten was.
    - [ ] Er is minimaal één review op deze locatie te zien die geaccepteerd is door de coördinator.
7. Klik op de naam `Kees Jansen`  _(Visitor must be able to see all reviews or internships on the map.)_
    - [ ] De tekst van de review is `Many fun activities to do here!`
    - [ ] De review heeft voor `opdrachten` 5 van de 5 sterren.
    - [ ] De review heeft voor `hulp bieden` 4 van de 5 sterren.
    - [ ] De review heeft voor `vestiging` 3 van de 5 sterren.


## Login
#### (33.) As a informant I want to login so I can make sure no other people can modify my reviews.
### Correcte inlog:

1.  Laad de homepage http://localhost/account/login/
    - [ ] Er is een inlogscherm zichtbaar
2.  Vul als gebruikersnaam `hbakker` en wachtwoord `password` in
3.  Klik op de knop `login` _(Informant must be able to login)_
    - [ ] Je wordt doorgestuurd naar de homepage
    - [ ] Rechtst bovenin de balk is de tekst `Welcome Harry` zichtbaar.

### Uitloggen:
1.  Klik rechtsboven op `Log uit`
    - [ ] Je wordt doorgestuurd naar de homepage
    - [ ] Rechtst bovenin de balk staan er weer twee knoppen `Registreren` en `Log in`

### Foutieve inlog:

1.  Laad de homepage http://localhost/account/login/
    - [ ] Er is een inlogscherm zichtbaar
2.  Vul als gebruikersnaam `hbakker` en wachtwoord `ongeldig` in
3.  Klik op de knop `login`
    - [ ] Het login veld wordt geleegd.
    - [ ] Je wordt niet doorgestuurd naar een andere pagina.

### Bruteforce inlog:

1.  Laad de homepage http://localhost/account/login/
    - [ ] Er is een inlogscherm zichtbaar
2.  Vul als gebruikersnaam `hbakker` en wachtwoord `ongeldig` in
3.  Klik op de knop `login`
    - [ ] Het login veld wordt geleegd.
    - [ ] Je wordt niet doorgestuurd naar een andere pagina.
4.  Vul als gebruikersnaam `hbakker` en wachtwoord `ongeldig` in
5.  Klik op de knop `login`
    - [ ] Het login veld wordt geleegd.
    - [ ] Je wordt niet doorgestuurd naar een andere pagina.
6.  Vul als gebruikersnaam `hbakker` en wachtwoord `ongeldig` in
7.  Klik op de knop `login`
    - [ ] Het login veld wordt geleegd.
    - [ ] Je wordt niet doorgestuurd naar een andere pagina.
8.  Vul als gebruikersnaam `hbakker` en wachtwoord `password` in
9.  Klik op de knop `login`
    - [ ] Het login veld wordt geleegd.
    - [ ] Je wordt niet doorgestuurd naar een andere pagina.
    - [ ] Je wordt niet ingelogd aangezien je de aantal pogingen hebt overschreven.
10. Ga naar de homepagine op http://localhost
    - [ ] Rechtst bovenin de balk staat nogsteeds de knop `Log in`

### Inloggen na bruteforce:

1. Leeg de tabel `loginattempt` in phpMyAdmin
2.  Laad de homepage http://localhost/account/login/
    - [ ] Er is een inlogscherm zichtbaar
3.  Vul als gebruikersnaam `hbakker` en wachtwoord `password` in
4.  Klik op de knop `login` _(Informant must be able to login)_
    - [ ] Je wordt doorgestuurd naar de homepage
    - [ ] Rechtst bovenin de balk is de tekst `Welcome Harry` zichtbaar.

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
3. Klik op de knop `Register`
    - [ ] Je wordt doorgestuurd naar de homepage
4. Klik op de knop `Log in` rechtsboven in de balk.
    - [ ] Er is een inlogscherm zichtbaar
5.  Vul als gebruikersnaam `patrick` en wachtwoord `iscool` in
6.  Klik op de knop `login` _(Informant must be able to login)_
    - [ ] Je wordt doorgestuurd naar de homepage
    - [ ] Rechtst bovenin de balk is de tekst `Welcome Patrick` zichtbaar.

## Contact
#### (19.) As an visitor I want to be able to get in contact with an informant so I can Ask him questions about the place he went.

### Correcte verzenden:

1.  Op de review van `Kees Jansen` van de `Avans Hogeschool` in 's-Hertogenbosch.
2.  Klik naast `Neem contact op met` op `Kees` _(Visitor can view a review and press a contact button)_
    - [ ] Er is een contact formulier zichtbaar
    - [ ] In het veld `Aan` staat `Kees Jansen`
3. Vul je eigen email adres in
4. Typ een onderwerp
5. Typ een bericht
6. Klik op de knop `send` _(Visitor can email the informant)_
    - [ ] In het resultaat staat `Your message was sent successfully.`

## Zoeken
#### (34.) As a visitor I want to search so I can get a specific project review.

### Zoeken naar bestaande review:

1. Laad de homepage http://localhost/
    - [ ] Rechts boven is een zoekformulier zichtbaar.
2. Vul het woord `fun` _(Visitor must be able to insert a keyword.)_
    - [ ] Er komt een dropdown met gevonden reviews.
3. Klik op een resultaat  _(Results will be shown if found.)_
    - [ ] De sidebar wordt geopend en de betreffende review wordt er in getoont.

### Zoeken naar bestaande locatie:

1. Laad de homepage http://localhost/
    - [ ] Rechts boven is een zoekformulier zichtbaar.
2. Vul het woord `Avans` _(Visitor must be able to insert a keyword.)_
    - [ ] Er komt een dropdown met `Avans Hogeschool` als resultaat(kunnen meer resultaten uitkomen).
3. Klik op een resultaat  _(Results will be shown if found.)_
    - [ ] De sidebar wordt geopend en de betreffende locatie/review wordt getoont.
    - [ ] Het is mogelijk om vanaf hier de reviews van `Avans` de bekijken.

### Zoeken naar niet bestaand item:

1. Laad de homepage http://localhost/
    - [ ] Rechts boven is een zoekformulier zichtbaar.
2. Vul het woord `nope` in
    - [ ] Er komt een dropdown.
    - [ ] In de dropdown staat `No search results found`

### Zoeken naar bestaande `geapprovede` review:

1. Laad de homepage http://localhost/
    - [ ] Rechts boven is een zoekformulier zichtbaar.
2. Vul het woord `job` in
    - [ ] Er komt een dropdown.
    - [ ] In de dropdown staat `No search results found`

### Zoeken naar bestaande `geapprovede` locatie:

1. Laad de homepage http://localhost/
    - [ ] Rechts boven is een zoekformulier zichtbaar.
2. Vul het woord `McDonalds` in
    - [ ] Er komt een dropdown.
    - [ ] In de dropdown staat `No search results found`

## Coördinator:
### Wachtwoord succesvol veranderen:
1.  Laad de homepage http://localhost/Management/ChangePassword
    - [ ] Er is een overzicht zichtbaar om je wachtwoord aan te passen
2.  Druk op de knop `Change Password`
    * Vul `password` in het 'Old Password' veld in.
    * Vul `notsosecret` in het 'New Password' veld in.
    * Vul `notsosecret` in het 'Repeat New Password' veld in.
    - [ ] U krijgt de tekst `Change password succesfully.` te zien

### Wachtwoord niet succesvol veranderen:
1.  Laad de homepage http://localhost/Management/ChangePassword
    - [ ] Er is een overzicht zichtbaar om je wachtwoord aan te passen
2.  Druk op de knop `Change Password`
    * Vul `notoldpassword` in het 'Old Password' veld in.
    * Vul `notsosecret` in het 'New Password' veld in.
    * Vul `notsosecret` in het 'Repeat New Password' veld in.
    * Druk op `save`
    - [ ] U krijgt de tekst `Old password didn't match.` te zien

1.  Laad de homepage http://localhost/Management/ChangePassword
    - [ ] Er is een overzicht zichtbaar om je wachtwoord aan te passen
2.  Druk op de knop `Change Password`
    * Vul `notsosecret` in het 'Old Password' veld in.
    * Vul `password` in het 'New Password' veld in.
    * Vul `pasword` in het 'Repeat New Password' veld in.
    * Druk op `save`
    - [ ] U krijgt de tekst `New passwords didn't match.` te zien
3.  Druk op de knop `Change Password`
    * Vul `notsosecret` in het 'Old Password' veld in.
    * Vul `notsosecret` in het 'New Password' veld in.
    * Vul `notsosecret` in het 'Repeat New Password' veld in.
    * Druk op  `save`
    - [ ] U krijgt de tekst `New password can't be the same as the old password.` te zien
4.  Verander het wachtwoord terug naar het orgineel door op de knop `Change Password` te drukken.
    * Vul `notsosecret` in het 'Old Password' veld in.
    * Vul `password` in het 'New Password' veld in.
    * Vul `password` in het 'Repeat New Password' veld in.
    * Druk op  `save`
    - [ ] U krijgt de tekst `Change password succesfully.` te zien

### Mijn account aanpassen:
1.  Laad de homepage http://localhost/Management/MyAccount
    - [ ] Er is een overzicht zichtbaar om je gegevens aan te passen
2.  Druk op de knop `My Account`
    * Druk op de knop `Save`
    - [ ]  U krijgt de tekst `Successfully saved.` te zien

###Correct een nieuwe Locatie aanmaken:
1.  Laad de pagina: http://localhost/Management/MyLocations/
    - [ ] Er is een overzicht zichtbaar om je locaties aan te passen
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

###Correct een Locatie aanpassen:
1.  Laad de pagina: http://localhost/Management/MyLocations/
    - [ ] Er is een overzicht zichtbaar om je locaties aan te passen
2.    Druk op de knop potlood icoontje achter de Locatie McDonald's
3.    Controleer of de gegevens kloppen volgens Bijlage 3.
4.    Vul bij `Company's Name` 'Mc-Donald's' in.
    * Druk op de knop `Update Location`
    - [ ] Het scherm verdwijnt en de locatie word met succes aangepast.

###Incorrect een Locatie aanpassen:
1.  Laad de pagina: http://localhost/Management/MyLocations/
    - [ ] Er is een overzicht zichtbaar om je locaties aan te passen
2.    Druk op de knop potlood icoontje achter de Locatie McDonald's
3.    Volg `Incorrect een nieuwe Locatie aanmaken` vanaf stap 2.
    * Je hoeft niet op de `Create New Location` Knop te drukken
    * De `Create Location` knop bestaat niet, maar heet nu `Update Location`.
    - [ ] Bovenstaand is met succes uitgevoerd.

###Correct een nieuw Project aanmaken:
1.  Laad de pagina: http://localhost/Management/MyProjects/
    - [ ] Er is een overzicht zichtbaar om je projecten aan te passen
    * De Pagina laad, en de `Create Project` knop is zichtbaar
2.    Druk op de knop `Create Project`
    * Je krijgt een scherm te zien om een nieuw project aan te maken.
3.    Vul de gegevens in volgens Bijlage 5.
    * Druk op de knop `Create Project`
    - [ ] Het scherm verdwijnt en er wordt een nieuwe locatie aangemaakt.

###Incorrect een nieuw Project aanmaken:
1.  Laad de pagina: http://localhost/Management/MyProjects/
    - [ ] Er is een overzicht zichtbaar om je projecten aan te passen
    * De Pagina laad, en de `Create Project` knop is zichtbaar
2.    Druk op de knop `Create Project`
    * Vul de gegevens in volgens Bijlage 5.
    * Maak willekeurig een van de zojuist ingevulde, verplichte, velden leeg.
    * Druk op de knop `Create Project`
    - [ ] Bovenaan zou de error `Not everything is filled in` moeten verschijnen.
3.    Vul het zojuist leeg gemaakte veld in met de eerder genoemde waarden.
    * Selecteer bij `start date` als jaar `2013` en als maand `Januari`
    * Druk op de knop `Create Project`
    - [ ] Bovenaan zou de error `Start date cannot be after Stop date` moeten verschijnen.

###Correct een Project aanpassen:
1.  Laad de pagina: http://localhost/Management/MyProjects/
    - [ ] Er is een overzicht zichtbaar om je gegevens aan te passen
2.    Druk op de knop potlood icoontje achter de Minor bij Avans Hogeschool
3.    Controleer of de gegevens kloppen volgens Bijlage 5.
4.    Selecteer bij `type` de waarde 'Internship'.
    * Druk op de knop `Update Location`
    - [ ] Het scherm verdwijnt en de locatie word met succes aangepast.

###Incorrect een Project aanpassen:
1.  Laad de pagina: http://localhost/Management/MyProjects/
    - [ ] Er is een overzicht zichtbaar om je gegevens aan te passen
2.    Druk op de knop potlood icoontje achter de Minor bij Avans Hogeschool
3.    Volg `Incorrect een nieuwe Project aanmaken` vanaf stap 2.
    * Je hoeft niet op de `Create Project` Knop te drukken
    * De `Create Project` knop bestaat niet, maar heet nu `Update Project`.
    - [ ] Bovenstaand is met succes uitgevoerd.

###Correct een nieuwe Review aanmaken:
1.    Laad de pagina: http://localhost/Management/MyReviews/
    * De Pagina laad, en de `Write review` knop is zichtbaar
2.    Druk op de knop `Write review`
    * Je krijgt een scherm te zien om een nieuwe review aan te maken.
    * Gebruik de gegevens uit bijlage 6 om de review in te vullen.
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

###Correct een Review aanpassen:
1.  Laad de pagina: http://localhost/Management/MyReviews/
    - [ ] Er is een overzicht zichtbaar om je gegevens aan te passen
2.    Druk op de knop potlood icoontje achter de Review van de `Avans Hogeschool`
3.    Controleer of de gegevens kloppen volgens Bijlage 5.
4.    Selecteer bij `Overall Score` de waarde '5'.
    * Druk op de knop `Update Location`
    - [ ] Het scherm verdwijnt en de review word met succes aangepast.

###Incorrect een Review aanpassen:
1.  Laad de pagina: http://localhost/Management/MyReviews/
    - [ ] Er is een overzicht zichtbaar om je gegevens aan te passen
2.    Druk op de knop potlood icoontje achter de Review van de `Avans Hogeschool`
3.    Volg `Incorrect een nieuwe Review aanmaken` vanaf stap 2.
    * Je hoeft niet op de `Write Review` Knop te drukken
    * De `Create Review` knop bestaat niet, maar heet nu `Update Review`.
    - [ ] Bovenstaand is met succes uitgevoerd.

###Een Project verwijderen:
1.  Laad de pagina: http://localhost/Management/MyProjects/
    - [ ] Er is een overzicht zichtbaar om je gegevens aan te passen
2.    Druk op het 'X' icoontje achter het project van McDonald's.
    * Je krijgt een scherm te zien met daarin de info over het te verwijderen project.
3.    Controlleer dat de getoonde informatie klopt.
    * Druk op de knop `Remove`
    - [ ] Het scherm verdwijnt en het project wordt verwijdert.

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
1.  Laad de pagina: http://localhost/Management/MyLocations/
    - [ ] Er is een overzicht zichtbaar om je gegevens aan te passen
2.    Druk op het 'X' icoontje achter de locatie McDonald's.
    * Je krijgt een scherm te zien met daarin de info over de te verwijderen locatie.
3.    Controlleer dat de getoonde informatie klopt.
    * Druk op de knop `Remove`
    - [ ] Het scherm verdwijnt en de locatie wordt verwijdert.

###Locaties mass-updaten door Coordinator
1.  Laad de pagina: http://localhost/Management/Locations
    - [ ] Er is een overzicht zichtbaar om je gegevens aan te passen
2.  Selecteer alle locaties door de bovenste Checkbox aan te vinken.
    - Kies uit de dropdown box `Set to Approved` onder `status`
    - [ ] Er komt een popup die meld hoeveel entry's je gaat updaten.
3.  Klik op `Confirm`.
    - [ ] Het scherm verdwijnt, en de Entry's hebben nu de status `Approved`

###Locaties mass-removen door Coordinator
1.  Laad de pagina: http://localhost/Management/Locations
    - [ ] Er is een overzicht zichtbaar om je gegevens aan te passen
2.  Selecteer alle locaties door de bovenste Checkbox aan te vinken.
    - Kies uit de dropdown box `Remove` onder `other`
    - [ ] Er komt een popup die meld hoeveel entry's je gaat verwijderen.
3.  Klik op `Confirm`.
    - [ ] Het scherm verdwijnt, en de Entry's zijn verwijdert.
4.  Draai het testdata script: http://localhost/testdata/

###Reviews mass-updaten door Coordinator
1.  Laad de pagina: http://localhost/Management/Reviews
    - [ ] Er is een overzicht zichtbaar om je gegevens aan te passen
2.  Selecteer alle reviews door de bovenste Checkbox aan te vinken.
    - Kies uit de dropdown box `Set to Approved` onder `status`
    - [ ] Er komt een popup die meld hoeveel entry's je gaat updaten.
3.  Klik op `Confirm`.
    - [ ] Het scherm verdwijnt, en de Entry's hebben nu de status `Approved`
	
###Reviews mass-removen door Coordinator
1.  Laad de pagina: http://localhost/Management/Reviews
    - [ ] Er is een overzicht zichtbaar om je gegevens aan te passen
2.  Selecteer alle reviews door de bovenste Checkbox aan te vinken.
    - Kies uit de dropdown box `Remove` onder `other`
    - [ ] Er komt een popup die meld hoeveel entry's je gaat verwijderen.
3.  Klik op `Confirm`.
    - [ ] Het scherm verdwijnt, en de Entry's zijn verwijdert.
4.  Draai het testdata script: http://localhost/testdata/

###Projects mass-updaten door Coordinator
1.  Laad de pagina: http://localhost/Management/Projects
    - [ ] Er is een overzicht zichtbaar om je gegevens aan te passen
2.  Selecteer alle projects door de bovenste Checkbox aan te vinken.
    - Kies uit de dropdown box `Set to Approved` onder `status`
    - [ ] Er komt een popup die meld hoeveel entry's je gaat updaten.
3.  Klik op `Confirm`.
    - [ ] Het scherm verdwijnt, en de Entry's hebben nu de status `Approved`

###Projects mass-removen door Coordinator
1.  Laad de pagina: http://localhost/Management/Projects
    - [ ] Er is een overzicht zichtbaar om je gegevens aan te passen
2.  Selecteer alle projects door de bovenste Checkbox aan te vinken.
    - Kies uit de dropdown box `Remove` onder `other`
    - [ ] Er komt een popup die meld hoeveel entry's je gaat verwijderen.
3.  Klik op `Confirm`.
    - [ ] Het scherm verdwijnt, en de Entry's zijn verwijdert.
4.  Draai het testdata script: http://localhost/testdata/

###Een Review verwijderen:
1.  Laad de pagina: http://localhost/Management/MyReviews/
    - [ ] Er is een overzicht zichtbaar om je gegevens aan te passen
2.    Druk op het 'X' icoontje achter de review van de McDonald's.
    - [ ] Je krijgt een scherm te zien met daarin de info over de te verwijderen review.
3.    Controlleer dat de getoonde informatie klopt.
    * Druk op de knop `Remove`
    - [ ] Het scherm verdwijnt en de locatie wordt verwijdert.

##Filteren op locatie type:
1.      Laad de homepage http://localhost/
    - [ ] De kaart is zichtbaar met in de menubalk de filter "Location Type:".
2.      Selecteer in de filter optie om alleen de "education" te laten zien.
    - [ ] Alle markers met een icoontje van een business verdwijnen, mits deze geaccepteerd zijn door de coördinator.
3.      Select in de filter optie om alleen de "business" te laten zien.
    - [ ] De markers met een icoontje van een education verdwijnen, mits deze geaccepteerd zijn door de coördinator.
    - [ ] De markers met een icoontje van een business verschijnen, mits deze geaccepteerd zijn door de coördinator.

##Reseten van filters:
1.      Laad de homepage http://localhost/
    - [ ] De kaart is zichtbaar met in de menubalk de button "Reset".
2.      Selecteer in de filter optie om alleen de "education" te laten zien.
    - [ ] Alle markers met een icoontje van een business verdwijnen, mits deze geaccepteerd zijn door de coördinator.
3.      Druk op de "Reset" knop in de menubalk.
    - [ ] Alle markers verschijnen, mits deze geaccepteerd zijn door de coördinator.
    - [ ] Alle filter opties worden leeggemaakt.

##Filteren op land:
1.      Laad de homepage http://localhost/
    - [ ] De kaart is zichtbaar met in de menubalk de filter "Country:".
2.      Selecteer in de filter optie om alleen de "Netherlands" te laten zien.
    - [ ] Alle markers buiten nederland verdwijnen, mits deze geaccepteerd waren door de coördinator.
3.      Select in de filter optie om alleen de "" (leeg) te laten zien.
    - [ ] Alle markers verschijnen, mits deze geaccepteerd waren door de coördinator.

##Filteren op project type:
1.      Laad de homepage http://localhost/
    - [ ] De kaart is zichtbaar met in de menubalk de filter "Project type:".
2.      Selecteer in de filter optie om alleen de "Minor" te laten zien.
    - [ ] Alle markers die geen minor hebben verdwijnen
3.      Select in de filter optie om alleen de "" (leeg) te laten zien.
    - [ ] Alle markers verschijnen.

##Filters combineren
1.      Laad de homepage http://localhost/
    - [ ] De kaart is zichtbaar met in de menubalk de filter "Country:".
2.      Selecteer in de filter optie Country om alleen de "Netherlands" te laten zien.
    - [ ] Alle markers buiten nederland verdwijnen, mits deze geaccepteerd waren door de coördinator.
3.      Selecteer in de filter optie Location Type de "education" te laten zien.
4.      Selecteer in de filter optie Project Type om alleen de "minor" te laten zien.
    - [ ] Alleen markers in nederland met het "education" type en het "internship" type zijn zichtbaar.

##Correct uploaden excel bestand
1.      Login als coordinator en ga onder management naar Upload Excelsheet
2.      Klik op de knop "Bestand kiezen" en kies een bestand met een .xslx of .xsl extentie.
3.      Druk op de knop "Upload Excelsheet"
    - [ ] Als output krijg je een pagina met daarop de naam, type, size en opslaglocatie over het excel bestand.

##Incorrect uploaden excel bestand
1.      Login als coordinator en ga onder management naar Upload Excelsheet
2.      Klik op de knop "Bestand kiezen" en kies een bestand met GEEN .xslx of .xsl extentie.
3.      Druk op de knop "Upload Excelsheet"
    - [ ] Als output krijg je een pagina met daarop "invalid filetype"

##Te groot excel bestand uploaden
1.      Login als coordinator en ga onder management naar Upload Excelsheet
2.      Klik op de knop "Bestand kiezen" en kies een bestand met een .xslx of .xslextentie EN het bestand moet groter zijn dan 1mb.
3.      Druk op de knop "Upload Excelsheet"
    - [ ] Als output krijg je een pagina met daarop "Filesize is too big"
    - [ ] Alleen markers in nederland zijn zichtbaar met het "education" type, mits deze geaccepteerd waren door de coördinator.

##Excel bestand succesvol uploaden
1.      Log in als coordinator en ga naar het admin gedeelte
    - [ ] De knop "Excelsheet Uploaden" is zichtbaar.
2.      Klik op "Excelsheet Uploaden" en upload het bestand import.xlsx en klik op "Upload"
    - [ ] Je komt op een volgende pagina waar er verwerkt word.

##Excel bestand onsuccesvol uploaden
1.      Log in als coordinator en ga naar het admin gedeelte
    - [ ] De knop "Excelsheet Uploaden" is zichtbaar.
2.      Klik op "Excelsheet Uploaden" en upload een bestand zonder .xslx extentie en klik op "Upload"
    - [ ] Je komt op een volgende pagina waar een error weergeven word.

##Excel bestand onsuccesvol uploaden (2)
1.      Log in als coordinator en ga naar het admin gedeelte
    - [ ] De knop "Excelsheet Uploaden" is zichtbaar.
2.      Klik op "Excelsheet Uploaden" en upload een met .xslx EN die groter is dan 1mb extentie en klik op "Upload"
    - [ ] Je komt op een volgende pagina waar een error weergeven word.

##Excel bestand verwerken
1.      Log in als coordinator en ga naar het admin gedeelte
    - [ ] De knop "Excelsheet Uploaden" is zichtbaar.
2.      Klik op "Excelsheet Uploaden" en upload een import.xlsx en klik op "Upload"
    - [ ] Je komt op een volgende pagina waar een error weergeven word.
    - [ ] In de database staan de waardes uit het import bestand.

##Excel bestand dubbel uploaden
1.      Log in als coordinator en ga naar het admin gedeelte
    - [ ] De knop "Excelsheet Uploaden" is zichtbaar.
2.      Kies het import bestand en druk op "Excelsheet Uploaden".
3.      Ga terug naar het upload scherm.
4.      Kiet het import bestand en druk op "Excelsheet Uploaden".
    - [ ] Op het scherm komt te staan dat de ingevoerde data al bestaat.
    - [ ] De data komt niet dubbel voor in de database.

##Bijlage
###1. Incorrecte registreren waarden

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
E-mail|pat@example.com
First Name|Patrick
Surname|Berenschot
City|Arnhem
Zipcode|6000AA
Street|Straatnaam
Streetnumber|12
Addition|[leeg]
Registration Code | 1234567890

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

###5. Correcte nieuw Project
Veld|Waarde
--------|--------
Type|Minor
Location|Avans Hogeschool ('s-Hertogenbosch)
Start Year|2013
Start Month|September
End Year|2014
End Month|February

###6. Correct een review aanmaken
Veld|Waarde
--------|--------
Project|Avans Hogeschool ('s-Hertogenbosch) - Internship
Assignment score|Not Relevant
Guidance score|2
Accomodation score|3
Overall score|3
review|Dit is een test review.
