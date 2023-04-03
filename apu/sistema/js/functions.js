
$(document).ready(function () {

    //Buscar producto en crear_orden
    $('#txt_cod_producto').keyup(function (e) {
        e.preventDefault();

        var producto = $(this).val();
        var action = 'infoProducto';

        if (producto != '') {
            $.ajax({
                url: 'ajax.php',
                type: "POST",
                async: true,
                data: { action: action, producto: producto },
                success: function (response) {
                    if (response != 'error') {
                        var info = JSON.parse(response);
                        $('#txt_nombre').html(info.nombre);
                        $('#txt_stock').html(info.stock);
                        $('#txt_cantidad').val('1');
                        $('#txt_precio').html(info.precio);
                        $('#txt_precio_total').html(info.precio);

                        $('#txt_cantidad').removeAttr('disabled');
                        if (info.stock > 0) {
                            $('#add_product_venta').slideDown();
                        }

                    } else {
                        $('#txt_nombre').html('-');
                        $('#txt_stock').html('-');
                        $('#txt_cantidad').val('0');
                        $('#txt_precio').html('0.00');
                        $('#txt_precio_total').html('0.00');

                        $('#txt_cantidad').attr('disabled', 'disabled');
                        $('#add_product_venta').slideUp();
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        } else {
            $('#txt_nombre').html('-');
            $('#txt_stock').html('-');
            $('#txt_cantidad').val('0');
            $('#txt_precio').html('0.00');
            $('#txt_precio_total').html('0.00');

            $('#txt_cantidad').attr('disabled', 'disabled');
            $('#add_product_venta').slideUp();
        }
    });

    //Invalidar botón agregar
    $('#txt_cantidad').keyup(function (e) {
        e.preventDefault();

        var precio_total = $(this).val() * $('#txt_precio').html();
        $('#txt_precio_total').html(precio_total);

        if ($(this).val() < 1 || isNaN($(this).val()) || $(this).val() > parseInt($('#txt_stock').html())) {
            $('#add_product_venta').slideUp();
        } else {
            $('#add_product_venta').slideDown();
        }
    });


    //Agregar producto a orden temporal
    $('#add_product_venta').click(function (e) {
        e.preventDefault();

        if ($('#txt_cantidad').val() > 0) {

            var codproducto = $('#txt_cod_producto').val();
            var cantidad = $('#txt_cantidad').val();
            var action = 'addProductoDetalle';

            $.ajax({
                url: 'ajax.php',
                type: "POST",
                async: true,
                data: { action: action, producto: codproducto, cantidad: cantidad },
                success: function (response) {
                    if (response != 'error') {
                        var info = JSON.parse(response);
                        $('#detalle_venta').html(info.tabla);
                        $('#detalle_total').html(info.total);

                        $('#txt_cod_producto').val('');
                        $('#txt_nombre').html('-');
                        $('#txt_stock').html('-');
                        $('#txt_cantidad').val('0');
                        $('#txt_precio').html('0.00');
                        $('#txt_precio_total').html('0.00');

                        $('#txt_cantidad').attr('disabled', 'disabled');
                        $('#add_product_venta').slideUp();
                    } else {
                        console.log(response);
                    }
                    btnCrearOrden();
                },
                error: function (error) {
                    console.log(error);
                }
            });

        }
    });

    //Anular venta - Eliminar todos los registros de la tabla temporal
    $('#btn_anular_venta').click(function (e) {
        e.preventDefault();

        var rows = $('#detalle_venta tr').length;

        if (rows > 0) {

            var action = 'anularOrden';

            $.ajax({
                url: 'ajax.php',
                type: "POST",
                async: true,
                data: { action: action },
                success: function (response) {
                    if (response != 'error') {
                        location.reload();
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });

        }
    });


    //Crear orden
    $('#btn_facturar_venta').click(function (e) {
        e.preventDefault();

        var rows = $('#detalle_venta tr').length;

        if (rows > 0) {

            var action = 'crearOrden';

            $.ajax({
                url: 'ajax.php',
                type: "POST",
                async: true,
                data: { action: action },
                success: function (response) {
                    if (response != 'error') {
                        var info = JSON.parse(response);
                        alert('Se ha creado la orden exitosamente');
                        $url = 'facturar.php?id=' + info.id_orden;
                        window.open($url);
                        location.reload();
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });

        }
    });

    // Anular orden
    $('.anular_factura').click(function (e) {
        e.preventDefault();
        var no_orden = $(this).attr('num');
        var action = 'anularFactura';

        if (confirm('¿Desea anular la orden No.' + no_orden + '?')) {
            $.ajax({
                url: 'ajax.php',
                type: "POST",
                async: true,
                data: { action: action, no_orden: no_orden },
                success: function (response) {
                    if (response != 'error') {
                        alert('Orden anulada exitosamente');
                        location.reload();
                    } else {
                        alert('No se pudo anular la orden');
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

    });

    // Ver detalles orden
    $('.view_factura').click(function (e) {
        e.preventDefault();
        var no_orden = $(this).attr('num');
        var action = 'ver_orden';

        $.ajax({
            url: 'ajax.php',
            type: "POST",
            async: true,
            data: { action: action, no_orden: no_orden },
            success: function (response) {
                if (response != 'error') {
                    var info = JSON.parse(response);
                    $('#all_ordenes').hide();
                    $('#tabla_orden').show();
                    $('#detalle_orden').html(info.orden);
                    $('#tabla_productos').show();
                    $('#productos_orden').html(info.productos);
                    $('#btn_volver').show();

                } else {
                    alert('No se pudo ver la orden');
                }
            },
            error: function (error) {
                console.log(error);
            }
        });

    });

    // Volver a todas las órdenes
    $('#btn_volver').click(function (e) {
        $('#all_ordenes').show();
        $('#tabla_orden').hide();
        $('#tabla_productos').hide();
        $('#btn_volver').hide();
    });

    // Ver historial de precios
    $('#btnhistorial').click(function (e) {
        e.preventDefault();
        var id = $('#id').val();
        var action = 'historial_productos';

        $.ajax({
            url: 'ajax.php',
            type: "POST",
            async: true,
            data: { action: action, id: id },
            success: function (response) {
                if (response != 'error') {
                    var info = JSON.parse(response);
                    $('#form').hide();
                    $('#tabla_orden').show();
                    $('#detalle_orden').html(info);
                    $('#btn_volver_historial').show();

                } else {
                    alert('ID incorrecto');
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    // Volver historial de precios
    $('#btn_volver_historial').click(function (e) {
        $('#form').show();
        $('#tabla_orden').hide();
        $('#btn_volver_historial').hide();
    });

    // Ver ingresos - egresos
    $('#buscar_ingresos').click(function (e) {
        var desde = $('#fecha_de').val();
        var hasta = $('#fecha_a').val();
        var action = "ingresos_egresos"
        if (desde != "" && hasta != "") {
            $.ajax({
                url: 'ajax.php',
                type: "POST",
                async: true,
                data: { action: action, desde: desde, hasta: hasta},
                success: function (response) {
                    if (response != 'error') {
                        var info = JSON.parse(response);
                        $('#tabla_ingresos').show();
                        $('#body_ingresos').html(info.lista);
                        $('#totales').show();
                        $('#body_totales').html(info.totales);
                        $('#informe_ingresos').show();
                    } else {
                        alert('No existen ingresos/egresos en la fecha ingresada');
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        } else {
            alert("Debe ingresar las fechas")
        }
    });

    $('.despachar').click(function (e) {
        e.preventDefault();
        var no_orden = $(this).attr('num');
        var action = 'despachar';

        $.ajax({
            url: 'ajax.php',
            type: "POST",
            async: true,
            data: { action: action, id: no_orden },
            success: function (response) {
                if (response != 'error') {
                    alert('Orden despachada exitosamente');
                    location.reload();
                } else {
                    alert('No se despachar la orden');
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    // Generar informe de productos disponibles
    $('#informe_productos').click(function (e) {
        window.open("informe_productos.php");
    });

    // Generar informe de los clientes
    $('#informe_clientes').click(function (e) {
        window.open("informe_clientes.php");
    });

    // Generar informe de ingresos_egresos
    $('#informe_ingresos').click(function (e) {
        window.print();
    });

    //Termina el ready
});


//Función mostrar el detalle temp de la orden del usuario
function mostrarDetalleTemp(id) {
    var action = 'mostrarDetalleTemp';
    var user = id;

    $.ajax({
        url: 'ajax.php',
        type: "POST",
        async: true,
        data: { action: action, user: user },
        success: function (response) {
            if (response != 'error') {
                var info = JSON.parse(response);
                $('#detalle_venta').html(info.tabla);
                $('#detalle_total').html(info.total);
            }
            btnCrearOrden();
        },
        error: function (error) {
            console.log(error);
        }
    });
}


// Función eliminar un producto del detalle temp
function del_producto_detalle(id, id_producto, cantidad) {
    var action = 'del_producto_detalle';
    var id = id;
    var id_producto = id_producto;
    var cantidad = cantidad;

    $.ajax({
        url: 'ajax.php',
        type: "POST",
        async: true,
        data: { action: action, id: id, id_producto: id_producto, cantidad: cantidad },
        success: function (response) {
            if (response != 'error') {
                var info = JSON.parse(response);
                $('#detalle_venta').html(info.tabla);
                $('#detalle_total').html(info.total);

                $('#txt_cod_producto').val('');
                $('#txt_nombre').html('-');
                $('#txt_stock').html('-');
                $('#txt_cantidad').val('0');
                $('#txt_precio').html('0.00');
                $('#txt_precio_total').html('0.00');

                $('#txt_cantidad').attr('disabled', 'disabled');
                $('#add_product_venta').slideUp();
            } else {
                $('#detalle_venta').html('');
                $('#detalle_total').html('');
            }

            btnCrearOrden();
        },
        error: function (error) {
            console.log(error);
        }
    });

}


// Ocultar el botón crear orden
function btnCrearOrden() {
    if ($('#detalle_venta tr').length > 0) {
        $('#btn_facturar_venta').show();
    } else {
        $('#btn_facturar_venta').hide();
    }
}

// Obtener factura
function obtener_factura(id) {
    var no_orden = id;
    var action = 'imprimir_factura';

    $.ajax({
        url: 'ajax.php',
        type: "POST",
        async: true,
        data: { action: action, no_orden: no_orden },
        success: function (response) {
            if (response != 'error') {
                var info = JSON.parse(response);
                console.log(info);
                $('#detalle_orden_facturar').html(info.orden);
                $('#productos_orden_facturar').html(info.productos);
                $('#btn_volver').show();

            } else {
                alert('No se pudo ver la orden');
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}