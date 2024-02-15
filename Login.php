<!-- Login.php -->
<?php
class Login
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function realizarLogin($email, $senha)
    {
        $stmt = $this->db->prepare('SELECT * FROM loja WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($senha, $user['senha'])){
            return [
                'nivel_acesso' => $user['nivel_acesso'],
                'id_loja' => $user['id_loja']
            ];
        }
        return false;
    }
}
?>