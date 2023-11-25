<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BongoCat Game</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap">
</head>

<body>
<header>
        <div class="titulo">
            ¡Bienvenido al BongoCat Game!
        </div>
    </header>

    <section class="principal">
            <div class="Tiempo">
                    <label for="T">Selecciona el tiempo</label>
                    <select name="Temp" id="Temp">
                        <option value=5>5 SEGUNDOS</option>
                        <option value=10>10 SEGUNDOS</option>
                        <option value=15>15 SEGUNDOS</option>
                        <option value=20>20 SEGUNDOS</option>
                    </select>
            </div>

        <div class="cps">
            <p>¡Haz clic en BongoCat para ganar!</p>
            <p id="cpsText">Clics por Segundo: 0 CPS</p>
        </div>
        </div>

        <div class="puntos">
            <p class="puntucionActual"></p>
            <p class="PuntajesTotales"></p>
        </div>
        </div>
        <div class="imagen" id="imagenDiv">
            <img src="Frames\CLAP.webp" alt="Frame1" id="BongoClap">
        </div>
    </section>

    <?php
$imagenDiv = $_POST['imagenDiv'];
$BongoClap = $_POST['BongoClap'];
$cpsTextElement = $_POST['cpsText'];
$tiempoSelect = $_POST['Temp'];

$isClapImage = true;
$clickCount = 0;
$startTime = null;
$inactivityTimeout = null;
$clickRate = 0;

// Cambia la imagen y actualiza el texto al hacer clic
if (isset($_POST['imagenDiv'])) {
    resetInactivityTimeout();
    $isClapImage = !$isClapImage;
    $clickCount++;
    updateImage();
    updateClickRate();
}

// Función para cambiar la imagen y actualizar el texto
function updateImage() {
    global $BongoClap, $isClapImage;
    $BongoClap = $isClapImage ? 'Frames\\CLAP.webp' : 'Frames\\UP.webp';
}

// Función para actualizar y mostrar la tasa de clics por segundo acumulada
function updateClickRate() {
    global $clickCount, $startTime, $clickRate, $cpsTextElement;
    $currentTime = microtime(true);
    $elapsedTime = ($currentTime - $startTime) / 1000;
    $clickRate = $clickCount / $elapsedTime;

    $cpsTextElement = "Clics por segundo: " . number_format($clickRate, 2);
}

// Función para reiniciar el temporizador de inactividad
function resetInactivityTimeout() {
    global $inactivityTimeout, $startTime, $tiempoSelect;
    $selectedTime = intval($tiempoSelect);

    if (!$startTime) {
        $startTime = microtime(true);
        $inactivityTimeout = setTimeout(function () {
            showPopup();
            resetGame();
        }, $selectedTime * 1000);
    }
}

// Función para mostrar el mensaje emergente
function showPopup() {
    global $selectedTime;
    echo "¡Juego terminado! Se alcanzó el tiempo seleccionado de $selectedTime segundos.";
}

// Función para reiniciar el juego
function resetGame() {
    global $clickCount, $startTime, $clickRate, $cpsTextElement;
    $clickCount = 0;
    $startTime = null;
    $clickRate = 0;
    $cpsTextElement = 'Clics por segundo: 0.00';
}
?>


</body>
</html>
