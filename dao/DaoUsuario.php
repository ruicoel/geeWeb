<?php
file_exists('../models/DatabaseConnection.php') ? require_once '../models/DatabaseConnection.php' : require_once '../../models/DatabaseConnection.php';
file_exists('../models/TipoUsuario.php') ? require_once '../models/TipoUsuario.php' : require_once '../../models/TipoUsuario.php';
file_exists('../models/Usuario.php') ? require_once '../models/Usuario.php' : require_once '../../models/Usuario.php';


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
            $user->setTipo($result['tipo']);


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

    public function listar($inicio, $fim){
        try{
            $db = DatabaseConnection::conexao();
            $vetUsuario = null;
            $stmt = $db->query("SELECT * FROM gee.usuario order by id desc OFFSET ".$inicio." LIMIT ".$fim);
            foreach ($stmt as $row){
                $usuario = new Usuario;
                $usuario->setId($row["id"]);
                $usuario->setNome($row["nome"]);
                $usuario->setEmail($row["email"]);
                $usuario->setTipo($row["tipo"]);
                $vetUsuario[] = $usuario;
            }
            return $vetUsuario;
        }catch ( PDOException $ex){
            echo "Erro: ".$ex->getMessage();
        }

    }
    public function findByName($nome, $inicio, $fim){
        try{
            $db = DatabaseConnection::conexao();
            $vetUsuario = null;
            $stmt = $db->query("SELECT * FROM gee.usuario WHERE nome like '%".$nome."%' ORDER BY id DESC OFFSET ".$inicio." LIMIT ".$fim);
            foreach ($stmt as $row){
                $usuario = new Usuario;
                $usuario->setId($row["id"]);
                $usuario->setNome($row["nome"]);
                $usuario->setEmail($row["email"]);
                $usuario->setTipo($row["tipo"]);
                $vetUsuario[] = $usuario;
            }
            return $vetUsuario;
        }catch ( PDOException $ex){
            echo "Erro: ".$ex->getMessage();
        }

    }
    public function findById($id){
        try{
            $db = DatabaseConnection::conexao();
            $stmt = $db->prepare("SELECT * FROM gee.usuario WHERE id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $result =  $stmt->fetch(PDO::FETCH_ASSOC);
            $user = new Usuario;
            $user->setId($result['id']);
            $user->setNome($result['nome']);
            $user->setEmail($result['email']);
            $user->setSenha($result['senha']);
            $user->setTipo($result['tipo']);


            return $user;
        }catch ( PDOException $ex){
            echo "Erro: ".$ex->getMessage();
        }

    }
    public function excluir($id){
        try{
            $db = DatabaseConnection::conexao();
            $db->exec("DELETE FROM gee.usuario where id = " . $id);
            return true;
        }catch ( PDOException $ex ){
            echo "Erro: ".$ex->getMessage();
        }
    }

    public function alterar($usuario){
        try{
            $db = DatabaseConnection::conexao();
            $senha = $usuario->getSenha();
            if($senha!=null){
                $stmt = $db->prepare("UPDATE gee.usuario SET nome = :nome, email = :email, tipo = :tipo, senha = :senha WHERE id = :id" );
              $stmt->bindValue(":senha", $usuario->getSenha());
            }else{
                $stmt = $db->prepare("UPDATE gee.usuario SET nome = :nome, email = :email, tipo = :tipo WHERE id = :id");
            }
            $stmt->bindValue(":nome", $usuario->getNome());
            $stmt->bindValue(":email", $usuario->getEmail());
            $stmt->bindValue(":tipo", $usuario->getTipo());
            $stmt->bindValue(":id", $usuario->getId());


            $stmt->execute();
            return true;
        }catch(PDOException $ex){
            echo "Erro: ".$ex->getMessage();
        }
    }

    public function findProp($key){
        try{
            $db = DatabaseConnection::conexao();
            $vetUsuario = null;
            $stmt = $db->prepare("SELECT * FROM gee.usuario WHERE tipo = 1 AND nome LIKE :key");
            $stmt->bindParam(":key", $key);
            $stmt->execute();
            foreach ($stmt as $row){
                $usuario = new Usuario;
                $usuario->setId($row["id"]);
                $usuario->setNome($row["nome"]);
                $vetUsuario[] = $usuario;
            }
            return $vetUsuario;
        }catch ( PDOException $ex){
            echo "Erro: ".$ex->getMessage();
        }

    }

}