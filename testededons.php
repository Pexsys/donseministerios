<?php
session_start();
$TituloPagina = "Question&aacute;rio de Dons";
@require_once("include/functions.php");
@require_once("include/rules.php");
@require_once("include/header_simples.php");
$userID = fRequest("userID");
$PHP_SELF = $VirtualDir."testededons.php?userID=$userID";
fConnDB();
@include("include/upperbar.php");
?>
<script type="text/javascript" language=javascript src="<?php echo $VirtualDir?>js/testededons.js?"></script>
<br/>
<br/>
<form>
	<input type="hidden" value="<?php echo $userID;?>" id="userID"/>
	<table width="100%" height="80%" cellspacing="0" cellpadding="0" align="center" valign="top" border="0">
		<tr>
			<td valign="top">
				<table cellspacing="0" cellpadding="0" align="center" class="tblFrame" style="width:50%">
					<tr>
						<td class="tdCaption" width="75%">TESTE DE DONS</td>
						<td class="tdCaption" width="25%"><span name="btnClose" class="exit"><img alt="Gravar e Sair" border="0" height="16" width="16" src="<?php echo $VirtualDir?>images/salvar.png"/>&nbsp;Gravar e Sair</span></td>
					</tr>
				</table>
				<table cellspacing="1" cellpadding="0" align="center" style="width:50%">
					<tr>
						<td align="center" class="THeader" style="width:10px;">Quest&atilde;o</td>
						<td class="THeader" align="center">Selecione a resposta que melhor se encaixa a voc&ecirc; para cada quest&atilde;o abaixo:</td>
					</tr>
					<?php
						$f = "";
						$class = "";
						$numreg = 15; // Quantos registros por pagina vai ser mostrado
						$pg = fRequest("pg");
						
						//quantas respostas faltam por pagina
						$arrayPages = array();
						$result = $conn->Execute("
							SELECT
								ceil(q.nr_ordem / $numreg)-1 as page,
								count(*) as qtd
							FROM qs_dons q
							LEFT JOIN rp_dons r ON (r.id_questao = q.id_questao AND (r.id_pessoa = $userID OR r.id_pessoa IS NULL))
							WHERE r.id_cj_resposta IS NULL
							GROUP BY 1
							ORDER BY page
						");
						while (!$result->EOF):
							$arrayPages[$result->fields['page']] = $result->fields['qtd'];
							$result->MoveNext();
						endwhile;

						if ($pg == ""):
							if (sizeof($arrayPages) == 0):
								$pg = 0;
							else:
								$pg = key($arrayPages);
							endif;
						endif;
						$inicial = $pg * $numreg;

						$cd_cj_resposta_ant = "";
						$cmb_resposta_base = "";
						
						// Serve para contar quantos registros voce tem na tabela para fazer a paginacao
						$sqlQuery = "
							SELECT
								q.id_questao,
								q.nr_ordem,
								q.ds_prefixo,
								q.ds_texto,
								q.cd_cj_resposta,
								r.id_cj_resposta
							FROM qs_dons q
							LEFT JOIN rp_dons r ON (r.id_questao = q.id_questao AND (r.id_pessoa = $userID OR r.id_pessoa IS NULL))
							ORDER BY q.nr_ordem
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

							$id_questao = $result->fields['id_questao'];
							$id_cj_resposta = $result->fields['id_cj_resposta'];
							$cd_cj_resposta = $result->fields['cd_cj_resposta'];

							if ( $cd_cj_resposta_ant != $cd_cj_resposta ):
								$cd_cj_resposta_ant = $cd_cj_resposta;

								$cmb_resposta_base = "<select basevalue=\"\" class=\"blank\" name=\"cmbQuestao\" question=\"\" tabindex=\"\">";
								$cmb_resposta_base .= "<option></option>";
								$resposta = $conn->Execute("
									SELECT
										id_cj_resposta,
										ds_resposta
									FROM cj_resposta
									WHERE cd_cj_resposta = $cd_cj_resposta
									ORDER BY nr_ordem
									");
								while (!$resposta->EOF):
									$cmb_resposta_base .= "<option value=\"".$resposta->fields['id_cj_resposta']."\">".$resposta->fields['ds_resposta']."</option>";
									$resposta->MoveNext();
								endwhile;
								$cmb_resposta_base .= "</select>";
							endif;
							$cmb_resposta = $cmb_resposta_base;

							++$tabindex;
							$cmb_resposta = str_replace( " question=\"\"", " question=\"$id_questao\"", $cmb_resposta );
							$cmb_resposta = str_replace( " tabindex=\"\"", " tabindex=\"$tabindex\"", $cmb_resposta );
							if (isset($id_cj_resposta)):
								$cmb_resposta = str_replace( " basevalue=\"\"", " basevalue=\"$id_cj_resposta\"", $cmb_resposta );
								$cmb_resposta = str_replace( " class=\"blank\"", " class=\"\"", $cmb_resposta );
							endif;

							$texto =  $result->fields['ds_prefixo'];
							$texto .= "&nbsp;$cmb_resposta&nbsp;";
							$texto .= $result->fields['ds_texto'];
							?>
							<tr>
								<td align="right" class="<?php echo $class;?>" style="width:35px;font-size:15pt;font-weight:bold;"><?php echo $result->fields['nr_ordem'];?>&nbsp;</td>
								<td align="left"  class="<?php echo $class;?>" style="width:100%"><?php echo utf8_decode($texto);?></td>
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