<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
} elseif ($_SESSION['rol'] != 'A' && $_SESSION['rol'] != 'S') {
    header('location: index.php');
} else {
    if (!empty($_POST)) {
        $accion = $_POST['accion'];
        if ($accion == 'C') {
            header("location:crear_orden.php");
        } else if ($accion == 'L') {
            header("location:lista_ordenes.php");
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
            <h4>Administrar ordenes</h4>
            <label>Elija la accion que quiere realizar</label>
            <select name="accion">
                <option value="C">Crear orden</option>
                <option value="L">Ver lista de ordenes</option>
            </select>
    </form>
    <button name="btnadministrar" id="btnadministrar" class="button" type="submit">Siguiente</button>
    </section>
    </form>
</body>

</html>