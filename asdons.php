<?php
session_start();
@require_once("include/_variables.php");
@include("include/functions.php");
fConnDB();

$arr = array();
$userID = fRequest("userID");
$showRes = fRequest("showRes");

//PESQUISA CARACTERISTICA DO DOM
if ( $showRes == "caracteristica" ):

	$id = fRequest("id");
	$result = $conn->Execute("
		SELECT 
			ds_dom,
			ds_descricao,
			ds_ref_biblica,
			ds_tarefas
		FROM
			dons
		WHERE id_dom = $id
	");
	if (!$result->EOF):
		$arr['dom'] = $result->fields['ds_dom'];
		$arr['ref'] = $result->fields['ds_descricao'] .
			"<p><b><u>Refer&ecirc;ncias B&iacute;blicas</u></b></p>".$result->fields['ds_ref_biblica'] . 
			"<p><b><u>Tarefas Sugeridas</u></b></p>".$result->fields['ds_tarefas'];
	endif;

else:

	$arr['page'] = fRequest("toUrl");
	$data = fRequest("data");

	//GRAVA DADOS COMPLEMENTARES E VAI PARA TELA DE QUESTIONARIO
	if (fRequest("complete") == "true"):
		$strUpdate = "";
		
		$corDS = fRequest("corDS");
		if ( isset($corDS) && !empty($corDS) ):
			$strUpdate .= ", ds_cor = '$corDS'";
		endif;
		
		$discipuloID = fRequest("discipuloID");
		if ( isset($discipuloID) && !empty($discipuloID) ):
			$strUpdate .= ", id_discipulo = $discipuloID";
		endif;
		
		$emailDS = fRequest("emailDS");
		if ( isset($emailDS) && !empty($emailDS) ):
			$strUpdate .= ", cd_email = '$emailDS'";
		endif;
		$conn->Execute("UPDATE pessoa SET ".substr($strUpdate,1)." WHERE id_pessoa = $userID");
		$conn->Execute("COMMIT");

		$arr['page'] = $VirtualDir."testededons.php?userID=$userID";

	else:
		//ANALISA RESPOSTAS DA PÁGINA
		foreach ($data as $k => $v):
			$questao = $v["questao"];
			$resposta = $v["resposta"];
			$temNaTela = trim($resposta) != "";

			$result = $conn->Execute("
				SELECT 
					id_cj_resposta
				FROM
					rp_dons
				WHERE id_pessoa = $userID 
					AND id_questao = $questao
			");
			$temNaBase = (!$result->EOF);

			if ($temNaTela && $temNaBase):
				if ( $resposta != $result->fields['id_cj_resposta'] ):
					$conn->Execute("UPDATE rp_dons SET id_cj_resposta = $resposta WHERE id_pessoa = $userID AND id_questao = $questao");
				endif;
			elseif ($temNaTela && !$temNaBase):
				$conn->Execute("INSERT INTO rp_dons(id_pessoa,id_questao,id_cj_resposta) VALUES($userID,$questao,$resposta)");
			elseif (!$temNaTela && $temNaBase):
				$conn->Execute("DELETE FROM rp_dons WHERE id_pessoa = $userID AND id_questao = $questao");
			endif;

		endforeach;
		$conn->Execute("COMMIT");

		if ($showRes == -1):
			$arr['page'] = $VirtualDir."login.php?";

		elseif ($showRes):
			$arr['page'] = $VirtualDir."menuprincipal.php?userID=$userID";
			$result = $conn->Execute("
				SELECT q.id_questao FROM qs_dons q
				LEFT JOIN rp_dons r ON (r.id_questao = q.id_questao AND (r.id_pessoa = $userID OR r.id_pessoa IS NULL))
				WHERE r.id_cj_resposta IS NULL
			");
			if ($result->EOF):
				$conn->Execute("
					INSERT INTO rs_dons(id_pessoa, id_dom, nr_resultado) 
						SELECT $userID as id_pessoa, res.id_dom, res.nr_resultado 
						FROM
							(SELECT q.id_dom, SUM(c.nr_peso) as nr_resultado
								FROM rp_dons r 
							INNER JOIN qs_dons q ON (r.id_questao = q.id_questao)
							INNER JOIN cj_resposta c ON (r.id_cj_resposta = c.id_cj_resposta)
							WHERE r.id_pessoa = $userID
							GROUP BY 1) res
				");
				$conn->Execute("DELETE FROM rp_dons WHERE id_pessoa = $userID"); 
				$conn->Execute("COMMIT"); 
				$arr['page'] = $VirtualDir."rsdons.php?userID=$userID";
			endif;
		endif;
	endif;
endif;
echo json_encode($arr);	
?>