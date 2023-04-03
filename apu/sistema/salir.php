<?php
    session_start();
    require_once "../conexion.php";

    $usuario = $_SESSION['usuario'];
    $sql = mysqli_query($conn, "INSERT INTO no_repudio(usuario, accion) VALUES('$usuario', 'Salir del sistema')");

    mysqli_close($conn);

    session_destroy();

    header('location: ../');
?>