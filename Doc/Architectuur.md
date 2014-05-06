#Architectuur

##0. Terminology

* Bootstrapping, Het opstarten van het hele mvc proces.
* Request, De aanvraag vanaf de browser naar de server.
* Router, Het onderdeel van de MVC welke de juiste controller aanroept.
* Action, Specifiece methodes welke worden aangeroepen a.d.h.v. de URI. Deze eindige altijd op Action zodat niet zomaar alle functies kunnen worden aangeroepen.

##1. Entry point
Het entry point is `./index.php`. Door middel van URL rewriting worden alle request welke geen bestand zijn
doorgestuurd naar apache. Hierin vind de __bootstrapping__ (zie punt 2.) plaats.

Daarna wordt een nieuw klasse `Request` gemaakt welke de URI onderdelen splitst
in een controller gedeelte, actie gedeelte en eventuele paramters.

Vervolgens wordt door de klasse `Router` de `Request` verwerkt. Hierin wordt gekeken
of de aangevraagde controller en action (methode) bestaat. Nadat zeker is dat de methodes gelig zijn wordt de
controller gemaakt en de actie aangeroepen. Als laatste bepaald de actie wat de body wordt van de request door deze te outputten.

##2. Bootstrapping
In de index gebeuren een aantal dingen. Ten eerste wordt de __autoloader__ (zie punt 4.2.) geladen.
Daarna worden er handige constants gedefineerd. Eventuele andere dingen die dienen te gebeuren voordat de controller en de bijbehorden action word aangeroepen kunnen hierworden georganiseerd.

##3. MVC
Het zelfgemaakte framework is volgens de MVC methodiek gebouwd. Hierbij zijn er dus _controllers_, _models_ en _views_. Vervolgens is er nog een extra laag, de _services_. I.p.v. de database interactie en de verwerking daarvan in de models te doen wordt nu de database communicatie in de achtergrond verzorgt door __Doctrine__, het resultaat daarvan wordt in de models gestopt. Daarna kan een service met de data aan de slag.

###3.1. Controllers
Alle controllers extenden `baseController`. Deze speciale controller zorgt er voor dat de juiste action wordt aangeroepen en de parameters worden gevuld met de parameters uit de URI.

Elke controller heeft zo zijn eigen actions welke de juiste _views_, _services_ en eventueel _models_ gebruikt om tot een resultaat te komen. Dit resultaat wordt terug gestuurt naar de gebruiker.

###3.1.1. Overzicht
Hieronder een overzicht van de controllers.
![](img/controllers.png)



###3.2. Models
Zoals in punt 3. kort toegelicht zijn de _models_ pure data containers. De data wordt door __Doctrine__ opgehaald uit de database of ook door __Doctrine__ opgeslagen. Elke verandering aan de _models_ heeft niet direct invloed op de database. Dit gebeurt pas zodra in de model de methode `persist` wordt aangeroepen.

###3.3. Views
Alle views zijn html en php door elkaar. Deze bevinden zich in de map `views` en
eindigen in `.phtml`. Bij het maken van de klasse `Template` kun je alle variabele
toewijzen, deze worden uitgepakt in de daadwerkelijke variabele in het `.phtml`
bestand.

####3.1.1. Voorbeeld
Laden van het view bestand, in dit voorbeeld het bestand `voorbeeld.phtml`.
```php
$t = new Template("voorbeeld");
$t->greeting = "hallo";
$t->where = "world.jpg"
```
Het `Voorbeeld.phtml` bestand.
```php
<h1><?php echo $greeting; ?></h1>
<img src="/img/><?php echo $where; ?>" />
```

###3.4. Services
Om onderscheid te houden tussen data en het verwerken van data hebben we een extra laag toegebracht. De _services_ laag. Hierin wordt er met de _models_ gecommuniceert en/of wordt er validaties gedaan. Door de meeste business logic in de _services_ te stoppen blijven de controllers overzichtelijk.

##4. Doctrine
Om de code vrij te houden van SQL code hebben we gekozen voor een ORM, een ORM heeft een snellere instap dan SQL laag zelf netjes te implementeren.

Vervolgens is er gekozen voor __Doctrine__ als ORM aangezien hiermee de meeste ervaring is in het team. Er is verder niet gekeken naar andere ORM's. Het is niet handig om een totaal andere ORM aan te leren als er al ervaring is met __Doctrine__.

