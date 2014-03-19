#Test document

##Unit testing

1. Run alle unit tests
	* Er mogen geen failures optreden!

##Responsiveness testen
#### (20.) As a visitor I want to I want to see the world map so I can easiliy see which places are available for me.

1. Laad de homepage `http://localhost` (Visitor must be able to view the world map)
	* Er is een map zichtbaar
2. Vergroot en verklein het scherm
    * Tekst dient kleiner te worden blij kleinere schermen.
    * Er staan ongeveer tussen de 45 en 75 tekens op één regel
    * Bij kleine schermen (zoals voor telefoons) komen meerdere kolommen tekst onder elkaar te staan.
3. Test of de kaart werkt (Visitor must be able to zoom in / out)
    * Je kunt zoomen door te scrollen 
    * Je kunt zoomen door met twee vingers een zoom gesture te maken.
    * Je kan de kaart verslepen met de muis of vinger.
4. De sidebar is te openen en te sluiten
    * De sidebar moet sluiten door naar links te slepen met de muis of vinger indien deze open is.
    * De sidebar moet openen door deze naar rechts te slepen met de muis of vinger indien deze gesloten is.
5. Vul de database met test data
6. Controleer of de `institute`'s op de kaart staan. (Visitor must be able to see all reviews or internships on the map.)
    * Kijk of de marker uit de database ook op de kaart komen te staan.
    * Een `institute` met `type` `education` dient een icoontje van een schoolhoedje te zijn.
    * Een `institute` met `type` `business` dient een icoontje van een bedrijfsgebouw te zijn.
6. Klik op een marker
   * De sidebar is nu geopend indien deze gesloten was.
