<?php
session_start();
//*****************VALOR UF MENSUAL *************
$con = mysqli_connect('ec2-3-87-203-241.compute-1.amazonaws.com','zazudb2','zazu2023','bd_andree');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"bd_andree");
$sql="SELECT valoruf FROM tbluf WHERE ano = '".date(Y)."' AND mes = '".date(n)."'";
$result = mysqli_query($con,$sql);

    while($row = mysqli_fetch_array($result)) {
        $ufval = $row['valoruf'];
    }
mysqli_close($con);

    if($ufval == 0)
    {
        $apiUrl = 'https://mindicador.cl/api';
        //Es necesario tener habilitada la directiva allow_url_fopen para usar file_get_contents
        if ( ini_get('allow_url_fopen') ) {
            $json = file_get_contents($apiUrl);
        } else {
            //De otra forma utilizamos cURL
            $curl = curl_init($apiUrl);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($curl);
            curl_close($curl);
        }
         
        $dailyIndicators = json_decode($json);
        $UF = intval($dailyIndicators->uf->valor);
        
        $con = mysqli_connect('ec2-3-87-203-241.compute-1.amazonaws.com','zazudb2','zazu2023','bd_andree');
        if (!$con) {
            die('Could not connect: ' . mysqli_error($con));
        }

        mysqli_select_db($con,"bd_andree");
        $sql="update tbluf SET valoruf = ".$UF." WHERE ano = '".date(Y)."' AND mes = '".date(n)."'";
        $result = mysqli_query($con,$sql);

        mysqli_close($con);
        
    }else{
        $UF = $ufval;
    }
    
//echo 'El valor actual de la UF es $' . $dailyIndicators->uf->valor;

//****************
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
				
$g = new jqgrid($db_conf);

$grid["caption"] = "Registro de Asociados";

$g->set_actions(array(
                        "add"=>true, // allow/disallow add
                        "edit"=>true, // allow/disallow edit
                        "delete"=>true, // allow/disallow delete
                        "rowactions"=>false, // show/hide row wise edit/del/save option
                        "search" => "advance", // show single/multi field search condition (e.g. simple or advance)
                        "autofilter" => true,
                        "export_pdf" => true,
                        "view" => false
                    )
                );

$g->table = "tbl_asegurado";
$g->select_command = "SELECT id, rut_asegurado, nomre_asegurado, isapre, fonasa, apellido_asegurado, apellido2_asegurado, tel_asegurado, email_asegurado, mnt_UF_asegurado_total, mnt_UF_asegurado, mnt_UF_psico, mnt_UF_recetas, mnt_UF_fono, mnt_UF_kine, mnt_optico FROM tbl_asegurado";

$col1 = array();
$col1["title"] = "id"; // caption of column
$col1["name"] = "id"; 
//$col1["width"] = "10";
$col1["editable"] = false;
$col1["hidden"] = true;
$cols1[] = $col1;

$col1 = array();
$col1["title"] = "Rut "; // caption of column
$col1["name"] = "rut_asegurado"; 
//$col1["width"] = "10";
$col1["editable"] = true;
$cols1[] = $col1;

$col1 = array();
$col1["title"] = "Nombre"; // caption of column
$col1["name"] = "nomre_asegurado"; 
//$col1["width"] = "10";
$col1["editable"] = true;
$cols1[] = $col1;

$col1 = array();
$col1["title"] = "Apellido Paterno"; // caption of column
$col1["name"] = "apellido_asegurado"; 
//$col1["width"] = "10";
$col1["editable"] = true;
$cols1[] = $col1;

$col1 = array();
$col1["title"] = "Apellido Materno"; // caption of column
$col1["name"] = "apellido2_asegurado"; 
//$col1["width"] = "10";
$col1["editable"] = true;
$cols1[] = $col1;

$col1 = array();
$col1["title"] = "Teléfono"; // caption of column
$col1["name"] = "tel_asegurado"; 
//$col1["width"] = "10";
$col1["editable"] = false;
$col1["hidden"] = true;
$cols1[] = $col1;

$col1 = array();
$col1["title"] = "Email"; // caption of column
$col1["name"] = "email_asegurado"; 
//$col1["width"] = "10";
$col1["editable"] = true;
$cols1[] = $col1;

$col1 = array();
$col1["title"] = "Isapre"; // caption of column
$col1["name"] = "isapre"; 
$col1["width"] = "75";
$col1["editable"] = true;
$col1["edittype"] = "checkbox";
$col1["visible"] = true;
$col1["editoptions"] = array("value"=>"SI:NO");
$cols1[] = $col1;

$col1 = array();
$col1["title"] = "Fonasa"; // caption of column
$col1["name"] = "fonasa"; 
$col1["width"] = "75";
$col1["editable"] = true;
$col1["edittype"] = "checkbox";
$col1["visible"] = true;
$col1["editoptions"] = array("value"=>"SI:NO");
$cols1[] = $col1;

$col1 = array();
$col1["title"] = "Monto Asegurado Total (UF)"; // caption of column
$col1["name"] = "mnt_UF_asegurado_total"; 
$col1["editable"] = false;
$col1["hidden"] = true;
$col1["formatter"] = "currency";
$col1["formatoptions"] = array("prefix" => "",
                                "suffix" => ' UF',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 4);
$col1["editoptions"] = array("size"=>5, "defaultValue"=>300);
$cols1[] = $col1;

$col1 = array();
$col1["title"] = "Monto Asegurado (UF)"; // caption of column
$col1["name"] = "mnt_UF_asegurado";
$col1["formatter"] = "currency";
$col1["formatoptions"] = array("prefix" => "",
                                "suffix" => ' UF',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 4);
//$col1["formoptions"] = array("rowpos"=>"31", "colpos"=>"1", "thousandsSeparator" => ".", "decimalPlaces" => 0);
//$col1["width"] = "10";
$col1["editable"] = true;
$col1["editoptions"] = array("size"=>5, "defaultValue"=>300);
$cols1[] = $col1;

$col1 = array();
$col1["title"] = "Monto Psicologa (UF)"; // caption of column
$col1["name"] = "mnt_UF_psico"; 
$col1["formatter"] = "currency";
$col1["formatoptions"] = array("prefix" => "",
                                "suffix" => ' UF',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 4);
//$col1["formoptions"] = array("rowpos"=>"31", "colpos"=>"1", "thousandsSeparator" => ".", "decimalPlaces" => 0);
//$col1["width"] = "10";
$col1["editable"] = true;
$col1["editoptions"] = array("size"=>5, "defaultValue"=>10);
$cols1[] = $col1;

$col1 = array();
$col1["title"] = "Monto Recetas (UF)"; // caption of column
$col1["name"] = "mnt_UF_recetas"; 
$col1["formatter"] = "currency";
$col1["formatoptions"] = array("prefix" => "",
                                "suffix" => ' UF',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 4);
//$col1["formoptions"] = array("rowpos"=>"31", "colpos"=>"1", "thousandsSeparator" => ".", "decimalPlaces" => 0);
//$col1["width"] = "10";
$col1["editable"] = true;
$col1["editoptions"] = array("size"=>5, "defaultValue"=>30);
$cols1[] = $col1;

$col1 = array();
$col1["title"] = "Monto Fono Audio. (UF)"; // caption of column
$col1["name"] = "mnt_UF_fono"; 
$col1["formatter"] = "currency";
$col1["formatoptions"] = array("prefix" => "",
                                "suffix" => ' UF',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 4);
//$col1["formoptions"] = array("rowpos"=>"31", "colpos"=>"1", "thousandsSeparator" => ".", "decimalPlaces" => 0);
//$col1["width"] = "10";
$col1["editable"] = true;
$col1["editoptions"] = array("size"=>5, "defaultValue"=>10);
$cols1[] = $col1;

$col1 = array();
$col1["title"] = "Monto Kinesiologia (UF)"; // caption of column
$col1["name"] = "mnt_UF_kine";
$col1["formatter"] = "currency";
$col1["formatoptions"] = array("prefix" => "",
                                "suffix" => ' UF',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 4);
//$col1["formoptions"] = array("rowpos"=>"31", "colpos"=>"1", "thousandsSeparator" => ".", "decimalPlaces" => 0);
//$col1["width"] = "10";
$col1["editable"] = true;
$col1["editoptions"] = array("size"=>5, "defaultValue"=>10);
$cols1[] = $col1;

//mnt_optico

$col1 = array();
$col1["title"] = "Monto ópticos (UF)"; // caption of column
$col1["name"] = "mnt_optico";
$col1["formatter"] = "currency";
$col1["formatoptions"] = array("prefix" => "",
                                "suffix" => ' UF',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 4);
//$col1["formoptions"] = array("rowpos"=>"31", "colpos"=>"1", "thousandsSeparator" => ".", "decimalPlaces" => 0);
//$col1["width"] = "10";
$col1["editable"] = true;
$col1["editoptions"] = array("size"=>5, "defaultValue"=>4);
$cols1[] = $col1;

$g->set_columns($cols1);
$e["js_on_select_row"] = "do_onselect";

$grid["subGrid"] = true;
$grid["subgridurl"] = "grid_detail.php";
$grid["detail_grid_id"] = "list2";
$grid["subgridparams"] = "rut_asegurado,mnt_optico";

//$grid["width"] = "600";

$g->set_options($grid);
$g->set_events($e);
$out = $g->render("list1");


$g1 = new jqgrid($db_conf);

$grid1["caption"] = "Solicitudes Realizadas";
$grid1["edit_options"] = array("recreateForm" => true, "closeAfterEdit"=>true, 'width'=>'920');
$grid1["add_options"] = array("recreateForm" => true, "closeAfterAdd"=>true, 'width'=>'920');
$grid1["view_options"] = array("recreateForm" => true, "closeAfterAdd"=>true, 'width'=>'1240');
$grid1["reloadedit"] = true;
$grid1["footerrow"] = true;

