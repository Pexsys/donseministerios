<?php
session_start();
@require_once("include/functions.php");
@require_once("include/rules.php");
@require_once("include/header_simples.php");
$userID = fRequest("userID");
$print = fRequest("print") == "yes";

$pool = explode(",", substr(fRequest("pool"),1));
if ( $userID > 0 ):
	$pool[0] = $userID;
endif;
$PHP_SELF = $VirtualDir."rsdons.php?userID=$userID";
fConnDB();
@include("include/upperbar.php");
?>
<script type="text/javascript" language=javascript src="<?php echo $VirtualDir?>js/rsdons.js?"></script>
<br/>
<br/>
<?php foreach ($pool as $v):?>
<div style="page-break-after:always;">
	<table cellspacing="0" cellpadding="0" align="center" style="width:700px;">
		<tr>
			<td valign="top">
				<table cellspacing="0" cellpadding="0" align="center" style="width:100%">
					<tr>
						<td class="tdCaption" width="80%">Teste de Dons - RESULTADO</td>
					</tr>
				</table>
				<?php echo utf8_decode(fRsDons($conn,$v,true));?>
			</td>
		</tr>
	</table>
</div>
<?php endforeach;?>
<?php include("include/bottom.php");?>