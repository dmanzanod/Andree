<?php
session_start();
  
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
				
$g = new jqgrid($db_conf);

// set few params
$opt["caption"] = "Reembolsos";


$g->navgrid["param"]["del"] = false;
$g->navgrid["param"]["view"] = false;
$g->navgrid["param"]["search"] = false;
$g->navgrid["param"]["add"] = false;
$g->navgrid["param"]["edit"] = false;
$g->navgrid["param"]["refresh"] = true;


$g->set_actions(array(	
						"add"=>false, // allow/disallow add
						"edit"=>false, // allow/disallow edit
						"delete"=>false, // allow/disallow delete
						"rowactions"=>false, // show/hide row wise edit/del/save option
						"export_excel"=>false, // export excel button
						"export_pdf"=>true, // export pdf button
						"export_csv"=>true, // export csv button
						"export_html"=>false, // export html button
						"autofilter" => false, // show/hide autofilter for search
						"showhidecolumns" => false // show/hide autofilter for search// show single/multi field search condition (e.g. simple or advance)
					) 
				);

$g->set_options($opt);

$g->select_command = "SELECT id, (SELECT CONCAT(nomre_asegurado, ' ', apellido_asegurado)  FROM tbl_asegurado WHERE rut_asegurado = rut_asegurado_h) nombre, fecha, nro_folio, total_reembolso, nro_cheque, '___________________' firma FROM frm_historic where (SELECT CONCAT(nomre_asegurado, ' ', apellido_asegurado)  FROM tbl_asegurado WHERE rut_asegurado = rut_asegurado_h) is NOT null";

$g->table = "frm_historic";

$col = array();
$col["title"] = "Fecha Reembolso"; // caption of column
$col["name"] = "fecha"; // grid column name, must be exactly same as returned column-name from sql (tablefield or field-alias)
//$col["width"] = "5";
$col["width"] = "120";
$col["hidden"] = false;
$cols[] = $col;	

$col = array();
$col["title"] = "Nro. Folio"; // caption of column
$col["name"] = "nro_folio"; // grid column name, must be exactly same as returned column-name from sql (tablefield or field-alias)
//$col["width"] = "5";
$col["width"] = "75";
$col["hidden"] = false;
$cols[] = $col;	

$col = array();
$col["title"] = "Nombre Asociado"; // caption of column
$col["name"] = "nombre"; // grid column name, must be exactly same as returned column-name from sql (tablefield or field-alias)
//$col["width"] = "5";
$col["width"] = "150";
$col["hidden"] = false;
$cols[] = $col;	

$col = array();
$col["title"] = "Reembolso $"; // caption of column
$col["name"] = "total_reembolso"; // grid column name, must be exactly same as returned column-name from sql (tablefield or field-alias)
//$col["width"] = "5";
$col["width"] = "90";
$col["hidden"] = false;
$cols[] = $col;	

$col = array();
$col["title"] = "Cheque Nro."; // caption of column
$col["name"] = "nro_cheque"; // grid column name, must be exactly same as returned column-name from sql (tablefield or field-alias)
//$col["width"] = "5";
$col["width"] = "90";
$col["hidden"] = false;
$cols[] = $col;	

$col = array();
$col["title"] = "Firma Asociado"; // caption of column
$col["name"] = "firma"; // grid column name, must be exactly same as returned column-name from sql (tablefield or field-alias)
//$col["width"] = "5";
$col["width"] = "150";
$col["hidden"] = false;
$cols[] = $col;	


// pass the cooked columns to grid
$g->set_columns($cols);

// generate grid output, with unique grid name as 'list1'
$out = $g->render('list1');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- <link rel="apple-touch-icon-precomposed" href="img/icon.png"/>
    <link rel="apple-touch-icon" href="img/icon.png"/>
    <link rel="apple-touch-startup-image" href="img/splash.png" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" /> -->

    <title>Reporte de Reembolsos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" media="screen" href="./phpgrid/lib/js/themes/cupertino/jquery-ui.custom.css" />	
	<link rel="stylesheet" type="text/css" media="screen" href="./phpgrid/lib/js/jqgrid/css/ui.jqgrid.bs.css"></link>	
	
	<script src="./phpgrid/lib/js/jquery.min.js" type="text/javascript"></script>
	<script src="./phpgrid/lib/js/jqgrid/js/i18n/grid.locale-es.js" type="text/javascript"></script>
	<script src="./phpgrid/lib/js/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>	
    <script src="./phpgrid/lib/js/themes/jquery-ui.custom.min.js" type="text/javascript"></script>

</head>

<body>
        <div style="clear:both;margin-bottom:10px">
		<fieldset style="float:left; font-family:tahoma; font-size:12px">
				<legend>Buscar por Fecha (Desde y Hasta)</legend>
				<form>
			        Fecha Desde: <input class="datepicker" type="text" id="datefrom"/>
			        Fecha Hasta: <input class="datepicker" type="text" id="dateto"/>
			        <input type="submit" id="search_date" value="Buscar">
			    </form>
		</fieldset>
		</div>
		<br />
		<br />
		<br />
    <div style="margin:10px">
    <!-- display grid here -->
    <?php echo $out?>
    <!-- display grid here -->
    </div>

<script>
    jQuery(window).load(function() {
	
		// formats: http://api.jqueryui.com/datepicker/#option-dateFormat
		jQuery(".datepicker").datepicker(
								{
								"disabled":false,
								"dateFormat":"yy-mm-dd",
								"changeMonth": true,
								"changeYear": true,
								"firstDay": 1,
								"showOn":'both'
								}
							).next('button').button({
								icons: {
									primary: 'ui-icon-calendar'
								}, text:false
							}).css({'font-size':'80%', 'margin-left':'2px', 'margin-top':'-5px'});
											
	});
	
	
	jQuery("#search_date").click(function() {
    	grid = jQuery("#list1");

		if (jQuery("#datefrom").val() == '' || jQuery("#dateto").val() == '')
			return false;
			
		var f = {groupOp:"AND",rules:[]};
		if (jQuery("#datefrom").val())
        f.rules.push({field:"fecha",op:"ge",data:jQuery("#datefrom").val()});
		
		if (jQuery("#dateto").val())
        f.rules.push({field:"fecha",op:"le",data:jQuery("#dateto").val()});

		var s = {groupOp:"OR",rules:[],groups:[f]};
		s.rules.push({field:"fecha",op:"nu",data:''});
		   
        grid[0].p.search = true;
        jQuery.extend(grid[0].p.postData,{filters:JSON.stringify(s)});

        grid.trigger("reloadGrid",[{jqgrid_page:1,current:true}]);
        return false;
    });
    
</script>
</body>
</html>


