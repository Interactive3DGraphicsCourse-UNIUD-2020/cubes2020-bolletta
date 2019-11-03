# Progetto Cubes Bolla - Populous 1989 world editing and small god action
	
![Image Preview](/preview/preview.png)
	
## Goals 
In this project you'll first create an interesting scene of your own design, made up just of cubes. The cubes can be
translated, scaled and rotated as you wish. For inspiration, look at [Minecraft](https://minecraft.net/en-us/), 
Legos, and voxel-based games such as [Crossy Road](http://www.crossyroad.com).

I am not expecting something highly complex, but I expect something **interesting** and that you use **at least 30 cubes**.

In addition, provide your model with a simple but meaningful animation. To do this, you'll have to structure the scene
graph in a convenient way. The animation can continuosly play itself, or can be controlled by the user through UI controls.

After creating a scene, you have a choice:

- if you are more interested in programming, you can choose to create a terrain for your scene, using a heightmap in the
form of a greyscale image as input;
- alternatively, you can choose to create a short movie that presents your scene.

In either case, see the next sections for more detailed instructions and suggestions. You are also required to document your
work and write a final report, as detailed below. 


## Report

Il progetto ripropone il gestore del mondo di populous semplificato in chiave voxel con alcune capacità divine, quali il
terremoto, lo tzunami e la meteorite.

#### Interfaccia

	L' interfaccia si compone di un tastierino sulla sinistra con le seguenti feature dal alto-sinistro muovendosi per righe crescenti:
		* 9 bottoni direzionali per muoversi nelle varie direzione (se fine mappa non si muove)
			
			![Image arrow](/textures/arrow.png)
		
		* 2 bottoni per gestire l'altezza terreno
		
				![Image alza](/textures/alza.png) ![Image bassa](/textures/bassa.png)
		
		* bottone potere terremoto
			
			![Image trremoto](/textures/terremoto.png)
		
		* bottoni per lo zoom
			
			![Image piu](/textures/piu.png) ![Image meno](/textures/meno.png)
		
		* bottoni per ruotare la mappa
			
			![Image Clock](/textures/Clock.png) ![Image AClock](/textures/AClock.png)
		
		* bottone potere tzunami
			
			![Image wave](/textures/wave.png)
		
		* bottone potere meteorite
			
			![Image meteora](/textures/meterora.png)
	
	di una bussola che indica la posizione, il tutto su un tavolo al cui centro si può vedere la mappa dela mondo modificabile

#### Poteri

	* altezza Terreno:
		si può alzare o abassare il terreno andando a premere i bottoni adeguati e cliccando poi la mappa
	
	* Terremoto:
		il Terremoto va a modificare l'aspetto del terreno alzando e abassando l'altezza massima dei blocchi con una semplice 
		animazione di tutta la mappa al centro, simulando un terremoto ondulatorio
	
	*Tzunami:
		lo Tzunami va ad alzare l'acqua con una mappa a punti,non interferisce in nessun modo con il terreno ma ha solo
		carattere grafico
	
	* Meteora:
		la Meteora crea un meteorite che va a inpattarsi con il terreno ove si è cliccato dopo averlo selezionato, all'impatto
		genera un cratere di dimensioni circa 6x6 di profonidità 3, modificando il terreno
	
#### journal
	
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
			* onWindowResize()   : resize view
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
		*  materiale(posY) : setta materiale in base all'altezza
	
	* 1/10/19:
		Aggiunta bottoni comando x posizione
			* initiateButton() : posizione
		Implementazione funzione per alzare o abassare il terreno e bottoni per controllarlo
			* modifyTerrainHigh(position,value) : aumenta altezza terreno in posizione position di un valore value
			* onDocumentMouseMove()	: per estrapolare posizione mouse
			* onDocumentMouseUp()   : per quando si lascia il bottone
			* onDocumentMouseDown() : per intercettare cosa si clicca sullo schermo
			* initiateButton()		: add, subtruct height
		aggiunti btn per terremoto, tzunami(errore di alpha), meteorite(ancora non implementato)
			* terremotoAction()	: gestione terremoto
			* waveAction()		: gestione tzunami
			* initiateButton()  : terremoto, tzunami e meteorite
		rotazione con correzione di direzione e zoom in/out
			* initiateButton()  : +, - per lo zoom
		vertexWater  tzunami ma errore alpha
			
		
	* 2/10/19:
		correzione alpha dello tzunami e suo aspetto
		implementazione meteorite senza texture con funzionalità del impatto
			* meteoraAction(positione) : gestore meteora data la posizione di dove dovra colpire
		correzione direzione 
			* directionAction(dir) : gestione direzioe data la rotazione (0 = north, 1 = north-est, 2 = est, ... , 6 = west, 7 = nort-west)
					
	* 3/10/19
		aggiunta bussola con direzione
		
#### Programmi usati
	
	immagini e texture Paint.net ver: 4.205
	shader test ShaderToy	
	editor di testo Notepad++ ver: 7.7.1
	server Web Apache ver: 2.4
	
#### Aggiunte future (modificabile)
	
	* aggiunta popolo che si auto gestisce
	* ottimizzazione voxel con creazione di un unica mesh anzichè tanti cubi
	* creazione shader meteora e effetto esplosione impatto (sfera che cresce e scompare)
	
	
#### shader vari
	
	* materialBussola 	: fragmentBussola, 	vertex			
	* materialButton 	: fragmentButton,	vertex
	* materialSnow  	: fragmentSnow, 	vertex
	* materialSand		: fragmentSand, 	vertex
	* materialBadRock	: fragmentBadRock, 	vertex
	* materialWater		: fragmentWater, 	vertexWater
	* materialGrass		: fragmentGrass, 	vertexGrass