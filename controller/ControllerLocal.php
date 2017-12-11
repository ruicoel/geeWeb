<?php
    require_once "../models/Local.php";
    require_once "../models/Imagem.php";
    require_once "../models/LocalCategoria.php";
    require_once '../dao/DaoLocal.php';
    require_once '../dao/DaoCategoria.php';
    require_once '../dao/DaoAmbiente.php';
    require_once '../dao/DaoImagem.php';

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
        error_log("acaaao =>>>> ".$acao);
        if($acao == "cadastrar") {
            $this->cadastrar();
        }else if($acao == "lista") {
            $this->listaHtml();
        }else if($acao == "remover") {
            $this->remover();
        }else if($acao == "editar"){
            $this->editar();
        }else if($acao == "desativar"){
            $this->desativarLocal();
        }else if($acao == "findLocal"){
            $this->findLocal();
        }else if($acao == "atualizar") {
            $this->atualizar();
        }else if($acao == "detalheLocal") {
            $this->detalheLocal();
        }else if($acao == "aprovarLocal") {
            $this->aprovarLocal();
        }else if($acao == "negarLocal") {
            $this->negarLocal();
        }
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
        $ext = pathInfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);
        $image->setArquivo($ext);
        $retorno = $daoLocal->inserir($loc, $categorias, $image);
        move_uploaded_file($_FILES['arquivo']['tmp_name'], '/var/www/html/images/'.$retorno.'.'.$ext);

        return $retorno;
    }

    public function atualizar(){
        $daoLocal   = new DaoLocal();
        $loc        = new Local();
        $daoImagem = new DaoImagem();
        $image = new Imagem();
        $categorias = $_POST['cat'];
        $loc->setId($_POST['idLocal']);
        $loc        -> setNome($_POST["nomeLocal"]);
        if(isset($_POST["privado"])){
            $loc->setPrivado($_POST["privado"]);
        }else{
            error_log("nao veio privado =====>");
            $loc->setPrivado(false);
        }
        $local2 = $daoLocal->findById($loc->getId());
        $loc -> setPrivado($local2->getPrivado());
        $loc        -> setDescricao($_POST["descLocal"]);
        if(isset($_POST['nome_id'])){
            $loc->setIdUsuario($_POST['nome_id']);
        }
        /*if(isset($_FILES['arquivo'])) {
            $ext = pathInfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);
            $image->setArquivo($ext);
            error_log($ext);
            $antigaImagem = $daoImagem->findByLocal($loc->getId());
            unlink('/var/www/html/images/' . $antigaImagem->getArquivo());
            move_uploaded_file($_FILES['arquivo']['tmp_name'], '/var/www/html/images/' . $loc->getId() . '.' . $ext);
        }*/
        $retorno = $daoLocal->atualizar($loc, $categorias, $image);
        return $retorno;
    }

    public function listaHtml(){
        $retorno = "";
        $pag = $_GET["pag"];
        $max = $_GET["max"];
        $inicio = ($pag * $max) - $max;
        $daoLocal = new DaoLocal();
        session_start();
        $vetLocal = $daoLocal->listarLocalProp($_SESSION['id']);

        if(isset($vetLocal)){
            $count = 1;
            foreach($vetLocal as $local) {
                $retorno .= "<tr class='treegrid-".$count."'>";
                $retorno .= "<td class='listaNome'> ".$local->getNome()." </td>";
                $retorno .= "<td class='listaAtivo'> ". ($local->getAtivo() ? 'Ativo' : 'Inativo') ." </td>";
                $retorno .= "<td><button type='button' class='btn btn-success btn-sm addAmbiente' data-id='".$local->getId()."' > <span class='glyphicon glyphicon-plus'></span> Ambiente </button> <button type='button' class='btn btn-primary btn-sm editar' data-id='".$local->getId()."'> <span class='glyphicon glyphicon-pencil'/> </button> ";
                $local->getAtivo() ? $retorno .= "<button type='button' class='btn btn-danger btn-sm remover' data-id='".$local->getId()."'> <span class='glyphicon glyphicon-remove'/> </button> </td>" : $retorno .= "<button type='button' class='btn btn-success btn-sm ativar' data-id='".$local->getId()."'> <span class='glyphicon glyphicon-ok'/> </button> </td>";
                $retorno .="</tr>";
                $daoAmbiente = new DaoAmbiente();
                $countAmbiente = $count+1;
                $vetAmbiente = $daoAmbiente->listarTodos($local->getId());
                if(isset($vetAmbiente)) {
                    foreach ($vetAmbiente as $ambiente) {
                        $retorno .= '<tr class="treegrid-' . $countAmbiente . ' treegrid-parent-' . $count . '"><td>' . $ambiente->getNome() . '</td><td>' . $ambiente->getValorFormatado() . '</td>';
                        $retorno .= "<td><button type='button' class='btn btn-primary btn-sm mostraAgenda' data-id='" . $ambiente->getId() . "'> <span class='glyphicon glyphicon-calendar'></span> Agenda </button>";
                        $ambiente->getAtivo() ? $retorno .= " <button type='button' class='btn btn-danger btn-sm removerAmbiente' data-id='".$ambiente->getId()."'> <span class='glyphicon glyphicon-remove'/> </button> </td>" : $retorno .= " <button type='button' class='btn btn-success btn-sm ativarAmbiente' data-id='".$ambiente->getId()."'> <span class='glyphicon glyphicon-ok'/> </button> </td>";
                        $retorno .="</tr>";
                        $countAmbiente++;
                    }
                    $count = $countAmbiente + 1;
                }else{
                    $count++;
                }
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
        $daoImagem = new DaoImagem();
        $local = $daoLocal->findById($id);
        $arrayLocal = $local->jsonSerialize();
        $categoriaLocal = $daoCat->findByLocal($id);
        $vetCategoriaLocal = array();
        foreach( $categoriaLocal as $cat){
            array_push($vetCategoriaLocal, $cat->getId());
        }
        array_push($arrayLocal, $vetCategoriaLocal);
        $image = $daoImagem->findByLocal($id);
        $arrayLocal['imagem'] = 'images/'.$image->getArquivo();
        print_r(json_encode($arrayLocal));
    }

    public function findLocal(){
        header("Content-type: application/json");
        $keyword = strval($_GET['query']);
        $search_param = "%{$keyword}%";
        $daoLocal = new DaoLocal();
        error_log('SEARCH PARAM ===>>'.$search_param);
        $vetLocal = $daoLocal->findLocal($search_param);
        if (isset($vetLocal)) {
            foreach($vetLocal as $local){
                $localResult[] = array('id'=>$local->getId(), 'label'=>$local->getNome());
            }
//            error_log(json_encode((array) $vetLocal));
//            error_log('CHEGOOOU =>>>>');
           // echo json_encode((array) $vetLocal);
            print_r(json_encode($localResult));
        }
    }

    public function detalheLocal(){
        $retorno = '';
        $daoLocal = new DaoLocal();
        $daoImagem = new DaoImagem();
        $local = $daoLocal->findById($_GET['id']);
        $imagem = $daoImagem->findByLocal($local->getId());
        $retorno .= ' <div class="row">'.
                        '<div class="col-md-9">';
                    if(isset($_GET['index'])) {
                        $retorno .= '<p><img class="imagem" src="http://localhost/images/' . $imagem->getArquivo() . '"/></p>';
                    }else{
                        $retorno .= '<p><img class="imagem" src="/images/' . $imagem->getArquivo() . '"/></p>';
                    }
                $retorno.='</div>'.
                    '</div>'.
                    '<div class="row">'.
                        '<div class="col-md-6">'.
                            '<p align="center"><h3>'.$local->getNome().'<h3></p>'.
                        '</div>'.
                    '</div>'.
                    '<div class="row">'.
                        '<div class="col-md-6">'.
                            '<p>'.$local->getDescricao().'</p>'.
                        '</div>'.
                    '</div>'.
                    '<div class="row">'.
                        '<div class="col-md-9"><p>';
                           isset($_GET['index']) ?  '' :  $retorno.= '<button type="button" class="btn btn-primary editar" data-id="' . $local->getId() . '"><span class="glyphicon glyphicon-pencil"></span> Editar</button>';
        if(!$local->getAtivo()) {
           $retorno .= ' <button type="button" class="btn btn-success aprovar" data-id="' . $local->getId() . '"><span class="glyphicon glyphicon-thumbs-up"></span> Aprovar</button> <button type="button" class="btn btn-danger negar" data-id="' . $local->getId() . '"><span class="glyphicon glyphicon-thumbs-down"></span> Negar</button></p>';
        }
        $retorno .= '</p</div></div>';

        echo $retorno;
    }

    public function aprovarLocal(){
        $id = $_GET['id'];
        $daoLocal = new DaoLocal();
        $daoLocal->aprovarLocal($id);
        echo true;
    }

    public function desativarLocal(){
        $id = $_GET['id'];
        $daoLocal = new DaoLocal();
        $daoLocal->desativarLocal($id);
        echo true;
    }

    public function negarLocal(){
        $id = $_GET['id'];
        $daoLocal = new DaoLocal();
        $daoLocal->excluir($id);
        echo true;
    }
}


