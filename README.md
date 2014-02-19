Tainted-Aberrant-Lion
=====================

School project

##Versie
Huidige versie is 0.1 na de eerste sprint. Deze is getagd als `Eerste Sprint` met git.


##Pagina's
* [Scrumboard](https://huboard.com/waaghals/Tainted-Aberrant-Lion)
* [Burndown chart](http://radekstepan.com/github-burndown-chart/#!/waaghals/Tainted-Aberrant-Lion)

##Doctrine
#####Instellingen
De database instellingen zitten een beetje verborgen maar je kan ze vinden in: /PROJ/Classes/Helper/DoctrineHelper.php

<br>

#####Doctrine Database Commands
Met doctrine heb je verschillende commands nodig om de database structuur te updaten. Deze kun je invoeren op /console.php

> orm:validate-schema

Dit commando kun je gebruiken om je Entities (de relaties daartussen) te valideren. Dit commando geeft ook precies aan wat de fouten zijn.

> orm:schema-tool:update --dump-sql

Dit commando draai je altijd als eerste om te kijken of de SQL is wat je verwacht en om te kijken of je geen errors krijgt.

> orm:schema-tool:update --force

Als het dump-sql commando geen errors terug geeft, kun je --force gebruiken om de changes naar de database op te slaan.

<br>

#####Proxy's
Alles wat in \Classes\PROJ\Proxies staat moet je niet editen. Je kan het wel doen maar Doctrine genereerd die shit vanzelf. Alles wat je doet wordt dus gewoon overschreven.

<br>

#####Debuggen
Een doctrine entity **NOOIT** print_r of var_dumpen! Altijd de Debug functie hier voor gebruiken.

>\Doctrine\Common\Util\Debug::dump( )

<br>

#####Handige links
* [Doctrine Mapping](http://docs.doctrine-project.org/en/2.0.x/reference/association-mapping.html)
* [Doctrine Inheritance Mapping](http://docs.doctrine-project.org/en/2.0.x/reference/inheritance-mapping.html)
* [Doctrine Annotations](http://docs.doctrine-project.org/en/latest/reference/annotations-reference.html#annref-column)


##Website
Het handigste is als we MVC gaan gebruiken. Ik heb het project al zo opgezet dat dit makkelijk moet gaan. In /PROJ/Classes/Pages zet je de pagina's ie bij URL benaarderbaar moeten zijn. dus bijvoorbeeld {domain}/DemoPage/. De index zorgt er al voor dat deze automatisch aangeroepen worden. **LET OP!** Deze pagina's worden **ALLEEN** aangeroepen als ze de MainPage extenden! Anders krijg je een 404.

In die paginas kun je dan de view aanroepen afhankelijk van overige url parameters ({domain}/DemoPage/Parm1/Parm2/Parm3). 

Probeer database handelingen zoveel mogelijk in een controller te doen. Het makkelijkste is om hier een Singleton van te maken (Zie DemoController.php in /PROJ/Classes/Controller/)

<br>
##Defenition of Done


* Het gemaakte werk moet voldoen aan de acceptatie criteria van de user story
* de broncode  van het gemaakte werk heeft unit tests 
* De broncode wordt gereviewd door twee anderen teamleden die het te reviewen werk niet gemaakt hebben.
* Deployement script is getest en werkend met de nieuwe functionalitiet. 
* Database wordt ook geupdate
* Documentatie is bijgewerkt. 
* Zodra een nieuwe functie voldoet aan de DOD mag de nieuwe functionaliteit in de DEV Branch worden gemerged 

<br>
