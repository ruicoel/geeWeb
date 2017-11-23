<?php
require_once '../models/Usuario.php';
require_once '../models/TipoUsuario.php';
require_once '../dao/DaoUsuario.php';

$cLogin = new ControllerLogin;

class ControllerLogin
{
    private $daoUsuario;
    function __construct() {
        if(isset($_POST["acao"])){
            $acao = $_POST["acao"];
        }else{
            $acao = $_GET["acao"];
        }

        if(isset($acao)){
            $this->processarAcao($acao);
        }else{

        }
    }

    public function processarAcao($acao){

        if($acao == "logar"){
            $this->logar();
        }else if($acao == "criarConta"){
            $this->criarConta();
        }else if($acao == "logout"){
            $this->logout();
        }
    }

    public function logar(){
        $this->daoUsuario = new DaoUsuario;
        $usuario = new Usuario;
        $usuario->setEmail($_POST["login"]);
        $usuario->setSenha(md5($_POST["senha"]));

        $usuario = $this->daoUsuario->findUsuario($usuario);
        if($usuario->getId() != null){
            if(!isset($_SESSION)){
                session_start();
                $_SESSION['email'] = $usuario->getEmail();
                $_SESSION['nome'] = $usuario->getNome();
                $_SESSION['senha'] = $usuario->getSenha();
                $_SESSION['tipo'] = $usuario->getTipo();
            }
            /*if($usuario->getTipo() == TipoUsuario::MODERADOR) {
                print_r('/View/Pages/home.php');
            }else if($usuario->getTipo() == TipoUsuario::COMUM){
                print_r('/View/Pages/index.php');
            }*/
            print_r($usuario->getTipo());
        }else{
            print_r(false);
        }
    }
    public function criarConta(){
        $this->daoUsuario = new DaoUsuario;
        $usuario = new Usuario;
        $usuario->setNome($_POST["nome"]);
        $usuario->setEmail($_POST["email"]);
        $usuario->setSenha(md5($_POST["senha"]));
        $usuario->setTipo(TipoUsuario::COMUM);

        $retorno = $this->daoUsuario->inserir($usuario);

        return $retorno;
    }

    public function logout(){
        session_start();
        session_destroy();
        header('Location:../View/Pages/index.php');
    }
}