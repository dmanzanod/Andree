<?php
$con = mysqli_connect('localhost','andree','andree','andreeBienestar');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"andreeBienestar");
$sql="SELECT folio_number FROM folio";
$result = mysqli_query($con,$sql);

while($row = mysqli_fetch_array($result)) {
    echo $row['folio_number'];
}
mysqli_close($con);
?>