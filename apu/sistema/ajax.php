<?php

include "../conexion.php";
session_start();

if (!empty($_POST)) {

    $usuario = $_SESSION['usuario'];

    //Buscar producto
    if ($_POST['action'] == 'infoProducto') {
        $id = $_POST['producto'];

        $query = mysqli_query($conn, "SELECT nombre, stock, precio FROM productos WHERE id = '$id'");

        mysqli_close($conn);

        $result = mysqli_num_rows($query);

        if ($result > 0) {
            $data = mysqli_fetch_assoc($query);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            exit;
        }
        echo 'error';
        exit;
    }


    //Agregar producto a orden temporal
    if ($_POST['action'] == 'addProductoDetalle') {
        if (empty($_POST['producto']) || empty($_POST['cantidad'])) {
            echo 'error';
        } else {
            $codproducto = $_POST['producto'];
            $cantidad = $_POST['cantidad'];
            $usuario = $_SESSION['usuario'];

            mysqli_query($conn, "INSERT INTO no_repudio (usuario, accion) VALUES ('$usuario', 'Agregar a orden temporal producto: $codproducto ; cantidad: $cantidad')");
            $query = mysqli_query($conn, "CALL add_detalle_temp('$usuario', '$codproducto', $cantidad)");

            $result = mysqli_num_rows($query);

            $tabla = '';
            $total = 0;
            $array = array();

            if ($result > 0) {
                while ($data = mysqli_fetch_assoc($query)) {
                    $precio_total = round(($data['cantidad'] * $data['precio_venta']), 2);
                    $total = round(($total + $precio_total), 2);
                    $tabla .= '
                            <tr>
                            <td>' . $data['id_producto'] . '</td>
                            <td colspan="2">' . $data['nombre'] . '</td>
                            <td class="textright">' . $data['cantidad'] . '</td>
                            <td class="textright">' . $data['precio_venta'] . '</td>
                            <td class="textright">' . $precio_total . '</td>
                            <td class=""><a class="link_delete" href="#" onclick="event.preventDefault();
                                del_producto_detalle(' . $data['id'] . ', ' . $data['id_producto'] . ', ' . $data['cantidad'] . ');">Quitar</a></td>
                            </tr>';
                }
                $iva = $total * 0.19;
                $total_iva = $total + $iva;
                $tabla_total = '
                            <tr>
                                <td colspan="5" class="txtright">SUBTOTAL</td>
                                <td class="txtright">' . $total . '</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="txtright">IVA</td>
                                <td class="txtright">' . $iva . '</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="txtright">TOTAL</td>
                                <td class="txtright">' . $total_iva . '</td>
                            </tr>
                    ';

                $array['tabla'] = $tabla;
                $array['total'] = $tabla_total;


                echo json_encode($array, JSON_UNESCAPED_UNICODE);
            } else {
                echo 'error';
            }
            mysqli_close($conn);
        }
        exit;
    }


    //Mostrar detalle temp
    if ($_POST['action'] == 'mostrarDetalleTemp') {
        if (empty($_POST['user'])) {
            echo 'error';
        } else {
            $usuario = $_SESSION['usuario'];

            $query = mysqli_query($conn, "SELECT temp.id, temp.usuario, temp.cantidad, temp.precio_venta,
                 temp.id_producto, p.nombre FROM detalle_temp temp INNER JOIN productos p ON temp.id_producto = p.id
                WHERE usuario = '$usuario'");

            mysqli_query($conn, "INSERT INTO no_repudio (usuario, accion) VALUES ('$usuario', 'Ingreso Crear orden')");
            $result = mysqli_num_rows($query);

            $tabla = '';
            $total = 0;
            $array = array();

            if ($result > 0) {

                while ($data = mysqli_fetch_assoc($query)) {
                    $precio_total = round(($data['cantidad'] * $data['precio_venta']), 2);
                    $total = round(($total + $precio_total), 2);
                    $tabla .= '
                            <tr>
                            <td>' . $data['id_producto'] . '</td>
                            <td colspan="2">' . $data['nombre'] . '</td>
                            <td class="textright">' . $data['cantidad'] . '</td>
                            <td class="textright">' . $data['precio_venta'] . '</td>
                            <td class="textright">' . $precio_total . '</td>
                            <td class=""><a class="link_delete" href="#" onclick="event.preventDefault();
                            del_producto_detalle(' . $data['id'] . ', ' . $data['id_producto'] . ', ' . $data['cantidad'] . ');">Quitar</a></td>
                            </tr>';
                }

                $iva = $total * 0.19;
                $total_iva = $total + $iva;
                $tabla_total = '
                <tr>
                <td colspan="5" class="txtright">SUBTOTAL</td>
                <td class="txtright">' . $total . '</td>
            </tr>
            <tr>
                <td colspan="5" class="txtright">IVA</td>
                <td class="txtright">' . $iva . '</td>
            </tr>
            <tr>
                <td colspan="5" class="txtright">TOTAL</td>
                <td class="txtright">' . $total_iva . '</td>
            </tr>
                    ';

                $array['tabla'] = $tabla;
                $array['total'] = $tabla_total;

                echo json_encode($array, JSON_UNESCAPED_UNICODE);
            } else {
                echo 'error';
            }
            mysqli_close($conn);
        }
        exit;
    }


    //Anular factura
    if ($_POST['action'] == 'anularFactura') {

        $no_orden = $_POST['no_orden'];

        $query = mysqli_query($conn, "SELECT * FROM orden WHERE id_orden = $no_orden");
        $result = mysqli_num_rows($query);

        if ($result > 0) {
            mysqli_query($conn, "INSERT INTO no_repudio (usuario, accion) VALUES ('$usuario', 'Anular orden No. $no_orden')");
            $query_orden = mysqli_query($conn, "CALL anula_factura($no_orden)");
            $result_detalle = mysqli_num_rows($query_orden);

            if ($result_detalle > 0) {
                echo 'succes';
            } else {
                echo 'error';
            }
        } else {
            echo 'error';
        }
        mysqli_close($conn);
        exit;
    }


    //Imprimir factura
    if ($_POST['action'] == 'imprimir_factura') {
        if (empty($_POST['no_orden'])) {
            echo 'error';
        } else {
            $no_orden = $_POST['no_orden'];

            $query = mysqli_query($conn, "SELECT o.id_orden, o.fecha, o.usuario, 
                o.precio_total, o.impuestos, o.estado, d.cantidad, d.precio_venta, p.nombre FROM orden o 
                INNER JOIN  detalle_orden d ON o.id_orden = d.id_orden 
                INNER JOIN productos p ON d.id_producto = p.id WHERE o.id_orden = $no_orden");

            $result = mysqli_num_rows($query);

            $tabla = '';
            $array = array();

            if ($result > 0) {
                while ($data = mysqli_fetch_assoc($query)) {
                    $precio_total = round(($data['cantidad'] * $data['precio_venta'])+($data['cantidad'] * $data['precio_venta'])*0.19, 2);
                    $tabla .= '<tr>
                    <td>' . $data['nombre'] . '</td>
                    <td>' . $data['cantidad'] . '</td>
                    <td>' . $data['precio_venta'] . '</td>
                    <td>' . $data['precio_venta']*0.19 . '</td>
                    <td>' . $precio_total . '</td>
                    </tr>';
                    $tabla_orden = '<tr>
                    <td>' . $data['id_orden'] . '</td>
                    <td>' . $data['fecha'] . '</td>
                    <td>' . $data['usuario'] . '</td>
                    <td>' . $data['precio_total'] . '</td>
                    <td>' . $data['impuestos'] . '</td>
                    <td>';
                    if ($data['estado'] == 'A') {
                        $tabla_orden .= 'Pagada</td>
                        </tr>';
                    } elseif ($data['estado'] == 'C') {
                        $tabla_orden .= 'Anulada</td>
                        </tr>';
                    }
                }

                $array['productos'] = $tabla;
                $array['orden'] = $tabla_orden;

                mysqli_query($conn, "INSERT INTO no_repudio (usuario, accion) VALUES ('$usuario', 'Ver detalles orden No. $no_orden')");

                echo json_encode($array, JSON_UNESCAPED_UNICODE);
            } else {
                echo 'error';
            }
            mysqli_close($conn);
        }
        exit;
    }

    // Ver detalle de orden
    if ($_POST['action'] == 'ver_orden') {
        if (empty($_POST['no_orden'])) {
            echo 'error';
        } else {
            $no_orden = $_POST['no_orden'];

            $query = mysqli_query($conn, "SELECT o.id_orden, o.fecha, o.usuario, o.precio_compra_total,
                o.precio_total, o.impuestos, o.estado, d.cantidad, d.precio_compra, d.precio_venta, p.nombre FROM orden o 
                INNER JOIN  detalle_orden d ON o.id_orden = d.id_orden 
                INNER JOIN productos p ON d.id_producto = p.id WHERE o.id_orden = $no_orden");

            $result = mysqli_num_rows($query);

            $tabla = '';
            $array = array();

            if ($result > 0) {
                while ($data = mysqli_fetch_assoc($query)) {
                    $precio_total = round(($data['cantidad'] * $data['precio_venta'])+($data['cantidad'] * $data['precio_venta'])*0.19, 2);
                    $tabla .= '<tr>
                    <td>' . $data['nombre'] . '</td>
                    <td>' . $data['cantidad'] . '</td>
                    <td>' . $data['precio_compra'] . '</td>
                    <td>' . $data['precio_venta'] . '</td>
                    <td>' . $data['precio_venta']*0.19 . '</td>
                    <td>' . $precio_total . '</td>
                    </tr>';
                    $tabla_orden = '<tr>
                    <td>' . $data['id_orden'] . '</td>
                    <td>' . $data['fecha'] . '</td>
                    <td>' . $data['usuario'] . '</td>
                    <td>' . $data['precio_compra_total'] . '</td>
                    <td>' . $data['precio_total'] . '</td>
                    <td>' . $data['impuestos'] . '</td>
                    <td>';
                    if ($data['estado'] == 'A') {
                        $tabla_orden .= 'Pagada</td>
                        </tr>';
                    } elseif ($data['estado'] == 'C') {
                        $tabla_orden .= 'Anulada</td>
                        </tr>';
                    }
                }

                $array['productos'] = $tabla;
                $array['orden'] = $tabla_orden;

                mysqli_query($conn, "INSERT INTO no_repudio (usuario, accion) VALUES ('$usuario', 'Ver detalles orden No. $no_orden')");

                echo json_encode($array, JSON_UNESCAPED_UNICODE);
            } else {
                echo 'error';
            }
            mysqli_close($conn);
        }
        exit;
    }

    //Eliminar producto del detalle temp
    if ($_POST['action'] == 'del_producto_detalle') {
        if (empty($_POST['id'])) {
            echo 'error';
        } else {
            $id = $_POST['id'];
            $cantidad = $_POST['cantidad'];
            $id_producto = $_POST['id_producto'];
            mysqli_query($conn, "INSERT INTO no_repudio (usuario, accion) VALUES ('$usuario', 'Quitar de orden temporal producto: $id_producto ; cantidad: $cantidad');");
            $query = mysqli_query($conn, "CALL del_detalle_temp($id, '$usuario');");

            $result = mysqli_num_rows($query);

            $tabla = '';
            $total = 0;
            $array = array();

            if ($result > 0) {
                while ($data = mysqli_fetch_assoc($query)) {
                    $precio_total = round(($data['cantidad'] * $data['precio_venta']), 2);
                    $total = round(($total + $precio_total), 2);
                    $tabla .= '
                            <tr>
                            <td>' . $data['id_producto'] . '</td>
                            <td colspan="2">' . $data['nombre'] . '</td>
                            <td class="textright">' . $data['cantidad'] . '</td>
                            <td class="textright">' . $data['precio_venta'] . '</td>
                            <td class="textright">' . $precio_total . '</td>
                            <td class=""><a class="link_delete" href="#" onclick="event.preventDefault();
                            del_producto_detalle(' . $data['id'] . ', ' . $data['id_producto'] . ', ' . $data['cantidad'] . ');">Quitar</a></td>
                            </tr>';
                }

                $iva = $total * 0.19;
                $total_iva = $total + $iva;
                $tabla_total = '
                    <tr>
                        <td colspan="5" class="txtright">SUBTOTAL</td>
                        <td class="txtright">' . $total . '</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="txtright">IVA</td>
                        <td class="txtright">' . $iva . '</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="txtright">TOTAL</td>
                        <td class="txtright">' . $total_iva . '</td>
                    </tr>
                        ';

                $array['tabla'] = $tabla;
                $array['total'] = $tabla_total;

                echo json_encode($array, JSON_UNESCAPED_UNICODE);
            } else {
                echo 'error';
            }
            mysqli_close($conn);
        }
        exit;
    }

    // Eliminar todos los productos del detalle temp
    if ($_POST['action'] == 'anularOrden') {

        $usuario = $_SESSION['usuario'];

        $query = mysqli_query($conn, "DELETE FROM detalle_temp WHERE usuario = '$usuario'");
        mysqli_close($conn);
        if ($query) {
            echo 'succes';
        } else {
            echo 'error';
        }
    }

    // Crear orden
    if ($_POST['action'] == 'crearOrden') {

        $query = mysqli_query($conn, "SELECT * FROM detalle_temp WHERE usuario = '$usuario'");
        $result = mysqli_num_rows($query);

        if ($result > 0) {
            mysqli_query($conn, "INSERT INTO no_repudio (usuario, accion) VALUES ('$usuario', 'Crear orden')");
            $query_orden = mysqli_query($conn, "CALL procesar_orden('$usuario')");
            $result_detalle = mysqli_num_rows($query_orden);

            if ($result_detalle > 0) {
                $data = mysqli_fetch_assoc($query_orden);
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
            } else {
                echo 'error';
            }
        } else {
            echo 'error';
        }
        mysqli_close($conn);
        exit;
    }

    // Mostrar historial de precios
    if ($_POST['action'] == 'historial_productos') {
        $id = $_POST['id'];

        $query = mysqli_query($conn, "SELECT h.id_producto, p.nombre, h.usuario, h.fecha, h.precio_compra, h.precio
         FROM historial_precios h INNER JOIN productos p ON h.id_producto = p.id WHERE id_producto = '$id'");
        $result = mysqli_num_rows($query);

        $tabla = '';
        if ($result > 0) {
            while ($data = mysqli_fetch_assoc($query)) {
                $tabla .= '
                <tr>
                <td>' . $data['id_producto'] . '</td>
                <td>' . $data['nombre'] . '</td>
                <td>' . $data['usuario'] . '</td>
                <td>' . $data['precio_compra'] . '</td>
                <td>' . $data['precio'] . '</td>
                <td>' . $data['fecha'] . '</td>
                </tr>
                ';
            }

            mysqli_query($conn, "INSERT INTO no_repudio (usuario, accion) VALUES ('$usuario', 'Ver historial precios producto : $id')");
            echo json_encode($tabla, JSON_UNESCAPED_UNICODE);
        } else {
            echo 'error';
        }
        mysqli_close($conn);
        exit;
    }

    // Mostrar ingresos - egresos
    if ($_POST['action'] == 'ingresos_egresos') {
        $desde = $_POST['desde'];
        $hasta = $_POST['hasta'];
        $lista = '';
        $query = mysqli_query($conn, "SELECT * FROM ingresos_egresos WHERE fecha BETWEEN '$desde' AND '$hasta'");
        $result = mysqli_num_rows($query);
        if ($result > 0) {
            $array = array();
            while ($data = mysqli_fetch_assoc($query)) {
                $lista .= '<tr>
                <td>' . $data['usuario'] . '</td>
                <td>' . $data['ingreso'] . '</td>
                <td>' . $data['egreso'] . '</td>
                <td>' . $data['ganancia'] . '</td>
                <td>' . $data['impuestos'] . '</td>
                <td>' . $data['fecha'] . '</td>
                </tr>';
            }
            $query = mysqli_query($conn, "SELECT SUM(ingreso) AS ingreso, SUM(egreso) AS egreso, SUM(ganancia) AS ganancia, SUM(impuestos) AS impuestos 
            FROM ingresos_egresos WHERE fecha BETWEEN '$desde' AND '$hasta'");
            $data = mysqli_fetch_assoc($query);
            $totales = '<tr>
            <td>' . $data['ingreso'] . '</td>
            <td>' . $data['egreso'] . '</td>
            <td>' . $data['ganancia'] . '</td>
            <td>' . $data['impuestos'] . '</td>
            </tr>';
            $array['lista'] = $lista;
            $array['totales'] = $totales;
            mysqli_query($conn, "INSERT INTO no_repudio (usuario, accion) VALUES ('$usuario', 'Buscar ingresos-egresos desde: $desde ; hasta: $hasta')");
            echo json_encode($array, JSON_UNESCAPED_UNICODE);
        } else {
            echo 'error';
        }
        mysqli_close($conn);
        exit;
    }

    // Despachar factura
    if ($_POST['action'] == 'despachar') {
        $id = $_POST['id'];
        $query = mysqli_query($conn, "UPDATE orden SET estado = 'D' WHERE id_orden = '$id'");
        if($query){
            mysqli_query($conn, "INSERT INTO no_repudio (usuario, accion) VALUES ('$usuario', 'Despachar orden No. $id')");
            echo 'success';
        }else{
            echo 'error';
        }
        mysqli_close($conn);
    }
}

exit;
