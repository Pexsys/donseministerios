<?php
unset($_SESSION);session_start();
@require_once("include/_variables.php");
@include("include/functions.php");
@include("include/rules.php");
fConnDB();

$load = fRequest("load");

$arr = array();
$arr['load'] = false;
$arr['html'] = "";

//DONS
if ( $load == "dons" ):
	$str = "";
	$result = $conn->Execute("
		SELECT id_dom, ds_dom
		FROM dons
		ORDER BY ds_dom
	");
	if (!$result->EOF && $result->RecordCount() > 1):
		$str .= "<option value=\"\"></option>";
	endif;
	while (!$result->EOF):
		$str .= "<option value=\"".$result->fields['id_dom']."\">".$result->fields['ds_dom']."</option>";
		$result->MoveNext();
	endwhile;
	$arr['html'] = $str;
	$arr['load'] = true;

//MINISTERIOS
elseif ( $load == "ministerios" ):
	$str = "";
	$result = $conn->Execute("
		SELECT id_ministerio, ds_ministerio
		FROM ministerios
		ORDER BY ds_ministerio
	");
	if (!$result->EOF && $result->RecordCount() > 1):
		$str .= "<option value=\"\"></option>";
	endif;
	while (!$result->EOF):
		$str .= "<option value=\"".$result->fields['id_ministerio']."\">".$result->fields['ds_ministerio']."</option>";
		$result->MoveNext();
	endwhile;
	$arr['html'] = $str;
	$arr['load'] = true;

//PESQUISAS DE DONS E MINISTERIOS
elseif ( $load == "listaresultados" ):
	$str = "";
	$where = "";

	$search = fRequest("search");
	if ( $search == "dons" ):
		$select = "SELECT DISTINCT p.id_pessoa, p.nm_pessoa ";
		$from = " FROM pessoa p INNER JOIN rs_dons r ON (r.id_pessoa = p.id_pessoa) ";
		$order = " ORDER BY 2";
		
		$idRef = "id_dom";
		$nrComp = "nr_resultado";
		
	elseif ( $search == "ministerios" ):
		$select = "SELECT DISTINCT p.id_pessoa, p.nm_pessoa ";
		$from = " FROM pessoa p INNER JOIN rp_ministerios r ON (r.id_pessoa = p.id_pessoa) ";
		$order = " ORDER BY 2";
	
		$idRef = "id_ministerio";
		$nrComp = "nr_nota";
	endif;
	
	//SE NOME PREENCHIDO
	$nome = fRequest("nome");
	if ( isset($nome) && $nome != "" ):
		$nome = str_replace(" ","%",strtoupper($nome));
		$where .= " AND p.nm_pessoa LIKE '%$nome%' ";
	endif;
	
	//SE IDENTIFICADOR PREENCHIDO
	$id = fRequest("id");
	$resultado = false;
	if ( isset($id) && $id != "" ):
		$resultado = true;
		$select = "SELECT DISTINCT p.id_pessoa, p.nm_pessoa, r.$nrComp ";
		$where .= " AND $idRef = $id ";
		$order = " ORDER BY 3 desc, 2";
	endif;
	
	//SE OPCAO PREENCHIDA
	$opcao = fRequest("opcao");
	if ( isset($opcao) && $opcao != "" ):
		$menor = fRequest("menor");
		if ( $opcao == "entre" ):
			$maior = fRequest("maior");
			$where .= " AND $nrComp BETWEEN $menor AND $maior ";
		elseif ( $opcao == "igual" ):
			$where .= " AND $nrComp = $menor ";
		elseif ( $opcao == "menor" ):
			$where .= " AND $nrComp < $menor ";
		elseif ( $opcao == "maior" ):
			$where .= " AND $nrComp > $menor ";
		endif;
	endif;
	
	if ( $where != "" ):
		$where = " WHERE ". substr($where,4);
	endif;

	$query = $select.$from.$where.$order;
	//echo $query;
	
	$result = $conn->Execute($query);
	if (!$result->EOF):
		$class = "";
		
		$str .= "<table cellpadding=\"1\" cellspacing=\"1\" border=\"0\" style=\"width:700px;\">";
		$str .= "<tr>";
		$str .= "<td align=\"center\" style=\"background-color:#000000;color:#ffffff;width:100%\">Encontradas <font style=\"color:ffff00;size:15px;font-weight:bold;\">".$result->RecordCount()."</font> pessoas para esta pesquisa.</td>";
		$str .= "</tr>";
		$str .= "</table>";
		$str .= "<table cellpadding=\"1\" cellspacing=\"1\" border=\"0\" style=\"width:700px;\">";
		while (!$result->EOF):
			if ($class == "LstDark"):
				$class = "LstLight";
			else:
				$class = "LstDark";
			endif;			
			$str .= "<tr>";
			$str .= "<td class=\"$class\" align=\"right\" style=\"cursor:pointer;\" name=\"detail\" pessoa=\"".$result->fields['id_pessoa']."\">";
			$str .= "<img src=\"".$VirtualDir."images/detail.gif\" border=\"0\" height=\"20\" width=\"20\">";
			$str .= "</td>";
			$str .= "<td class=\"$class\" align=\"left\" style=\"font-size:10pt;width:95%\">&nbsp;".$result->fields['nm_pessoa']."</td>";
			if ($resultado):
				$str .= "<td class=\"$class\" align=\"left\" style=\"font-size:10pt;width:5%\">&nbsp;".$result->fields[$nrComp]."</td>";
			endif;
			$str .= "</tr>";
			$result->MoveNext();
		endwhile;
		$str .= "</table>";
		$arr['html'] = $str;
		$arr['load'] = true;
 	endif;
	
elseif ( $load == "detail" ):
	$userID = fRequest("userID");
	$search = fRequest("search");
	if ( $search == "dons" ):
		$arr['title'] = "Resultado do Teste de Dons";
		$arr['html'] = fRsDons($conn,$userID);
	elseif ( $search == "ministerios" ):
		$arr['title'] = "Resultado da Disponibilidade de Minist&eacute;rios";
		$arr['html'] = fDispMinisterios($conn,$userID);
	endif;
	$arr['load'] = true;

endif;
echo json_encode($arr);
?>