<?php 


    if(!defined('INSTITUTION_ROOT')){
        define('INSTITUTION_ROOT', dirname(__FILE__).'/');
        require_once(INSTITUTION_ROOT.'DataBase.class.php');
        require_once(INSTITUTION_ROOT.'Users.class.php');
    }


    class Institution extends User {


        function __construct($pId=''){
            
            $this->setUsertype('I');
            
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

            $query = "SELECT u.*, i.cnpj FROM users AS u
                      INNER JOIN institution AS i 
                      ON i.user_id = u.id
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
                $this->setDocument($r->cnpj);
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
            }            
        }


        /**
         * INSERT
         */        

        public function insertExtend(){

            $DataBase = $this->getDataBase(); 

            $query  = "INSERT INTO `institution` ";
            $query .= "(`user_id`, `cnpj`) ";
            $query .= "VALUES (?, ?)";
            $params = array($this->getId(), $this->getDocument());
            $insert = $DataBase ->insertDB($query, $params);
                
            if($insert){ 
                return true; 
            }
            return false;
        }


        /**
         * UPDATE
         */ 
       
        public function updateExtend(){

            $DataBase = $this->getDataBase(); 

            $query  = "UPDATE `institution` SET ";
            $query .= "`cnpj` = ?";
            $query .= "WHERE `user_id` = ? LIMIT 1";
            $params = array($this->getDocument(), $this->getId());
            $update = $DataBase->updateDB($query, $params);

            if($update){ 
                return true; 
            }
            return false;
        }

        /**
         * DELETE
         */ 
       
        public function deleteExtend(){

            $DataBase = $this->getDataBase(); 
            
            $query  = "DELETE FROM institution WHERE user_id = ? LIMIT 1";
            $params = array($this->getId());
            $delete = $DataBase->deleteDB($query, $params);

            if($delete > 0){
                return true;
            }
            return false;
        }

    }




    class InstitutionList extends UsersList {

        /**
         * GET LIST
         */
        public function getList(){
            $result    = array();
            $DataBase  = $this->getDataBase();

            $query  = "SELECT id FROM users WHERE 1 ";
            $query .= $DataBase->applyFilters($this->getFilters());
            $query .= "AND usertype = 'I' AND status != 'D' ";
            $query .= $this->getOrderBy() ? "ORDER BY ".$this->getOrderBy()." " : "";
            //die($DataBase->pdoDebugger($query, $this->getParams()));
            $list = $DataBase->selectDB($query, $this->getParams());
            foreach($list as $item){
                $obj = new Institution($item->id);
                $result[] = $obj;
            }

            return $result;
        }
    }
