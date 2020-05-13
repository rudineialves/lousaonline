
<?php defined( 'LOCAL_ACCESS' ) or die( 'Acesso restrito' ); ?>

<div id="popEditInstitution" class="modal fade" data-backdrop="static">	
	
	<div id="mainPopEditInstitution" class="modal-dialog">
		<div class="modal-content">	
			<div class="modal-header">
				<button id="closeEditInstitutionBtn" type="button" class="close">×</button>
				<h3 class="modal-title">&nbsp;</h3>
			</div>
			<div class="modal-body">
				<div class="row">						
					<form id="formEditInstitution">
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
						<div class="clearfix"></div>
						<div class="form-group col-sm-6">
						    <label>Nome</label>
						    <input id="name" name="name" class="input-field form-control" type="text">
						</div>
						<div class="form-group col-sm-6">
						    <label>Sobrenome</label>
						    <input id="lastname" name="lastname" class="input-field form-control" type="text">
						</div>	
						<div class="form-group col-sm-6">
						    <label>CNPJ</label>
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
				<button id="cancelEditInstitutionBtn" class="btn btn-default cancel-btn">Fechar</button> 
				<button id="saveEditInstitutionBtn" class="btn btn-primary save-btn">Salvar</button> 
			</div>
		</div>
		<div class="loaderContent" style="display:none"></div>
	</div>
		
</div>

<script src="<?=_FULLPATH?>/views/js/institution/popEditInstitution.js"></script>


