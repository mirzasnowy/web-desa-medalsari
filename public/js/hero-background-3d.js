// public/js/hero-background-3d.js

document.addEventListener('DOMContentLoaded', () => {
    if (typeof THREE === 'undefined') {
        console.error('THREE.js library not loaded. Please ensure it is linked correctly.');
        return;
    }

    const heroSection = document.querySelector('#home');
    const backgroundContainer = document.querySelector('.hero-background-3d');

    if (!heroSection || !backgroundContainer) {
        // console.warn('Hero section or 3D background container not found. Hero 3D animation will not start.');
        return;
    }

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(window.devicePixelRatio);
    backgroundContainer.appendChild(renderer.domElement);

    const primaryGreen = new THREE.Color(0x4CAF50); // From --primary-green
    const accentYellow = new THREE.Color(0xFFC107); // From --accent-yellow

    const particleCount = 700;
    const particles = new THREE.BufferGeometry();
    const positions = new Float32Array(particleCount * 3);
    const colors = new Float32Array(particleCount * 3);

    for (let i = 0; i < particleCount; i++) {
        positions[i * 3] = (Math.random() - 0.5) * 30;
        positions[i * 3 + 1] = (Math.random() - 0.5) * 20;
        positions[i * 3 + 2] = (Math.random() - 0.5) * 20;

        // Alternate colors slightly
        if (Math.random() > 0.5) {
            primaryGreen.toArray(colors, i * 3);
        } else {
            accentYellow.toArray(colors, i * 3);
        }
    }

    particles.setAttribute('position', new THREE.BufferAttribute(positions, 3));
    particles.setAttribute('color', new THREE.BufferAttribute(colors, 3));

    const material = new THREE.PointsMaterial({
        size: 0.15,
        vertexColors: true,
        opacity: 0.8,
        transparent: true,
        depthWrite: false,
        blending: THREE.AdditiveBlending
    });

    const particleSystem = new THREE.Points(particles, material);
    scene.add(particleSystem);

    camera.position.z = 10;

    let mouseX = 0;
    let mouseY = 0;
    document.addEventListener('mousemove', (event) => {
        mouseX = (event.clientX / window.innerWidth) * 2 - 1;
        mouseY = -(event.clientY / window.innerHeight) * 2 + 1;
    });

    function animate() {
        requestAnimationFrame(animate);

        particleSystem.rotation.y += 0.0008;
        particleSystem.rotation.x += 0.0004;

        particleSystem.position.x += (mouseX * 0.005 - particleSystem.position.x) * 0.05;
        particleSystem.position.y += (mouseY * 0.005 - particleSystem.position.y) * 0.05;

        renderer.render(scene, camera);
    }

    animate();

    window.addEventListener('resize', () => {
        const newWidth = window.innerWidth;
        const newHeight = window.innerHeight;
        camera.aspect = newWidth / newHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(newWidth, newHeight);
    });
});