<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
} elseif ($_SESSION['rol'] != 'A' && $_SESSION['rol'] != 'S') {
    header('location: index.php');
} else {
    if (!empty($_POST)) {
        require_once "../conexion.php";
        $nombre = strtolower(mysqli_real_escape_string($conn, $_POST["nombre"]));
        $id = mysqli_real_escape_string($conn, $_POST["id"]);
        $precio = $_POST["precio"];
        $precio_compra = $_POST["precio_compra"];
        $descripcion = mysqli_real_escape_string($conn, $_POST["mensaje"]);
        $usuario = $_SESSION['usuario'];
        $cont = 0;

        $sql = "SELECT * FROM productos WHERE id = '$id'";

        $query = mysqli_query($conn, $sql);
        $nr = mysqli_num_rows($query);
        if ($nr == 1) {
            $alert = '';
            $actualizar = true;
            if (!empty($precio)) {
                if ($precio < 1) {
                    $alert = $alert . "Precio no válido<br>";
                    $actualizar = false;
                }
            }
            if (!empty($precio_compra)) {
                if ($precio_compra < 1) {
                    $alert = $alert . "Precio no válido<br>";
                    $actualizar = false;
                }
            }
            if ($actualizar) {
                if (!empty($nombre)) {
                    $sql = "UPDATE productos SET nombre = '$nombre' WHERE id = '$id'";
                    $ejecutar = mysqli_query($conn, $sql);
                    if ($ejecutar) {
                        $accion = "Actualizar nombre producto: $id";
                        mysqli_query($conn, "INSERT INTO no_repudio(usuario, accion) VALUES ('$usuario','$accion')");
                        $alert = "Nombre actualizado exitosamente<br>";
                        $cont = $cont + 1;
                    } else {
                        $alert = "No se pudo actualizar el nombre<br>";
                    }
                }
                if (!empty($precio)) {
                    $act_precio_compra = 0;
                    if(!empty($precio_compra)){
                        $act_precio_compra = 1;
                        $ejecutar1 = mysqli_query($conn, "INSERT INTO historial_precios (id_producto, usuario, precio_compra, precio) VALUES ('$id', '$usuario', $precio_compra, $precio)");
                        mysqli_query($conn, "UPDATE productos SET precio_compra = $precio_compra WHERE id = '$id'");
                    }else{
                        $ejecutar1 = mysqli_query($conn, "INSERT INTO historial_precios (id_producto, usuario, precio_compra, precio) VALUES ('$id', '$usuario', 
                        (SELECT precio_compra FROM productos WHERE id = '$id'), '$precio')");
                    }
                    $sql = "UPDATE productos SET precio = '$precio' WHERE id = '$id'";
                    $ejecutar = mysqli_query($conn, $sql);
                    if ($ejecutar & $ejecutar1) {
                        $accion = "Actualizar precio venta producto: $id";
                        mysqli_query($conn, "INSERT INTO no_repudio(usuario, accion) VALUES ('$usuario','$accion')");
                        $alert = $alert . "Precio actualizado exitosamente<br>";
                        if($act_precio_compra == 1){
                            $accion = "Actualizar precio compra producto: $id";
                            mysqli_query($conn, "INSERT INTO no_repudio(usuario, accion) VALUES ('$usuario','$accion')");
                            $alert = $alert . "Precio compra actualizado exitosamente<br>";
                        }
                        $cont = $cont + 1;
                    } else {
                        $alert = $alert . "No se pudo actualizar el precio<br>";
                    }
                }else{
                    if(!empty($precio_compra)){
                        $sql = "UPDATE productos SET precio_compra = $precio_compra WHERE id = '$id'";
                        $ejecutar = mysqli_query($conn, $sql);
                        if($ejecutar){
                            $accion = "Actualizar precio compra producto: $id";
                            mysqli_query($conn, "INSERT INTO no_repudio(usuario, accion) VALUES ('$usuario','$accion')");
                            $alert = $alert . "Precio compra actualizado exitosamente<br>";
                            $ejecutar1 = mysqli_query($conn, "INSERT INTO historial_precios(id_producto, usuario, precio_compra, precio) VALUES ('$id', '$usuario', '$precio_compra'
                            , (SELECT precio FROM productos WHERE id = '$id'))");
                            $cont = $cont + 1;
                        }
                    }
                }
                if (!empty($descripcion)) {
                    $sql = "UPDATE productos SET descripcion = '$descripcion' WHERE id = '$id'";
                    $ejecutar = mysqli_query($conn, $sql);
                    if ($ejecutar) {
                        $accion = "Actualizar descripción producto: $id";
                        mysqli_query($conn, "INSERT INTO no_repudio(usuario, accion) VALUES ('$usuario','$accion')");
                        $alert = $alert . "Descripción actualizada exitosamente<br>";
                        $cont = $cont + 1;
                    } else {
                        $alert = $alert . 'No se pudo actualizar la descripción<br>';
                    }
                }
                if ($cont == 0) {
                    $alert = '<p>No hay campos por actualizar</p>';
                }
                $alert = '<p>' . $alert . '</p>';
            } else {
                $alert = '<p>' . $alert . '</p>';
            }
        } else {
            $alert = '<p>ID inválido</p>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style_actualizar_productos.css">
    <?php include "includes/scripst.php" ?>
    <title>APU</title>
</head>

<body>
    <?php include "includes/header.php" ?>
    <section id="container">
    </section>
    <form method="POST" class="form_actualizar" id="form" action="">
        <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
        <section class="registro">
            <h4>Actualizar producto</h4>
            <h5>Bienvenido al módulo para actualizar productos</h5>
            <h5>Debe ingresar el ID del producto a actualizar en el campo correspondiente</h5>
            <h5>Rellene únicamente los campos que actualizará</h5>
            <br>
            <input class="textBox" type="text" name="nombre" id="nombre" placeholder="Nombre producto">
            <input class="textBox" type="text" name="id" id="id" placeholder="ID del producto" required>
            <input class="textBox" type="number" step="0.01" name="precio_compra" id="precio_compra" placeholder="Precio compra">
            <input class="textBox" type="number" step="0.01" name="precio" id="precio" placeholder="Precio venta">
            <textarea name="mensaje" placeholder="Descripcion" id="mensaje"></textarea>
            <button name="btnregistrar" id="btnregistrar" class="button" type="submit">Actualizar</button>
        </section>
    </form>
</body>

</html>