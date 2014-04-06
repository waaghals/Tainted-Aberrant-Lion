#Test document

In dit document worden de stappen beschreven waarin de __acceptence criteria__ van de __use cases__ getest worden. Het script dient van boven tot onder doorlopen te worden. Het is niet de bedoeling om steeds één stuk te testen. Het hele testplan moet afgelopen worden zodat zeker is dat de onderdelen onderling werkend blijven.

Het document heeft de volgende structuur.
Elk onderdeel heeft een subtitel welke aangeeft welke use case het dekt.
Daar onder staan de stappen welke doorlopen moeten worden. Deze stappen zijn altijd genummerd. Indien er achter de zin tussen haakjes en onderstreept tekst staat, dat is de betreffende __acceptence criteria__ welke gedekt wordt mocht die stap succesvol zijn afgelegd.
Onder deze stappen is het mogelijk dat er bepaalde eisen staan. Deze eisen moeten zijn voldaan voor de bovenstaande stap. Indien dat niet het geval is dan is er er een gedeelte van een __acceptence criteria__ niet behaald en daarmee dus ook de __acceptence criteria__ niet. Dit betekend dat de __use case__ niet meer correct is geimplementeerd of werkt.

##Voorbereiding

1. Leeg alle tabellen in de database met phpMyAdmin.
2. Breng de database structuur up-to-date door naar http://localhost/console.php te gaan
3. Run het commando `orm:schema-tool:update --force` te runnen.
	* Er komt geen `[FAIL]` voor in het resultaat.
4. Vul de database met test data door naar http://localhost/testData/create te gaan.
	* Er staat meerdere keren `<iets> has been added to the database successfully`
	* Er zijn geen errors
5. Run alle unit tests
	* Er mogen geen failures optreden!

##Responsiveness testen
#### (20.) As a visitor I want to I want to see the world map so I can easiliy see which places are available for me.

1. Laad de homepage http://localhost _(Visitor must be able to view the world map)_
	* Er is een map zichtbaar
2. Vergroot en verklein het scherm
    * Tekst dient kleiner te worden blij kleinere schermen.
    * Er staan ongeveer tussen de 45 en 75 tekens op één regel
    * Bij kleine schermen (zoals voor telefoons) komen meerdere kolommen tekst onder elkaar te staan.
3. Test of de kaart werkt _(Visitor must be able to zoom in / out)_
    * Je kunt zoomen door te scrollen 
    * Je kunt zoomen door met twee vingers een zoom gesture te maken.
    * Je kan de kaart verslepen met de muis of vinger.
4. De sidebar is te openen en te sluiten
    * De sidebar moet sluiten door naar links te slepen met de muis of vinger indien deze open is.
    * De sidebar moet openen door deze naar rechts te slepen met de muis of vinger indien deze gesloten is.
5. Vul de database met test data
6. Controleer of de `institute`'s op de kaart staan.
    * Kijk of de marker uit de database ook op de kaart komen te staan.
    * Een `institute` met `type` `education` dient een icoontje van een schoolhoedje te zijn.
    * Een `institute` met `type` `business` dient een icoontje van een bedrijfsgebouw te zijn.
