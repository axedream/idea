<?php 
/**
 * PHP Grid Component
 *
 * @author Abu Ghufran <gridphp@gmail.com> - http://www.phpgrid.org
 * @version 1.5.2
 * @license: see license.txt included in package
 */

// include db config
include_once("../../config.php");

// set up DB
mysql_connect(PHPGRID_DBHOST, PHPGRID_DBUSER, PHPGRID_DBPASS) or die(mysql_error());
mysql_select_db(PHPGRID_DBNAME);

// include and create object
include(PHPGRID_LIBPATH."inc/jqgrid_dist.php");

// you can customize your own columns ...

$col = array();
$col["title"] = "Код источника"; // caption of column
$col["name"] = "dsId"; // grid column name, must be exactly same as returned column-name from sql (tablefield or field-alias)
$col["align"] = "center"; 
$col["editable"] = false;
$col["width"] = "22";
$cols[] = $col;		

$col = array();
$col["title"] = "Запрос";
$col["name"] = "query";
$col["width"] = "100";
//$col["editable"] = false; // this column is not editable
$col["align"] = "left"; 
$col["editable"] = false;
//$col["search"] = false; // this column is not searchable
$cols[] = $col;

$col = array();
$col["title"] = "Название источника";
$col["name"] = "name";
$col["sortable"] = false; // this column is not sortable
$col["search"] = false; // this column is not searchable
$col["editable"] = false;
$col["edittype"] = "textarea"; // render as textarea on edit
$col["editoptions"] = array("rows"=>2, "cols"=>20); // with these attributes

// don't show this column in list, but in edit/add mode
$col["hidden"] = true;
$col["editrules"] = array("edithidden"=>true); 

$cols[] = $col;

$col = array();
$col["title"] = "Дата создания";
$col["name"] = "date_create"; 
$col["width"] = "40";
$col["align"] = "center";
$col["editable"] = false; // this column is editable
//$col["editrules"] = array("required"=>true); // required:true(false), number:true(false), minValue:val, maxValue:val
$col["formatter"] = "datetime"; // format as date
$cols[] = $col;
		
		
$col = array();
$col["title"] = "Дата последнего обновления";
$col["name"] = "date_update";
$col["width"] = "40";
$col["align"] = "center";
$col["editable"] = false;
$col["formatter"] = "datetime"; // format as date

// default render is textbox
$col["editoptions"] = array("value"=>'10');

// can be switched to select (dropdown)
# $col["edittype"] = "select"; // render as select
# $col["editoptions"] = array("value"=>'10:$10;20:$20;30:$30;40:$40;50:$50'); // with these values "key:value;key:value;key:value"

$cols[] = $col;

$col = array();
$col["title"] = "Готов для отчёта?";
$col["name"] = "to_report";
$col["width"] = "22";
$col["align"] = "center";
$col["editable"] = true;
$col["search"] = true;
$col["stype"] = "select";
$col["searchoptions"] = array("value"=>"1:Да;0:Нет");
$col["edittype"] = "checkbox"; // render as checkbox
$col["editoptions"] = array("value"=>"1:0"); // with these values "checked_value:unchecked_value"
$col["formatter"] = "checkbox";
//$col["formatoptions"] = array("disabled"=>"false");
$cols[] = $col;

# Custom made column to show link, must have default value as it's not db driven
$col = array();
$col["title"] = "Срез?";
$col["name"] = "section";
$col["width"] = "10";
$col["align"] = "center";
$col["editable"] = true;
$col["search"] = true;
$col["stype"] = "select";
$col["searchoptions"] = array("value"=>"1:Да;0:Нет");
$col["edittype"] = "checkbox"; // render as checkbox
$col["editoptions"] = array("value"=>"1:0"); // with these values "checked_value:unchecked_value"
$col["formatter"] = "checkbox";
//$col["formatoptions"] = array("disabled"=>"false");
//$col["sortable"] = false;
//$col["link"] = "http://bi.etagi.local/vendor/phpgrid-free-v1.5.2/demos/appearence/alternate-row.php/?dsId={id}"; // e.g. http://domain.com?id={id} given that, there is a column with $col["name"] = "id" exist
//$col["linkoptions"] = "target='_blank'"; // extra params with <a> tag
//$col["default"] = "View More"; // default link text
$cols[] = $col;

$col = array();
$col["title"] = "Описание источника";
$col["name"] = "description";
$col["align"] = "center";
$col["width"] = "30";
$col["sortable"] = true; // this column is not sortable
$col["search"] = true; // this column is not searchable
$col["editable"] = true;
$col["edittype"] = "textarea"; // render as textarea on edit
//$col["editoptions"] = array("rows"=>2, "cols"=>20); // with these attributes
$cols[] = $col;

$g = new jqgrid();

$grid["rowNum"] = 10; // by default 20
$grid["sortname"] = 'dsId'; // by default sort grid by this field
$grid["sortorder"] = "desc"; // ASC or DESC
$grid["caption"] = "Реестр источников"; // caption of grid
$grid["autowidth"] = true; // expand grid to screen width
$grid["multiselect"] = false; // allow you to multi-select through checkboxes
$grid["multiSort"] = true; // allow you to multi-sort

$grid["altRows"] = true; 
$grid["altclass"] = "myAltRowClass"; 

$grid["rowactions"] = true; // allow you to multi-select through checkboxes

// export XLS file
// export to excel parameters
$grid["export"] = array("format"=>"pdf", "filename"=>"my-file", "sheetname"=>"test");

// RTL support
// $grid["direction"] = "rtl";

$g->set_options($grid);

$g->set_actions(array(	
						"add"=>false, // allow/disallow add
						"edit"=>true, // allow/disallow edit
						"delete"=>true, // allow/disallow delete
						"rowactions"=>true, // show/hide row wise edit/del/save option
						"export"=>false, // show/hide export to excel option
						"autofilter" => true, // show/hide autofilter for search
						"search" => "advance" // show single/multi field search condition (e.g. simple or advance)
					) 
				);

// you can provide custom SQL query to display data
$g->select_command = " SELECT * FROM ds ";

// this db table will be used for add,edit,delete
$g->table = "ds";

// pass the cooked columns to grid
$g->set_columns($cols);

// generate grid output, with unique grid name as 'sources'
$out = $g->render("sources");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
	<link rel="stylesheet" type="text/css" media="screen" href="../../lib/js/themes/redmond/jquery-ui.custom.css"></link>	
	<link rel="stylesheet" type="text/css" media="screen" href="../../lib/js/jqgrid/css/ui.jqgrid.css"></link>	
	
	<script src="../../lib/js/jquery.min.js" type="text/javascript"></script>
	<script src="../../lib/js/jqgrid/js/i18n/grid.locale-ru.js" type="text/javascript"></script>
	<script src="../../lib/js/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>	
	<script src="../../lib/js/themes/jquery-ui.custom.min.js" type="text/javascript"></script>
</head>
<body>
	<style>
    .myAltRowClass { background-color: #DDDDDC; background-image: none; }
	</style>
	<div style="margin:10px">
	<?php echo $out?>
	</div>
</body>
</html>
