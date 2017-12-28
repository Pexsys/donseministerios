<?php
unset($_SESSION);session_start();
@require_once("include/_variables.php");
@include("include/functions.php");
@include("include/rules.php");
fConnDB();

$txtLoginUser = strtolower(fRequest("txtLoginUser"));
$txtLoginPass = fRequest("txtLoginPass");

$_SESSION['USER'] = array();
$arr = array();
$arr['page'] = "Código de usuário ou senha inválida!";
$arr['login'] = false;

//Verificacao de Usuario/Senha
if ( isset($txtLoginUser) && !empty($txtLoginUser) ):
	$result = $conn->Execute("SELECT * FROM pessoa WHERE cd_email = '$txtLoginUser'");
	if (!$result->EOF):
		$userID = $result->fields['id_pessoa'];
		/*
		$password = $result->fields['ds_senha'];
		
		if ( !isset($password) || empty($password) ):
			$password = sha1(fNormalizeStr(strtok($result->fields['nm_pessoa'], " ")));
			$arr['received'] = $txtLoginPass;
			$arr['separated'] = strtok($result->fields['nm_pessoa'], " ");
			$arr['normalize'] = fNormalizeStr($arr['normalize']);
			$arr['calculated'] = sha1($arr['normalize']);
			$conn->Execute("UPDATE pessoa SET ds_senha = '$password' WHERE id_pessoa = $userID");
			$conn->Execute("COMMIT");
		endif;
			
		if ($password == $txtLoginPass):
		*/
			$_SESSION['USER']['id'] = session_id();
			$_SESSION['USER']['id_pessoa'] = $userID;
			
			//VERIFICAR SE EXISTE PERFIL ESPECIFICO PARA A PESSOA
			if ( sizeof(fGetPerfil($conn,$userID)) > 0 ):
				$arr['page'] = $VirtualDir."menuprincipal.php?userID=$userID";
			//elseif ( sizeof(fGetPendencia($conn,$userID)) > 0 ):
			//	$arr['page'] = $VirtualDir."complete.php?userID=$userID";
			elseif ( !fExistResultado($conn,$userID) ):
				$arr['page'] = $VirtualDir."testededons.php?userID=$userID";
			elseif ( !fExistMinisterios($conn,$userID) ):
				$arr['page'] = $VirtualDir."testedeministerios.php?userID=$userID";
			else:
				$arr['page'] = $VirtualDir."rsdons.php?userID=$userID";
			endif;
			$arr['login'] = true;
		//endif;
	endif;
endif;
echo json_encode($arr);
?>