<?php   
    $baseurl=base_url();   
    $public =$baseurl.'public/'; 
?>

<!DOCTYPE html>

<html>

<head>
    <title>Example 08.09 - Load stl model </title>
    <script type="text/javascript" src="<?php echo $public?>js/libs/three.js"></script>
    <script type="text/javascript" src="<?php echo $public?>js/libs/STLLoader.js"></script>
    <script type="text/javascript" src="<?php echo $public?>js/libs/jquery-1.9.0.js"></script>
    <script type="text/javascript" src="<?php echo $public?>js/libs/stats.js"></script>
    <script type="text/javascript" src="<?php echo $public?>js/libs/dat.gui.js"></script>
    <style>
        body {
            /* set margin to 0 and overflow to hidden, to go fullscreen */
            margin: 0;
            overflow: hidden;
        }
    </style>
</head>
<body>

<!-- <div id="Stats-output">
</div> -->
<!-- Div which will hold the Output -->
<div id="WebGL-output">
</div>

<!-- Javascript code that runs our Three.js examples -->
<script type="text/javascript">

    // once everything is loaded, we run our Three.js stuff.
    $(function () {

        var stats = initStats();

        // create a scene, that will hold all our elements such as objects, cameras and lights.
        var scene = new THREE.Scene();

        // create a camera, which defines where we're looking at.
        var camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 1000);

        // create a render and set the size
        var webGLRenderer = new THREE.WebGLRenderer();
        webGLRenderer.setClearColorHex(0x000, 1.0);
        webGLRenderer.setSize(window.innerWidth, window.innerHeight);
        webGLRenderer.shadowMapEnabled = true;

        // position and point the camera to the center of the scene
        camera.position.x = 150;
        camera.position.y = 150;
        camera.position.z = 150;
        camera.lookAt(new THREE.Vector3(0, 40, 0));

        // add spotlight for the shadows
        var spotLight = new THREE.SpotLight(0xffffff);
        spotLight.position.set(150, 150, 150);
        scene.add(spotLight);

        // add the output of the renderer to the html element
        $("#WebGL-output").append(webGLRenderer.domElement);

        // call the render function
        var step = 0;


        // setup the control gui
       /* var controls = new function () {
            // we need the first child, since it's a multimaterial


        }*/

        var group;
        var gui = new dat.GUI();


        // model from http://www.thingiverse.com/thing:69709
        var loader = new THREE.STLLoader();
        var group = new THREE.Object3D();
        loader.load("<?php echo $public?>assets/models/SolidHead.stl", function (geometry) {
            // console.log(geometry);
            var mat = new THREE.MeshLambertMaterial({color: 0x7777ff});
            group = new THREE.Mesh(geometry, mat);
            group.rotation.x = -0.5 * Math.PI;
            group.scale.set(0.6, 0.6, 0.6);
            scene.add(group);
        });


        render();


        function render() {
            stats.update();

            if (group) {
                group.rotation.z += 0.006;
                // group.rotation.x+=0.006;
            }

            // render using requestAnimationFrame
            requestAnimationFrame(render);
            webGLRenderer.render(scene, camera);
        }

        function initStats() {

            var stats = new Stats();
            stats.setMode(0); // 0: fps, 1: ms

            // Align top-left
            stats.domElement.style.position = 'absolute';
            stats.domElement.style.left = '0px';
            stats.domElement.style.top = '0px';

            $("#Stats-output").append(stats.domElement);

            return stats;
        }
    });


</script>
</body>
</html>