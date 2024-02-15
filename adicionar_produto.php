<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['nivel_acesso'] !== 'loja') {
    header('Location: index.php');
    exit();
}

$user = $_SESSION['user'];

echo "Bem-vindo à área restrita da loja, {$user['email']}!<br>";
echo "<a href='logout.php'>Logout</a>";

require_once 'db.php';
require_once 'Produto.php';

$database = new Database();
$db = $database->getPDO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_produto = $_POST['nome_produto'];
    $preco_produto = $_POST['preco_produto'];

    // Chama o método estático para adicionar um novo produto
    Produto::adicionarProduto($nome_produto, $preco_produto, $_SESSION['user']['id_loja'], $db);

    echo "Produto adicionado com sucesso! <a href='loja_dashboard.php'>Voltar ao Painel</a>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Produto</title>
</head>
<body>
    <h2>Adicionar Produto</h2>
    <a href="loja_dashboard.php">Voltar ao Painel</a>
    <br><br>
    <form method="post" action="">
        <label>Nome do Novo Produto: <input type="text" name="nome_produto"></label><br>
        <label>Preço do Novo Produto: <input type="text" name="preco_produto"></label><br>
        <input type="submit" value="Adicionar Produto">
    </form>
</body>
</html>