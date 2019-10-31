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
					gl_FragColor = 1.15*shade_factor*vec4(1.,1.,1.,1.0)*(sin(delta)+0.5);
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
					gl_FragColor = 1.15*shade_factor*vec4(1.0,0.75,0.1,1.0)*(sin(delta)+0.5);
				else
					gl_FragColor = color;
				
			}
			
		</script>
		<script id="fragmentWater"  type="glsl/x-fragment">
			
			uniform float delta;
			uniform vec3 LightPosition;
			
			varying vec2 vUv;

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
				gl_FragColor = vec4(color.rgb*max(0.2,(sin(delta)/2.0)+0.5),color.a);
			}
		</script>
		<script id="fragmentGrass" type="glsl/x-fragment">
			
			uniform sampler2D tex;
			uniform float delta;
			uniform vec3 lightPos;

			varying vec2 vUv;
			varying vec3 vNormal;
			
			vec3 light; 
			
			

			void main() {
				vec2 uVu = vUv+vec2(pow(2.72,sin(delta*50.5)/8.0)/15.5*sin(delta*10.0), pow(2.72,sin(delta*10.5)/8.0)/15.5);
				
				light =   vec3(0.2, 0.9, 0.05);
				
				vec4 color = texture2D(tex, uVu);
				float shade_factor = 0.25 + 1.3 * max(0.0, dot(vNormal, normalize(lightPos)/1.75));
				color = color*shade_factor*max(min((sin(delta)/1.15),0.4), 0.85);
				
				gl_FragColor = vec4(color.xyz*light,1.0);
				
			}
			
		</script>
		
		<script id="vertex" type="glsl/x-vertex">
			uniform sampler2D tex;
			varying vec2 vUv;
			varying vec3 vNormal;
			
			void main() {
				vUv = uv;
				vNormal = normal.xyz;
				
				
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
		var gX = 5, gZ = 5;
		var vista = 5, x = 0;
		
		var geometry 		= new THREE.BoxGeometry(1,1,1);
		var material 		= new THREE.MeshPhongMaterial( { color: 0xaaaaaa } );
		var materialSand 	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/sand.jpg")}, delta : {type:"f", value:0.0}, lightPos:{type:"v3", value:new THREE.Vector3(1.0,1.0,1.0)}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentSand").innerHTML});
		var materialSnow 	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/sand.jpg")}, delta : {type:"f", value:0.0}, lightPos:{type:"v3", value:new THREE.Vector3(1.0,1.0,1.0)}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentSnow").innerHTML});
		var materialWater 	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/sand.jpg")},LightPosition : {type:'v3',value:new THREE.Vector3()}, delta : {type:"f", value:0.0}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentWater").innerHTML, transparent : true});
		var materialGrass 	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/sand.jpg")},LightPosition : {type:'v3',value:new THREE.Vector3()}, delta : {type:"f", value:0.0}, lightPos:{type:"v3", value:new THREE.Vector3(1.0,1.0,1.0)}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentGrass").innerHTML, transparent : true});
			materialGrass.uniforms.tex.value.wrapS  = THREE.RepeatWrapping;
			materialGrass.uniforms.tex.value.wrapT  = THREE.RepeatWrapping;
			
		var cube,cropWorld;
		
		var clWS=true, clAD=true;
		
		
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
			console.log(size);
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
			if(posY<=3)
				return new THREE.Mesh(geometry, materialSand);
			else if(posY<=5)
				return new THREE.Mesh( geometry, materialGrass );
			else if(posY<=7)
				return new THREE.Mesh( geometry, materialSnow );
			else
				return new THREE.Mesh( geometry, material );
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
							if(ix-1>iniX && ix+1<maxX && iz-1>iniZ && iz+1<maxZ){
								if(data[ix+iz*sqrt]+1>data[(ix+1)+iz*sqrt] && data[ix+iz*sqrt]+1>data[(ix-1)+iz*sqrt] && data[ix+iz*sqrt]+1>data[(ix)+(iz+1)*sqrt] && data[ix+iz*sqrt]+1>data[(ix)+(iz-1)*sqrt])
								{
									cube = materiale(i2);
									cube.position.set(ix-gX-vista, i2, iz-gZ-vista);
									cube.castShadow = true;
									cube.receiveShadow = true;
									cropWorld.add(cube);
								}
							}else{
								cube = materiale(i2);
								
								cube.position.set(ix-gX-vista, i2, iz-gZ-vista);
								cube.castShadow = true;
								cube.receiveShadow = true;
								cropWorld.add(cube);
							}
							
						}
					}
				}
			}
			scene.children[0]=(cropWorld);
		}
	
		
		function Start() {
			sun = new THREE.DirectionalLight(0xddddff, 1.5);
			var ambient =  new THREE.DirectionalLight(0xffffaa, 0.5);
			
			scene = new THREE.Scene();
			camera = new THREE.OrthographicCamera(-window.innerWidth/64, window.innerWidth/64, window.innerHeight/44, -window.innerHeight/44, 1, 100);
			
			scene.add(new THREE.Object3D());
			initiateTerrain();
			
			

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
			
			
			var sea = new THREE.Mesh(new THREE.PlaneGeometry(vista*2+2,vista*2+2), materialWater);
			sea.rotation.set(-Math.PI/2, 0, 0);
			sea.position.set(-vista-0.6, 2, -vista-0.6);
			scene.add(sea);
			
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
			
			materialSand.uniforms.lightPos.value = sun.position;
			materialGrass.uniforms.lightPos.value = sun.position;
			materialSnow.uniforms.lightPos.value = sun.position;
		}
		
		function Render() {
			
			renderer.render(scene, camera);
		}
		
		
		
		window.addEventListener( 'resize', onWindowResize, false );
		document.addEventListener("keydown", onDocumentKeyDown, false);
		document.addEventListener("keyup", function(e){ 
												if(e.which==83 || e.which==87) clWS=true;
												if(e.which==68 || e.which==65) clAD=true;
											}, false);

		function onWindowResize(){
			
			
			var aspect =  window.innerWidth / window.innerHeight;
			aspect = (aspect>=1? 1:aspect);
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
					gZ--;
					click=false;
				} else if (keyCode == 83 && clWS) {
					gZ++;
					click=false;
				}
				if (keyCode == 65 && clAD) {
					gX--;
					click=false;
				} else if (keyCode == 68 && clAD) {
					gX++;
					click=false;
				} 
				gX=lim(gX, vista, Math.sqrt(data.length)-vista);
				gZ=lim(gZ, vista, Math.sqrt(data.length)-vista);
				updateTerrainVis();
			}		
		
		function lim(val, min, max){
			return Math.min(max, Math.max(val, min));
		}
		
		
		Start();
		Update();
			
		</script>
	</body>
</html>