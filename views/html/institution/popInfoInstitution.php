
<?php defined( 'LOCAL_ACCESS' ) or die( 'Acesso restrito' ); ?>

<div id="popInfoInstitution" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">	
			<div class="modal-header">
				<button id="closeInfoInstitutionBtn" type="button" class="close">×</button>
				<h3 class="modal-title">&nbsp;</h3>
			</div>
			<div class="modal-body">
				<div class="row">
					<div id="popHolder" class="col-md-12">

					</div>
				</div>				
			</div>
			<div class="modal-footer">					
				<button id="cancelInfoInstitutionBtn" class="btn btn-default">Fechar</button> 
			</div>
		</div>
		<div class="loaderContent" style="display:none"></div>
	</div>
</div>


<script src="<?=_FULLPATH?>/views/js/institution/popInfoInstitution.js"></script>


