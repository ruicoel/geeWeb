<?php
require_once "../models/Agendamento.php";
require_once '../models/DatabaseConnection.php';

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
            $stmt = $db->prepare("INSERT INTO gee.agendamento (data_inicio, data_fim, id_usuario, id_ambiente) VALUES (:dataInicio, :dataFim, :idUsuario, :idAmbiente)");
            $stmt->bindValue(":dataInicio", $agendamento->getDataHoraInicio());
            $stmt->bindValue(":dataFim",$agendamento->getDataHoraFim());
            $stmt->bindValue(":idUsuario", $agendamento->getIdUsuario());
            $stmt->bindValue(":idAmbiente", $agendamento->getIdAmbiente());
            $stmt->execute();
            return true;
        }catch (PDOException $ex){
            echo "Erro: ".$ex->getMessage();
        }
    }

}