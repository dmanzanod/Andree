<?php
    $con = mysqli_connect('ec2-52-90-113-228.compute-1.amazonaws.com','zazudb2','zazu2023','bd_andree');
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    
    $id = $_GET['op'];
    
    mysqli_select_db($con,"bd_andree");
    

    $return_arr = array();
    $sql1="SELECT pkit_puntos.valor_estacionamiento, pkit_solicitudes.idDireccion, pkit_solicitudes.fechaInicio, pkit_solicitudes.fechaTermino, pkit_solicitudes.horaInicio, pkit_solicitudes.horaTermino, pkit_solicitudes.estadoSolicitud,  pkit_solicitudes.fechaInicioServicio FROM pkit_solicitudes, pkit_puntos WHERE pkit_solicitudes.idDireccion = pkit_puntos.nombre AND idUsuario = '".$id."'";
    $result1 = mysqli_query($con,$sql1);
    
// comentarios.add(new ListElementConfirmacion("12xMin", "<h3>Napoleón 345</h3><p>Las Condes, Santiago", "08/03/20", "ENVIADO", R.drawable.confirmacion_invite));
    
    while($row1 = mysqli_fetch_array($result1)) {
        
               $row_array['valor_estacionamiento'] = $row1['valor_estacionamiento'];
               $row_array['idDireccion'] = $row1['idDireccion'];
               $row_array['fechaInicio'] = $row1['fechaInicio'];
               $row_array['fechaTermino'] = $row1['fechaTermino'];
               $row_array['horaInicio'] = $row1['horaInicio'];
               $row_array['horaTermino'] = $row1['horaTermino'];
               $row_array['fechaInicioServicio'] = $row1['fechaInicioServicio'];
               $row_array['fechaTerminoServicio'] = $row1['fechaTerminoServicio'];
               $row_array['estadoSolicitud'] = $row1['estadoSolicitud'];
               
               array_push($return_arr,$row_array);
    }
    
    mysqli_close($con);

echo json_encode($return_arr);

?>