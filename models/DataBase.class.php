<?php

/** root directory */
if (!defined('DATABASE_ROOT')) {
    define('DATABASE_ROOT', dirname(__FILE__) . '/');  
}

class DataBase {

    private $conn;
    public  $message;  


    function __construct(){
        $this->connect();
    }  
    

    /**
     * CONNECT
     * conecta ao banco de dados
     */
    public function connect(){  

        $dbType     = "mysql";
        $dbHost     = "localhost";
        $port       = "3306";
        $dbUser     = "root";
        $dbPassword = "";
        $dbName     = "lousaonline";

        // conecta ao banco
        if(empty($this->conn)){
            try{
                $this->conn = new PDO($dbType.":host=".$dbHost.";port=".$port.";dbname=".$dbName.";charset=utf8", $dbUser, $dbPassword);
            } catch(PDOException $e) {
                $this->message = $e->getMessage();
                $this->conn = 'ERROR';
            }   
        }                                   
         
        return $this->conn;
    }     
    
     
    /**
     * SELECT DB
     * retorna um VO ou um array de objetos
     */
    public function selectDB($sql, $params=null, $class=null){  
        $rs = null;
        if($this->connect() != 'ERROR'){
            $params = is_array($params) ? $params : @explode(',', $params);
            $query = $this->connect()->prepare($sql);
            $query->execute($params);
             
            if(isset($class)){
                $rs = $query->fetchAll(PDO::FETCH_CLASS,$class);// or die(print_r($query->errorInfo(), true));
            }else{
                $rs = $query->fetchAll(PDO::FETCH_OBJ);// or die(print_r($query->errorInfo(), true));
            }
            $this->disconnect();            
        }
        return $rs;
    }
  


    /**
     * INSERT DB
     * insere valores no banco de dados e retorna o último id inserido
     */
    public function insertDB($sql, $params=null){

        $result = false;

        if($this->connect() != 'ERROR'){ 
            $params = is_array($params) ? $params : explode(',', $params);
            $query  = $this->connect()->prepare($sql);
            
            $rs = $query->execute($params) or die(print_r($query->errorInfo(), true));

            if($rs === true){
               $result = $this->connect()->lastInsertId();
            }
            
            $result = $result ? $result : $rs;
           
            $this->disconnect();
        }

        return $result;
    }


     
    /**
     * UPDATE DB 
     * altera valores do banco de dados e retorna o número de linhas afetadas
     */
    public function updateDB($sql, $params=null){
        $rs = false;
        if($this->connect() != 'ERROR'){ 
            $params = is_array($params) ? $params : explode(',', $params);
            $query = $this->connect()->prepare($sql);
            $query->execute($params);
            $rs = true or die(print_r($query->errorInfo(), true));

            $this->disconnect();
        }
        return $rs;
    }
     


    /**
     * DELETE DB
     * exclui valores do banco de dados 
     */
    public function deleteDB($sql, $params=null){
        $rs = null;
        if($this->connect() != 'ERROR'){ 
            $params = is_array($params) ? $params : explode(',', $params);
            $query = $this->connect()->prepare($sql);
            $rs = $query->execute($params);
     
            $this->disconnect();
        }
        return $rs;
    }  

   

    /**
     * ROW COUNT
     * retorna o numero de resultados
     */
    public function rowCount($sql, $params=null){
        $rowCount = 0;
        if($this->connect() != 'ERROR'){
            $params = is_array($params) ? $params : explode(',', $params);
            $query = $this->connect()->prepare($sql);
            $query->execute($params);
            $rowCount = $query->rowCount();  

            $this->disconnect();  
        }
        return $rowCount;
    }


   /**
     * DISCONNECT 
     * desconecta do banco
     */
    public function disconnect(){
        $this->conn = null;
    }


    /**
     * DESTRUCT
     * destroi a conexão com banco de dados e remove da memória todas as variáveis setadas
     */
    public function __destruct() {
        $this->disconnect();
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }


    /**
     * ************************************************************************
     * 
     * FUNÇÕES COMPLEMENTARES
     * 
     * ************************************************************************
     */


    /**
     * APLY PAGE LIMIT
     * Aplica o limit e page 
     * Retorna uma string para ser utilizado na query
     */
    public function applyPageLimit($pLimit, $pPage=1){
        $result = '';
        if($pLimit > 0){
            $result = " LIMIT ".((($pPage)-1)*$pLimit).", ".$pLimit." ";
        }
        return $result;
    }

    /**
     * APPLY FILTERS
     * Aplica os filtros
     * Retorna uma string para ser utilizado na query
     */
    public function applyFilters($pFilters){
        $result = '';
        if(count($pFilters) > 0){                  
            $filterStr = "";
            $i = 0;
            foreach($pFilters as $filter){                    
                if($i>0){$filterStr .= " AND ";}$i++;
                $filterStr .= $filter;
            }
            $result = " AND ($filterStr) ";
        }
        return $result;
    }
    


     /**
     * PDO DEBUGGER
     * Transforma uma query pdo em sql
     */
    public static function pdoDebugger($query, $parameters=array()){
        $keys = array();
        $values = array();
      
        $isNamedMarkers = false;
        if (count($parameters) && is_string(key($parameters))) {
            uksort($parameters, function($k1, $k2) {
                return strlen($k2) - strlen($k1);
            });
            $isNamedMarkers = true;
        }
        foreach ($parameters as $key => $value) {

            // check if named parameters (':param') or anonymous parameters ('?') are used
            if (is_string($key)) {
                $keys[] = '/:'.ltrim($key, ':').'/';
            } else {
                $keys[] = '/[?]/';
            }

            // bring parameter into human-readable format
            if (is_string($value)) {
                $values[] = "'" . addslashes($value) . "'";
            } elseif(is_int($value)) {
                $values[] = strval($value);
            } elseif (is_float($value)) {
                $values[] = strval($value);
            } elseif (is_array($value)) {
                $values[] = implode(',', $value);
            } elseif (is_null($value)) {
                $values[] = 'NULL';
            }
        }
        if ($isNamedMarkers) {
            return preg_replace($keys, $values, $query);
        } else {
            return preg_replace($keys, $values, $query, 1, $count);
        }
    }

}
