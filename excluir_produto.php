<!-- excluir_produto.php -->
<?php
session_start();
require_once 'db.php';
require_once 'produto.php';

if(!isset($_SESSION['user']) || $_SESSION['user']['nivel_acesso'] !== 'loja'){
    header('Location: index.php');
    exit();
}

if(isset($_GET['id_produto'])){
    $id_produto = $_GET['id_produto'];

    //Inclua aqui a lógica para confirmar a exclusão se necessárioo

    //Crie uma instância da classe Database
    $database = new Database();
    $db = $database->getPDO();

    //Crie uma instância da classe Produto
    $produto = new Produto($id_produto, '', '', $_SESSION['user']['id_loja']);

    //Exclua o produto
    $produto->deletarProduto($db);

    //Redirecione de volta à página de produtos após a exclusão
    header('Location: loja_dashboard.php');
    exit();
}
?>