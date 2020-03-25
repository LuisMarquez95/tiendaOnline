<?php
session_start();
$mensaje = "";
if(isset($_POST['btnAccion'])){
    switch ($_POST['btnAccion']){
        case 'Agregar':
            if (is_numeric(openssl_decrypt($_POST['id'], COD, KEY))){
                $id = openssl_decrypt($_POST['id'], COD, KEY);

            }else{
                $mensaje .= "UPS.. ID NO CORRECTO";
            }
            if (is_string(openssl_decrypt($_POST['nombre'], COD, KEY))){
                $producto = openssl_decrypt($_POST['nombre'], COD, KEY);

            }else{
                $mensaje .=" Nombre del prodcuto Incorrecto";
            }
            if(is_numeric(openssl_decrypt($_POST['precio'], COD, KEY))){
                $precio = openssl_decrypt($_POST['precio'], COD, KEY);

            }else{
                $mensaje.= "Error del precio";
            }
            if(is_numeric(openssl_decrypt($_POST['cantidad'], COD, KEY))){
                $cantidad = openssl_decrypt($_POST['cantidad'], COD, KEY);

            }else{
                $mensaje.= "Error de la cantidad";
            }
            if(!isset($_SESSION['CARRITO'])){
                $producto = array(
                    'ID' => $id,
                    'NOMBRE' => $producto,
                    'CANTIDAD' => $cantidad,
                    'PRECIO' => $precio
                );
                $_SESSION['CARRITO'][0] = $producto;
                $mensaje = "Producto Agregado correctamente";
            }else{
                $idProductos = array_column($_SESSION['CARRITO'], "ID");
                if(in_array($id, $idProductos)){
                    $mensaje = "El producto ya esta en tu carrito";
                }else {
                    $numeroproducto = count($_SESSION['CARRITO']);
                    $producto = array(
                        'ID' => $id,
                        'NOMBRE' => $producto,
                        'CANTIDAD' => $cantidad,
                        'PRECIO' => $precio
                    );
                    $_SESSION['CARRITO'][$numeroproducto] = $producto;
                    $mensaje = "Producto Agregado correctamente";
                }
            }
           // $mensaje = print_r($_SESSION, true);
            break;
        case 'Eliminar':
            if (is_numeric(openssl_decrypt($_POST['id'], COD, KEY))){
                $ID = openssl_decrypt($_POST['id'], COD, KEY);
                foreach ($_SESSION['CARRITO'] as $indice => $producto){
                    if($producto['ID'] == $ID) {
                        unset($_SESSION['CARRITO'][$indice]);
                        echo "<script>
                                alert('ELEMENTO ELIMINADO');
                            </script>";
                    }
                }
            }else{
                echo "Error";
            }
            break;
        case'proceder':
            break;
    }
}