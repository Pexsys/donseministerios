<?php
session_start();
@require_once("include/_variables.php");
@include("include/functions.php");
fConnDB();

$userID = fRequest("userID");
$data = fRequest("data");
$showRes = fRequest("showRes");

$arr = array();
$arr['page'] = fRequest("toUrl");

//GRAVA DADOS COMPLEMENTARES E VAI PARA TELA DE QUESTIONARIO
if (fRequest("complete") == "true"):
	$strUpdate = "";

	/*	
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
	*/

	$arr['page'] = $VirtualDir."testedeministerios.php?userID=$userID";

else:
	//ANALISA RESPOSTAS DA PÁGINA
	foreach ($data as $k => $v):
		$ministerio = $v["ministerio"];
		$resposta = $v["resposta"];
		$temNaTela = trim($resposta) != "";

		$result = $conn->Execute("
			SELECT nr_nota
			FROM rp_ministerios
			WHERE id_pessoa = $userID 
				AND id_ministerio = $ministerio
		");
		$temNaBase = (!$result->EOF);

		if ($temNaTela && $temNaBase):
			if ( $resposta != $result->fields['nr_nota'] ):
				$conn->Execute("UPDATE rp_ministerios SET nr_nota = $resposta WHERE id_pessoa = $userID AND id_ministerio = $ministerio");
			endif;
		elseif ($temNaTela && !$temNaBase):
			$conn->Execute("INSERT INTO rp_ministerios(id_pessoa,id_ministerio,nr_nota) VALUES($userID,$ministerio,$resposta)");
		elseif (!$temNaTela && $temNaBase):
			$conn->Execute("DELETE FROM rp_ministerios WHERE id_pessoa = $userID AND id_ministerio = $ministerio");
		endif;

	endforeach;
	$conn->Execute("COMMIT");

	endif;
echo json_encode($arr);	
?>