<?php
if($_GET['op'] == 1)
{
    session_start();
}

//menu.php?op=1&usr=dmanzanod@gmail.com

    if(!isset($_SESSION['login_user']))
    {
       if($_SERVER["REQUEST_METHOD"] == "GET") {
          // username and password sent from form 
          $myusername = $_GET['usr'];
          
          $con = mysqli_connect('ec2-3-87-203-241.compute-1.amazonaws.com','zazudb2','zazu2023','bd_andree');
            if (!$con) {
                die('Could not connect: ' . mysqli_error($con));
            }
        
            mysqli_select_db($con,"bd_andree");
            
            $sql = "SELECT id, nuevo FROM tbl_users WHERE user = '".$myusername."' and active='1'";
            
            //echo  $sql = "SELECT id, nuevo FROM tbl_users WHERE user = '".$myusername."' and active='1'";
            
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
    
 //* TRAIGO DATOS BENEFISIARIO
             
            $con = mysqli_connect('ec2-3-87-203-241.compute-1.amazonaws.com','zazudb2','zazu2023','bd_andree');
            
            if (!$con) {
                die('Could not connect: ' . mysqli_error($con));
            }
        
            mysqli_select_db($con,"bd_andree");
            
            $sql = "SELECT rut_asegurado, nomre_asegurado, apellido_asegurado, email_asegurado FROM tbl_asegurado where email_asegurado = '".$_GET['usr']."' LIMIT 1";
            $result = mysqli_query($con,$sql);
            $rowcount = mysqli_num_rows($result);
            
            $result = mysqli_query($con,$sql);

            //SELECT rut_asegurado, nomre_asegurado, apellido_asegurado, email_asegurado FROM `tbl_asegurado` where email_asegurado = 'dmanzanod@gmail.com' LIMIT 1

            while($row = mysqli_fetch_array($result)) {
                $rut = $row['rut_asegurado'];
                $nombre = $row['nomre_asegurado'];
                $apellido = $row['apellido_asegurado'];
                $email = $row['email_asegurado'];
            }
            
            mysqli_close($con);
//* /////////////////////////
             
    

    
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Andree Bienestar</title>

    <style>
        /* Sticky footer styles
-------------------------------------------------- */
html {
  position: relative;
  min-height: 100%;
}
body {
  /* Margin bottom by footer height */
  margin-bottom: 60px;
}
.footer {
  position: absolute;
  bottom: 0;
  width: 100%;
  /* Set the fixed height of the footer here */
  height: 60px;
  line-height: 60px; /* Vertically center the text there */
  background-color: #f5f5f5;
}


/* Custom page CSS
-------------------------------------------------- */
/* Not required for template or sticky footer method. */

body > .container {
  padding: 60px 15px 0;
}

.footer > .container {
  padding-right: 15px;
  padding-left: 15px;
}

code {
  font-size: 80%;
}
        
    </style>
  </head>
  <body>
    <!-- Static navbar -->
    <header>
      <!-- Fixed navbar -->
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#">C. Bienestar Andree School</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Salir</a>
            </li>
          </ul>
        </div>
      </nav>
    </header>
 
 <br />
    <div class="container">
          <div class="row">
            <div class="col-lg-12">
               <form id="myform" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleFormControlInput5">Nombre Asociado: <?php echo $nombre." ".$apellido ?></label>
                        <input id="rut" name="rut" type="hidden" value="<?php echo $rut ?>">
                        <input id="email" name="email" type="hidden" value="<?php echo $email ?>">
                    </div>
                   <div class="form-group">
                        <label for="exampleFormControlInput3">Nombre del Reembolso</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" name="exampleFormControlInput1" placeholder="Ej. Gripe de Juanito">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput4">Monto solicitado a reembolsar</label>
                        <input class="form-control" class="form-control" type="number"  id="exampleFormControlInput2" name="exampleFormControlInput2" placeholder="$ 0">
                    </div>
                        <div class="form-group">
                            <label for="file">Seleccione los documentos necesarios para el reembolso.</label>
                            <input type="file" name="files[]" id="file" aria-describedby="inputGroupFileAddon01" multiple>
                        </div>
                  <br />
                  <input type="submit"  class="btn btn-success btn-primary" value="Enviar Solicitud">
                  </div>
                </form>
            </div>
          </div>
    </div> <!-- /container -->
    <br />
    <br />
    <br />
    <br />
    <!-- Footer -->
    <footer class="footer">
      <div class="container">
        <span class="text-muted">© 2020 Copyright: C. Bienestar Andree School</span>
      </div>
    </footer>
<!-- Footer -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    
    <script>
        $(function(){
                var callback = function(e){
                    var file = $("#file").val();
                    var motivo = $("#exampleFormControlInput1").val();
                    var monto = $("#exampleFormControlInput2").val();
            
                    if(file != "" && motivo != "" && monto != "")
                    {
                        e.preventDefault();
                        $.ajax({
                            url: "./upload.php",
                            type:"POST",
                            data: new FormData(this),
                            contentType: false,
                            cache: false,
                            processData:false,
                            success: function(response){
                              $('#file').val("");
                              $('#exampleFormControlInput1').val("");
                              $("#exampleFormControlInput2").val("0");
                              $('#file').val("");
                              $('#exampleModal').modal('show');
                            }
                        });
                    }else{
                        e.preventDefault();
                        $('#exampleModal1').modal('show');
                    }       
                }
                $('#myform').on("submit", callback);
    });
    </script>
    
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Información</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Estimado asociado <?php echo $nombre." ".$apellido ?>, su requerimiento ha sido enviado con éxito, un comprobante fue enviado a su correo. Gracias. 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal 1 -->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ERROR</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Estimado asociado <?php echo $nombre." ".$apellido ?>, DEBE ingresar todos los datos antes de enviar la solicitud. Gracias. 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
    
  </body>
</html>