$grid1["add_options"]["afterShowForm"] = 'function ()
    {
        $(\'<a href="#">Calcular Valores <span class="ui-icon ui-icon-calculator"></span></a>\')
        .addClass("fm-button ui-state-default ui-corner-all fm-button-icon-left")
        .prependTo("#Act_Buttons>td.EditButton")
        .click(function()
                {
                    update_field_rut();                
                    update_fiel_kine_saldo_actual();
                    update_fiel_fono_saldo_actual();
                    update_fiel_saldo_actual_cristales();
                    update_fiel_saldo_actual_receta();
                    update_field_consulta_hermana15();
                    update_field_consulta15();
                    update_field_consulta_hermana14();
                    update_field_consulta14();
                    //update_field_consulta_hermana13();
                    //update_field_consulta13();
                    update_field_consulta_hermana12();
                    update_field_consulta12();
                    update_field_consulta11();
                    update_field_consulta_hermana10();
                    update_field_consulta10();
                    update_field_consulta_hermana9();
                    update_field_consulta9();
                    update_field_consulta_hermana8();
                    update_field_consulta8();
                    update_field_consulta_hermana7();
                    update_field_consulta7();
                    update_field_consulta_hermana6();
                    update_field_consulta6();
                    update_field_consulta_hermana5();
                    update_field_consulta5();
                    //update_field_consulta_hermana4();
                    //update_field_consulta4();
                    update_field_consulta_hermana3();
                    update_field_consulta3();
                    update_field_consulta_hermana1();
                    update_field_consulta1();
                    update_field_consulta_hermana();
                    update_field_consulta();
                
            
                    update_field_total();
                    
                    alert("¡Datos Calculados!, presione boton GUARDAR. Gracias.");
                    
                });
    }';

$grid1["edit_options"]["afterShowForm"] = 'function ()
    {
        $(\'<a href="#">Calcular Valores <span class="ui-icon ui-icon-calculator"></span></a>\')
        .addClass("fm-button ui-state-default ui-corner-all fm-button-icon-left")
        .prependTo("#Act_Buttons>td.EditButton")
        .click(function()
                {
                    update_field_rut();                
                    update_fiel_kine_saldo_actual();
                    update_fiel_fono_saldo_actual();
                    update_fiel_saldo_actual_cristales();
                    update_fiel_saldo_actual_receta();
                    update_field_consulta_hermana15();
                    update_field_consulta15();
                    update_field_consulta_hermana14();
                    update_field_consulta14();
                    //update_field_consulta_hermana13();
                    //update_field_consulta13();
                    update_field_consulta_hermana12();
                    update_field_consulta12();
                    update_field_consulta11();
                    update_field_consulta_hermana10();
                    update_field_consulta10();
                    update_field_consulta_hermana9();
                    update_field_consulta9();
                    update_field_consulta_hermana8();
                    update_field_consulta8();
                    update_field_consulta_hermana7();
                    update_field_consulta7();
                    update_field_consulta_hermana6();
                    update_field_consulta6();
                    update_field_consulta_hermana5();
                    update_field_consulta5();
                    //update_field_consulta_hermana4();
                    //update_field_consulta4();
                    update_field_consulta_hermana3();
                    update_field_consulta3();
                    update_field_consulta_hermana1();
                    update_field_consulta1();
                    update_field_consulta_hermana();
                    update_field_consulta();
                
            
                    update_field_total();
                    
                    alert("¡Datos Calculados!, presione boton GUARDAR. Gracias.");
                    
                });
    }';


$g1->set_actions(array(
                        "add"=>true, // allow/disallow add
                        "edit"=>true, // allow/disallow edit
                        "delete"=>true, // allow/disallow delete
                        "rowactions"=>false, // show/hide row wise edit/del/save option
                        "search" => "advance", // show single/multi field search condition (e.g. simple or advance)
                        "autofilter" => true,
                        "export_pdf" => true,
                        "view" => false
                    )
                );

$g1->table = "frm_historic";

$g1->select_command = "SELECT id, rut_asegurado_h, rut_paciente_h, bono_consulta_doctos, `Bono_Consulta_pagado`, `Bono_factor_consulta`, `Bono_consulta_reembolso`, 
`foto_boleta_original_reembolso_isapre_number`, 
`foto_boleta_original_reembolso_isapre_asegurado`, 
`foto_factor_boleta_original_reembolso_isapre`, 
`foto_boleta_original_reembolso_isapre_reembolso`, 
`bono_consulta_con_tope_reembolso_1UF_docto`, `bono_consulta_con_tope_reembolso_1UF`, `bono_consulta_con_tope_reembolso_1UF_factor`, `bono_consulta_con_tope_reembolso_1UF_reembolso`, 
`bonos_consulta_tope_isapre_docto`, 
`bonos_consulta_tope_isapre`, 
`bonos_consulta_tope_isapre_factor`, 
`bonos_consulta_tope_isapre_reembolso`, 
`consultas_psicologicas_psiquiatricas_docto`, 
`consultas_psicologicas_psiquiatricas_asegurado`, 
`consultas_psicologicas_psiquiatricas_factor`, 
`consultas_psicologicas_psiquiatricas_reembolso`,
`consulta_psico_docto`,
`consulta_psico_asegurado`,
`consulta_psico_factor`,
`consulta_psico_reembolso`,
`consulta_psico2_docto`,
`consulta_psico2_asegurado`,
`consulta_psico2_reembolso`,
`saldo_anterior`, 
`saldo_actual`, 
`bono_examen_sin_tope_docto`, 
`bono_examen_sin_tope_asegurado`,
`bono_examen_sin_tope_factor`, 
`bono_examen_sin_tope_reembolso`, 
`bono_examen_con_tope_docto`, 
`bono_examen_con_tope_asegurado`, 
`bono_examen_con_tope_factor`, 
`bono_examen_con_tope_reembolso`, 
`receta_con_nombre_beneficiario_docto`, 
`receta_con_nombre_beneficiario_asegurado`, 
`receta_con_nombre_beneficiario_factor`, 
`receta_con_nombre_beneficiario_reembolso`, 
`receta_permanente_docto`, 
`receta_permanente_asegurado`, 
`receta_permanente_factor`, 
`receta_permanente_reembolso`, 
`vigencia_desde`, 
`saldo_anterior_receta`, 
`saldo_anterior_receta2`, 
`cristales_opticos_saldo`, 
`cristales_opticos_saldo_actual`,
`fotocopia_boleta_cristales_opticos_original_docto`, 
`fotocopia_boleta_cristales_opticos_original_asegurado`, 
`fotocopia_boleta_cristales_opticos_original_factor`, 
`fotocopia_boleta_cristales_opticos_original_reembolso`, 
`boleta_original_cristales_opticos_con_timbre_docto`, 
`boleta_original_cristales_opticos_con_timbre_asegurado`, 
`boleta_original_cristales_opticos_con_timbre_factor`, 
`boleta_original_cristales_opticos_con_timbre_reembolso`, 
`fotocopia_boleta_cristales_opticos_tope_isapre_docto`, 
`fotocopia_boleta_cristales_opticos_tope_isapre_asegurado`, 
`fotocopia_boleta_cristales_opticos_tope_isapre_factor`, 
`fotocopia_boleta_cristales_opticos_tope_isapre_reembolso`, 
`hopitalizacion_programa_medico`, 
`hopitalizacion_programa_maternidad`, 
`monto_hospitalizacion`, 
`boleta_original_por_gastos_medicos_con_timbre_docto`,
`boleta_original_por_gastos_medicos_con_timbre_asegurado`,
`boleta_original_por_gastos_medicos_con_timbre_factor`, 
`boleta_original_por_gastos_medicos_con_timbre_reembolso`, 
`otros_documentos_docto`, 
`otros_documentos_asegurado`, 
`otros_documentos_factor`, 
`otros_documentos_reembolso`, 
`otros_documentos_tope_docto`, 
`otros_documentos_tope_asegurado`, 
`otros_documentos_tope_factor`, 
`otros_documentos_tope_reembolso`, 
`fonoaudiologia_docto`, 
`fonoaudiologia_asegurado`, 
`fonoaudiologia_factor`, 
`fonoaudiologia_reembolso`,
`fonoaudiologia_docto_con_tope`, 
`fonoaudiologia_asegurado_con_tope`, 
`fonoaudiologia_factor_con_tope`, 
`fonoaudiologia_reembolso_con_tope`,
`kinesioterapia_docto`,
`kinesioterapia_asegurado`,
`kinesioterapia_factor`,
`kinesioterapia_reembolso`, 
`kinesioterapia_docto_contope`,
`kinesioterapia_asegurado_contope`,
`kinesioterapia_factor_contope`,
`kinesioterapia_reembolso_contope`,
`fono_saldo`,
`fono_saldo_actual`,
`kine_saldo`,
`kine_saldo_actual`,
`saldo_anterior_general`, 
`reemboslo_actual_general`, 
`saldo_reembolsos_futuros_general`, `nro_folio`, `fecha`, `valor_uf`, 
`total_reembolso`, 
`saldo_anterior_total`, 
`reembolso_actual`, 
`saldo_futuros_reembolsos`,
`nro_cheque`
FROM frm_historic WHERE rut_asegurado_h = '".$_GET["rut_asegurado"]."'";


//$rs = $g->execute_query("select folio_number from folio;");

$axu1=0;

$col = array();
$col["title"] = "id"; // caption of column
$col["name"] = "id"; 
$col["editable"] = false;
$col["hidden"] = true;
$cols[] = $col;

$col = array();
$col["title"] = "Fecha Reembolso"; // caption of column
$col["name"] = "fecha"; 
$col["editable"] = false;
$col["visible"] = true;
$cols[] = $col;

$col = array();
$col["title"] = "Nro. Reembolso"; // caption of column
$col["name"] = "nro_folio"; 
$col["editable"] = true;
$col["visible"] = true;
$col["formoptions"] = array("rowpos"=>"1", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"102", "size"=>7,"onblur"=>"update_nroFolio()");
$cols[] = $col;

$col = array();
$col["title"] = "Valor UF"; // caption of column
$col["name"] = "valor_uf"; 
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"1", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"102", "size"=>7,"defaultValue"=>$UF);
$cols[] = $col;

$col = array();
$col["title"] = "Rut Asegurado"; // caption of column
$col["name"] = "rut_asegurado_h"; // field name, must be exactly same as with SQL prefix or db field
$col["editable"] = true;
$col["visible"] = false;
$col["editrules"] = array ('required' => true);
$col["formoptions"] = array("rowpos"=>"3", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"101", "size"=>7, "onblur"=>"update_field_rut()");
$cols[] = $col;

$col = array();
$col["title"] = "Rut Beneficiario"; // caption of column
$col["name"] = "rut_paciente_h"; 
$col["width"] = "10";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"3", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"102", "size"=>7);
$cols[] = $col;

