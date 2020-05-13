<?php defined( 'LOCAL_ACCESS' ) or die( 'Acesso restrito' ); ?> 
<?php require_once(_ABSOLUTEPATH.'/models/Institution.class.php'); ?> 

<div id="widget-list-institution" class="card">
	<div class="card-header text-white bg-primary">
		<h4>Escolas</h4>
	</div>
	<div class="card-body" style="height:250px;overflow:auto">
		<div class="list-group">
		<?php
			$institution = new InstitutionList();
			$institutionList = $institution->getList();
			foreach($institutionList as $teacher){
				echo '<a href="'._FULLPATH.'/institution_description/'.$teacher->getId().'" class="list-group-item list-group-item-action">'.$teacher->getFullname().'</a>';
			}
		?>
		</div>	
	</div>
	<div class="card-header"></div>
</div>