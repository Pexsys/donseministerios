<?php
session_start();
$TituloPagina = "Question&aacute;rio de Minist&eacute;rios";
@require_once("include/functions.php");
@require_once("include/rules.php");
@require_once("include/header_simples.php");
$userID = fRequest("userID");
$PHP_SELF = $VirtualDir."testedeministerios.php?userID=$userID";
fConnDB();
@include("include/upperbar.php");
?>
<script type="text/javascript" language=javascript src="<?php echo $VirtualDir?>js/testedeministerios.js?"></script>
<br/>
<br/>
<form>
	<input type="hidden" value="<?php echo $userID;?>" id="userID"/>
	<table width="100%" height="80%" cellspacing="0" cellpadding="0" align="center" valign="top" border="0">
		<tr>
			<td valign="top">
				<table cellspacing="0" cellpadding="0" align="center" class="tblFrame" style="width:50%">
					<tr>
						<td class="tdCaption" width="75%">TESTE DE MINIST&Eacute;RIOS</td>
						<td class="tdCaption" width="25%"><span name="btnClose" class="exit"><img alt="Gravar e Sair" border="0" height="16" width="16" src="<?php echo $VirtualDir?>images/salvar.png"/>&nbsp;Gravar e Sair</span></td>
					</tr>
				</table>
				<table cellspacing="1" cellpadding="0" align="center" style="width:50%">
					<tr>
						<td align="center" class="THeader" style="width:10px;">C&oacute;digo</td>
						<td class="THeader" align="center" colspan="2">D&ecirc; sua nota de 1 a 10 apenas para o(s) minist&eacute;rio(s) de seu interesse</td>
					</tr>
					<?php
						$f = "1";
						$class = "";
						$numreg = 15; // Quantos registros por pagina vai ser mostrado
						$pg = fRequest("pg");
						if ($pg == ""):
							$pg = 0;
						endif;
						$inicial = $pg * $numreg;

						$cj_ministerio_ant = "";
						
						// Serve para contar quantos registros voce tem na tabela para fazer a paginacao
						$sqlQuery = "
							SELECT
							 q.id_ministerio,
							 q.cd_ministerio,
							 q.ds_ministerio,
							 m.ds_cj_ministerio,
							 r.nr_nota
							FROM ministerios q
							INNER JOIN cj_ministerio m ON (m.id_cj_ministerio = q.id_cj_ministerio)
							LEFT JOIN rp_ministerios r ON (r.id_ministerio = q.id_ministerio AND (r.id_pessoa = $userID OR r.id_pessoa IS NULL))
							ORDER BY q.cd_ministerio
						";
						$sql_conta = $conn->Execute($sqlQuery);
						$quantreg = $sql_conta->RecordCount(); // Quantidade de registros pra paginacao

						$tabindex = 0;
						$result = $conn->Execute("$sqlQuery LIMIT $inicial, $numreg");
						while (!$result->EOF):
							if ($class == "LstDark"):
								$class = "LstLight";
							else:
								$class = "LstDark";
							endif;
							
							$cj_ministerio = utf8_decode($result->fields['ds_cj_ministerio']);
							if ( $cj_ministerio_ant != $cj_ministerio ):
								echo "<tr><td class=\"THMinistries\" align=\"center\" colspan=\"3\">$cj_ministerio</td></tr>";
								$cj_ministerio_ant = $cj_ministerio;
							endif;
							?>
							<tr>
								<td align="right" class="<?php echo $class;?>" style="width:35px;font-size:15pt;font-weight:bold;"><?php echo $result->fields['cd_ministerio'];?>&nbsp;</td>
								<td align="left"  class="<?php echo $class;?>" style="width:100%"><?php echo utf8_decode($result->fields['ds_ministerio']);?></td>
								<td align="right" class="<?php echo $class;?>" style="width:40px;font-size:15pt;font-weight:bold;">
									<select name="cmbMinisterio" ministerio="<?php echo $result->fields['id_ministerio'];?>" basevalue="<?php echo $result->fields['nr_nota'];?>" tabindex="<?php echo ++$tabindex;?>">;
										<option value=""></option>
										<?php
										for ($i=1;$i<=10;$i++):
											echo "<option value=\"$i\">$i</option>";
										endfor;
										?>
									</select>
								</td>
							</tr>
							<?php
							$result->MoveNext();
						endwhile;
					?>
				</table>
				<table cellspacing="0" cellpadding="0" align="center" class="tblFrame" style="width:50%">
					<tr>
						<td class="tdCaption" style="text-align:center;height:40px"><?php include("include/paginacao.php");?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
<?php include("include/bottom.php");?>