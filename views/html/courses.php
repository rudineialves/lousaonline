
<?php defined( 'LOCAL_ACCESS' ) or die( 'Acesso restrito' ); ?>

<div id="courses" class="page-content">	
	<h3>Cursos</h3>						
	<div class="row">
		<div class="col-md-12">
			<div id="courses-filter" class="card card-default content-header">	
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
							</div>
						</div>
						<?php if($_SESSION['userLevel'] === 1): ?>
						<div class="form-group col-md-4" style="text-align:right">								
							<button id="newCoursesBtn" onclick="openPopEditCourses('')" class="btn btn-primary">Cadastrar Novo</button>
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
			<table id="courses-data-table" class="table table-striped table-bordered tablesorter">
				<thead id="data-head" class="data-item">
					<tr>						
						<th class="name">Curso</th>
						<th class="date_init">Data</th>
						<th class="hour">Horário</th>
						<th class="actions">&nbsp;</th>
					</tr>
				</thead>
				<tbody>	

				</tbody>
			</table>
			<div class="data-loader alert alert-info" style="display:none">buscando dados... <img src="<?=_FULLPATH?>/images/loader.gif" alt="buscando dados..." /></div>
		</div>
	</div>
	<?php include_once(_ABSOLUTEPATH.'/views/html/courses/popInfoCourses.php');?>	
	<?php include_once(_ABSOLUTEPATH.'/views/html/courses/popEditCourses.php');?>
</div>
<script src="<?=_FULLPATH?>/views/js/courses.js"></script>
