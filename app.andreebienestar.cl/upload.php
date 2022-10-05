<?php

    $count = count($_FILES['files']['name']);

    $con = mysqli_connect('localhost','andree','andree','andreeBienestar');
    
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    
    mysqli_select_db($con,"andreeBienestar");
    
    $hash = md5(uniqid());
    
    $sql = "INSERT INTO tbl_requerimientos(rut, nombre, valor, hash) VALUES ('".$_POST['rut']."', '".$_POST['exampleFormControlInput1']."', '".$_POST['exampleFormControlInput2']."', '".$hash."' )";
    
    $result = mysqli_query($con,$sql);
    
    mysqli_close($con);

for($index = 0; $index < $count; $index++){
    $temp_path = $_FILES['files']['tmp_name'][$index];
    $uploadPath= "./upload/".$_FILES['files']['name'][$index];
    
    $ext = pathinfo($_FILES['files']['tmp_name'][$index], PATHINFO_EXTENSION);

    $newFileName = md5(uniqid());
    $fileDest = 'upload/'.$newFileName;

    if(move_uploaded_file($temp_path, $fileDest)){
        $data[] = $_FILES['files']['name'][$index];
    }

            $con = mysqli_connect('localhost','andree','andree','andreeBienestar');
            
            if (!$con) {
                die('Could not connect: ' . mysqli_error($con));
            }
        
                mysqli_select_db($con,"andreeBienestar");
            
                
                $sql1 = "INSERT INTO tbl_imagenes(RUT, nombre_original, nombre_servidor, hash) VALUES ('".$_POST['rut']."', '".$_FILES['files']['name'][$index]."','".$newFileName."','".$hash."')";
                
                $result = mysqli_query($con,$sql1);
                mysqli_close($con);
}


                $con = mysqli_connect('localhost','andree','andree','andreeBienestar');
                if (!$con) {
                    die('Could not connect: ' . mysqli_error($con));
                }
    
                mysqli_select_db($con,"andreeBienestar");
                $sql = "SELECT CONCAT(nomre_asegurado, ' ', apellido_asegurado) as nombre, email_asegurado FROM tbl_asegurado WHERE rut_asegurado = '".$_POST['rut']."'";
                $result = mysqli_query($con,$sql);

                        while($row = mysqli_fetch_array($result)) {
                            $email = $row['email_asegurado'];
                            $nombre = $row['nombre'];
                        }
            
                mysqli_close($con);

