<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
} else {
    if ($_SESSION['rol'] != 'A' && $_SESSION['rol'] != 'S') {
        header('location: index.php');
    } else {
        require_once "../conexion.php";
        $consulta = "SELECT * FROM productos WHERE estado = 'A' ORDER BY nombre ASC";
        $query = mysqli_query($conn, $consulta);
        $usuario = $_SESSION['usuario'];
        mysqli_query($conn, "INSERT INTO no_repudio(usuario, accion) VALUES ('$usuario', 'Generar informe productos')");
        mysqli_close($conn);
    }
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
        <h1>Informe productos</h1>

        <table class="tabla">
            <tr>
                <th>Nombre</th>
                <th>Id</th>
                <th>Stock</th>
                <th>Precio</th>
                <th>Descripcion</th>
            </tr>
            <?php
            foreach ($query as $row) { ?>
                <tr>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['stock']; ?></td>
                    <td><?php echo $row['precio']; ?></td>
                    <td><?php echo $row['descripcion']; ?></td>
                </tr>

            <?php
            }
            ?>
        </table>

    </section>
</body>

</html>