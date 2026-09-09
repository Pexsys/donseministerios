<?php
include_once("phpmailer/class.phpmailer.php");
$mail = new PHPMailer();
$mail->Host = "ip-from-host";
$mail->Username = "user@dominio.com.br";
$mail->Password = "password";
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->From = "conato@dominio.com.br";
$mail->FromName = "Descricao";
//$mail->AddAttachment("arquivo.zip");  //supondo que esta no mesmo diretorio.
//$mail->WordWrap = 50;
$mail->IsHTML(true);
?>