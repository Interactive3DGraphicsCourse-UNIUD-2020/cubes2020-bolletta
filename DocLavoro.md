# Log lavoro:

	* 28/10/19:
		Progettazione idea simil populous
		Studio funzionamento HeightMap, implementazione
		
	* 29/10/19:
		Implementazione del "crop" nel terreno del mondo
			* initiateTerrain()  :  inizializza la mappa
			* updateTerrainVis() :  passa alla scena solo il terreno "utile"
			* onDocumentKeyDown():  input della tastiera per muovere il "crop" della mappa
		uso della camera ortogonale 
		resize del renderer con resize schermo
		
		La mappa si muove al premere dei btn WASD sino al bordo
	
	* 30/10/19:
		Implemetazione shader material sabbia
			con luccichio e ombra posizionale non trasmessa
	
	* 31/10/19:
		Implemetazione shader material erba
			con ombra posizionale non trasmessa e movimento
		Implemetazione shader material acqua
			con luccichio e movimento
		Implemetazione shader material neve
			con luccichio e ombra posizionale non trasmessa
	
	* 1/10/19:
		Aggiunta bottoni comando x posizione
		Aggiunta funzione per alzare o abassare il terreno,+ btn x controllarlo
		aggiunti btn per terremoto, tzunami(errore di alpha), meteorite(ancora non implementato)
			rotazione con correzione di direzione e zoom in/out
		vertexWater  tzunami ma errore alpha
		
	* 2/10/19:
		correzione alpha dello tzunami e suo aspetto
		implementazione meteorite senza texture con funzionalità del impatto
		correzione direzione 
	
	* 3/10/19:
		aggiunta bussola con direzione
	
	* 4/10/19
		Aggiunta scambio giorno notte un po netto
		aggiunto orologio in alto a sinistra
		correzione bug di shader
	
	* 5/10/19
		bug direzione sfalsata
		implementato effetto esplosione con fragment e vertex, e oggetto esplosione
		meteoraAction(positione) : crea anche l'intervallo per gestire l'animazione delle esplosioni
		implementato shader meteora
		correzione colori
		la mappa ruota al premere di Q(orario), E(antiorario)
	
	* 6/10/19:
		implementato camminatore errante nella mappa
		