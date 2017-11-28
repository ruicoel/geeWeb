<?php
require_once "../models/Agendamento.php";
require_once '../dao/DaoAgendamento.php';
require_once '../dao/DaoAmbiente.php';

$cAgendamento = new ControllerAgendamento;
class ControllerAgendamento
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
        }else if($acao == "confirmarAgendamento"){
            $this->confirmarAgendamento();
        }else if($acao == "finalizarAgendamento"){
            $this->finalizarAgendamento();
        }
    }

    public function listaHtml(){
        session_start();
        $retorno = "";
        $idAmbiente = $_POST["id"];
        $date = $_POST["data"];
        error_log($date);
        $daoAgendamento = new DaoAgendamento();
        $daoAmbiente = new DaoAmbiente();
        $ambiente = $daoAmbiente->findById($idAmbiente);
        $_SESSION['ambiente'] = new Ambiente();
        $_SESSION['ambiente'] = serialize($ambiente);
        $vetAgendamento = $daoAgendamento->listar($idAmbiente, $date);
        $retorno .= "<div class='table-responsive'><table class='table table-striped'><thead><th colspan='3'>".$ambiente->getNome()." - Valor: ".$ambiente->getValor()."</th></thead><tbody><th>Hora</th><th>Ação</th>";
        for($i = 0; $i < 24; $i++){
            $aux = 0;
            if(isset($vetAgendamento)) {
                foreach ($vetAgendamento as $agendamento) {
                    error_log("HORA INICIO =>".$agendamento->getHoraInicio());
                    if ($agendamento->getHoraInicio() == $i) {
                        $aux = 1;
                    }
                }
            }
            if($aux == 0){
                $retorno .= "<tr>";
                $retorno.= "<td class='hora'><div class='content'>".($i < 10 ? "0".$i : $i).":".$ambiente->getDivisaoHoras()." - ".($i < 9 ? "0".($i+1) : ($i+1)).":".$ambiente->getDivisaoHoras()." </div></td>";
                $retorno .= "<td> <button type='button' class='btn btn-primary btn-sm selecionarHorario' data-id-ambiente='".$ambiente->getId()."' data-hora='".$i."'> <span class='glyphicon glyphicon-ok'/> Selecionar </button> </td>";
                $retorno .= "</tr>";
            }
        }
        $retorno .="</tbody></table></div>";
        echo $retorno;
    }

    public function confirmarAgendamento()
    {
        session_start();
        $retorno = "";
        $hora = $_POST["hora"];
        $dt = new DateTime();
        $dt->format('Y-m-d H:i:s');
        $dt2 = new DateTime();
        $dt2->format('Y-m-d H:i:s');
        $ambiente = unserialize($_SESSION['ambiente']);
        $agendamento = new Agendamento();
        $dt->setTime($hora, $ambiente->getDivisaoHoras());
        $agendamento->setDataHoraInicio($dt->format('Y-m-d H:i:s'));
        $dt2->setTime(($hora+1), $ambiente->getDivisaoHoras());
        $agendamento->setDataHoraFim($dt2->format('Y-m-d H:i:s'));
        $agendamento->setIdAmbiente($ambiente->getId());
        $agendamento->setIdUsuario($_SESSION['id']);
        $_SESSION['agendamento'] = serialize($agendamento);

        $retorno .= "<div class='table-responsive'><table class='table table-striped'><thead><th colspan='2'>Confirmar Agendamento</th></thead><tbody>";
        $retorno .="<tr><td>Ambiente</td><td>".$ambiente->getNome()."</td></tr>";
        $retorno .="<tr><td>Valor</td><td>".$ambiente->getValor()."</td></tr>";
        $retorno .="<tr><td>Horário</td><td>".$dt->format('H:i')." - ".$dt2->format('H:i')."</td></tr>";
        $retorno .="<tr><td>Usuário</td><td>".$_SESSION['nome']."</td></tr></tbody>";
        $retorno .= "<tfoot><th></th><th> <button type='button' class='btn btn-success btn-sm confirmarHorario'> <span class='glyphicon glyphicon-ok'/> Confirmar </button> </th></tfoot>";
        $retorno .= "</table></div>";
        echo $retorno;
    }

    public function finalizarAgendamento(){
        session_start();
        $agendamento = unserialize($_SESSION['agendamento']);
        $daoAgendamento = new DaoAgendamento();
        $daoAgendamento->inserir($agendamento);
    }

}