<!-- Produto.php -->
<?php

require_once 'db.php';

class Produto
{
    private $id_prod;
    private $nome_prod;
    private $preco_prod;
    private $id_loja;

    public function __construct($id_prod, $nome_prod, $preco_prod, $id_loja)
    {
        $this->id_prod = $id_prod;
        $this->nome_prod = $nome_prod;
        $this->preco_prod = $preco_prod;
        $this->id_loja = $id_loja;
    }

    //Getter methods if needed

    //Example getter for id_prod
    public function getIdProd()
    {
        return $this->id_prod;
    }

    //Other getter methods for nome_prod, preco_prod, and id_loja can be added similarly

    //Método para editar um produto
    public static function editarProduto($idProduto, $novoNome, $novoPreco, $db)
    {
        $query = "UPDATE produtos SET nome_prod = :novo_nome, preco_prod = :novo_preco WHERE id_prod = :id_produto";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':novo_nome', $novoNome);
        $stmt->bindParam(':novo_preco', $novoPreco);
        $stmt->bindParam(':id_produto', $idProduto);
        $stmt->execute();
    }

    //Método estático para obter um produto pelo Id
    public static function getProdutoById($idProduto, $db)
    {
        $query = "SELECT * FROM produtos WHERE id_prod = :id_produto";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id_produto', $idProduto, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Método para adicionar um novo produto
    public static function adicionarProduto($nomeProduto, $precoProduto, $idLoja, $db)
    {
        //Adicionar lógica de validação se necessário

        $query = "INSERT INTO produtos (nome_prod, preco_prod, id_loja) VALUES (:nome_produto, :preco_produto, :id_loja)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':nome_produto', $nomeProduto);
        $stmt->bindParam(':preco_produto', $precoProduto);
        $stmt->bindParam(':id_loja', $idLoja);
        $stmt->execute();
    }

    //Método para deletar um produto
    public function deletarProduto($db)
    {
        $query = "DELETE FROM produtos WHERE id_prod = :id_produto AND id_loja = :id_loja";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id_produto', $this->id_prod);
        $stmt->bindParam(':id_loja', $this->id_loja);
        $stmt->execute();
    }

    //Método estático para obter todos os produtos de uma loja
    public static function getProdutosByLoja($idLoja, $db)
    {
        $query = "SELECT * FROM produtos WHERE id_loja = :id_loja";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id_loja', $idLoja, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}