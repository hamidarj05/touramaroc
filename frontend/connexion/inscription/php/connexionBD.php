<?php

function connexion($servername , $dbname , $username , $password){
    try{
        
        $pdo = new PDO("mysql:host=$servername; port=3306 ; dbname=$dbname" ,$username , $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }catch(PDOException $e){
        return false ;
    }
}


// $kk = connexion('sql100.infinityfree.com' , 'if0_39175946_touramaroc' , 'if0_39175946' , 'zCpWskUJsfI9Y') ;










?>