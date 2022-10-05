<?php

if($_GET['nro'] != '')
{
    $f = $_GET['folio'];
    $n = $_GET['nro'];
    
    $con = mysqli_connect('localhost','andree','andree','andreeBienestar');
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    
    mysqli_select_db($con,"andreeBienestar");
    $sql="update frm_historic set nro_cheque = '".$n."' WHERE nro_folio = '".$f."'";
    
    $result = mysqli_query($con,$sql);
    
    mysqli_close($con);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h4>Ingrese Nro. Transferencia:</h4>
  <form action="cheque.php" method="GET">
    <div class="form-group">
      <input type="input" class="form-control" id="nro" placeholder="" name="nro">
      <input type="hidden" id="folio" name="folio" value="<?php echo $_GET['folio'];?>">
    </div>
    <button type="submit" class="btn btn-primary">Guardar Datos</button>
  </form>
</div>
</body>
</html>