<?php
    $con = mysqli_connect('ec2-44-204-145-91.compute-1.amazonaws.com','zazudb2','zazu2023','bd_andree');
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    
    $f = $_GET['nombre'];
    $n = $_GET['clave'];
    
    mysqli_select_db($con,"bd_andree");
    
    $sql="SELECT activo FROM pkit_usuarios WHERE email = '".$f."' and contrasena = '".$n."'";
    
    $result = mysqli_query($con,$sql);
    
    while($row = mysqli_fetch_array($result)) {
        $myObj->activo = $row['activo'];
    }
    mysqli_close($con);

$myJSON = json_encode($myObj);

echo $myJSON;
?>