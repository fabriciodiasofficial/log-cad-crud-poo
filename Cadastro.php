<!-- Cadastro.php -->
<?php
class Cadastro
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function cadastrarLoja($nome_loja, $cnpj, $email, $senha)
    {
        //Verificar se o e-mail á está em uso
        $stmt = $this->db->prepare('SELECT id_loja FROM loja WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if($stmt->fetch(PDO::FETCH_ASSOC)){
            return false; //E-mail já cadastrado
        }

        //Criar heash da senha
        $hash_senha = password_hash($senha, PASSWORD_DEFAULT);

        //inserir novo usuário na tabela
        $stmt = $this->db->prepare('INSERT INTO loja (nome_loja, cnpj, email, senha, nivel_acesso) 
        VALUES(:nome_loja, :cnpj, :email, :senha, :nivel_acesso)');
        $nivel_acesso = 'loja'; //Pode ajustar conforme necessário
        $stmt->bindParam(':nome_loja', $nome_loja);
        $stmt->bindParam(':cnpj', $cnpj);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $hash_senha);
        $stmt->bindParam(':nivel_acesso', $nivel_acesso);
        $stmt->execute();

        return true;
    }
}
?>