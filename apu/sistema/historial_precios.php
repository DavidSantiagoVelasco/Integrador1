<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
} elseif ($_SESSION['rol'] != 'A' && $_SESSION['rol'] != 'S') {
    header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/historial_precio.css">
    <?php include "includes/scripst.php" ?>
    <title>APU</title>
</head>

<body>
    <?php include "includes/header.php" ?>
    <section id="container">
    </section>
    <form method="POST" id="form" action="">
        <section class="registro">
            <h4>Historial precios de productos</h4>
            <input class="textBox_ID" type="text" name="id" id="id" placeholder="Buscar producto por ID" required>
            <button name="btnhistorial" id="btnhistorial" class="button">Buscar</button>
        </section>
    </form>
    <table class="tabla" id="tabla_orden" hidden>
        <thead>
            <tr>
                <th>ID producto</th>
                <th>Nombre</th>
                <th>Usuario modificó</th>
                <th>Precio compra</th>
                <th>Precio venta</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody id="detalle_orden">
            
        </tbody>

    </table>
    <button class="btn_volver" id="btn_volver_historial">
        Volver
    </button>
</body>

</html>