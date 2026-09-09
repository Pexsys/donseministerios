<?php require_once("_variables.php");
require_once("_metaheader.php");
setlocale(LC_ALL,"pt_BR");
$logged = (session_id() != "" && $_SESSION['USER']['id'] != "" && session_id() == $_SESSION['USER']['id']);
if ($logged):
	$logged = ($_SESSION['USER']['COD_OPERADOR'] != "");
	if ($logged):
		require_once("include/functions.php");
		fConnDB();
		$result2 = $conn->Execute("SELECT * FROM SESSION_ACTIVE WHERE COD_SESSAO = '". $_SESSION['USER']['id'] ."'");
		$logged = (!$result2->EOF);
	endif;
	if (!$logged):
		?>
		<script language=javascript>
			alert('Voce esta sendo desconectado!\n\nPossiveis Motivos:\n1) Sua conexao com o servidor expirou\n2) Voce se conectou em outra maquina');
			window.location.replace('<?php echo $VirtualDir?>logout.php?>');
		</script>
		<?php
		exit;
	endif;
endif;
$menu = $logged;

?><html>
<head>
<title><?php echo $TituloPagina?></title>

<link rel=stylesheet type="text/css" href="<?php echo $VirtualDir?>css/default.css">
<script language=javascript>
	var jsVirtualDir = '<?php echo $VirtualDir?>';
</script>
<script type="text/javascript" language=javascript src="<?php echo $VirtualDir?>js/functions.js?1"></script>
<?php if ($logged):?>
<link rel=stylesheet type="text/css" href="<?php echo $VirtualDir?>css/menu.css">
<script language=javascript><?php echo $_SESSION['USER']['user_menu'];?></script>
<script type="text/javascript" language=javascript src="<?php echo $VirtualDir?>js/menu.js"></script>
<?php endif;?>
</head>
<body>
<?php if ($menu):?>
<table cellpadding=0 cellspacing=0 border=0 width=100%>
	<tr>
		<td valign=top nowrap class=menubar width=70%>&nbsp;</td>
		<?php if (!empty($botaoLista) && $botaoLista):?>
		<td valign=top nowrap class=menubar id=btnList>
			<table cellpadding=0 cellspacing=0 border=0 class=menuitems>
				<tr>
					<td align=center style="width:60px;height:13px;" onmouseover="javascript:this.style.color='HighlightText';this.style.backgroundColor='Highlight';" onmouseout="javascript:this.style.color='MenuText';this.style.backgroundColor='Menu';" onclick="<?php echo $botaoLista;?>"><img src="<?php echo $VirtualDir?>images/detail.gif" width=14 height=14 border=0>&nbsp;Listar</td>
				</tr>
			</table>
		</td>
		<?php endif;?>
		<?php if (!empty($botaoNovo)):?>
		<td valign=top nowrap class=menubar id=btnNovo>
			<table cellpadding=3 cellspacing=0 border=0 class=menuitems>
				<tr>
					<td align=center style="width:60px;height:13px;" onmouseover="javascript:this.style.color='HighlightText';this.style.backgroundColor='Highlight';" onmouseout="javascript:this.style.color='MenuText';this.style.backgroundColor='Menu';" onclick="<?php echo $botaoNovo;?>"><img src="<?php echo $VirtualDir?>images/addedit.png" width=14 height=14 border=0>&nbsp;Novo</td>
				</tr>
			</table>
		</td>
		<?php endif;?>
		<?php if (!empty($botaoSalvar)):?>
		<td valign=top nowrap class=menubar id=btnSalvar>
			<table cellpadding=0 cellspacing=0 border=0 class=menuitems>
				<tr>
					<td align=center style="width:60px;height:13px;" onmouseover="javascript:this.style.color='HighlightText';this.style.backgroundColor='Highlight';" onmouseout="javascript:this.style.color='MenuText';this.style.backgroundColor='Menu';" onclick="<?php echo $botaoSalvar;?>"><img src="<?php echo $VirtualDir?>images/salvar.png" width=14 height=14 border=0>&nbsp;Salvar</td>
				</tr>
			</table>
		</td>
		<?php endif;?>
		<?php if (!empty($botaoExcluir) && $botaoExcluir):?>
		<td valign=top nowrap class=menubar id=btnExcluir>
			<table cellpadding=0 cellspacing=0 border=0 class=menuitems>
				<tr>
					<td align=center style="width:60px;height:13px;" onmouseover="javascript:this.style.color='HighlightText';this.style.backgroundColor='Highlight';" onmouseout="javascript:this.style.color='MenuText';this.style.backgroundColor='Menu';" onclick="<?php echo $botaoExcluir;?>"><img src="<?php echo $VirtualDir?>images/cancel.png" width=14 height=14 border=0>&nbsp;Excluir</td>
				</tr>
			</table>
		</td>
		<?php endif;?>
		<td valign=top nowrap class=menubar align=right>
			<table cellpadding=0 cellspacing=0 border=0 class=menuitems>
				<tr>
					<td align=center style="width:60px;height:13px;" onmouseover="javascript:this.style.color='HighlightText';this.style.backgroundColor='Highlight';" onmouseout="javascript:this.style.color='MenuText';this.style.backgroundColor='Menu';" onClick="javascript:jumpto(this);" url="<?php echo $VirtualDir?>logout.php"><img src="<?php echo $VirtualDir?>images/login.gif" width=14 height=14 border=0 alt="Sair">&nbsp;Sair</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php endif;?>
<br>