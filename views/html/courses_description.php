<?php defined( 'LOCAL_ACCESS' ) or die( 'Acesso restrito' ); ?> 
<?php require_once(_ABSOLUTEPATH.'/models/Courses.class.php'); ?> 
<?php 
	$courseId = !empty($urlParams[1]) ? $urlParams[1] : '';
	$course = new Course($courseId);
?>

<div id="courses_description" class="page-content">
	<h3 class="mb-4"><?=$course->getName();?></h3>	
	<div class="row">
		<div class="col-12">
			<?php 
				echo '<p><b>Dia: </b>'.date('d/m/Y', strtotime($course->getDateCourse())).'</p>';
				echo '<p><b>Horário: </b>'.date('H:i', strtotime($course->getHourInit())).' / '.date('H:i', strtotime($course->getHourEnd())).'</p>';
				echo '<p>'.$course->getDescription().'</p>';
				echo '<h4 class="mb-3">Professores</h4>';
				echo '<p><a href="'._FULLPATH.'/teachers_description/3">João Alberto da Silva</a></p>';
				echo '<p><a href="'._FULLPATH.'/teachers_description/4">Adamastor Damasceno</a></p>';
			?>
		</div>
	</div>
</div>