<?php
session_start();
if (!empty($_SESSION['active'])) {
    header('location: sistema/');
} else {
    if (!empty($_POST)) {

        if (empty($_POST['usuario']) || empty($_POST['contra'])) {
            echo "<script> alert('Debe colocar usuario y contraseña');window.location='index.html'</script>";
        } else {
            require_once "conexion.php";

            $usuario = mysqli_real_escape_string($conn, $_POST["usuario"]);
            $contra = mysqli_real_escape_string($conn, $_POST["contra"]);

            $sql = "SELECT * FROM usuarios WHERE '$usuario' = usuario";

            $queryusuario = mysqli_query($conn, $sql);
            $nr = mysqli_num_rows($queryusuario);
            if ($nr == 1) {
                $data = mysqli_fetch_array($queryusuario);
                $rol = $data['rol'];
                $contra_encript = $data['contraseña'];
                $estado = $data['estado'];

                if (password_verify($contra, $contra_encript)) {
                    if ($estado == 'A') {
                        $_SESSION['active'] = true;
                        $_SESSION['id'] = $data['identificacion'];
                        $_SESSION['usuario'] = $data['usuario'];
                        $_SESSION['nombre'] = $data['nombre'];
                        $_SESSION['apellido'] = $data['apellido'];
                        $_SESSION['rol'] = $data['rol'];
                        $usuario = $data['usuario'];

                        $sql = mysqli_query($conn, "INSERT INTO no_repudio(usuario, accion) 
                        VALUES ('$usuario', 'Ingreso al sistema')");

                        if($sql){
                            header('location: sistema/');
                        }
                        
                        mysqli_close($conn);

                    } else {
                        echo "<script> alert('Usuario no se encuentra activo');window.location='index.php'</script>";
                        session_destroy();
                    }
                } else {
                    echo "<script> alert('Contraseña inválido');window.location='index.php'</script>";
                    session_destroy();
                }
            } else {
                echo "<script> alert('Usuario o contraseña inválido');window.location='index.php'</script>";
                session_destroy();
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style_inicio.css">
    <title>Ingresar</title>
</head>

<body>
    <form method="POST" id="form" action="">
        <section class="registro">
            <h4>Iniciar sesión</h4>
            <input class="textBox" type="email" name="usuario" id="usuario" placeholder="Usuario" required>
            <input class="textBox" type="password" name="contra" id="contrase" placeholder="Contraseña" required>
            <button name="btnregistrar" id="btnregistrar" class="button" type="submit">Ingresar</button>
        </section>
    </form>
</body>

</html>