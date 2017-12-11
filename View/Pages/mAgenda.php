<!doctype html>
<html lang="en">
<head>
    <title>Categorias</title>
    <?php include_once "head.php"; ?>
    <style>
        .hora {
            width: 40px;
        }
    </style>
</head>
<div>
    <?php include_once "menu.php"; ?>


    <div class="container-fluid">
        <div class="row">
            <br>
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">Ambiente :
                                <?php
                                    require_once '../../models/Ambiente.php';
                                    $ambiente = unserialize($_SESSION['ambiente']);
                                    echo $ambiente->getNome();
                                echo ' </h3>';
                            echo '<h3 class="panel-title">Valor : '.$ambiente->getValorFormatado().'</h3>';?>
                        </div>
                        <div class="col col-xs-6 text-right">
                            <button type="button" class="btn btn-sm btn-primary btn-prev-page"> < </button>
                            <button type="button" class="btn btn-sm btn-primary btn-next-page"> > </button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table agenda">
                            <thead>
                                <th colspan="3" id="data1"></th>
                                <th colspan="3" id="data2"></th>
                            </thead>
                            <thead>
                                <th>Horários</th>
                                <th>Agendamento</th>
                                <th>Ações</th>
                                <th>Horários</th>
                                <th>Agendamento</th>
                                <th>Ações</th>
                            </thead>
                            <tbody>


                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
</div>
<!-- Modal -->
<div class="modal fade multi-step" id="modalAgenda" tabindex="-1" role="dialog" aria-labelledby="modalAgenda" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="js-title-step" id="modalAgendaLabel">Agendar horário</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body body-agenda">
                <div class='table-responsive'>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-prev pull-left">Voltar</button>
                <button type="button" class="btn btn-default btn-close-agenda" data-orientation="cancel" data-dismiss="modal">Close</button>
                <!--<button type="button" class="btn btn-success btn-next">Next</button>-->
            </div>
        </div>
    </div>
</div>
</body>
<?php include_once "footer.php"; ?>
<script src="../Components/JQuery/jquery-minicolors.js"></script>
<link href="../Components/Css/jquery.minicolors.css" rel="stylesheet" />
<script>
    var data1 = new Date();
    var data1string = data1.getDate()+"/"+(data1.getMonth()+1)+"/"+data1.getFullYear();
    var data2 = new Date();
    data2.setDate(data2.getDate()+1);
    var data2string = data2.getDate()+"/"+(data2.getMonth()+1)+"/"+data2.getFullYear();
    function getitens(data1){
        $.ajax({
            type: 'GET',
            data: 'acao=listarAgenda&data1='+data1,
            url:'../../controller/ControllerAgendamento.php',
            success: function(retorno){
                $('.agenda tbody').html(retorno);
                $('#data1').html(data1string);
                $('#data2').html(data2string);
            }
        })
    }
    $("document").ready(function(){
        getitens(data1string);
        $(document).on('click', '.btn-next-page', function(){
           data1.setDate(data2.getDate()+1);
           data1string = data1.getDate()+"/"+(data1.getMonth()+1)+"/"+data1.getFullYear();
           data2.setDate(data2.getDate()+2);
           data2string = data2.getDate()+"/"+(data2.getMonth()+1)+"/"+data2.getFullYear();
           getitens(data2string);
        });
        $(document).on('click', '.btn-prev-page', function(){
            data1.setDate(data1.getDate()-2);
            data1string = data1.getDate()+"/"+(data1.getMonth()+1)+"/"+data1.getFullYear();
            data2.setDate(data2.getDate()-2);
            data2string = data2.getDate()+"/"+(data2.getMonth()+1)+"/"+data2.getFullYear();
            getitens(data1string);
        });
        $(document).on('click', '.confirmarHorario', function(){
            var nome = $('input[name="nome"]').val();
            $.ajax({
                type: "GET",
                url: "../../controller/ControllerAgendamento.php",
                data: "acao=finalizarAgendamento&nome="+nome,
                success: function(data){
                    $.notify({
                        title: '<strong>Sucesso!</strong>',
                        message: 'Agendamento efetuado com êxito.'
                    },{
                        delay: 3000,
                        type: "success",
                        placement:{
                            from: "top",
                            align: "left"
                        }
                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
            $('#modalAgenda').modal('toggle');
            getitens(data1string);
        });
        $(document).on('click', '.btn-cancelar', function(){
            var id = $(this).data("id");
            $.ajax({
                type: 'GET',
                data: 'acao=remover&id='+id,
                url:'../../controller/ControllerAgendamento.php',
                success: function(retorno){
                    getitens(data1string);
                    $.notify({
                        title: '<strong>Sucesso!</strong>',
                        message: 'Agendamento cancelado com êxito.'
                    },{
                        delay: 3000,
                        type: "warning",
                        placement:{
                            from: "top",
                            align: "left"
                        }
                    });
                }
            })
        });
        $(document).on('click', '.selecionarHorario', function(){
            var data = $(this).data('dia');
            var hora = $(this).data('hora');
            $.ajax({
                type: 'GET',
                data: 'acao=confirmarAgendamentoProp&data='+data+'&hora='+hora,
                url:'../../controller/ControllerAgendamento.php',
                success: function(retorno){
                    $('.body-agenda .table-responsive').html(retorno);
                    $('#modalAgenda').modal('show');
                }
            })
        });
    });
</script>
</html>
