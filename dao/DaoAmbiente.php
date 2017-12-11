<?php
file_exists("../models/Ambiente.php") ? require_once "../models/Ambiente.php" : require_once "../../models/Ambiente.php";
file_exists('../models/DatabaseConnection.php') ? require_once '../models/DatabaseConnection.php' : require_once '../../models/DatabaseConnection.php';

class DaoAmbiente
{
    public function listar($idLocal){
        try{
            $db = DatabaseConnection::conexao();
            $vetAmbiente = null;
            $stmt = $db->prepare("SELECT a.* FROM gee.ambiente a WHERE a.id_local = :id and ativo = true");
            $stmt->bindParam(":id", $idLocal);
            $stmt->execute();
            foreach ($stmt as $row){
                $ambiente = new Ambiente;
                $ambiente->setId($row["id"]);
                $ambiente->setNome($row["nome"]);
                $ambiente->setValor($row["valor"]);
                $vetAmbiente[] = $ambiente;
            }
            return $vetAmbiente;
        }catch ( PDOException $ex){
            echo "Erro: ".$ex->getMessage();
        }

    }

    public function listarTodos($idLocal){
        try{
            $db = DatabaseConnection::conexao();
            $vetAmbiente = null;
            $stmt = $db->prepare("SELECT a.* FROM gee.ambiente a WHERE a.id_local = :id");
            $stmt->bindParam(":id", $idLocal);
            $stmt->execute();
            foreach ($stmt as $row){
                $ambiente = new Ambiente;
                $ambiente->setId($row["id"]);
                $ambiente->setNome($row["nome"]);
                $ambiente->setValor($row["valor"]);
                $ambiente->setAtivo($row["ativo"]);
                $vetAmbiente[] = $ambiente;
            }
            return $vetAmbiente;
        }catch ( PDOException $ex){
            echo "Erro: ".$ex->getMessage();
        }

    }

    public function findById($id){
        try{
            $db = DatabaseConnection::conexao();
            $query = $db->prepare("SELECT a.* FROM gee.ambiente a WHERE a.id = :id");
            $query->bindValue(':id', $id);
            $query->execute();
            $result =  $query->fetch(PDO::FETCH_ASSOC);
            $ambiente = new Ambiente();
            $ambiente->setId($result['id']);
            $ambiente->setNome($result['nome']);
            $ambiente->setDescricao($result['descricao']);
            $ambiente->setDivisaoHoras($result['divisor_horas']);
            $ambiente->setValor($result['valor']);

            return $ambiente;
        }catch ( PDOException $ex){
            echo "Erro: ".$ex->getMessage();
        }

    }

    public function inserir($ambiente, $vetArquivos){
        try{
            $db = DatabaseConnection::conexao();
            $stmt = $db->prepare("INSERT INTO gee.ambiente (nome, descricao, valor, ativo, id_local, divisor_horas) VALUES (:nome, :descricao, :valor, :ativo, :idLocal, :divisaoHoras)");
            $stmt->bindValue(":nome", $ambiente->getNome());
            $stmt->bindValue(":descricao", $ambiente->getDescricao());
            $stmt->bindValue(":valor", $ambiente->getValor());
            $stmt->bindValue(":ativo", $ambiente->getAtivo());
            $stmt->bindValue(":idLocal", $ambiente->getIdLocal());
            $stmt->bindValue(":divisaoHoras", $ambiente->getDivisaoHoras());

            $stmt->execute();
            $lastId = $db->lastInsertId();
            $cont = 0;
            foreach($vetArquivos as $arquivo){
                $stmtImagem = $db->prepare("INSERT INTO gee.imagem (arquivo, id_ambiente) VALUES (:arquivo, :id_ambiente)");
                $stmtImagem->bindValue(":arquivo", $lastId.'_'.$cont.'.'.$arquivo);
                $stmtImagem->bindValue(":id_ambiente", $lastId);
                $stmtImagem->execute();
                $cont++;
            }

            return $lastId;
        }catch (PDOException $ex){
            echo "Erro: ".$ex->getMessage();
        }
    }

    public function alteraStatus($idAmbiente, $status)
    {
        try {
            $db = DatabaseConnection::conexao();
            $stmt = $db->prepare("UPDATE gee.ambiente SET ativo = :ativo WHERE id = :id ");
            $stmt->bindValue(":ativo", $status, PDO::PARAM_BOOL);
            $stmt->bindValue(":id", $idAmbiente);

            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            echo "Erro: " . $ex->getMessage();
        }
    }
}