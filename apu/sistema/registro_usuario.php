<?php
	session_start();
	if (empty($_SESSION['active'])) {
		header('location: ../');
	}elseif($_SESSION['rol'] != 'A'){
        header('location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
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
    <form method="POST" id="form" action="registrar.php">
        <section class="registro">
            <h4>Registrar usuario</h4>
            <input class="textBox" type="text" name="nombre" id="nombre" placeholder="Nombre" required>
            <input class="textBox" type="text" name="apellido" id="apellido" placeholder="Apellidos" required>
            <input class="textBox" type="text" name="identificacion" id="identificacion" placeholder="Identificacion"
                required>
            <input class="textBox" type="email" name="usuario" id="usuario" placeholder="Usuario" required>
            <input class="textBox" type="password" name="contra" id="contrase" placeholder="Contraseña" requir ed>
            <input class="textBox" type="password" name="contraseña2" id="contrase2" placeholder="Repetir contraseña"
                required>
            <form>
                <label>Elija el rol</label>
                <select name="rol">
                    <option value="S">Secretario</option>
                    <option value="B">Personal de bodega</option>
                    <option value="E">Usuario externo</option>
                    <option value="A">Administrador</option>
                </select>
            </form>
            <button name="btnregistrar" id="btnregistrar" class="button" type="submit">Registrar</button>
            <p class="warnings" id="warnings"></p>
        </section>
    </form>
    <script src="logica.js"></script>
</body>
</html>