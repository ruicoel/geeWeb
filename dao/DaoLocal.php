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
            $stmt->bindValue(":privado", $local->getPrivado(), PDO::PARAM_BOOL);
            $stmt->bindValue(":ativo", false, PDO::PARAM_BOOL);

            $stmt->execute();
            $lastId = $db->lastInsertId();

            $stmtImagem = $db->prepare("INSERT INTO gee.imagem (arquivo, id_local) VALUES (:arquivo, :id_local)");
            $arquivo = $lastId.'.'.$image->getArquivo();
            $stmtImagem->bindValue(":arquivo", $arquivo);
            $stmtImagem->bindValue(":id_local", $lastId);
            $stmtImagem->execute();

            foreach ($categorias as $cat){
                $stmtCatLocal = $db->prepare("INSERT INTO gee.local_categoria (id_categoria, id_local) VALUES (:categoria_id, :local_id)");
                $stmtCatLocal->bindValue(":categoria_id", $cat);
                $stmtCatLocal->bindValue(":local_id", $lastId);
                $stmtCatLocal->execute();
            }

            return $lastId;
        } catch (PDOException $ex) {
            echo "Erro: " . $ex->getMessage();
        }
    }

    public function atualizar(Local $local, $categorias, $image)
    {
        try {
            $db = DatabaseConnection::conexao();
            $stmt = $db->prepare("UPDATE gee.local SET nome = :nome, descricao = :descricao, privado = :privado WHERE id = :id ");
            if($local->getIdUsuario() != null){
                error_log("SETADOOO =>>>>>>>>>>>>>>>>>>>>>>");
                $stmt = $db->prepare("UPDATE gee.local SET nome = :nome, descricao = :descricao, privado = :privado, id_usuario = :idUsuario WHERE id = :id ");
            }else{
                $stmt = $db->prepare("UPDATE gee.local SET nome = :nome, descricao = :descricao, privado = :privado WHERE id = :id ");
            }
            $stmt->bindValue(":nome", $local->getNome());
            $stmt->bindValue(":descricao", $local->getDescricao());
            $stmt->bindValue(":privado", $local->getPrivado(), PDO::PARAM_BOOL);
            $stmt->bindValue(":id", $local->getId());
            if($local->getIdUsuario() != null){ $stmt->bindValue(":idUsuario", $local->getIdUsuario());}
            $stmt->execute();

           /* $stmtImagem = $db->prepare("UPDATE gee.imagem SET  arquivo = :arquivo WHERE id_local = :id");
            $arquivo = $local->getId().'.'.$image->getArquivo();
            $stmtImagem->bindValue(":arquivo", $arquivo);
            $stmtImagem->bindValue(":id_local", $local->getId());
            $stmtImagem->execute();*/

            $stmtCat = $db->exec('DELETE FROM gee.local_categoria WHERE id_local = '.$local->getId());
            foreach ($categorias as $cat){
                $stmtCatLocal = $db->prepare("INSERT INTO gee.local_categoria (id_categoria, id_local) VALUES (:categoria_id, :local_id)");
                $stmtCatLocal->bindValue(":categoria_id", $cat);
                $stmtCatLocal->bindValue(":local_id", $local->getId());
                $stmtCatLocal->execute();
            }

            return $local->getId();
        } catch (PDOException $ex) {
            echo "Erro: " . $ex->getMessage();
        }
    }

    public function aprovarLocal($idLocal)
    {
        try {
            $db = DatabaseConnection::conexao();
            $stmt = $db->prepare("UPDATE gee.local SET ativo = :ativo WHERE id = :id ");
            $stmt->bindValue(":ativo", true, PDO::PARAM_BOOL);
            $stmt->bindValue(":id", $idLocal);

            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            echo "Erro: " . $ex->getMessage();
        }
    }

    public function desativarLocal($idLocal)
    {
        try {
            $db = DatabaseConnection::conexao();
            $stmt = $db->prepare("UPDATE gee.local SET ativo = :ativo WHERE id = :id ");
            $stmt->bindValue(":ativo", false, PDO::PARAM_BOOL);
            $stmt->bindValue(":id", $idLocal);

            $stmt->execute();

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

    public function listarLocalProp($id){
        try{
            $db = DatabaseConnection::conexao();
            $vetLocal = null;
            $stmt = $db->query("SELECT * FROM gee.local WHERE id_usuario = ".$id);
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

    public function findLocal($key){
        try{
            $db = DatabaseConnection::conexao();
            $vetLocal = null;
            $stmt = $db->prepare("SELECT * FROM gee.local WHERE ativo = true AND nome LIKE :key");
            $stmt->bindParam(":key", $key);
            $stmt->execute();
            foreach ($stmt as $row){
                $local = new Local;
                $local->setId($row["id"]);
                $local->setNome($row["nome"]);
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
