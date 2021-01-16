<?php
#AC-changepass.php - simple function to change pass in mysql database
    function changepass($oldpass,$newpass,$column_with_pass, $table_name,$connection_file){
        require_once $connection_file;
        $connect = new mysqli($host,$db_user,$db_pass,$db_name);
        if($connect->connect_error != 0){
            return $connect->connect_error;
        }else{
            $oldpass = password_hash($oldpass,PASSWORD_DEFAULT);
            $newpass = password_hash($newpass, PASSWORD_DEFAULT);
            if($connect->query("UPDATE $table_name SET $column_with_pass = '$newpass' WHERE $column_with_pass = '$oldpass'")){
                return true;
            }else{
                return false;
            }
        }

    }
    
#Author: wizardos