<?php

session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');

}else{
    if (!empty($_POST)) {
        require_once "../conexion.php";

        $viejo = $_POST["usuario_v"];
        $nuevo = $_POST["usuario_n"];

        $sql = "SELECT * FROM usuarios WHERE '$viejo' = usuario";

        $queryusuario = mysqli_query($conn, $sql);
        $nr = mysqli_num_rows($queryusuario);

        if ($nr == 1) {
            try{
                $sql = "UPDATE usuarios SET usuario = '$nuevo' WHERE '$viejo' = usuario ";
            $ejecutar = mysqli_query($conn, $sql);
            if ($ejecutar) {
                $usu = $_SESSION['usuario'];
                $accion = "Cambiar usuario: $viejo por: $nuevo";
                $ejecutar = mysqli_query($conn, "INSERT INTO no_repudio(usuario, accion) VALUES ('$usu', '$accion')");
                echo "<script> alert('Se modificó el usuario exitosamente');window.location='cambio_usuario.php'</script>";
            } else {
                echo "<script> alert('Error. No se pudo modificar el usuario');window.location='cambio_usuario.php'</script>";
            }
            }catch(Exception $e){
                echo "<script> alert('Error. No se pudo modificar el usuario. Revise si ya existe el usuario nuevo');window.location='cambio_usuario.php'</script>";
            }
            
        } else {
            echo "<script> alert('Usuario inválido');window.location='cambio_usuario.php'</script>";
        }
        mysqli_close($conn);
    } else {
        header('location: cambio_usuario.php');
    }
}
