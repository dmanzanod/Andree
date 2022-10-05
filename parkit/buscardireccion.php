<?php
    $con = mysqli_connect('localhost','andree','andree','andreeBienestar');
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    
    $f = $_GET['nombre'];
    $n = $_GET['clave'];
    
    mysqli_select_db($con,"andreeBienestar");
    
    $sql="SELECT nombre, lat, lon, descripcion_estacionamiento, valor_estacionamiento, disponible FROM pkit_puntos";
    
    $result = mysqli_query($con,$sql);
    
    $desc = array(); 
    $views = array();
    
    $return_arr = array();
    
    while($row = mysqli_fetch_array($result)) {
        //$desc[] = $row["nombre"]; // or smth like $row["video_title"] for title
        //$views[] = $row["lat"];
    
        $row_array['calle'] = $row['nombre'];
        $row_array['la'] = $row['lat'];
        $row_array['lo'] = $row['lon'];
        $row_array['detalle'] = $row['descripcion_estacionamiento'];
        $row_array['precio'] = $row['valor_estacionamiento'];
        $row_array['estado'] = $row['disponible'];
        
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