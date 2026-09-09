<?php
@require_once("_variables.php");
@require_once("_metaheader.php");
?><html>
<head>
<title><?php echo $TituloPagina?></title>
<link rel=stylesheet type="text/css" href="<?php echo $VirtualDir?>css/default.css">
<link href="<?php echo $VirtualDir?>css/blitzer/jquery-ui-1.9.2.custom.min.css" rel="stylesheet">
<script language=javascript>var jsVirtualDir = '<?php echo $VirtualDir?>';</script>
<script type="text/javascript" language=javascript src="<?php echo $VirtualDir?>js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" language=javascript src="<?php echo $VirtualDir?>js/jquery-ui-1.9.2.custom.min.js"></script>
</head>
<body>
<div id="dialog-message" title="" style="display:none;"></div>
