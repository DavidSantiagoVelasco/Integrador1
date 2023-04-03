<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
}elseif ($_SESSION['rol'] != 'A' && $_SESSION['rol'] != 'S') {
    header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="crear_orden.css">
    <?php include "includes/scripst.php" ?>
    <title>APU</title>
</head>

<body>
    <?php include "includes/header.php" ?>
    <section id="container">
        <h1>Crear orden</h1>
        <div class="datos_venta">
            <h4>Datos orden</h4>
            <div class="datos">
                <div class="wd50">
                    <label>Vendedor</label>
                    <p><?php echo $_SESSION['nombre'].' '.$_SESSION['apellido'] ?></p>
                </div>
                <div class="wd50">
                    <label>Acciones</label>
                    <div id="acciones_venta">
                        <a href="#" class="btn_ok textcenter" id="btn_anular_venta">Cancelar</a>
                        <a href="#" class="btn_new textcenter" id="btn_facturar_venta" style="display: none;">Crear</a>
                    </div>
                </div>
            </div>
        </div>
        <table class="tbl_venta">
            <thead>
                <tr>
                    <th width="100px">Código</th>
                    <th>Nombre</th>
                    <th>Stock</th>
                    <th width="100px">Cantidad</th>
                    <th class="textright">Precio</th>
                    <th class="textright">Precio total</th>
                    <th>Acción</th>
                </tr>
                <tr>
                    <td><input type="text" name="txt_cod_producto" id="txt_cod_producto"></td>
                    <td id="txt_nombre">-</td>
                    <td id="txt_stock">-</td>
                    <td><input type="text" name="txt_cantidad" id="txt_cantidad" value="0" min="1" disabled></td>
                    <td class="textright" id="txt_precio">0.00</td>
                    <td class="textright" id="txt_precio_total">0.00</td>
                    <td><a href="#" id="add_product_venta" class="link_add">Agregar</a></td>
                </tr>
                <tr>
                    <th>Código</th>
                    <th colspan="2">Nombre</th>
                    <th>Cantidad</th>
                    <th class="textright">Precio</th>
                    <th class="textright">Precio total</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="detalle_venta">
                
            </tbody>
            <tfoot id="detalle_total">
                
            </tfoot>
        </table>
    </section>

    <script type="text/javascript">
        $(document).ready(function(){
            var usuarioid = '<?php echo $_SESSION['usuario']; ?>';
            mostrarDetalleTemp(usuarioid);
        });

    </script>
</body>

</html>