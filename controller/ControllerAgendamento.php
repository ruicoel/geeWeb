<?php
require_once "../models/Agendamento.php";
require_once '../dao/DaoAgendamento.php';
require_once '../dao/DaoAmbiente.php';
require_once '../dao/DaoUsuario.php';

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
        }else if($acao == "confirmarAgendamentoProp"){
            $this->confirmarAgendamentoProprietario();
        }else if($acao == "finalizarAgendamento"){
            $this->finalizarAgendamento();
        }else if($acao == "listarAgenda"){
            $this->listarAgenda();
        }else if($acao == "mostrarAgenda"){
            $this->mostrarAgenda();
        }else if($acao == "remover"){
            $this->remover();
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
        $_SESSION['ambiente'] = serialize($ambiente);
        $vetAgendamento = $daoAgendamento->listar($idAmbiente, $date);
        $retorno .= "<div class='table-responsive'><table class='table table-striped'><thead><th colspan='3'>".$ambiente->getNome()." - Valor: ".$ambiente->getValorFormatado()."</th></thead><tbody><th>Hora</th><th>Ação</th>";
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

    public function confirmarAgendamentoProprietario()
    {
        session_start();
        $retorno = "";
        $hora = $_GET["hora"];
        $data = $_GET["data"];
        $dt = DateTime::createFromFormat('Y-m-d', $_SESSION['dataPesquisa']);
        $dt2 = DateTime::createFromFormat('Y-m-d', $_SESSION['dataPesquisa']);
        $data == 'data1' ? $dt->sub(new DateInterval('P1D')) : null;
        $ambiente = unserialize($_SESSION['ambiente']);
        $agendamento = new Agendamento();
        $dt->setTime($hora, $ambiente->getDivisaoHoras());
        $hora++;
        $dt2->setTime($hora, $ambiente->getDivisaoHoras());
        $agendamento->setDataHoraInicio($dt->format('Y-m-d H:i:s'));
        $agendamento->setDataHoraFim($dt->add(new DateInterval('PT1H'))->format('Y-m-d H:i:s'));
        $agendamento->setIdAmbiente($ambiente->getId());
        $_SESSION['agendamento'] = serialize($agendamento);

        $retorno .= "<table class='table table-striped table-confirmar'><thead><th colspan='2'>Confirmar Agendamento</th></thead><tbody>";
        $retorno .="<tr><td>Ambiente</td><td>".$ambiente->getNome()."</td></tr>";
        $retorno .="<tr><td>Valor</td><td>".$ambiente->getValorFormatado()."</td></tr>";
        $retorno .="<tr><td>Horário</td><td>".$dt->format('H:i')." - ".$dt2->format('H:i')."</td></tr>";
        $retorno .="<tr><td>Usuário</td><td><div class='col-xs-8'><input class='form-control' name='nome' type='text'></div></td></tr></tbody>";
        $retorno .= "<tfoot><th></th><th> <button type='button' class='btn btn-success btn-sm confirmarHorario'> <span class='glyphicon glyphicon-ok'/> Confirmar </button> </th></tfoot>";
        $retorno .= "</table>";
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
        $retorno .="<tr><td>Valor</td><td>".$ambiente->getValorFormatado()."</td></tr>";
        $retorno .="<tr><td>Horário</td><td>".$dt->format('H:i')." - ".$dt2->format('H:i')."</td></tr>";
        $retorno .="<tr><td>Usuário</td><td>".$_SESSION['nome']."</td></tr></tbody>";
        $retorno .= "<tfoot><th></th><th> <button type='button' class='btn btn-success btn-sm confirmarHorario'> <span class='glyphicon glyphicon-ok'/> Confirmar </button> </th></tfoot>";
        $retorno .= "</table></div>";
        echo $retorno;
    }

    public function finalizarAgendamento(){
        session_start();
        $agendamento = unserialize($_SESSION['agendamento']);
        isset($_GET['nome']) ? $agendamento->setNomeUsuario($_GET['nome']) : null;
        $daoAgendamento = new DaoAgendamento();
        $daoAgendamento->inserir($agendamento);
        unset($_SESSION['agendamento']);
    }

    public function listarAgenda(){
        session_start();
        $date = $_GET['data1'];
        $date = DateTime::createFromFormat('d/m/Y', $date);
        $retorno = '';
        $daoAgendamento = new DaoAgendamento();
        $daoAmbiente = new DaoAmbiente();
        $daoUsuario = new DaoUsuario();
        $ambiente = unserialize($_SESSION['ambiente']);
        //$ambiente = $daoAmbiente->findById(1);
        $vetAgendamento = $daoAgendamento->listar($ambiente->getId(), $date->format('Y-m-d'));
        $date->add(new DateInterval('P1D'));
        $_SESSION['dataPesquisa'] = $date->format('Y-m-d');

        $vetAgendamentoNextDay = $daoAgendamento->listar($ambiente->getId(), $date->format('Y-m-d'));
        for($i = 0; $i < 24; $i++){
            $aux = 0;
            $auxNext = 0;
            if(isset($vetAgendamento)) {
                foreach ($vetAgendamento as $agendamento) {
                    if ($agendamento->getHoraInicio() == $i) {
                        $agendamento->getIdUsuario() != null ? $usuario = $daoUsuario->findById($agendamento->getIdUsuario()) : $usuario = null;
                        $retorno .= "<tr>";
                        $retorno.= "<td class='hora danger'><div class='content'>".($i < 10 ? "0".$i : $i).":".$ambiente->getDivisaoHoras()." - ".($i < 9 ? "0".($i+1) : ($i+1)).":".$ambiente->getDivisaoHoras()." </div></td>";
                        $retorno .= "<td  class='danger'> ". (is_null($usuario) ? $agendamento->getNomeUsuario() : $usuario->getNome()) ."</td>";
                        $retorno .= "<td  class='danger'> <button type='button' class='btn btn-success btn-sm disabled'> <span class='glyphicon glyphicon-ok'/> Reservado </button> <button type='button' class='btn btn-danger btn-sm  btn-cancelar' data-id='".$agendamento->getId()."'> <span class='glyphicon glyphicon-remove'/> Cancelar </button></td>";
                        //$retorno .= "</tr>";
                        $aux = 1;
                    }
                }
            }
            if($aux == 0){
                $retorno .= "<tr>";
                $retorno.= "<td class='hora success'><div class='content'>".($i < 10 ? "0".$i : $i).":".$ambiente->getDivisaoHoras()." - ".($i < 9 ? "0".($i+1) : ($i+1)).":".$ambiente->getDivisaoHoras()." </div></td>";
                $retorno .= "<td  class='success'> Livre </td>";
                $retorno .= "<td  class='success'> <button type='button' class='btn btn-primary btn-sm selecionarHorario'  data-dia='data1' data-hora='".$i."'> <span class='glyphicon glyphicon-plus'/> Selecionar </button> </td>";
                //$retorno .= "</tr>";
            }

            if(isset($vetAgendamentoNextDay)) {
                foreach ($vetAgendamentoNextDay as $agendamento) {
                    if ($agendamento->getHoraInicio() == $i) {
                        $agendamento->getIdUsuario() != null ? $usuario = $daoUsuario->findById($agendamento->getIdUsuario()) : $usuario = null;
                        //$retorno .= "<tr class='danger'>";
                        $retorno.= "<td class='hora danger'><div class='content'>".($i < 10 ? "0".$i : $i).":".$ambiente->getDivisaoHoras()." - ".($i < 9 ? "0".($i+1) : ($i+1)).":".$ambiente->getDivisaoHoras()." </div></td>";
                        $retorno .= "<td class='danger'> ". (is_null($usuario) ? $agendamento->getNomeUsuario() : $usuario->getNome())."</td>";
                        $retorno .= "<td class='danger'> <button type='button' class='btn btn-success btn-sm disabled'> <span class='glyphicon glyphicon-ok'/> Reservado </button> <button type='button' class='btn btn-danger btn-sm  btn-cancelar' data-id='".$agendamento->getId()."'> <span class='glyphicon glyphicon-remove'/> Cancelar </button></td>";
                        $retorno .= "</tr>";
                        $auxNext = 1;
                    }
                }
            }
            if($auxNext == 0){
                //$retorno .= "<tr class='success'>";
                $retorno.= "<td class='hora success'><div class='content'>".($i < 10 ? "0".$i : $i).":".$ambiente->getDivisaoHoras()." - ".($i < 9 ? "0".($i+1) : ($i+1)).":".$ambiente->getDivisaoHoras()." </div></td>";
                $retorno .= "<td class='success'> Livre </td>";
                $retorno .= "<td class='success'> <button type='button' class='btn btn-primary btn-sm selecionarHorario'  data-dia='data2' data-hora='".$i."'> <span class='glyphicon glyphicon-plus'/> Selecionar </button> </td>";
                $retorno .= "</tr>";
            }
        }

        echo $retorno;
    }
    public function remover(){
        $id = $_GET["id"];
        $daoAgendamento = new DaoAgendamento();
        $daoAgendamento->excluir($id);

        echo true;
    }
    public function mostrarAgenda(){
        session_start();
        $id = $_GET['id'];
        $daoAmbiente = new DaoAmbiente();
        $ambiente = $daoAmbiente->findById($id);
        $_SESSION['ambiente'] = serialize($ambiente);
        echo 'mAgenda.php';
    }

}