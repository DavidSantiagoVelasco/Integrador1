<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
}
require_once "../conexion.php";
$consulta = "SELECT id_orden, fecha, usuario, precio_total, estado FROM orden ORDER BY fecha ASC";
$query = mysqli_query($conn, $consulta);
$usuario = $_SESSION['usuario'];
mysqli_query($conn, "INSERT INTO no_repudio (usuario, accion) VALUES ('$usuario', 'Ver lista ordenes')");
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/lista_orden.css">
    <?php include "includes/scripst.php" ?>
    <title>APU</title>
</head>

<body>
    <?php include "includes/header.php" ?>
    <section id="container">
        <h1>Lista órdenes</h1>
        <form action="buscar_oden.php" method="get" class="form_search">
            <input type="text" name="busqueda" id="busqueda" placeholder="No. Orden">
            <input type="submit" value="Buscar" class="btn_search">
        </form>
        <table class="tabla" id="all_ordenes">
            <tr>
                <th>No.</th>
                <th>Fecha</th>
                <th>Usuario Vendedor</th>
                <th>Precio total</th>
                <th class="textrigth">Estado</th>
                <th class="textrigth">Acciones</th>
            </tr>
            <?php
            foreach ($query as $row) { ?>
                <tr id="row_<?php echo $row['id_orden'] ?>">
                    <td><?php echo $row['id_orden']; ?></td>
                    <td><?php echo $row['fecha']; ?></td>
                    <td><?php echo $row['usuario']; ?></td>
                    <td><?php echo $row['precio_total']; ?></td>
                    <td><?php if ($row['estado'] == 'A') {
                            echo 'Pagada';
                        } elseif ($row['estado'] == 'C') {
                            echo 'Anulada';
                        } elseif ($row['estado'] == 'D') {
                            echo 'Despachada';
                        } ?></td>
                    <td>
                        <div class="div_acciones">
                            <div>
                                <button class="btn_view view_factura" num="<?php echo $row['id_orden'] ?>">Ver</button>
                            </div>

                            <div>
                                <?php
                                if ($_SESSION['rol'] == 'A' || $_SESSION['rol'] == 'S') {
                                    if ($row['estado'] == 'A' || $row['estado'] == 'D') {
                                ?>
                                        <div class="div_factura">
                                            <button class="btn_anular anular_factura" num="<?php echo $row['id_orden'] ?>">Anular</button>
                                        </div>
                                    <?php } else { ?>
                                        <div class="div_factura">
                                            <button class="btn_anular inactive" style="cursor: default;" disabled>Anular</button>
                                        </div>
                                    <?php }
                                } elseif ($_SESSION['rol'] == 'B') {
                                    if ($row['estado'] == 'A') {
                                    ?>
                                        <div class="div_factura">
                                            <button class="btn_anular despachar" num="<?php echo $row['id_orden'] ?>">Despachar</button>
                                        </div>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="div_factura">
                                            <button class="btn_anular despachar" style="cursor: default;" disabled>Despachar</button>
                                        </div>
                                <?php
                                    }
                                } ?>
                            </div>
                        </div>
                    </td>
                </tr>

            <?php
            }
            ?>
        </table>
        <table class="tabla" id="tabla_orden" hidden>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Fecha</th>
                    <th>Usuario Vendedor</th>
                    <th>Precio compra total</th>
                    <th>Precio venta total</th>
                    <th>Total impuestos</th>
                    <th class="textrigth">Estado</th>
                </tr>
            </thead>
            <tbody id="detalle_orden">

            </tbody>

        </table>
        <br>
        <table class="tabla" id="tabla_productos" hidden>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio compra</th>
                    <th>Precio venta</th>
                    <th>Impuestos</th>
                    <th>Total item</th>
                </tr>
            </thead>
            <tbody id="productos_orden">
            </tbody>
        </table>
        <button class="btn_volver" id="btn_volver">
            Volver
        </button>

    </section>
</body>

</html>