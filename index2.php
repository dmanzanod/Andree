<?php 
session_start();

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      $mypasswordOLD = $_POST['passold'];
      $mypasswordNEW = $_POST['passnew']; 
      
        $con = mysqli_connect('ec2-52-90-113-228.compute-1.amazonaws.com','zazudb2','zazu2023','bd_andree');
        if (!$con) {
            die('Could not connect: ' . mysqli_error($con));
        }
    
        mysqli_select_db($con,"bd_andree");
      
        $sql = "SELECT id, nuevo FROM tbl_users WHERE user = '".$_SESSION['login_user']."' and password = '".$mypasswordOLD."' and active='1' and nuevo='1'";
        $result = mysqli_query($con,$sql);
        $rowcount = mysqli_num_rows($result);
        
        mysqli_close($con);
		
        if($rowcount == 1) {
				$con = mysqli_connect('ec2-52-90-113-228.compute-1.amazonaws.com','zazudb2','zazu2023','bd_andree');
                if (!$con) {
                    die('Could not connect: ' . mysqli_error($con));
                }
    
                mysqli_select_db($con,"bd_andree");
        
                $sql = "UPDATE tbl_users SET password = '".$mypasswordNEW."', nuevo='0' WHERE user = '".$_SESSION['login_user']."'";
                $result = mysqli_query($con,$sql);
                
        }
        header("location: main2.php?op=1");
   }

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Sistema Bienestar</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
				<form id="frmLogin" class="login100-form validate-form" action="index2.php" method="post">
					<span class="login100-form-title p-b-33">
						<img src="LOGOTIPO COLOR1.jpg" alt="" style="width:150px;height:150px;">
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Se requiere un formato de correo: ejemplo@andreebienestar.cl">
						<input class="input100" type="text" name="email" placeholder="Usuario" value = "<?php echo $_SESSION['login_user']; ?>" readonly>
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="wrap-input100 rs1 validate-input" data-validate="Password is required">
						<input class="input100" type="password" id="passold" name="passold" placeholder="Clave Anterior">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>
					
					<div class="wrap-input100 rs1 validate-input" data-validate="Password is required">
						<input class="input100" type="password" id="passnew" name="passnew" placeholder="Clave Nueva">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="container-login100-form-btn m-t-20">
						<input class="login100-form-btn" type="submit" value="CAMBIAR">
					</div>

					<div class="text-center p-t-45 p-b-4">

					</div>
				</form>
			</div>
		</div>
	</div>
	

	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>