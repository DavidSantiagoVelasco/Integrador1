<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
} elseif ($_SESSION['rol'] != 'A') {
    header('location: index.php');
} else {
    require_once "../conexion.php";
    $consulta = "SELECT usuario, nombre, apellido, identificacion, rol, estado FROM usuarios ORDER BY rol ASC";

    $query = mysqli_query($conn, $consulta);

    $usuario = $_SESSION['usuario'];

    mysqli_query($conn, "INSERT INTO no_repudio (usuario, accion) VALUES ('$usuario', 'Ver lista usuarios')");

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
        <h1>Lista de usuarios</h1>
        <form action="buscar_usuario.php" method="get" class="form_search">
            <input type="text" name="busqueda" id="busqueda" placeholder="buscar">
            <input type="submit" value="Buscar" class="btn_search">
        </form>
        <table class="tabla">
            <tr>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Identificacion</th>
                <th>Rol</th>
                <th>Estado</th>
            </tr>
            <?php
            foreach ($query as $row) { ?>
                <tr>
                    <td><?php echo $row['usuario']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['apellido']; ?></td>
                    <td><?php echo $row['identificacion']; ?></td>
                    <td><?php
                        if ($row['rol'] == 'A') {
                            echo 'Administrador';
                        } else if ($row['rol'] == 'S') {
                            echo 'Secretario';
                        } else if ($row['rol'] == 'B') {
                            echo 'Personal Bodega';
                        } else {
                            echo 'Usuario externo';
                        }; ?></td>
                    <td><?php if ($row['estado'] == 'A') {
                            echo 'Activo';
                        } else {
                            echo 'Inactivo';
                        }; ?></td>
                </tr>


            <?php
            }
            ?>

        </table>
    </section>
</body>

</html>