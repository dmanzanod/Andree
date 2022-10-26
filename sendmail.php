<?php
$folio = $_GET['j'];
//************RECOLECTO LOS DATOS ***********************

$con = mysqli_connect('ec2-44-204-145-91.compute-1.amazonaws.com','zazudb2','zazu2023','bd_andree');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"bd_andree");

$sql="SELECT id, rut_asegurado_h, rut_paciente_h, bono_consulta_doctos, Bono_Consulta_pagado, Bono_factor_consulta, Bono_consulta_reembolso, 
foto_boleta_original_reembolso_isapre_number, 
foto_boleta_original_reembolso_isapre_asegurado, 
foto_factor_boleta_original_reembolso_isapre, 
foto_boleta_original_reembolso_isapre_reembolso, 
bono_consulta_con_tope_reembolso_1UF_docto, bono_consulta_con_tope_reembolso_1UF, bono_consulta_con_tope_reembolso_1UF_factor, bono_consulta_con_tope_reembolso_1UF_reembolso, 
bonos_consulta_tope_isapre_docto, 
bonos_consulta_tope_isapre, 
bonos_consulta_tope_isapre_factor, 
bonos_consulta_tope_isapre_reembolso, 
consultas_psicologicas_psiquiatricas_docto, 
consultas_psicologicas_psiquiatricas_asegurado, 
consultas_psicologicas_psiquiatricas_factor, 
consultas_psicologicas_psiquiatricas_reembolso, 
saldo_anterior, 
saldo_actual, 
bono_examen_sin_tope_docto, 
bono_examen_sin_tope_asegurado,
bono_examen_sin_tope_factor, 
bono_examen_sin_tope_reembolso, 
bono_examen_con_tope_docto, 
bono_examen_con_tope_asegurado, 
bono_examen_con_tope_factor, 
bono_examen_con_tope_reembolso, 
receta_con_nombre_beneficiario_docto, 
receta_con_nombre_beneficiario_asegurado, 
receta_con_nombre_beneficiario_factor, 
receta_con_nombre_beneficiario_reembolso, 
receta_permanente_docto, 
receta_permanente_asegurado, 
receta_permanente_factor, 
receta_permanente_reembolso, 
vigencia_desde, 
saldo_anterior_receta, 
saldo_anterior_receta2, 
cristales_opticos_saldo, 
fotocopia_boleta_cristales_opticos_original_docto, 
fotocopia_boleta_cristales_opticos_original_asegurado, 
fotocopia_boleta_cristales_opticos_original_factor, 
fotocopia_boleta_cristales_opticos_original_reembolso, 
boleta_original_cristales_opticos_con_timbre_docto, 
boleta_original_cristales_opticos_con_timbre_asegurado, 
boleta_original_cristales_opticos_con_timbre_factor, 
boleta_original_cristales_opticos_con_timbre_reembolso, 
fotocopia_boleta_cristales_opticos_tope_isapre_docto, 
fotocopia_boleta_cristales_opticos_tope_isapre_asegurado, 
fotocopia_boleta_cristales_opticos_tope_isapre_factor, 
fotocopia_boleta_cristales_opticos_tope_isapre_reembolso, 
hopitalizacion_programa_medico, 
hopitalizacion_programa_maternidad, 
monto_hospitalizacion, 
boleta_original_por_gastos_medicos_con_timbre_docto,
boleta_original_por_gastos_medicos_con_timbre_asegurado,
boleta_original_por_gastos_medicos_con_timbre_factor, 
boleta_original_por_gastos_medicos_con_timbre_reembolso, 
otros_documentos_docto, 
otros_documentos_asegurado, 
otros_documentos_factor, 
otros_documentos_reembolso, 
otros_documentos_tope_docto, 
otros_documentos_tope_asegurado, 
otros_documentos_tope_factor, 
otros_documentos_tope_reembolso, 
fonoaudiologia_docto, 
fonoaudiologia_asegurado, 
fonoaudiologia_factor, 
fonoaudiologia_reembolso,
fonoaudiologia_docto_con_tope, 
fonoaudiologia_asegurado_con_tope, 
fonoaudiologia_factor_con_tope, 
fonoaudiologia_reembolso_con_tope,
kinesioterapia_docto,
kinesioterapia_asegurado,
kinesioterapia_factor,
kinesioterapia_reembolso, 
kinesioterapia_docto_contope,
kinesioterapia_asegurado_contope,
kinesioterapia_factor_contope,
kinesioterapia_reembolso_contope,
fono_saldo, 
kine_saldo, 
saldo_anterior_general, 
reemboslo_actual_general, 
saldo_reembolsos_futuros_general, nro_folio, fecha, valor_uf, 
total_reembolso, 
saldo_anterior_total, 
reembolso_actual, 
saldo_futuros_reembolsos
FROM frm_historic WHERE nro_folio ='".$folio."'";

