<?php
if (!empty($_POST['nombre']) && !empty($_POST['email']) && !empty($_POST['id']) && !empty($_POST['direccion']) && !empty($_POST['celular'])) {
    include_once "conexion.php";
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $direc = mysqli_real_escape_string($conn, $_POST['direccion']);
    $cel = mysqli_real_escape_string($conn, $_POST['celular']);
    $check = $_POST['checkbox'];

    if ($check == 'on') {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $registro = mysqli_query($conn, "INSERT INTO clientes(nombre, email, identificacion, direccion, celular) VALUES('$nombre', '$email', '$id', '$direc', '$cel')");
            if ($registro) {
                echo '<script language="javascript">alert("Se registró correctamente");</script>';
            } else {
                echo '<script language="javascript">alert("Ocurrió un error. No se pudo registrar");</script>';
            }
        } else {
            echo '<script language="javascript">alert("Email no válido");</script>';
        }
    } else {
        echo '<script language="javascript">alert("Debe aceptar la política de datos personales y el manual de usuario");</script>';
    }
    mysqli_close($conn);
}

?>


<!-- Footer Start -->
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="footer-contact">
                    <h2>información </h2>
                    <p><i class="fa fa-phone-alt"></i>+777 777 7777</p>
                    <p><i class="fa fa-envelope"></i>ejemplo@ejemplo.com</p>
                    <a href="anular_cliente.php">Dejar de recibir información</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-link">
                    <h2>Links más usados</h2>
                    <a href="about.php">Sobre nosotros</a>
                    <a href="contact.php">Contactanos</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-link">
                    <h2>Links utiles</h2>
                    <a href="datos_personales.txt" target="_blank">Política de tratamiento de datos personales</a>
                    <a href="manual_usuario.txt" target="_blank">Manual usuario</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-newsletter">
                    <h2>Recibir información?</h2>
                    <form method="POST" action="">
                        <input class="form-control" name="nombre" placeholder="Nombre completo">
                        <input class="form-control" name="email" placeholder="Email">
                        <input class="form-control" name="id" placeholder="Identificacion">
                        <input class="form-control" name="direccion" placeholder="Direccion">
                        <input class="form-control" name="celular" placeholder="Celular">
                        <label>Acepta la <a href="datos_personales.html" target="_blank">política de tratamiento de datos personales</a></label>
                        <input type="checkbox" name="checkbox">
                        <button class="btn btn-custom">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="js/no_reenvio.js"></script>
</div>
<!-- Footer End -->