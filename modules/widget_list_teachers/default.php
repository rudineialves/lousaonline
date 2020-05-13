<?php defined( 'LOCAL_ACCESS' ) or die( 'Acesso restrito' ); ?> 
<?php require_once(_ABSOLUTEPATH.'/models/Teachers.class.php'); ?> 

<div id="widget-list-teachers" class="card">
	<div class="card-header text-white bg-primary">
		<h4>Professores</h4>
	</div>
	<div class="card-body" style="height:250px;overflow:auto">
		<div class="list-group">
		<?php
			$teachers = new TeacherList();
			$teachersList = $teachers->getList();
			foreach($teachersList as $teacher){
				echo '<a href="'._FULLPATH.'/teachers_description/'.$teacher->getId().'" class="list-group-item list-group-item-action">'.$teacher->getFullname().'</a>';
			}
		?>
		</div>	
	</div>
	<div class="card-header"></div>
</div>