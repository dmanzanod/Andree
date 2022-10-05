<?php
$con = mysqli_connect('localhost','andree','andree','andreeBienestar');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"andreeBienestar");
$sql="SELECT mnt_optico FROM tbl_asegurado WHERE rut_asegurado = '".$_GET['rut']."'";
$result = mysqli_query($con,$sql);

while($row = mysqli_fetch_array($result)) {
    echo $row['mnt_optico'];
}
mysqli_close($con);
?>