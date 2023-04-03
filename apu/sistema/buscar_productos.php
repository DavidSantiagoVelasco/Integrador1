<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
}
require_once "../conexion.php";
$busqueda = mysqli_real_escape_string($conn, strtolower($_REQUEST['busqueda']));
$consulta = "SELECT * FROM productos WHERE nombre LIKE '%$busqueda%' ORDER BY id ASC";
$query = mysqli_query($conn, $consulta);
$usuario = $_SESSION['usuario'];
mysqli_query($conn, "INSERT INTO no_repudio (usuario, accion) VALUES ('$usuario', 'Buscar lista productos : $busqueda')");
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
        <?php
        if (empty($busqueda)) {
            header('location: lista_productos.php');
        }

        ?>
        <h1>Lista productos</h1>
        <form action="buscar_productos.php" method="get" class="form_search">
            <input type="text" name="busqueda" id="busqueda" placeholder="buscar" value="<?php echo $busqueda; ?>">
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
                </tr>

            <?php
            }
            ?>
        </table>

    </section>
</body>

</html>