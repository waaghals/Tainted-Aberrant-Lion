# Deployment
## Bestanden
Plaatst alle bestanden uit deze map met de zelfde structuur op de server waarop een lamp stack staat.

## Sites beschikbaar maken
Activeer de sites met apache d.m.v.
   a2ensite stable
   a2ensite dev
   a2ensite api

## DNS
Maak DNS records aan voor de `ServerName` uit de virtual hosts. (of pas de VH aan)

## Github
### SSH
Maak SSH communicatie werkend voor de ww-data gebruiker zodat deze met github kan praten.

### Post receive hook
Set op github een post receive hook in voor pushes naar de API virtual hosts.
(http://api.toip.nl)

## Sudoers
Voeg de www-data toe aan de sudoers zodat deze het `git` commando wachtwoordloos kan uitvoeren.
`www-data ALL = NOPASSWD:/usr/bin/git`

#KLOAR