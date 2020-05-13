<?php 


    if(!defined('USERS_ROOT')){
        define('USERS_ROOT', dirname(__FILE__).'/');
        require_once(USERS_ROOT.'DataBase.class.php');
    }


    class User {
        
        private $id;
        private $registration;
        private $lastupdate;
        private $lastaccess;
        private $name;
        private $lastname;
        private $document;
        private $sex;
        private $datebirth;
        private $telephone;
        private $cell;
        private $email;
        private $thumb;
        private $login;
        private $password;
        private $usertype;
        private $status;
        private $dataBase;

        function __construct($pId=''){
            
            if(!empty($pId)){
                $this->setId($pId);
                $this->load();
            }
        }


        public function getDataBase(){
            $thisDataBase = $this->dataBase;
            if(empty($thisDataBase)){
                $this->dataBase = new DataBase();
            }
            return $this->dataBase;
        }


        /**
         * LOAD
         * carrega o objeto com os dados do DB
         */ 
        public function load(){

            $DataBase = $this->getDataBase();            

            $query = "SELECT * FROM `users` WHERE `id` = ? LIMIT 1";
            $res   = $DataBase->selectDB($query, $this->getId());

            if(count($res)>0){
                
                $r = $res[0];
                
                $this->setId($r->id);
                $this->setRegistration($r->registration);
                $this->setLastupdate($r->lastupdate);
                $this->setLastaccess($r->lastaccess);
                $this->setName($r->name);
                $this->setLastname($r->lastname);
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
        public function insert(){

            $DataBase = $this->getDataBase();

            $query  = "INSERT INTO `users` ";
            $query .= "(`name`, `lastname`, `sex`, `datebirth`, `telephone`, `cell`, `email`, `thumb`, `login`, `password`, `usertype`, `status`) ";
            $query .= "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $params = array($this->getName(), $this->getLastname(), $this->getSex(), $this->getDatebirth(), $this->getTelephone(), $this->getCell(), $this->getEmail(), $this->getThumb(), $this->getLogin(), $this->getPassword(), $this->getUsertype(), $this->getStatus());

            $insert = $DataBase ->insertDB($query, $params);

            if($insert > 0){
                $this->setId($insert);
                return $this->insertExtend();
            }
            else {
                return false;
            }
        }

        public function insertExtend(){
            return true;
        }


        /**
         * UPDATE
         */ 
        public function update(){

            $DataBase = $this->getDataBase();

            $query  = "UPDATE `users` SET ";
            $query .= "`lastupdate` = NOW(), `lastaccess` = ?,  `name` = ?, `lastname` = ?, `sex` = ?, `datebirth` = ?, `telephone` = ?, `cell` = ?, `email` = ?, `thumb` = ?, `login` = ?, `password` = ?, `usertype` = ?, `status` = ? ";
            $query .= "WHERE `id` = ? LIMIT 1";

            $params = array($this->getLastaccess(), $this->getName(), $this->getLastname(), $this->getSex(), $this->getDatebirth(), $this->getTelephone(), $this->getCell(), $this->getEmail(), $this->getThumb(), $this->getLogin(), $this->getPassword(), $this->getUsertype(), $this->getStatus(), $this->getId());

            $update = $DataBase->updateDB($query, $params);

            return $this->updateExtend();
        }

        public function updateExtend(){
            return true;
        }


        /**
         * APPLY UPDATE
         * Decide se é insert ou update
         */ 
        public function applyUpdate(){

            $thisId = $this->getId();
            if(!empty($thisId)){
                return $this->update();
            }
            else {
                return $this->insert();
            }
        }


        /**
         * DELETE
         */ 
        public function delete(){

            $DataBase = $this->getDataBase();

            $query  = "DELETE FROM users WHERE id = ? LIMIT 1";
            $params = array($this->getId());
            $delete = $DataBase->deleteDB($query, $params);

            if($delete > 0){
                return deleteExtend();
            }
            else {
                return false;
            }
        }

        public function deleteExtend(){
            return true;
        }

        /**
         * SETTERS
         */ 
        
        public function setId($id){$this->id = $id;}
        public function setRegistration($registration){$this->registration = $registration;}
        public function setLastupdate($lastupdate){$this->lastupdate = $lastupdate;}
        public function setLastaccess($lastaccess){$this->lastaccess = $lastaccess;}
        public function setName($name){$this->name = $name;}
        public function setLastname($lastname){$this->lastname = $lastname;}
        public function setDocument($document){$this->document = $document;}
        public function setSex($sex){$this->sex = $sex;}
        public function setDatebirth($datebirth){$this->datebirth = $datebirth;}
        public function setTelephone($telephone){$this->telephone = $telephone;}
        public function setCell($cell){$this->cell = $cell;}
        public function setEmail($email){$this->email = $email;}
        public function setThumb($thumb){$this->thumb = $thumb;}
        public function setLogin($login){$this->login = $login;}
        public function setPassword($password){$this->password = $password;}
        public function setUsertype($usertype){$this->usertype = $usertype;}
        public function setStatus($status){$this->status = $status;}

        /**
         * GETTERS
         */ 
        
        public function getId(){return $this->id;}
        public function getRegistration(){return $this->registration;}
        public function getLastupdate(){return $this->lastupdate;}
        public function getLastaccess(){return $this->lastaccess;}
        public function getName(){return $this->name;}        
        public function getLastname(){return $this->lastname;}
        public function getFullname(){return $this->name.(!empty($this->lastname) ? ' '.$this->lastname : '');}
        public function getDocument(){return $this->document;}
        public function getSex(){return $this->sex;}
        public function getDatebirth(){return $this->datebirth;}
        public function getTelephone(){return $this->telephone;}
        public function getCell(){return $this->cell;}
        public function getEmail(){return $this->email;}
        public function getThumb(){return $this->thumb;}
        public function getLogin(){return $this->login;}
        public function getPassword(){return $this->password;}
        public function getUsertype(){return $this->usertype;}
        public function getStatus(){return $this->status;}

        public function getTypeNames(){return array('A'=>'Administrador', 'I'=>'Escola', 'T'=>'Professor', 'S'=>'Aluno');}
        public function getStatusNames(){return array('A'=>'Ativo', 'I'=>'Inativo', 'S'=>'Suspenso', 'B'=>'Bloqueado', 'D'=>'Excluído');}

    }




    class UsersList {

        private $page;
        private $limit;
        private $orderBy;
        private $filters;
        private $params;


        function __construct(){

            $this->setPage(1);
            $this->setLimit(0);
            $this->filters = array();
            $this->setOrderBy('desc');
        }


        public function getDataBase(){
            if(empty($this->dataBase)){
                $this->dataBase = new DataBase();
            }
            return $this->dataBase;
        }


        /**
         * GET LIST
         */
        public function getList(){
            $result    = array();
            $DataBase  = $this->getDataBase(); //print_r($DataBase);

            $query  = "SELECT id FROM users WHERE 1 ";
            $query .= $DataBase->applyFilters($this->getFilters());
            $query .= "AND status != 'D' ";
            $query .= $this->getOrderBy() ? "ORDER BY ".$this->getOrderBy()." " : "";
            //die($DataBase->pdoDebugger($query, $this->getParams()));
            $list = $DataBase->selectDB($query, $this->getParams());
            foreach($list as $item){
                $obj = new User($item->id);
                $result[] = $obj;
            }

            return $result;
        }
        

        public function getTotalGeral(){
            $total = 0;
            $DataBase  = $this->getDataBase();  

            $query  = "SELECT * FROM users WHERE 1";
            $query .= $DataBase->applyFilters($this->filters);
            $total  = $DataBase->rowCount($query, $this->getParams());
            return $total;
        }


        /**
         * SETTERS
         */
        
        public function setPage($page = ''){
            if(!empty($page)){$this->page = $page;}
        }
        public function setLimit($limit = ''){
            if(!empty($limit)){$this->limit = $limit;}
        }
        public function setOrderBy($order){
            if($order == 'desc'){
                $this->orderBy = "id DESC";
            }
            elseif($order == 'asc'){
                $this->orderBy = "id ASC";
            }
            elseif($order == 'rand'){
                $this->orderBy = "RAND()";
            }
        }


        /**
         * GETTERS
         */
        
        public function getPage(){return $this->page;}
        public function getLimit(){return $this->limit;}
        public function getOrderBy(){return $this->orderBy;}
        public function getFilters(){return $this->filters;}
        public function getParams(){return $this->params;}
        

        /**
         * FILTERS
         */
        
        public function filterByKey($key){
            $fields = array('name', 'lastname', 'email');
            if(count($fields) > 0 && !empty($key)){
                $i      = 0;
                $filter = '';
                foreach($fields as $field){
                    if($i>0){$filter .= " OR ";}$i++;
                    $filter .= $field." LIKE :key".$i;
                    $this->params['key'.$i] = '%'.$key.'%';
                }
                $this->filters[] = "($filter)";
            }
        } 
        public function filterByRegistration($dtIni, $dtFin){
            if(!empty($dtIni)){
                $this->filters[] = "registration >= :registrationIni";
                $this->params['registrationIni'] = $dtIni;
            }
            if(!empty($dtFin)){
                $this->filters[] = "registration <= :registrationFin";
                $this->params['registrationFin'] = $dtFin;
            }
        }
        public function filterByLastaccess($dtIni, $dtFin){
            if(!empty($dtIni)){
                $this->filters[] = "lastaccess >= :lastaccessIni";
                $this->params['lastaccessIni'] = $dtIni;
            }
            if(!empty($dtFin)){
                $this->filters[] = "lastaccess <= :lastaccessFin";
                $this->params['lastaccessFin'] = $dtFin;
            }
        }
        public function filterByUsertype($usertype=''){
            if(!empty($usertype)){
                $this->filters[] = "usertype = :usertype";
                $this->params['usertype'] = $usertype;
            }
        }
        public function filterByStatus($status=''){
            if(!empty($status)){
                $this->filters[] = "status = :status";
                $this->params['status'] = $status;
            }
        }

    }
