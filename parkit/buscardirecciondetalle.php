<?php
    $con = mysqli_connect('ec2-52-90-113-228.compute-1.amazonaws.com','zazudb2','zazu2023','bd_andree');
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    
    $f = $_GET['op'];
    
    mysqli_select_db($con,"bd_andree");
    
    $sql="SELECT nombre, descripcion_estacionamiento, valor_estacionamiento FROM pkit_puntos WHERE nombre = '".$f."' LIMIT 1";
    
    $result = mysqli_query($con,$sql);
    
    $return_arr = array();
    
    while($row = mysqli_fetch_array($result)) {
        //$desc[] = $row["nombre"]; // or smth like $row["video_title"] for title
        //$views[] = $row["lat"];
    
        $row_array['detalle'] = $row['descripcion_estacionamiento'];
        $row_array['precio'] = $row['valor_estacionamiento'];
        
            $sql1="SELECT foto FROM pkit_fotos Where direccion = '".$row['nombre']."' LIMIT 1";
            $result1 = mysqli_query($con,$sql1);
            while($row1 = mysqli_fetch_array($result1)) {
                   $row_array['foto'] = $row1['foto'];
            }
        
        array_push($return_arr,$row_array);
    }
    
    //$res = array($desc, $views);
    
    mysqli_close($con);

//echo json_encode($res);
echo json_encode($return_arr);

?>