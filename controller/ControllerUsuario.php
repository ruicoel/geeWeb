<?php
require_once '../models/Usuario.php';
require_once '../models/TipoUsuario.php';
require_once '../dao/DaoUsuario.php';

$cUsuario = new ControllerUsuario;

class ControllerUsuario
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

        if($acao == "listar"){
            $this->listaHtml();
        }else if($acao == "remover"){
            $this->remover();
        }else if($acao == "alterar"){
            $this->alterar();
        }
    }

    public function listaHtml(){
        $retorno = "";
        $pag = $_GET["pag"];
        $max = $_GET["max"];
        $inicio = ($pag * $max) - $max;
       $this->daoUsuario = new DaoUsuario();
        if(isset($_GET["nome"])){
            $vetUsuario = $this->daoUsuario->findByName($_GET["nome"], $inicio, $max);
        }else{
            $vetUsuario = $this->daoUsuario->listar($inicio, $max);
        }

        if(isset($vetUsuario)){
            foreach($vetUsuario as $usuario) {
                $retorno .= "<tr>";
                $retorno .= "<td class='listaNome'> ". $usuario->getNome() ."</td>";
                $retorno .= "<td class='listaEmail'> ".$usuario->getEmail()." </td>";
                $retorno .= "<td class='listaTipo' data-tipo='".$usuario->getTipo()."'> ".TipoUsuario::getTipo($usuario->getTipo())." </td>";
                $retorno .= "<td> <button type='button' class='btn btn-primary btn-sm editar' data-id='".$usuario->getId()."'> <span class='glyphicon glyphicon-pencil'/> </button> <button type='button' class='btn btn-danger btn-sm remover' data-id='".$usuario->getId()."'> <span class='glyphicon glyphicon-remove'/> </button> </td>";
                $retorno .="</tr>";
            }
        }else{
            $retorno = false;
        }
        echo $retorno;
    }

    public function remover(){
        $id = $_GET["id"];
        $this->daoUsuario = new DaoUsuario();
        $this->daoUsuario->excluir($id);

        echo true;
    }

    public function alterar(){
        $this->daoUsuario = new DaoUsuario;
        $usuario = new Usuario;
        $usuario->setNome($_POST["nome"]);
        $usuario->setEmail($_POST["email"]);
        if(isset($_POST["senha"])) {
            $usuario->setSenha(md5($_POST["senha"]));
        }
        $usuario->setTipo($_POST["tipo"]);
        $usuario->setId($_POST["id"]);

        $retorno = $this->daoUsuario->alterar($usuario);

        print_r($retorno);
    }


}