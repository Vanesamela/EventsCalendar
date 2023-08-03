<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "eventscalendar";


$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    echo ("No hay conexión a la BD " . mysqli_connect_error());
}


$nombre = $_POST["nombre"];
$usuario = $_POST["usuario"];
$cedula = $_POST["cedula"];
$password = $_POST["pass"];
$email = $_POST["email"];
$telefono = $_POST["telefono"];
$id_cargo = 2;
$foto_perfil = "1.png";

$query = "INSERT INTO usuarios (nombre,usuario,cedula,password,email,telefono,foto_perfil,id_cargo)   values('$nombre','$usuario','$cedula','$password','$email','$telefono','$foto_perfil','$id_cargo')";
$ejecutar = mysqli_query($conn, $query);
header("Location: mainOrg.php?usuario=" . urlencode($usuario));  



?>