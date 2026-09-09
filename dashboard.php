<?php
session_start();
$TituloPagina = "Question&aacute;rio de Dons";
@require_once("include/functions.php");
@require_once("include/header_simples.php");
@require_once("include/rules.php");
$userID = fRequest("userID");
$PHP_SELF = $VirtualDir."dashboard.php?userID=$userID";
fConnDB();
@include("include/upperbar.php");

function fPct($num,$numTot,$dec){
	return round(($num*100)/$numTot,$dec);
}
function fPctNum($pct,$numTot,$dec){
	return round(($pct*$numTot)/100,$dec);
}
?>
<script type="text/javascript" language=javascript src="<?php echo $VirtualDir?>js/dashboard.js?"></script>
<br/>
<br/>
<form>
	<table width="100%" height="80%" cellspacing="0" cellpadding="0" align="center" valign="top" border="0">
		<tr>
			<td valign="top">
				<table cellspacing="0" cellpadding="0" align="center" class="tblFrame" style="width:50%">
					<tr>
						<td class="tdCaption" width="80%">Teste de Dons - DASHBOARD</td>
					</tr>
				</table>
				<br/>
				<table cellspacing="1" cellpadding="0" align="center" style="width:50%">
					<tr>
						<td class="THeader" align="center" style="width:100%" colspan="3"><b>Geral</b></td>
					</tr>
					<?php
						$result = $conn->Execute("SELECT COUNT(*) as qtd FROM questao");
						$qtdQst = $result->fields['qtd'];
						$qtd75 = fPctNum(75,$qtdQst,1);
						$qtd50 = fPctNum(50,$qtdQst,1);
						$qtd25 = fPctNum(25,$qtdQst,1);
					
						$result = $conn->Execute("
							SELECT COUNT(*) as qtd
							FROM pessoa p
							WHERE p.tp_inscricao NOT IN ('BEBE','CRIANCA')
						");
						$qtdGrupo = $result->fields['qtd'];
					?>
					<tr>
						<td class="LstDark" align="left" style="width:60%;"><b>Inscritos na Campal</b></td>
						<td class="LstDark" align="center" style="width:20%;"><b><?echo $qtdGrupo?></b></td>
						<td class="LstDark" align="center" style="width:20%;"><b><?echo fPct($qtdGrupo,$qtdGrupo,0)?>%</b></td>
					</tr>
					<?php
						$result = $conn->Execute("
							SELECT COUNT(*) as qtd
							FROM pessoa p
							WHERE p.tp_inscricao NOT IN ('BEBE','CRIANCA') 
							AND p.ds_senha IS NOT NULL
						");
						$qtd = $result->fields['qtd'];
					?>
					<tr>
						<td class="LstLight" align="left" style="width:60%;"><b>Quantos j&aacute; acessaram</b></td>
						<td class="LstLight" align="center" style="width:20%;"><b><?echo $qtd?></b></td>
						<td class="LstLight" align="center" style="width:20%;"><b><?echo fPct($qtd,$qtdGrupo,1)?>%</b></td>
					</tr>
					<?php
						$result = $conn->Execute("
							SELECT DISTINCT p.id_pessoa
							FROM pessoa p
							INNER JOIN rs_dons r ON (r.id_pessoa = p.id_pessoa)
						");
						$qtd = $result->RecordCount();
					?>
					<tr>
						<td class="LstDark" align="left" style="width:60%;"><b>Quantos completaram 100% do teste</b></td>
						<td class="LstDark" align="center" style="width:20%;"><b><?echo $qtd?></b></td>
						<td class="LstDark" align="center" style="width:20%;"><b><?echo fPct($qtd,$qtdGrupo,1)?>%</b></td>
					</tr>
					<?php
						$result = $conn->Execute("
							SELECT * FROM (
								SELECT p.id_pessoa, COUNT(*) as qtd
								FROM pessoa p
								INNER JOIN rp_dons r ON (r.id_pessoa = p.id_pessoa)
								WHERE p.ds_senha IS NOT NULL
								GROUP BY r.id_pessoa
							) a WHERE a.qtd > $qtd75
						");
						$qtd = $result->RecordCount();
					?>
					<tr>
						<td class="LstLight" align="left" style="width:60%;"><b>Quantos completaram acima de 75% do teste</b></td>
						<td class="LstLight" align="center" style="width:20%;"><b><?echo $qtd?></b></td>
						<td class="LstLight" align="center" style="width:20%;"><b><?echo fPct($qtd,$qtdGrupo,1)?>%</b></td>
					</tr>
					<?php
						$result = $conn->Execute("
							SELECT * FROM (
								SELECT p.id_pessoa, COUNT(*) as qtd
								FROM pessoa p
								INNER JOIN rp_dons r ON (r.id_pessoa = p.id_pessoa)
								WHERE p.ds_senha IS NOT NULL
								GROUP BY r.id_pessoa
							) a WHERE a.qtd BETWEEN ($qtd50+1) AND $qtd75
						");
						$qtd = $result->RecordCount();
					?>
					<tr>
						<td class="LstDark" align="left" style="width:60%;"><b>Quantos completaram at&eacute; 75% do teste</b></td>
						<td class="LstDark" align="center" style="width:20%;"><b><?echo $qtd?></b></td>
						<td class="LstDark" align="center" style="width:20%;"><b><?echo fPct($qtd,$qtdGrupo,1)?>%</b></td>
					</tr>
					<?php
						$result = $conn->Execute("
							SELECT * FROM (
								SELECT p.id_pessoa, COUNT(*) as qtd
								FROM pessoa p
								INNER JOIN rp_dons r ON (r.id_pessoa = p.id_pessoa)
								WHERE p.ds_senha IS NOT NULL
								GROUP BY r.id_pessoa
							) a WHERE a.qtd BETWEEN ($qtd25+1) AND $qtd50
						");
						$qtd = $result->RecordCount();
					?>
					<tr>
						<td class="LstLight" align="left" style="width:60%;"><b>Quantos completaram at&eacute; 50% do teste</b></td>
						<td class="LstLight" align="center" style="width:20%;"><b><?echo $qtd?></b></td>
						<td class="LstLight" align="center" style="width:20%;"><b><?echo fPct($qtd,$qtdGrupo,1)?>%</b></td>
					</tr>
					<?php
						$qtd25 = fPctNum(25,$qtdQst,1);
						$result = $conn->Execute("
							SELECT * FROM (
								SELECT p.id_pessoa, COUNT(*) as qtd
								FROM pessoa p
								INNER JOIN rp_dons r ON (r.id_pessoa = p.id_pessoa)
								WHERE p.ds_senha IS NOT NULL
								GROUP BY r.id_pessoa
							) a WHERE a.qtd BETWEEN 0 AND $qtd25
						");
						$qtd = $result->RecordCount();
					?>
					<tr>
						<td class="LstDark" align="left" style="width:60%;"><b>Quantos completaram at&eacute; 25% do teste</b></td>
						<td class="LstDark" align="center" style="width:20%;"><b><?echo $qtd?></b></td>
						<td class="LstDark" align="center" style="width:20%;"><b><?echo fPct($qtd,$qtdGrupo,1)?>%</b></td>
					</tr>
				</table>
				<br/>
				<table cellspacing="1" cellpadding="0" align="center" style="width:50%">
					<tr>
						<td class="THeader" align="center" style="width:100%" colspan="4"><b>Testes completados Por Regi&atilde;o</b></td>
					</tr>
					<?php
						$result = $conn->Execute("
						SELECT yy.cd_regiao, yy.ds_regiao, yy.qtd, rr.qt_regiao, ((yy.qtd*100)/rr.qt_regiao) as pc_regiao
						FROM
							(SELECT xx.id_regiao,  xx.cd_regiao, xx.ds_regiao, COUNT(*) as qtd 
							FROM
								(SELECT DISTINCT p.id_pessoa, r.id_regiao, r.cd_regiao, r.ds_regiao
								FROM pessoa p
								INNER JOIN rs_dons rs ON (rs.id_pessoa = p.id_pessoa)
								INNER JOIN caravana c ON (c.id_caravana = p.id_caravana)
								INNER JOIN regiao r ON (r.id_regiao = c.id_regiao)) xx
								GROUP BY 1,2) yy
						INNER JOIN 
							(SELECT r.id_regiao, r.cd_regiao, r.ds_regiao, count(*) AS qt_regiao
							FROM pessoa p
							INNER JOIN caravana c ON (c.id_caravana = p.id_caravana)
							INNER JOIN regiao r ON (r.id_regiao = c.id_regiao)
							GROUP BY 1,2,3) rr
						ON rr.id_regiao = yy.id_regiao
						ORDER BY 5 DESC, 2
						");
						$class = "";
						$ordem = 0;
						while (!$result->EOF):
							if ($class == "LstDark"):
								$class = "LstLight";
							else:
								$class = "LstDark";
							endif;
							?>
							<tr>
								<td class="<?php echo $class;?>" align="center" style="width:10%;"><?php echo ++$ordem;?>&ordm;&nbsp;</td>
								<td class="<?php echo $class;?>" align="left" style="width:50%;"><?echo $result->fields['cd_regiao']."-". $result->fields['ds_regiao'];?></td>
								<td class="<?php echo $class;?>" align="center" style="width:20%;"><?echo $result->fields['qtd']." / ". $result->fields['qt_regiao'];?></td>
								<td class="<?php echo $class;?>" align="center" style="width:20%;"><?echo fPct($result->fields['qtd'],$result->fields['qt_regiao'],1)?>%</td>
							</tr>
							<?php
							$result->MoveNext();
						endwhile;
					?>
				</table>
				<br/>
				<table cellspacing="1" cellpadding="0" align="center" style="width:50%">
					<tr>
						<td class="THeader" align="center" style="width:100%" colspan="4"><b>Testes completados Por Caravana</b></td>
					</tr>
					<?php
						$result = $conn->Execute("
						SELECT yy.nm_caravana, yy.qtd, rr.qt_caravana, ((yy.qtd*100)/rr.qt_caravana) as pc_caravana
						FROM
							(SELECT xx.id_caravana, xx.nm_caravana, COUNT(*) as qtd 
							FROM
								(SELECT DISTINCT p.id_pessoa, c.id_caravana, c.nm_caravana
								FROM pessoa p
								INNER JOIN rs_dons rs ON (rs.id_pessoa = p.id_pessoa)
								INNER JOIN caravana c ON (c.id_caravana = p.id_caravana)) xx
							GROUP BY 1,2) yy
						INNER JOIN 
							(SELECT c.id_caravana, c.nm_caravana, count(*) AS qt_caravana
							FROM pessoa p
							INNER JOIN caravana c ON (c.id_caravana = p.id_caravana)
							GROUP BY 1,2) rr
						ON rr.id_caravana = yy.id_caravana
						ORDER BY 4 DESC, 1
						");
						$class = "";
						$ordem = 0;
						while (!$result->EOF):
							if ($class == "LstDark"):
								$class = "LstLight";
							else:
								$class = "LstDark";
							endif;
							?>
							<tr>
								<td class="<?php echo $class;?>" align="center" style="width:10%;"><?php echo ++$ordem;?>&ordm;&nbsp;</td>
								<td class="<?php echo $class;?>" align="left" style="width:50%;"><?echo $result->fields['nm_caravana'];?></td>
								<td class="<?php echo $class;?>" align="center" style="width:20%;"><?echo $result->fields['qtd'] ." / ". $result->fields['qt_caravana'];?></td>
								<td class="<?php echo $class;?>" align="center" style="width:20%;"><?echo fPct($result->fields['qtd'],$result->fields['qt_caravana'],1)?>%</td>
							</tr>
							<?php
							$result->MoveNext();
						endwhile;
					?>
				</table>
				<br/>
				<table cellspacing="1" cellpadding="0" align="center" style="width:50%">
					<tr>
						<td class="THeader" align="center" style="width:100%" colspan="3"><b>Perfil da Campal 2013 - Disc&iacute;pulo Teu - M&eacute;dia de pontos</b></td>
					</tr>
					<?php
						$result = $conn->Execute("
							SELECT d.ds_dom, AVG(r.nr_resultado) AS media
							FROM rs_dons r
							INNER JOIN dons d ON (r.id_dom = d.id_dom)
							GROUP BY 1
							ORDER BY 2 desc				
						");
						$class = "";
						$ordem = 0;
						while (!$result->EOF):
							if ($class == "LstDark"):
								$class = "LstLight";
							else:
								$class = "LstDark";
							endif;
							?>
							<tr>
								<td class="<?php echo $class;?>" align="center" style="width:10%;"><?php echo ++$ordem;?>&ordm;&nbsp;</td>
								<td class="<?php echo $class;?>" align="left" style="width:70%;"><?echo $result->fields['ds_dom'];?></td>
								<td class="<?php echo $class;?>" align="center" style="width:20%;"><?echo round($result->fields['media'],2);?></td>
							</tr>
							<?php
							$result->MoveNext();
						endwhile;
					?>
				</table>
			</td>
		</tr>
	</table>
</form>
<?php include("include/bottom.php");?>