<?php require_once("_variables.php");
require_once("_metaheader.php");
$logged = (session_id() != "" && $_SESSION['USER']['id'] != "" && session_id() == $_SESSION['USER']['id']);
$menu = false;
?><html>
<head>
<title><?php echo $TituloPagina?></title>
<link rel=stylesheet type="text/css" href="<?php echo $VirtualDir?>css/default.css">
<script type="text/javascript" language=javascript src="<?php echo $VirtualDir?>js/jquery-1.9.1.min.js"></script>
<script language=javascript>var jsVirtualDir = '<?php echo $VirtualDir?>';</script>
</head>
