<?php

session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
} elseif ($_SESSION['rol'] != 'A') {
    header('location: index.php');
} else {
    if (!empty($_POST)) {
        try {
            require_once "../conexion.php";

            $nombre = $_POST["nombre"];
            $apellido = $_POST["apellido"];
            $id = $_POST["identificacion"];
            $usuario = $_POST["usuario"];
            $contra = $_POST["contra"];
            $tipo = $_POST['rol'];
            $pass_encript = password_hash($contra, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuarios VALUES('$nombre', '$apellido', '$id', '$usuario', '$pass_encript', '$tipo', 'A')";

            $ejecutar = mysqli_query($conn, $sql);

            if (!$ejecutar) {
                echo "<script> alert('No se pudo registrar el usuario');window.location='registro_usuario.php'</script>";
            } else {
                $usu = $_SESSION['usuario'];
                $insert = "Registar usuario: $usuario";
                echo $insert;
                $ejecutar = mysqli_query($conn, "INSERT INTO no_repudio(usuario, accion) VALUES('$usu', '$insert')");
                echo  "<script> alert('Usuario registrado exitosamente');window.location='registro_usuario.php'</script>";
            }
        } catch (Exception $e) {
            echo  "<script> alert('No se pudo registrar el usuario. Revise si ya existe un registro con el mismo usuario o identificación');window.location='registro_usuario.php'</script>";
        }
    } else {
        header('location: registro_usuario.php');
    }
}
