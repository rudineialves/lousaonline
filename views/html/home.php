<?php defined( 'LOCAL_ACCESS' ) or die( 'Acesso restrito' ); ?> 
<div id="home" class="page-content">
	<h3>Home</h3>	
	<div class="row">
		<div class="col-md-6 mb-4">
			<?php Main::insertModule('widget_list_courses'); ?>
		</div>
		<div class="col-md-6 mb-4">
			<?php Main::insertModule('widget_list_my_courses'); ?>
		</div>
		<div class="col-md-6 mb-4">
			<?php Main::insertModule('widget_list_teachers'); ?>
		</div>
		<div class="col-md-6 mb-4">
			<?php Main::insertModule('widget_list_institutions'); ?>
		</div>
	</div>
</div>
