let timerInterval;
let isPaused = true;
let currentTime = 0;

const button = document.querySelector('#start_pause_button');
button.addEventListener('click', () => {
    if (isPaused) {
        isPaused = false;
        startTimer();
        button.textContent = 'Pausar';
    } else {
        isPaused = true;
        clearInterval(timerInterval);
        button.textContent = 'Iniciar';
    }
});

document.querySelector('#select_pomodoro').addEventListener('click', () => {
    clearInterval(timerInterval);
    isPaused = true;
    currentTime = 25 * 60;
    document.querySelector('.timer_count').textContent = formatTime(currentTime);
});

document.querySelector('#select_descanso').addEventListener('click', () => {
    clearInterval(timerInterval);
    isPaused = true;
    currentTime = 5 * 60;
    document.querySelector('.timer_count').textContent = formatTime(currentTime);
});

function startTimer() {
    timerInterval = setInterval(() => {
        if (currentTime > 0) {
            currentTime--;
            document.querySelector('.timer_count').textContent = formatTime(currentTime);
        } else {
            clearInterval(timerInterval);
            alert('Tempo esgotado!');
        }
    }, 1000);
}

function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const secs = seconds % 60;
    return `${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
}

document.querySelector('#select_pomodoro').click();
