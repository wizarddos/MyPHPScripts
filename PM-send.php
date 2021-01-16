<?php
#PM-send.php - script used to send private messages
session_start();
require_once "connect.php";
$username = $_POST['username'];
$content = $_POST['content'];

$username = htmlentities($username, ENT_HTML5, "UTF-8");
$content = htmlentities($content,ENT_HTML5, "UTF-8");
if(!$username or !$content){
    $_SESSION['blad'] = '<span style = "color: red">wypełnij wszystkie pola</span>';
    header("Location: skrzynka.php");
    exit();
}
try{
    $db = new mysqli($host, $db_user,$db_pass,$db_name);
    if($db->connect_errno != 0){
        throw new mysqli_sql_exception($connect->connect_error);
    }else{
        $query = "SELECT * FROM uzytkownicy WHERE user = ?";
        if(!$polecenie = $db->prepare($query)){
            throw new mysqli_sql_exception("błąd przygotowania zapytania");
        }else{
            $polecenie->bind_param("s",$username);
            $polecenie->execute();
            $wynik = $polecenie->get_result();
            if($wynik->num_rows == 0){
                $_SESSION['blad'] = '<span style = "color: red">nie ma takiego użytkownika w bazie</span>';
                header("Location: skrzynka.php");
                exit();
            }
            $tablica = $wynik->fetch_assoc();
            $iddokogo = $tablica['id'];
            if($iddokogo == $_SESSION['id']){
                $_SESSION['blad'] = '<span style = "color: red">nie można wysłać wiadomości do samego siebie</span>';
                header("Location: skrzynka.php");
                exit();
            }else{
                $query2 = "INSERT INTO wiadomosci VALUES(NULL,?,?,?,?)" ;
                if(!$polecenie->prepare($query2)){
                    throw new mysqli_sql_exception("błąd przygotowania zapytania");
                }else{
                    $polecenie->bind_param("siis", $content, $_SESSION['id'], $iddokogo, date("Y-m-d"));
                    if(!$polecenie->execute()){
                        throw new mysqli_sql_exception("błąd wykonania zapytania");
                    }else{
                        $_SESSION['blad'] = '<span style = "color: limegreen">Pomyślnie wysłano wiadomość</span> ';
                        header("Location: skrzynka.php");
                    }
                }
            }
        }
    }
}catch(mysqli_sql_exception $e){
    $_SESSION['blad'] = "błąd bazy danych";
    header("Location: skrzynka.php");
}catch(Exception $e){
    $_SESSION['blad'] = "nieznany błąd";
    header("Location: skrzynka.php");
}

#Author: wizarddos