$message = '<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>Coorporación de Bienestar Andree School</title>
    <style type="text/css">
        div.MsoNormal {
            mso-style-unhide: no;
            mso-style-qformat: yes;
            mso-style-parent: "";
            margin: 0cm;
            margin-bottom: .0001pt;
            mso-pagination: widow-orphan;
            font-size: 12.0pt;
            font-family: "Times New Roman","serif";
            mso-fareast-font-family: "Times New Roman";
            mso-fareast-theme-font: minor-fareast;
        }

        li.MsoNormal {
            mso-style-unhide: no;
            mso-style-qformat: yes;
            mso-style-parent: "";
            margin: 0cm;
            margin-bottom: .0001pt;
            mso-pagination: widow-orphan;
            font-size: 12.0pt;
            font-family: "Times New Roman","serif";
            mso-fareast-font-family: "Times New Roman";
            mso-fareast-theme-font: minor-fareast;
        }

        p.MsoNormal {
            mso-style-unhide: no;
            mso-style-qformat: yes;
            mso-style-parent: "";
            margin: 0cm;
            margin-bottom: .0001pt;
            mso-pagination: widow-orphan;
            font-size: 12.0pt;
            font-family: "Times New Roman","serif";
            mso-fareast-font-family: "Times New Roman";
            mso-fareast-theme-font: minor-fareast;
        }

        div.MsoNormal1 {
            mso-style-unhide: no;
            mso-style-qformat: yes;
            mso-style-parent: "";
            margin: 0cm;
            margin-bottom: .0001pt;
            mso-pagination: widow-orphan;
            font-size: 12.0pt;
            font-family: "Times New Roman","serif";
            mso-fareast-font-family: "Times New Roman";
            mso-fareast-theme-font: minor-fareast;
        }

        li.MsoNormal1 {
            mso-style-unhide: no;
            mso-style-qformat: yes;
            mso-style-parent: "";
            margin: 0cm;
            margin-bottom: .0001pt;
            mso-pagination: widow-orphan;
            font-size: 12.0pt;
            font-family: "Times New Roman","serif";
            mso-fareast-font-family: "Times New Roman";
            mso-fareast-theme-font: minor-fareast;
        }

        p.MsoNormal1 {
            mso-style-unhide: no;
            mso-style-qformat: yes;
            mso-style-parent: "";
            margin: 0cm;
            margin-bottom: .0001pt;
            mso-pagination: widow-orphan;
            font-size: 12.0pt;
            font-family: "Times New Roman","serif";
            mso-fareast-font-family: "Times New Roman";
            mso-fareast-theme-font: minor-fareast;
        }

        span.GramE {
            mso-style-name: "";
            mso-gram-e: yes;
        }

        div.MsoNormal2 {
            mso-style-unhide: no;
            mso-style-qformat: yes;
            mso-style-parent: "";
            margin: 0cm;
            margin-bottom: .0001pt;
            mso-pagination: widow-orphan;
            font-size: 12.0pt;
            font-family: "Times New Roman","serif";
            mso-fareast-font-family: "Times New Roman";
            mso-fareast-theme-font: minor-fareast;
        }

        li.MsoNormal2 {
            mso-style-unhide: no;
            mso-style-qformat: yes;
            mso-style-parent: "";
            margin: 0cm;
            margin-bottom: .0001pt;
            mso-pagination: widow-orphan;
            font-size: 12.0pt;
            font-family: "Times New Roman","serif";
            mso-fareast-font-family: "Times New Roman";
            mso-fareast-theme-font: minor-fareast;
        }

        p.MsoNormal2 {
            mso-style-unhide: no;
            mso-style-qformat: yes;
            mso-style-parent: "";
            margin: 0cm;
            margin-bottom: .0001pt;
            mso-pagination: widow-orphan;
            font-size: 12.0pt;
            font-family: "Times New Roman","serif";
            mso-fareast-font-family: "Times New Roman";
            mso-fareast-theme-font: minor-fareast;
        }

        span.GramE1 {
            mso-style-name: "";
            mso-gram-e: yes;
        }

        span.GramE11 {
            mso-style-name: "";
            mso-gram-e: yes;
        }

        span.GramE12 {
            mso-style-name: "";
            mso-gram-e: yes;
        }

        span.GramE13 {
            mso-style-name: "";
            mso-gram-e: yes;
        }

        div.MsoNormal3 {
            mso-style-unhide: no;
            mso-style-qformat: yes;
            mso-style-parent: "";
            margin: 0cm;
            margin-bottom: .0001pt;
            mso-pagination: widow-orphan;
            font-size: 12.0pt;
            font-family: "Times New Roman","serif";
            mso-fareast-font-family: "Times New Roman";
            mso-fareast-theme-font: minor-fareast;
        }

        li.MsoNormal3 {
            mso-style-unhide: no;
            mso-style-qformat: yes;
            mso-style-parent: "";
            margin: 0cm;
            margin-bottom: .0001pt;
            mso-pagination: widow-orphan;
            font-size: 12.0pt;
            font-family: "Times New Roman","serif";
            mso-fareast-font-family: "Times New Roman";
            mso-fareast-theme-font: minor-fareast;
        }

        p.MsoNormal3 {
            mso-style-unhide: no;
            mso-style-qformat: yes;
            mso-style-parent: "";
            margin: 0cm;
            margin-bottom: .0001pt;
            mso-pagination: widow-orphan;
            font-size: 12.0pt;
            font-family: "Times New Roman","serif";
            mso-fareast-font-family: "Times New Roman";
            mso-fareast-theme-font: minor-fareast;
        }

        span.SpellE {
            mso-style-name: "";
            mso-spl-e: yes;
        }

        span.SpellE1 {
            mso-style-name: "";
            mso-spl-e: yes;
        }

        span.GramE2 {
            mso-style-name: "";
            mso-gram-e: yes;
        }

        span.SpellE11 {
            mso-style-name: "";
            mso-spl-e: yes;
        }
    </style>
