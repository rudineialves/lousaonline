
<?php defined( 'LOCAL_ACCESS' ) or die( 'Acesso restrito' ); ?>

<div id="popEditCourses" class="modal fade" data-backdrop="static">		
	<div id="mainPopEditCourses" class="modal-dialog">
		<div class="modal-content">	
			<div class="modal-header">
				<button id="closeEditCoursesBtn" type="button" class="close">×</button>
				<h3 class="modal-title">&nbsp;</h3>
			</div>
			<div class="modal-body">
				<div class="row">						
					<form id="formEditCourses">						
						<div class="form-group col-sm-8">
						    <label>Titulo</label>
						    <input id="name" name="name" class="input-field form-control" type="text">
						</div>
						<div class="form-group col-sm-4">
						    <label>Status</label>
						    <select id="status" name="status" class="select-field form-control select2">
					            <option value="A">Ativo</option>
					            <option value="I">Inativo</option>
					            <option value="S">Suspenso</option>
					            <option value="B">Bloqueado</option>
					            <option value="D">Excluído</option>
				            </select>
						</div>
						<div class="form-group col-sm-5">
						    <label>Dia</label>						    
						    <div class="input-group">
						        <input id="date_course" name="date_course" class="input-field select-field form-control date-picker date-mask" type="text" placeholder="">
						        <span class="input-group-addon">
						            <i class="fa fa-calendar"></i>
						        </span>
						    </div>
						</div>
						<div class="form-group col-sm-7">
						    <label>Horário</label>
					    	<div class="row">
							    <div class="col-6">
							    	<input id="hour_init" name="hour_init" class="input-field form-control hour-mask" type="text" placeholder="De">
							    </div>
							    <div class="col-6">
							    	<input id="hour_end" name="hour_end" class="input-field form-control hour-mask" type="text" placeholder="Até">
							    </div>
							</div>
						</div>
						<div class="form-group col-12">
							<label>Descrição</label>
							<textarea id="description" name="description" rows="7" class="form-control"></textarea>
						</div>
					</form>						
				</div>				
			</div>
			<div class="modal-footer">		
				<button id="cancelEditCoursesBtn" class="btn btn-default cancel-btn">Fechar</button> 
				<button id="saveEditCoursesBtn" class="btn btn-primary save-btn">Salvar</button> 
			</div>
		</div>
		<div class="loaderContent" style="display:none"></div>
	</div>
		
</div>

<script src="<?=_FULLPATH?>/views/js/courses/popEditCourses.js"></script>


