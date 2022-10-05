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

$grid["rowNum"] = 20; // by default 20
//$grid["sortname"] = 'fecha'; // by default sort grid by this field
//$grid["sortorder"] = 'fecha'; // by default sort grid by this field
$grid["caption"] = "Reembolsos"; // caption of grid
//$grid["autowidth"] = true; // expand grid to screen width
$grid["hotkeys"] = true; // a,e,d,v for add,edit,del,view

$grid["sortname"] = 'id';
$grid["sortorder"] = "asc";
$grid["responsive"] = true;
$grid["userDataOnFooter"] = true;
$grid["grouping"] = true;

// export PDF file params
$grid["export"] = array("filename"=>"my-file", "heading"=>"Invoice Details", "orientation"=>"landscape", "paper"=>"a4");
// for excel, sheet header
$grid["export"]["sheetname"] = "Invoice Details";
// export filtered data or all data
$grid["export"]["range"] = "filtered"; // or "all"


if (isset($_GET["fullscreen"]))
    $grid["fullscreen"] = true; // expand grid to screen width

$g->set_options($grid);


// remove from toolbar
$g->navgrid["param"]["del"] = false;
$g->navgrid["param"]["view"] = false;
$g->navgrid["param"]["search"] = false;
$g->navgrid["param"]["add"] = false;
$g->navgrid["param"]["edit"] = true;
$g->navgrid["param"]["refresh"] = true;


$g->set_actions(array(	
						"add"=>false, // allow/disallow add
						"edit"=>true, // allow/disallow edit
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
				
$e = array();

$e["on_render_excel"] = array("filter_xls", null, true);
$e["on_data_display"] = array("filter_display", null, true);

$g->set_events($e);

function filter_xls($param)
{
	for($x=1; $x<count($param["data"]); $x++)
		$param["data"][$x]["note"] = "/".$param["data"][$x]["note"]."/Excel";
}


$default_filter = "";
if (!isset($_GET["filters"]))
    $default_filter = "WHERE 1 = 1";				

$g->select_command = "SELECT id, fecha, nro_folio, total_reembolso FROM frm_historic $default_filter";

$g->table = "frm_historic";

$col = array();
$col["title"] = "Fecha"; // caption of column
$col["name"] = "fecha"; // grid column name, must be exactly same as returned column-name from sql (tablefield or field-alias)
//$col["width"] = "5";
$col["width"] = "150";
$col["fixed"] = true;
$col["formatter"] = "date";
$col["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'d-m-Y');
$col["hidden"] = false;
$col["visible"] = "xs+";
$col["export"] = true;
$cols[] = $col;		

$col = array();
$col["title"] = "Nro Reembolso";
$col["name"] = "nro_folio"; 
$col["fixed"] = true;
$col["width"] = "150";
$col["editable"] = false; // this column is editable
$col["export"] = true;
$cols[] = $col;

$col = array();
$col["title"] = "Total Reembolso";
$col["name"] = "total_reembolso"; 
$col["fixed"] = true;
$col["width"] = "150";
$col["editable"] = false;
$col["formatter"] = "number";
$col["summaryRound"] = 0;
$col["search"] = false;
$col["export"] = true;
$cols[] = $col;


$col = array();
$col["title"] = "Total Acumulado";
$col["name"] = "total_reembolso2";
$col["fixed"] = true;
$col["width"] = "150";
$col["editable"] = true;
$col["search"] = false;
$col["export"] = true;
$col["formatter"] = "number";
$col["summaryType"] = "sum";
$col["summaryRound"] = 2;
$cols[] = $col;

function filter_display($param)
{
//	$d = &$param["params"];
//	$running_total = 0;
//	for($x=1; $x<count($d); $x++)
//	{
//		$d[$x]["note"] = "/".$d[$x]["note"]."/Display";
//	}	
//
//    $x=0;
//
//    for($x=1; $x<count($d); $x++)
//    {  
//        echo "+++".$running_total;
//	    $running_total += $d["total_reembolso"];
//	    $d["total_reembolso2"] = $running_total;
//
//}

$running_total = 0;
	foreach($data["params"] as &$d)
	{
	    echo "www";
		$running_total += $d["total_reembolso"];
		$d["total_reembolso2"] = 88;
	}
}

// pass the cooked columns to grid
$g->set_columns($cols);

// generate grid output, with unique grid name as 'list1'
$out = $g->render('list1');
?>

<!doctype html>
<html lang="es">
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
    <style>
    .global-search
    {
        display:none;
    }
    .ui-jqgrid input[type=checkbox] {
        zoom: 1.2;
    }
    .ui-jqgrid .editable
    {
        color: black !important;
    }
    #sidebar-collapse {
        display: none;
    }
    #sidebar {
            min-width: 250px;
            max-width: 250px;
            transition: all 0.3s;
            display:block;
        }
    
    @media (max-width: 768px) {

        #sidebar-collapse {
            display: block;
        }
        #sidebar {
            background: #7386D5;
            color: #fff;
            position:absolute;
            right: -250px;
            top:0px;
            height: 100%;
            display:none;
        }
        #sidebar.active {
            right: 0;
            display:block;
        }
    }
    </style>