//*****************************Bono Consulta************************
$col = array();
$col["title"] = "Bono Consulta: "; // caption of column
$col["name"] = "bono_consulta_doctos"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"5", "colpos"=>"1");
$col["editoptions"] = array("defaultValue"=>'0', "tabindex"=>"103", "size"=>3);
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "Bono_Consulta_pagado"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"5", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"104", "size"=>7, "defaultValue"=>'0', "onblur"=>"update_field_consulta()");
$cols[] = $col;

$col = array();
$col["title"] = "%"; // caption of column
$col["name"] = "Bono_factor_consulta"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"5", "colpos"=>"3");
//$x=80;
$col["editoptions"] = array("tabindex"=>"105", "size"=>3, "defaultValue"=>80, "onblur"=>"update_field_consulta()");
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "Bono_consulta_reembolso"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"5", "colpos"=>"4");
$col["editoptions"] = array("tabindex"=>"106", "size"=>7, "defaultValue"=>'0', "onblur"=>"update_field_consulta()");
$cols[] = $col;
//******************************************************************
//*****************************FOTOCOPIA BOLETA*********************
$col = array();
$col["title"] = "Fotocopia Boleta con Original reembolso Isapre"; // caption of column
$col["name"] = "foto_boleta_original_reembolso_isapre_number"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"6", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>3, "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "foto_boleta_original_reembolso_isapre_asegurado"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"6", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"104", "defaultValue"=>'0', "size"=>7, "onblur"=>"update_field_consulta1()");
$cols[] = $col;

$col = array();
$col["title"] = "%"; // caption of column
$col["name"] = "foto_factor_boleta_original_reembolso_isapre"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"6", "colpos"=>"3");
//$x=80;
$col["editoptions"] = array("tabindex"=>"105", "size"=>3, "defaultValue"=>80, "onblur"=>"update_field_consulta1()");
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "foto_boleta_original_reembolso_isapre_reembolso"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"6", "colpos"=>"4");
$col["editoptions"] = array("tabindex"=>"106", "size"=>7, "onblur"=>"update_field_consulta1()","defaultValue"=>'0');
$cols[] = $col;
//******************************************************************
//*****************************BONO CONSULTA CON TOPE***************
$col = array();
$col["title"] = "Bono Consulta con Tope de Reembolso de 1UF"; // caption of column
$col["name"] = "bonos_consulta_tope_isapre_docto"; 
$col["width"] = "2";
$col["editable"] = false;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"7", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>3, "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "bonos_consulta_tope_isapre"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 4);
$col["editable"] = false;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"7", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"104", "size"=>7, "defaultValue"=>'0');
$cols[] = $col;

//$col = array();
//$col["title"] = "%"; // caption of column
//$col["name"] = "foto_factor_boleta_original_reembolso_isapre"; 
//$col["width"] = "2";
//$col["editable"] = true;
//$col["visible"] = false;
//$col["formoptions"] = array("rowpos"=>"6", "colpos"=>"3");
////$x=80;
//$col["editoptions"] = array("tabindex"=>"105", "size"=>3, "defaultValue"=>80, "onblur"=>"update_field_consulta1()");
//$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "bonos_consulta_tope_isapre_reembolso"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 4);
$col["editable"] = false;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"7", "colpos"=>"4");
$col["editoptions"] = array("tabindex"=>"106", "defaultValue"=>'0', "size"=>7, "onblur"=>"update_field_total()");
$cols[] = $col;
//******************************************************************
//*****************************Bono consultas con tope de Isapre*
$col = array();
$col["title"] = "Bonos consulta con tope de Isapre"; // caption of column
$col["name"] = "consultas_psicologicas_psiquiatricas_docto"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"8", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>3, "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "consultas_psicologicas_psiquiatricas_asegurado"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"8", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"104", "size"=>7, "defaultValue"=>'0');
$cols[] = $col;

//$col = array();
//$col["title"] = "%"; // caption of column
//$col["name"] = "consultas_psicologicas_psiquiatricas_factor"; 
//$col["width"] = "2";
//$col["editable"] = true;
//$col["visible"] = false;
//$col["formoptions"] = array("rowpos"=>"8", "colpos"=>"3");
//$x=80;
//$col["editoptions"] = array("tabindex"=>"105", "size"=>3, "defaultValue"=>80, "onblur"=>"update_field_consulta2()");
//$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "consultas_psicologicas_psiquiatricas_reembolso"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"8", "colpos"=>"4");
$col["editoptions"] = array("tabindex"=>"106", "defaultValue"=>'0', "size"=>7, "onblur"=>"update_field_total()");
$cols[] = $col;
//******************************************************************


//**************************CONSULTA PSICO 2 ***********************
$col = array();
$col["title"] = "Bonos consulta Psicológicas y/o Psiquiatricas sin tope de Isapre"; // caption of column
$col["name"] = "consulta_psico_docto"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"9", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>3, "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "consulta_psico_asegurado"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"9", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"104", "size"=>7, "defaultValue"=>'0', "onblur"=>"update_field_consulta15()" );
$cols[] = $col;

$col = array();
$col["title"] = "%"; // caption of column
$col["name"] = "consulta_psico_factor"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"9", "colpos"=>"3");
$x=80;
$col["editoptions"] = array("tabindex"=>"105", "size"=>3, "defaultValue"=>80, "onblur"=>"update_field_consulta15()");
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "consulta_psico_reembolso"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"9", "colpos"=>"4");
$col["editoptions"] = array("tabindex"=>"106", "defaultValue"=>'0', "size"=>7, "onblur"=>"update_field_total()");
$cols[] = $col;

//******************************************************************

//**************************CONSULTA PSICO 22 ***********************
$col = array();
$col["title"] = "Bonos consulta Psicológicas y/o Psiquiatricas con tope de Isapre"; // caption of column
$col["name"] = "consulta_psico2_docto"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"10", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>3, "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "consulta_psico2_asegurado"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"10", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"104", "size"=>7, "defaultValue"=>'0');
$cols[] = $col;


$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "consulta_psico2_reembolso"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"10", "colpos"=>"4");
$col["editoptions"] = array("tabindex"=>"106", "defaultValue"=>'0', "size"=>7, "onblur"=>"update_field_total()");
$cols[] = $col;

//******************************************************************



//*****************************Saldo Anterior***********************
$col = array();
$col["title"] = "Saldo Anterior Consulta Psicológicas y/o Psiquiatricas (Tope 10UF)"; // caption of column
$col["name"] = "saldo_anterior"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 4);
$col["formoptions"] = array("rowpos"=>"11", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>7, "defaultValue"=>'0');
$cols[] = $col;
//*****************************Saldo Actual**************************
$col = array();
$col["title"] = "Monto Utilizado Consulta Psicológicas y/o Psiquiatricas (Tope 10UF)"; // caption of column
$col["name"] = "saldo_actual"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 4);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"12", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"104", "size"=>7, "defaultValue"=>'0');
$cols[] = $col;
//******************************************************************
//*****************************BONO EXAMENES SIN TOPE***************
$col = array();
$col["title"] = "Bono examenes sin tope Isapre"; // caption of column
$col["name"] = "bono_examen_sin_tope_docto"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"13", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>3, "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "bono_examen_sin_tope_asegurado"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"13", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"104", "size"=>7, "onblur"=>"update_field_consulta3()", "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "%"; // caption of column
$col["name"] = "bono_examen_sin_tope_factor"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"13", "colpos"=>"3");
//$x=80;
$col["editoptions"] = array("tabindex"=>"105", "size"=>3, "defaultValue"=>80, "onblur"=>"update_field_consulta3()");
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "bono_examen_sin_tope_reembolso"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["formoptions"] = array("rowpos"=>"13", "colpos"=>"4");
$col["editoptions"] = array("tabindex"=>"106", "size"=>7, "defaultValue"=>'0', "onblur"=>"update_field_consulta3()");
$cols[] = $col;
//***********************************************************************
//*****************************BONO EXAMEN CON TOPE *******************
//`bono_examen_con_tope_docto`, 
//`bono_examen_con_tope_asegurado`, 
//`bono_examen_con_tope_factor`, 
//`bono_examen_con_tope_reembolso`,

$col = array();
$col["title"] = "Bono examenes con tope Isapre"; // caption of column
$col["name"] = "bono_examen_con_tope_docto"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"14", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>3, "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "bono_examen_con_tope_asegurado"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"14", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"104", "size"=>7, "defaultValue"=>'0');
$cols[] = $col;

//$col = array();
//$col["title"] = "%"; // caption of column
//$col["name"] = "bono_examen_con_tope_factor"; 
//$col["width"] = "2";
//$col["editable"] = true;
//$col["visible"] = false;
//$col["formoptions"] = array("rowpos"=>"12", "colpos"=>"3");
//$x=80;
//$col["editoptions"] = array("tabindex"=>"105", "size"=>3, "defaultValue"=>80, "onblur"=>"update_field_consulta4()");
//$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "bono_examen_con_tope_reembolso"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"14", "colpos"=>"4");
$col["editoptions"] = array("tabindex"=>"106", "defaultValue"=>'0', "size"=>7, "onblur"=>"update_field_total()");
$cols[] = $col;
//***********************************************************************
//*****************************RECETA CON NOMBRE *******************
//`receta_con_nombre_beneficiario_docto`, 
//`receta_con_nombre_beneficiario_asegurado`, 
//`receta_con_nombre_beneficiario_factor`, 
//`receta_con_nombre_beneficiario_reembolso`

$col = array();
$col["title"] = "Receta con nombre de Beneficiario y timbre de farmacia (Hasta 30 Días)"; // caption of column
$col["name"] = "receta_con_nombre_beneficiario_docto"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"15", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>3, "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "receta_con_nombre_beneficiario_asegurado"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"15", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"104", "size"=>7, "onblur"=>"update_field_consulta5()", "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "%"; // caption of column
$col["name"] = "receta_con_nombre_beneficiario_factor"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"15", "colpos"=>"3");
//$x=80;
$col["editoptions"] = array("tabindex"=>"105", "size"=>3, "defaultValue"=>80, "onblur"=>"update_field_consulta5()");
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "receta_con_nombre_beneficiario_reembolso"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"15", "colpos"=>"4");
$col["editoptions"] = array("tabindex"=>"106", "size"=>7, "onblur"=>"update_field_consulta5()", "defaultValue"=>'0');
$cols[] = $col;
//**********************************************************************************
//*****************************RECETA PERMANENTE SONBRE 30 días y hasta 6 MESES*****
//`receta_permanente_docto`, 
//`receta_permanente_asegurado`, 
//`receta_permanente_factor`, 
//`receta_permanente_reembolso`, 

