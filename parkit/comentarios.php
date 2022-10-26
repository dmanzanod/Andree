<?php
    $con = mysqli_connect('ec2-44-204-145-91.compute-1.amazonaws.com','zazudb2','zazu2023','bd_andree');
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    
    $calle = $_GET['op'];
    
    mysqli_select_db($con,"bd_andree");
    
    $sql="SELECT id FROM pkit_puntos where nombre ='".$calle."'";
    
    $result = mysqli_query($con,$sql);
    
    $return_arr = array();
    
    while($row = mysqli_fetch_array($result)) {
        $id = $row['id'];
    }

    $sql1="SELECT pkit_comentaios.detallecomentario, pkit_comentaios.calificacion, pkit_usuarios.fotoPerfil FROM pkit_comentaios, pkit_usuarios WHERE pkit_comentaios.idUsuario = pkit_usuarios.id and pkit_comentaios.idEstacionamiento=".$id;

    $result1 = mysqli_query($con,$sql1);
    
    while($row1 = mysqli_fetch_array($result1)) {
        
               $row_array['detallecomentario'] = $row1['detallecomentario'];
               $row_array['calificacion'] = $row1['calificacion'];
               $row_array['fotoPerfil'] = $row1['fotoPerfil'];
               
               array_push($return_arr,$row_array);
    }
    
    mysqli_close($con);

echo json_encode($return_arr);

?>