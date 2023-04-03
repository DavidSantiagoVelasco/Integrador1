<nav>
	<ul>
		<li><a href="../index.php">Inicio</a></li>
		<?php
		if ($_SESSION['rol'] == 'A') {
		?>
			<li class="principal">
				<a href="modificar_usuarios.php">Usuarios</a>
				<ul>
					<li><a href="registro_usuario.php">Nuevo Usuario</a></li>
					<li><a href="eliminar_usuario.php">Eliminar Usuario</a></li>
					<li><a href="cambio_usuario.php">Cambiar Usuario</a></li>
					<li><a href="cambio_contraseña.php">Cambiar Contraseña</a></li>
					<li><a href="lista_usuarios.php">Lista de Usuarios</a></li>
				</ul>
			</li>
		<?php
		}
		?>
		<?php
		if ($_SESSION['rol'] == 'A' || $_SESSION['rol'] == 'S') {
		?>
			<li class="principal">
				<a href="administrar_productos.php">Productos</a>
				<ul>
					<li><a href="registro_producto.php">Registrar Producto</a></li>
					<li><a href="eliminar_producto.php">Eliminar Producto</a></li>
					<li><a href="actualizar_producto.php">Actualizar Producto</a></li>
					<li><a href="lista_productos.php">Lista de Productos</a></li>
					<li><a href="agregar_stock.php">Agregar stock</a></li>
					<li><a href="historial_precios.php">Historial precios</a></li>
				</ul>
			</li>
		<?php } ?>
		<?php
		if ($_SESSION['rol'] == 'B' || $_SESSION['rol'] == 'E') {
		?>
			<li class="principal">
				<a href="lista_productos.php">Lista Productos</a>
			</li>
		<?php } ?>
		<?php
		if ($_SESSION['rol'] == 'A' || $_SESSION['rol'] == 'S') {
		?>
		<li class="principal">
			<a href="ordenes.php">Ordenes</a>
			<ul>
				<li><a href="crear_orden.php">Crear orden</a></li>
				<li><a href="lista_ordenes.php">Lista ordenes</a></li>
			</ul>
		</li>
		<?php } ?>
		<?php
		if ($_SESSION['rol'] == 'B') {
		?>
			<li class="principal">
				<a href="lista_ordenes.php">Lista Ordenes</a>
			</li>
		<?php } ?>
		<?php
		if ($_SESSION['rol'] == 'A' || $_SESSION['rol'] == 'S') {
		?>
			<li class="principal">
				<a href="ingresos_egresos.php">Ingresos/Egresos</a>
			</li>
		<?php } ?>
		<?php
		if ($_SESSION['rol'] == 'A' || $_SESSION['rol'] == 'S') {
		?>
			<li class="principal">
				<a href="contacto.php">Mensajes contacto</a>
			</li>
		<?php } ?>
		<?php
		if ($_SESSION['rol'] == 'A' || $_SESSION['rol'] == 'S' || $_SESSION['rol'] == 'E') {
		?>
			<li class="principal">
				<a href="clientes.php">Lista clientes</a>
			</li>
		<?php } ?>
		
	</ul>
</nav>