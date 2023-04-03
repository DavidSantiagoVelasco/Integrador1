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
	<?php include "includes/scripst.php" ?>
    <link rel="stylesheet" href="style_registro_producto.css">
	<title>APU</title>
</head>
<body>
	<?php include "includes/header.php" ?>
	<section id="container">
	</section>
    <form method="POST" id="form" action="registrar_productos.php">
        <section class="registro">
            <h4>Registrar producto</h4>
            <input class="textBox" type="text" name="nombre" id="nombre" placeholder="Nombre producto" required>
            <input class="textBox" type="text" name="id" id="id" placeholder="ID del producto" required>
            <input class="textBox" type="number" name="stock" id="stock" placeholder="Stock" required>
            <input class="textBox" type="number" step="0.01" name="precio_compra" id="precio_compra" placeholder="Precio compra" required>
            <input class="textBox" type="number" step="0.01" name="precio" id="precio" placeholder="Precio venta" required>
            <textarea name="mensaje" placeholder="Descripcion" id="mensaje"></textarea>
            <button name="btnregistrar" id="btnregistrar" class="button" type="submit">Registrar</button>
            <p class="warnings" id="warnings"></p>
        </section>
    </form>
    <script src="js/logica_registro_producto.js"></script>
</body>
</html>