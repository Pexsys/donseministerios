<?php
$temPerfil = false;
if (isset($userID) && !empty($userID)):
	$arrPerfil = fGetPerfil($conn,$userID);
	?>
	<link rel="stylesheet" type="text/css" href="<?php echo $VirtualDir?>css/menu.css?">
	<script type="text/javascript" language=javascript src="<?php echo $VirtualDir?>js/menuprincipal.js?"></script>
	<table cellspacing="0" cellpadding="4" align="center" width="100%" class="menubar">
		<tr>
			<?php 
				$testeDonsURL = $VirtualDir."testededons.php?userID=$userID";
				if ( fExistResultado($conn,$userID) ):
					$testeDonsURL = $VirtualDir."rsdons.php?userID=$userID";
				endif;
			?>
			<?php if ( !array_key_exists("SECRETARIA",$arrPerfil) ):?>
			<td align="left" nowrap valign="middle" class="menuitems" name="menu" to="<?php echo $testeDonsURL?>">DONS</td>
			<td align="left" nowrap valign="middle" class="menuitems" name="menu" to="<?php echo $VirtualDir?>testedeministerios.php?userID=<?php echo $userID;?>">MINIST&Eacute;RIOS</td>
			<?php endif;?>
			<?php if ( array_key_exists("PESQUISAS",$arrPerfil) || array_key_exists("SECRETARIA",$arrPerfil) ):?>
			<td align="left" nowrap valign="middle" class="menuitems" name="menu" to="<?php echo $VirtualDir?>researching.php?userID=<?php echo $userID;?>">PESQUISAS</td>
			<?php endif;?>
			<?php if ( array_key_exists("IMPRESSAO",$arrPerfil) ):?>
			<td align="left" nowrap valign="middle" class="menuitems" name="menu" to="<?php echo $VirtualDir?>printing.php?userID=<?php echo $userID;?>">IMPRESS&Atilde;O</td>
			<?php endif;?>
			<?php if ( array_key_exists("RELATORIOS",$arrPerfil) ):?>
			<td align="left" nowrap valign="middle" class="menuitems" name="menu" to="<?php echo $VirtualDir?>dashboard.php?userID=<?php echo $userID;?>">DASHBOARD</td>
			<?php endif;?>
			<td valign="top" nowrap style="width:100%">&nbsp;</td>
			<td align="left" nowrap valign="middle" class="menuitems" name="menu" to="<?php echo $VirtualDir?>login.php?">SAIR</td>
		</tr>
	</table>
	<?php
endif;
?>