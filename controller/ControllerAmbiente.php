<?php
require_once "../models/Ambiente.php";
require_once "../models/Imagem.php";
require_once '../dao/DaoAmbiente.php';

$cAmbiente = new ControllerAmbiente;
class ControllerAmbiente
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

    public function processarAcao($acao)
    {

        if ($acao == "listaHtml") {
            $this->listaHtml();
        }else if($acao == 'cadastrar'){
            $this->cadastrar();
        }else if($acao == 'desativarAmbiente'){
            $this->desativarAmbiente();
        }else if($acao == 'ativarAmbiente'){
            $this->ativarAmbiente();
        }
    }

    public function listaHtml(){
        $retorno = "";
        $idLocal = $_GET["id"];
        $daoAmbiente = new DaoAmbiente();
        $vetAmbiente = $daoAmbiente->listar($idLocal);
        if(isset($vetAmbiente)){
            $retorno .= "<div class='table-responsive'><table class='table table-striped'><thead><th>Nome</th><th>Valor</th><th>Ação</th></thead><tbody>";
            foreach($vetAmbiente as $ambiente) {
                $retorno .= "<tr>";
                $retorno .= "<td class='listaNome'> ". $ambiente->getNome() ."</td>";
                $retorno .= "<td class='listaValor'> ".$ambiente->getValorFormatado()." </td>";
                $retorno .= "<td> <button type='button' class='btn btn-primary btn-sm selecionar' data-id='".$ambiente->getId()."'> <span class='glyphicon glyphicon-ok'/> Selecionar </button> </td>";
                $retorno .="</tr>";
            }
            $retorno .="</tbody></table></div>";
        }
        echo $retorno;
    }
    public function cadastrar(){
        $daoAmbiente   = new DaoAmbiente();
        $ambiente        = new Ambiente();
        $image = new Imagem();
        $ambiente-> setNome($_POST["nomeAmbiente"]);
        $ambiente-> setDescricao($_POST["descAmbiente"]);
        $ambiente-> setValor($_POST["valorAmbiente"]);
        $ambiente->setIdLocal($_POST['idLocalAmbiente']);
        $ambiente->setDivisaoHoras($_POST['divisorHoras']);
        $ambiente->setAtivo(true);
        $vetArquivos = null;
        foreach($_FILES['arquivo-ambiente']['name'] as $arquivo){
            $ext = pathInfo($arquivo, PATHINFO_EXTENSION);
            $vetArquivos[] = $ext;
        }
       /* $image->setArquivo(file_get_contents($_FILES['arquivo']['tmp_name']));
        error_log("MENSAGEM: " . $image->getArquivo(), 0);*/
        $retorno = $daoAmbiente->inserir($ambiente, $vetArquivos);
        $qtFiles = count($_FILES['arquivo-ambiente']);
        /*for($cont = 0; $cont <= $qtFiles; $cont++){
            move_uploaded_file($_FILES['arquivo-ambiente'][$cont]['tmp_name'], '/var/www/html/images/'.$retorno.'_'.$cont.'.jpg');
        }*/
        $cont = 0;
        foreach($_FILES['arquivo-ambiente']['tmp_name'] as $arquivo){
            move_uploaded_file($arquivo, '/var/www/html/images/'.$retorno.'_'.$cont.'.jpg');
            $cont++;
        }
        header('Location:/View/Pages/mLocalAmbiente.php');
    }

    public function desativarAmbiente(){
        $id = $_GET['id'];
        $daoAmbiente = new DaoAmbiente();
        $daoAmbiente->alteraStatus($id, false);
        echo true;
    }

    public function ativarAmbiente(){
        $id = $_GET['id'];
        $daoAmbiente = new DaoAmbiente();
        $daoAmbiente->alteraStatus($id, true);
        echo true;
    }
}