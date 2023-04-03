<?php
	session_start();
	if (empty($_SESSION['active'])) {
		header('location: ../');
	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripst.php" ?>
	<title>APU</title>
</head>
<body>
	<?php include "includes/header.php" ?>
	<section id="container">
		<h1>Bienvenido al sistema</h1>
	</section>
</body>
</html>