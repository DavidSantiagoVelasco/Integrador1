<?php
session_start();
if (empty($_SESSION['active'])) {
	header('location: ../');
} elseif ($_SESSION['rol'] != 'A') {
	header('location: index.php');
}
if (!empty($_POST)) {
	require_once "../conexion.php";
	$usuario = $_POST["usuario"];

	$sql = "SELECT * FROM usuarios WHERE '$usuario' = usuario";

	$queryusuario = mysqli_query($conn, $sql);
	$nr = mysqli_num_rows($queryusuario);

	if ($nr == 1) {
		$data = mysqli_fetch_array($queryusuario);
		if ($data['estado'] == 'I') {
			echo "<script> alert('El usuario ya se encuentra inactivo');window.location='eliminar_usuario.php'</script>";
		} else {
			$sql = "UPDATE usuarios SET estado = 'I' WHERE '$usuario' = usuario ";
			$ejecutar = mysqli_query($conn, $sql);
			if ($ejecutar) {
				$usu = $_SESSION['usuario'];
				$accion = "Eliminar usuario: $usuario";
				$ejecutar = mysqli_query($conn, "INSERT INTO no_repudio(usuario, accion) VALUES ('$usu', '$accion')");
				echo "<script> alert('Usuario eliminado exitosamente');window.location='eliminar_usuario.php'</script>";
			} else {
				echo "<script> alert('Error. No se pudo eliminar el usuario');window.location='eliminar_usuario.php'</script>";
			}
		}
	} else {
		echo "<script> alert('Usuario inválido');window.location='eliminar_usuario.php'</script>";
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
			<h4>Eliminar usuario</h4>
			<input class="textBox" type="email" name="usuario" id="usuario" placeholder="Usuario" required>
			<button name="btnregistrar" id="btnregistrar" class="button" type="submit">Eliminar</button>
		</section>
	</form>
	<script src="logica_eliminar_usuario.js"></script>
</body>

</html>