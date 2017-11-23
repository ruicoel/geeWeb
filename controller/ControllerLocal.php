<?php
    require_once "../models/Local.php";
    require_once "../models/Imagem.php";
    require_once "../models/LocalCategoria.php";
    require_once '../dao/DaoLocal.php';
    require_once '../dao/DaoCategoria.php';

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
        }else if($acao == "lista") {
            $this->listaHtml();
        }else if($acao == "remover") {
            $this->remover();
        }else if($acao = "editar"){
            $this->editar();
        }
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
        if(isset($_POST["privado"])){
            $loc->setPrivado($_POST["privado"]);
        }else{
            $loc->setPrivado(false);
        }
        $loc        -> setDescricao($_POST["descLocal"]);
        $loc        -> setPonto($_POST["ponto"]);
        $image->setArquivo(file_get_contents($_FILES['arquivo']['tmp_name']));
        error_log("MENSAGEM: " . $image->getArquivo(), 0);
        $retorno = $daoLocal->inserir($loc, $categorias, $image);

        return $retorno;
    }

    public function listaHtml(){
        $retorno = "";
        $pag = $_GET["pag"];
        $max = $_GET["max"];
        $inicio = ($pag * $max) - $max;
        $daoLocal = new DaoLocal();
        $vetLocal = $daoLocal->listar($inicio, $max);

        if(isset($vetLocal)){
            foreach($vetLocal as $local) {
                $retorno .= "<tr>";
                $retorno .= "<td class='listaNome'> ".$local->getNome()." </td>";
                $retorno .= "<td class='listaAtivo'> ". ($local->getAtivo() ? 'Ativo' : 'Inativo') ." </td>";
                $retorno .= "<td><button type='button' class='btn btn-success btn-sm addAmbiente' data-id='".$local->getId()."'> <span class='glyphicon glyphicon-plus'></span> Ambiente </button> <button type='button' class='btn btn-primary btn-sm editar' data-id='".$local->getId()."'> <span class='glyphicon glyphicon-pencil'/> </button> <button type='button' class='btn btn-danger btn-sm remover' data-id='".$local->getId()."'> <span class='glyphicon glyphicon-remove'/> </button> </td>";
                $retorno .="</tr>";
            }
        }else{
            $retorno = false;
        }
        echo $retorno;
    }

    public function remover(){
        $id = $_GET["id"];
        $daoLocal = new DaoLocal();
        $daoLocal->excluir($id);

        echo true;
    }

    public function editar(){
        $id = $_GET["id"];
        $daoLocal = new DaoLocal();
        $daoCat = new DaoCategoria();
        $local = $daoLocal->findById($id);
        $arrayLocal = $local->jsonSerialize();
        $categoriaLocal = $daoCat->findByLocal($id);
        $vetCategoriaLocal = array();
        foreach( $categoriaLocal as $cat){
            array_push($vetCategoriaLocal, $cat->getId());
        }
        array_push($arrayLocal, $vetCategoriaLocal);
        print_r(json_encode($arrayLocal));
    }
}


