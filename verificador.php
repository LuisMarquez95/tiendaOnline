<?php
///print_r($_GET);
$clienId = "Ab-TP6rl-UqxrOqc9QkkW07eNuSj0ksmiU0_i_SprwpeNdZ8NiqbEeSKqQIKE-n45YoSikJ68aBfDopf";
$secret = "EDQz07uPhQQ3d1Om5Om449DFIQpvCrCcxcf5kBMAt-SSNsSrQhY6ivLtIFXQ4-GqhTcK216l33Fapc1t";
$login = curl_init("https://api.sandbox.paypal.com/v1/oauth2/token");
curl_setopt($login, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($login, CURLOPT_USERPWD, $clienId.":".$secret);
curl_setopt($login, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

$Response = curl_exec($login);
//print_r($Response);
$objeto = json_decode($Response);
$accestoken = $objeto->access_token;
//$venta = curl_init("https://api.sandbox.paypal.com/v2/payments/authorizations/".$_GET['paymentID']);
//curl_setopt($venta, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer".$accestoken));
//$responseVenta = curl_exec($venta);
//print_r($responseVenta);
$venta = curl_init("https://api.sandbox.paypal.com/v2/payments/authorizations/".$_GET['paymentID']);
curl_setopt($venta, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer".$accestoken));
$responseVenta = curl_exec($venta);
print_r($responseVenta);
