<?php
require_once '../models/Local.php';
require_once '../models/DatabaseConnection.php';

class DaoLocal
{
    public function inserir($local, $categorias, $image)
    {
        try {
            $db = DatabaseConnection::conexao();
            $stmt = $db->prepare("INSERT INTO gee.local (nome, descricao, ponto, privado, ativo) VALUES (:nome, :descricao, :ponto, :privado, :ativo)");
            $stmt->bindValue(":nome", $local->getNome());
            $stmt->bindValue(":descricao", $local->getDescricao());
            $stmt->bindValue(":ponto", $local->getPonto());
            $stmt->bindValue(":privado", $local->getPrivado());
            $stmt->bindValue(":ativo", true, PDO::PARAM_BOOL);

            $stmt->execute();
            $lastId = $db->lastInsertId();

            $stmtImagem = $db->prepare("INSERT INTO gee.imagem (arquivo, id_local) VALUES (:arquivo, :id_local)");
            $stmtImagem->bindValue(":arquivo", pg_escape_bytea($image->getArquivo()));
            $stmtImagem->bindValue(":id_local", $lastId);
            $stmtImagem->execute();

            foreach ($categorias as $cat){
                $stmtCatLocal = $db->prepare("INSERT INTO gee.local_categoria (id_categoria, id_local) VALUES (:categoria_id, :local_id)");
                $stmtCatLocal->bindValue(":categoria_id", $cat);
                $stmtCatLocal->bindValue(":local_id", $lastId);
                $stmtCatLocal->execute();
            }

            return true;
        } catch (PDOException $ex) {
            echo "Erro: " . $ex->getMessage();
        }
    }
}
