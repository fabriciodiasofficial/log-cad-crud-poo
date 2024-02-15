<?php
// loja.php

require_once 'db.php';

class Loja
{
    private $id_loja;
    private $nome_loja;
    private $cnpj;
    private $email;
    private $senha;

    public function __construct($id_loja, $nome_loja, $cnpj, $email, $senha)
    {
        $this->id_loja = $id_loja;
        $this->nome_loja = $nome_loja;
        $this->cnpj = $cnpj;
        $this->email = $email;
        $this->senha = $senha;
    }

    public function getIdLoja()
    {
        return $this->id_loja;
    }

    public function getNomeLoja()
    {
        return $this->nome_loja;
    }

    public function getCnpj()
    {
        return $this->cnpj;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function editarLoja($novoNome, $novoCnpj, $novoEmail, $novaSenha, $db)
    {
        $query = "UPDATE loja SET nome_loja = :novo_nome, cnpj = :novo_cnpj, email = :novo_email, senha = :nova_senha WHERE id_loja = :id_loja";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':novo_nome', $novoNome);
        $stmt->bindParam(':novo_cnpj', $novoCnpj);
        $stmt->bindParam(':novo_email', $novoEmail);
        $stmt->bindParam(':nova_senha', $novaSenha);
        $stmt->bindParam(':id_loja', $this->id_loja);
        $stmt->execute();
    }

    public function excluirLoja($db)
    {
        $query = "DELETE FROM loja WHERE id_loja = :id_loja";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id_loja', $this->id_loja, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function getLojaById($idLoja, $db)
    {
        $query = "SELECT * FROM loja WHERE id_loja = :id_loja";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id_loja', $idLoja, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAllLojas($db)
    {
        $query = "SELECT * FROM loja";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function promoverParaAdmin($db)
    {
        $query = "UPDATE loja SET nivel_acesso = 'admin' WHERE id_loja = :id_loja";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id_loja', $this->id_loja);
        $stmt->execute();
    }

    public function despromoverParaLoja($db)
    {
        $query = "UPDATE loja SET nivel_acesso = 'loja' WHERE id_loja = :id_loja";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id_loja', $this->id_loja);
        $stmt->execute();
    }

}
?>
