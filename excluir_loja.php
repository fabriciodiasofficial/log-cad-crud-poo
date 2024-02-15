<?php
session_start().
require_once 'db.php';
require_once 'loja.php';

if(!isset($_SESSION['user']) || $_SESSION['user']['nivel_acesso'] !== 'admin'){
    header('Location: index.php');
    exit();
}

if(isset($_GET['id_loja'])){
    $id_loja = $_GET['id_loja'];

    //Inclua aqui a lógica para confirmar a exclusão se necessário

    //Crie uma instância da classe Database
    $database = new Database();
    $db = $database->getPDO();

    //Crie uma instância da classe Loja
    $loja = new Loja($id_loja, '', '', '', '');

    //Exclua a loja
    $loja->excluirLoja($db);

    //Redirecione de volta à página de lojas após a exlusão
    header('Location: admin_dashboard.php');
    exit();
}