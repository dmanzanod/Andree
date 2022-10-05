<?php
    $con = mysqli_connect('localhost','andree','andree','andreeBienestar');
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    
    $f = $_GET['op'];
    
    mysqli_select_db($con,"andreeBienestar");
    
    $sql="SELECT foto FROM pkit_fotos where direccion = '".$f."'";
    
    $result = mysqli_query($con,$sql);
    
    $return_arr = array();
    
    while($row = mysqli_fetch_array($result)) {

        $row_array['foto'] = $row['foto'];    
        
        array_push($return_arr,$row_array);
    }
    
    //$res = array($desc, $views);
    
    mysqli_close($con);

//echo json_encode($res);
echo json_encode($return_arr);


?>