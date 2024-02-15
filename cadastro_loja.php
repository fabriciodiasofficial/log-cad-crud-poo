<!-- cadastro_loja.php -->
<?php
require_once 'db.php';
require_once 'Cadastro.php';

session_start();

$db = new Database();
$cadastro = new Cadastro($db->getPDO());

$erro = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nome_loja = $_POST['nome_loja'];
    $cnpj = $_POST['cnpj'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    //Validação simples
    if(empty($nome_loja) || empty($cnpj) || empty($senha)){
        $erro = "Todos os campos são obrigatórios.";
    }else{
        if($cadastro->cadastrarLoja($nome_loja, $cnpj, $email, $senha)){
            echo "Loja cadastrada com sucesso! <a href='index.php'>Fazer Login</a>";
            //Adicionar redirecionamento ou outras ações após o cadastro
        }else{
            $erro = "Erro ao cadastrar a loja. E-mail já em uso.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Loja</title>
</head>
<body>
    <h2>Cadastro de Loja</h2>
    <?php
        if ($erro): ?>
        <p stype="color: red;"><?php echo $erro; ?>
    <?php endif; ?>
    <form method="post" action="">
            <label>Nome da Loja: <input type="text" name="nome_loja"></label></br>
            <label>CNPJ: <input type="text" name="cnpj"></label><br>
            <label>Email: <input type="text" name="email"></label><br>
            <label>Senha: <input type="password" name="senha"></label>
            <input type="submit" value="Cadastrar">
    </form>
</body>
</html>