###4.1. Entiteiten
![EER](img/EER.png)


###4.2. Autoloader
__Doctrine__ heeft een autoloader nodig om er makkelijk mee te werken. Standaard heeft __Doctrine__ een eigen autoloader waarvan wij gebruik maken. Deze autoloader implementeert de PSR-0 standaard. Hierdoor is hij makkelijk uitwisselbaar.

##5. Bestand structuur
###5.1. Folders
Klassen bevinden zich in de map classes zodat de autoloader ze kan vinden. Hierin heeft alles een eigen _vendor_ map, voor ons project is `PROJ` de _vendor_ map. In de root staan verder nog de mappen `Doctrine` en `Symphony` welke de ORM verzorgen.

Alle publieke assets zoals javascript en css bestanden bevinden zich in de mappen `js` en `css` in de root map.

###5.2. Namespaces
Namespaces dienen altijd de folder structuur aan te houden. Dus een voorbeeld entitie `Student` bevind zich in de namespace `\PROJ\Entities`. De klasse zijn altijd enkelvoudige woorden, de namespace waar ze zich in bevinden zijn in het meervoud. De map waar de voorbeelde klasse zich bevind is dan `\Classes\PROJ\Entities`

##6. Response design
Er is een stylesheet gemaakt welke css classes heeft voor resposive design.
Dit is afgeleid vanaf ["A simple guide to responsive design."](http://www.adamkaplan.me/grid)

###6.1 Introductie
Het uiterlijk dient Mobile First te zijn. Dit houd in dat de inhoud standaard is gemaakt voor op kleinere apparaten. Vervolgens worden er onderdelen aan toegevoegd of worden onderdelen anders ingedeeld zodra het scherm groter wordt.

###6.2 Classes
Alle kolommen zitten altijd in een container. De container zorgt voor de maximale breedte zodat de kolommen hier niets van hoven te weten. De kolommen neem hun breedte aan vanaf de container waarin ze zitten. Het is dus mogelijk om meerdere containers te hebben.
```
<div class="container">
  <!-- Inhoud -->
</div>
```

Een kolom is altijd een blocklevel element. (Vult alle beschikbare breedte.)
```
<div class="container">
  <div class="column">
    <!-- Inhoud -->
  </div>
</div>
```

Zodra een venster grooter wordt dan krijgen colummen het eigenschap `float: left;`. Hierdoor worden de colummen op grotere schermen naast elkaar afgebeeld. Om de groote van de colummen aan te geven zijn er extra klassen.
```css
.full { width: 100%; }
.two-thirds { width: 66.7%; }
.half { width: 50%; }
.third { width: 33.3%; }
.fourth { width: 24.95%; }
.fifth { width: 20%; }
.two-fifth { width: 40%; }
.three-fifth { width: 60%; }
.four-fifth { width: 80%; }
.flow-opposite { float: right; }
```
Standaard heeft een column al de breedte 100% dus de klasse `.full` is optioneel.


Om er voor te zorgen dat kolommen niet naast elkaar blijven stapelen kunnen ze in rijen worden geplaatst. Na een rij dient de `float`'s te worden gereset. Dit gebeurd door de bekende __clearfix__ hack. Je hoeft alleen een extra element om de kolommen te voegen welke in de zelfde rij dienen te zitten. Vervolgens wordt aan dat element de klassen `.row` en `.clearfix` gedaan.
```
<div class="container">
  <div class="row clearfix">
    <div class="column half">
      <!-- Inhoud -->
    </div>
    <div class="column half">
      <!-- Inhoud -->
    </div>
  </div>

  <div class="row clearfix">
    <div class="column half">
      <!-- Inhoud -->
    </div>
    <div class="column half">
      <!-- Inhoud -->
    </div>
  </div>
</div>
```

Er zit een standaard flow in deze opmaak. Alle kolommen welke als eerst in de opmaak staan worden als eerst getoont. Indien de ruimte er is worden er aan de rechterkant kolommen bij geplaatst. Soms is het toch wensbaar oom op grotere schermen een kolom eerst rechts te tonen terwijl die op kleinere schermen als eerste getoont dient te worden. Hiervoor is er de klasse `.flow-opposite`.

Aan de elementen kan verder nog een eigen stijl gegeven worden. De bovenstaande klasses zijn er puur om de markup responsive te houden.
