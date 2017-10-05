<?php
require_once "../models/Categoria.php";
require_once '../dao/DaoCategoria.php';

$cCategoria = new ControllerCategoria;
class ControllerCategoria
{
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

        if($acao == "lista"){
            $this->listaHtml();
        }else if($acao == "remover"){
            $this->remover();
        }else if($acao == "cadastrar"){
            $this->cadastrar();
        }else if($acao == "alterar"){
            $this->alterar();
        } else if ($acao = "listarIndex"){
            $this->listaIndex();
        }
    }

    public function listaHtml(){
        $retorno = "";
        $pag = $_GET["pag"];
        $max = $_GET["max"];
        $inicio = ($pag * $max) - $max;
        $daoCategoria = new DaoCategoria();
        $vetCategoria = $daoCategoria->listar($inicio, $max);
        if(isset($vetCategoria)){
           foreach($vetCategoria as $categoria) {
               $retorno .= "<tr>";
               $retorno .= "<td class='listaDescricao'> ". $categoria->getDescricao() ."</td>";
               $retorno .= "<td class='listaCor' data-color='".$categoria->getCor()."'> <button type='button' style='background-color:".$categoria->getCor()."; border-color:".$categoria->getCor()."; color:white;' class='btn btn-primary btn-xs'> ".$categoria->getDescricao()." </button> </td>";
               $retorno .= "<td> <button type='button' class='btn btn-primary btn-sm editar' data-id='".$categoria->getId()."'> <span class='glyphicon glyphicon-pencil'/> </button> <button type='button' class='btn btn-danger btn-sm remover' data-id='".$categoria->getId()."'> <span class='glyphicon glyphicon-remove'/> </button> </td>";
               $retorno .="</tr>";
           }
        }
        echo $retorno;
    }


    public function listaIndex(){
        $retorno = "";
        $daoCategoria = new DaoCategoria();
        $vetCategoria = $daoCategoria->listarTodos();
        if(isset($vetCategoria)){
            foreach($vetCategoria as $categoria) {
                $retorno .= "<span class='button-checkbox'>
                                <button type='button' class='btn btn-primary' data-color='primary'>". $categoria->getDescricao() ."</button>
                                <input type='checkbox' class='hidden' name='cat[]' id='cat' value='". $categoria->getId() ."'/>
                            </span>";
                //$retorno .= "<option value='". $categoria->getId() ."'>". $categoria->getDescricao(). "</option>";
            }
        }
        echo $retorno;
    }


    public function remover(){
        $id = $_GET["id"];
        $daoCategoria = new DaoCategoria();
        $daoCategoria->excluir($id);

        echo true;
    }

    public function cadastrar(){
        $daoCategoria = new DaoCategoria();
        $cat = new Categoria();
        $cat->setDescricao($_POST["descricao"]);
        $cat->setCor($_POST["cor"]);

        $retorno = $daoCategoria->inserir($cat);

        return $retorno;
    }

    public function alterar(){
        $daoCategoria = new DaoCategoria();
        $cat = new Categoria();
        $cat->setId($_POST["id"]);
        $cat->setDescricao($_POST["descricao"]);
        $cat->setCor($_POST["cor"]);

        $retorno = $daoCategoria->alterar($cat);

        echo $retorno;
    }
}