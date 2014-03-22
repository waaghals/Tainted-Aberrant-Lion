Requirements:
- Een op Debian gebaseerd besturingssysteem moet draaien op de server.
- Je hebt root rechten nodig op de server.

Stappenplan:
1. Installeer php5, apache2, mysql en phpunit op de gewenste server.
2. Zet alleen de inhoud van de deployment directory op de server. En behoud hiermee de mappenstructuur.
3. Voeg de WWW-Data toe aan de SUDO'ers zodat dit commando's zonder wachtwoord uitgevoerd kunnen worden. Dit doe je door het volgende commando uit te voeren: www-data ALL = NOPASSWD:/usr/bin/git
4. Activeer de sites door het volgende commando uit te voeren: a2ensite stable a2ensite dev a2ensite api
5. Maak DNS records aan voor de ServerName uit de Virtual Hosts. Je kan er ook voor kiezen om de Virtual Host aan te passen.
6. Maak SSH communicatie werkend voor de ww-data gebruiker zodat deze met github kan praten.
7. Set op github een post receive hook in voor pushes naar de API virtual hosts. (http://api.toip.nl).
8. Ga nu naar DOMAIN/tal/api en wacht totdat deze klaar is en je de volgende message krijgt : Pulling repository
9. Ga daarna naar DOMAIN/console.php en voer het volgende commando uit : orm:schema-tool:update --force

Nu is de site volledig functioneel.
