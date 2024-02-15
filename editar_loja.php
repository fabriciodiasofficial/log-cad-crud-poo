<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['nivel_acesso'] !== 'admin') {
    header('Location: index.php');
    exit();
}

require_once 'db.php';
require_once 'Loja.php';

$database = new Database();
$db = $database->getPDO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_loja = $_POST['id_loja'];
    $novo_nome = $_POST['novo_nome'];
    $novo_cnpj = $_POST['novo_cnpj'];
    $novo_email = $_POST['novo_email'];
    $nova_senha = $_POST['nova_senha'];

    $loja = Loja::getLojaById($id_loja, $db);

    if ($loja) {
        $lojaObj = new Loja($loja['id_loja'], $loja['nome_loja'], $loja['cnpj'], $loja['email'], $loja['senha']);
        $lojaObj->editarLoja($novo_nome, $novo_cnpj, $novo_email, $nova_senha, $db);

        echo "Loja editada com sucesso!";
    } else {
        echo "Loja não encontrada.";
    }
}

if (isset($_GET['id_loja'])) {
    $id_loja = $_GET['id_loja'];

    $loja = Loja::getLojaById($id_loja, $db);

    if ($loja) {
        ?>
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <title>Editar Loja</title>
        </head>
        <body>
            <h2>Editar Loja</h2>
            <a href='admin_dashboard.php'>Voltar ao Painel</a>
            <br><br>
            <form method="post" action="">
                <input type="hidden" name="id_loja" value="<?php echo $loja['id_loja']; ?>">
                <label>Novo Nome: <input type="text" name="novo_nome" value="<?php echo $loja['nome_loja']; ?>" required></label><br>
                <label>Novo CNPJ: <input type="text" name="novo_cnpj" value="<?php echo $loja['cnpj']; ?>" required></label><br>
                <label>Novo Email: <input type="email" name="novo_email" value="<?php echo $loja['email']; ?>" required></label><br>
                <label>Nova Senha: <input type="password" name="nova_senha" required></label><br>
                <input type="submit" value="Editar Loja">
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "Loja não encontrada.";
    }
} else {
    echo "ID da loja não especificado.";
}
?>
