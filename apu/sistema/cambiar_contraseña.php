<?php

session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
} elseif ($_SESSION['rol'] != 'A') {
    header('location: index.php');
} else {
    if (!empty($_POST)) {
        require_once "../conexion.php";

        $usuario = $_POST["usuario"];
        $contra = $_POST["contra"];
        $pass_encript = password_hash($contra, PASSWORD_DEFAULT);

        $sql = "SELECT * FROM usuarios WHERE '$usuario' = usuario";

        $queryusuario = mysqli_query($conn, $sql);
        $nr = mysqli_num_rows($queryusuario);

        if ($nr == 1) {
            $sql = "UPDATE usuarios SET contraseña = '$pass_encript' WHERE '$usuario' = usuario ";
            $ejecutar = mysqli_query($conn, $sql);
            if ($ejecutar) {
                $usu = $_SESSION['usuario'];
                $accion = "Cambiar contraseña del usuario: $usuario";
                $ejecutar = mysqli_query($conn, "INSERT INTO no_repudio(usuario, accion) VALUES ('$usu', '$accion')");
                echo "<script> alert('Se modificó la contraseña exitosamente');window.location='cambio_contraseña.php'</script>";
            } else {
                echo "<script> alert('Error. No se pudo modificar la contraseña');window.location='cambio_contraseña.php'</script>";
            }
        } else {
            echo "<script> alert('Usuario inválido');window.location='cambio_contraseña.php'</script>";
        }
    } else {
        header('location: cambio_contraseña.php');
    }
}
