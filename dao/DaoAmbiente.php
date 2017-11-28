<?php
require_once "../models/Ambiente.php";
require_once '../models/DatabaseConnection.php';

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
}