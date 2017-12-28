<?php 
require_once("include/_variables.php");
require_once("include/functions.php");
fConnDB();
//Libera Sessao
session_unset();
session_destroy();
?>
<script language=javascript>
	window.parent.frameTop.document.location.replace('<?php echo $VirtualDir?>include/top.php?');
	window.parent.framePrinc.document.location.replace('<?php echo $VirtualDir?>login.php?');
</script>