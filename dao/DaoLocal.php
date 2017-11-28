<?php
require_once '../models/Local.php';
require_once '../models/DatabaseConnection.php';

class DaoLocal
{
    public function inserir($local, $categorias,Imagem $image)
    {
        try {
            $db = DatabaseConnection::conexao();
            $stmt = $db->prepare("INSERT INTO gee.local (nome, descricao, ponto, privado, ativo) VALUES (:nome, :descricao, :ponto, :privado, :ativo)");
            $stmt->bindValue(":nome", $local->getNome());
            $stmt->bindValue(":descricao", $local->getDescricao());
            $stmt->bindValue(":ponto", $local->getPonto());
            $stmt->bindValue(":privado", $local->getPrivado(), PDO::PARAM_BOOL);
            $stmt->bindValue(":ativo", true, PDO::PARAM_BOOL);

            $stmt->execute();
            $lastId = $db->lastInsertId();

            /*$stmtImagem = $db->prepare("INSERT INTO gee.imagem (arquivo, id_local) VALUES (pg_escape_bytea($image->getArquivo()), $lastId)");
            //$stmtImagem->bindValue(":arquivo", pg_escape_bytea($image->getArquivo()));
            //$stmtImagem->bindValue(":id_local", $lastId);
            $stmtImagem->execute();*/

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

    public function listar($inicio, $fim){
        try{
            $db = DatabaseConnection::conexao();
            $vetLocal = null;
            $stmt = $db->query("SELECT * FROM gee.local order by id desc OFFSET ".$inicio." LIMIT ".$fim);
            foreach ($stmt as $row){
                $local = new Local;
                $local->setId($row["id"]);
                $local->setNome($row["nome"]);
                $local->setAtivo($row["ativo"]);
                $vetLocal[] = $local;
            }
            return $vetLocal;
        }catch ( PDOException $ex){
            echo "Erro: ".$ex->getMessage();
        }

    }

    public function excluir($id){
        try{
            $db = DatabaseConnection::conexao();
            $db->exec("DELETE FROM gee.local_categoria where id_local = " . $id);
            $db->exec("DELETE FROM gee.imagem where id_local = " . $id);
            $db->exec("DELETE FROM gee.local where id = " . $id);
            return true;
        }catch ( PDOException $ex ){
            echo "Erro: ".$ex->getMessage();
        }
    }

    public function findById($id){
        try{
            $db = DatabaseConnection::conexao();
            $query = $db->prepare("SELECT l.* FROM gee.local l WHERE l.id = :id");
            $query->bindValue(':id', $id);
            $query->execute();
            $result =  $query->fetch(PDO::FETCH_ASSOC);
            $local = new Local;
            $local->setId($result['id']);
            $local->setNome($result['nome']);
            $local->setDescricao($result['descricao']);
            $local->setPrivado($result['privado']);
            $local->setAtivo($result['ativo']);
            $local->setPonto($result['ponto']);

            return $local;
        }catch ( PDOException $ex){
            echo "Erro: ".$ex->getMessage();
        }

    }
}
