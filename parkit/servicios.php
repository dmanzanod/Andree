<?php
    $con = mysqli_connect('localhost','andree','andree','andreeBienestar');
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    
    $calle = $_GET['op'];
    
    mysqli_select_db($con,"andreeBienestar");
    
    $sql="SELECT id FROM pkit_puntos where nombre ='".$calle."'";
    
    $result = mysqli_query($con,$sql);
    
    $return_arr = array();
    
    while($row = mysqli_fetch_array($result)) {
        $id = $row['id'];
    }

    $sql1="SELECT nombre FROM pkit_servicios WHERE idDireccion =".$id;

    $result1 = mysqli_query($con,$sql1);
    
    while($row1 = mysqli_fetch_array($result1)) {
        
               $row_array['nombreservicio'] = $row1['nombre'];
               
               array_push($return_arr,$row_array);
    }
    
    mysqli_close($con);

echo json_encode($return_arr);

?>