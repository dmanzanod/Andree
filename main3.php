<?php
if($_GET['op'] == 1)
{
    session_start();
}

//echo $_SESSION['login_user']."<=======";

    if(!isset($_SESSION['login_user']))
    {
        //echo 1;
       if($_SERVER["REQUEST_METHOD"] == "POST") {
          // username and password sent from form 
          $myusername = $_POST['email'];
          $mypassword = $_POST['pass']; 
          
          $con = mysqli_connect('ec2-44-204-145-91.compute-1.amazonaws.com','zazudb2','zazu2023','bd_andree');
            if (!$con) {
                die('Could not connect: ' . mysqli_error($con));
            }
        
            mysqli_select_db($con,"bd_andree");
            
            $sql = "SELECT id, nuevo FROM tbl_users WHERE user = '".$myusername."' and password = '".$mypassword."' and active='1'";
            $result = mysqli_query($con,$sql);
            $rowcount = mysqli_num_rows($result);
            
            $result = mysqli_query($con,$sql);

            while($row = mysqli_fetch_array($result)) {
                $nuevo = $row['nuevo'];
                //echo $nuev."<<<";
            }
            
            mysqli_close($con);
    	//echo "==>".$rowcount."<== rowcont";
         if($rowcount == 1) {
            if($nuevo == 1)
            {
                session_start();
                $_SESSION['login_user'] = $myusername;
                //echo 2;
                header("location: index2.php");
            }else{
                //echo 3;
             session_start();
             $_SESSION['login_user'] = $myusername;
            }
          }else {
             header("location: logout.php");
          }
       }else {
            header("location: logout.php");
       }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
  <title>AndreeBienestar</title>
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Coorporación de Bienestar Andree School</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"  href="#" id="button4">Administración de Reembolsos<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="#" id="button3">Solicitudes Ingresadas</a></li>
        </ul>
      </li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Informes<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#" id="button">Informe de Reembolsos</a></li>
          <li><a href="#" id="button2">Informe Reembolsos por Asociado</a></li>
          <li><a href="#" id="button5">Informe de Comprobantes</a></li>
          <!-- <li><a href="#">Page 1-3</a></li> -->
        </ul>
      </li>
      <li><a href="#" id="button3">Administración de Usuarios</a></li>
      <!--<li><a href="#">Page 2</a></li> -->
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Salir</a></li>
    </ul>
  </div>
</nav>
  
<iframe id="frame" frameborder="0" src="" width="100%" height="824px"></iframe>
  
    <script>
    
        $( document ).ready(function() {
            $("#frame").attr("src", "main.php");
        });

          $("#button").click(function () { 
            $("#frame").attr("src", "reporte_v2.php");
        });
        
        $("#button2").click(function () { 
            $("#frame").attr("src", "reporte_reembolsos2.php");
        });
        
        $("#button5").click(function () { 
            $("#frame").attr("src", "reporte_v3.php");
        });
        
        $("#button4").click(function () { 
            $("#frame").attr("src", "main.php");
        });
        
        $("#button3").click(function () { 
            $("#frame").attr("src", "solicitudes.php");
        });
    </script>
</body>
</html>