7. Klik op de marker in ``s-Hertogenbosch`
    * De sidebar is nu geopend indien deze gesloten was.
8. Klik op de naam `Kees Jansen`  _(Visitor must be able to see all reviews or internships on the map.)_
	* De tekst van de review is `Good things happend here`
	* De review heeft 4 van de 5 sterren.


##Login
#### (33.) As a informant I want to login so I can make sure no other people can modify my reviews.
###Correcte inlog:

1.	Laad de homepage http://localhost/account/login/
    * Er is een inlogscherm zichtbaar
2.	Vul als gebruikersnaam `hbakker` en wachtwoord `password` in
3.	Klik op de knop `login` _(Informant must be able to login)_
	* Je wordt doorgestuurd naar de homepage
    * Rechtst bovenin de balk is de voornaam `harry` van de test gebruiker zichtbaar.

###Uitloggen:
1.	Klik rechtsboven op `Log uit`
	* Je wordt doorgestuurd naar de homepage
    * Rechtst bovenin de balk staan er weer twee knoppen `Registreren` en `Log in`

###Foutieve inlog:

1.	Laad de homepage http://localhost/account/login/
    * Er is een inlogscherm zichtbaar
2.	Vul als gebruikersnaam `hbakker` en wachtwoord `ongeldig` in
3.	Klik op de knop `login`
	* Het login veld wordt geleegd.
	* Je wordt niet doorgestuurd naar een andere pagina.

###Bruteforce inlog:

1.	Laad de homepage http://localhost/account/login/
    * Er is een inlogscherm zichtbaar
2.	Vul als gebruikersnaam `hbakker` en wachtwoord `ongeldig` in
3.	Klik op de knop `login`
	* Het login veld wordt geleegd.
	* Je wordt niet doorgestuurd naar een andere pagina.
4.	Vul als gebruikersnaam `hbakker` en wachtwoord `ongeldig` in
5.	Klik op de knop `login`
	* Het login veld wordt geleegd.
	* Je wordt niet doorgestuurd naar een andere pagina.
6.	Vul als gebruikersnaam `hbakker` en wachtwoord `ongeldig` in
7.	Klik op de knop `login`
	* Het login veld wordt geleegd.
	* Je wordt niet doorgestuurd naar een andere pagina.
8.	Vul als gebruikersnaam `hbakker` en wachtwoord `password` in
9.	Klik op de knop `login`
	* Het login veld wordt geleegd.
	* Je wordt niet doorgestuurd naar een andere pagina.
	* Je wordt niet ingelogd aangezien je de aantal pogingen hebt overschreven.
10. Ga naar de homepagine op http://localhost
	* Rechtst bovenin de balk staat nogsteeds de knop `Log in`

###Inloggen na bruteforce:

1. Leeg de tabel `loginattempt` in phpMyAdmin
2.	Laad de homepage http://localhost/account/login/
    * Er is een inlogscherm zichtbaar
3.	Vul als gebruikersnaam `hbakker` en wachtwoord `password` in
4.	Klik op de knop `login` _(Informant must be able to login)_
	* Je wordt doorgestuurd naar de homepage
    * Rechtst bovenin de balk is de voornaam `harry` van de test gebruiker zichtbaar.

###Incorrect registreren:

1. Laad de homepage http://localhost/account/register/
    * Er is een registreerscherm zichtbaar
2. Vul de gegevens in volgens bijlage 1.
3. Klik op de knop `Register`
	* Er komt een error op het scherm dat de gebruikers naam al ingebruik is.

###Correct registreren:

1. Laad de homepage http://localhost/account/register/
    * Er is een registreerscherm zichtbaar
2. Vul de gegevens in volgens bijlage 2.
3. Klik op de knop `Register`
	* Je wordt doorgestuurd naar de homepage
4. Klik op de knop `Log in` rechtsboven in de balk.
    * Er is een inlogscherm zichtbaar
5.	Vul als gebruikersnaam `patrick` en wachtwoord `iscool` in
6.	Klik op de knop `login` _(Informant must be able to login)_
	* Je wordt doorgestuurd naar de homepage
    * Rechtst bovenin de balk is de voornaam `Patrick` van de test gebruiker zichtbaar.

##Contact
#### (19.) As an visitor I want to be able to get in contact with an informant so I can Ask him questions about the place he went.

###Correcte verzenden:

1.	Op de review van `Kees Jansen` van de `Avans Hogeschool` in `s-Hertogenbosch.
2.	Klik naast `Neem contact op met` op `Kees` _(Visitor can view a review and press a contact button)_
	* Er is een contact formulier zichtbaar
	* In het veld `Aan` staat `Kees Jansen`
3. Vul je eigen email adres in
4. Typ een onderwerp
5. Typ een bericht
6. Klik op de knop `send` _(Visitor can email the informant)_
	* In het resultaat staat `Email send`

##Zoeken
#### (34.) As a visitor I want to search so I can get a specific project review.

###Zoeken naar bestaande review:

1. Laad de homepage http://localhost/
    * Rechts boven is een zoekformulier zichtbaar.
2. Vul het woord `things` _(Visitor must be able to insert a keyword.)_
	* Er komt een dropdown met gevonden reviews.
3. Klik op een resultaat  _(Results will be shown if found.)_
	* De sidebar wordt geopend en de betreffende review wordt er in getoont.

###Zoeken naar bestaande locatie:

1. Laad de homepage http://localhost/
    * Rechts boven is een zoekformulier zichtbaar.
2. Vul het woord `Avans` _(Visitor must be able to insert a keyword.)_
	* Er komt een dropdown met `Avans Hogeschool` als resultaat.
3. Klik op een resultaat  _(Results will be shown if found.)_
	* De sidebar wordt geopend en de betreffende locatie wordt getoont.
	* Het is mogelijk om vanaf hier de reviews van `Avans` de bekijken.


###Zoeken naar niet bestaande review:

1. Laad de homepage http://localhost/
    * Rechts boven is een zoekformulier zichtbaar.
2. Vul het woord `nope`
	* Er komt een dropdownp.
	* In de dropdown staat `No search results found`



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

###2. Correcte registreren waarden
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

###Groeperen van markers:

1.	Laad de homepage http://localhost/
    * Er is een kaart zichtbaar
2.	Zoom uit of in
	* De hoeveelheid markers in een bepaald gebied wordt aangegeven door kleuren, het aantal markers, in dat gebied, staat in de 'groepeerings'-marker:
	* Vanaf 1 tot en met 9 markers in het gebied, dan wordt de 'groepeerings'-marker blauw gekleurd.
	* Vanaf 10 tot en met 99 markers in het gebied, dan wordt de 'groepeerings'-marker geel gekleurd.
	* Vanaf 100 markers in het gebied, dan wordt de 'groepeerings'-marker rood gekleurd.