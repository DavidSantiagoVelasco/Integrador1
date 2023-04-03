<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
} elseif ($_SESSION['rol'] != 'A' && $_SESSION['rol'] != 'S') {
    header('location: index.php');
} else {
    require_once "../conexion.php";
    $consulta = "SELECT * FROM contacto ORDER BY id ASC";
    $query = mysqli_query($conn, $consulta);
    $usuario = $_SESSION['usuario'];
    mysqli_query($conn, "INSERT INTO no_repudio (usuario, accion) VALUES ('$usuario', 'Ver mensajes contacto')");

    mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style_lista.css">
    <?php include "includes/scripst.php" ?>
    <title>APU</title>
</head>

<body>
    <?php include "includes/header.php" ?>
    <section id="container">
        <h1>Mensajes contacto</h1>
        <table class="tabla">
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Tema</th>
                <th>Mensaje</th>
            </tr>
            <?php
            foreach ($query as $row) { ?>
                <tr>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['tema']; ?></td>
                    <td><?php echo $row['mensaje']; ?></td>
                </tr>
            <?php
            }
            ?>

        </table>
    </section>
</body>

</html>