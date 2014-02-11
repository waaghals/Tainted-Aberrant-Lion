Tainted-Aberrant-Lion
=====================

School project

##Pagina's
* [Scrumboard](https://huboard.com/waaghals/Tainted-Aberrant-Lion)
* [Burndown chart](http://radekstepan.com/github-burndown-chart/#!/waaghals/Tainted-Aberrant-Lion)

##Doctrine
#####Instellingen
De database instellingen zitten een beetje verborgen maar je kan ze vinden in: /PROJ/Classes/Helper/DoctrineHelper.php

#####Doctrine Database Commands
Met doctrine heb je verschillende commands nodig om de database structuur te updaten. Deze kun je invoeren op /console.php

> orm:schema-tool:update --dump-sql

Dit command draai je altijd als eerste om te kijken of de SQL is wat je verwacht en om te kijken of je geen errors krijgt.

> orm:schema-tool:update --force

Als het dump-sql command geen errors terug geeft, kun je --force gebruiken om de changes naar de database op te slaan.


#####Handige links
* [Doctrine Mapping](http://docs.doctrine-project.org/en/2.0.x/reference/association-mapping.html)
* [Doctrine Inheritance Mapping](http://docs.doctrine-project.org/en/2.0.x/reference/inheritance-mapping.html)
* [Doctrine Annotations](http://docs.doctrine-project.org/en/latest/reference/annotations-reference.html#annref-column)


##Website
Het handigste is als we MVC gaan gebruiken. Ik heb het project al zo opgezet dat dit makkelijk moet gaan. In /PROJ/Classes/Pages zet je de pagina's ie bij URL benaarderbaar moeten zijn. dus bijvoorbeeld {domain}/DemoPage/. De index zorgt er al voor dat deze automatisch aangeroepen worden. LET OP! Deze pagina's worden ALLEEN aangeroepen als ze de MainPage extenden! Anders krijg je een 404.

In die paginas kun je dan de view aanroepen afhankelijk van overige url parameters ({domain}/DemoPage/Parm1/Parm2/Parm3). 

Probeer database handelingen zoveel mogelijk in een controller te doen. Het makkelijkste is om hier een Singleton van te maken (Zie DemoController.php in /PROJ/Classes/Controller/)