$col = array();
$col["title"] = "Receta PERMANENTE (Sobre 30 días y hasta 6 meses)"; // caption of column
$col["name"] = "receta_permanente_docto"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"16", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>3, "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "receta_permanente_asegurado"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"16", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"104", "size"=>7, "onblur"=>"update_field_consulta6()", "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "%"; // caption of column
$col["name"] = "receta_permanente_factor"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"16", "colpos"=>"3");
$col["editoptions"] = array("tabindex"=>"105", "size"=>3, "defaultValue"=>70, "onblur"=>"update_field_consulta6()");
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "receta_permanente_reembolso"; 
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"16", "colpos"=>"4");
$col["editoptions"] = array("tabindex"=>"106", "size"=>7, "onblur"=>"update_field_consulta6()", "defaultValue"=>'0');
$cols[] = $col;
//***********************************************************************
//*****************VIGENTE DESDE*****************************************
//$col = array();
//$col["title"] = "Vigencia Desde"; // caption of column
//$col["name"] = "vigencia_desde"; 
//$col["editable"] = true;
//$col["visible"] = false;
//$col["formatter"] = "date";
//$col["editoptions"] = array("tabindex"=>"120", "size"=>12);
//$col["formoptions"] = array("rowpos"=>"15", "colpos"=>"1");
//$col["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'d-m-Y');
//$cols[] = $col;
//**********************************************************************
//`saldo_anterior_receta`, `saldo_anterior_receta2`
//*****************VIGENTE DESDE*****************************************
$col = array();
$col["title"] = "Saldo Anterior Recetas (Tope 30UF)"; // caption of column
$col["name"] = "saldo_anterior_receta"; 
$col["editable"] = true;
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 4);
$col["visible"] = false;
$col["editoptions"] = array("tabindex"=>"121", "size"=>7);
$col["formoptions"] = array("rowpos"=>"17", "colpos"=>"1", "defaultValue"=>'0');
$cols[] = $col;
//**********************************************************************
//*****************VIGENTE DESDE*****************************************
$col = array();
$col["title"] = "Monto Utilizado en receta (Tope 30UF)"; // caption of column
$col["name"] = "saldo_anterior_receta2"; 
$col["editable"] = true;
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 4);
$col["visible"] = false;
$col["editoptions"] = array("tabindex"=>"122", "size"=>7, "onblur"=>"update_fiel_saldo_actual_receta()");
$col["formoptions"] = array("rowpos"=>"18", "colpos"=>"1", "defaultValue"=>'');
$cols[] = $col;
//**********************************************************************
//cristales_opticos_saldo

//*****************CRISTALES OPTICOS************************************
$optico = intval($_GET["mnt_optico"]);

$col = array();
$col["title"] = "Cristales Opticos Saldo Anterior"; // caption of column
$col["name"] = "cristales_opticos_saldo"; 
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"19", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"123", "size"=>7,"defaultValue"=>$optico);
$cols[] = $col;
//************************************************************************

//*****************CRISTALES SALDO ACTUAL************************************
$col = array();
$col["title"] = "Cristales Opticos Saldo Actual (Tope 4 UF)"; // caption of column
$col["name"] = "cristales_opticos_saldo_actual"; 
$col["editable"] = true;
$col["visible"] = false;
$col["editoptions"] = array("tabindex"=>"124", "size"=>7, "onblur"=>"update_fiel_saldo_actual_cristales()");
$col["formoptions"] = array("rowpos"=>"20", "colpos"=>"1", "defaultValue"=>'');
$cols[] = $col;
//**********************************************************************
//*************************************************************************
//`fotocopia_boleta_cristales_opticos_original_docto`, 
//`fotocopia_boleta_cristales_opticos_original_asegurado`, 
//`fotocopia_boleta_cristales_opticos_original_factor`, 
//`fotocopia_boleta_cristales_opticos_original_reembolso`,
//*****************************FOTOCOPIA CRISTALES OPTICOS CON Original*****
$col = array();
$col["title"] = "Fotocopia boleta cristales ópticos con original Reembolso Isapre"; // caption of column
$col["name"] = "fotocopia_boleta_cristales_opticos_original_docto"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"21", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>3, "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "fotocopia_boleta_cristales_opticos_original_asegurado"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"21", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"104", "size"=>7, "onblur"=>"update_field_consulta7()", "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "%"; // caption of column
$col["name"] = "fotocopia_boleta_cristales_opticos_original_factor"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"21", "colpos"=>"3");
$col["editoptions"] = array("tabindex"=>"105", "size"=>3, "defaultValue"=>80, "onblur"=>"update_field_consulta7()");
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "fotocopia_boleta_cristales_opticos_original_reembolso"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["formoptions"] = array("rowpos"=>"21", "colpos"=>"4");
$col["editoptions"] = array("tabindex"=>"106", "size"=>7, "onblur"=>"update_field_consulta7()", "defaultValue"=>'0');
$cols[] = $col;
//******************************************************************************************************
//`boleta_original_cristales_opticos_con_timbre_docto`, 
//`boleta_original_cristales_opticos_con_timbre_asegurado`, 
//`boleta_original_cristales_opticos_con_timbre_factor`, 
//`boleta_original_cristales_opticos_con_timbre_reembolso`,
//*****************************Boleta Original cristales ópticos con timbre de Isapre NoReembolsable****
$col = array();
$col["title"] = "Boleta Original cristales ópticos con timbre de Isapre 

"; // caption of column
$col["name"] = "boleta_original_cristales_opticos_con_timbre_docto"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"22", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>3, "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "boleta_original_cristales_opticos_con_timbre_asegurado"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"22", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"104", "size"=>7, "onblur"=>"update_field_consulta8()", "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "%"; // caption of column
$col["name"] = "boleta_original_cristales_opticos_con_timbre_factor"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"22", "colpos"=>"3");
$col["editoptions"] = array("tabindex"=>"105", "size"=>3, "defaultValue"=>80, "onblur"=>"update_field_consulta8()");
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "boleta_original_cristales_opticos_con_timbre_reembolso"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["formoptions"] = array("rowpos"=>"22", "colpos"=>"4");
$col["editoptions"] = array("tabindex"=>"106", "size"=>7, "onblur"=>"update_field_consulta8()", "defaultValue"=>'0');
$cols[] = $col;
//***********************************************************************
//`fotocopia_boleta_cristales_opticos_tope_isapre_docto`, 
//`fotocopia_boleta_cristales_opticos_tope_isapre_asegurado`, 
//`fotocopia_boleta_cristales_opticos_tope_isapre_factor`, 
//`fotocopia_boleta_cristales_opticos_tope_isapre_reembolso`
//*****************************Boleta Original cristales ópticos con timbre de Isapre NoReembolsable****
$col = array();
$col["title"] = "Fotocopia boleta cristales ópticos con Tope de Isapre"; // caption of column
$col["name"] = "fotocopia_boleta_cristales_opticos_tope_isapre_docto"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"23", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>3, "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "fotocopia_boleta_cristales_opticos_tope_isapre_asegurado"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"23", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"104", "size"=>7, "defaultValue"=>'0');
$cols[] = $col;

//$col = array();
//$col["title"] = "%"; // caption of column
//$col["name"] = "fotocopia_boleta_cristales_opticos_tope_isapre_factor"; 
//$col["width"] = "2";
//$col["editable"] = true;
//$col["visible"] = false;
//$col["formoptions"] = array("rowpos"=>"21", "colpos"=>"3");
//$col["editoptions"] = array("tabindex"=>"105", "size"=>3, "defaultValue"=>80, "onblur"=>"update_field_consulta8()");
//$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "fotocopia_boleta_cristales_opticos_tope_isapre_reembolso"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["formoptions"] = array("rowpos"=>"23", "colpos"=>"4");
$col["editoptions"] = array("tabindex"=>"106", "size"=>7, "defaultValue"=>'0', "onblur"=>"update_field_total()");
$cols[] = $col;
//**********************************************************************
//`hopitalizacion_programa_medico`, 
//`hopitalizacion_programa_maternidad`, 
//`monto_hospitalizacion`,
//*****************************PROGRAMA MEDICO*************************
$col = array();
$col["title"] = "Programa Médico"; // caption of column
$col["name"] = "hopitalizacion_programa_medico"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["edittype"] = "checkbox";
$col["formoptions"] = array("rowpos"=>"24", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "value"=>"Yes:No");
$cols[] = $col;

