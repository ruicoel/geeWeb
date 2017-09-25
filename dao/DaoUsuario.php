<?php
require_once '../models/DatabaseConnection.php';
require_once '../models/TipoUsuario.php';

class DaoUsuario{
    public function findUsuario(Usuario $usuario){
        try{
            $db = DatabaseConnection::conexao();
            $query = $db->prepare("SELECT u.* FROM gee.usuario u WHERE u.login = :login and u.senha =  :senha");
            $query->bindValue(':login', $usuario->getLogin());
            $query->bindValue(':senha', $usuario->getSenha());
            $query->execute();
            $result =  $query->fetch(PDO::FETCH_ASSOC);
            $user = new Usuario;
            $user->setId($result['id']);
            $user->setNome($result['nome']);
            $user->setLogin($result['login']);
            $user->setSenha($result['senha']);
            $user->setTipo(TipoUsuario::getTipo($result['tipo']));


            return $user;
        }catch ( PDOException $ex){
            echo "Erro: ".$ex->getMessage();
        }

    }
}