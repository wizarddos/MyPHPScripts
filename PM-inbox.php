<?php
#PM-inbox.php - Simple inbox script
    session_start();
    require_once "connect.php";
    try{
        $connect = new mysqli($host,$db_user,$db_pass,$db_name);
        if($connect->connect_errno !=0){
            throw new mysqli_sql_exception($connect->connect_error);
        }else{
            $query = "SELECT * FROM wiadomosci WHERE iddokogo = ?";
            if(!$polecenie = $connect->prepare($query)){
                throw new mysqli_sql_exception("Błąd przygotowania zapytania");
            }
            $userid =  $_SESSION['id'];
            $polecenie->bind_param('i', $userid);
            $rezultat = $polecenie->execute();
            $wynik = $polecenie->get_result();
            $tablica = $wynik->fetch_assoc();
            $ile = $wynik->num_rows;
            foreach($wynik as $tablica){
                echo $tablica['trescWidomosci']."<br/><br/>";
            }
        }
        $connect->close();
    }catch(mysqli_sql_exception $e){
        echo "błąd bazy danych";
        echo $e;
    }catch(Exception $e){
        echo "nieznany błąd";
    }

#Author: wizarddos