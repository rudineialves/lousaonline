<?php 


    if(!defined('COURSES_ROOT')){
        define('COURSES_ROOT', dirname(__FILE__).'/');
        require_once(COURSES_ROOT.'DataBase.class.php');
    }


    class Course {
        
        private $id;
        private $name;
        private $dateCreated;
        private $dateCourse;
        private $hourInit;
        private $hourEnd;
        private $description;
        private $status;
        private $dataBase;

        function __construct($pId=''){
           
            if(!empty($pId)){
                $this->setId($pId);
                $this->load();
            }
        }


        private function getDataBase(){
            $thisDataBase = $this->dataBase;
            if(empty($thisDataBase)){
                $this->dataBase = new DataBase('sistema');
            }
            return $this->dataBase;
        }


        /**
         * LOAD
         * carrega o objeto com os dados do DB
         */ 
        public function load(){

            $DataBase = $this->getDataBase();            

            $query = "SELECT * FROM `courses` WHERE `id` = ? LIMIT 1";
            $res   = $DataBase->selectDB($query, $this->getId());

            if(count($res)>0){
                
                $r = $res[0];
                
                $this->setId($r->id);
                $this->setName($r->name);
                $this->setDateCreated($r->date_created);
                $this->setDateCourse($r->date_course);
                $this->setHourInit($r->hour_init);
                $this->setHourEnd($r->hour_end);
                $this->setDescription($r->description);
                $this->setStatus($r->status);
            }            
        }


        /**
         * INSERT
         */ 
        public function insert(){

            $DataBase = $this->getDataBase();

            $query  = "INSERT INTO `courses` ";
            $query .= "(`name`, `date_course`, `hour_init`, `hour_end`, `description`, `status`) ";
            $query .= "VALUES (?, ?, ?, ?, ?, ?)";

            $params = array($this->getName(), $this->getDateCourse(), $this->getHourInit(), $this->getHourEnd(), $this->getDescription(), $this->getStatus());

            $insert = $DataBase ->insertDB($query, $params);

            if($insert > 0){
                $this->setId($insert);
                return true;
            }
            else {
                return false;
            }
        }


        /**
         * UPDATE
         */ 
        public function update(){

            $DataBase = $this->getDataBase();

            $query  = "UPDATE `courses` SET ";
            $query .= "`name` = ?, `date_course` = ?, `hour_init` = ?, `hour_end` = ?, `description` = ?, `status` = ? ";
            $query .= "WHERE `id` = ? LIMIT 1";

            $params = array($this->getName(), $this->getDateCourse(), $this->getHourInit(), $this->getHourEnd(), $this->getDescription(), $this->getStatus(), $this->getId());

            $update = $DataBase->updateDB($query, $params);

            return $update;
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

            $query  = "DELETE FROM courses WHERE id = ? LIMIT 1";
            $params = array($this->getId());
            $delete = $DataBase->deleteDB($query, $params);

            if($delete > 0){
                return true;
            }
            else {
                return false;
            }
        }

        /**
         * SETTERS
         */ 
        
        public function setId($id){$this->id = $id;}
        public function setName($name){$this->name = $name;}
        public function setDateCreated($date_created){$this->dateCreated = $date_created;}
        public function setDateCourse($date_course){$this->dateCourse = $date_course;}
        public function setHourInit($hour_init){$this->hourInit = $hour_init;}
        public function setHourEnd($hour_end){$this->hourEnd = $hour_end;}
        public function setDescription($description){$this->description = $description;}
        public function setStatus($status){$this->status = $status;}

        /**
         * GETTERS
         */ 
        
        public function getId(){return $this->id;}
        public function getName(){return $this->name;}
        public function getDateCreated(){return $this->dateCreated;}
        public function getDateCourse(){return $this->dateCourse;}
        public function getHourInit(){return $this->hourInit;}
        public function getHourEnd(){return $this->hourEnd;}
        public function getDescription(){return $this->description;}
        public function getStatus(){return $this->status;}

    }




    class CoursesList {

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


        private function getDataBase(){
            if(empty($this->dataBase)){
                $this->dataBase = new DataBase('sistema');
            }
            return $this->dataBase;
        }


        /**
         * GET LIST
         */
        public function getList(){

            $result    = array();
            $DataBase  = $this->getDataBase();

            $query  = "SELECT id FROM courses WHERE 1 ";
            $query .= $DataBase->applyFilters($this->getFilters());
            $query .= "AND status != 'E' ";
            $query .= $this->getOrderBy() ? "ORDER BY ".$this->getOrderBy()." " : "";
            $query .= $DataBase->applyPageLimit($this->getLimit(), $this->getPage());

            $list = $DataBase->selectDB($query, $this->getParams());
            foreach($list as $item){
                $obj = new Course($item->id);
                $result[] = $obj;
            }

            return $result;
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
            $fields = array('name');
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
        public function filterByDateCourse($dtIni, $dtFin){
            if(!empty($dtIni)){
                $this->filters[] = "date_course >= :dateInitIni";
                $this->params['dateInitIni'] = $dtIni;
            }
            if(!empty($dtFin)){
                $this->filters[] = "date_course <= :dateInitFin";
                $this->params['dateInitFin'] = $dtFin;
            }
        }
        public function filterByTeacherUserId($teacherUserId=''){
            if(!empty($teacherUserId)){
                $this->filters[] = "teacher_user_id = :teacher_user_id";
                $this->params['teacher_user_id'] = $teacherUserId;
            }
        }
        public function filterByStudentUserId($studentUserId=''){
            if(!empty($studentUserId)){
                $this->filters[] = "student_user_id = :student_user_id";
                $this->params['student_user_id'] = $studentUserId;
            }
        }
        public function filterByStatus($status=''){
            if(!empty($status)){
                $this->filters[] = "status = :status";
                $this->params['status'] = $status;
            }
        }

    }
