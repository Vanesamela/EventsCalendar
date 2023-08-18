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
            float: right;
            /* Añadido para alinear a la derecha */
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

        .container {
            margin-top: 20px;
        }

        .evento-card {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }

        .evento-thumbnail {
            max-width: 239px;
            max-height: 135px;
            object-fit: cover;
        }

        .eventos-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-top: 20px;
            /* Añadido para espacio entre botón y eventos */
        }
    </style>
</head>

<body>
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
                $organizadorId = $filas['id'];
                $organizadorIdEncoded = urlencode($organizadorId);

                // Mostrar perfil del organizador
                if (file_exists($rutaFotoPerfil)) {
                    echo "<div class='row mt-3'>";
                    echo "<div class='col-md-8 offset-md-4'>";
                    echo "<div class='profile'>";
                    echo "<h1>Organizador</h1>";
                    echo "<div class='d-flex align-items-start'>";
                    echo "<img src='$rutaFotoPerfil' alt='Foto de Perfil del Organizador' width='100' height='100'>";
                    echo "<div class='dropdown-menu ml-2'>";
                    echo "<div class='menu-item'>";
                    echo "<a href='editarPer.php?usuario=" . urlencode($usuario) . "'>Editar Perfil</a>";
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

                // Mostrar eventos aprobados
                echo "<div class='eventos-row'>";

                // Selector de orden
                echo "<div>";
                echo "<label for='orden'>Ordenar por:</label>";
                echo "<select id='orden' onchange='cambiarOrden();'>";
                echo "<option value='titulo' " . ($_GET['orden'] === 'titulo' ? 'selected' : '') . ">Título</option>";
                echo "<option value='fecha' " . ($_GET['orden'] === 'fecha' ? 'selected' : '') . ">Fecha</option>";
                echo "</select>";
                echo "</div>";

                $queryEventos = "SELECT * FROM eventos WHERE status = 2";

                $orden = "titulo"; // Orden por defecto (título)
                if (isset($_GET['orden'])) {
                    if ($_GET['orden'] === 'fecha') {
                        $orden = "fecha";
                    }
                }

                $queryEventos .= " ORDER BY " . $orden;
                $resultEventos = mysqli_query($conn, $queryEventos);

                while ($evento = mysqli_fetch_assoc($resultEventos)) {
                    echo '<div class="evento-card">';
                    echo '<h2>' . $evento['titulo'] . '</h2>';
                    echo '<img src="' . $evento['imagen1'] . '" alt="Imagen 1" class="evento-thumbnail">';
                    echo '<p><strong>Fecha:</strong> ' . $evento['fecha'] . '</p>';
                    echo '<p><strong>Lugar:</strong> ' . $evento['lugar'] . '</p>';
                    echo '<a href="javascript:void(0);" onclick="verDetalles(' . $evento['id_eve'] . ');">Ver más</a>'; // Cambio en el enlace
                    echo '</div>';
                }
                echo "</div>"; // Fin de eventos-row
            } else {
                echo "<p class='error'>Acceso no autorizado</p>";
            }
        } else {
            echo "<p class='error'>Usuario no especificado</p>";
        }

        mysqli_close($conn);
        ?>
    </div>
    <script>
        function cambiarOrden() {
            var select = document.getElementById("orden");
            var ordenSeleccionado = select.options[select.selectedIndex].value;
            var url = window.location.href.split("?")[0];
            var usuario = "<?php echo urlencode($usuario); ?>"; // Obtener el valor del usuario desde PHP
            window.location.href = url + "?usuario=" + usuario + "&orden=" + ordenSeleccionado;
        }

        function verDetalles(eventoId) {
            // Abre una nueva ventana o pestaña con el archivo verEvento.php y el ID del evento
            window.open('verEvento.php?id=' + eventoId, '_blank');
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
</body>

</html>