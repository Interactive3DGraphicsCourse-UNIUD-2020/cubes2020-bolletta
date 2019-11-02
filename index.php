<html>
	<head>
		<title>Starting Code for 1st Project 2017</title>
		<style>
		
		body {
			font-family: Monospace;
			background-color: #f0f0f0;
			margin: 0px;
			overflow: hidden;
		}
		
		canvas { 
			width: 100%; 
			height: 100%;
		}
	
	</style>
		<script id="fragmentButton" type="glsl/x-fragment">
			
			uniform sampler2D tex;
			uniform float alpha;
			varying vec2 vUv;
			varying vec3 vPosition;
			varying vec3 vNormal;
				
			

			void main() {
				vec2 uVu  = vUv;
				float shaderFactor = dot(vNormal, vec3(0.255, 0.67, 0.8));
				float med = 0.5;
				uVu = vec2(
					cos(alpha) * (uVu.x - med) + sin(alpha) * (uVu.y - med) + med,
					cos(alpha) * (uVu.y - med) - sin(alpha) * (uVu.x - med) + med
				);
				
				vec4 color = texture2D(tex, uVu);
				vec4 colorBase = vec4(vec3(1.0)*shaderFactor,1.0);
				
				
				if(vPosition.y>0.499)
					
					if(color.a>0.5)
						gl_FragColor = color;
					else{ 
						gl_FragColor = vec4(vec3(1.0-abs(max(max(vPosition.x, min(vPosition.x,vPosition.z)), vPosition.z))),1.0);
						
					}
				else 
					if(vPosition.x<-0.4999 || vPosition.x>0.4999)
						gl_FragColor = vec4(vec3((1.0-abs(vPosition.z))),1.0);
					else if(vPosition.z<-0.4999 || vPosition.z>0.4999)
						gl_FragColor = vec4(vec3((1.0-abs(vPosition.x))),1.0)*shaderFactor;
					else
						gl_FragColor = colorBase;
			}
			
		</script>
		<script id="fragmentSnow" type="glsl/x-fragment">
			
			uniform sampler2D tex;
			uniform float delta;
			uniform vec3 lightPos;

			varying vec2 vUv;
			varying vec3 vNormal;
			
			vec3 light; 
				
			float random (vec2 st) {
				return fract(sin(dot(st.xy,
									 vec2(12.9898,78.233)))*
					43758.5453123);
			}
			

			void main() {
				light =   vec3(0.8);
				vec4 color = texture2D(tex, vUv);
				vec2 st = vUv.xy;
				

				st *= 15.0; 			
				vec2 ipos = floor(st);  
				vec2 fpos = fract(st);  // get the fractional coords
				vec4 rand = vec4(random( ipos ));
				vec4 randV= vec4(random(floor( gl_FragCoord.xy*0.75+vec2(sin(delta*25.0)))));
				
				float shade_factor = 0.25 + 1.3 * max(0.0, dot(vNormal, normalize(lightPos)/1.75));
				
				color = color*shade_factor*max(min((sin(delta)/1.15),0.4), 0.85);
				
				
				if(randV.x>0.95 && rand.x>0.9 && shade_factor>0.4)
					gl_FragColor = 1.15*shade_factor*vec4(1.,1.,1.,1.0)*max(0.85,(sin(delta)+0.5));
				else
					gl_FragColor = vec4(vec3(dot(color.rgb, vec3(0.299, 0.587, 0.114)))*1.35,1.0);
				
			}
			
		</script>
		<script id="fragmentSand" type="glsl/x-fragment">
			
			uniform sampler2D tex;
			uniform float delta;
			uniform vec3 lightPos;

			varying vec2 vUv;
			varying vec3 vNormal;
			
			vec3 light; 
				
			float random (vec2 st) {
				return fract(sin(dot(st.xy,
									 vec2(12.9898,78.233)))*
					43758.5453123);
			}
			

			void main() {
				light =   vec3(0.9, 0.9, 0.6);
				vec4 color = texture2D(tex, vUv);
				vec2 st = vUv.xy;
				

				st *= 15.0; 			
				vec2 ipos = floor(st);  
				vec2 fpos = fract(st);  // get the fractional coords
				vec4 rand = vec4(random( ipos ));
				vec4 randV= vec4(random(floor( gl_FragCoord.xy*0.75+vec2(sin(delta*25.0)))));
				
				float shade_factor = 0.25 + 1.3 * max(0.0, dot(vNormal, normalize(lightPos)/1.75));
				
				color = color*shade_factor*max(min((sin(delta)/1.15),0.4), 0.85);
				
				
				if(randV.x>0.95 && rand.x>0.9 && shade_factor>0.4)
					gl_FragColor = 1.15*shade_factor*vec4(1.0,0.75,0.1,1.0)*max(0.85,(sin(delta)+0.5));
				else
					gl_FragColor = color;
				
			}
			
		</script>
		<script id="fragmentBadRock" type="glsl/x-fragment">
			
			uniform sampler2D tex;
			uniform float delta;
			uniform vec3 lightPos;

			varying vec2 vUv;
			varying vec3 vNormal;
			
			vec3 light; 
				
			float random (vec2 st) {
				return fract(sin(dot(st.xy,
									 vec2(12.9898,78.233)))*
					43758.5453123);
			}
			

			void main() {
				light =   vec3(0.9, 0.9, 0.6);
				vec4 color = texture2D(tex, vUv);
				vec2 st = vUv.xy;
				
				float shade_factor = 0.25 + 1.3 * max(0.0, dot(vNormal, normalize(lightPos)/1.75));
				
				color = color*shade_factor*max(min((sin(delta)/1.15),0.4), 0.85);
				
				
				gl_FragColor = color;
				
			}
			
		</script>
		<script id="fragmentWater"  type="glsl/x-fragment">
			
			uniform float delta;
			uniform vec3 lightPos;
			
			varying vec2 vUv;
			varying vec3 vNormal;
			varying vec3 vPosition;

			float random (vec2 st) {
				return fract(sin(dot(st.xy,
									 vec2(12.9898,78.233)))*
					43758.5453123);
			}

			void main()
			{
				vec4 color1= vec4(0.4,0.6,0.8,1.0);
				vec4 colorbase;
				vec4 colorSec;
				vec4 color;

				vec2 st = vUv.xy+vec2(delta,0.0);
				
				float shade_factor = 0.25 + 1.3 * max(0.0, dot(vNormal, normalize(lightPos)/1.75));
							
				st *= 80.0; 			
				vec2 ipos = floor(st);  
				vec2 fpos = fract(st);  // get the fractional coords
				vec4 rand = vec4(random( ipos ));
				vec4 randV= vec4(random(floor( vUv.xy*80.0+vec2((delta*35.0)))));
				
				colorbase = vec4(color1.xyz, rand.x*randV.x+0.6);
				
				if(rand.x*randV.x<=0.8)
					color = colorbase;
				else
					color = vec4(1.0);
				gl_FragColor = vec4(color.rgb*(max(0.2,(sin(delta)/2.0)+0.5)+(vec3(max(0.,min(1.0,0.5-vPosition.z))))),color.a);
			}
		</script>
		<script id="fragmentGrass" type="glsl/x-fragment">
			
			uniform sampler2D tex;
			uniform sampler2D texLato;
			uniform float delta;
			uniform vec3 lightPos;

			varying vec2 vUv;
			varying vec3 vNormal;
			varying vec3 vPosition;
			
			vec3 light; 
			
			

			void main() {
				float shade_factor = 0.25 + 1.3 * max(0.0, dot(vNormal, normalize(lightPos)/1.75));
				vec4 color;
				
				light =   vec3(0.2, 0.8, 0.05);
								
				
				if(vPosition.y>0.45){
					vec2 uVu = vUv+(vec2(pow(2.72,sin(delta*30.5)/8.0)/3.5*sin(delta*10.0)/3.0, pow(2.72,sin(delta*20.5)/4.0)/2.0))/2.0;
					color = texture2D(tex, uVu);
					
					color = color*shade_factor*max(min((sin(delta)/1.15),0.4), 0.85);
				
					gl_FragColor = vec4(color.xyz*light,1.0);
				}else{
					color = texture2D(texLato, vUv);
					
					color = color*shade_factor*max(min((sin(delta)/1.15),0.4), 0.85);
				
					gl_FragColor = vec4(color.xyz,1.0);
				}
			}
			
		</script>
		<script id="vertexGrass" type="glsl/x-vertex">
			uniform sampler2D tex;
			varying vec2 vUv;
			varying vec3 vNormal;
			varying vec3 vPosition;
			
			void main() {
				vUv = uv;
				vNormal = normal.xyz;
				vPosition = position.xyz;
				
				gl_Position =   projectionMatrix * modelViewMatrix *vec4(position,1.0);
			}
		</script>
		<script id="vertexWater" type="glsl/x-vertex">
			
			uniform sampler2D tex;
			uniform float delta;
			uniform float waveX;
			varying vec2 vUv;
			varying vec3 vNormal;
			varying vec3 vPosition;
			
			void main() {
				vUv = uv;
				vNormal = normal.xyz;
				vPosition = position.xyz;
				
				if(waveX!=0. && position.y>-5.5 && position.y<5. && position.x>-5. && position.x<5.5)
					gl_Position =   projectionMatrix * modelViewMatrix *(vec4(position,1.0)+(vec4(0.,0.,(waveX*cos(position.x+delta*10.)*sin(position.y)/2.)+waveX,0.)));
				else
					gl_Position =   projectionMatrix * modelViewMatrix *(vec4(position,1.0));
				
			
				
			}
		</script>
		<script id="vertex" type="glsl/x-vertex">
			
			uniform sampler2D tex;
			varying vec2 vUv;
			varying vec3 vNormal;
			varying vec3 vPosition;
			
			void main() {
				vUv = uv;
				vNormal = normal.xyz;
				vPosition = position;
				
				gl_Position =   projectionMatrix * modelViewMatrix *vec4(position,1.0);
			}
		</script>
		
		<script src="lib/three.min.js"></script>
		<script src="lib/stats.min.js"></script>
		<script src="lib/Coordinates.js"></script>
		<script src="lib/OrbitControls.js"></script>
	</head>
	<body>
		
		<script>
		
		var scene, renderer, stats, camera, data, sun;
		var gX 	  = 5, gZ = 5;
		var vista = 5, x  = 0, zoom = 1, rotateA=0;
		var waveX = +vista+2;
		var isRunningAction = false;
		
		var geometry 				= new THREE.BoxGeometry(1,1,1);
		var material 				= new THREE.MeshPhongMaterial( { color: 0xaaaaaa } );
		var texture					= new THREE.ImageUtils.loadTexture("textures/sand.jpg");
		var materialSand 			= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:texture}, delta : {type:"f", value:0.0}, lightPos:{type:"v3", value:new THREE.Vector3(1.0,1.0,1.0)}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentSand").innerHTML});
		var materialBadRock			= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:texture}, delta : {type:"f", value:0.0}, lightPos:{type:"v3", value:new THREE.Vector3(1.0,1.0,1.0)}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentBadRock").innerHTML});
		var materialSnow 			= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:texture}, delta : {type:"f", value:0.0}, lightPos:{type:"v3", value:new THREE.Vector3(1.0,1.0,1.0)}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentSnow").innerHTML});
		var materialWater 			= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:texture}, waveX : {type:"f", value:0.0},lightPos : {type:'v3',value:new THREE.Vector3(1.0,1.0,1.0)}, delta : {type:"f", value:0.0}}, vertexShader:i("vertexWater").innerHTML, fragmentShader:i("fragmentWater").innerHTML, transparent : true});
		var materialGrass 			= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:texture}, texLato : {type:'t',value:THREE.ImageUtils.loadTexture("textures/grassLato.jpg")},LightPosition : {type:'v3',value:new THREE.Vector3()}, delta : {type:"f", value:0.0}, lightPos:{type:"v3", value:new THREE.Vector3(1.0,1.0,1.0)}}, vertexShader:i("vertexGrass").innerHTML, fragmentShader:i("fragmentGrass").innerHTML, transparent : true});
			materialGrass.uniforms.tex.value.wrapS  = THREE.RepeatWrapping;
			materialGrass.uniforms.tex.value.wrapT  = THREE.RepeatWrapping;
		var materialButton			= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/arrow.png")}, alpha: {type:"f", value:0.0}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentButton").innerHTML, transparent:true});
			
		var cube,cropWorld;
		var touchableItem;
		
		var clWS=true, clAD=true;
		
		var raycaster    = new THREE.Raycaster();
		var mousePos     = new THREE.Vector2();
		var mousePressed = false;
		
		
		var command	 = { terrainUp: true, terrainDown:false, terremoto:false, meteorite:false, onda:false};
		
		
		function i(id){
			return document.getElementById(id);
		}
		
		function getHeightData(img,scale) {
  
		 if (scale == undefined) scale=1;
  
		    var canvas = document.createElement( 'canvas' );
		    canvas.width = img.width;
		    canvas.height = img.height;
		    var context = canvas.getContext( '2d' );
 
		    var size = img.width * img.height;
			console.log("World size: "+size);
		    var data = new Float32Array( size );
 
		    context.drawImage(img,0,0);
 
		    for ( var i = 0; i < size; i ++ ) {
		        data[i] = 0
		    }
 
		    var imgd = context.getImageData(0, 0, img.width, img.height);
		    var pix = imgd.data;
 
		    var j=0;
		    for (var i = 0; i<pix.length; i +=4) {
		        var all = pix[i]+pix[i+1]+pix[i+2];  // all is in range 0 - 255*3
		        data[j++] = scale*all/3;   
		    }
			
		    return data;
		}
		
		function initiateButton(){
			var button = [];
			var parteSoto;			
			
			for(var idx=0; idx<18; idx++){
				switch(idx){
					case 4:
						materialButton	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/punto.png")}, alpha: {type:"f", value:0.0}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentButton").innerHTML, transparent:true});
						break;
					case 9:
						materialButton	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/alza.png")}, alpha: {type:"f", value:Math.PI/4}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentButton").innerHTML, transparent:true});
						break;
					case 10:
						materialButton	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/terremoto.png")}, alpha: {type:"f", value:Math.PI/4}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentButton").innerHTML, transparent:true});
						break;
					case 11:
						materialButton	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/bassa.png")}, alpha: {type:"f", value:Math.PI/4}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentButton").innerHTML, transparent:true});
						break;
					case 12:
						materialButton	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/AClock.png")}, alpha: {type:"f", value:Math.PI/4}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentButton").innerHTML, transparent:true});
						break;
					case 13:
						materialButton	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/meterora.png")}, alpha: {type:"f", value:Math.PI/4}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentButton").innerHTML, transparent:true});
						break;
					case 14:
						materialButton	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/piu.png")}, alpha: {type:"f", value:Math.PI/4}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentButton").innerHTML, transparent:true});
						break;
					case 15:
						materialButton	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/Clock.png")}, alpha: {type:"f", value:Math.PI/4}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentButton").innerHTML, transparent:true});
						break;
					case 16:
						materialButton	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/wave.png")}, alpha: {type:"f", value:Math.PI/4}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentButton").innerHTML, transparent:true});
						break;
					case 17:
						materialButton	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/meno.png")}, alpha: {type:"f", value:Math.PI/4}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentButton").innerHTML, transparent:true});
						break;
					default:
						materialButton	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/arrow.png")}, alpha: {type:"f", value:idx*Math.PI/8}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentButton").innerHTML, transparent:true});
				}
				
				button.push(new THREE.Mesh(new THREE.CubeGeometry(1), materialButton));
				
				button[idx].position.set(parseInt(idx/3),0,parseInt(idx%3));
				button[idx].scale.set(1,1,1);
				
				touchableItem.add(button[idx]);
			}
			
			button[0].material.uniforms.alpha.value = 2*Math.PI/8;
			button[1].material.uniforms.alpha.value = 4*Math.PI/8;
			button[2].material.uniforms.alpha.value = 6*Math.PI/8;
			button[3].material.uniforms.alpha.value = 0;
			button[5].material.uniforms.alpha.value = 8*Math.PI/8;
			button[6].material.uniforms.alpha.value = -2*Math.PI/8;
			button[7].material.uniforms.alpha.value = -4*Math.PI/8;
			button[8].material.uniforms.alpha.value = -6*Math.PI/8;
			
			scene.add(touchableItem);
			touchableItem.position.set(-8,2.5,1.5);
		}	
		
		function initiateTerrain(){
			
			
			var img = new Image();
			img.src = "textures/heightmap2.png";
			img.onload = function(){
				//get height data from img
				data = getHeightData(img,0.03);
				updateTerrainVis();
			}
		}
		
		function materiale(posY){
			if(posY==0)
				return new THREE.Mesh(geometry, materialBadRock);
			else if(posY<=3)
				return new THREE.Mesh(geometry, materialSand);
			else if(posY<=5)
				return new THREE.Mesh( geometry, materialGrass );
			else if(posY<=7)
				return new THREE.Mesh( geometry, materialSnow );
			else
				return new THREE.Mesh( geometry, material );
		}
		
		function modifyTerrainHigh(position,value){
			var sqrt = Math.sqrt(data.length);
			if(data[position.x+position.z*sqrt]+value>0)
				if(position.x>=0 && position.x<sqrt &&	
					position.z>=0 && position.z<sqrt){
						data[position.x+position.z*sqrt]+=value;
						updateTerrainVis();
					}
		}
	
		function updateTerrainVis(){
			
			cube = new THREE.Mesh( geometry, material );
			cropWorld = new THREE.Object3D();
			if(data!=null){
				var sqrt = Math.sqrt(data.length);
				var iniX = Math.max(0,gX-vista), iniZ = Math.max(0,gZ-vista);
				var maxX = Math.min(sqrt,gX+vista), maxZ = Math.min(sqrt,gZ+vista);
				
				for(var ix=iniX; ix<maxX; ix++){
					for(var iz=iniZ; iz<maxZ; iz++){
						for(var i2=0; i2<data[ix+iz*sqrt]; i2++){	
								cube = materiale(i2);
								
								cube.position.set((ix-gX+0.5), i2, (iz-gZ+0.5));
								cube.castShadow = true;
								cube.receiveShadow = true;
								cropWorld.add(cube);
							
							
						}
					}
				}
			}
			cropWorld.position.set(-vista-0.5, 0,- vista-0.5);
			cropWorld.rotation.y = rotateA;
			scene.children[1].rotation.z=rotateA;
			scene.children[0]=(cropWorld);
		}
	
		
		function Start() {			
			sun = new THREE.DirectionalLight(0xddddff, 1.5);
			var ambient =  new THREE.DirectionalLight(0xffffaa, 0.5);
			
			scene = new THREE.Scene();
			camera = new THREE.OrthographicCamera(-window.innerWidth/64*zoom, window.innerWidth/64*zoom, window.innerHeight/44*zoom, -window.innerHeight/44*zoom, 0.01, 400);
			
			scene.add(new THREE.Object3D());
			scene.add(new THREE.Object3D());
			
			resetCommand();
			initiateTerrain();
			
			touchableItem = new THREE.Object3D();

			renderer = new THREE.WebGLRenderer( {antialias: true} );
			renderer.setSize( window.innerWidth, window.innerHeight );
			renderer.setClearColor( 0x040404 );
			renderer.shadowMapEnabled = true;																			
			renderer.shadowMap.type   = THREE.PCFSoftShadowMap;
			renderer.physicallyCorrectLights = true;
				
			document.body.appendChild( renderer.domElement );
			
			camera.position.set(-1, 12, -1);
			camera.rotation.set(-1.137, 0.398, 0.666);
						
			stats = new Stats();
			stats.domElement.style.position = 'absolute';
			stats.domElement.style.top = '0px';
			document.body.appendChild( stats.domElement );
			/*
			sun.castShadow = true;
			sun.shadowCameraVisible = true;		
			sun.shadowMapWidth  = 512*2;
			sun.shadowMapHeight = 512*2;
			sun.shadow.radius   = 2;
			
			d = 15;
			sun.shadow.camera.left   = -d;
			sun.shadow.camera.right  = d;
			sun.shadow.camera.top    = d;
			sun.shadow.camera.bottom = -d;			
			*/
			scene.add(sun);
			scene.add(ambient);
			
			
			var sea = new THREE.Mesh(new THREE.PlaneGeometry(vista*2+2,vista*2+2,320,320), materialWater);
			sea.rotation.set(-Math.PI/2, 0, 0);
			sea.position.set(-vista-0.6, 2.4, -vista-0.6);
			scene.children[1]=(sea);
			
			initiateButton();
				
			
			var table = new THREE.Mesh(new THREE.PlaneGeometry(20,20), new THREE.MeshBasicMaterial({map: THREE.ImageUtils.loadTexture("textures/table_alpha.png"),transparent:true}));
			table.rotation.set(-Math.PI/2, 0, 0);
			table.position.set(-5,2.5,-5);
			scene.add(table);
			
			
			onWindowResize();
			
		}
		
		function Update() {
			requestAnimationFrame( Update ); 
			stats.update();
			
			sunUpdate();
			shaderUpdate();
			
			Render();
			x=Date.now()/10000%(2*Math.PI);
		}
		
		function sunUpdate(){
			
			sun.position.set(Math.cos(x)*(vista*20), (Math.sin(x)*(vista*20)), -Math.cos(x)*(vista*20));
			sun.color.r = (Math.abs((Math.sin(x))*0.9)-0.1)%1;
			sun.color.g = (Math.abs((Math.sin(x))*0.9)-0.1)%1;
			sun.color.b = (Math.abs((Math.sin(x))*0.6)-0.1)%1;
			
		}
		
		function shaderUpdate(){
			materialSand.uniforms.delta.value = x;
			materialWater.uniforms.delta.value = x;
			materialGrass.uniforms.delta.value = x;
			materialSnow.uniforms.delta.value = x;
			materialWater.uniforms.delta.value = x;
			
			materialSand.uniforms.lightPos.value = sun.position;
			materialGrass.uniforms.lightPos.value = sun.position;
			materialSnow.uniforms.lightPos.value = sun.position;
			materialWater.uniforms.lightPos.value = sun.position;
		}
		
		function Render() {
			
			renderer.render(scene, camera);
		}
		
		
		function actionFunction(action){
			var offset = new THREE.Vector3(gX+vista, 0, gZ+vista);
			if(command.terrainUp){
				modifyTerrainHigh(new THREE.Vector3(action.position.x, action.position.y, action.position.z), +1);
			}else if(command.terrainDown){
				modifyTerrainHigh(new THREE.Vector3(action.position.x, action.position.y, action.position.z), -1);
			}else if(command.meteorite){
				meteoraAction(action.position);
			}
			
			
		}
		
		function resetAllBTN(){
			
			for(var i=0; i<touchableItem.children.length; i++){
				touchableItem.children[i].position.y=0;
			}
		}
		function resetCommand(){
			command.terrainUp	= false;
			command.terrainDown	= false;
			command.terremoto	= false;
			command.meteorite	= false;
			command.onda		= false;
		}
		
		function terremotoAction(){
			if(!isRunningAction){
				isRunningAction = true;
				
				var scala = Math.random()*10;
				var stato = 0;
				var xT = 0, zT = 0;
				var sqrt = Math.sqrt(data.length);
				
				var intervallo = setInterval(function(){
						if(stato/20>=scala){
							clearInterval(intervallo);
							cropWorld.position.set(0,0,0);
							updateTerrainVis();
							isRunningAction=false;
							resetAllBTN();
							return;
						}else{
							xT = parseInt((Math.random()-0.5)*2*vista);
							zT = parseInt((Math.random()-0.5)*2*vista);
							var valY = parseInt((Math.random()-0.5)*3);
							modifyTerrainHigh(new THREE.Vector3((gX+xT),0,(gZ+zT)),valY);
							cropWorld.position.set((-vista-0.333)+Math.sin(x*1000)/10*scala/3,0,(-vista-0.333)+Math.cos(x*1000)/10*scala/3);
							stato += 0.5;
						}					
					},50);
			}
		}
		function waveAction(){
			if(!isRunningAction){
				isRunningAction = true;
				
				var time=0;
				
				var intervallo = setInterval(function(){
						if(time>10){
							clearInterval(intervallo);
							isRunningAction=false;
							resetAllBTN();
							materialWater.uniforms.waveX.value=0;
							return;
						}else{
							if(time<=2)
								materialWater.uniforms.waveX.value+=0.05;
							if(time>=8)
								materialWater.uniforms.waveX.value-=0.05;
							time+=0.1;
						}		
					},100);
			}
		}
		function meteoraAction(positione){
			if(!isRunningAction){
				isRunningAction = true;
				
				var time=0;
				var meteora = new THREE.Mesh(geometry, material);
				var pos = positione.clone();
				pos.x+=gX-0.5;
				pos.z+=gZ-0.5;
				meteora.position.set(positione.x-vista-0.5,15, positione.z-vista-0.5);
				scene.add(meteora);
				
				var intervallo = setInterval(function(){
						if(meteora.position.y<=pos.y){
							clearInterval(intervallo);
							isRunningAction=false;
							resetAllBTN();
							scene.remove(meteora);
							createCratere(pos,3);
							
							return;
						}else{
							meteora.position.y-=time;
							time+=0.25;
						}		
					},100);
			}
		}
		
		function createCratere(pos, n){
			var sqrt = Math.sqrt(data.length);
			console.log("posizione1: ");
			console.log(pos);
			for(var i2=0; i2<n; i2++){
				for(var i=-n+i2+1; i<n-i2; i++){
					for(var iz=-n+i2+1; iz<n-i2; iz++){
						data[(i+pos.x)+(iz+pos.z)*sqrt]-=1;
					}
				}
			}	
			updateTerrainVis();
		}
		
		function buttonAction(action){
						
			
			
			switch(action.position.x){
				case 0:
					buttonAnimation(action);
					switch(action.position.z){
						case 0:
							directionAction(1);
							break;
						case 1:
							directionAction(0);
							break;
						case 2:
							directionAction(7);
							break;
					}
					break;
				case 1:
					buttonAnimation(action);
					switch(action.position.z){
						case 0:
							directionAction(2);
							break;
						case 2:
							directionAction(6);
							break;
					}
					break;
				case 2:
					buttonAnimation(action);
					switch(action.position.z){
						case 0:
							directionAction(3);
							break;
						case 1:
							directionAction(4);
							break;
						case 2:
							directionAction(5);
							break;
					}
					break;
				case 3:
					if(!isRunningAction){
						resetAllBTN();
						resetCommand();
						switch(action.position.z){
							case 0:
								command.terrainUp = true;
								action.position.y=-0.3;
								break;
							case 1:
								command.terremoto = true;
								action.position.y=-0.3;
								terremotoAction();
								break;
							case 2:
								command.terrainDown = true;
								action.position.y=-0.3;
								break;
						}
						break;	
					}
				case 4:
					
					switch(action.position.z){
						case 0:
							buttonAnimation(action);
							rotateA += Math.PI/2;
							break;
						case 1:
							if(!isRunningAction){
								resetAllBTN();
								resetCommand();
								command.meteorite = true;
								action.position.y=-0.3;
							}
							break;
						case 2:
							buttonAnimation(action);
							zoom+=0.05;
							break;
					}
					break;	
				case 5:
					
					switch(action.position.z){
						case 0:
							buttonAnimation(action);
							rotateA -= Math.PI/2;
							break;
						case 1:
							if(!isRunningAction){
								resetAllBTN();
								resetCommand();
								command.wave = true;
								action.position.y=-0.3;
								waveAction();
							}
							break;
						case 2:
							buttonAnimation(action);
							zoom-=0.05;
							break;
					}
					break;		
			}
			
			
			gX=lim(gX, vista, Math.sqrt(data.length)-vista);
			gZ=lim(gZ, vista, Math.sqrt(data.length)-vista);
			updateTerrainVis();
			onWindowResize();
			
			
		}
	
		function buttonAnimation(btn){
			btn.position.y = -0.2;
			var intervallo = setInterval(function(){
				if(btn.position.y>=0)
				{
					clearInterval(intervallo);
					btn.position.y=0;
				}else 
					btn.position.y+=0.075;
			},100);
		}
		
		function directionAction(dir){
			switch(dir){
				case 0:
					if(rotateA%Math.PI==0)
						gX+=-Math.cos(rotateA);
					else
						gZ+=-Math.sin(rotateA);
					break;
				case 1:
					if(rotateA%Math.PI==0){
						gX+=-Math.cos(rotateA);
						gZ+=-Math.cos(rotateA);
					}else{
						gZ+=-Math.sin(rotateA);
						gX+=Math.sin(rotateA);
					}break;
				case 2:
					if(rotateA%Math.PI==0)
						gZ+=-Math.cos(rotateA);
					else
						gX+=Math.sin(rotateA);
					break;
				case 3:
					if(rotateA%Math.PI==0){
						gZ+=-Math.cos(rotateA);
						gX+=Math.cos(rotateA);
					}else{
						gX+=Math.sin(rotateA);
						gZ+=Math.sin(rotateA);
					}
					break;
				case 4:
					if(rotateA%Math.PI==0)
						
						gX+=Math.cos(rotateA);
					else
						gZ+=Math.sin(rotateA);
					break;
				case 5:
					if(rotateA%Math.PI==0){
						gX+=Math.cos(rotateA);
						gZ+=Math.cos(rotateA);
					}else{
						gZ+=Math.sin(rotateA);
						gX+=-Math.sin(rotateA);
					}
					break;
				case 6:
					if(rotateA%Math.PI==0)
						gZ+=Math.cos(rotateA);
					else
						gX+=-Math.sin(rotateA);
					break;
				case 7:
					if(rotateA%Math.PI==0){
						gZ+=Math.cos(rotateA);
						gX+=-Math.cos(rotateA);
					}else{
						gX+=-Math.sin(rotateA);
						gZ+=-Math.sin(rotateA);
					}
					break;
			}
			gX=lim(gX, vista, Math.sqrt(data.length)-vista);
			gZ=lim(gZ, vista, Math.sqrt(data.length)-vista);
			updateTerrainVis();
			onWindowResize();
			
		}
		
		
		window.addEventListener( 'resize', onWindowResize, false );
		document.addEventListener("keydown", onDocumentKeyDown, false);
		document.addEventListener("keyup", function(e){ 
												if(e.which==83 || e.which==87) clWS=true;
												if(e.which==68 || e.which==65) clAD=true;
											}, false);
		document.addEventListener( 'mousemove', onDocumentMouseMove, false );
		document.addEventListener( 'mousedown', onDocumentMouseDown, false );    
		document.addEventListener( 'mouseup', onDocumentMouseUp, false );

		function onWindowResize(){
			
			
			var aspect =  window.innerWidth / window.innerHeight;
			aspect = (aspect>=1? 1:aspect)*zoom;
			camera.left   = -window.innerWidth/(64*aspect);
			camera.right  =  window.innerWidth/(64*aspect);
			camera.top    =  window.innerHeight/(48*aspect);
			camera.bottom = -window.innerHeight/(48*aspect);
			
			camera.updateProjectionMatrix();

			renderer.setSize( window.innerWidth, window.innerHeight );

		}
		function onDocumentKeyDown(event) {
							
				var keyCode = event.which;
				if (keyCode == 87 && clWS) {
					directionAction(2);
					click=false;
				} else if (keyCode == 83 && clWS) {
					directionAction(6);
					click=false;
				}
				if (keyCode == 65 && clAD) {
					directionAction(0);
					click=false;
				} else if (keyCode == 68 && clAD) {
					directionAction(4);
					click=false;
				} 
				
				if(keyCode == 107 || keyCode == 171){
					zoom += 0.05;
					onWindowResize();
				}else if(keyCode == 109 || keyCode == 173){
					zoom -= 0.05;
					onWindowResize();
				}
				
				
			}		
		function onDocumentMouseDown( event ) { 
			mousePressed=true;
			
			raycaster.setFromCamera( mousePos.clone(), camera );   
			
			var objects = raycaster.intersectObjects(touchableItem.children);
				var o = [];
			if (objects.length>0) {
				for (var i=0; i<objects.length; i++) {
				   	o.push(objects[i].object.uuid);
					
				}
				o = o.length>0 ? o[0] : -1;
			} else {
				objects = raycaster.intersectObjects(cropWorld.children);
				o = [];
				if (objects.length>0) {
					for (var i=0; i<objects.length; i++) {
						o.push(objects[i].object.uuid);
						
					}
					o = o.length>0 ? o[0] : -1;
				} 
				else
					o = o.length>0 ? o[0] : -1;
			} 
			
			
			if(mousePressed){
				for(var i=0; i<cropWorld.children.length; i++) {
							
							if (cropWorld.children[i].uuid===o) {
								actionFunction(cropWorld.children[i].clone());
								mousePressed = false;
							} 
					}
				for(var i=0; i<touchableItem.children.length; i++) {
							
							if (touchableItem.children[i].uuid===o) {
								buttonAction(touchableItem.children[i]);
								mousePressed = false;
							} 
					}
			}
		}
		function onDocumentMouseUp( event ) { mousePressed = false;}
		function onDocumentMouseMove( event ) {
			mousePos.x = ( event.clientX / window.innerWidth ) * 2 - 1;
			mousePos.y = - ( event.clientY / window.innerHeight ) * 2 + 1;
		}

		
		function lim(val, min, max){
			return Math.min(max, Math.max(val, min));
		}
		
		
		Start();
		Update();
			
		</script>
	</body>
</html>