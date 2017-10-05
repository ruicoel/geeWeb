<?php
require_once '../models/Local.php';
require_once '../models/DatabaseConnection.php';

class DaoLocal
{
    public function inserir($local, $categoriaLocal)
    {
        try {
            $db = DatabaseConnection::conexao();
            $stmt = $db->prepare("INSERT INTO gee.local (nome, descricao, ponto) VALUES (:nome, :descricao, :ponto)");
            $stmt->bindValue(":nome", $local->getNome());
            $stmt->bindValue(":descricao", $local->getDescricao());
            $stmt->bindValue(":ponto", $local->getPonto());

            $stmt->execute();
            $lastId = $db->lastInsertId();

            foreach ($categoriaLocal->getIdCategoria() as $catId){
                $stmtCatLocal = $db->prepare("INSERT INTO gee.categoria_local (categoria_id, local_id) VALUES (:categoria_id, :local_id)");
                $stmtCatLocal->bindValue(":categoria_id", $catId);
                $stmtCatLocal->bindValue(":local_id", $lastId);
                $stmtCatLocal->execute();
            }

            return true;
        } catch (PDOException $ex) {
            echo "Erro: " . $ex->getMessage();
        }
    }
}
