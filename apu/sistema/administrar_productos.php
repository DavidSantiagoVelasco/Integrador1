<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
} elseif ($_SESSION['rol'] != 'A' && $_SESSION['rol'] != 'S') {
    header('location: index.php');
} else {
    if (!empty($_POST)) {
        $accion = $_POST['accion'];
        if ($accion == 'E') {
            header("location:eliminar_producto.php");
        } else if ($accion == 'R') {
            header("location:registro_producto.php");
        } else if ($accion == 'A') {
            header("location:actualizar_producto.php");
        } elseif($accion == 'H'){
            header("location:historial_precios.php");
        }
         else {
            header("location:lista_productos.php");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripst.php" ?>
    <link rel="stylesheet" href="style.css">
    <title>APU</title>
</head>

<body>
    <?php include "includes/header.php" ?>
    <section id="container">
    </section>
    <form method="POST" id="form" action="">
        <section class="registro">
            <h4>Administrar productos</h4>
            <label>Elija la accion que quiere realizar</label>
            <select name="accion">
                <option value="R">Registrar</option>
                <option value="E">Eliminar</option>
                <option value="A">Actualizar producto</option>
                <option value="L">Ver lista de productos</option>
                <option value="H">Historial de precios</option>
            </select>
    </form>
    <button name="btnadministrar" id="btnadministrar" class="button" type="submit">Siguiente</button>
    </section>
    </form>
</body>

</html>