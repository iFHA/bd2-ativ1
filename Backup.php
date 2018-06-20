<?php
try {
  $pdo = new PDO('mysql:host=localhost;dbname=loja2', "root", "");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $consulta = $pdo->query("SELECT * FROM backup_log;");


  while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
        $data = array($linha['Id_Produto'],$linha['Id_cliente'],$linha['quantidade']);
        $stmt = $pdo->prepare("INSERT INTO venda (Id_Produto, Id_cliente, quantidade) VALUES (?,?,?)");
        $stmt->execute($data);
        
        $stmt = $pdo->prepare('UPDATE produtos SET quantidade = quantidade - :qtd WHERE Id_Produto = :idpr');
        $stmt->bindParam(':qtd',$linha['quantidade']);
        $stmt->bindParam(':idpr',$linha['Id_Produto']);
        $stmt->execute();
  }
  $stmt = $pdo->prepare('DELETE FROM backup_log');
  $stmt->execute();
  echo 'Backup restaurado';

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}
  
?>
