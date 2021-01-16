<?php 
#SQL-Select.php - some function making SELECT Query to database
    function select($connect_file_name, $table_name, $column, $val_of_column){
        require_once $connect_file_name;
        $connect = new mysqli($host,$db_user,$db_pass,$db_name);
        if($connect->connect_error != 0){
            return $connect->connect_error;
        }else{
            if($result = $connect->query("SELECT * FROM $table_name, WHERE $column = '$val_of_column'")){
                return $result;
            }else{
                return false;
            }
        }
    }

#Author: wizarddos