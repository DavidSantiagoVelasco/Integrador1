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
    <form method="POST" id="form" action="cambiar_contraseña.php">
        <section class="registro">
            <h4>Cambiar Contraseña</h4>
            <input class="textBox" type="email" name="usuario" id="usuario" placeholder="Usuario" required>
            <input class="textBox" type="password" name="contra" id="contra" placeholder="Contraseña nueva" required>
            <input class="textBox" type="password" name="contra2" id="contra2" placeholder="Repetir contraseña" required>
            <button name="btnusuario" id="btnusuario" class="button" type="submit">Cambiar</button>
        </section>
    </form>
    <script src="cambiar_contraseña.js"></script>
</body>
</html>