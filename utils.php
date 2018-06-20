<?php

$username = 'root';
$password = '';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=loja2', $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

function login($login, $senha){
    global $pdo;
    try {
        $consulta = $pdo->query('SELECT id_cliente FROM cliente where login=\''.$login.'\' and senha=\''.$senha.'\';');
        $qtd = $consulta->rowCount();
        if(!empty($qtd)){
            $clientid = $consulta->fetch(PDO::FETCH_ASSOC);
            return $clientid['id_cliente'];
        }
        else
            return false;
    } catch(PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        return false;
    }
}

function lockTable($table){
    global $pdo;
    try {
        $pdo->query('LOCK TABLES '.$table.' WRITE');
        
        return true;
    } catch(PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        return false;
    }
}

function unlockTables(){
    global $pdo;
    try {
        $pdo->query('UNLOCK TABLES');
        return true;
    } catch(PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        return false;
    }
}

function transaction($clientid, $pid, $qtd){
    global $pdo;
    $retorno = false;
    try {
        $pdo->beginTransaction();
        $pdo->query('SET autocommit=0;');
        $sth = $pdo->exec("UPDATE produtos SET quantidade = quantidade - $qtd where ID_Produto = $pid");
        
        $stmt = $pdo->prepare('INSERT INTO venda VALUES(default, :productid, :clientid, :quantidade)');
        $stmt->execute(array(
        ':productid' => $pid, 
        ':clientid' => $clientid, 
        ':quantidade' => $qtd
        ));

        $pdo->commit();
        $retorno = true;
    } catch(PDOException $e) {
        $pdo->rollBack();
        $retorno = false;
    }
    if(!unlockTables()){
        $retorno = false;
    }
    return $retorno;
}

?>