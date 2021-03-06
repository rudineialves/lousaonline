<?php
	@ session_start();
    if(empty($_SESSION['userId'])){die('Usuário não logado!');}

	require_once('../models/Students.class.php');
	
	$key = '';

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

			$datebirth = !empty($datebirth) ? implode('-', array_reverse(explode('/', $datebirth))) : '';
		
			$obj = new Student($id);

            $obj->setName($name);
            $obj->setLastname($lastname);
            $obj->setSex($sex);
            $obj->setDatebirth($datebirth);
            $obj->setDocument($document);
            $obj->setTelephone($telephone);
            $obj->setCell($cell);
            $obj->setEmail($email);
            $obj->setLogin($login);
            if(!empty($password)){$obj->setPassword(crypt($password,''));}				
 			$obj->setStatus($status); 						

			$res = $obj->applyUpdate();

			$item = formatResult($obj);
		

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

			$totalGeral = 0;
			
            $registration_ini = !empty($registration_ini) ? implode('-', array_reverse(explode('/', $registration_ini))).' 00:00:00' : '';
            $registration_fin = !empty($registration_fin) ? implode('-', array_reverse(explode('/', $registration_fin))).' 23:59:59' : '';
           
			$obj = new StudentList();
			
            $obj->filterByKey($key);
            $obj->filterByRegistration($registration_ini, $registration_fin);
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

			$item = new Student($id);
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

				$obj = new Student($id);
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
		$userTypeNames = $obj->getTypeNames();
		$statusNames   = $obj->getStatusNames();
		
        $item['id']              = $obj->getId();
        $item['thumb']           = '';
        $item['registration']    = strtotime($obj->getRegistration()) > 0 ? date('d/m/Y', strtotime($obj->getRegistration())) : '';
        $item['lastupdate']      = strtotime($obj->getLastupdate()) > 0 ? date('d/m/Y', strtotime($obj->getLastupdate())) : '';
        $item['lastaccess']      = strtotime($obj->getLastaccess()) > 0 ? date('d/m/Y', strtotime($obj->getLastaccess())) : '';
        $item['name']            = $obj->getName();
        $item['lastname']        = $obj->getLastname();
        $item['document']        = $obj->getDocument();
        $item['sex']             = $obj->getSex();
        $item['datebirth']       = strtotime($obj->getDatebirth()) > 0 ? date('d/m/Y', strtotime($obj->getDatebirth())) : '';
        $item['telephone']       = $obj->getTelephone();
        $item['cell']            = $obj->getCell();
        $item['email']           = $obj->getEmail();
        $item['login']           = $obj->getLogin();
        $item['usertype']        = $obj->getUsertype();
        $item['usertypeName']    = $obj->getUsertype() ? @$userTypeNames[$obj->getUsertype()] : '';
        $item['status']          = $obj->getStatus();
        $item['statusName']      = $obj->getStatus() ? @$statusNames[$obj->getStatus()] : '';		
        
		return $item;
	}
