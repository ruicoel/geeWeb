<?php
require_once "../models/Categoria.php";
require_once '../models/DatabaseConnection.php';

class DaoCategoria
{
    // retirei os parametros do listar e o offset e limit da query lembra d colocar dpeois
    public function listar($inicio, $fim){
        try{
            $db = DatabaseConnection::conexao();
            $vetCategoria = null;
            $stmt = $db->query("SELECT * FROM gee.categoria order by id desc OFFSET ".$inicio." LIMIT ".$fim);
            foreach ($stmt as $row){
                $categoria = new Categoria;
                $categoria->setId($row["id"]);
                $categoria->setDescricao($row["nome"]);
                $categoria->setCor($row["cor"]);
                $vetCategoria[] = $categoria;
            }
            return $vetCategoria;
        }catch ( PDOException $ex){
            echo "Erro: ".$ex->getMessage();
        }

    }

    public function findByLocal($idLocal){
        try{
            $db = DatabaseConnection::conexao();
            $vetCategoria = null;
            $stmt = $db->query("SELECT lc.* FROM gee.local_categoria lc WHERE lc.id_local = ".$idLocal);
            foreach ($stmt as $row){
                $query = $db->prepare("SELECT * FROM gee.categoria WHERE id = ".$row["id_categoria"]);
                $query->execute();
                $result =  $query->fetch(PDO::FETCH_ASSOC);
                $categoria = new Categoria;
                $categoria->setId($result["id"]);
                $categoria->setDescricao($result["nome"]);
                $categoria->setCor($result["cor"]);
                $vetCategoria[] = $categoria;
            }
            return $vetCategoria;
        }catch ( PDOException $ex){
            echo "Erro: ".$ex->getMessage();
        }

    }

    public function listarTodos(){
        try{
            $db = DatabaseConnection::conexao();
            $vetCategoria = null;
            $stmt = $db->query("SELECT * FROM gee.categoria order by id");
            foreach ($stmt as $row){
                $categoria = new Categoria;
                $categoria->setId($row["id"]);
                $categoria->setDescricao($row["nome"]);
                $categoria->setCor($row["cor"]);
                $vetCategoria[] = $categoria;
            }
            return $vetCategoria;
        }catch ( PDOException $ex){
            echo "Erro: ".$ex->getMessage();
        }

    }

    public function excluir($id){
        try{
            $db = DatabaseConnection::conexao();
            $db->exec("DELETE FROM gee.categoria where id = " . $id);
            return true;
        }catch ( PDOException $ex ){
            echo "Erro: ".$ex->getMessage();
        }
    }

    public function inserir($categoria){
        try{
            $db = DatabaseConnection::conexao();
            $stmt = $db->prepare("INSERT INTO gee.categoria (nome, cor) VALUES (:nome, :cor)");
            $stmt->bindValue(":nome", $categoria->getDescricao());
            $stmt->bindValue(":cor", $categoria->getCor());


            $stmt->execute();
            return true;
        }catch (PDOException $ex){
            echo "Erro: ".$ex->getMessage();
        }
    }

    public function alterar($categoria){
        try{
            $db = DatabaseConnection::conexao();
            $stmt = $db->prepare("UPDATE gee.categoria SET nome = :desc, cor = :cor WHERE id = :id");
            $stmt->bindParam(":desc", $categoria->getDescricao());
            $stmt->bindParam(":cor", $categoria->getCor());
            $stmt->bindParam(":id", $categoria->getId());


            $stmt->execute();
            return true;
        }catch (PDOException $ex){
            echo "Erro: ".$ex->getMessage();
        }
    }
}