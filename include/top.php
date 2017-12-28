<?php 
@require_once("_variables.php");
@include_once("functions.php");
@require_once("_metaheader.php");
?><html>
<head>
<link rel="stylesheet" type="text/css" href="<?php echo $VirtualDir?>css/default.css">
<script type="text/javascript" language="javascript" src="<?php echo $VirtualDir?>js/jquery-1.9.1.min.js"></script>
</head>
<body>
<table cellspacing="0" border="0" cellpadding="0" align="center" width="100%" style="border-bottom:2px solid MenuText;height:50px;table-layout:fixed;">
	<tr>
		<td width="100%" align="center" valign="middle" style="font-family:Tahoma;font-size:12px;font-weight:bolder;background-color:<?php echo $BGroundTop;?>;color:<?php echo $TextTop;?>;"><?php echo $SYSDesc?></td>
	</tr>
</table>
<?php 
if (session_id() != "" && isset($_SESSION['USER']) && $_SESSION['USER']['id'] != "" && session_id() == $_SESSION['USER']['id']):
	if ($_SESSION['USER']['ds_pessoa'] != ""):
	?>
	<table cellspacing="0" cellpadding="0" align="center" width="100%">
		<tr>
			<td align="center" valign="middle" style="background-color:MenuText;color:Menu;">
				&nbsp;
				<label style="height:18px;background-color:MenuText;color:Menu;">Usu&aacute;rio:</label>&nbsp;<input type="text" readonly id="idUsuario" value="<?php echo $_SESSION['USER']['cd_pessoa'];?>" size="<?php echo strlen($_SESSION['USER']['cd_pessoa'])?>" style="border:0px;height:20px;background-color:MenuText;color:Menu;">&nbsp;&nbsp;&nbsp;
				<label style="height:18px;background-color:MenuText;color:Menu;">Nome:</label>&nbsp;<input type="text" readonly value="<?php echo $_SESSION['USER']['ds_pessoa'];?>" size="<?php echo strlen($_SESSION['USER']['ds_pessoa'])?>" style="border:0px;height:20px;background-color:MenuText;color:Menu;">
				&nbsp;
			</td>
		</tr>
	</table>
	<?php
	endif;
endif;
?>