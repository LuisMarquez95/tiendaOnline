<?php
$servidor = "mysql:dbname=".BD.";host=".SERVIDOR;
try {
    $pdo = new PDO($servidor, USUARIO, PASSWORD,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

}catch(PDOException $e){
    echo "<scritp>
            alert('error');
          </scritp>";
}