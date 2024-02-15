<!-- index.php -->
<?php
require_once 'db.php';
require_once 'Login.php';

session_start();

$db = new Database();
$login = new Login($db->getPDO());

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $dadosUsuario = $login->realizarLogin($email, $senha);

    if($dadosUsuario){
        $_SESSION['user'] = [
            'email' => $email,
            'nivel_acesso' => $dadosUsuario['nivel_acesso'],
            'id_loja' => $dadosUsuario['id_loja']
        ];

        header('Location: '. ($dadosUsuario['nivel_acesso'] === 'admin' ? 'admin_dashboard.php' : 'loja_dashboard.php'));
        exit();
    }else{
        echo "Credenciais inválidas.";
    }    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Login</title>
</head>
<body>
    <a href="cadastro_loja.php">Cadastrar</a>
    <h2>Login</h2>
    <form method="post" action="">
        <label>Email: <input type="text" name="email"></label><br>
        <label>Senha: <input type="password" name="senha"></label><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>