</head>
<body>
    <div class="container-fluid py-3">
    <div class="row">
            <div class="col">

            <?php echo $out?>
            </div>
            <div id="sidebar" class="col-3">
                <span id="sidebar-collapse" class="float-right py-1"><i class="fa fa-window-close"></i></span>
                <fieldset style="font-family:tahoma; font-size:12px">
                    <legend>Filtros de Búsqueda</legend>
                    <form>
                    <div class="row py-1">
                    <div class="col-2">Desde:</div>
                    <div class="col"><input class="datepicker" type="text" id="datefrom"/></div>  
                    </div>

                    <div class="row py-1">
                    <div class="col-2">Hasta:</div>
                    <div class="col"><input class="datepicker" type="text" id="dateto"/></div>  
                    </div>

                    <div class="row py-1">
                    </div>

                    <div class="row py-1">
                    <div class="col">
                    </div>  
                    </div>

                    <div class="row py-1">
                    
                    </div>

                    <div class="row py-1">
                    <div class="col-2"></div>
                    <div class="col">
                    <input class="btn btn-info" type="submit" id="search_date" value="Buscar">
                    </div>  
                    </div>
                    
                    </form>
                </fieldset>
            </div>
    </div>
    
    <script>
    $(document).ready(function () {

        // show buttons only on mobile devices
        if( jQuery(window).innerWidth() > 768) 
            return;

		jQuery('#list1').jqGrid('navButtonAdd', '#list1_pager',
		{
			'caption'      : 'Filters',
			'buttonicon'   : 'ui-icon-menu',
			'onClickButton': function()
			{
                $('#sidebar').show("slide").toggleClass('active');
			},
			'position': 'last'
		});

		jQuery('#list1').jqGrid('navButtonAdd', '#list1_pager',
		{
			'caption'      : '',
			'buttonicon'   : 'ui-icon-fullscreen',
			'onClickButton': function()
			{
                if (location.href.indexOf("fullscreen") != -1)
                    location.href = location.href.replace("?fullscreen=1","");
                else
                    location.href = "?fullscreen=1"
			},
			'position': 'last'
		});

        $('#sidebar-collapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

    });
    
    // external search form js api
    jQuery(window).load(function() {
	
		// formats: http://api.jqueryui.com/datepicker/#option-dateFormat
		jQuery(".datepicker").datepicker(
								{
								"disabled":false,
								"dateFormat":"dd-mm-yy",
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
                            jQuery(".datepicker").width('80%');		
                            
                            reloadGrid();   
	});
	
	jQuery("#search_date").click(function() {
    	grid = jQuery("#list1");

        var main = {groupOp:"AND",rules:[],groups:[]};

        // if both date set, then filter by date
        if (jQuery("#datefrom").val() != '' && jQuery("#dateto").val() != '')
        {
            var f = {groupOp:"AND",rules:[]};
            if (jQuery("#datefrom").val())
            f.rules.push({field:"fecha",op:"ge",data:jQuery("#datefrom").val()});
            
            if (jQuery("#dateto").val())
            f.rules.push({field:"fecha",op:"le",data:jQuery("#dateto").val()});
    
            var datefilter = {groupOp:"OR",rules:[],groups:[f]};
            datefilter.rules.push({field:"fecha",op:"nu",data:''});

            main.groups.push(datefilter);
        }
      
        if (jQuery("#query").val() != '')
        {
            //main.rules.push({field:"description",op:"cn",data:jQuery("#query").val()});
        }
        
        var colors = jQuery("[name=fpriority]:checked").map(function () {  
                                                                return this.value;
                                                            }).get().join(",");
        // if set, perform IN search
        if (colors)
            main.rules.push({field:"priority",op:"in",data:colors});

        grid[0].p.search = true;
        jQuery.extend(grid[0].p.postData,{filters:JSON.stringify(main)});

        grid.trigger("reloadGrid",[{jqgrid_page:1,current:true}]);

        $('#sidebar').toggleClass('active');
        return false;
    });
    
</script>
    
    
</body>
</html>



