$result = mysqli_query($con,$sql);

while($row = mysqli_fetch_array($result)) {
    $rut = $row['rut_asegurado_h'];
    $bono_consulta_doctos = $row['bono_consulta_doctos'];
    $Bono_Consulta_pagado = number_format($row['Bono_Consulta_pagado'], 0, ',', '.');
    $Bono_consulta_reembolso = number_format($row['Bono_consulta_reembolso'], 0, ',', '.');
    $foto_boleta_original_reembolso_isapre_number = $row['foto_boleta_original_reembolso_isapre_number'];
    $foto_boleta_original_reembolso_isapre_asegurado = number_format($row['foto_boleta_original_reembolso_isapre_asegurado'], 0, ',', '.');
    $foto_boleta_original_reembolso_isapre_reembolso = number_format($row['foto_boleta_original_reembolso_isapre_reembolso'], 0, ',', '.');
    $consultas_psicologicas_psiquiatricas_docto = $row['consultas_psicologicas_psiquiatricas_docto'];
    $consultas_psicologicas_psiquiatricas_asegurado = number_format($row['consultas_psicologicas_psiquiatricas_asegurado'], 0, ',', '.');
    $consultas_psicologicas_psiquiatricas_reembolso = number_format($row['consultas_psicologicas_psiquiatricas_reembolso'], 0, ',', '.');
    $saldo_anterior = $row['saldo_anterior'];
    $saldo_actual = $row['saldo_actual'];
    $bono_examen_sin_tope_docto = $row['bono_examen_sin_tope_docto'];
    $bono_examen_sin_tope_asegurado = number_format($row['bono_examen_sin_tope_asegurado'], 0, ',', '.');
    $bono_examen_sin_tope_reembolso = number_format($row['bono_examen_sin_tope_reembolso'], 0, ',', '.');
    $bono_examen_con_tope_docto = $row['bono_examen_con_tope_docto'];
    $bono_examen_con_tope_asegurado = number_format($row['bono_examen_con_tope_asegurado'], 0, ',', '.');
    $bono_examen_con_tope_reembolso = number_format($row['bono_examen_con_tope_reembolso'], 0, ',', '.');
    $receta_con_nombre_beneficiario_docto = $row['receta_con_nombre_beneficiario_docto'];
    $receta_con_nombre_beneficiario_asegurado = number_format($row['receta_con_nombre_beneficiario_asegurado'], 0, ',', '.');
    $receta_con_nombre_beneficiario_reembolso = number_format($row['receta_con_nombre_beneficiario_reembolso'], 0, ',', '.');
    $receta_permanente_docto = $row['receta_permanente_docto'];
    $receta_permanente_asegurado =  number_format($row['receta_permanente_asegurado'], 0, ',', '.');
    $receta_permanente_reembolso =  number_format($row['receta_permanente_reembolso'], 0, ',', '.');
    $saldo_anterior_receta = $row['saldo_anterior_receta'];
    $saldo_anterior_receta2 = $row['saldo_anterior_receta2'];
    $cristales_opticos_saldo = $row['cristales_opticos_saldo'];
    $fotocopia_boleta_cristales_opticos_original_docto = $row['fotocopia_boleta_cristales_opticos_original_docto'];
    $fotocopia_boleta_cristales_opticos_original_asegurado =  number_format($row['fotocopia_boleta_cristales_opticos_original_asegurado'], 0, ',', '.');
    $fotocopia_boleta_cristales_opticos_original_reembolso =  number_format($row['fotocopia_boleta_cristales_opticos_original_reembolso'], 0, ',', '.');
    $boleta_original_cristales_opticos_con_timbre_docto = $row['boleta_original_cristales_opticos_con_timbre_docto'];
    $boleta_original_cristales_opticos_con_timbre_asegurado = number_format($row['boleta_original_cristales_opticos_con_timbre_asegurado'], 0, ',', '.');
    $boleta_original_cristales_opticos_con_timbre_reembolso = number_format($row['boleta_original_cristales_opticos_con_timbre_reembolso'], 0, ',', '.');
    $fotocopia_boleta_cristales_opticos_tope_isapre_docto = $row['fotocopia_boleta_cristales_opticos_tope_isapre_docto'];
    $fotocopia_boleta_cristales_opticos_tope_isapre_asegurado = number_format($row['fotocopia_boleta_cristales_opticos_tope_isapre_asegurado'], 0, ',', '.');
    $fotocopia_boleta_cristales_opticos_tope_isapre_reembolso = number_format($row['fotocopia_boleta_cristales_opticos_tope_isapre_reembolso'], 0, ',', '.');
    $hopitalizacion_programa_medico = $row['hopitalizacion_programa_medico'];
    $hopitalizacion_programa_maternidad = $row['hopitalizacion_programa_maternidad'];
    $monto_hospitalizacion = number_format($row['monto_hospitalizacion'], 0, ',', '.');
    $boleta_original_por_gastos_medicos_con_timbre_docto = $row['boleta_original_por_gastos_medicos_con_timbre_docto'];
    $boleta_original_por_gastos_medicos_con_timbre_asegurado = number_format($row['boleta_original_por_gastos_medicos_con_timbre_asegurado'], 0, ',', '.');
    $boleta_original_por_gastos_medicos_con_timbre_reembolso = number_format($row['boleta_original_por_gastos_medicos_con_timbre_reembolso'], 0, ',', '.');
    $otros_documentos_docto = $row['otros_documentos_docto'];
    $otros_documentos_asegurado = number_format($row['otros_documentos_asegurado'], 0, ',', '.');
    $otros_documentos_reembolso = number_format($row['otros_documentos_reembolso'], 0, ',', '.');
    $otros_documentos_tope_docto = $row['otros_documentos_tope_docto'];
    $otros_documentos_tope_asegurado = number_format($row['otros_documentos_tope_asegurado'], 0, ',', '.');
    $otros_documentos_tope_reembolso = number_format($row['otros_documentos_tope_reembolso'], 0, ',', '.');
    $fonoaudiologia_docto = $row['fonoaudiologia_docto'];
    $fonoaudiologia_asegurado = number_format($row['fonoaudiologia_asegurado'], 0, ',', '.');
    $fonoaudiologia_reembolso = number_format($row['fonoaudiologia_reembolso'], 0, ',', '.');
    $fonoaudiologia_docto_con_tope = $row['fonoaudiologia_docto_con_tope'];
    $fonoaudiologia_asegurado_con_tope = number_format($row['fonoaudiologia_asegurado_con_tope'], 0, ',', '.');
    $fonoaudiologia_reembolso_con_tope = number_format($row['fonoaudiologia_reembolso_con_tope'], 0, ',', '.');
    $kinesioterapia_docto = $row['kinesioterapia_docto'];
    $kinesioterapia_asegurado = number_format($row['kinesioterapia_asegurado'], 0, ',', '.');
    $kinesioterapia_reembolso = number_format($row['kinesioterapia_reembolso'], 0, ',', '.');
    $kinesioterapia_docto_contope = $row['kinesioterapia_docto_contope'];
    $kinesioterapia_asegurado_contope = number_format($row['kinesioterapia_asegurado_contope'], 0, ',', '.');
    $kinesioterapia_reembolso_contope = number_format($row['kinesioterapia_reembolso_contope'], 0, ',', '.');
    $total_reembolso = number_format($row['total_reembolso'], 0, ',', '.');
    $saldo_anterior_total = number_format($row['saldo_anterior_total'], 0, ',', '.');
    $reembolso_actual = number_format($row['reembolso_actual'], 0, ',', '.');
    $saldo_futuros_reembolsos = number_format($row['saldo_futuros_reembolsos'], 0, ',', '.');
}
mysqli_close($con);

