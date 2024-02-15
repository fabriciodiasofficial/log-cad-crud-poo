<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['nivel_acesso'] !== 'loja'){
    header('Location: index.php');
    exit();
}

require_once 'db.php';
require_once 'Produto.php';

$database = new Database();
$db = $database->getPDO();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //Tratar o formulário de edição aqui
    $id_produto = $_POST['id_produto'];
    $novo_nome_produto = $_POST['novo_nome_produto'];
    $novo_preco_produto = $_POST['novo_preco_produto'];

    //Recupera o produto pelo Id
    $produto = Produto::getProdutoById($id_produto, $db);

    if($produto && $produto['id_loja'] == $_SESSION['user']['id_loja']){
        //Execute a edição do produto
        Produto::editarProduto($id_produto, $novo_nome_produto, $novo_preco_produto, $db);

        echo "Produto editado com sucesso! <a href='loja_dashboard.php'>Voltar</a>";
    }else{
        echo"Produto não encontrado ou você não tem permissão para editá-lo.";
    }
}

//Recuperar informações do produto a ser editado
if(isset($_GET['id_produto'])){
    $id_produto = $_GET['id_produto'];

    $produto = Produto::getProdutoById($id_produto, $db);

    if($produto && $produto['id_loja'] == $_SESSION['user']['id_loja']){
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Editar Produto</title>
        </head>
        <body>
            <h2>Editar Produto</h2>
            <a href='loja_dashboard.php'>Voltar ao Painel</a>
            <br><br>
            <form method="post" action="">
                <input type="hidden" name="id_produto" value="<?php echo $produto['id_prod']; ?>">
                <label>Novo Nome do Produto: <input type="text" name="novo_nome_produto" value="<?php echo $produto['nome_prod']; ?>"></label><br>
                <label>Novo Preço do Produto: <input type="text" name="novo_preco_produto" value="<?php echo $produto['preco_prod']; ?>"></label><br>
                <input type="submit" value="Salvar Edições">
            </form>
        </body>
        </html>
        <?php
    }else{
        echo "Produto não encontrado ou você não tem permissão para editá-lo.";
    }
}else{
    echo"Id do produto não especificado.";
}
?>