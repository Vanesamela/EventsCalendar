<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title> Dashboard 1</title>
</head>

<body>
    <div class="container">
        <?php
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $dbname = "eventscalendar";

        $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        if (!$conn) {
            echo ("<p class='error'>No hay conexión a la BD " . mysqli_connect_error() . "</p>");
        }

        if (isset($_GET["usuario"])) {
            $usuario = $_GET["usuario"];

            $query = "SELECT * FROM usuarios WHERE usuario='$usuario'";
            $ejecutar = mysqli_query($conn, $query);
            $filas = mysqli_fetch_array($ejecutar);

            if ($filas && $filas['id_cargo'] == 2) {
                $rutaFotoPerfil = "img/" . $filas['foto_perfil'];
                if (file_exists($rutaFotoPerfil)) {
                    echo "<div class='profile'>";
                    echo "<h1>Organizador</h1>";
                    echo "<a href='cambiarFoto.php?usuario=" . urlencode($usuario) . "'>";
                    echo "<img src='$rutaFotoPerfil' alt='Foto de Perfil del Organizador' width='100' height='100'>";
                    echo "</a>";
                    echo "<p><strong>Nombre:</strong> " . $filas['nombre'] . "</p>";
                    // Puedes agregar más información sobre el organizador aquí
                    echo "</div>";
                } else {
                    echo "<p class='error'>Foto de perfil no encontrada</p>";
                }
            } else {
                echo "<p class='error'>Acceso no autorizado</p>";
            }
        } else {
            echo "<p class='error'>Usuario no especificado</p>";
        }

        mysqli_close($conn);
        ?>
        <div class="back-btn">
            <a href="login.html">Volver al inicio de sesión</a>
        </div>
    </div>
</body>

</html>
