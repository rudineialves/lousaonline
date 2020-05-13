<?php defined('LOCAL_ACCESS') or die( 'Acesso restrito' ); ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?=_FULLPATH?>/">Lousa Online</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
		<?php
			$menuList = [
				'Home' => 'home',
				'Escolas' => 'institution',
				'Professores' => 'teachers',
				'Alunos' => 'students',
				'Cursos' => 'courses',				
				'Sala de Aula' => 'classroom',
			];

			foreach($menuList as $title => $route){
			    echo '<li class="nav-item active">';
			    echo 	'<a class="nav-link" href="'._FULLPATH.'/'.$route.'">'.$title.'</a>';
			    echo '</li>';
		  	}      
      	?>
    </ul>
  </div>
</nav>