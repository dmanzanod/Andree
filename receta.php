<?php
$con = mysqli_connect('ec2-52-90-113-228.compute-1.amazonaws.com','zazudb2','zazu2023','bd_andree');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"bd_andree");



$sql="SELECT saldo_anterior_receta from frm_historic where nro_folio = '".$_GET['folio']."';";
$result = mysqli_query($con,$sql);


$row = mysqli_num_rows($result);
echo $row;

if ($row)
{
        while($row = mysqli_fetch_array($result)) {
            echo $row['saldo_anterior_receta'];
        }
    
}

mysqli_free_result($result);

mysqli_close($con);
?>