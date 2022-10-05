<?php
include_once("./phpgrid/config.php");

include(PHPGRID_LIBPATH."inc/jqgrid_dist.php");

// Database config file to be passed in phpgrid constructor
$db_conf = array(
					"type" 		=> PHPGRID_DBTYPE,
					"server" 	=> PHPGRID_DBHOST,
					"user" 		=> PHPGRID_DBUSER,
					"password" 	=> PHPGRID_DBPASS,
					"database" 	=> PHPGRID_DBNAME
				);
				
				
include_once("../../config.php");

$g = new jqgrid($db_conf);

$grid["caption"] = "Solicitudes Ingresadas";

$g->set_actions(array(
                        "add"=>false, // allow/disallow add
                        "edit"=>true, // allow/disallow edit
                        "delete"=>true, // allow/disallow delete
                        "rowactions"=>false, // show/hide row wise edit/del/save option
                        "search" => "advance", // show single/multi field search condition (e.g. simple or advance)
                        "autofilter" => true,
                        "export_pdf" => false,
                        "view" => false
                    )
                );

$g->table = "tbl_requerimientos";
$g->select_command = "SELECT id, rut, (SELECT CONCAT(nomre_asegurado, ' ', apellido_asegurado) AS nomre_asegurado2 FROM tbl_asegurado where tbl_asegurado.rut_asegurado = tbl_requerimientos.rut Limit 1) as beneficiario, nombre, valor, estado, hash, folio, HoraFecha FROM tbl_requerimientos";

$col1 = array();
$col1["title"] = "id"; // caption of column
$col1["name"] = "id"; 
//$col1["width"] = "10";
$col1["editable"] = false;
$col1["hidden"] = true;
$cols1[] = $col1;

$col1 = array();
$col1["title"] = "Rut "; // caption of column
$col1["name"] = "rut"; 
$col1["width"] = "50";
$col1["editable"] = false;
$cols1[] = $col1;

$col1 = array();
$col1["title"] = "Nombre Asociado "; // caption of column
$col1["name"] = "beneficiario"; 
//$col1["width"] = "10";
$col1["editable"] = false;
$cols1[] = $col1;

$col1 = array();
$col1["title"] = "Motivo Solicitud"; // caption of column
$col1["name"] = "nombre"; 
//$col1["width"] = "10";
$col1["editable"] = false;
$cols1[] = $col1;

//$col1 = array();
//$col1["title"] = "Monto Solicitud"; // caption of column
//$col1["name"] = "valor"; 
//$col1["width"] = "10";
//$col1["editable"] = false;
//$cols1[] = $col1;

$col1 = array();
$col1["title"] = "Monto Solicitud"; // caption of column
$col1["name"] = "valor"; 
$col1["editable"] = false;
$col1["hidden"] = false;
$col1["formatter"] = "currency";
$col1["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col1["editoptions"] = array("size"=>5, "defaultValue"=>300);
$cols1[] = $col1;

$col1 = array();
$col1["title"] = "Hora / Fecha"; // caption of column
$col1["name"] = "HoraFecha"; 
//$col1["width"] = "10";
$col1["editable"] = false;
$cols1[] = $col1;

$col1 = array();
$col1["title"] = "Documentos Enviados";
$col1["name"] = "hash";
$col1["width"] = "130";
$col1["align"] = "center";
$col1["editable"] = false;
$col1["search"] = false;
$col1["default"] = "<button onclick='openWin({id})' class='btn'>Ver Documentos</button>";
$cols1[] = $col1;

$col1 = array();
$col1["title"] = "Estado Solicitud"; // caption of column
$col1["name"] = "estado"; 
//$col1["width"] = "10";
$col1["editable"] = true;
$col1["edittype"] = "select";
$col1["editoptions"] = array("value"=>'PENDIENTE:PENDIENTE;APROBADO:APROBADO;RECHAZADO:RECHAZADO');
$cols1[] = $col1;

$col1 = array();
$col1["title"] = "Folio Asignado"; // caption of column
$col1["name"] = "folio"; 
//$col1["width"] = "10";
$col1["editable"] = true;
$cols1[] = $col1;

// pass the cooked columns to grid
$g->set_columns($cols1);

// generate grid output, with unique grid name as 'list1'
$out = $g->render('list1');

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" media="screen" href="./phpgrid/lib/js/themes/cupertino/jquery-ui.custom.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="./phpgrid/lib/js/jqgrid/css/ui.jqgrid.css" />

	<script src="./phpgrid/lib/js/jquery.min.js" type="text/javascript"></script>
	<script src="./phpgrid/lib/js/jqgrid/js/i18n/grid.locale-es.js" type="text/javascript"></script>
	<script src="./phpgrid/lib/js/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>
	<script src="./phpgrid/lib/js/themes/jquery-ui.custom.min.js" type="text/javascript"></script>
	
	
	<style>
.ui-jqgrid {font-size:14px; font-family:"tahoma";}
.ui-jqgrid tr.jqgrow td {height: 50px; padding:0 5px;}

.btn {
  background-color: DodgerBlue;
  border: none;
  color: white;
  padding: 10px 14px;
  font-size: 14px;
  cursor: pointer;
}

/* Darker background on mouse-over */
.btn:hover {
  background-color: RoyalBlue;
}
</style>


</head>

<script>
var myWindow;

        function openWin(op)
        {
            window.open("http://www.andreebienestar.cl/imagenes.php?j="+op, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=100,width=1024,height=800");
        }
</script>

<body>
	<div style="margin:30px;top:50px">
	<?php echo $out?>
	</div>
	
	</body>
</html>