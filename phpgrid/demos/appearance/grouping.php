<?php 
/**
 * PHP Grid Component
 *
 * @author Abu Ghufran <gridphp@gmail.com> - http://www.phpgrid.org
 * @version 2.0.0
 * @license: see license.txt included in package
 */
 
// include db config
include_once("../../config.php");

// include and create object
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

$grid["rowNum"] = 99; // by default 20
$grid["caption"] = "Orders"; // caption of grid
$grid["autowidth"] = false; // expand grid to screen width
$grid["multiselect"] = true; // allow you to multi-select through checkboxes
$grid["reloadedit"] = true; // auto reload after editing
$grid["footerrow"] = true; // Show footer row
$grid["userDataOnFooter"] = true; // Fill footer row with userdata (with on_data_display event)

$grid["autowidth"] = false;
$grid["responsive"] = true;
$grid["shrinkToFit"] = false;
$grid["cmTemplate"]["visible"] = "xs+";
$grid["cmTemplate"]["width"] = "150";

// to use footerdata without formatter, comment above and use this
$grid["loadComplete"] = 'function(){ var userData = jQuery("#list1").jqGrid("getGridParam","userData"); jQuery("#list1").jqGrid("footerData","set",userData,false); }';

// grouping
$grid["grouping"] = true;
$grid["groupingView"] = array();
$grid["groupingView"]["groupField"] = array("ship_country"); // specify column name to group listing
$grid["groupingView"]["groupColumnShow"] = array(true); // either show grouped column in list or not (default: true)
$grid["groupingView"]["groupText"] = array("<b>{0} - {1} Item(s)</b>"); // {0} is grouped value, {1} is count in group
$grid["groupingView"]["groupOrder"] = array("asc"); // show group in asc or desc order
$grid["groupingView"]["groupDataSorted"] = array(true); // show sorted data within group
$grid["groupingView"]["groupSummary"] = array(true); // work with summaryType, summaryTpl, see column: $col["name"] = "total"; (if false, set showSummaryOnHide to false)
$grid["groupingView"]["groupCollapse"] = false; // Turn true to show group collapse (default: false) 
$grid["groupingView"]["showSummaryOnHide"] = true; // show summary row even if group collapsed (hide) 

// to combine multiple records in same group
$grid["groupingView"]["isInTheSameGroup"] = array(
        "function (x, y) { return String(x).toLowerCase() === String(y).toLowerCase(); }"
    );
$grid["groupingView"]["formatDisplayField"] = array(
        "function (displayValue, cm, index, grp) { return displayValue[0].toUpperCase() + displayValue.substring(1).toLowerCase(); }"
    );

$g->set_options($grid);

$g->set_actions(array(	
						"add"=>false, // allow/disallow add
						"edit"=>true, // allow/disallow edit
						"delete"=>true, // allow/disallow delete
						"rowactions"=>true, // show/hide row wise edit/del/save option
						"export"=>true, // show/hide export to excel option
						"autofilter" => true, // show/hide autofilter for search
						"search" => "advance" // show single/multi field search condition (e.g. simple or advance)
					) 
				);

// this db table will be used for add,edit,delete
$g->table = "orders";

$col = array();
$col["title"] = "Order Num";
$col["name"] = "order_id";
$col["width"] = 0.1; // fix to align and want first column to be hidden
$col["hidden"] = false; // fix with above
$col["fixed"] = true;
$col["editable"] = true;
$cols[] = $col;

$col = array();
$col["title"] = "Total";
$col["tooltip"] = "Custom Header Tooltip of Total Number";
$col["name"] = "freight";
$col["width"] = "170";
$col["editable"] = true;
$col["formatter"] = "number";
$col["summaryType"] = "sum"; // available grouping fx: sum, count, min, max, avg
$col["summaryRound"] = 2; // decimal places
$col["summaryRoundType"] = 'fixed'; // round or fixed
$col["summaryTpl"] = 'Total ${0}'; // display html for summary row - work when "groupSummary" is set true. search below
$cols[] = $col;

// pass the cooked columns to grid
$g->set_columns($cols,true);

// generate footer data for grand sum
$e["on_data_display"] = array("filter_display", null, true);
$g->set_events($e);

function filter_display($data)
{
	// grand sum total and show in footer user data
	$total = 0;
	foreach($data["params"] as $d)
	{
		$total += $d["freight"];
	}

	$data["params"]["userdata"] = array("freight"=>"Grand $".$total);
}

$grid_id = "list1";
// generate grid output, with unique grid name as 'list1'
$out = $g->render($grid_id);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
	<link rel="stylesheet" type="text/css" media="screen" href="../../lib/js/themes/redmond/jquery-ui.custom.css"></link>	
	<link rel="stylesheet" type="text/css" media="screen" href="../../lib/js/jqgrid/css/ui.jqgrid.css"></link>	
	
	<script src="../../lib/js/jquery.min.js" type="text/javascript"></script>
	<script src="../../lib/js/jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
	<script src="../../lib/js/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>	
	<script src="../../lib/js/themes/jquery-ui.custom.min.js" type="text/javascript"></script>
