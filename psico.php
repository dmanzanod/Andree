<?php
$con = mysqli_connect('ec2-52-90-113-228.compute-1.amazonaws.com','zazudb2','zazu2023','bd_andree');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"bd_andree");
$sql = "SELECT saldo_anterior from frm_historic where nro_folio = '".$_GET['folio']."';";
$result = mysqli_query($con,$sql);

$row = mysqli_num_rows($result);


if ($row != 0)
{
    while($row = mysqli_fetch_array($result)) {
        echo $row['saldo_anterior'];
    }
    
}else{
    
    $sql1="SELECT mnt_UF_psico FROM tbl_asegurado WHERE rut_asegurado = '".$_GET['rut']."' Limit 1;";
    $result1 = mysqli_query($con,$sql1);


    while($row1 = mysqli_fetch_array($result1)) {
        echo $row1['mnt_UF_psico'];
    }

}

mysqli_free_result($result);
mysqli_free_result($result1);



mysqli_close($con);
?>