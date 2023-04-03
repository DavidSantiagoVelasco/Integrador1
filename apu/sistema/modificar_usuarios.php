<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
}elseif($_SESSION['rol'] != 'A'){
    header('location: index.php');
}
if (!empty($_POST)) {
    $accion = $_POST['accion'];
    if ($accion == 'E') {
        header("location:eliminar_usuario.php");
    } else if ($accion == 'U') {
        header("location:cambio_usuario.php");
    } else if($accion == 'C'){
        header("location:cambio_contraseña.php");
    }else{
        header("location: lista_usuarios.php");
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
            <h4>Modificar usuario</h4>
            <label>Elija la accion que quiere realizar</label>
            <select name="accion">
                <option value="E">Eliminar</option>
                <option value="U">Cambio de usuario</option>
                <option value="C">Cambio de contraseña</option>
                <option value="L">Ver lista usuarios</option>
            </select>
    </form>
    <button name="btnmodificar" id="btnmodificar" class="button" type="submit">Siguiente</button>
    </section>
    </form>
</body>

</html>