<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
} elseif ($_SESSION['rol'] != 'A' && $_SESSION['rol'] != 'S') {
    header('location: index.php');
} else {
    if (!empty($_POST)) {
        require_once "../conexion.php";
        $id = mysqli_real_escape_string($conn, $_POST["id"]);
        $sql = "SELECT * FROM productos WHERE '$id' = id";

        $queryusuario = mysqli_query($conn, $sql);
        $nr = mysqli_num_rows($queryusuario);

        if ($nr == 1) {
            $sql = "UPDATE productos SET estado = 'E' WHERE id = '$id'";
            $ejecutar = mysqli_query($conn, $sql);
            if ($ejecutar) {
                $usuario = $_SESSION['usuario'];
                $accion = "Eliminar producto ID: $id";
                mysqli_query($conn, "INSERT INTO no_repudio (usuario, accion) VALUES ('$usuario', '$accion') ");
                echo "<script> alert('Producto eliminado exitosamente');window.location='eliminar_producto.php'</script>";
            } else {
                echo "<script> alert('Error. No se pudo eliminar el producto');window.location='eliminar_producto.php'</script>";
            }
        } else {
            echo "<script> alert('ID inválido');window.location='eliminar_producto.php'</script>";
        }
        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <?php include "includes/scripst.php" ?>
    <title>APU</title>
</head>

<body>
    <?php include "includes/header.php" ?>
    <section id="container">
    </section>
    <form method="POST" id="form" action="">
        <section class="registro">
            <h4>Eliminar producto</h4>
            <input class="textBox_ID" type="text" name="id" id="id" placeholder="Eliminar producto por ID" required>
            <button name="btnregistrar" id="btnregistrar" class="button" type="submit">Eliminar</button>
        </section>
    </form>
    <script src="js/eliminar_producto.js"></script>
</body>

</html>