<?php

session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
} elseif ($_SESSION['rol'] != 'A' && $_SESSION['rol'] != 'S') {
    header('location: index.php');
} else {
    if (!empty($_POST)) {
        require_once "../conexion.php";

        $nombre = $_POST["nombre"];
        $nombre = strtolower($nombre);
        $id = $_POST["id"];
        $string_stock = $_POST['stock'];
        $string_precio = $_POST['precio'];
        $descripcion = $_POST['mensaje'];
        $usuario = $_SESSION['usuario'];
        $stock = intval($string_stock);
        $precio_compra = doubleval($_POST['precio_compra']);
        $precio = doubleval($string_precio);

        $sql = "INSERT INTO productos VALUES('$nombre', '$id', '$stock', $precio_compra, '$precio', '$descripcion', 'A')";

        try {
            $ejecutar = mysqli_query($conn, $sql);
            if ($ejecutar) {
                $sql = mysqli_query($conn, "INSERT INTO historial_precios (id_producto, usuario, precio_compra, precio) VALUES ('$id', '$usuario', $precio_compra, $precio)");
                $sql = mysqli_query($conn, "INSERT INTO ingresos_egresos (usuario, egreso) VALUES ('$usuario', $precio_compra*$stock)");
                $accion = "Registrar producto ID: $id ; Cantidad: $stock";
                $sql = mysqli_query($conn, "INSERT INTO no_repudio (usuario, accion) VALUES ('$usuario', '$accion')");
                echo "<script> alert('Producto registrado exitosamente');window.location='registro_producto.php'</script>";
            } else {
                echo "<script> alert('No se pudo registrar el producto');window.location='registro_producto.php'</script>";
            }
        } catch (Exception $e) {
            echo "<script> alert('No se pudo registrar el producto. Revise si existe un producto con ese ID');window.location='registro_producto.php'</script>";
        }
        mysqli_close($conn);
    } else {
        header('location: registro_producto.php');
    }
}
