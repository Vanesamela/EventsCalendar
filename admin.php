<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard del Administrador</title>
    <!-- Agrega el enlace al archivo de Bootstrap CSS aquí -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Agrega tus estilos CSS personalizados aquí -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .event-card {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .event-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .event-status {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="top-bar">
            <h1>Eventos por Aprobar</h1>
            <a href="logout.php" class="btn btn-danger">Salir</a>
        </div>

        <?php
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $dbname = "eventscalendar";

        $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        if (!$conn) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        $query = "SELECT * FROM eventos WHERE status = 1";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="event-card">';
            echo '<h3>' . $row['titulo'] . '</h3>';
            echo '<p>' . $row['descripcion'] . '</p>';
            echo '<div class="event-actions">';
            echo '<span class="event-status">Por aprobar</span>';
            echo '<div>';
            echo '<a href="aprobarEvento.php?id=' . $row['id'] . '&action=aprobar" class="btn btn-success">Aprobar</a>';
            echo '<a href="aprobarEvento.php?id=' . $row['id'] . '&action=negar" class="btn btn-danger">Negar</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        mysqli_close($conn);
        ?>
    </div>
    <!-- Agrega los enlaces a Bootstrap JS aquí si es necesario -->
</body>

</html>
