<?php
session_start();
$TituloPagina = "Pesquisas";
@require_once("include/functions.php");
@require_once("include/rules.php");
@require_once("include/header_simples.php");
$userID = fRequest("userID");
$PHP_SELF = $VirtualDir."researching.php?userID=$userID";
fConnDB();
@include("include/upperbar.php");
?>
<script type="text/javascript" language=javascript src="<?php echo $VirtualDir?>js/researching.js?"></script>
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
							<div id="radio">
								<input type="radio" id="radioDom" name="optFiltros" checked="checked" value="dons"/><label for="radioDom">Dons</label>
								<input type="radio" id="radioMin" name="optFiltros" value="ministerios"/><label for="radioMin">Minist&eacute;rios</label>
							</div>
							<table cellspacing="1" cellpadding="1" border="0" width="99%">
								<tr>
									<td style="border:1px outset;">
										<table cellspacing="5" cellpadding="0" border="0" width="100%">
											<tr>
												<td align="right" width="20%"><label for="txtNomePessoa" class="input">Nome da Pessoa:</label>&nbsp;</td>
												<td align="left" width="80%"><input type="text" id="txtNomePessoa" name="filtros" style="width:500px;"/></td>
											</tr>
											<tr>
												<td align="right" width="20%"><label id="lblcmbSearch" for="cmbSearch" class="input">Dom:</label>&nbsp;</td>
												<td align="left" width="80"><select id="cmbSearch" style="width:500px;" name="filtros"></select></td>
											</tr>
											<tr>
												<td align="right" width="20%"><label id="lblcmbPontuacao" for="cmbPontuacao" class="input">Pontua&ccedil;&atilde;o:</label>&nbsp;</td>
												<td align="left" width="80%">
													<select id="cmbPontuacao" name="filtros" style="width:150px;">
														<option value="" selected></option>
														<option value="igual">Igual a:</option>
														<option value="menor">Menor que:</option>
														<option value="maior">Maior que:</option>
														<option value="entre">Entre:</option>
													</select>&nbsp;
													<input type="text" id="txtValorMenor" style="width:30px;display:none;"/>
													<label id="lbltxtValorMaior" class="input" style="height:15px;display:none;">e</label>
													<input type="text" id="txtValorMaior" style="width:30px;display:none;"/>
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