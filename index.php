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
		<script id="fragmentSand" type="x-shader/x-fragment">
			
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
				

				st *= 40.0; // Scale the coordinate system by 10
				vec2 ipos = floor(st);  // get the integer coords
				vec2 fpos = fract(st);  // get the fractional coords
				vec4 rand = vec4(random( ipos ));
				vec4 randV= vec4(random(floor( gl_FragCoord.xy*0.8+vec2(delta))));
				
				float shade_factor = 0.19 + 1.3 * max(0.0, dot(vNormal, normalize(lightPos)));
				
				color = color*shade_factor;
				
				
				if(randV.x>0.95 && rand.x>0.9)
					gl_FragColor = vec4(1.0,1.0,0.9,1.0);
				else
					gl_FragColor = color;
				
			}
			
		</script>
		<script id="vertexSand" type="x-shader/x-vertex">
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
		var materialSand 	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/sand.jpg")}, delta : {type:"f", value:0.0}, lightPos:{type:"v3", value:new THREE.Vector3(1.0,1.0,1.0)}}, vertexShader:i("vertexSand").innerHTML, fragmentShader:i("fragmentSand").innerHTML});
		//var materialGrass 	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/grass.jpg")}, delta : {type:"f", value:0.0}, lightPos:{type:"v3", value:new THREE.Vector3(1.0,1.0,1.0)}}, vertexShader:i("vertexGrass").innerHTML, fragmentShader:i("fragmentGrass").innerHTML});
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
				data = getHeightData(img,0.02);
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
							if(ix-1>iniX && ix+1<maxX && iz-1>iniZ && iz+1<maxZ){
								if(data[ix+iz*sqrt]+1>data[(ix+1)+iz*sqrt] && data[ix+iz*sqrt]+1>data[(ix-1)+iz*sqrt] && data[ix+iz*sqrt]+1>data[(ix)+(iz+1)*sqrt] && data[ix+iz*sqrt]+1>data[(ix)+(iz-1)*sqrt])
								{
									if(data[ix+iz*sqrt]<=3)
										cube = new THREE.Mesh(geometry, materialSand);
									else
										cube = new THREE.Mesh( geometry, material );
									cube.position.set(ix-gX-vista, i2, iz-gZ-vista);
									cube.castShadow = true;
									cube.receiveShadow = true;
									cropWorld.add(cube);
								}
							}else{
								if(data[ix+iz*sqrt]<=3)
									cube = new THREE.Mesh(geometry, materialSand);
								else
									cube = new THREE.Mesh( geometry, material );
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
			renderer.setClearColor( 0xf0f0f0 );
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
			
			
			var sea = new THREE.Mesh(new THREE.PlaneGeometry(vista*2+2,vista*2+2), new THREE.MeshBasicMaterial({color: 0x9999ff}));
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
			x=Date.now()/10000%Math.PI;
		}
		
		function sunUpdate(){
			
			sun.position.set(Math.cos(x)*(vista*20), Math.abs(Math.sin(x)*(vista*20)), -Math.cos(x)*(vista*20));
			sun.color.r = (Math.abs((Math.sin(x))*0.9))%1;
			sun.color.g = (Math.abs((Math.sin(x))*0.9))%1;
			sun.color.b = (Math.abs((Math.sin(x))*0.6))%1;
			
		}
		
		function shaderUpdate(){
			materialSand.uniforms.delta.value = Math.sin(x*25);
			materialSand.uniforms.lightPos.value = sun.position;
		}
		
		function Render() {
			
			renderer.render(scene, camera);
		}
		
		
		
		window.addEventListener( 'resize', onWindowResize, false );

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
		

		document.addEventListener("keydown", onDocumentKeyDown, false);
		document.addEventListener("keyup", function(e){ 
												if(e.which==83 || e.which==87) clWS=true;
												if(e.which==68 || e.which==65) clAD=true;
											}, false);
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