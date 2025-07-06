// public/js/animated-shader-background.js

document.addEventListener('DOMContentLoaded', () => {
    if (typeof THREE === 'undefined') {
        console.error('THREE.js library not loaded. Animated shader background will not start.');
        return;
    }

    const container = document.getElementById('animated-background-middle');
    if (!container) {
        // console.warn('Shader background container not found. Shader animation will not start.');
        return;
    }

    let scene, camera, renderer, material, geometry, mesh;
    let uniforms;

    const init = () => {
        scene = new THREE.Scene();
        camera = new THREE.OrthographicCamera(-1, 1, 1, -1, 0.1, 100);
        camera.position.z = 1;

        renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        renderer.setSize(container.offsetWidth, container.offsetHeight);
        renderer.setPixelRatio(window.devicePixelRatio);
        container.appendChild(renderer.domElement);

        // Define shader uniforms
        uniforms = {
            iTime: { value: 0 },
            iResolution: { value: new THREE.Vector2(container.offsetWidth, container.offsetHeight) },
            iColorA: { value: new THREE.Color(0x4CAF50) }, // Primary Green
            iColorB: { value: new THREE.Color(0xFFC107) }, // Accent Yellow
            iColorC: { value: new THREE.Color(0xA7D7E8) }, // Light Blue
            iColorD: { value: new THREE.Color(0xD2B48C) }, // Light Brown/Tan
            iIsDarkMode: { value: 0 } // 0 for light, 1 for dark
        };

        // Vertex Shader - basic passthrough
        const vertexShader = `
            void main() {
                gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
            }
        `;

        // Fragment Shader - This is where the magic happens!
        // Inspired by various generative art shaders, adapted for our theme
        const fragmentShader = `
            precision highp float;

            uniform float iTime;
            uniform vec2 iResolution;
            uniform vec3 iColorA;
            uniform vec3 iColorB;
            uniform vec3 iColorC;
            uniform vec3 iColorD;
            uniform float iIsDarkMode;

            // Simple hash function for pseudo-random values
            float hash(vec2 p) {
                p = 50.0 * fract(p * 0.3183099 + vec2(0.113, 0.117));
                return fract(p.x * p.y * (p.x + p.y));
            }

            // Perlin noise (simplified)
            float noise(vec2 p) {
                vec2 i = floor(p);
                vec2 f = fract(p);
                f = f * f * (3.0 - 2.0 * f);
                return mix(mix(hash(i + vec2(0.0, 0.0)), hash(i + vec2(1.0, 0.0)), f.x),
                           mix(hash(i + vec2(0.0, 1.0)), hash(i + vec2(1.0, 1.0)), f.x), f.y);
            }

            // Fractal Brownian Motion (FBM) / layering noise
            float fbm(vec2 p) {
                float sum = 0.0;
                float amp = 0.5;
                float freq = 2.0;
                for (int i = 0; i < 4; i++) { // Fewer octaves for smoother look
                    sum += amp * noise(p * freq);
                    amp *= 0.5;
                    freq *= 2.0;
                }
                return sum;
            }

            void main() {
                vec2 uv = gl_FragCoord.xy / iResolution.xy;
                uv.x *= iResolution.x / iResolution.y; // Aspect ratio correction
                uv -= 0.5; // Center the UVs

                float time = iTime * 0.1; // Slower time for gentle movement

                // Create wave-like distortion
                vec2 p = uv * 3.0 + vec2(cos(time * 0.5) * 0.1, sin(time * 0.7) * 0.1); // Subtle shift
                float n1 = fbm(p + time * 0.1);
                float n2 = fbm(p * 2.0 - time * 0.05); // Second layer for complexity

                float mixFactor = (n1 + n2) * 0.5;
                mixFactor = pow(mixFactor, 2.0); // Bias towards lighter values

                // Adjust colors based on dark mode
                vec3 finalColorA = iColorA;
                vec3 finalColorB = iColorB;
                vec3 finalColorC = iColorC;
                vec3 finalColorD = iColorD;

                if (iIsDarkMode > 0.5) { // If dark mode is active
                    finalColorA = mix(iColorA, vec3(0.1, 0.2, 0.15), 0.7); // Darken primary green
                    finalColorB = mix(iColorB, vec3(0.2, 0.15, 0.0), 0.7); // Darken yellow
                    finalColorC = mix(iColorC, vec3(0.05, 0.08, 0.15), 0.7); // Darken light blue
                    finalColorD = mix(iColorD, vec3(0.1, 0.08, 0.05), 0.7); // Darken light brown
                }

                // Smoothly blend multiple colors based on noise patterns
                vec3 color = mix(finalColorA, finalColorB, smoothstep(0.4, 0.6, mixFactor));
                color = mix(color, finalColorC, smoothstep(0.6, 0.8, mixFactor));
                color = mix(color, finalColorD, smoothstep(0.8, 1.0, mixFactor));

                // Add subtle pulsating glow effect
                float glow = sin(time * 5.0 + mixFactor * 10.0) * 0.05 + 0.95;
                color *= glow;


                // Optionally apply a subtle gradient over the entire shader output
                // float vignette = smoothstep(0.7, 0.2, length(uv));
                // color *= vignette;

                gl_FragColor = vec4(color, 1.0); // Full opacity
            }
        `;

        material = new THREE.ShaderMaterial({
            uniforms: uniforms,
            vertexShader: vertexShader,
            fragmentShader: fragmentShader,
            transparent: true // Crucial for overlaying on existing background if needed, but here it replaces.
        });

        geometry = new THREE.PlaneGeometry(2, 2); // A plane that covers the entire screen
        mesh = new THREE.Mesh(geometry, material);
        scene.add(mesh);
    };

    const animate = () => {
        requestAnimationFrame(animate);

        // Update time uniform
        uniforms.iTime.value = performance.now() / 1000;

        // Update colors based on dark mode
        const style = getComputedStyle(document.body);
        const isDarkModeActive = document.body.classList.contains('dark-mode');
        uniforms.iIsDarkMode.value = isDarkModeActive ? 1 : 0;

        // Update colors directly from CSS variables to ensure perfect match
        // Note: This can be expensive if done every frame, but for a few colors it's fine.
        // For more complex shaders, pre-calculate or use uniforms for color palettes.
        // We're already sending a `iIsDarkMode` flag, so the shader can handle the blending.
        // The iColorA, B, C, D are base colors. The shader itself will darken them if iIsDarkMode is 1.

        renderer.render(scene, camera);
    };

    const onResize = () => {
        uniforms.iResolution.value.x = container.offsetWidth;
        uniforms.iResolution.value.y = container.offsetHeight;
        renderer.setSize(container.offsetWidth, container.offsetHeight);
        camera.aspect = container.offsetWidth / container.offsetHeight;
        camera.updateProjectionMatrix();
    };

    init();
    animate();
    window.addEventListener('resize', onResize);
    // Add event listener for dark mode toggle to ensure uniform updates
    document.getElementById('darkModeToggle').addEventListener('change', () => {
        // The `animate` loop already checks `body.classList.contains('dark-mode')`
        // so no explicit uniform update is needed here, just ensure `iIsDarkMode` is updated on next frame.
    });
});