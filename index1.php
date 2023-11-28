<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BongoCat Game</title>
    <link rel="stylesheet" href="Styles\style.css">
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

            <div class="TiempoSelected">
                <p class="selectedT"></p>
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
session_start();

// Conexión a la base de datos
$db = new mysqli('localhost', 'root', '123456', 'registro');

if ($db->connect_error) {
    die("Error de conexión: " . $db->connect_error);
}

// Variables
$imagenDiv = isset($_POST['imagenDiv']) ? $_POST['imagenDiv'] : null;
$BongoClap = isset($_POST['BongoClap']) ? $_POST['BongoClap'] : 'Frames\\CLAP.webp';
$cpsTextElement = isset($_POST['cpsText']) ? $_POST['cpsText'] : 'Clics por segundo: 0 CPS';
$tiempoSelect = isset($_POST['Temp']) ? $_POST['Temp'] : 5;
$usuario = $_SESSION['usuario']; // Asegúrate de que el usuario haya iniciado sesión

// Función para cambiar la imagen y actualizar el texto
function updateImage() {
    global $BongoClap;
    $BongoClap = $BongoClap == 'Frames\\CLAP.webp' ? 'Frames\\UP.webp' : 'Frames\\CLAP.webp';
}

// Función para actualizar y mostrar la tasa de clics por segundo acumulada
function updateClickRate() {
    global $clickCount, $startTime, $clickRate, $cpsTextElement;
    $currentTime = microtime(true);
    $elapsedTime = ($currentTime - $startTime) / 1000;
    $clickRate = $clickCount / $elapsedTime;

    $cpsTextElement = "Clics por segundo: " . number_format($clickRate, 2);
}

// Función para guardar la puntuación en la base de datos
function guardarPuntuacion($usuario, $tiempo, $clicks, $cps) {
    global $db;
    $puntuacion = $cps * $clicks; // Calcula la puntuación aquí

    $stmt = $db->prepare("INSERT INTO puntuaciones (usuario, tiempo, clicks, cps, puntuacion) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("siidd", $usuario, $tiempo, $clicks, $cps, $puntuacion);

    if ($stmt->execute()) {
        echo "Puntuación guardada con éxito.";
    } else {
        echo "Error al guardar la puntuación: " . $stmt->error;
    }

    $stmt->close();
}

// Lógica del juego
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    updateImage();
    updateClickRate();

    if ($clickCount >= $tiempoSelect) {
        guardarPuntuacion($usuario, $tiempoSelect, $clickCount, $clickRate);
    }
}
?>
</body>
</html>
