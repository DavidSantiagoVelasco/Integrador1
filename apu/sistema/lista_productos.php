<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
}
require_once "../conexion.php";
$consulta = "SELECT * FROM productos ORDER BY nombre ASC";
$query = mysqli_query($conn, $consulta);
$usuario = $_SESSION['usuario'];
mysqli_query($conn, "INSERT INTO no_repudio(usuario, accion) VALUES ('$usuario', 'Ver lista productos')");
mysqli_close($conn);
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
        <h1>Lista productos</h1>

        <form action="buscar_productos.php" method="get" class="form_search">
            <?php
            if ($_SESSION['rol'] == 'A' || $_SESSION['rol'] == 'S') {
            ?>
                <button id="informe_productos">Generar informe</button>
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
                <th>Id</th>
                <th>Stock</th>
                <?php
                if ($_SESSION['rol'] == 'S' || $_SESSION['rol'] == 'A') { ?>
                    <th>Precio compra</th>
                <?php
                } ?>
                <th>Precio venta</th>
                <th>Descripcion</th>
                <th>Estado</th>
            </tr>
            <?php
            foreach ($query as $row) { ?>
                <tr>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['stock']; ?></td>
                    <?php
                    if ($_SESSION['rol'] == 'S' || $_SESSION['rol'] == 'A') { ?>
                        <td><?php echo $row['precio_compra']; ?></td>
                    <?php
                    } ?>
                    <td><?php echo $row['precio']; ?></td>
                    <td><?php echo $row['descripcion']; ?></td>
                    <td><?php
                        if ($row['estado'] == 'A') {
                            echo 'Activo';
                        } elseif ($row['estado'] == 'E') {
                            echo 'Eliminado';
                        }
                        ?></td>
                </tr>

            <?php
            }
            ?>
        </table>

    </section>
</body>

</html>