<?php
require_once '../models/DatabaseConnection.php';
require_once '../models/TipoUsuario.php';

class DaoUsuario{
    public function findUsuario(Usuario $usuario){
        try{
            $db = DatabaseConnection::conexao();
            $query = $db->prepare("SELECT u.* FROM gee.usuario u WHERE u.email = :email and u.senha =  :senha");
            $query->bindValue(':email', $usuario->getEmail());
            $query->bindValue(':senha', $usuario->getSenha());
            $query->execute();
            $result =  $query->fetch(PDO::FETCH_ASSOC);
            $user = new Usuario;
            $user->setId($result['id']);
            $user->setNome($result['nome']);
            $user->setEmail($result['email']);
            $user->setSenha($result['senha']);
            $user->setTipo(TipoUsuario::getTipo($result['tipo']));


            return $user;
        }catch ( PDOException $ex){
            echo "Erro: ".$ex->getMessage();
        }

    }

    public function inserir($usuario){
        try{
            $db = DatabaseConnection::conexao();
            $stmt = $db->prepare("INSERT INTO gee.usuario (nome, email, senha, tipo) VALUES (:nome, :email, :senha, :tipo)");
            $stmt->bindValue(":nome", $usuario->getNome());
            $stmt->bindValue(":email", $usuario->getEmail());
            $stmt->bindValue(":senha", $usuario->getSenha());
            $stmt->bindValue(":tipo", $usuario->getTipo());


            $stmt->execute();
            return true;
        }catch (PDOException $ex){
            echo "Erro: ".$ex->getMessage();
        }
    }
}