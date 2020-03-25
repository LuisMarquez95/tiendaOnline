<?php
include 'global/config.php';
include 'global/conexion.php';
include  'carrito.php';
include 'template/cabecera.php'
?>

<!-- It´s Container -->
<div class="container">
    <?php if($mensaje != ""){?>
    <div class="alert alert-success" role="alert">
        <?php echo $mensaje ?> <a href="mostrarCarrito.php"><button class="btn btn-success">Ver carrito</button></a>
    </div>
    <?php }?>
    <div class="row">
        <?php
            $sentencia  = $pdo->prepare("SELECT * FROM products");
            $sentencia->execute();
            $listaPorduct = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <?php foreach($listaPorduct as $producto){ ?>
            <div class="col-4">
                <div class="card" style="width: 18rem;">
                    <img
                        title="<?php echo $producto['Nombre'] ?>"
                        alt="<?php echo $producto['Nombre'] ?>"
                        src="<?php echo $producto['imagen'] ?>"
                        data-toggle="popover"
                        data-trigger="hover"
                        data-content="<?php echo $producto['Descripcion'] ?>"
                        class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $producto['Nombre'] ?></h5>
                        <p class="text-center"><?php echo "$".$producto['Precio']. " MXN" ?></p>
                        <form action="" method="post">
                            <input type="hidden" name="id" id="id" value="<?php echo openssl_encrypt($producto['id'], COD, KEY) ?>">
                            <input type="hidden" name="nombre" id="nombre" value="<?php echo openssl_encrypt($producto['Nombre'], COD, KEY) ?>">
                            <input type="hidden" name="precio" id="precio" value="<?php echo openssl_encrypt($producto['Precio'], COD, KEY) ?>">
                            <input type="hidden" name="cantidad" id="cantidad" value="<?php echo openssl_encrypt(1, COD, KEY) ?>">
                            <button class="btn btn-success"
                                    name ="btnAccion"
                                    value="Agregar"
                                    type="submit">
                                Agregar Al carrito
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php include 'template/pie.php' ?>