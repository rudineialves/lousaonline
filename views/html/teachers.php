
<?php defined( 'LOCAL_ACCESS' ) or die( 'Acesso restrito' ); ?>

<div id="teacher" class="page-content">	
		<h3>Professores</h3>						
		<div class="row">
			<div class="col-md-12">
				<div id="teacher-filter" class="card card-default content-header">	
					<div class="card-header">
						<div class="row">
							<div class="form-group col-md-8">
								<div class="row">									
							        <div class="form-group col-sm-6">
							            <div class="input-group">
							                <input id="key" name="key" class="js-input-filter js-select-filter form-control" type="text">
							                <span class="input-group-append">
							                    <button class="btn btn-primary btn-src-send" type="button">Buscar</button>
							                </span>
							            </div>
							        </div>
							        <div class="form-group col-sm-6">
							            <div class="row">
							                <div class="col-6">
							                    <div class="input-group">
							                        <input id="registration_ini" name="registration_ini" class="input-field select-field form-control date-picker date-mask" type="text" placeholder="De">
							                        <span class="input-group-addon">
							                            <i class="fa fa-calendar"></i>
							                        </span>
							                    </div>
							                </div>
							                <div class="col-6">
							                    <div class="input-group">
							                        <input id="registration_fin" name="registration_fin" class="input-field select-field form-control date-picker date-mask" type="text" placeholder="Até">
							                        <span class="input-group-addon">
							                            <i class="fa fa-calendar"></i>
							                        </span>
							                    </div>
							                </div>
							            </div>
							        </div>
							        <div class="form-group col-sm-6">
							            <select id="status" name="status" class="select-field form-control select2">
							                <option value="">Todos os status</option>
								            <option value="A">Ativos</option>
								            <option value="I">Inativos</option>
								            <option value="S">Suspensos</option>
								            <option value="B">Bloqueados</option>
								        </select>
							        </div>
								</div>
							</div>
							<?php if($_SESSION['userLevel'] === 1): ?>
							<div class="form-group col-md-4" style="text-align:right">								
								<button id="newTeacherBtn" onclick="openPopEditTeacher('')" class="btn btn-primary">Cadastrar Novo</button>
							</div>
							<?php endif; ?>
						</div>
					</div>
					<div class="card-footer"></div>
				</div>
			</div>
		</div>

		<div id="data-wrapper" class="scroll-pane">
			<div id="data-holder" class="table-responsive">
				<table id="teacher-data-table" class="table table-striped table-bordered tablesorter">
					<thead id="data-head" class="data-item">
						<tr>
							<th class="img-thumb">&nbsp;</th>
							<th class="name">Nome</th>
							<th class="telephone">Fone</th>
							<th class="email">Email</th>
							<th class="institution">Escola</th>	
							<th class="status">Status</th>
							<th class="actions">&nbsp;</th>
						</tr>
					</thead>
					<tbody>	

					</tbody>
				</table>
				<div class="data-loader alert alert-info" style="display:none">buscando dados... <img src="<?=_FULLPATH?>/images/loader.gif" alt="buscando dados..." /></div>
			</div>
		</div>

	<?php include_once(_ABSOLUTEPATH.'/views/html/teachers/popInfoTeacher.php');?>	
	<?php include_once(_ABSOLUTEPATH.'/views/html/teachers/popEditTeacher.php');?>
</div>
<script src="<?=_FULLPATH?>/views/js/teachers.js"></script>
