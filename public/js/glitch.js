// script.js
document.addEventListener('DOMContentLoaded', () => {
    let time = 30;
    const timerElement = document.getElementById('time');
    const glitchOverlay = document.querySelector('.glitch-overlay');

    const countdown = setInterval(() => {
        time--;
        timerElement.textContent = time;

        // Activer l'effet glitch quand il reste <= 5 secondes
        if (time <= 5) {
            glitchOverlay.style.opacity = '1';
        }

        // Redirection ou fin du compte à rebours
        if (time <= 0) {
            clearInterval(countdown);
            glitchOverlay.style.opacity = '0'; // Désactiver le glitch
            window.location.href = 'index.php?page=question&number=2'; // Exemple de redirection
        }
    }, 1000);
});
