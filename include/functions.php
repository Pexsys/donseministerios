<?php 
error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED); //
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input('UTF-8');

global $conn, $DBType, $DBServerHost, $DBUser, $DBPassWord, $DBDataBase, $DBRegras, $VirtualDir;
@include("adodb5/adodb.inc.php");
@include_once("dbconnect/_base.php");

function fRequest($pVar){
	if (isset($_GET[$pVar])) return $_GET[$pVar];
	if (isset($_POST[$pVar])) return $_POST[$pVar];
	return "";
}

function fConnDB(){
	try{
		$GLOBALS['conn'] = ADONewConnection($GLOBALS['DBType']);
		$GLOBALS['conn']->SetCharSet('utf8');
		$GLOBALS['conn']->Connect($GLOBALS['DBServerHost'],$GLOBALS['DBUser'],$GLOBALS['DBPassWord'],$GLOBALS['DBDataBase']);
		$GLOBALS['conn']->SetFetchMode(ADODB_FETCH_ASSOC);
		return true;
	}catch (Exception $e){
		return false;
	}
}

function fNormalizeStr($str,$charset){
	if ($charset == "ISO-8859-1"):
		$some_special_chars = array( "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�" );
	else:
		$some_special_chars = array( "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�" );
	endif;
  $replacement_chars  = array( "a", "a", "a", "e", "e", "i", "i", "o", "o", "o", "u", "c", "A", "A", "A", "E", "E", "I", "I", "O", "O", "O", "U", "C" );
	return str_replace( $some_special_chars, $replacement_chars, $str );
}
?>