</head>
<body>
	<style>
	/* change color of group text */
	.jqgroup b {
		color: navy;
		line-height: 25px;
	}
	
	.jqgroup .ui-icon {
		font-size: 2em;
	}
	
	.ui-jqgrid tr.jqgroup td
	{
		background-color: lightyellow;
	}
	</style>
	<script>
	jQuery(window).load(function()
	{
		// show dropdown in toolbar
		jQuery('.navtable tr:first').append('<td><div style="padding-left: 5px; padding-top:0px; float:left"><select style="height:24px" class="chngroup"><option value="clear" >- Group By -</option><?php foreach($g->options["colModel"] as $c) { if($c["title"] !='Action'){?><option value="<?php echo $c["name"] ?>" <?php echo ($c["name"]=="role")?"selected":"" ?>><?php echo $c["title"] ?></option><?php }} ?></select></div></td>');

		var grid_id = '<?php echo $g->id ?>';
		
		jQuery(".chngroup").change(function()
		{
			var vl = jQuery(this).val(); 
			if(vl) 
			{ 
				if(vl == "clear") 
					jQuery("#"+grid_id).jqGrid('groupingRemove',true); 
				else 
					jQuery("#"+grid_id).jqGrid('groupingGroupBy',vl); 
			} 
		});
		
		// http://www.trirand.com/jqgridwiki/doku.php?id=wiki:grouping#methods
		jQuery("#toggleGroup").click(function()
		{
			jQuery("."+grid_id+"ghead_0").each(function(){
				jQuery("#"+grid_id).jqGrid('groupingToggle',jQuery(this).attr('id')); 
			});
		});
	});
	</script>			

	<div style="margin:10px">
		Dynamic Group By: 
		<select class="chngroup">
			<?php foreach($g->options["colModel"] as $c) { ?>
			<option value="<?php echo $c["name"] ?>"><?php echo $c["title"] ?></option>
			<?php } ?>
			<option value="clear">Clear</option> 
		</select>
		<button id="toggleGroup">Toggle Grouping</button>
		<br>
		<div id="grid_groups">
			<ol>
				<li class="placeholder">Drag a column header here to group by that column</li>
			</ol>
		</div>
		<?php echo $out?>
	</div>	

	<style type="text/css">
	#grid_groups ol {
		padding: 7px 0;
		margin: 10px 0 5px 0;
		box-shadow: 0px 0px 2px #ccc;
	}
	#grid_groups .ui-sortable li {
		cursor: hand;
		cursor: pointer;
	}		
	
	#grid_groups li, .dragable { 
		background-color: #f4f4f4;
		display: inline-block;
		padding:5px 15px;
		margin-left:10px;
		font-family: tahoma,verdana,"sans serif";
		font-size: 13px;		
	}
	#grid_groups .ui-icon.ui-icon-close{
		display: inline-block;
		top: 1px;
		position: relative;
		left: -3px;
		cursor: pointer;
		font-size: 12px;		
	}
	</style>	
	<script type="text/javascript">
	jQuery(document).ready(function($){ 
		var $grid = $("#list1"),
		getColumnHeaderByName = function (colName) {
			var $self = $(this),
				colNames = $self.jqGrid("getGridParam", "colNames"),
				colModel = $self.jqGrid("getGridParam", "colModel"),
				cColumns = colModel.length,
				iCol;
			for (iCol = 0; iCol < cColumns; iCol++) {
				if (colModel[iCol].name === colName) {
					return colNames[iCol];
				}
			}
		},
		customFormatDisplayField = function (displayValue, value, colModel, index, grp) {
			return getColumnHeaderByName.call(this, colModel.name) + ": " + displayValue;
		},
		generateGroupingOptions = function (groupingCount) {
			var i, arr = [];
			for (i = 0; i < groupingCount; i++) {
				arr.push(customFormatDisplayField);
			}
			return {
				formatDisplayField: arr
			}
		},
		getArrayOfNamesOfGroupingColumns = function () {
			return $("#grid_groups ol li:not(.placeholder)")
				.map(function() {
					return $(this).attr("data-column");
				}).get()
		};

		$("tr.ui-jqgrid-labels th div").draggable({
			appendTo: "body",
			helper: function( event ) {
				return $( "<div class='dragable'>"+$(this).html()+"</div>" );
			}
		});
		$("#grid_groups ol").droppable({
			activeClass: "ui-state-default",
			hoverClass: "ui-state-hover",
			accept: ":not(.ui-sortable-helper)",
			drop: function(event, ui) {
				var $this = $(this), groupingNames;
				$this.find(".placeholder").remove();
				var groupingColumn = $("<li></li>").attr("data-column", ui.draggable.attr("id").replace("jqgh_" + $grid[0].id + "_", ""));
				$("<span class='ui-icon ui-icon-close'></span>").click(function() {
					var namesOfGroupingColumns;
					$(this).parent().remove();
					$grid.jqGrid("groupingRemove");
					namesOfGroupingColumns = getArrayOfNamesOfGroupingColumns();
					$grid.jqGrid("groupingGroupBy", namesOfGroupingColumns);
					if (namesOfGroupingColumns.length === 0) {
						$("<li class='placeholder'>Drop column headers here to group by that column</li>").appendTo($this);
					}
				}).appendTo(groupingColumn);
				groupingColumn.append(ui.draggable.text());
				groupingColumn.appendTo($this);
				$grid.jqGrid("groupingRemove");
				groupingNames = getArrayOfNamesOfGroupingColumns();
				$grid.jqGrid("groupingGroupBy", groupingNames, generateGroupingOptions(groupingNames.length));
				jQuery(".chngroup").val("clear");
			}
		}).sortable({
				items: "li:not(.placeholder)",
				sort: function() {
					$( this ).removeClass("ui-state-default");
				},
				stop: function() {
					var groupingNames = getArrayOfNamesOfGroupingColumns();
					$grid.jqGrid("groupingRemove");
					$grid.jqGrid("groupingGroupBy", groupingNames, generateGroupingOptions(groupingNames.length));
				}
		});
	});
	</script>

	</body>
</html>
