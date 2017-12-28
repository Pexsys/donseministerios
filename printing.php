<?php
session_start();
$TituloPagina = "Sele&ccedil;&atilde;o e Impress&atilde;o de Resultados";
@require_once("include/functions.php");
@require_once("include/rules.php");
@require_once("include/header_simples.php");
$userID = fRequest("userID");
$PHP_SELF = $VirtualDir."printing.php?userID=$userID";
fConnDB();
@include("include/upperbar.php");
?>
<script type="text/javascript" language=javascript src="<?php echo $VirtualDir?>js/printing.js?"></script>
<br/>
<br/>
<form name="frmPrinting">
	<table width="100%" height="80%" cellspacing="0" cellpadding="0" align="center" border="0">
		<tr>
			<td valign="top">
				<table cellspacing="0" cellpadding="0" align="center" class="tblFrame" style="width:700px;">
					<tr>
						<td align="center" width="100%" class="tdCaption"><?php echo $TituloPagina;?></td>
					</tr>
					<tr>
						<td align="center">
							<table cellspacing="1" cellpadding="1" border="0" width="99%">
								<tr>
									<td valign="middle" align="center" width="100%" style="border:1px outset;background-color:ThreeDDarkShadow;"><label style="color:#f0f0f0;">Filtros</label></td>
								</tr>
								<tr>
									<td style="border:1px outset;">
										<table cellspacing="5" cellpadding="0" border="0" width="100%">
											<tr>
												<td align="right" width="15%"><label for="cmbRegiao">Regi&atilde;o:</label>&nbsp;</td>
												<td align="left" width="85%"><select id="cmbRegiao" style="width:500px;" name="filtros"></select>
												</td>
											</tr>
											<tr>
												<td align="right" width="15%"><label for="cmbCaravana">Caravana:</label>&nbsp;</td>
												<td align="left" width="85%"><select id="cmbCaravana" style="width:500px;" name="filtros"></select>
												</td>
											</tr>
											<tr>
												<td align="right" width="15%"><label for="cmbDiscipulo">Disc&iacute;pulo:</label>&nbsp;</td>
												<td align="left" width="85%"><select id="cmbDiscipulo" style="width:500px;" name="filtros"></select>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td align="center" width="100%" colspan="2" valign="middle" style="height:50px;">
							<br>
							<table class="tdBotao" cellpadding="3" cellspacing="0" border="0">
								<tr>
									<td class="tdBotao" id="tdGerar" style="width:120px;"><img src="<?php echo $VirtualDir?>images/useradmin.gif" border=0 height=16 width=16>&nbsp;Pesquisar</td>
									<td class="tdBotao" id="tdImprimir" style="width:70px;" style="display:none;"><img src="<?php echo $VirtualDir?>images/printer.gif" border=0 height=16 width=16>&nbsp;Imprimir Todos</td>
									<td class="tdBotao" id="tdLimpar" style="width:120px;"><img src="<?php echo $VirtualDir?>images/back.png" border=0 height=16 width=16>&nbsp;Limpar Tudo</td>
								</tr>
							</table>
							<br>
							<div id="divPrintInfo" style="display:none"></div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
<iframe id="printFrame" href="<?php echo $VirtualDir?>none.php?" style="display:none"></iframe>
<?php include("include/bottom.php");?>