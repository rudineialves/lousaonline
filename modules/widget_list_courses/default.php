<?php defined( 'LOCAL_ACCESS' ) or die( 'Acesso restrito' ); ?> 
<?php require_once(_ABSOLUTEPATH.'/models/Courses.class.php'); ?> 

<div id="widget-list-courses" class="card">
	<div class="card-header text-white bg-primary">
		<h4>Cursos</h4>
	</div>
	<div class="card-body" style="height:250px;overflow:auto">
		<div class="list-group">
		<?php
			$courses = new CoursesList();
			$coursesList = $courses->getList();
			foreach($coursesList as $course){
				echo '<a href="'._FULLPATH.'/courses_description/'.$course->getId().'" class="list-group-item list-group-item-action">'.$course->getName().'</a>';
			}
		?>
		</div>	
	</div>
	<div class="card-header"></div>
</div>