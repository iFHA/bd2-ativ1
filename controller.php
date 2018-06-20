<?php

require './utils.php';

$op = $_POST['action'];

switch($op){
    case 'login':
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $clientid = login($login, $senha);
    if($clientid)
        echo $clientid;
    else
        echo '0';
    break;
    case 'comprar':
    $clientId = $_POST['clientid'];
    $ProductId = $_POST['produtoid'];
    $qtd = $_POST['qtd'];
    if(transaction(intval($clientId), intval($ProductId), intval($qtd))){
        echo '1';
    } else {
        echo '0';
    }
    break;
    case 'bloquear':
    $obj = new stdClass();
    $obj->id = $_POST['id'];
    $obj->qtd = $_POST['qtd'];
    $obj->preco = intval($_POST['preco'])*(intval($obj->qtd));
    $obj->descricao = $_POST['descricao'];
    if(lockTable('produtos')){
        $obj->msg = '1';
    } else {
        $obj->msg = '0';
    } 
    
    $myJSON = json_encode($obj);
    echo $myJSON;
    break;
    case 'desbloquear':
    if(unlockTables()){
        echo '1';
    } else {
        echo '0';
    }
    break;
}

?>