if($hopitalizacion_programa_medico == "Yes")
{
    $hopitalizacion_programa_medico = "SI";
}else{
    $hopitalizacion_programa_medico = "NO";
}

if($hopitalizacion_programa_maternidad == "Yes")
{
    $hopitalizacion_programa_maternidad = "SI";
}else{
    $hopitalizacion_programa_maternidad = "NO";
}

//rut_asegurado_h


$con = mysqli_connect('ec2-44-204-145-91.compute-1.amazonaws.com','zazudb2','zazu2023','bd_andree');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"bd_andree");

$sql="SELECT nomre_asegurado, apellido_asegurado, apellido2_asegurado, email_asegurado, mnt_UF_asegurado_total, mnt_UF_asegurado, mnt_UF_psico, mnt_UF_recetas, mnt_UF_fono, mnt_UF_kine, mnt_optico FROM tbl_asegurado where rut_asegurado = '".$rut."'";

$result = mysqli_query($con,$sql);

while($row = mysqli_fetch_array($result)) {
    $para = $row['email_asegurado'];
    $nombre = $row['nomre_asegurado'];
    $apellido_p = $row['apellido_asegurado'];
    $apellido_m = $row['apellido2_asegurado'];
    $mnt_UF_recetas_m = $row['mnt_UF_recetas'];
}

