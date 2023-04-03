<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
} elseif ($_SESSION['rol'] != 'A' && $_SESSION['rol'] != 'S' && $_SESSION['rol'] != 'E') {
    header('location: index.php');
} else {
    require_once "../conexion.php";
    $consulta = "SELECT * FROM clientes WHERE estado LIKE 'A' ORDER BY id ASC";
    $query = mysqli_query($conn, $consulta);
    $usuario = $_SESSION['usuario'];
    mysqli_query($conn, "INSERT INTO no_repudio (usuario, accion) VALUES ('$usuario', 'Generar informe clientes')");
    mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style_lista.css">
    <?php include "includes/scripst.php" ?>
    <script>
        alert("Presione 'Ctrl + P' para imprimir el informe");
    </script>
    <title>APU</title>
</head>

<body>
    <section id="container">
        <h1>Informe clientes</h1>

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