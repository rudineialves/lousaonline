<?php	

	$path = explode('/', $_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]);
	array_pop($path);	
	define('_FULLPATH', 'http://'.implode('/',$path));

	$path = explode('/', __DIR__);
	array_pop($path);
	define('_ABSOLUTEPATH', implode('/', $path));

	$urlParams = isset($_GET['params']) ? explode('/', $_GET['params']) : array();

	define('LOCAL_ACCESS', 1);	

?>	

<script type="text/javascript">
	var _FULLPATH     = '<?=_FULLPATH?>';
	var _ABSOLUTEPATH = '<?=_ABSOLUTEPATH?>';
</script>