$col = array();
$col["title"] = "Maternidad"; // caption of column
$col["name"] = "hopitalizacion_programa_maternidad"; 
$col["width"] = "2";
$col["editable"] = true;
$col["edittype"] = "checkbox";
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"24", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"103", "value"=>"Yes:No");
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "monto_hospitalizacion"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["formoptions"] = array("rowpos"=>"24", "colpos"=>"4");
$col["editoptions"] = array("tabindex"=>"106", "size"=>7, "defaultValue"=>'0');
$cols[] = $col;
//**************************************************************************************************************
//`boleta_original_por_gastos_medicos_con_timbre_docto`,
//`boleta_original_por_gastos_medicos_con_timbre_asegurado`,
//`boleta_original_por_gastos_medicos_con_timbre_factor`, 
//`boleta_original_por_gastos_medicos_con_timbre_reembolso`
$col = array();
$col["title"] = "Boleta Original por gastos médicos con timbre de Isapre"; // caption of column
$col["name"] = "boleta_original_por_gastos_medicos_con_timbre_docto"; 
$col["width"] = "2";
$col["editable"] = false;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"25", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>3, "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "boleta_original_por_gastos_medicos_con_timbre_asegurado"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = false;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"25", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"104", "size"=>7, "onblur"=>"update_field_consulta9()", "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "%"; // caption of column
$col["name"] = "boleta_original_por_gastos_medicos_con_timbre_factor"; 
$col["width"] = "2";
$col["editable"] = false;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"25", "colpos"=>"3");
$col["editoptions"] = array("tabindex"=>"105", "size"=>3, "defaultValue"=>50, "onblur"=>"update_field_consulta9()");
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "boleta_original_por_gastos_medicos_con_timbre_reembolso"; 
$col["width"] = "2";
$col["editable"] = false;
$col["visible"] = false;
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["formoptions"] = array("rowpos"=>"25", "colpos"=>"4");
$col["editoptions"] = array("tabindex"=>"106", "size"=>7, "onblur"=>"update_field_consulta9()", "defaultValue"=>'0');
$cols[] = $col;
//**************************************************
//**************************************************************************************************************
//`boleta_original_por_gastos_medicos_con_timbre_docto`,
//`boleta_original_por_gastos_medicos_con_timbre_asegurado`,
//`boleta_original_por_gastos_medicos_con_timbre_factor`, 
//`boleta_original_por_gastos_medicos_con_timbre_reembolso`
$col = array();
$col["title"] = "Boleta Original por gastos médicos con timbre de Isapre NO REEMBOLSABLE"; // caption of column
$col["name"] = "boleta_original_por_gastos_medicos_con_timbre_docto"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"26", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>3, "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "50% Boleta $"; // caption of column
$col["name"] = "boleta_original_por_gastos_medicos_con_timbre_asegurado"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 4);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"26", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"104", "size"=>7, "onblur"=>"update_field_consulta9()", "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "%"; // caption of column
$col["name"] = "boleta_original_por_gastos_medicos_con_timbre_factor"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"26", "colpos"=>"3");
$col["editoptions"] = array("tabindex"=>"105", "size"=>3, "defaultValue"=>50, "onblur"=>"update_field_consulta9()");
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "boleta_original_por_gastos_medicos_con_timbre_reembolso"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"26", "colpos"=>"4");
$col["editoptions"] = array("tabindex"=>"106", "size"=>7, "onblur"=>"update_field_consulta9()", "defaultValue"=>'0');
$cols[] = $col;
//**************************************************
//`otros_documentos_docto`, 
//`otros_documentos_asegurado`, 
//`otros_documentos_factor`, 
//`otros_documentos_reembolso`, 
//**************************************************************************************************************
$col = array();
$col["title"] = "Otros Documentos Reembolsables sin Tope Isapre"; // caption of column
$col["name"] = "otros_documentos_docto"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"27", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>3, "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "otros_documentos_asegurado"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"27", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"104", "size"=>7, "onblur"=>"update_field_consulta10()", "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "%"; // caption of column
$col["name"] = "otros_documentos_factor"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"27", "colpos"=>"3");
$col["editoptions"] = array("tabindex"=>"105", "size"=>3, "defaultValue"=>80, "onblur"=>"update_field_consulta10()");
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "otros_documentos_reembolso"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"27", "colpos"=>"4");
$col["editoptions"] = array("tabindex"=>"106", "size"=>7, "onblur"=>"update_field_consulta10()", "defaultValue"=>'0');
$cols[] = $col;
//**************************************************
//`otros_documentos_tope_docto`, 
//`otros_documentos_tope_asegurado`, 
//`otros_documentos_tope_factor`, 
//`otros_documentos_tope_reembolso`, 
//**************************************************************************************************************
$col = array();
$col["title"] = "Otros Documentos Reembolsables con Tope Isapre"; // caption of column
$col["name"] = "otros_documentos_tope_docto"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"28", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>3, "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "otros_documentos_tope_asegurado"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"28", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"104", "size"=>7, "onblur"=>"update_field_consulta11()", "defaultValue"=>'0');
$cols[] = $col;

//$col = array();
//$col["title"] = "%"; // caption of column
//$col["name"] = "otros_documentos_tope_factor"; 
//$col["width"] = "2";
//$col["editable"] = true;
//$col["visible"] = false;
//$col["formoptions"] = array("rowpos"=>"26", "colpos"=>"3");
//$col["editoptions"] = array("tabindex"=>"105", "size"=>3, "defaultValue"=>80, "onblur"=>"update_field_consulta11()");
//$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "otros_documentos_tope_reembolso"; 
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"28", "colpos"=>"4");
$col["editoptions"] = array("tabindex"=>"106", "size"=>7, "onblur"=>"update_field_consulta11()", "defaultValue"=>'0');
$cols[] = $col;
//**************************************************
//`fonoaudiologia_docto`, 
//`fonoaudiologia_asegurado`, 
//`fonoaudiologia_factor`, 
//`fonoaudiologia_reembolso`,

$col = array();
$col["title"] = "Fonoaudiología Saldo Anterior"; // caption of column
$col["name"] = "fono_saldo"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"29", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>3, "defaultValue"=>'0');
$cols[] = $col;

//**************************************************
$col = array();
$col["title"] = "Fonoaudiología Saldo Actual (Tope 10UF)"; // caption of column
$col["name"] = "fono_saldo_actual"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"30", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>3, "defaultValue"=>'0');
$cols[] = $col;

//**************************************************

$col = array();
$col["title"] = "Fonoaudiología (Tope 10UF)"; // caption of column
$col["name"] = "fonoaudiologia_docto"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"31", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>3, "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "fonoaudiologia_asegurado"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"31", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"104", "size"=>7, "onblur"=>"update_field_consulta12()", "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "%"; // caption of column
$col["name"] = "fonoaudiologia_factor"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"31", "colpos"=>"3");
$col["editoptions"] = array("tabindex"=>"105", "size"=>3, "defaultValue"=>80, "onblur"=>"update_field_consulta12()");
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "fonoaudiologia_reembolso"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"31", "colpos"=>"4");
$col["editoptions"] = array("tabindex"=>"106", "size"=>7, "onblur"=>"update_field_consulta12()", "defaultValue"=>'0');
$cols[] = $col;
//**************************************************
//**************************************************
//`fonoaudiologia_docto_con_tope`, 
//`fonoaudiologia_asegurado_con_tope`, 
//`fonoaudiologia_factor_con_tope`, 
//`fonoaudiologia_reembolso_con_tope`,
$col = array();
$col["title"] = "Fonoaudiología Con Tope Isapre"; // caption of column
$col["name"] = "fonoaudiologia_docto_con_tope"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"32", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>3, "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "fonoaudiologia_asegurado_con_tope"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"32", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"104", "size"=>7, "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "fonoaudiologia_reembolso_con_tope"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"32", "colpos"=>"4");
$col["editoptions"] = array("tabindex"=>"106", "size"=>7, "defaultValue"=>'0', "onblur"=>"update_field_total()");
$cols[] = $col;
//**************************************************



//***************Kinesioterapia Saldo Anterior***********************
$col = array();
$col["title"] = "Kinesioterapia Saldo Anterior"; // caption of column
$col["name"] = "kine_saldo";
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"33", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>3, "defaultValue"=>'0');
$cols[] = $col;

//*******************************************************************
//***************Kinesioterapia Saldo Anterior***********************
$col = array();
$col["title"] = "Kinesioterapia Saldo Actual (Tope 10UF)"; // caption of column
$col["name"] = "kine_saldo_actual";
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"34", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>3, "defaultValue"=>'0');
$cols[] = $col;

//*******************************************************************


//`kinesioterapia_docto`,
//`kinesioterapia_asegurado`,
//`kinesioterapia_factor`,
//`kinesioterapia_reembolso`,

$col = array();
$col["title"] = "Kinesioterapia (Tope 10UF)"; // caption of column
$col["name"] = "kinesioterapia_docto"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"35", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>3, "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "kinesioterapia_asegurado"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"35", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"104", "size"=>7, "onblur"=>"update_field_consulta14()", "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "%"; // caption of column
$col["name"] = "kinesioterapia_factor"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"35", "colpos"=>"3");
$col["editoptions"] = array("tabindex"=>"105", "size"=>3, "defaultValue"=>80, "onblur"=>"update_field_consulta14()");
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "kinesioterapia_reembolso"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"35", "colpos"=>"4");
$col["editoptions"] = array("tabindex"=>"106", "size"=>7, "onblur"=>"update_field_consulta14()", "defaultValue"=>'0');
$cols[] = $col;
//**************************************************
//**************************************************
//`kinesioterapia_docto_contope`,
//`kinesioterapia_asegurado_contope`,
//`kinesioterapia_factor_contope`,
//`kinesioterapia_reembolso_contope`,

$col = array();
$col["title"] = "Kinesioterapia Con Tope Isapre"; // caption of column
$col["name"] = "kinesioterapia_docto_contope"; 
$col["width"] = "2";
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"36", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"103", "size"=>3, "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "kinesioterapia_asegurado_contope"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"36", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"104", "size"=>7, "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "$"; // caption of column
$col["name"] = "kinesioterapia_reembolso_contope"; 
$col["width"] = "2";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"36", "colpos"=>"4");
$col["editoptions"] = array("tabindex"=>"106", "size"=>7, "defaultValue"=>0, "defaultValue"=>'0', "onblur"=>"update_field_total()");
$cols[] = $col;
//**************************************************
//`total_reembolso`, 
//`saldo_anterior_total`, 
//`reembolso_actual`, 
//`saldo_futuros_reembolsos`
$col = array();
$col["title"] = "Total Reembolso $"; // caption of column
$col["name"] = "total_reembolso"; 
$col["editable"] = true;
$col["visible"] = true;
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "$",
                                "suffix" => '',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
$col["formoptions"] = array("rowpos"=>"37", "colpos"=>"1", "thousandsSeparator" => ".", "decimalPlaces" => 0);
$col["editoptions"] = array("tabindex"=>"106", "size"=>7, "onblur"=>"update_field_total()", "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "Saldo Anterior (UF)"; // caption of column
$col["name"] = "saldo_anterior_total"; 
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "",
                                "suffix" => ' UF',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 4);
$col["editable"] = true;
$col["visible"] = false;
$col["formoptions"] = array("rowpos"=>"38", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"106", "size"=>7, "onblur"=>"update_field_total()", "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "Reembolso Actual (UF)"; // caption of column
$col["name"] = "reembolso_actual";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "",
                                "suffix" => ' UF',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 4);
