const imagenDiv = document.getElementById('imagenDiv');
const BongoClap = document.getElementById('BongoClap');
const tiempoText = document.getElementById('tiempoText');
const cpsText = document.getElementById('cpsText');
const puntucionActual = document.querySelector('.puntucionActual');
const puntajesTotales = document.querySelector('.PuntajesTotales');

let isClapImage = true;
let LeaderBoard = 0;
let ClicksPerSecond = 0;
let intervalId;
let currentScore = 0;
let totalScores = [];
let lastClickTime = Date.now();

// Cambia la imagen al hacer clic
imagenDiv.addEventListener('click', () => {
    toggleImage();
    updateImageText();
});

// Inicia el contador principal al hacer clic en la imagen
imagenDiv.addEventListener('click', () => {
    incrementCounter();
    startCounter();
});

// Función para cambiar la imagen y actualizar el texto
function toggleImage() {
    isClapImage = !isClapImage;
    BongoClap.src = isClapImage ? 'Frames\\CLAP.webp' : 'Frames\\UP.webp';
    BongoClap.alt = isClapImage ? 'CLAP' : 'UP';
}

// Función para actualizar el texto asociado a la imagen
function updateImageText() {
    const imageText = isClapImage ? '¡Haz CLIC en BongoCat!' : '¡Haz CLIC en UP!';
    console.log(imageText);
}

// Incrementa el contador principal y actualiza la puntuación actual
function incrementCounter() {
    LeaderBoard++;
    currentScore = LeaderBoard;
    puntucionActual.textContent = `Puntuación Actual: ${currentScore}`;
    lastClickTime = Date.now(); // Actualiza el tiempo del último clic
}

// Inicia el contador de clics por segundo y actualiza puntajes totales
function startCounter() {
    if (!intervalId) {
        intervalId = setInterval(function () {
            const currentTime = Date.now();
            const timeSinceLastClick = currentTime - lastClickTime;

            if (timeSinceLastClick >= 3000) {
                clearInterval(intervalId);
                updateTotalScores(); // Mueve la llamada a updateTotalScores aquí
            } else {
                ClicksPerSecond = LeaderBoard;
                tiempoText.textContent = `Segundos Transcurridos: ${ClicksPerSecond}s`;
                cpsText.textContent = `Clics por Segundo: ${ClicksPerSecond} CPS`;
                LeaderBoard = 0;
            }
        }, 1000);
    }
}

// Actualiza las puntuaciones totales
function updateTotalScores() {
    totalScores.push(currentScore);
    puntajesTotales.textContent = `Puntuaciones Totales: ${totalScores.join(', ')}`;
    currentScore = 0; // Reinicia el puntaje actual después de guardar
    puntucionActual.textContent = `Puntuación Actual: ${currentScore}`;
}
