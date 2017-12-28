<?php
@require_once("include/_variables.php"); 
?><html>
<title><?php echo $Titulo?></title>
<frameset rows="50px,*" border="0" id=frameSetPadrao>
	<frame src="<?php echo $VirtualDir;?>include/top.php?" id=frameTop name=frameTop noresize scrolling=no style="z-index:0;">
	<frame src="<?php echo $VirtualDir;?>login.php?" id=framePrinc name=framePrinc scrolling=auto style="z-index:0;">
</frameset>
</html>