$col["editable"] = true;
$col["visible"] = true;
$col["formoptions"] = array("rowpos"=>"38", "colpos"=>"2");
$col["editoptions"] = array("tabindex"=>"106", "size"=>7, "onblur"=>"update_field_total()", "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "Saldo Futuros Reembolsos (UF)"; // caption of column
$col["name"] = "saldo_futuros_reembolsos";
$col["formatter"] = "currency";
$col["formatoptions"] = array("prefix" => "",
                                "suffix" => ' UF',
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 4);
$col["editable"] = true;
$col["visible"] = true;
$col["formoptions"] = array("rowpos"=>"39", "colpos"=>"1");
$col["editoptions"] = array("tabindex"=>"106", "size"=>7, "onblur"=>"update_field_total()", "defaultValue"=>'0');
$cols[] = $col;

$col = array();
$col["title"] = "Nro Transferencia"; // caption of column
$col["name"] = "nro_cheque"; 
$col["width"] = "60";
$col["editable"] = false;
$col["visible"] = true;
$cols[] = $col;

$col = array();
$col["title"] = "table_total";
$col["name"] = "table_total";
$col["width"] = "100";
$col["hidden"] = true;
$cols[] = $col;

// virtual column for running total
$col = array();
$col["title"] = "running_total";
$col["name"] = "running_total";
$col["width"] = "100";
$col["hidden"] = true;
$cols[] = $col;

//$col = array();
//$col["title"] = "Comp.";
//$col["name"] = "ver_comprobante";
//$col["width"] = "30";
//$col["default"] = "<button onclick='openWin1({nro_folio})' class='btn'><i class='fa fa-bars'></i></button>";
//$col["editable"] = false;
//$col["search"] = false;
//$col["align"] = "center";
//$col["link"] = "http://www.andreebienestar.cl/topdf/TCPDF-master/examples/reportepdf.php?id={nro_folio}";
//$col["linkoptions"] = "target='_blank'";
//$col["hidden"] = true;
//$cols[] = $col;

$col = array();
$col["title"] = "Notificar";
$col["name"] = "print";
$col["width"] = "40";
$col["align"] = "center";
$col["editable"] = false;
$col["search"] = false;
$col["default"] = "<button onclick='openWin({nro_folio})' class='btn'><i class='fa fa-envelope'></i></button>";
$cols[] = $col;

$col = array();
$col["title"] = "Asignar Nro. Tranferencia";
$col["name"] = "cheque";
$col["width"] = "50";
$col["align"] = "center";
$col["editable"] = false;
$col["search"] = false;
$col["default"] = "<button onclick='openWin2({nro_folio})' class='btn'><i class='fa fa-address-card'></i></button>";
$cols[] = $col;


// running total calculation
$e1 = array();

$e1["on_data_display"] = array("pre_render","",true);
$e1["js_on_load_complete"] = "grid_onload";


$g1->set_events($e1);


function pre_render($data)
{
	$rows = $_GET["jqgrid_page"] * $_GET["rows"];
	$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
	$sord = $_GET['sord']; // get the direction
	
	$swhere = "WHERE rut_asegurado_h = '".$_GET["rut_asegurado"]."'";

	global $g;
	
	// running total
	//$result = $g->execute_query("SELECT SUM(saldo_futuros_reembolsos) as s FROM (SELECT saldo_futuros_reembolsos FROM frm_historic $swhere ORDER BY $sidx $sord LIMIT $rows) AS tmp");

	//$result = $g->execute_query("SELECT TRUNCATE(SUM(total_reembolso),2) as s FROM (SELECT total_reembolso FROM frm_historic $swhere) AS tmp");
	
	//$rs = $result->GetRows();
	//$rs = $rs[0];
	//foreach($data["params"] as &$d)
	//{
	//	$d["running_total"] = $rs["s"];
	//}
	
    // table total (with filter)
	$result = $g->execute_query("SELECT TRUNCATE(SUM(reembolso_actual),2) as s FROM (SELECT reembolso_actual FROM frm_historic $swhere) AS tmp");
	$rs = $result->GetRows();
	$rs = $rs[0];
	foreach($data["params"] as &$d)
	{
		$d["table_total"] = $rs["s"];
	}
}




$g1->set_columns($cols);
$g1->set_options($grid1);
$out1 = $g1->render("list2");

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

<body>
	<div style="margin:30px;top:50px">
	<?php echo $out?>
	</div>
	<div style="margin:30px;top:50px">
	<?php echo $out1?>
	</div>
	
	<script>
	var rd;
	var total=0;
	var a=0,b=0,c=0,d=0,e=0,f=0,g=0,h=0,i=0,j=0,k=0,l=0,m=0,n=0,o=0;

    var myWindow;

    function openWin(op) {
        window.open("http://www.andreebienestar.cl/sendmail.php?j="+op, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=100,width=200,height=200");
    }
    
    function openWin1(op) {
        var left = (screen.width - myWidth) / 2;
        var top = (screen.height - myHeight) / 4;
        window.open("http://www.andreebienestar.cl/topdf/TCPDF-master/examples/reportepdf.php?id="+op, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=300,left=300,width=800,height=600");
    }
    
    function openWin2(op) {

        var left = 300;
        var top = 400;

        window.open("http://www.andreebienestar.cl/cheque.php?folio="+op, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=" + top + ",left=" + left + ",width=400,height=140");
    }

	function update_field_consulta()
	{
	    a=0;
	    //alert($('#Bono_factor_consulta').val());
	    var x = $('#Bono_factor_consulta').val();
	    var y = $('#Bono_Consulta_pagado').val();
	    
	    var z = (y * x) / 100;
	    a= parseInt(z);
        {jQuery('input[name="Bono_consulta_reembolso"]:visible').val(parseInt(z));}
        
        update_field_total();
    }
    
    function update_field_consulta_hermana()
	{
	    a=0;
	    //alert($('#Bono_factor_consulta').val());
	    var x = $('#Bono_factor_consulta').val();
	    var y = $('#Bono_Consulta_pagado').val();
	    
	    var z = (y * x) / 100;
	    a= parseInt(z);
        {jQuery('input[name="Bono_consulta_reembolso"]:visible').val(parseInt(z));}
    }
    
    function update_field_consulta1()
	{
	    b=0;
	    //alert($('#Bono_factor_consulta').val());
	    var x = $('#foto_boleta_original_reembolso_isapre_asegurado').val();
	    var y = $('#foto_factor_boleta_original_reembolso_isapre').val();
	    var z = (y * x) / 100;
	    b= parseInt(z);
        {jQuery('input[name="foto_boleta_original_reembolso_isapre_reembolso"]:visible').val(parseInt(z));}
        
        update_field_total();
    }
    
    
    function update_field_consulta_hermana1()
	{
	    b=0;
	    //alert($('#Bono_factor_consulta').val());
	    var x = $('#foto_boleta_original_reembolso_isapre_asegurado').val();
	    var y = $('#foto_factor_boleta_original_reembolso_isapre').val();
	    var z = (y * x) / 100;
	    b= parseInt(z);
        {jQuery('input[name="foto_boleta_original_reembolso_isapre_reembolso"]:visible').val(parseInt(z));}
        
    }
    
    //function update_field_consulta2()
	//{
	//    c=0;
	//    //alert($('#Bono_factor_consulta').val());
	//    var x = $('#consultas_psicologicas_psiquiatricas_asegurado').val();
	//    var y = $('#consultas_psicologicas_psiquiatricas_factor').val();
	//    var z = (y * x) / 100;
	    
	//    c= parseInt(z);
    //    {jQuery('input[name="consultas_psicologicas_psiquiatricas_reembolso"]:visible').val(parseInt(z));}
    //    
    //    update_field_total();
    //}
    
    //function update_field_consulta_hermana2()
//	{
//	    c=0;
	    //alert($('#Bono_factor_consulta').val());
//	    var x = $('#consultas_psicologicas_psiquiatricas_asegurado').val();
//	    var y = $('#consultas_psicologicas_psiquiatricas_factor').val();
//	    var z = (y * x) / 100;
	    
//	    c= parseInt(z);
//        {jQuery('input[name="consultas_psicologicas_psiquiatricas_reembolso"]:visible').val(parseInt(z));}
//    }
    
        function update_field_consulta3()
	{
	    d=0;
	    //alert($('#Bono_factor_consulta').val());
	    var x = $('#bono_examen_sin_tope_asegurado').val();
	    var y = $('#bono_examen_sin_tope_factor').val();
	    var z = (y * x) / 100;
	    d= parseInt(z);
        {jQuery('input[name="bono_examen_sin_tope_reembolso"]:visible').val(parseInt(z));}
        
        update_field_total();
    }
    
    function update_field_consulta_hermana3()
	{
	    d=0;
	    //alert($('#Bono_factor_consulta').val());
	    var x = $('#bono_examen_sin_tope_asegurado').val();
	    var y = $('#bono_examen_sin_tope_factor').val();
	    var z = (y * x) / 100;
	    d= parseInt(z);
        {jQuery('input[name="bono_examen_sin_tope_reembolso"]:visible').val(parseInt(z));}
        
    }

    function update_field_consulta4()
	{
	    e=0;
	    //alert($('#Bono_factor_consulta').val());
	    var x = $('#bono_examen_con_tope_asegurado').val();
	    var y = $('#bono_examen_con_tope_factor').val();
	    
	    var z = (y * x) / 100;
	    e= parseInt(z);
        {jQuery('input[name="bono_examen_con_tope_reembolso"]:visible').val(parseInt(z));}
        
        update_field_total();
    }
    
    function update_field_consulta_hermana4()
	{
	    e=0;
	    //alert($('#Bono_factor_consulta').val());
	    var x = $('#bono_examen_con_tope_asegurado').val();
	    var y = $('#bono_examen_con_tope_factor').val();
	    
	    var z = (y * x) / 100;
	    e= parseInt(z);
        {jQuery('input[name="bono_examen_con_tope_reembolso"]:visible').val(parseInt(z));}
    }
    
    
    function update_field_consulta5()
	{
	    f=0;
	    //alert($('#Bono_factor_consulta').val());
	    var x = $('#receta_con_nombre_beneficiario_asegurado').val();
	    var y = $('#receta_con_nombre_beneficiario_factor').val();
	    var z = (y * x) / 100;
        f= parseInt(z);
        {jQuery('input[name="receta_con_nombre_beneficiario_reembolso"]:visible').val(parseInt(z));}
        
        update_field_total();
    }
    
    function update_field_consulta_hermana5()
	{
	    f=0;
	    //alert($('#Bono_factor_consulta').val());
	    var x = $('#receta_con_nombre_beneficiario_asegurado').val();
	    var y = $('#receta_con_nombre_beneficiario_factor').val();
	    var z = (y * x) / 100;
        f= parseInt(z);
        {jQuery('input[name="receta_con_nombre_beneficiario_reembolso"]:visible').val(parseInt(z));}
    }
    
    function update_field_consulta6()
	{
	    g=0;
	    var x = $('#receta_permanente_asegurado').val();
	    var y = $('#receta_permanente_factor').val();
	    var z = (y * x) / 100;
	    g= parseInt(z);
        {jQuery('input[name="receta_permanente_reembolso"]:visible').val(parseInt(z));}
        
        update_field_total();
    }
    
    function update_field_consulta_hermana6()
	{
	    g=0;
	    var x = $('#receta_permanente_asegurado').val();
	    var y = $('#receta_permanente_factor').val();
	    var z = (y * x) / 100;
	    g= parseInt(z);
        {jQuery('input[name="receta_permanente_reembolso"]:visible').val(parseInt(z));}
    }

    function update_field_consulta7()
	{
	    h=0;
	    var x = $('#fotocopia_boleta_cristales_opticos_original_asegurado').val();
	    var y = $('#fotocopia_boleta_cristales_opticos_original_factor').val();
	    var z = (y * x) / 100;
        h= parseInt(z);
        {jQuery('input[name="fotocopia_boleta_cristales_opticos_original_reembolso"]:visible').val(parseInt(z));}
        
        update_field_total();
        update_fiel_saldo_actual_cristales();
    }
    
    function update_field_consulta_hermana7()
	{
	    h=0;
	    var x = $('#fotocopia_boleta_cristales_opticos_original_asegurado').val();
	    var y = $('#fotocopia_boleta_cristales_opticos_original_factor').val();
	    var z = (y * x) / 100;
        h= parseInt(z);
        {jQuery('input[name="fotocopia_boleta_cristales_opticos_original_reembolso"]:visible').val(parseInt(z));}
        
        //update_field_total();
        //update_fiel_saldo_actual_cristales();
    }
    
       function update_field_consulta8()
	{
	    i=0;
	    var x = $('#boleta_original_cristales_opticos_con_timbre_asegurado').val();
	    var y = $('#boleta_original_cristales_opticos_con_timbre_factor').val();
	    var z = (y * x) / 100;
	    i= parseInt(z);
        {jQuery('input[name="boleta_original_cristales_opticos_con_timbre_reembolso"]:visible').val(parseInt(z));}
        
        update_field_total();
        update_fiel_saldo_actual_cristales();
        
    }

    function update_field_consulta_hermana8()
	{
	    i=0;
	    var x = $('#boleta_original_cristales_opticos_con_timbre_asegurado').val();
	    var y = $('#boleta_original_cristales_opticos_con_timbre_factor').val();
	    var z = (y * x) / 100;
	    i= parseInt(z);
        {jQuery('input[name="boleta_original_cristales_opticos_con_timbre_reembolso"]:visible').val(parseInt(z));}
        
        //update_field_total();
        //update_fiel_saldo_actual_cristales();
    }

    function update_field_consulta9()
	{
	    j=0;
	    var x = $('#boleta_original_por_gastos_medicos_con_timbre_asegurado').val();
	    var y = $('#boleta_original_por_gastos_medicos_con_timbre_factor').val();
	    var z = (y * x) / 100;
        j= parseInt(z);
        {jQuery('input[name="boleta_original_por_gastos_medicos_con_timbre_reembolso"]:visible').val(parseInt(z));}
        update_field_total();
    }
    
    function update_field_consulta_hermana9()
	{
	    j=0;
	    var x = $('#boleta_original_por_gastos_medicos_con_timbre_asegurado').val();
	    var y = $('#boleta_original_por_gastos_medicos_con_timbre_factor').val();
	    var z = (y * x) / 100;
        j= parseInt(z);
        {jQuery('input[name="boleta_original_por_gastos_medicos_con_timbre_reembolso"]:visible').val(parseInt(z));}
    }
    
    function update_field_consulta10()
	{
	    k=0;
	    var x = $('#otros_documentos_asegurado').val();
	    var y = $('#otros_documentos_factor').val();
	    var z = (y * x) / 100;
        k= parseInt(z);
        {jQuery('input[name="otros_documentos_reembolso"]:visible').val(parseInt(z));}
        
        update_field_total();
    }
    
    
    function update_field_consulta_hermana10()
	{
	    k=0;
	    var x = $('#otros_documentos_asegurado').val();
	    var y = $('#otros_documentos_factor').val();
	    var z = (y * x) / 100;
        k= parseInt(z);
        {jQuery('input[name="otros_documentos_reembolso"]:visible').val(parseInt(z));}
    }
    
    function update_field_consulta11()
	{
	    //l=0;
	    //var x = $('#otros_documentos_tope_asegurado').val();
	    //var y = $('#otros_documentos_tope_factor').val();
	    //var z = (y * x) / 100;
        //l= parseInt(z);
        //{jQuery('input[name="otros_documentos_tope_reembolso"]:visible').val(parseInt(z));}
        
        update_field_total();
        update_fiel_saldo_actual_cristales();
    }

    function update_field_consulta12()
	{
	    m=0;
	    var x = $('#fonoaudiologia_asegurado').val();
	    var y = $('#fonoaudiologia_factor').val();
	    var z = (y * x) / 100;
        m= parseInt(z);
        {jQuery('input[name="fonoaudiologia_reembolso"]:visible').val(parseInt(z));}
        
        update_field_total();
        update_fiel_fono_saldo_actual();
    }
    
    function update_field_consulta_hermana12()
	{
	    m=0;
	    var x = $('#fonoaudiologia_asegurado').val();
	    var y = $('#fonoaudiologia_factor').val();
	    var z = (y * x) / 100;
        m= parseInt(z);
        {jQuery('input[name="fonoaudiologia_reembolso"]:visible').val(parseInt(z));}
        
        //update_field_total();
        //update_fiel_fono_saldo_actual();
    }

    function update_field_consulta13()
	{
	    n=0;
	    var x = $('#fonoaudiologia_asegurado_con_tope').val();
	    var y = $('#fonoaudiologia_factor_con_tope').val();
	    var z = (y * x) / 100;
        n= parseInt(z);
        {jQuery('input[name="fonoaudiologia_reembolso_con_tope"]:visible').val(parseInt(z));}
        
        update_field_total();
    }
    
    function update_field_consulta_hermana13()
	{
	    n=0;
	    var x = $('#fonoaudiologia_asegurado_con_tope').val();
	    var y = $('#fonoaudiologia_factor_con_tope').val();
	    var z = (y * x) / 100;
        n= parseInt(z);
        {jQuery('input[name="fonoaudiologia_reembolso_con_tope"]:visible').val(parseInt(z));}
        
       //update_field_total();
    }
    
    function update_field_consulta14()
	{
	    o=0;
	    var x = $('#kinesioterapia_asegurado').val();
	    var y = $('#kinesioterapia_factor').val();
	    var z = (y * x) / 100;
        o = parseInt(z);
        {jQuery('input[name="kinesioterapia_reembolso"]:visible').val(parseInt(z));}
        update_field_total();
    }
    
        
    function update_field_consulta_hermana14()
	{
	    o=0;
	    var x = $('#kinesioterapia_asegurado').val();
	    var y = $('#kinesioterapia_factor').val();
	    var z = (y * x) / 100;
        o = parseInt(z);
        {jQuery('input[name="kinesioterapia_reembolso"]:visible').val(parseInt(z));}
        //update_field_total();
    }
    
    function update_field_consulta15()
	{
	    o=0;
	    var x = $('#consulta_psico_asegurado').val();
	    var y = $('#consulta_psico_factor').val();
	    var z = (y * x) / 100;
        o = parseInt(z);
        {jQuery('input[name="consulta_psico_reembolso"]:visible').val(parseInt(z));}
        
        update_field_total();
    }
    
    
    function update_field_consulta_hermana15()
	{
	    o=0;
	    var x = $('#consulta_psico_asegurado').val();
	    var y = $('#consulta_psico_factor').val();
	    var z = (y * x) / 100;
        o = parseInt(z);
        {jQuery('input[name="consulta_psico_reembolso"]:visible').val(parseInt(z));}
        
        //update_field_total();
    }

    function update_field_total()
	{
	    var p=0;
	    
	    update_field_consulta_hermana();
	    update_field_rut();
	    //Actualizo todas los registros antes de calcular:
        //update_field_consulta_hermana1();
        //update_field_consulta_hermana2();
        //update_field_consulta_hermana3();
        //update_field_consulta_hermana4();
        //update_field_consulta_hermana5();
        //update_field_consulta_hermana6();
        //update_field_consulta_hermana7();
        //update_field_consulta_hermana8();
        //update_field_consulta_hermana9();
        //update_field_consulta_hermana10();
        //update_field_consulta_hermana12();
        //update_field_consulta_hermana13();
        //update_field_consulta_hermana14();
        //update_field_consulta_hermana15();

	    /////////////////////////////////////////////////////
	    
        //var q = $('#bonos_consulta_tope_isapre_reembolso').val();
        var r = $('#consultas_psicologicas_psiquiatricas_reembolso').val();
        var s = $('#bono_examen_con_tope_reembolso').val();
        var t = $('#fotocopia_boleta_cristales_opticos_tope_isapre_reembolso').val();
        var u = $('#monto_hospitalizacion').val();
        var v = $('#fonoaudiologia_reembolso_con_tope').val();
        var w = $('#kinesioterapia_reembolso_contope').val();
        var x = $('#consulta_psico_reembolso').val();
        var y = $('#consulta_psico2_reembolso').val();
        
        a = $('#Bono_consulta_reembolso').val();
        b = $('#foto_boleta_original_reembolso_isapre_reembolso').val();
        c = $('#bono_examen_sin_tope_reembolso').val();
        d = $('#receta_con_nombre_beneficiario_reembolso').val();
        e = $('#receta_permanente_reembolso').val();
        f = $('#fotocopia_boleta_cristales_opticos_original_reembolso').val();
        g = $('#boleta_original_cristales_opticos_con_timbre_reembolso').val();
        h = $('#boleta_original_por_gastos_medicos_con_timbre_reembolso').val();
        i = $('#otros_documentos_reembolso').val();
        j = $('#otros_documentos_tope_reembolso').val();
        k = $('#fonoaudiologia_reembolso').val();
        l = $('#kinesioterapia_reembolso').val();
        //p = a + b + c + d + e + f + g + h + i + j + k + l + m + n + o;
        
        p = p + parseInt(a);
        p = p + parseInt(b);
        p = p + parseInt(c);
        p = p + parseInt(d);
        p = p + parseInt(e);
        p = p + parseInt(f);
        p = p + parseInt(g);
        p = p + parseInt(h);
        p = p + parseInt(i);
        p = p + parseInt(j);
        p = p + parseInt(k);
        p = p + parseInt(l);
        
        //p = p + parseInt(q);
        p = p + parseInt(r);
        p = p + parseInt(s);
        p = p + parseInt(t);
        p = p + parseInt(u);
        p = p + parseInt(v);
        p = p + parseInt(w);
        p = p + parseInt(x);
        p = p + parseInt(y);
        
        
        //Monto Utilizado Consulta Psico******************
        var uf2 = $('#valor_uf').val();
        var paux1=parseInt(x);
        var paux2=parseInt(y);
        
        var ppsico = (paux1 + paux2) / parseInt(uf2);
        
        {jQuery('input[name="saldo_actual"]:visible').val(ppsico.toFixed(4));}
        //*********************************
        
        {jQuery('input[name="total_reembolso"]:visible').val(p);}
         
         var uf = $('#valor_uf').val();
         var pp = (parseInt(p) / parseInt(uf));
         
         {jQuery('input[name="reembolso_actual"]:visible').val(pp.toFixed(4));}
         
         var pp2 = $('#saldo_anterior_total').val() - pp;
         
        {jQuery('input[name="saldo_futuros_reembolsos"]:visible').val(pp2.toFixed(4));}
        
        update_fiel_fono_saldo_actual();
        update_fiel_kine_saldo_actual();
    }

    function do_onselect(id)
    {
        rd = jQuery('#list1').jqGrid('getCell', id, 'rut_asegurado'); // where invdate is column name
    }
    
    function update_field_rut()
    {
        var xx=0;
        {jQuery('input[name="rut_asegurado_h"]:visible').val(rd);}
        
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                
                if (this.readyState == 4 && this.status == 200) {
                    xx = this.responseText;
                    {jQuery('input[name="saldo_anterior_total"]:visible').val(xx);}
                }
            };
            xmlhttp.open("GET","saldoactual.php?rut_asegurado="+rd,true);
            xmlhttp.send();    
    }
    
    
    function update_fiel_saldo_actual_receta()
    {
        var receta1 = 0;
        var receta2 = 0;
        var valorUF = 0; 
        var resultado = 0;
        
        receta1 = $('#receta_con_nombre_beneficiario_reembolso').val();
        receta2 = $('#receta_permanente_reembolso').val();
        valorUF = $('#valor_uf').val();
        resultado = (parseInt(receta1) + parseInt(receta2)) / parseInt(valorUF);
        
        {jQuery('input[name="saldo_anterior_receta2"]:visible').val(resultado.toFixed(4));}
    }
    
    function update_fiel_saldo_actual_cristales()
    {
        
        //fotocopia_boleta_cristales_opticos_original_reembolso
        //boleta_original_cristales_opticos_con_timbre_reembolso
        //fotocopia_boleta_cristales_opticos_tope_isapre_reembolso
        
        
        var optico1 = 0;
        var optico2 = 0;
        var optico3 = 0;
        
        var valorUF = 0; 
        var resultado = 0;
        
        optico1 = $('#fotocopia_boleta_cristales_opticos_original_reembolso').val();
        optico2 = $('#boleta_original_cristales_opticos_con_timbre_reembolso').val();
        optico3 = $('#fotocopia_boleta_cristales_opticos_tope_isapre_reembolso').val();
        
        valorUF = $('#valor_uf').val();
        resultado = (parseInt(optico1) + parseInt(optico2) + parseInt(optico3)) / parseInt(valorUF);
        
        {jQuery('input[name="cristales_opticos_saldo_actual"]:visible').val(resultado.toFixed(4));}
    }
    
    function update_fiel_fono_saldo_actual()
    {
        
        //fotocopia_boleta_cristales_opticos_original_reembolso
        //boleta_original_cristales_opticos_con_timbre_reembolso
        //fotocopia_boleta_cristales_opticos_tope_isapre_reembolso
        
        
        var fono1 = 0;
        var fono2 = 0;
        
        var valorUF = 0; 
        var resultado = 0;
        
        fono1 = $('#fonoaudiologia_reembolso').val();
        fono2 = $('#fonoaudiologia_reembolso_con_tope').val();
        
        valorUF = $('#valor_uf').val();
        resultado = (parseInt(fono1) + parseInt(fono2)) / parseInt(valorUF);
        
        {jQuery('input[name="fono_saldo_actual"]:visible').val(resultado.toFixed(4));}
    }
    
    function update_fiel_kine_saldo_actual()
    {
        
        //fotocopia_boleta_cristales_opticos_original_reembolso
        //boleta_original_cristales_opticos_con_timbre_reembolso
        //fotocopia_boleta_cristales_opticos_tope_isapre_reembolso
        
        
        var kine1 = 0;
        var kine2 = 0;
        
        var valorUF = 0; 
        var resultado = 0;
        
        kine1 = $('#kinesioterapia_reembolso').val();
        kine2 = $('#kinesioterapia_reembolso_contope').val();
        
        valorUF = $('#valor_uf').val();
        resultado = (parseInt(kine1) + parseInt(kine2)) / parseInt(valorUF);
        
        {jQuery('input[name="kine_saldo_actual"]:visible').val(resultado.toFixed(4));}
    }
    
    
    function update_nroFolio()
    {
        var nro=0;
        var nro2=0;
        var nro3=0;
        var nro4=0;
        var nro5=0;
        var nro6=0;
        
        var aux = $('#nro_folio').val();
        var aux2 = $('#cristales_opticos_saldo').val();
        var aux3 = $('#saldo_anterior_receta').val();
        var aux4 = $('#fono_saldo').val();
        var aux5 = $('#saldo_anterior').val();
        var aux6 = $('#kine_saldo').val();
        
        var rut = rd;
        
        if(aux == "")
        {
        
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                
                if (this.readyState == 4 && this.status == 200) {
                    nro = this.responseText;
                    {jQuery('input[name="nro_folio"]:visible').val(nro);}
                }
            };
            xmlhttp.open("GET","folio.php",true);
            xmlhttp.send();
        }
        
        if(aux2 == "")
        {
        
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                
                if (this.readyState == 4 && this.status == 200) {
                    nro2 = this.responseText;
                    nro2 = parseFloat(nro2).toFixed(4);
                    {jQuery('input[name="cristales_opticos_saldo"]:visible').val(nro2);}
                }
            };
            xmlhttp.open("GET","optico.php?rut="+rut,true);
            xmlhttp.send();
        }
        
        if(aux3 == "")
        {
        
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                
                if (this.readyState == 4 && this.status == 200) {
                    nro3 = this.responseText;
                    nro3 = parseFloat(nro3).toFixed(4);
                    {jQuery('input[name="saldo_anterior_receta"]:visible').val(nro3);}
                }
            };
            xmlhttp.open("GET","receta.php?rut="+rut,true);
            xmlhttp.send();
        }
        
        if(aux4 == "")
        {
        
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                
                if (this.readyState == 4 && this.status == 200) {
                    nro4 = this.responseText;
                    nro4 = parseFloat(nro4).toFixed(4);
                    {jQuery('input[name="fono_saldo"]:visible').val(nro4);}
                }
            };
            xmlhttp.open("GET","fono.php?rut="+rut,true);
            xmlhttp.send();
        }
        
        if(aux5 == "")
        {
        
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                
                if (this.readyState == 4 && this.status == 200) {
                    nro5 = this.responseText;
                    nro5 = parseFloat(nro5).toFixed(4);
                    {jQuery('input[name="saldo_anterior"]:visible').val(nro5);}
                }
            };
            xmlhttp.open("GET","psico.php?rut="+rut,true);
            xmlhttp.send();
        }
        
        if(aux6 == "")
        {
        
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                
                if (this.readyState == 4 && this.status == 200) {
                    nro6 = this.responseText;
                    nro6 = parseFloat(nro6).toFixed(4);
                    {jQuery('input[name="kine_saldo"]:visible').val(nro6);}
                }
            };
            xmlhttp.open("GET","kine.php?rut="+rut,true);
            xmlhttp.send();
        }
    }
    
    function grid_onload() 
    {
        var grid = $("#list2");
        var cc = 0;
        var aux=0;
        var sum_table=0;
        var sum_running=0;
        var sum = 0;
        
        //DecimalFormat sum_table = new DecimalFormat("0.00");
        
		sum = grid.jqGrid('getCol', 'reembolso_actual', false, 'sum'); // 'sum, 'avg', 'count' (use count-1 as it count footer row).

		// sum of running total records
		//sum_running = grid.jqGrid('getCol', 'running_total')[0];
		sum_running = grid.jqGrid('getCol', 'total_reembolso', false, 'sum');

		// sum of total records
		sum_table = grid.jqGrid('getCol', 'table_total')[0];
		
		
		// record count
		cc = grid.jqGrid('getCol', 'id', false, 'count');
		
	    //grid.jqGrid('footerData','set', {nro_folio: 'Reenvolsos Ingresados: ' + cc,reembolso_actual: 'Total UF: $' + parseFloat(sum),saldo_futuros_reembolsos: 'Total Saldos UF: $' + sum_running});
	    
	    grid.jqGrid('footerData','set', {nro_folio: 'Reenbolsos Ingresados: ' + cc,total_reembolso: 'qe1',reembolso_actual: 'Total UF: ' + parseFloat(sum).toFixed(4)});
	    
	    update_field_total();
    }
    
</script>
    
</body>
</html>