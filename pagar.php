
<?php
include 'global/config.php';
include 'global/conexion.php';
include  'carrito.php';
include 'template/cabecera.php'?>
<?php
if ($_POST){
    $total = 0;
    $correo = $_POST['email'];
    $SID = session_id();
    foreach ($_SESSION['CARRITO'] as $indice => $producto){
        $total = $total+($producto['PRECIO']*$producto['CANTIDAD']);
    }
    $sentencia = $pdo->prepare("INSERT INTO `ventas`(`id`, `ClaveTransaccion`, `PaypalDatos`, `fecha`, `correo`, `total`, `status`)
    VALUES (NULL,:claveTrans,'NoHAYDatos',CURRENT_TIMESTAMP ,:correo,:total,'Pendiente')");
    $sentencia->bindParam(":claveTrans", $SID);
    $sentencia->bindParam(':correo', $correo);
    $sentencia->bindParam(':total', $total);
    $sentencia->execute();
    $idVenta = $pdo->lastInsertId();
    foreach ($_SESSION['CARRITO'] as $indice => $producto){
        $sentencia = $pdo->prepare("INSERT INTO detallecompra  (`Id`, `Idventa`, `Idproducto`, `Preciounitario`, `Cantidad`, `Descargado`)
        VALUES (NULL, :idventa, :idproducto, :preciounitario, :cantidad, '0')");
        $sentencia->bindParam(':idventa', $idVenta);
        $sentencia->bindParam(':idproducto', $producto['ID']);
        $sentencia->bindParam(':preciounitario', $producto['PRECIO']);
        $sentencia->bindParam(':cantidad', $producto['CANTIDAD']);
        $sentencia->execute();
    }
    //echo "<h3>".$total."</h3>";
}
?>
<div class="jumbotron text-center">
    <!-- Include the PayPal JavaScript SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=Ab-TP6rl-UqxrOqc9QkkW07eNuSj0ksmiU0_i_SprwpeNdZ8NiqbEeSKqQIKE-n45YoSikJ68aBfDopf&currency=MXN"></script>
    <h1 class="display-4">¡PASO FINAL!</h1>
    <div id="paypal-button-container"></div>
    <hr class="my-4">
    <p class="lead"> Estas apunto de pagar con paypal la cantidad de:
        <h4>$ <?php echo number_format($total, 2) ?></h4>
    </p>
    <p>Los productos podrán ser descarhgados una vez que se procse el pago<br>
    <sctrong>(Para aclaraciones: unt@gmai.com)</sctrong>
    </p>


    <script>
        // Render the PayPal button into #paypal-button-container
        paypal.Buttons({

            // Set up the transaction
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?php echo $total ?>'
                        },
                        description: "Compra de productos a DoctorSystem: <?php echo number_format($total, 2) ; ?>",
                        custom: "<?php echo $SID  ?>#<?php echo openssl_encrypt($idVenta, COD, KEY);?>"
                    }]
                });
            },

            // Finalize the transaction
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // Show a success message to the buyer
                    //orderID: "2UR44572SP3443246"
                    //payerID: "PXDRK3FYDG4VW"
                    //facilitatorAccessToken:
                    //console.log(details);
                    //console.log(data);
                    //window.location ="verificador.php?paymenttoken="+data.facilitatorAccessToken+"&paymentID="+data.payerID;
                });
            },
            onShippingChange: function(data, actions) {
                /*if (data.shipping_address.country_code !== 'US') {
                    return actions.reject();
                }

                return actions.resolve();*/
                console.log(data);
            }


        }).render('#paypal-button-container');
    </script>

</div>
<?php include 'template/pie.php'?>
