<?php
session_start();
$TituloPagina = "Question&aacute;rio de Dons";
@require_once("include/functions.php");
@require_once("include/header_simples.php");
@require_once("include/rules.php");
$userID = fRequest("userID");
$PHP_SELF = $VirtualDir."complete.php?userID=$userID";
fConnDB();
@include("include/upperbar.php");
?>
<script type="text/javascript" language=javascript src="<?php echo $VirtualDir?>js/complete.js?"></script>
<br/>
<br/>
<form>
	<input type="hidden" value="<?php echo $userID;?>" id="userID"/>
	<table width="100%" height="80%" cellspacing="0" cellpadding="0" align="center" valign="top" border="0">
		<tr>
			<td valign="top">
				<table cellspacing="0" cellpadding="0" align="center" class="tblFrame" style="width:70%">
					<tr>
						<td class="tdCaption" width="80%">A Campal 2013 e voc&ecirc;</td>
						<td class="tdCaption" width="20%"><span name="btnClose" class="pg">SAIR</span></td>
					</tr>
				</table>
				<?php
				$class = "";
				$tabindex = 1;
				
				$arr = fGetPendencia($conn,$userID);
				?>
				<table cellspacing="1" cellpadding="0" align="center" style="width:70%">
					<tr>
						<td align="center" class="THeader" style="width:30%;">Informe:</td>
						<td class="THeader" align="center" style="width:70%">Por gentileza, responda os dados abaixo:</td>
					</tr>
					
					<?php if (array_key_exists("color",$arr) && $arr['color']):
						if ($class == "LstDark"):
							$class = "LstLight";
						else:
							$class = "LstDark";
						endif;
					?>
					<tr>
						<td align="right" class="<?php echo $class;?>" style="width:30%;font-size:13pt;font-weight:bold;">Cor de sua pulseira:&nbsp;</td>
						<td align="left"  class="<?php echo $class;?>" style="width:70%;">
							<select name="cmbQuestao" class="blank" tabindex="<?echo $tabindex++;?>" id="corDS" required="true">
								<option value=""></option>
								<option value="AMARELA">AMARELA</option>
								<option value="VERDE">VERDE</option>
								<option value="VERMELHA">VERMELHA</option>
								<option value="ROXA">ROXA</option>
							</select>
						</td>
					</tr>
					<?php endif;?>
					<?php if (array_key_exists("disci",$arr) && $arr['disci']):
						if ($class == "LstDark"):
							$class = "LstLight";
						else:
							$class = "LstDark";
						endif;
					?>
					<tr>
						<td align="right" class="<?php echo $class;?>" style="width:30%;font-size:13pt;font-weight:bold;">Disc&iacute;pulo:&nbsp;</td>
						<td align="left"  class="<?php echo $class;?>" style="width:70%;">
								<select class="blank" name="cmbQuestao" tabindex="<?echo $tabindex++;?>" id="discipuloID" required="true">
								<option value=""></option>
								<?php
								$resposta = $conn->Execute("SELECT id_discipulo, nm_discipulo FROM discipulo ORDER BY nm_discipulo");
								while (!$resposta->EOF):
									echo "<option value=\"".$resposta->fields['id_discipulo']."\">".$resposta->fields['nm_discipulo']."</option>";
									$resposta->MoveNext();
								endwhile;
								?>
								</select>
						</td>
					</tr>
					<?php endif;?>
					<?php if (array_key_exists("email",$arr) && $arr['email']):
						if ($class == "LstDark"):
							$class = "LstLight";
						else:
							$class = "LstDark";
						endif;
					?>
					<tr>
						<td align="right" class="<?php echo $class;?>" style="width:30%;font-size:13pt;font-weight:bold;">Email:&nbsp;</td>
						<td align="left"  class="<?php echo $class;?>" style="width:70%;"><input type="text" name="cmbQuestao" id="emailDS" class="blank" style="width:550px" tabindex="<?echo $tabindex++;?>" required="true"/></td>
					</tr>
					<?php endif;?>
					<tr>
						<td align="center" width="100%" colspan="2" valign="middle" style="height:40px;">
							<a href="#" id="submitButton" tabindex="<?echo $tabindex++;?>">
								<table cellpadding="3" cellspacing="0" border="0">
									<tr>
										<td class="tdBotao" style="width:70px;"><img src="<?php echo $VirtualDir?>images/salvar.png" border="0" height="20" width="20">&nbsp;Gravar</td>
									</tr>
								</table>
							</a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
<?php include("include/bottom.php");?>