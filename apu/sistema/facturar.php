<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
}
require_once "../conexion.php";
if(empty($_REQUEST['id'])){
    echo "<script> alert('Error. No es posible generar la factura');window.location='facturar.php'</script>";
    header('location: crear_orden.php');
}else{
    $id_orden = mysqli_real_escape_string($conn, $_REQUEST['id']);

}
$usuario = $_SESSION['usuario'];
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/lista_orden.css">
    <?php include "includes/scripst.php" ?>
    <script>
        obtener_factura(<?php echo $id_orden ?>);
        alert("Presione 'Ctrl + P' para imprimir la factura");
    </script>
    <title>APU</title>
</head>

<body>
    <section id="container">
        <h1>Factura venta</h1>
        <br><br>
        <table class="tabla" id="tabla_orden">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Fecha</th>
                    <th>Usuario Vendedor</th>
                    <th>Precio total factura</th>
                    <th>Total impuestos</th>
                    <th class="textrigth">Estado</th>
                </tr>
            </thead>
            <tbody id="detalle_orden_facturar">
                <php echo $detalle ?>
            </tbody>

        </table>
        <br>
        <table class="tabla" id="tabla_productos">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Impuestos</th>
                    <th>Total item</th>
                </tr>
            </thead>
            <tbody id="productos_orden_facturar">
                <php echo $productos ?>
            </tbody>
        </table>

    </section>
</body>

</html>