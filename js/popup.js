console.log("Popup JS loaded");

document.addEventListener('DOMContentLoaded', () => {
    const popup = document.getElementById('popup');
    const message = document.getElementById('popup-message');
    const closeBtn = document.getElementById('popup-close');
    const confettiContainer = document.getElementById('confetti-container');

    function showPopup(msg, type) {
        if(!msg) return;
        message.textContent = msg;
        message.parentElement.classList.remove('success','error');
        message.parentElement.classList.add(type);
        popup.classList.add('show');

        if(type === 'success') launchConfetti();
    }

    function hidePopup() {
        popup.classList.remove('show');
        confettiContainer.innerHTML = '';
    }

    closeBtn.addEventListener('click', hidePopup);

    // Show PHP messages safely
    if(errorMessage) showPopup(errorMessage, 'error');
    if(successMessage) showPopup(successMessage, 'success');

    function launchConfetti() {
        for(let i=0; i<50; i++) {
            const confetti = document.createElement('div');
            confetti.classList.add('confetti');
            confetti.style.left = Math.random()*100 + 'vw';
            confetti.style.background = `hsl(${Math.random()*360}, 70%, 60%)`;
            confetti.style.animationDuration = 1 + Math.random()*2 + 's';
            confettiContainer.appendChild(confetti);
        }
    }
});