</head>

<body style=" margin:0px auto;">
    <!--INICIO SI NO VES CLICK AQUI-->
    <table width="600" border="0" align="center" cellpadding="2" cellspacing="2">
        <tr>
            <td width="589" height="25" align="center"></td>
        </tr>
    </table>
    <!--SI NO VES CLICK AQUI-->
    <!--INICIO HEAD TITULO BIENVENIDA-->
    <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="left" valign="top">
                <table width="600" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="left" valign="top">
                            <table width="600" border="0" cellspacing="0" cellpadding="0">
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
                            <table width="600" border="0" cellspacing="0" cellpadding="0">
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="border: solid 1px #CCC; font-family: Arial, Helvetica, sans-serif; font-size: 12px; text-align: justify; color: #333;">
        <tr>
            <td width="600" align="left" valign="top">

                <!--TITULO PRINCIPAL-->
                <table width="600" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td height="103" align="center" valign="middle">
                            <table width="547" border="0" cellspacing="0" cellpadding="0">
                                <tr align="left">
                                    <td align="center" valign="top">
                                        <span style="font:bold 30px Arial, Helvetica, sans-serif; color:#666; text-align: center;; font-size: 30px">
                                            Aviso de recepción <br>
                                            de Solicitud de Reembolso
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr bgcolor="#1d7dd3">
                        <td height="10"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top"></td>
        </tr>
        <tr>
            <td align="center" valign="top" style="line-height: 100%; color: #333;">




                <table width="547" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="552" height="60" align="left" valign="middle" style="text-align:justify;">
                            <p>&nbsp;</p>
                            <p>
                                <strong>Estimado '.$nombre.',</strong><br>
                                <br>
                                <font face="Arial" style="font-size:12px; color:#333333;">Junto con saludar, informamos que su solicitud de reembolso ha sido recibido por la Coorporación de Bienestar Andree School, una vez sea revisado, le comunicaremos el resultado a su correo electrónico.</font>
                            </p>
                            <p>
                                <span style="font-size:9.0pt;
    font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:#333333">Se despide cordialmente,</span>
                            </p>
                            <p>
                                <span style="font-size:9.0pt;
    font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:#333333">
                                    <strong>Coorporación de Bienestar Andree School</strong>
                                </span>
                            </p>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top">
                <table width="20" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#666; text-align:center">
                    <tr>
                        <td width="20" bgcolor="#FFFFFF"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top">
                <table width="600" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td><br /></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!--FIN MAIN-->
    <!--LEGAL DESUSCRIBIR-->
    <table align="center" border="0" cellpadding="2" cellspacing="2" width="600">
        <tbody>
            <tr style="TEXT-ALIGN: justify" valign="center">
                <td height="40" width="591">
                    <font style="font-family: arial; font-size: 11px; text-align: justify; color: #7A7A7A;">
                        Por favor no responder este mail ya que ha sido generado automáticamente por una cuenta no habilitada para recibir respuestas.<br>
                    </font>
                </td>
            </tr>
        </tbody>
    </table>
    <!--FIN LEGAL DESUSCRIBIR-->
</body>
</html>';

         $to = $email;
         $subject = "Aviso de recepción de Solicitud de Reembolso ";
         
         $header = "From:noreply@andreebienestar.cl \r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
         
         $retval = mail ($to,$subject,$message,$header);

?>