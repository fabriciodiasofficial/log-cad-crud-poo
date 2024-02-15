<!-- admin_dashboard.php -->
<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['nivel_acesso'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$user = $_SESSION['user'];

echo "Bem-vindo à área restrita de administração, {$user['email']}!<br>";
echo "<a href='logout.php'>Logout</a>";

// Inclui o arquivo de conexão
require_once 'db.php';
require_once 'loja.php';

// Cria uma instância da classe Database
$database = new Database();
$db = $database->getPDO();

// Obtém todas as lojas usando a classe Loja
$lojas = Loja::getAllLojas($db);

// Exibe a tabela de lojas
echo "<br><br><b>Lista de Lojas:</b><br>";
echo "<table border='1'>";
echo "<tr><th>ID Loja</th><th>Nome da Loja</th><th>CNPJ</th><th>Email</th><th>Acesso</th><th>Ações</th></tr>";

foreach ($lojas as $loja) {
    echo "<tr>";
    echo "<td>" . $loja['id_loja'] . "</td>";
    echo "<td>" . $loja['nome_loja'] . "</td>";
    echo "<td>" . $loja['cnpj'] . "</td>";
    echo "<td>" . $loja['email'] . "</td>";
    echo "<td>" . $loja['nivel_acesso'] . "</td>";
    // Adiciona links para editar, excluir e promover a loja
    echo "<td>
            <a href='editar_loja.php?id_loja=" . $loja['id_loja'] . "'>Editar</a> | 
            <a href='javascript:void(0);' onclick='confirmarExclusao(" . $loja['id_loja'] . ")'>Excluir</a> | 
            <a href='javascript:void(0);' onclick='confirmarPromocao(" . $loja['id_loja'] . ")'>Promover</a> |
            <a href='javascript:void(0);' onclick='confirmarDespromocao(" . $loja['id_loja'] . ")'>Despromover</a>

            </td>";
    echo "</tr>";
}

echo "</table>";

// Script JavaScript para confirmar exclusão
echo "
<script>
function confirmarExclusao(idLoja) {
    var resposta = confirm('Tem certeza que gostaria de excluir esta loja?');

    if (resposta) {
        window.location.href = 'excluir_loja.php?id_loja=' + idLoja;
    }
}

function confirmarPromocao(idLoja) {
    var resposta = confirm('Tem certeza que gostaria de promover esta loja para administrador?');

    if (resposta) {
        window.location.href = 'promover_admin.php?id_loja=' + idLoja;
    }
}

function confirmarDespromocao(idLoja) {
    var resposta = confirm('Tem certeza que gostaria de despromover esse administrador para loja?');

    if (resposta) {
        window.location.href = 'despromover_loja.php?id_loja=' + idLoja;
    }
}

</script>
";
?>
