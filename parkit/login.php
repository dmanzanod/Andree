<?php
    $con = mysqli_connect('localhost','andree','andree','andreeBienestar');
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    
    $f = $_GET['nombre'];
    $n = $_GET['clave'];
    
    mysqli_select_db($con,"andreeBienestar");
    
    $sql="SELECT activo FROM pkit_usuarios WHERE email = '".$f."' and contrasena = '".$n."'";
    
    $result = mysqli_query($con,$sql);
    
    while($row = mysqli_fetch_array($result)) {
        $myObj->activo = $row['activo'];
    }
    mysqli_close($con);

$myJSON = json_encode($myObj);

echo $myJSON;
?>