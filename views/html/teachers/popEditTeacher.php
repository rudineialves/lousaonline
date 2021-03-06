
<?php defined( 'LOCAL_ACCESS' ) or die( 'Acesso restrito' ); ?>
<?php include_once(_ABSOLUTEPATH.'/models/Institution.class.php'); ?>

<div id="popEditTeacher" class="modal fade" data-backdrop="static">	
	
	<div id="mainPopEditTeacher" class="modal-dialog">
		<div class="modal-content">	
			<div class="modal-header">
				<button id="closeEditTeacherBtn" type="button" class="close">×</button>
				<h3 class="modal-title">&nbsp;</h3>
			</div>
			<div class="modal-body">
				<div class="row">						
					<form id="formEditTeacher">
						<div class="form-group col-sm-6">
						    <label>Status</label>
						    <select id="status" name="status" class="select-field form-control select2">
					            <option value="A">Ativo</option>
					            <option value="I">Inativo</option>
					            <option value="S">Suspenso</option>
					            <option value="B">Bloqueado</option>
					            <option value="D">Excluído</option>
				            </select>
						</div>
						<div class="form-group col-sm-6">
						    <label>Escola</label>
						    <select id="institution_id" name="institution_id" class="select-field form-control select2">
					        <?php
					        	$institutionList = new InstitutionList();
					        	$institutionGetList = $institutionList->getList();
					        	foreach($institutionGetList as $institution){
					            	echo '<option value="'.$institution->getId().'">'.$institution->getFullname().'</option>';
					        	}
					        ?>
				            </select>
						</div>	
						<div class="form-group col-sm-6">
						    <label>Nome</label>
						    <input id="name" name="name" class="input-field form-control" type="text">
						</div>
						<div class="form-group col-sm-6">
						    <label>Sobrenome</label>
						    <input id="lastname" name="lastname" class="input-field form-control" type="text">
						</div>
						<div class="form-group col-sm-6">
						    <label>Data de nascimento</label>
						    <div class="input-group">
						        <input id="datebirth" name="datebirth" class="input-field select-field form-control date-mask" type="text" placeholder="">
						        <span class="input-group-addon">
						            <i class="fa fa-calendar"></i>
						        </span>
						    </div>
						</div>					
						<div class="form-group col-sm-4">
						    <label>Sexo</label>
						    <select id="sex" name="sex" class="select-field form-control select2">
				                <option value="M">Masculino</option>
				                <option value="F">Feminino</option>
				            </select>
						</div>
						<div class="form-group col-sm-6">
						    <label>CPF</label>
						    <input id="document" name="document" class="input-field form-control" type="text">
						</div>
						<div class="form-group col-sm-6">
						    <label>Email</label>
						    <input id="email" name="email" class="input-field form-control" type="text">
						</div>
						<div class="form-group col-sm-6">
						    <label>Fone</label>
						    <input id="telephone" name="telephone" class="input-field form-control" type="text">
						</div>
						<div class="form-group col-sm-6">
						    <label>Celular</label>
						    <input id="cell" name="cell" class="input-field form-control" type="text">
						</div>						
						<div class="form-group col-sm-6">
						    <label>Nome de usuário</label>
						    <input id="login" name="login" class="input-field form-control" type="text">
						</div>
						<div class="form-group col-sm-6">
						    <label>Senha</label>
						    <input id="password" name="password" class="input-field form-control" type="password">
						</div>						
					</form>						
				</div>				
			</div>
			<div class="modal-footer">		
				<button id="cancelEditTeacherBtn" class="btn btn-default cancel-btn">Fechar</button> 
				<button id="saveEditTeacherBtn" class="btn btn-primary save-btn">Salvar</button> 
			</div>
		</div>
		<div class="loaderContent" style="display:none"></div>
	</div>
		
</div>

<script src="<?=_FULLPATH?>/views/js/teachers/popEditTeacher.js"></script>


