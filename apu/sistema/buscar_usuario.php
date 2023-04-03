<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
}
require_once "../conexion.php";
$busqueda = mysqli_real_escape_string($conn, strtolower($_REQUEST['busqueda']));
$consulta = "SELECT * FROM usuarios WHERE nombre LIKE '%$busqueda%' OR usuario LIKE '%$busqueda%' 
OR identificacion LIKE '%$busqueda%' ORDER BY rol ASC";
$query = mysqli_query($conn, $consulta);
$usuario = $_SESSION['usuario'];
$accion = "Buscar lista usuario : $busqueda";
mysqli_query($conn, "INSERT INTO no_repudio(usuario, accion) VALUES ('$usuario', '$accion')");
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style_lista.css">
    <?php include "includes/scripst.php" ?>
    <title>APU</title>
</head>

<body>
    <?php include "includes/header.php" ?>
    <section id="container">
        <?php
        if (empty($busqueda)) {
            header('location: lista_usuarios.php');
        }

        ?>
        <h1>Lista usuarios</h1>
        <form action="buscar_usuario.php" method="get" class="form_search">
            <input type="text" name="busqueda" id="busqueda" placeholder="buscar" value="<?php echo $busqueda; ?>">
            <input type="submit" value="Buscar" class="btn_search">
        </form>
        <table class="tabla">
            <tr>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Identificacion</th>
                <th>Rol</th>
                <th>Estado</th>
            </tr>
            <?php
            foreach ($query as $row) { ?>
                <tr>
                    <td><?php echo $row['usuario']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['apellido']; ?></td>
                    <td><?php echo $row['identificacion']; ?></td>
                    <td><?php
                        if ($row['rol'] == 'A') {
                            echo 'Administrador';
                        } else if ($row['rol'] == 'S') {
                            echo 'Secretario';
                        } else if ($row['rol'] == 'B') {
                            echo 'Personal Bodega';
                        } else {
                            echo 'Usuario externo';
                        }; ?></td>
                    <td><?php if ($row['estado'] == 'A') {
                            echo 'Activo';
                        } else {
                            echo 'Inactivo';
                        }; ?></td>
                </tr>


            <?php
            }
            ?>
        </table>

    </section>
</body>

</html>