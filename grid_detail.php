<?php
/**
 * PHP Grid Component
 *
 * @author Abu Ghufran <gridphp@gmail.com> - http://www.phpgrid.org
 * @version 2.0.0
 * @license: see license.txt included in package
 */

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

$g1 = new jqgrid($db_conf);

$grid["caption"] = "Registro de Cargas";

$g1->set_options($grid);

$g1->table = "tbl_pacientes";

$company = $_REQUEST["rut_asegurado"];

//echo $company."1";
//echo $_REQUEST["rut_asegurado"]."2";

$g1->select_command = "SELECT rut_asegurado_paciente,rut_paciente,nm_paciente,app_paciente,apm_paciente FROM tbl_pacientes WHERE rut_asegurado_paciente = '".$company."'";
                        
$out1 = $g1->render("list1");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" media="screen" href="./phpgrid/lib/js/themes/cupertino/jquery-ui.custom.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="./phpgrid/lib/js/jqgrid/css/ui.jqgrid.css" />

	<script src="./phpgrid/lib/js/jquery.min.js" type="text/javascript"></script>
	<script src="./phpgrid/lib/js/jqgrid/js/i18n/grid.locale-es.js" type="text/javascript"></script>
	<script src="./phpgrid/lib/js/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>
	<script src="./phpgrid/lib/js/themes/jquery-ui.custom.min.js" type="text/javascript"></script>

</head>
<body>
	<div>
	<?php echo $out1?>
	</div>
</body>
</html>