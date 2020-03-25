<?php
include 'global/config.php';
include  'carrito.php';
include 'template/cabecera.php'
?>
<br>
<h3>Lista del carrito</h3>
<?php if(!empty($_SESSION['CARRITO'])){?>
<table class="table table-light">
    <tbody>
        <tr>
            <th width="40%">Descripción</th>
            <th width="15%">Cantidad</th>
            <th width="20%">Precio</th>
            <th width="20%">Total</th>
            <th width="5%">--</th>
        </tr>
        <?php
        $total = 0;
        foreach ($_SESSION['CARRITO'] as $index => $producto){ ?>
        <tr>
            <td width="40%"><?php echo $producto['NOMBRE']?></td>
            <td width="15%"><?php echo $producto['CANTIDAD']?></td>
            <td width="20%"><?php echo $producto['PRECIO']?></td>
            <td width="20%"><?php echo number_format($producto['PRECIO'] * $producto['CANTIDAD'])?></td>
            <td width="5%">
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo openssl_encrypt($producto['ID'], COD, KEY) ?>">
                    <button
                        class="btn btn-danger"
                        type="submit"
                        name="btnAccion"
                        value="Eliminar">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php
            $total = $total+($producto['PRECIO'] * $producto['CANTIDAD']);
        }
        ?>
        <tr>
            <td colspan="3" align="right"><h3>TOTAL</h3></td>
            <td align="right"><h3>$<?php echo number_format($total, 2) ?></h3></td>
            <td></td>
        </tr>
    <tr>
        <td colspan="5">
            <div class="alert alert-success" role="alert">
                <label for="" class="text-center">Datos para enviar tu carrito</label>
                <form action="pagar.php" method="post">
                    <div class="form-group">
                        <label for="email">Correo de contacto</label>
                        <input type="email" name="email" id="mail" placeholder="tu email" class="form-control">
                    </div>
                    <div class="form-group">
                        <button
                            type="submit"
                            class="btn btn-success btn-block"
                            name="btnAccion"
                            value="proceder">Pagar carrito >></button>
                    </div>
                </form>
            </div>
        </td>
    </tr>
    </tbody>

</table>
<?php } else{ ?>
    <div class="alert alert-danger" role="alert">
        Sin producto por el momento
    </div>
<?php } ?>
<?php include 'template/pie.php' ?>
