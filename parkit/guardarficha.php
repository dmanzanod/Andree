<?php

//{"codUsuario":"jperez@gmail.com","codMarker":"Calle uno 1024, San Miguel, Santiago","codFechaInicio":"27\/4\/2021","codFechaTermino":"27\/4\/2021","codHoraInicio":"27\/4\/2021","codHoraTermino":"27\/4\/2021"}

$json = file_get_contents('php://input');
$obj = json_decode($json);

$codUsuario = $obj->{'codUsuario'};
$codMarker = $obj->{'codMarker'};
$codFechaInicio = $obj->{'codFechaInicio'};
$codFechaTermino = $obj->{'codFechaTermino'};
$codHoraInicio = $obj->{'codHoraInicio'};
$codHoraTermino = $obj->{'codHoraTermino'};
$estado = 'NUEVA';

try 
{
    $bdd = new PDO('mysql:host=localhost;dbname=andreeBienestar;charset=utf8', 'andree', 'andree');
} catch (Exception $e) 
{
    die('Erreur : '.$e->getMessage());
}

$sql = $bdd->prepare(
'INSERT INTO pkit_solicitudes (idUsuario, idDireccion, fechaInicio, fechaTermino, horaInicio, horaTermino, estadoSolicitud) 
VALUES (:idUsuario, :idDireccion, :fechaInicio, :fechaTermino, :horaInicio, :horaTermino, :estadoSolicitud)');
if (!empty($codUsuario)) {
    $sql->execute(array(
        'idUsuario' => $codUsuario,
        'idDireccion' => $codMarker,
        'fechaInicio' => $codFechaInicio,
        'fechaTermino' => $codFechaTermino,
        'horaInicio' => $codHoraInicio,
        'horaTermino' => $codHoraTermino,
        'estadoSolicitud' => $estado));
}

?>