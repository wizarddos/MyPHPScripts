<?php
#SQL-Update: Simple function making SQL Query (Data have to be valid)
function update($connect_file_name, $table, $valueToUpdate, $columnToUpdate,$whereUPDATE, $whereUPDATEval){
    require_once $connect_file_name;
    $connect = new mysqli($host,$db_user,$db_pass,$db_name);
    if($connect->connect_error != 0){
        return false;
    }else{
        if($connect->query("UPDATE $table SET $columnToUpdate = '$valueToUpdate' WHERE $whereUPDATE = '$whereUPDATEval'")){
            return true;
        }else{
            return false;
        }
    }
}
#Author: wizarddos