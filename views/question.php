<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question</title>
    <link rel="stylesheet" href="./public/css/style.css">

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/gsap.min.js"></script>
    <script src="./public/js/script.js" defer></script>
    <!-- <script type="module" src="./public/js/glitch.js"></script> -->
</head>

<body>
<?php
echo '
  <nav class="navbar">
  <div class="nav-container">
      <a href="index.php?page=home" class="nav-logo">SCSS Quiz</a>
      <div class="nav-links">';

if (isset($username) && !empty($username)) {
    echo "<div class='user-info'>";
    
    if (isset($profilePicturePath) && !empty($profilePicturePath)) {
        echo "<img src='$profilePicturePath' alt='Profile Picture' class='profile-picture'>";
    } else {
        echo "<img src='public/images/default-profile.png' alt='Default Profile Picture' class='profile-picture'>";
    }

    echo "<span class='welcome-message'>Bonjour, <strong>$username</strong></span>";
    echo '<a href="handlers/logout_handler.php" class="btn-logout">Déconnexion</a>';
    echo '</div>';
} else {
    echo '<a href="index.php?page=login" class="btn-login">Se connecter</a>
    <a href="index.php?page=register" class="btn-register">S\'inscrire</a>';
}

echo '      </div>
  </div>
</nav>
';
?>
    <script type="module">
        import * as THREE from 'https://cdn.skypack.dev/three@0.136.0/build/three.module.js';
        import {
            OrbitControls
        } from 'https://cdn.skypack.dev/three@0.136.0/examples/jsm/controls/OrbitControls.js';
        import {
            RenderPass
        } from 'https://cdn.skypack.dev/three@0.136.0/examples/jsm/postprocessing/RenderPass.js';
        import {
            EffectComposer
        } from 'https://cdn.skypack.dev/three@0.136.0/examples/jsm/postprocessing/EffectComposer.js';
        import {
            GlitchPass
        } from 'https://cdn.skypack.dev/three@0.136.0/examples/jsm/postprocessing/GlitchPass.js';
        import {
            UnrealBloomPass
        } from 'https://cdn.skypack.dev/three@0.136.0/examples/jsm/postprocessing/UnrealBloomPass.js';

        // Initialisation de la scène
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({
            alpha: true
        });
        renderer.setSize(window.innerWidth, window.innerHeight);
        document.body.appendChild(renderer.domElement);

        const controls = new OrbitControls(camera, renderer.domElement);
        controls.enableDamping = true;

        // Ajout d'un objet
        const geometry = new THREE.BoxGeometry(6, 6, 6);
        const material = new THREE.MeshBasicMaterial({
            color: 0x000000,
            wireframe: true
        });
        const mesh = new THREE.Mesh(geometry, material);
        scene.add(mesh);

        camera.position.z = 10;

        // Configuration des passes d'effet
        const composer = new EffectComposer(renderer);
        const renderPass = new RenderPass(scene, camera);
        composer.addPass(renderPass);

        const glitchPass = new GlitchPass();
        glitchPass.enabled = false; // Désactivé par défaut
        composer.addPass(glitchPass);

        const bloomPass = new UnrealBloomPass(new THREE.Vector2(window.innerWidth, window.innerHeight), 1.5, 0.4, 0.85);
        composer.addPass(bloomPass);

        // Compte à rebours
        let time = 30; // Temps initial
        const timerElement = document.getElementById('time');

        const countdown = setInterval(() => {
            time--;
            timerElement.textContent = time;

            // Activer le glitch si le temps est inférieur à 2 secondes
            if (time < 2) {
                glitchPass.enabled = true;
            } else {
                glitchPass.enabled = false;
            }

            // Redirection ou fin du compte à rebours
            if (time <= 0) {
                clearInterval(countdown);
                window.location.href = 'index.php?page=question&number=2'; // Exemple de redirection
            }
        }, 1000);

        // Animation
        function animate() {
            requestAnimationFrame(animate);
            mesh.rotation.x += 0.01;
            mesh.rotation.y += 0.01;
            controls.update();
            composer.render();
        }

        animate();

        // Gestion du redimensionnement
        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
            composer.setSize(window.innerWidth, window.innerHeight);
        });
    </script>

    <?php
    $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/';
    ?>
    <div class="question-container">
        <h2 class="question-title"><?= htmlspecialchars($question->text); ?></h2>
        <?php if ($question->options): ?>
            <form id="answer-form" action="<?= $base_url; ?>index.php?page=submitAnswer&number=<?= $_GET['number']; ?>" method="post" autocomplete="off">
                <ul class="options-list">
                    <?php foreach ($question->options as $index => $option): ?>
                        <li>
                            <input type="radio" name="userAnswer" value="<?= $index; ?>" id="option-<?= $index; ?>" required>
                            <label for="option-<?= $index; ?>"><?= htmlspecialchars($option); ?></label>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <button type="submit" class="submit-button">Submit</button>
            </form>
        <?php else: ?>
            <form id="answer-form" action="<?= $base_url; ?>index.php?page=submitAnswer&number=<?= $_GET['number']; ?>" method="post" autocomplete="off">
                <input type="text" name="userAnswer" required onpaste="return false;" autocomplete="off">
                <input type="hidden" id="hidden-time" name="timeElapsed" value="0">
                <button type="submit" class="submit-button">Submit</button>
            </form>
        <?php endif; ?>
        <div id="timer">Time remaining: <span id="time">30</span> seconds</div>
    </div>
</body>

</html>