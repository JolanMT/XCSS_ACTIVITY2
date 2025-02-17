document.addEventListener('DOMContentLoaded', () => {
    let time = 30;
    const timerElement = document.getElementById('time');
    const hiddenTimeInput = document.getElementById('hidden-time');
    const currentQuestionNumber = parseInt(new URLSearchParams(window.location.search).get('number'), 10) || 1; // Récupérer le numéro de la question actuelle
    const nextQuestionNumber = currentQuestionNumber + 1; // Calculer le numéro de la prochaine question

    // Initialisation du timer
    const countdown = setInterval(() => {
        if (time > 0) {
            time--;
            timerElement.textContent = time;
            hiddenTimeInput.value = time; // Mettre à jour la valeur de l'input caché avec chaque seconde
        } else {
            clearInterval(countdown); // Stop le timer
            // Rediriger vers la prochaine question (si nécessaire)
            window.location.href = `index.php?page=question&number=${nextQuestionNumber}`;
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

    // Assurez-vous que le temps est bien envoyé lors de la soumission du formulaire
    document.getElementById("answer-form").addEventListener("submit", (e) => {
        e.preventDefault(); // Empêche la soumission pour voir l'animation
        // Mettre à jour la valeur du champ caché avant de soumettre
        hiddenTimeInput.value = time;  // Dernière mise à jour du temps avant la soumission
        gsap.to(".question-container", {
            opacity: 0,
            y: -50,
            duration: 1,
            ease: "power3.inOut",
            onComplete: () => {
                e.target.submit(); // Soumettre le formulaire après l'animation
            }
        });
    });
});