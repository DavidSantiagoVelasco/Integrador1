<header>
		<div class="header">
			
			<h1>APU</h1>
			<div class="optionsBar">
				<p><?php echo fechaC() ?></p>
				<span>|</span>
				<span class="user"><?php echo $_SESSION['nombre']. " ". $_SESSION['apellido'];?></span>
				<a href="salir.php"><img class="close" src="img/salir.png" alt="Salir del sistema" title="Salir"></a>
			</div>
		</div>
        <?php include "nav.php" ?>
	</header>