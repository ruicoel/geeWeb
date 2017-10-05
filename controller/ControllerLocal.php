<?php
    require_once "../models/Local.php";
    require_once "../models/LocalCategoria.php";
    require_once '../dao/DaoLocal.php';

$local = new ControllerLocal;

class ControllerLocal
{
    function __construct() {
        if(isset($_POST["acao"])){
            $acao = $_POST["acao"];
        }else{
            $acao = $_GET["acao"];
        }

        if(isset($acao)){
            $this->processarAcao($acao);
        }
    }


    public function processarAcao($acao){
        if($acao == "cadastrar") {
            $this->cadastrar();
        }

//        if($acao == "lista"){
//            $this->listaHtml();
//        }else if($acao == "remover"){
//            $this->remover();
//        }else if($acao == "cadastrar"){
//            $this->cadastrar();
//        }else if($acao == "alterar"){
//            $this->alterar();
//        } else if ($acao = "listarIndex"){
//            $this->listaIndex();
//        }
    }


    public function cadastrar(){
        $daoLocal   = new DaoLocal();
        $loc        = new Local();
        $catLocal   = new LocalCategoria();

        $loc        -> setNome($_GET["nome"]);
        $catLocal   -> setIdCategoria($_GET["categoria"]);
        $loc        -> setDescricao($_GET["descricao"]);
        $loc        -> setPonto($_GET["ponto"]);

        $retorno = $daoLocal->inserir($loc, $catLocal);

        return $retorno;
    }
}


