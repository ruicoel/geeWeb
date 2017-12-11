<?php
file_exists("../models/Agendamento.php") ? require_once "../models/Agendamento.php" : require_once "../../models/Agendamento.php";
file_exists('../models/DatabaseConnection.php') ? require_once '../models/DatabaseConnection.php' : require_once '../../models/DatabaseConnection.php';

class DaoAgendamento
{
    public function listar($idAmbiente, $date){
        try{
            $db = DatabaseConnection::conexao();
            $vetAgendamento = null;
            $stmt = $db->prepare("SELECT a.* FROM gee.agendamento a WHERE a.id_ambiente = :id and a.data_inicio::date  = :data ");
            $stmt->bindParam(":id", $idAmbiente);
            $stmt->bindParam(":data", $date);
            $stmt->execute();
            foreach ($stmt as $row){
                $agendamento = new Agendamento();
                $agendamento->setId($row["id"]);
                $agendamento->setDataHoraInicio($row["data_inicio"]);
                $agendamento->setDataHoraFim($row["data_fim"]);
                $agendamento->setIdUsuario($row["id_usuario"]);
                $agendamento->setIdAmbiente($row["id_ambiente"]);
                $agendamento->setNomeUsuario($row["nome_usuario"]);
                $vetAgendamento[] = $agendamento;
            }
            return $vetAgendamento;
        }catch ( PDOException $ex){
            //echo "Erro: ".$ex->getMessage();
        }

    }

    public function inserir($agendamento){
        try{
            $db = DatabaseConnection::conexao();
            $stmt = $db->prepare("INSERT INTO gee.agendamento (data_inicio, data_fim, id_usuario, id_ambiente, nome_usuario) VALUES (:dataInicio, :dataFim, :idUsuario, :idAmbiente, :nomeUsuario)");
            $stmt->bindValue(":dataInicio", $agendamento->getDataHoraInicio());
            $stmt->bindValue(":dataFim",$agendamento->getDataHoraFim());
            $stmt->bindValue(":idUsuario", $agendamento->getIdUsuario() != null ? $agendamento->getIdUsuario() : null);
            $stmt->bindValue(":nomeUsuario", $agendamento->getNomeUsuario() != null ? $agendamento->getNomeUsuario() : null);
            $stmt->bindValue(":idAmbiente", $agendamento->getIdAmbiente());
            $stmt->execute();
            return true;
        }catch (PDOException $ex){
            echo "Erro: ".$ex->getMessage();
        }
    }

    public function excluir($id){
        try{
            $db = DatabaseConnection::conexao();
            $db->exec("DELETE FROM gee.agendamento where id = " . $id);
            return true;
        }catch ( PDOException $ex ){
            echo "Erro: ".$ex->getMessage();
        }
    }

}