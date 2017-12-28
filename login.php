<?php @require_once("include/header_simples.php");?>
<script type="text/javascript" language=javascript src="<?php echo $VirtualDir?>js/jquery-sha-1.js"></script>
<script type="text/javascript" language=javascript src="<?php echo $VirtualDir?>js/login.js?"></script>
<table width="100%" height="70%" cellspacing="0" cellpadding="0" align="center" valign="middle" border="0">
	<tr>
		<td>
			<form id="frmLogin" method="post">
				<table cellspacing="0" cellpadding="0" align="center" class="tblFrame" style="width:320px;height:160px;">
					<tr>
						<td align="center" width="100%" class="tdCaption" id="tdLogin">Login</td>
					</tr>
					<tr>
						<td align="center" valign="middle">
							<table cellspacing="0" cellpadding="5" border="0">
								<tr>
									<td align="right" width="35%"><label for="txtLoginUser" class="input">Email:</label></td>
									<td align="left" width="65%"><input type="text" id="txtLoginUser" size="35" maxlength="200" tabindex="1"/></td>
								</tr>
								<tr style="display:none;">
									<td align="right" width="35%"><label for="txtLoginPass" class="input">Senha:</label></td>
									<td align="left" width="65%"><input type="password" id="txtLoginPass" size="16" maxlength="15" tabindex="2"/></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td align="center" valign="middle" width="100%" colspan="2" style="height:40px;">
							<a href="#" id="submitButton" tabindex="3">
								<table cellpadding="3" cellspacing="0" border="0">
									<tr>
										<td class="tdBotao" style="width:70px;"><img src="<?php echo $VirtualDir?>images/login.gif" border="0" height="20" width="20">&nbsp;Entrar</td>
									</tr>
								</table>
							</a>
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>
<?php include("include/bottom.php");?>