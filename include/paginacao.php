<?php
	$quant_pg = ceil($quantreg/$numreg);
	$quant_pg++;
	$classe = "Green";

	// Verifica se esta na primeira pagina, se nao estiver ele libera o link para anterior
	if ( $pg > 0 ): 
		echo "<span name=\"hrefPage\" to=\"".$PHP_SELF."&pg=".($pg-1)."\" class=\"pg\">&laquo; anterior</span>";
	else:
		echo "<span class=\"pgdis\">&laquo; anterior</span>";
	endif;
	
	// Faz aparecer os numeros das pagina entre o ANTERIOR e PROXIMO
	for ($i_pg=1;$i_pg<$quant_pg;$i_pg++):
		
		if ( $f != "1" ):
			if (!array_key_exists($i_pg-1, $arrayPages)):
				$classe = "Green";
			else:
				$classe = "Red";
			endif;
		endif;
			
		// Verifica se a pagina que o navegante esta e retira o link do numero para identificar visualmente
		if ($pg == ($i_pg-1)):
			echo "<span class=\"pgoff$classe\" title=\"P&aacute;gina $i_pg\">[$i_pg]</span>"; //original
		else:
			$i_pg2 = $i_pg-1;
			echo "<span name=\"hrefPage\" to=\"".$PHP_SELF."&pg=$i_pg2\" class=\"pg$classe\" title=\"P&aacute;gina $i_pg\">$i_pg</span>";
		endif;
		
	endfor;
	
	// Verifica se esta na ultima pagina, se nao estiver ele libera o link para proxima
	if (($pg+2) < $quant_pg ):
		echo "<span name=\"hrefPage\" to=\"".$PHP_SELF."&pg=".($pg+1)."\" class=\"pg\">pr&oacute;xima &raquo;</span>"; //original
	else:
		echo "<span class=\"pgdis\">pr&oacute;xima &raquo;</span>";
	endif;
	
	if ( $f != "1" ):
		if (sizeof($arrayPages) < 2):
			echo "&nbsp;&nbsp;&nbsp;&nbsp;<span id=\"result\" class=\"pg\">RESULTADO</span>";
		endif;
	endif;
?>