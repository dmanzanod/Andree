<?php
//$con = mysqli_connect('ec2-52-90-113-228.compute-1.amazonaws.com','zazudb2','zazu2023','bd_andree');
$con = mysqli_connect('roundhouse.proxy.rlwy.net:23957','root','dDbFeEd4C5-5-C5fgFb4ECdEbhD5A5C6','bd_andree');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"bd_andree");
$sql="SELECT mnt_UF_asegurado FROM tbl_asegurado WHERE rut_asegurado = '".$_GET["rut_asegurado"]."'";
$result = mysqli_query($con,$sql);

while($row = mysqli_fetch_array($result)) {
    echo $row['mnt_UF_asegurado'];
}
mysqli_close($con);
?>
