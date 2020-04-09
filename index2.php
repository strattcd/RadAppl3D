<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="assets/stylesheets/main.css">
</head>
<?php 
	if (isset($_POST['posX']))
	{
        $posArray['X'] = $_POST['posX'];
        $posArray['Y'] = $_POST['posY'];
        $posArray['Z'] = $_POST['posZ'];
    }
    else{
        $posArray['X'] = 0;
        $posArray['Y'] = 0;
        $posArray['Z'] = 1;
    }

?>
<body>
    <form id="position" method="post" action="index.php">
				X <input type="text" name="posX" />
                Y <input type="text" name="posY" />
                Z <input type="text" name="posZ" />
				<input type="submit" value="Post" />	
    </form>
    <div id="text"></div>
    <div id="container"></div>
    <script src="../js/three.js"></script>
    <script>

        function setCubePosition(elementId, x, y, z){

            console.clear();

            var renderer, scene, camera, distance, raycaster, projector;
            var container = document.getElementById(elementId);
            var distance = 400;   

            init(x,y,z);
            animate();
            print("cube");                     

        }

        function init(x,y,z){
            renderer = new THREE.WebGLRenderer();
            renderer.setSize( 500, 250 );
            renderer.setClearColor(0x888888, 1);
            container.appendChild( renderer.domElement );

            scene = new THREE.Scene();
            camera = new THREE.PerspectiveCamera( 75, 2, 0.1, 1000 );
            camera.position.z = 5;

            //LIGHTNING
            //first point light
            light = new THREE.PointLight(0xffffff, 1, 4000);
            light.position.set(50, 0, 0);
            //the second one
            light_two = new THREE.PointLight(0xffffff, 1, 4000);
            light_two.position.set(-100, 800, 800);
            //And another global lightning some sort of cripple GL
            lightAmbient = new THREE.AmbientLight(0x404040);
            scene.add(light, light_two, lightAmbient);            
            

            createCube(x,y,z); 
            renderer.render(scene, camera);
        }

        function createCube(x, y, z){
            var geometry = new THREE.BoxGeometry();
            var material = new THREE.MeshPhongMaterial( { color: 0x00ff00 } );
            var cube = new THREE.Mesh( geometry, material );
            cube.name = "cube";
            cube.position.x = x;
            cube.position.y = y;
            cube.position.z = z;
            scene.add( cube );
        }  

        function animate() {
            requestAnimationFrame( animate );
            cube = scene.getObjectByName( "cube" );
            cube.rotation.x += 0.01;
            cube.rotation.y += 0.01;           
            renderer.render( scene, camera );
        }

        function print(name){
            cube = scene.getObjectByName( name );
            var x =  cube.position.x;
            var y =  cube.position.y;
            var z =  cube.position.z;
            document.getElementById("text").innerHTML = x + " " + y + " " + z;            
        }

    </script>
    <script>
        function setPosition(elementId, x, y, z){
            document.getElementById(elementId).posX.value = x;
            document.getElementById(elementId).posY.value = y;
            document.getElementById(elementId).posZ.value = z;
        }
        setPosition("position", '<?php echo $posArray['X'] ?>', '<?php echo $posArray['Y'] ?>', '<?php echo $posArray['Z'] ?>');
        setCubePosition("container", '<?php echo $posArray['X'] ?>', '<?php echo $posArray['Y'] ?>', '<?php echo $posArray['Z'] ?>');
    </script>    
</body>
</html>