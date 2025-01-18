import * as THREE from 'three';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';

const canvas = document.getElementById("statueBandeau");
const scene = new THREE.Scene();
const loader = new GLTFLoader();
let renderer;
let camera;

init();
render();


function init() {
    camera = new THREE.PerspectiveCamera(
      20,
      window.innerWidth / 500,
      1,
      1000
    );
    camera.position.set(0.31, 0.25, 3);


    const loader = new GLTFLoader();
  loader.load(
    "ressources/models/torso-stylax.glb",
    function (gltf) {
        gltf.scene.scale.set(0.028,0.028,0.028);
        gltf.scene.position.set(0,0,0);
        gltf.scene.rotation.x = 90;
      scene.add(gltf.scene);
      render(); //render the scene for the first time
    }
  );

  const light = new THREE.PointLight( 0xf5e9db, 0.1, 100 );
    light.position.set( 0.340, 0.3, 0.7 );
    scene.add( light );

    renderer = new THREE.WebGLRenderer({ antialias: true, canvas: canvas });
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(window.innerWidth, 500);
    renderer.setClearColor (0x00000, 0);
}

function render() {
    renderer.render(scene, camera);
}



