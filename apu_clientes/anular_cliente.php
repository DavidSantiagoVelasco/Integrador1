<?php
if (!empty($_POST['nombre_cliente']) && !empty($_POST['email_cliente']) && !empty($_POST['id_cliente'])) {
    include_once "conexion.php";
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre_cliente']);
    $email = mysqli_real_escape_string($conn, $_POST['email_cliente']);
    $id = mysqli_real_escape_string($conn, $_POST['id_cliente']);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $cliente = mysqli_query($conn, "SELECT * FROM clientes WHERE email LIKE '$email' AND identificacion LIKE '$id'");
        $nr = mysqli_num_rows($cliente);
        if ($nr == 1) {
            $data = mysqli_fetch_array($cliente);
            if ($data['estado'] == 'I') {
                echo '<script language="javascript">alert("El usuario no se encuentra activo");</script>';
            } else {
                $eliminar = mysqli_query($conn, "UPDATE clientes SET estado = 'I' WHERE email LIKE '$email' AND identificacion LIKE '$id'");
                if ($eliminar) {
                    echo '<script language="javascript">alert("Éxito. Ya no recibirá más información");</script>';
                } else {
                    echo '<script language="javascript">alert("Ocurrió un error. No se pudo completar la acción con éxito");</script>';
                }
            }
        } else {
            echo '<script language="javascript">alert("Usuario no encontrado");</script>';
        }
    } else {
        echo '<script language="javascript">alert("Email no válido");</script>';
    }
    mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>AutoWash - Car Wash Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free Website Template" name="keywords">
    <meta content="Free Website Template" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <?php include "includes.php" ?>
</head>

<body>
    <!-- Top Bar Start -->
    <div class="top-bar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 col-md-12">
                    <div class="logo">
                        <a href="index.php">
                            <h1>Auto<span>Parts</span></h1>
                        </a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7 d-none d-lg-block">
                    <div class="row">
                        <div class="col-4">

                        </div>
                        <div class="col-4">
                            <div class="top-bar-item">
                                <div class="top-bar-icon">
                                    <i class="fa fa-phone-alt"></i>
                                </div>
                                <div class="top-bar-text">
                                    <h3>Contacto</h3>
                                    <p>+77 7777 777</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="top-bar-item">
                                <div class="top-bar-icon">
                                    <i class="far fa-envelope"></i>
                                </div>
                                <div class="top-bar-text">
                                    <h3>Email</h3>
                                    <p>ejemplos@example.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Top Bar End -->
    <!-- Nav Bar Start -->
    <div class="nav-bar">
        <div class="container">
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
                <a href="#" class="navbar-brand">MENU</a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto">
                        <a href="index.php" class="nav-item nav-link active">Inicio</a>
                        <a href="about.php" class="nav-item nav-link">Nosotros</a>
                        <a href="productos.php" class="nav-item nav-link">Productos</a>
                        <a href="contact.php" class="nav-item nav-link">Contact</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Nav Bar End -->
    <br><br>
    <div class="container">
        <div class="col-lg-3 col-md-6">
            <div class="footer-newsletter">
                <h2>Dejar de recibir información</h2>
                <form method="POST" action="anular_cliente.php">
                    <input class="form-control" name="nombre_cliente" placeholder="Nombre completo">
                    <input class="form-control" name="email_cliente" placeholder="Email">
                    <input class="form-control" name="id_cliente" placeholder="Identificacion">
                    <button class="btn btn-custom">Enviar</button>
                </form>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

    <!-- Back to top button -->
    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

    <!-- Pre Loader -->
    <div id="loader" class="show">
        <div class="loader"></div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>