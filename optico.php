<?php
$con = mysqli_connect('ec2-52-90-113-228.compute-1.amazonaws.com','zazudb2','zazu2023','bd_andree');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"bd_andree");
//$sql="SELECT mnt_optico FROM tbl_asegurado WHERE rut_asegurado = '".$_GET['rut']."'";
$sql="SELECT cristales_opticos_saldo from frm_historic where nro_folio = '".$_GET['rut']."';";
$result = mysqli_query($con,$sql);

while($row = mysqli_fetch_array($result)) {
    echo $row['cristales_opticos_saldo'];
}
mysqli_close($con);
?>