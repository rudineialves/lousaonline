<?php	
	
	//define na constante _FULLPATH a url base
	$path = explode('/', $_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]);
	array_pop($path);	
	define('_FULLPATH', 'http://'.implode('/',$path));

	//define na constante _ABSOLUTEPATH o caminho absoluto base - para ser utilizado nos includes e requires
	$path = explode('/', __DIR__);
	array_pop($path);
	define('_ABSOLUTEPATH', implode('/', $path));

	//transforma a url em um array de parâmetros
	$urlParams = isset($_GET['params']) ? explode('/', $_GET['params']) : array();

	//define a constante LOCAL_ACCESS
	//todo arquivo html incluído deve verificar a existencia desta constante
	//para evitar acesso direto ao arquivo utilizando em seu início o seguinte código
	// defined( 'LOCAL_ACCESS' ) or die( 'Acesso restrito' )
	define('LOCAL_ACCESS', 1);	

?>	

<script type="text/javascript">
	// passa o valor das constantes para variáveis javascript
	var _FULLPATH     = '<?=_FULLPATH?>';
	var _ABSOLUTEPATH = '<?=_ABSOLUTEPATH?>';
</script>