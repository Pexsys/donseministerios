<?php
session_start();
$TituloPagina = "Question&aacute;rio de Dons";
@require_once("include/functions.php");
@require_once("include/rules.php");
@require_once("include/header_simples.php");
$userID = fRequest("userID");
$PHP_SELF = $VirtualDir."menuprincipal.php?userID=$userID";
fConnDB();
@include("include/upperbar.php");
@include("include/bottom.php");
?>