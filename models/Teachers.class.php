<?php 


    if(!defined('TEACHERS_ROOT')){
        define('TEACHERS_ROOT', dirname(__FILE__).'/');
        require_once(TEACHERS_ROOT.'DataBase.class.php');
        require_once(TEACHERS_ROOT.'Users.class.php');
    }


    class Teacher extends User {

        private $institutionId;

        function __construct($pId=''){
            
            $this->setUsertype('T');
            
            if(!empty($pId)){
                $this->setId($pId);
                $this->load();
            }
        }


        /**
         * LOAD
         * carrega o objeto com os dados do DB
         */ 
        public function load(){

            $DataBase = $this->getDataBase();            

            $query = "SELECT u.*, t.cpf, t.institution_id FROM users AS u
                      INNER JOIN teachers AS t 
                      ON t.user_id = u.id
                      WHERE u.id = ? LIMIT 1";
            $res   = $DataBase->selectDB($query, $this->getId());

            if(count($res)>0){
                
                $r = $res[0];
                
                $this->setId($r->id);
                $this->setRegistration($r->registration);
                $this->setLastupdate($r->lastupdate);
                $this->setLastaccess($r->lastaccess);
                $this->setName($r->name);
                $this->setLastname($r->lastname);
                $this->setDocument($r->cpf);
                $this->setSex($r->sex);
                $this->setDatebirth($r->datebirth);
                $this->setTelephone($r->telephone);
                $this->setCell($r->cell);
                $this->setEmail($r->email);
                $this->setThumb($r->thumb);
                $this->setLogin($r->login);
                $this->setPassword($r->password);
                $this->setUsertype($r->usertype);
                $this->setStatus($r->status);
                $this->setInstitutionId($r->institution_id);
            }            
        }


        public function insertExtend(){

            $DataBase = $this->getDataBase(); 

            $query  = "INSERT INTO `teachers` ";
            $query .= "(`user_id`, `cpf`, `institution_id`) ";
            $query .= "VALUES (?, ?, ?)";
            $params = array($this->getId(), $this->getDocument(), $this->getInstitutionId());
            $insert = $DataBase ->insertDB($query, $params);
                
            if($insert){ 
                return true; 
            }
            return false;
        }        

        public function updateExtend(){

            $DataBase = $this->getDataBase(); 

            $query  = "UPDATE `teachers` SET ";
            $query .= "`cpf` = ?, `institution_id` = ?";
            $query .= "WHERE `user_id` = ? LIMIT 1";
            $params = array($this->getDocument(), $this->getInstitutionId(), $this->getId());
            $update = $DataBase->updateDB($query, $params);

            if($update){ 
                return true; 
            }
            return false;
        }

        
        public function deleteExtend(){

            $DataBase = $this->getDataBase(); 
            
            $query  = "DELETE FROM teachers WHERE user_id = ? LIMIT 1";
            $params = array($this->getId());
            $delete = $DataBase->deleteDB($query, $params);

            if($delete > 0){
                return true;
            }
            return false;
        }


        public function setInstitutionId($institutionId){$this->institutionId = $institutionId;} 
        public function getInstitutionId(){return $this->institutionId;}

    }




    class TeacherList extends UsersList {

        /**
         * GET LIST
         */
        public function getList(){
            $result    = array();
            $DataBase  = $this->getDataBase();

            $query  = "SELECT id FROM users WHERE 1 ";
            $query .= $DataBase->applyFilters($this->getFilters());
            $query .= "AND usertype = 'T' AND status != 'D' ";
            $query .= $this->getOrderBy() ? "ORDER BY ".$this->getOrderBy()." " : "";
            $list = $DataBase->selectDB($query, $this->getParams());
            foreach($list as $item){
                $obj = new Teacher($item->id);
                $result[] = $obj;
            }

            return $result;
        }
    }
