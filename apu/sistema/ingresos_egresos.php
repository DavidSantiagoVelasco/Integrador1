<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
} elseif ($_SESSION['rol'] != 'A' && $_SESSION['rol'] != 'S') {
    header('location: index.php');
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
        <h1>Ingresos y Egresos</h1>
        <br><br>
        <h4>Buscar por fecha</h4>
        <label>Desde: </label>
        <input type="date" name="fecha_de" id="fecha_de">
        <label>Hasta: </label>
        <input type="date" name="fecha_a" id="fecha_a">
        <button id="buscar_ingresos">Buscar</button>
        <button id="informe_ingresos" hidden>Generar informe</button>
        <br><br>

        <table class="tabla" id="tabla_ingresos" hidden>
            <thead>
                <tr>
                    <th>Usuario responsable</th>
                    <th>Ingreso</th>
                    <th>Egreso</th>
                    <th>Ganancia</th>
                    <th>Impuestos</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody id="body_ingresos">

            </tbody>
        </table>
        <br><br>
        <table class="tabla" id="totales" hidden>
            <thead>
                <tr>
                    <th>Total ingresos</th>
                    <th>Total egresos</th>
                    <th>Total ganancia</th>
                    <th>Total impuestos</th>
                </tr>
            </thead>
            <tbody id="body_totales">
                
            </tbody>
        </table>
    </section>
</body>

</html>