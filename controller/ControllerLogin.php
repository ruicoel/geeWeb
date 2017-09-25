<?php
require_once '../models/Usuario.php';
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
        }
    }

    public function logar(){
        $this->daoUsuario = new DaoUsuario;
        $usuario = new Usuario;
        $usuario->setLogin($_POST["login"]);
        $usuario->setSenha($_POST["senha"]);

        var_dump($this->daoUsuario->findUsuario($usuario));
    }
    public function criarConta(){
        return "chegou";
    }
}