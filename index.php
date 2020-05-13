<?php
	
	//atribui user session default enquanto não houver login
	//remover após os testes
	@ session_start();
	$_SESSION['userLevel'] = 1;	
	$_SESSION['userId']    = 1;	

?>
<?php require_once(__DIR__.'/inc/router.php'); ?>
<?php require_once(__DIR__.'/models/Main.class.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Lousa Online</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	
	<script src="<?=_FULLPATH?>/libs/jquery/js/jquery.min.js"></script>
	<script src="<?=_FULLPATH?>/libs/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?=_FULLPATH?>/libs/select2/select2.min.js"></script>
	<script src="<?=_FULLPATH?>/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
	<script src="<?=_FULLPATH?>/libs/toastr/toastr.min.js"></script>
	<script src="<?=_FULLPATH?>/libs/jquery-confirm/dist/jquery-confirm.min.js"></script>
	<script src="<?=_FULLPATH?>/libs/jquery.form/jquery.form.js"></script>

	<script src="<?=_FULLPATH?>/js/plugins.config.js"></script>
	<script src="<?=_FULLPATH?>/js/plugins.config.js"></script>
	<script src="<?=_FULLPATH?>/js/init.js"></script>

	<link href="<?=_FULLPATH?>/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet"/> 
	<link href="<?=_FULLPATH?>/libs/select2/css/select2.css" rel="stylesheet">
	<link href="<?=_FULLPATH?>/libs/fontawesome/css/all.min.css" rel="stylesheet"/>
	<link href="<?=_FULLPATH?>/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet"/>
	<link href="<?=_FULLPATH?>/libs/toastr/toastr.min.css" rel="stylesheet"/>
	<link href="<?=_FULLPATH?>/libs/jquery-confirm/dist/jquery-confirm.min.css" rel="stylesheet">

	<link href="<?=_FULLPATH?>/css/application.css" rel="stylesheet">
</head>
<body>

	<?php require_once('inc/navbar.php'); ?>

	<main role="main" class="container mt-4">
		<?php 
			$page = !empty($urlParams[0]) ? $urlParams[0] : 'home'; //define a pagina inicial se não houver parametro
			if(is_file('views/html/'.$page.'.php')){			
				require_once('views/html/'.$page.'.php');
			}
			else {
				http_response_code(404);
				require_once('views/html/notfound.php');
			}
		?>
	</main>
</body>
</html>