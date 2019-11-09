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
	
	* 1/11/19:
		Aggiunta bottoni comando x posizione
		Aggiunta funzione per alzare o abassare il terreno,+ btn x controllarlo
		aggiunti btn per terremoto, tzunami(errore di alpha), meteorite(ancora non implementato)
			rotazione con correzione di direzione e zoom in/out
		vertexWater  tzunami ma errore alpha
		
	* 2/11/19:
		correzione alpha dello tzunami e suo aspetto
		implementazione meteorite senza texture con funzionalità del impatto
		correzione direzione 
	
	* 3/11/19:
		aggiunta bussola con direzione
	
	* 4/11/19
		Aggiunta scambio giorno notte un po netto
		aggiunto orologio in alto a sinistra
		correzione bug di shader
	
	* 5/11/19
		bug direzione sfalsata
		implementato effetto esplosione con fragment e vertex, e oggetto esplosione
		meteoraAction(positione) : crea anche l'intervallo per gestire l'animazione delle esplosioni
		implementato shader meteora
		correzione colori
		la mappa ruota al premere di Q(orario), E(antiorario)
	
	* 6/11/19:
		implementato camminatore errante nella mappa
		
	* 7/11/19:
		implementata animazione camminatore errante
		aggiunto bottone per centrare il camminatore
		correzione movimento camminatore (no in acqua e no camminata oltre 2 blocchi altezza)
		implementato un loadState per controllare lo stato del caricamento
		
	* 8/11/19:
		Corretto combattimento sulla Z tra table e i bottoni
		ritocco di alcune texture
		
	* 9/11/19:
		correzione bug posizione meteora alla rotazione della mappa
		correzione teletrasporto Camminatore Errante in caso di caduta in ac
		