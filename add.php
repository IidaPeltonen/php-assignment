<?php

require_once './functions.php';
$input = json_decode(file_get_contents('php://input'));

$user = filter_var($input->user, FILTER_SANITIZE_STRING);
$password = filter_var($input->password, FILTER_SANITIZE_STRING);

try{
    $dbcon = openDb();
   // $hash_password = password_hash($password, PASSWORD_DEFAULT); //salasanan hash
    $query = $dbcon->prepare('insert into tunnus (user, password) values (:user, :password)');
    $query->bindValue(':user',$user, PDO::PARAM_STR);
    $query->bindValue(':password',$password, PDO::PARAM_STR);
    $query->execute();
    header('HTTP/1.1 200 OK');
    $data = array('id' => $dbcon->lastInsertId(),'user' => $user, 
        'password' => $password);
    print json_encode($data);
}catch(PDOException $e){
    echo '<br>'.$e->getMessage();
}

