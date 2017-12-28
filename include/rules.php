<?php
function fGetPerfil($conn,$userID){
	$arr = array();
	$result = $conn->Execute("
		SELECT DISTINCT pf.cd_perfil FROM perfil pf 
		INNER JOIN pessoa pp ON (pp.id_pessoa = pf.id_pessoa)
		WHERE pp.id_pessoa = $userID
	");
	while (!$result->EOF):
		$arr[ $result->fields['cd_perfil'] ] = true;
		$result->MoveNext();
	endwhile;
	return $arr;
}

function fExistResultado($conn,$userID){
	$result = $conn->Execute("SELECT * FROM rs_dons WHERE id_pessoa = $userID");
	return !$result->EOF;
}

function fExistMinisterios($conn,$userID){
	$result = $conn->Execute("SELECT * FROM rp_ministerios WHERE id_pessoa = $userID");
	return !$result->EOF;
}

function fGetPendencia($conn,$userID){
	$arr = array();
	$result = $conn->Execute("SELECT * FROM pessoa WHERE id_pessoa = $userID");
	if ( !$result->EOF ):
		$area = $result->fields['tp_area'];
		if ( $area == "ACAMPANTE" ):
			$cor = $result->fields['ds_cor'];
			if ( !isset($cor) || empty($cor) ):
				$arr['color'] = true;
				$askColor = true;
			endif;
			
			$discipulo = $result->fields['id_discipulo'];
			if ( !isset($discipulo) || empty($discipulo) ):
				$arr['disci'] = true;
			endif;
		endif;
		
		$email = $result->fields['ds_email'];
		if ( !isset($email) || empty($email) ):
			$arr['email'] = true;
		endif;
	endif;
	return $arr;
}

function fRsFields($result,$label,$field){
	$retorno = "";
	if ( isset($result->fields[$field]) && $result->fields[$field] != "" ):
		$retorno .= "<tr>";
		$retorno .= "<td class=\"LstDark\" align=\"right\" style=\"width:20%;\"><b>".$label.":</b>&nbsp;</td>";
		$retorno .= "<td class=\"LstDark\" align=\"left\" style=\"width:80%;\">".$result->fields[$field]."</td>";
		$retorno .= "</tr>";
	endif;
	return $retorno;
}

function fRsCabecalhoPessoa($conn,$userID){
	$result = $conn->Execute("SELECT * FROM pessoa WHERE id_pessoa = $userID");
	$retorno = "<table cellspacing=\"1\" cellpadding=\"0\" align=\"center\" style=\"width:100%\">";
	$retorno .= fRsFields($result,"Nome","nm_pessoa");
	$retorno .= fRsFields($result,"Classe","ds_classe_es");
	$retorno .= fRsFields($result,"Email","cd_email");
	$retorno .= fRsFields($result,"Contato","ds_contato");
	$retorno .= "</table>";
	return $retorno;
}

function fRsDons($conn,$userID,$linkDetails = false){
	$retorno = fRsCabecalhoPessoa($conn,$userID);
	$retorno .= "<table cellspacing=\"1\" cellpadding=\"0\" align=\"center\" style=\"width:100%\">";
	$retorno .= "<tr>";
	$retorno .= "<td class=\"THeader\" align=\"center\" style=\"width:10px;\">Ordem</td>";
	$retorno .= "<td class=\"THeader\" align=\"center\" style=\"width:80%;\">Dom</td>";
	$retorno .= "<td class=\"THeader\" align=\"center\" style=\"width:20%\">Pontua&ccedil;&atilde;o:</td>";
	$retorno .= "</tr>";
	$result = $conn->Execute("
		SELECT d.ds_dom, r.nr_resultado, r.id_dom
		FROM rs_dons r
		INNER JOIN dons d ON (r.id_dom = d.id_dom)
		WHERE r.id_pessoa = $userID
		ORDER BY r.nr_resultado DESC, d.ds_dom
	");
	$class = "";
	$ordem = 0;
	while (!$result->EOF):
		if ($class == "LstDark"):
			$class = "LstLight";
		else:
			$class = "LstDark";
		endif;
		++$ordem;

		if ( $linkDetails ):
			$retorno .= "<tr name=\"caracteristica\" id-dom=\"". $result->fields['id_dom'] ."\" class=\"selectable\">";
		else:
			$retorno .= "<tr>";
		endif;
		$retorno .= "<td align=\"center\" class=\"$class\" style=\"width:10px\">$ordem&ordm;&nbsp;</td>";
		$retorno .= "<td align=\"left\" class=\"$class\" style=\"width:80%;\">&nbsp;". $result->fields['ds_dom'] ."</td>";
		$retorno .= "<td align=\"center\" class=\"$class\" style=\"width:20%\">". $result->fields['nr_resultado'] ."&nbsp;</td>";
		$retorno .= "</tr>";
		$result->MoveNext();
	endwhile;
	$retorno .= "</table>";
	return $retorno;
}

function fDispMinisterios($conn,$userID){
	$retorno = fRsCabecalhoPessoa($conn,$userID);
	$retorno .= "<table cellspacing=\"1\" cellpadding=\"0\" align=\"center\" style=\"width:100%\">";
	$retorno .= "<tr>";
	$retorno .= "<td class=\"THeader\" align=\"center\" style=\"width:10px;\">Ordem</td>";
	$retorno .= "<td class=\"THeader\" align=\"center\" style=\"width:80%;\">Minist&eacute;rio</td>";
	$retorno .= "<td class=\"THeader\" align=\"center\" style=\"width:20%\">Nota:</td>";
	$retorno .= "</tr>";
	$result = $conn->Execute("
		SELECT d.ds_ministerio, r.nr_nota, r.id_ministerio
		FROM rp_ministerios r
		INNER JOIN ministerios d ON (r.id_ministerio = d.id_ministerio)
		WHERE r.id_pessoa = $userID
		ORDER BY r.nr_nota DESC, d.ds_ministerio
	");
	$class = "";
	$ordem = 0;
	while (!$result->EOF):
		if ($class == "LstDark"):
			$class = "LstLight";
		else:
			$class = "LstDark";
		endif;
		++$ordem;
		$retorno .= "<tr name=\"caracteristica\" id-dom=\"". $result->fields['id_ministerio'] ."\" class=\"selectable\">";
		$retorno .= "<td align=\"center\" class=\"$class\" style=\"width:10px\">$ordem&ordm;&nbsp;</td>";
		$retorno .= "<td align=\"left\" class=\"$class\" style=\"width:80%;\">&nbsp;". $result->fields['ds_ministerio'] ."</td>";
		$retorno .= "<td align=\"center\" class=\"$class\" style=\"width:20%\">". $result->fields['nr_nota'] ."&nbsp;</td>";
		$retorno .= "</tr>";
		$result->MoveNext();
	endwhile;
	$retorno .= "</table>";
	return $retorno;
}
?>