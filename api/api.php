<?php

//ZICK API v1.0

//ACCEPTED HEADERS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/JSON; charset=utf-8;');
include('adatok.php');
//DB SETUP
$db = new PDO('mysql:dbname=' . $dbname . ';host=' . $dbhost, $dbuser, $dbpass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$db->exec("SET NAMES utf8");
//HANDLING INPUTS
$data = json_decode(file_get_contents("php://input"));
function POST($db, $data)
{
    if (CheckIfHasTable($data)){
        $table = $data->table;
        //HANDLING NO DATA
        if (isset($data->data)){
            $insertKeys = array();
            $insertValues = array();
            //SET INSERT TEXT
            foreach ($data->data as $key => $value){
                array_push($insertKeys, $key);
                array_push($insertValues, "'".$value."'");
            }
            try{
                //INSERTING
                $insertKeyString = join(",", $insertKeys);
                $insertValuesString = join(",", $insertValues);
                return array(
                    "inserts" => $db->exec("insert into $table ($insertKeyString) values ($insertValuesString)")
                );
            }
            catch (PDOException $e){
                status(400);
                return array(
                    "inserts" => 0,
                    "message" => $e->errorInfo
                );
            }
        }
    }
    else {
        return NoTableError();
    }
}
function PATCH($db, $data)
{
    //HANDLING NO TABLE
    if (CheckIfHasTable($data)){
        $table = $data->table;
        //HANDLING NO DATA
        if (isset($data->data)){
            //UPDATE TEXT SETUP
            $updateText = "";
            foreach ($data->data as $key => $dValue){
                $updateText .= $key . "=" . "'" . $dValue . "'";
            }
            if (CheckIfHasFields($data)){
                //UPDATE BY FIELD
                $field = $data->field;
                $value = $data->value;
                try{
                    return array(
                        "affectedRows" => $db->exec("update $table set $updateText where $field=$value")
                    );
                }
                catch (PDOException $e){
                    status(400);
                    return array(
                        "affectedRows" => 0,
                        "message" => $e->errorInfo
                    );
                }
            }
            else if (CheckIfHasID($data)){
                //UPDATE BY ID
                $id = $data->ID;
                try{
                    return array(
                        "affectedRows" => $db->exec("update $table set $updateText where ID=$id")
                    );
                }
                catch (PDOException $e){
                    status(400);
                    return array(
                        "affectedRows" => 0,
                        "message" => $e->errorInfo
                    );
                }
            }
            else {
                status(400);
                return array(
                    "affectedRows" => 0,
                    "message" => "Set a filtering mode! (e. g.: by field, by ID)"
                );
            }
        }
        else{
            status(400);
            return array(
                "affectedRows" => 0,
                "message"=>"You didn't set data!"
            );
        }
    }
    else{
        $error = NoTableError();
        $error["affectedRows"] = 0;
        return $error;
    }
}
function MDELETE($db, $data)
{
    //NO TABLE HANDLING
    if (CheckIfHasTable($data)) {
        $table = $data->table;
        if (CheckIfHasFields($data)) {
            //DELETE BY FIELD AND VALUE
            $field = $data->field;
            $value = $data->value;
            try {
                return array(
                    "deletedRows" => $db->exec("delete from $table where $field='$value'")
                );
            } catch (PDOException $e) {
                status(400);
                return array(
                    "deletedRows" => 0,
                    "message" => $e->errorInfo
                );
            }
        } else if (CheckIfHasID($data)) {
            //DELETE BY ID
            $id = $data->ID;
            try {
                return array(
                    "deletedRows" => $db->exec("delete from $table where ID='$id'")
                );
            } catch (PDOException $e) {
                status(400);
                return array(
                    "deletedRows" => 0,
                    "message" => $e->errorInfo
                );
            }
        } else {
            //DELETE EVERYTHING
            try {
                return array(
                    "deletedRows" => $db->exec("delete from $table"),
                );
            } catch (PDOException $e) {
                status(400);
                return array(
                    "deletedRows" => 0,
                    "message" => $e->errorInfo
                );
            }
        }
    } else {
        $error = NoTableError();
        $error["deletedRows"]=0;
        return $error;
    }
}
function GET($db, $data)
{
    if (CheckIfHasTable($data)) {
        $table = $_REQUEST["table"];
        //GET BY FIELD AND VALUE
        if (CheckIfHasFields($data)) {
            try {
                $field = $_REQUEST["field"];
                $value = $_REQUEST["value"];
                return $db->query("select * from $table where $field=$value")->fetchAll();
            } catch (PDOException $e) {
                status(400);
                return array(
                    "error" => "ERR_BAD_FIELDS",
                    "message" => $e->errorInfo
                );
            }
        } else if (CheckIfHasID($data)) {
            //GET BY ID
            try {
                $id = $_REQUEST["ID"];
                return $db->query("select * from $table where ID=$id")->fetchAll();
            } catch (PDOException $e) {
                status(400);
                return array(
                    "error" => "ERR_ID",
                    "message" => $e->errorInfo
                );
            }
        } else {
            //GET ALL
            try {
                return $db->query("select * from $table")->fetchAll();
            } catch (PDOException $e) {
                status(400);
                return array(
                    "error" => "ERR_BAD_TABLE",
                    "message" => $e->errorInfo
                );
            }
        }
    } else {
        return NoTableError();
    }
}
//SETTING RESPONSE STATUS CODE
function status($code)
{
    http_response_code($code);
}
//ERROR HANDLINGS
function CheckIfHasTable($data): bool
{
    return isset($_REQUEST["table"]) || isset($data->table);
}
function CheckIfHasFields($data): bool
{
    return (isset($_REQUEST["field"]) && isset($_REQUEST["value"])) || (isset($data->field) && isset($data->value));
}
function CheckIfHasID($data): bool
{
    return isset($_REQUEST["ID"]) || isset($data->ID);
}
function NoTableError(){
    status(400);
    return array(
        "error" => "ERR_NO_TABLE",
        "message" => "A table is required!"
    );
}
//HANDLING THE REQUEST METHOD
function HandleRequest($db, $data)
{
    switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            return GET($db, $data);
        case "DELETE":
            return MDELETE($db,$data);
        case "PATCH":
            return PATCH($db, $data);
        case "POST":
            return POST($db, $data);
    }
}
//SEND IT
echo json_encode(HandleRequest($db, $data));
?>