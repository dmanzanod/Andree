<?php
$usu = $_POST["usu"];
$pass = $_POST["pass"];

$server = "localhost";
$username = "andree";
$password = "andree";
$database = "andreeBienestar";

    $con = mysqli_connect('ec2-44-204-145-91.compute-1.amazonaws.com','zazudb2','zazu2023','bd_andree');
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    
    mysqli_select_db($con,"bd_andree");
    
    $sql = "SELECT email FROM tbl_users WHERE user='".$usu."' AND password='".$pass."'";

    if ($result = mysqli_query($con, $sql)) {
        $row_cnt = mysqli_num_rows($result);
        if($row_cnt == 1)
        {
            echo 1;
            }else{
            echo 2;
        }
    }
    
mysqli_close($con);
?>