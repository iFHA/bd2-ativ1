<?php

error_reporting(E_ERROR | E_PARSE);

try {
    $username = 'root';
    $password = '';
    $pdo = new PDO('mysql:host=localhost;dbname=loja2', $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $consulta = $pdo->query("SELECT ID_Produto, Descricao, Preco FROM produtos;");
    $i = 0;
    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
        $produtos[$i]->id = $linha['ID_Produto'];
        $produtos[$i]->descricao = $linha['Descricao'];
        $produtos[$i]->preco = $linha['Preco'];
        $i++;
    }
    $i=0;
} catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
    return false;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lojinha</title>
    <script src="js/jquery-3.3.1.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="js/loja.js"></script>
</head>
<body>
<div class="container">
    <h2>Produtos</h2>           
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Descrição do produto</th>
                <th>Preço(R$)</th>
                <th>Escolher Quantidade</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach($produtos as $produto){
        ?>
            <tr>
                <input type="hidden" name="produtoid" value="<?php echo $produto->id;?>"/>
                <input type="hidden" name="preco" value="<?php echo $produto->preco;?>"/>
                <input type="hidden" name="descricao" value="<?php echo $produto->descricao;?>"/>
                <td><?php echo $produto->descricao;?></td>
                <td><?php echo $produto->preco;?></td>
                <td><input name="qtd" type="number" min="1" value="1" ></td>
                <td>
                    <button class='btn btn-primary' onclick="comprar(this);">
                        Comprar
                    </button>
                </td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
</div>
<div class="container">

    <!-- Modal -->
    <div class="modal fade" data-js="modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
            <h4><span class="glyphicon glyphicon-lock"></span> Finalizando Compra</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
            <div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Preço Total(R$)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <form action="controller.php" data-js="form-compra" method="POST">
                                <input name="clientid" data-js="clienteid" type="hidden" value="<?php echo $_GET['clientid'];?>"/>
                                <input name="produtoid" data-js="produtoid" type="hidden" />
                                <input name="action" data-js="action" type="hidden" value="comprar" />
                                <input name="qtd" data-js="qtd" type="hidden" />
                                <td><input name="descricao" data-js="descricao" type="text" readonly/></td>
                                <td><input name="precototal" data-js="precototal" type="text" readonly /></td>
                            
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">Finalizar Compra</button>
        </div>
        </form>
        </div>
        
    </div>
    </div> 
</div>
<!-- Modal -->
<div data-js="modal2" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Loja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p data-js="modal2-text">Modal body text goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

<script>

</script>
</body>
</html>

<?php
?>