mysqli_close($con);

// título
$titulo = 'Formulario Reembolso Nro. '.$folio.'';

// mensaje
$mensaje = "
<html>
<head>
<meta charset='utf-8'>
</head>
<body>
<h2 style='font: normal; font-family: Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', 'serif' '><img src='http://www.andreebienestar.cl/LOGOTIPO_COLOR_1.jpg' width='261' height='190' alt=''/></h2>
<h2 style='font: normal; font-family: Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', 'serif' '><strong>Comporbante de Reembolso del Asociado</strong></h2>
<p style='font: normal; font-family: Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', 'serif' '>
  Estimado(a) ".$nombre." ".$apellido_p." ".$apellido_m.", Le informamos que se ha ingresado el formulario de reembolso Nro. $folio con el siguiente detalle:
</p>
<table width='866' border='0' bgcolor='#d9efff' style='font: normal; font-family: Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', 'serif'; font-size: 16px;'>
  <tbody>
    <tr>
      <td width='41' height='26' background=''>&nbsp;</td>
      <td colspan='2'>&nbsp;</td>
      <td width='36' align='right'>&nbsp;</td>
      <td colspan='3' align='right'>&nbsp;</td>
      <td width='34' align='right'>&nbsp;</td>
      <td colspan='2' align='right'><p><strong>&nbsp;REEMBOLSO Nº:</strong></p></td>
      <td width='82' align='center' bgcolor='#E3EBF5'><strong>$folio</strong></td>
    </tr>
    <tr>
      <td colspan='3'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td colspan='3' align='center'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td align='center'>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan='3'><strong>CONSULTAS MÉDICAS</strong></td>
      <td align='right'>&nbsp;</td>
      <td colspan='3' align='center'>Pagado por el asegurado</td>
      <td align='right'>&nbsp;</td>
      <td width='21' align='right'>&nbsp;</td>
      <td width='159' align='center'>Reembolso</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor='#E3EBF5'>$bono_consulta_doctos</td>
      <td colspan='2'>Bono Consulta</td>
      <td align='right'>$</td>
      <td colspan='3' bgcolor='#E3EBF5'>$Bono_Consulta_pagado</td>
      <td align='right'> 80%</td>
      <td align='right'>$</td>
      <td bgcolor='#E3EBF5'>$Bono_consulta_reembolso</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor='#E3EBF5'>$foto_boleta_original_reembolso_isapre_number</td>
      <td colspan='2'>Fotocopia boleta con original reembolso Isapre</td>
      <td align='right'>$</td>
      <td colspan='3' bgcolor='#E3EBF5'>$foto_boleta_original_reembolso_isapre_asegurado</td>
      <td align='right'>80%</td>
      <td align='right' >$</td>
      <td bgcolor='#E3EBF5'>$foto_boleta_original_reembolso_isapre_reembolso</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor='#E3EBF5'>$consultas_psicologicas_psiquiatricas_docto</td>
      <td colspan='2'>Bonos consulta con Tope de Isapre</td>
      <td align='right'>$</td>
      <td colspan='3' bgcolor='#E3EBF5'>$consultas_psicologicas_psiquiatricas_asegurado</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>$</td>
      <td bgcolor='#E3EBF5'>$consultas_psicologicas_psiquiatricas_reembolso</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan='11'>&nbsp;</td>
    </tr>
    <tr>
      <td colspan='11'>Consultas Psicológicas y/o psiquiátricas tienen en conjunto tope anual de 10UF</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width='170' align='right'>Saldo Anterior</td>
      <td width='109' bgcolor='#E3EBF5'>$saldo_anterior</td>
      <td align='right'>UF</td>
      <td colspan='2' align='right'> Saldo Actual</td>
      <td colspan='2' bgcolor='#E3EBF5'>$saldo_actual</td>
      <td align='right'>UF</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan='2'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td colspan='3'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan='3'><strong>EXÁMENES</strong></td>
      <td align='right'>&nbsp;</td>
      <td colspan='3'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor='#E3EBF5'>$bono_examen_sin_tope_docto</td>
      <td colspan='2'>Bono examen sin tope Isapre</td>
      <td align='right'>$</td>
      <td colspan='3' bgcolor='#E3EBF5'>$bono_examen_sin_tope_asegurado</td>
      <td align='right'>80%</td>
      <td align='right'>$</td>
      <td bgcolor='#E3EBF5'>$bono_examen_sin_tope_reembolso</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor='#E3EBF5'>$bono_examen_con_tope_docto</td>
      <td colspan='2'>Bono examen con tope Isapre</td>
      <td align='right'>$</td>
      <td colspan='3' bgcolor='#E3EBF5'>$bono_examen_con_tope_asegurado</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>$</td>
      <td bgcolor='#E3EBF5'>$bono_examen_con_tope_reembolso</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan='2'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td colspan='3'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan='3'><strong>RECETAS</strong></td>
      <td align='right'>&nbsp;</td>
      <td colspan='3'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor='#E3EBF5'>$receta_con_nombre_beneficiario_docto</td>
      <td colspan='2'>Receta con nombre de beneficiario y timbre de farmacia (hasta 30 días)</td>
      <td align='right'>$</td>
      <td colspan='3' bgcolor='#E3EBF5'>$receta_con_nombre_beneficiario_asegurado</td>
      <td align='right'>80%</td>
      <td align='right'>$</td>
      <td bgcolor='#E3EBF5'>$receta_con_nombre_beneficiario_reembolso</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor='#E3EBF5'>$receta_permanente_docto</td>
      <td colspan='2'>Receta PERMANENTE (sobre 30 días y hasta 6 meses)</td>
      <td align='right'>$</td>
      <td colspan='3' bgcolor='#E3EBF5'>$receta_permanente_asegurado</td>
      <td align='right'>70%</td>
      <td align='right'>$</td>
      <td bgcolor='#E3EBF5'>$receta_permanente_reembolso</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan='2'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td colspan='3'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan='3'>Tope anual de RECETAS: 30 UF</td>
      <td align='right'>&nbsp;</td>
      <td colspan='3'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align='right'>Saldo Anterior: </td>
      <td bgcolor='#E3EBF5'>$saldo_anterior_receta</td>
      <td align='right'>UF</td>
      <td colspan='2' align='right'>Saldo Actual: </td>
      <td colspan='2' bgcolor='#E3EBF5'>$mnt_UF_recetas_m</td>
      <td align='right'>UF</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan='2'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td colspan='3'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan='3'><strong>CRISTALES ÓPTICOS</strong></td>
      <td colspan='7' align='left'>(Saldo:  $cristales_opticos_saldo UF )</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor='#E3EBF5'>$fotocopia_boleta_cristales_opticos_original_docto</td>
      <td colspan='2'>Fotocopia boleta cristales ópticos con original reembolso Isapre</td>
      <td align='right'>$</td>
      <td colspan='3' bgcolor='#E3EBF5'>$fotocopia_boleta_cristales_opticos_original_asegurado</td>
      <td align='right'>80%</td>
      <td align='right'>$</td>
      <td bgcolor='#E3EBF5'>$fotocopia_boleta_cristales_opticos_original_reembolso</td>
      <td>(Con tope anual 4UF)</td>
    </tr>
    <tr>
      <td bgcolor='#E3EBF5'>$boleta_original_cristales_opticos_con_timbre_docto</td>
      <td colspan='2'>Boleta original cristales ópticos con timbre de Isapre NO REEMBOLSABLE</td>
      <td align='right'>$</td>
      <td colspan='3' bgcolor='#E3EBF5'>$boleta_original_cristales_opticos_con_timbre_asegurado</td>
      <td align='right'>80%</td>
      <td align='right'>$</td>
      <td bgcolor='#E3EBF5'>$boleta_original_cristales_opticos_con_timbre_reembolso</td>
      <td>(Con tope anual 4UF)</td>
    </tr>
    <tr>
      <td bgcolor='#E3EBF5'>$fotocopia_boleta_cristales_opticos_tope_isapre_docto</td>
      <td colspan='2'>Fotocopia boleta cristales ópticos con Tope de Isapre</td>
      <td align='right'>$</td>
      <td colspan='3' bgcolor='#E3EBF5'>$fotocopia_boleta_cristales_opticos_tope_isapre_asegurado</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>$</td>
      <td bgcolor='#E3EBF5'>$fotocopia_boleta_cristales_opticos_tope_isapre_reembolso</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan='2'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td colspan='3'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan='3'><strong>HOSPITALIZACIÓN</strong></td>
      <td align='right'>&nbsp;</td>
      <td colspan='3'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor='#E3EBF5'>$hopitalizacion_programa_medico</td>
      <td colspan='2'>Programa Médico</td>
      <td colspan='2' align='right' bgcolor='#E3EBF5'>$hopitalizacion_programa_maternidad</td>
      <td width='104'>Maternidad</td>
      <td width='45'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>$</td>
      <td bgcolor='#E3EBF5'>$monto_hospitalizacion</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan='2'>(Detalle en formulario Adjunto)</td>
      <td align='right'>&nbsp;</td>
      <td colspan='3'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan='2'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td colspan='3'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor='#E3EBF5'>$boleta_original_por_gastos_medicos_con_timbre_docto</td>
      <td colspan='2'>Boleta original por gastos médicos con timbre de Isapre NO REEMBOLSABLE</td>
      <td align='right'>$</td>
      <td colspan='3' bgcolor='#E3EBF5'>$boleta_original_por_gastos_medicos_con_timbre_asegurado</td>
      <td align='right'>80%</td>
      <td align='right'>$</td>
      <td bgcolor='#E3EBF5'>$boleta_original_por_gastos_medicos_con_timbre_reembolso</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan='2'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td colspan='3' align='center'>(50% Valor boleta)</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor='#E3EBF5'>$otros_documentos_docto</td>
      <td colspan='2'>Otros documentos reembolsables</td>
      <td align='right'>$</td>
      <td colspan='3' bgcolor='#E3EBF5'>$otros_documentos_asegurado</td>
      <td align='right'>80%</td>
      <td align='right'>$</td>
      <td bgcolor='#E3EBF5'>$otros_documentos_reembolso</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor='#E3EBF5'>$otros_documentos_tope_docto</td>
      <td colspan='2'>Otros documentos reembolsables con tope Isapre</td>
      <td align='right'>$</td>
      <td colspan='3' bgcolor='#E3EBF5'>$otros_documentos_tope_asegurado</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>$</td>
      <td bgcolor='#E3EBF5'>$otros_documentos_tope_reembolso</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor='#E3EBF5'>$fonoaudiologia_docto</td>
      <td colspan='2'>Fonoaudiología (tope 10UF)</td>
      <td align='right'>$</td>
      <td colspan='3' bgcolor='#E3EBF5'>$fonoaudiologia_asegurado</td>
      <td align='right'>80%</td>
      <td align='right'>$</td>
      <td bgcolor='#E3EBF5'>$fonoaudiologia_reembolso</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor='#E3EBF5'>$fonoaudiologia_docto_con_tope</td>
      <td colspan='2'>Fonoaudiología con Tope Isapre</td>
      <td align='right'>$</td>
      <td colspan='3' bgcolor='#E3EBF5'>$fonoaudiologia_asegurado_con_tope</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>$</td>
      <td bgcolor='#E3EBF5'>$fonoaudiologia_reembolso_con_tope</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor='#E3EBF5'>$kinesioterapia_docto</td>
      <td colspan='2'>Kinesioterapia (tope 10UF)</td>
      <td align='right'>$</td>
      <td colspan='3' bgcolor='#E3EBF5'>$kinesioterapia_asegurado</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>$</td>
      <td bgcolor='#E3EBF5'>$kinesioterapia_reembolso</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor='#E3EBF5'>$kinesioterapia_docto_contope</td>
      <td colspan='2'>Kinesioterapia con Tope Isapre</td>
      <td align='right'>$</td>
      <td colspan='3' bgcolor='#E3EBF5'>$kinesioterapia_asegurado_contope</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>$</td>
      <td bgcolor='#E3EBF5'>$kinesioterapia_reembolso_contope</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan='2'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td colspan='3'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan='2'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td colspan='4' align='right'><strong>TOTAL REEMBOLSO</strong></td>
      <td align='right'><strong>$</strong></td>
      <td bgcolor='#E3EBF5'><strong>$total_reembolso</strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan='2'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td colspan='3'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan='2' align='center'><strong>Saldo Anterior</strong></td>
      <td align='center'>&nbsp;</td>
      <td colspan='3' align='center'><strong>Reembolso actual</strong></td>
      <td align='center'>&nbsp;</td>
      <td align='center'>&nbsp;</td>
      <td colspan='2' align='center'><strong>Saldo para futuros Reembolsos</strong></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan='2' align='center' bgcolor='#E3EBF5'><strong>$saldo_anterior_total</strong></td>
      <td align='center'><strong>UF - </strong></td>
      <td colspan='3' align='center' bgcolor='#E3EBF5'><strong>$reembolso_actual</strong></td>
      <td align='center'><strong>UF</strong></td>
      <td align='center'><strong>= </strong></td>
      <td align='center' bgcolor='#E3EBF5'><strong>$saldo_futuros_reembolsos</strong></td>
      <td><strong>UF</strong></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan='2'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td colspan='3'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan='2'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td colspan='3'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan='2'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td colspan='3'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan='2'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td colspan='3'>&nbsp;</td>
      <td colspan='4' align='right'>________________________________________________</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan='2'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td colspan='3'>&nbsp;</td>
      <td colspan='4' rowspan='2' align='center'>Firma y timbre BIENESTANDRÉE <br />SEGURO COMPLEMENTARIO DE SALUD</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan='2'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td colspan='3'>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan='2'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td colspan='3'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td align='right'>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
</body>
</html>";

// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type:text/html;charset=UTF-8' . "\r\n";

// Cabeceras adicionales
$cabeceras .= 'To: '.$para.''."\r\n";
$cabeceras .= 'From: Andrée Bienestar <noreply@andreebienestar.cl>' . "\r\n";

if (mail($para, $titulo, $mensaje, $cabeceras)) {
              echo 'Se ha enviado el correo correctamente!';
           } else {
              echo 'No se pudo enviar el correo.';
            }


//echo $mensaje;

?>

<!DOCTYPE html>
<html>
<body>
<script type='text/javascript'>
window.close();
</script>

</body>
</html>