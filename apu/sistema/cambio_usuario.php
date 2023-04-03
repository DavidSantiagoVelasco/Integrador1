<?php
	session_start();
	if (empty($_SESSION['active'])) {
		header('location: ../');
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
    <form method="POST" id="form" action="cambiar_usuario.php">
        <section class="registro">
            <h4>Cambiar Usuario</h4>
            <input class="textBox" type="email" name="usuario_v" id="usuario_v" placeholder="Usuario actual" required>
            <input class="textBox" type="email" name="usuario_n" id="usuario_n" placeholder="Usuario nuevo" required>
            <button name="btnusuario" id="btnusuario" class="button" type="submit">Cambiar</button>
        </section>
    </form>
    <script src="cambiar_usuario.js"></script>
</body>
</html>