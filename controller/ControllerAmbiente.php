<?php
require_once "../models/Ambiente.php";
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
                $retorno .= "<td class='listaValor'> ".$ambiente->getValor()." </td>";
                $retorno .= "<td> <button type='button' class='btn btn-primary btn-sm selecionar' data-id='".$ambiente->getId()."'> <span class='glyphicon glyphicon-ok'/> Selecionar </button> </td>";
                $retorno .="</tr>";
            }
            $retorno .="</tbody></table></div>";
        }
        echo $retorno;
    }

}