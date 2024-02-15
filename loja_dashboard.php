<!-- loja_dashboard.php -->
<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['nivel_acesso'] !== 'loja') {
    header('Location: index.php');
    exit();
}

$user = $_SESSION['user'];

echo "Bem-vindo à área restrita da loja, {$user['email']}!<br>";
echo "<a href='logout.php'>Logout</a>";

// Inclui o arquivo de conexão
require_once 'db.php';
require_once 'produto.php';

// Cria uma instância da classe Database
$database = new Database();
$db = $database->getPDO();

// Consulta para selecionar todos os produtos da loja
if (isset($_SESSION['user']['id_loja'])) {
    $produtos = Produto::getProdutosByLoja($_SESSION['user']['id_loja'], $db);

    // Exibe a tabela de produtos
    echo "<br><br><b>Lista de Produtos:</b><br>";
    echo "<table border='1'>";
    echo "<tr><th>Id Produto</th><th>Nome do Produto</th><th>Preço do Produto</th><th>Editar</th><th>Excluir</th></tr>";

    foreach ($produtos as $produto) {
        echo "<tr>";
        echo "<td>".$produto['id_prod']."</td>";
        echo "<td>".$produto['nome_prod']."</td>";
        echo "<td>".$produto['preco_prod']."</td>";
        echo "<td><a href='editar_produto.php?id_produto=".$produto['id_prod']."'>Editar</a></td>";
        echo "<td><a href='excluir_produto.php?id_produto=".$produto['id_prod']."' onclick='return confirm(\"Tem certeza que deseja excluir este produto?\")'>Excluir</a></td>";
        echo "</tr>";
    }

    echo "</table>";

    // Adiciona o link para adicionar um novo produto
    echo "<br><br><a href='adicionar_produto.php'>Adicionar Novo Produto</a>";
} else {
    echo "Id da loja não definido na sessão.";
}
?>
