<?php
require_once "../models/Imagem.php";
require_once '../models/DatabaseConnection.php';

class DaoImagem
{
    public function findByLocal($idLocal){
        try{
            $db = DatabaseConnection::conexao();
            $stmt = $db->query("SELECT i.* FROM gee.imagem i  WHERE i.id_local = ".$idLocal);
            $result =  $stmt->fetch(PDO::FETCH_ASSOC);
            $imagem = new Imagem;
            $imagem->setId($result["id"]);
            $imagem->setIdLocal($result['id_local']);
            $arquivo = $result['arquivo'];
            $imagem->setArquivo($arquivo);
            return $imagem;
        }catch ( PDOException $ex){
            echo "Erro: ".$ex->getMessage();
        }

    }
}