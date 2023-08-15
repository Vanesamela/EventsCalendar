<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard 1</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .dropdown-menu {
            display: none;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            z-index: 1000;
            top: 100%;
            right: 0;
            width: 200px;
        }

        .profile {
            position: relative;
            cursor: pointer;
            text-align: right;
            padding-top: 10px;
            display: inline-block;
            float: right; /* Añadido para alinear a la derecha */
        }

        .profile img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .profile:hover .dropdown-menu {
            display: block;
        }

        .menu-item {
            margin-bottom: 10px;
        }
    </style>
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
                $organizadorId = $filas['id']; // Obtén el ID del organizador
                $organizadorIdEncoded = urlencode($organizadorId); // Codifica el ID para pasarlo en la URL
                if (file_exists($rutaFotoPerfil)) {
                    echo "<div class='row mt-3'>";
                    echo "<div class='col-md-8 offset-md-4'>";
                    echo "<div class='profile'>";
                    echo "<h1>Organizador</h1>";
                    echo "<div class='d-flex align-items-start'>";
                    echo "<img src='$rutaFotoPerfil' alt='Foto de Perfil del Organizador' width='100' height='100'>";
                    echo "<div class='dropdown-menu ml-2'>";
                    echo "<div class='menu-item'>";
                    echo "<a href='cambiarFoto.php?usuario=" . urlencode($usuario) . "'>Cambiar Foto de Perfil</a>";
                    echo "</div>";
                    echo "<div class='menu-item'>";
                    echo "<a href='generarEvento.php?usuario=" . urlencode($usuario) . "&organizadorId=" . $organizadorIdEncoded . "'>Generar Evento</a>";
                    echo "</div>";
                    echo "<div class='menu-item'>";
                    echo "<a href='login.html'>Salir</a>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "<p><strong>Nombre:</strong> " . $filas['nombre'] . "</p>";
                    echo "<p><strong>ID:</strong>" . $filas['id'] . "</p>";
                    echo "</div>";
                    echo "</div>";
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
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const profileImage = document.querySelector(".profile img");
            const dropdownMenu = document.querySelector(".dropdown-menu");

            profileImage.addEventListener("click", function () {
                dropdownMenu.classList.toggle("show");
            });

            window.addEventListener("click", function (event) {
                if (!profileImage.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.remove("show");
                }
            });
        });
    </script>
</body>

</html>
