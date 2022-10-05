<?php

$json = file_get_contents('php://input');
$obj = json_decode($json);
$name = $obj->{'name'};
$email = $obj->{'email'};
$rut = $obj->{'rut'};
$fechaNac = $obj->{'fechaNac'};
$tel = $obj->{'tel'};
$contrasena = $obj->{'contrasena'};
$repitecontrasena = $obj->{'repitecontrasena'};

try 
{
    $bdd = new PDO('mysql:host=localhost;dbname=andreeBienestar;charset=utf8', 'andree', 'andree');
} catch (Exception $e) 
{
    die('Erreur : '.$e->getMessage());
}

$sql = $bdd->prepare(
'INSERT INTO pkit_usuarios (name, email, rut, fechaNac, tel, contrasena, repitecontrasena) 
VALUES (:name, :email, :rut, :fechaNac, :tel, :contrasena, :repitecontrasena)');
if (!empty($name)) {
    $sql->execute(array(
        'name' => $name,
        'email' => $email,
        'rut' => $rut,
        'fechaNac' => $fechaNac,
        'tel' => $tel,
        'contrasena' => $contrasena,
        'repitecontrasena' => $repitecontrasena));
}
//echo $sql;
//ALMACENO LOS DATOS EN FLOW

$secretKey = "56f638e5368f3281868b83700e211e1ec2078cf0";

$params = array( 
    "apiKey" => "2FFBECB9-9AB1-4BBC-8671-61B4F6LDEAC9",
    "email" => $email,
    "name" => $name,
    "externalId" => $email,
    "pay_mode" => "auto",
    "status" => 1
); 

$keys = array_keys($params);
sort($keys);

$toSign = "";
foreach($keys as $key) {
  $toSign .= $key . $params[$key];
};

//echo $toSign."<br/>";

$signature = hash_hmac('sha256', $toSign , $secretKey);

//echo $signature;

$url = 'https://www.flow.cl/api';
// Agrega a la url el servicio a consumir
$url = $url . '/customer/create';
//Agrega la firma a los parámetros

$params["s"] = $signature;

try {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
  
  // DESHABILITADO --- >    $response = curl_exec($ch);
  
  if($response === false) {
    $error = curl_error($ch);
    throw new Exception($error, 1);
  } 
  $info = curl_getinfo($ch);
  
  } catch (Exception $e) {
        echo 'Error: ' . $e->getCode() . ' - ' . $e->getMessage();
    }

?>