<?php
    //  *****************************
    //  *   Simple PHP Backend API  *
    //  *           2023.           *
    //  *****************************

    //  SET HTTP HEADER SETTINGS 
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET,POST,PATCH,DELETE');
    header('Access-Control-Allow-Headers: Content-Type');
    header('Content-Type: application/json; charset=utf-8;');

    //  SET PDO DATABASE CONNECTION
    include('adatok.php');
    $db = new PDO('mysql:dbname='.$dbname.';host='.$dbhost, $dbuser, $dbpass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->exec("SET NAMES utf8");
    
    //  GET PHP INPUTS
    $data = json_decode(file_get_contents("php://input"));
    $table = $data->table;

    if ($op = @$data->op){
        $op = getOp($op);   
    }else{
        $op = '=';    
    }
    //  ************************************
    //  CRUD OPERATIONS ENDPOINTS
    //  ************************************

    echo json_encode(RequestSelector($data,$table, $op, $db));

    //  HTTP GET METHOD
    function GetRequests($data, $table, $op ,$db){
        // GET RECORD(S) BY FIELD
        if (isset($data->field) && isset($data->value)){
            $field = $data->field;
            $value = $data->value;
            if ($op == ' LIKE ') {
                $value = "%$value%";
            }
            try{
                return $db->query("SELECT * FROM $table WHERE $field $op '$value'")->fetchAll();  
            }
            catch(PDOException $Exception){
                return array(
                    'message' => $db->errorInfo(),
                    'clientData'=>$data
                );
            }
        }else
        // GET ONE RECORD BY ID 
        if (isset($data->id)){
            $id = $data->id;
            try{
                return $db->query("SELECT * FROM $table WHERE ID = $id")->fetchAll();
            }
            catch(PDOException $Exception){
                return array(
                    'message' => $db->errorInfo(),
                    'clientData'=>$data
                );
            }
        }
        else{
            // GET ALL RECORDS
            try{
                return $db->query("SELECT * FROM $table")->fetchAll();
            }
            catch(PDOException $Exception){
                return array(
                    'message' => $db->errorInfo(),
                    'clientData'=>$data
                );
            }
        }    
    }

    //  HTTP POST METHOD
    function PostRequests($data,$table, $op, $db){
        $sqlfields='';
        $sqlvalues='';
        foreach ( $data->values as $key => $field) {
            $sqlfields .= ",".$key;
            $sqlvalues .=","."'".$field."'";
        }
        try{
            $affectedRows = $db->exec("INSERT INTO $table (ID $sqlfields) VALUES (null $sqlvalues)"); 
            return array(
                'affectedRows' => $affectedRows,
                'message' => "A művelet végrehajtva!"
            );
        }
        catch(PDOException $Exception){
            return array(
                'affectedRows' => 0,
                'message' => $db->errorInfo()
            );
        }
    }

    //  HTTP PATCH METHOD
    function PatchRequests($data,$table, $op, $db){
        $field = $data->field;
        $value = $data->value;
        $newrecord = $data->values;
        $str = '';
        foreach ($newrecord as $key => $record) {
            $str .= $key . "='" . $record . "',";
        }
        $str = rtrim($str,1);
        try{
            $affectedRows = $db->exec("UPDATE TABLE $table SET $str WHERE $field $op $value" ); 
            return array(
                'affectedRows' => $affectedRows,
                'message' => "A művelet végrehajtva!"
            );
        }
        catch(PDOException $Exception){
            return array(
                'affectedRows' => 0,
                'message' => $db->errorInfo()
            );
        }
    }
    
    //  DELETE METHOD
    function DeleteRequests($data,$table, $op, $db){
        // DELETE RECORD BY FIELD
        if (isset($data->field) && isset($data->value)){
            $field = $data->field;
            $value = $data->value;
            if ($op == ' LIKE ') {
                $value = "%$value%";
            }
            try{
                $affectedRows = $db->exec("DELETE FROM $table WHERE $field $op '$value'"); 
                return $results = array(
                    'affectedRows' => $affectedRows,
                    'message' => "A művelet végrehajtva!"
                );
            }
            catch(PDOException $Exception){
                return $results = array(
                    'affectedRows' => 0,
                    'message' => $db->errorInfo()
                );
            } 
        }else
        // DELETE RECORD BY ID 
        if (isset($data->id)){
            $id = $data->id;
            try{
                $affectedRows = $db->exec("DELETE FROM $table WHERE ID = $id");
                $results = array(
                    'affectedRows' => $affectedRows,
                    'message' => "A művelet végrehajtva!"
                );
            }
            catch(PDOException $Exception){
                $results = array(
                    'affectedRows' => 0,
                    'message' => $db->errorInfo()
                );
            }
        }
        else{
            // DELETE ALL RECORDS
            try{
                $affectedRows = $db->exec("DELETE FROM $table");
                $results = array(
                    'affectedRows' => $affectedRows,
                    'message' => "A művelet végrehajtva!"
                );
            }
            catch(PDOException $Exception){
                $results = array(
                    'affectedRows' => 0,
                    'message' => $db->errorInfo()
                );
            }
        }
    }

    //  ************************************
    //  OTHER FUNCTIONS
    //  ************************************

    //  operands switcher
    function getOp($op){
        switch ($op) {
            case 'eq':
                { $op = '='; break; }
            case 'lt':
                { $op = '<'; break; }
            case 'gt':
                { $op = '>'; break; }
            case 'not':
                { $op = '!='; break; }
            case 'gte':
                { $op = '>='; break; }
            case 'lte':
                { $op = '<='; break; }
            case 'lk':
                { $op = ' LIKE '; break; }
        }
        return $op;
    }
    //request type switch
    function RequestSelector($data,$table, $op, $db){
        switch($_SERVER['REQUEST_METHOD']){
            case 'GET': {return (GetRequests($data,$table, $op, $db)); }
            case 'DELETE': {return (DeleteRequests($data,$table, $op, $db)); }
            case 'POST':{return (PostRequests($data,$table, $op, $db));; }
            case 'PATCH':{return (PatchRequests($data,$table, $op, $db));; }
        }
    }
?>
