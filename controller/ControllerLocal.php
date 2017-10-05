<?php
    require_once "../models/Local.php";
    require_once "../models/Imagem.php";
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
        $image = new Imagem();
        $categorias = $_POST['cat'];
        $loc        -> setNome($_POST["nomeLocal"]);
        $loc        -> setPrivado($_POST["privado"]);
        $loc        -> setDescricao($_POST["descLocal"]);
        $loc        -> setPonto($_POST["ponto"]);
        $image->setArquivo(file_get_contents($_FILES['arquivo']['tmp_name']));

        $retorno = $daoLocal->inserir($loc, $categorias, $image);

        return $retorno;
    }
}


