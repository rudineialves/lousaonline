<?php
	@ session_start();
    if(empty($_SESSION['userId'])){die('Usuário não logado!');}

	require_once('../models/Courses.class.php');
	
	$key             = '';
	$date_course_ini = '';
	$date_course_fin = '';
	$teacher_user_id = '';
	$student_user_id = '';
	$status          = '';

	foreach($_POST as $postField => $postValue){
		if(!is_array($postValue)){
			$$postField = trim(strip_tags(addslashes($postValue)));
		}
		else {
			$$postField = $postValue;
		}
	}

	switch($act){		
		
		/** 
		 * ****************************************************************************
		 * SALVAR
		 * ****************************************************************************
		 */	
		case 'Salvar':					

			$res  = false;
			$item = array();

			if($_SESSION['userLevel'] > 1){$res = 'Você não possui permissão para esta ação.';}					
			else {	
				
                $date_course = !empty($date_course) ? implode('-', array_reverse(explode('/', $date_course))) : '';
				
				$obj = new Course($id);				
				
                $obj->setName($name);
                $obj->setDateCourse($date_course);
                $obj->setHourInit($hour_init);
                $obj->setHourEnd($hour_end);
                $obj->setDescription($description);	
                $obj->setStatus($status);				

				$res = $obj->applyUpdate();

				$item = formatResult($obj);
			}

			$result['result'] = $res;	
			$result['item']   = $item;
			
			echo json_encode($result);
	
		break;
		
		
		/** 
		 * ****************************************************************************
		 * LISTAR
		 * ****************************************************************************
		 */			
		case 'Listar':	
			
			$result = array();
			$list   = array();

			$obj = new CoursesList();
			
            $obj->filterByKey($key);
            $obj->filterByDateCourse($date_course_ini, $date_course_fin);
            $obj->filterByTeacherUserId($teacher_user_id);
            $obj->filterByStudentUserId($student_user_id);
            $obj->filterByStatus($status);

			$getList = $obj->getList();

			foreach($getList as $item){
				$list[] = formatResult($item);
			}

			$result['list'] = $list;

			echo json_encode($result);
			
		break;	



		/** 
		 * ****************************************************************************
		 * SELECIONAR
		 * ****************************************************************************
		 */		
		case 'Selecionar':		

			$item = new Course($id);
			echo json_encode(formatResult($item));	

		break;			
		

				
		
		
		
		/** 
		 * ****************************************************************************
		 * EXCLUIR
		 * ****************************************************************************
		 */		
		case 'Excluir':	

			$res  = false;
			
			if($_SESSION['userLevel'] > 1){$res = 'Você não possui permissão para esta ação.';}					
			else {	

				$obj = new Course($id);
				$obj->setStatus('D');
				$res = $obj->applyUpdate();					
			}

			echo $res;

		break;
		

	}


	/** 
	 * ****************************************************************************
	 * FORMAT RESULT
	 * formata o resultado transformando o objeto em array
	 * ****************************************************************************
	 */
	function formatResult($obj){

		$item = array();
		
        $item['id']          = $obj->getId();
        $item['name']        = $obj->getName();
        $item['dateCreated'] = $obj->getDateCreated();
        $item['dateCourse']  = strtotime($obj->getDateCourse()) > 0 ? date('d/m/Y', strtotime($obj->getDateCourse())) : '';
        $item['hourInit']    = date('H:i', strtotime($obj->getHourInit()));
        $item['hourEnd']     = date('H:i', strtotime($obj->getHourEnd()));
        $item['description'] = $obj->getDescription();		
		$item['status']      = $obj->getStatus();		

		return $item;
	}
