<?php
$con = mysqli_connect('ec2-3-87-203-241.compute-1.amazonaws.com','zazudb2','zazu2023','bd_andree');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"bd_andree");
$sql="SELECT mnt_optico FROM tbl_asegurado WHERE rut_asegurado = '".$_GET['rut']."'";
$result = mysqli_query($con,$sql);

while($row = mysqli_fetch_array($result)) {
    echo $row['mnt_optico'];
}
mysqli_close($con);
?>