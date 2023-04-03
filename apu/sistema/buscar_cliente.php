<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
}
require_once "../conexion.php";
$busqueda = mysqli_real_escape_string($conn, strtolower($_REQUEST['busqueda']));
$consulta = "SELECT * FROM clientes WHERE nombre LIKE '%$busqueda%' OR email LIKE '%$busqueda%' 
OR identificacion LIKE '%$busqueda%' ORDER BY id ASC";
$query = mysqli_query($conn, $consulta);
$usuario = $_SESSION['usuario'];
$accion = "Buscar cliente : $busqueda";
///mysqli_query($conn, "INSERT INTO no_repudio(usuario, accion) VALUES ('$usuario', '$accion')");
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
            header('location: clientes.php');
        }

        ?>
        <h1>Lista clientes</h1>
        <form action="buscar_cliente.php" method="get" class="form_search">
            <input type="text" name="busqueda" id="busqueda" placeholder="buscar" value="<?php echo $busqueda; ?>">
            <input type="submit" value="Buscar" class="btn_search">
        </form>
        <table class="tabla">
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Identificacion</th>
                <th>Direccion</th>
                <th>Celular</th>
            </tr>
            <?php
            foreach ($query as $row) { ?>
                <tr>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['identificacion']; ?></td>
                    <td><?php echo $row['direccion']; ?></td>
                    <td><?php echo $row['celular']; ?></td>
                </tr>
            <?php
            }
            ?>
        </table>

    </section>
</body>

</html>