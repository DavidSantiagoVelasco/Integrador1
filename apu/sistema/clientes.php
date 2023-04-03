<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
} elseif ($_SESSION['rol'] != 'A' && $_SESSION['rol'] != 'S' && $_SESSION['rol'] != 'E') {
    header('location: index.php');
} else {
    require_once "../conexion.php";
    $consulta = "SELECT * FROM clientes ORDER BY id ASC";
    $query = mysqli_query($conn, $consulta);
    $usuario = $_SESSION['usuario'];
    mysqli_query($conn, "INSERT INTO no_repudio (usuario, accion) VALUES ('$usuario', 'Ver lista clientes')");

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
        <h1>Lista clientes</h1>
        <form action="buscar_cliente.php" method="get" class="form_search">
            <?php
            if ($_SESSION['rol'] == 'A' || $_SESSION['rol'] == 'S') {
            ?>
                <button id="informe_clientes">Generar informe</button>
                &nbsp; &nbsp;
            <?php
            }
            ?>
            <input type="text" name="busqueda" id="busqueda" placeholder="buscar">
            <input type="submit" value="Buscar" class="btn_search">
        </form>
        <table class="tabla">
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Identificacion</th>
                <th>Direccion</th>
                <th>Celular</th>
                <th>Estado</th>
            </tr>
            <?php
            foreach ($query as $row) { ?>
                <tr>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['identificacion']; ?></td>
                    <td><?php echo $row['direccion']; ?></td>
                    <td><?php echo $row['celular']; ?></td>
                    <?php
                    if ($row['estado'] == 'A') {
                    ?>
                        <td>Activo</td>
                    <?php
                    } elseif ($row['estado'] == 'I') {
                    ?>
                        <td>Inactivo</td>
                    <?php
                    }
                    ?>

                </tr>

            <?php
            }
            ?>

        </table>
    </section>
</body>

</html>