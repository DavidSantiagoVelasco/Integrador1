<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
} elseif ($_SESSION['rol'] != 'A' && $_SESSION['rol'] != 'S') {
    header('location: index.php');
} else {
    if (!empty($_POST['id']) && !empty($_POST['stock'])) {

        require_once "../conexion.php";
        $id = mysqli_real_escape_string($conn, $_POST["id"]);
        $stock = mysqli_real_escape_string($conn, $_POST["stock"]);
        $sql = "SELECT * FROM productos WHERE '$id' = id";

        $queryusuario = mysqli_query($conn, $sql);
        $nr = mysqli_num_rows($queryusuario);

        if ($nr == 1) {
            if ($stock > 1) {
                $usuario = $_SESSION['usuario'];
                if (!empty($_POST['precio_compra'])) {
                    $precio_compra = $_POST['precio_compra'];
                    $ejecutar1 = mysqli_query($conn, "INSERT INTO historial_precios(id_producto, usuario, precio_compra, precio)
                VALUES('$id', '$usuario', $precio_compra, (SELECT precio FROM productos WHERE id = '$id'))");
                    $ejecutar2 = mysqli_query($conn, "UPDATE productos SET precio_compra = $precio_compra WHERE id = '$id'");
                    $ejecutar = mysqli_query($conn, "UPDATE productos SET stock = $stock + (SELECT stock FROM productos 
                WHERE id = '$id') WHERE id = '$id'");
                    $ejecutar3 = mysqli_query($conn, "INSERT INTO ingresos_egresos(usuario, egreso) 
                VALUES ('$usuario', $stock*$precio_compra)");
                    if ($ejecutar && $ejecutar1 && $ejecutar2 && $ejecutar3) {
                        $accion = "Actualizar precio compra producto: $id";
                        mysqli_query($conn, "INSERT INTO no_repudio (usuario, accion) VALUES ('$usuario','$accion')");
                        $accion = "Agregar stock producto: $id ; Cantidad agregada $stock";
                        mysqli_query($conn, "INSERT INTO no_repudio (usuario, accion) VALUES ('$usuario','$accion')");
                        echo "<script> alert('Stock actualizado exitosamente');window.location='agregar_stock.php'</script>";
                    } else {
                        echo "<script> alert('Error. No se pudo actualizar el stock');window.location='agregar_stock.php'</script>";
                    }
                } else {
                    $ejecutar = mysqli_query($conn, "UPDATE productos SET stock = $stock + (SELECT stock FROM productos 
                WHERE id = '$id') WHERE id = '$id'");
                    $ejecutar1 = mysqli_query($conn, "CALL añadir_egresos('$usuario', $stock, '$id')");
                    if ($ejecutar && $ejecutar1) {
                        $accion = "Agregar stock producto: $id ; Cantidad agregada $stock";
                        $ejecutar2 = mysqli_query($conn, "INSERT INTO no_repudio (usuario, accion) VALUES ('$usuario','$accion')");
                        echo "<script> alert('Stock actualizado exitosamente');window.location='agregar_stock.php'</script>";
                    } else {
                        echo "<script> alert('Error. No se pudo actualizar el stock');window.location='agregar_stock.php'</script>";
                    }
                }
            } else {
                echo "<script> alert('Sólo se permiten valores positivos');window.location='agregar_stock.php'</script>";
            }
        } else {
            echo "<script> alert('ID inválido');window.location='agregar_stock.php'</script>";
        }
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
            <h4>Agregar stock</h4>
            <h5>Bienvenido al módulo para agregar stock a los productos</h5>
            <h5>Debe ingresar el ID del producto y la cantidad que agregará en los campos correspondientes</h5>
            <h5>Ingrese el precio de compra únicamente si es un nuevo precio</h5>
            <input class="textBox_ID" type="text" name="id" id="id" placeholder="ID del producto" required>
            <input class="textBox" type="number" name="stock" id="stock" placeholder="Cantidad a agregar" required>
            <input class="textBox" type="number" step="0.01" name="precio_compra" id="precio_compra" placeholder="Precio compra">
            <button name="btnregistrar" id="btnregistrar" class="button" type="submit">Agregar</button>
        </section>
    </form>
</body>

</html>