<!-- despromover_loja.php -->
<?php
session_start();
require_once 'db.php';
require_once 'loja.php';

if(!isset($_SESSION['user']) || $_SESSION['user']['nivel_acesso'] !== 'admin'){
    header('Location: index.php');
    exit();
}

if(isset($_GET['id_loja'])){
    $id_loja = $_GET['id_loja'];

    //Crie uma instância da classe Database
    $database = new Database();
    $db = $database->getPDO();

    //Crie uma instância da classe Loja
    $loja = Loja::getLojaById($id_loja, $db);

    if($loja){
        //despromover o admin para o nível de acesso "loja"
        $lojaObj = new Loja($loja['id_loja'], $loja['nome_loja'], $loja['cnpj'], $loja['email'], '');
        $lojaObj->despromoverParaLoja($db);

        //Redicione de volta à página de admin_dashboard.php após a promoção
        header('Location: admin_dashboard.php');
        exit();
    }
}
?>