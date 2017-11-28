<!doctype html>
<html lang="en">
<head>
    <title>Categorias</title>
    <?php include_once "head.php"; ?>
    <style>
        .hora {
            width: 30px;
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
                            <h3 class="panel-title">Nome do Ambiente</h3>
                        </div>
                        <div class="col col-xs-6 text-right">
                            <button type="button" class="btn btn-sm btn-primary btn-create"> < </button>
                            <button type="button" class="btn btn-sm btn-primary btn-create"> > </button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table agenda">
                            <thead>
                                <th colspan="3">21/09/2017</th>
                                <th colspan="3">22/09/2017</th>
                            </thead>
                            <tbody>
                                <th>Horários</th>
                                <th>Agendamento</th>
                                <th>Ações</th>
                            <?php
                                $min = 15;
                                for($i = 0; $i < 24; $i++){
                                    echo "<tr>";
                                    if($i < 10){
                                        echo "<td class='hora'><div class='content'> 0".$i.":".$min." </div></td>";
                                    }else{
                                        echo "<td class='hora'><div class='content'>".$i.":".$min." </div></td>";
                                    }
                                    echo "<td><div class='content'> Agendamento: ".$i."</div></td>";
                                    echo "<td><div class='content'> Ações</div></td>";
                                    if($i < 10){
                                        echo "<td class='hora'><div class='content'> 0".$i.":".$min." </div></td>";
                                    }else{
                                        echo "<td class='hora'><div class='content'>".$i.":".$min." </div></td>";
                                    }
                                    echo "<td><div class='content'> Agendamento: ".$i."</div></td>";
                                    echo "<td><div class='content'> Ações</div></td>";
                                    echo "</tr>";
                                }

                            ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

</body>
<?php include_once "footer.php"; ?>
<script src="../Components/JQuery/jquery-minicolors.js"></script>
<link href="../Components/Css/jquery.minicolors.css" rel="stylesheet" />
<script>
    var nitens = 5;
    var pagina=1;
    function getitens(pag, max){
        $.ajax({
            type: 'GET',
            data: 'acao=lista&pag='+pag+'&max='+max,
            url:'../../controller/ControllerCategoria.php',
            success: function(retorno){
                $('#listaCategorias').html(retorno);
                nitens = max;
                pagina = pag;
            }
        })
    }
    $("document").ready(function(){
        getitens(pagina, nitens);
        $('input[name="cor"]').minicolors();
        $(document).on('click', '.remover', function(){
            var id = $(this).data("id");
            $.ajax({
                type: 'GET',
                data: 'acao=remover&id='+id,
                url:'../../controller/ControllerCategoria.php',
                success: function(retorno){
                    getitens(pagina, nitens);
                    $.notify({
                        title: '<strong>Sucesso!</strong>',
                        message: 'Remoção efetuada com êxito.'
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
        $(document).on('click', '.editar', function(){
            var descricao = $(this).closest('tr').find('.listaDescricao').html();
            var cor = $(this).closest('tr').find('.listaCor').data("color");
            var id = $(this).data('id');
            $('input[name="descricao"]').val(descricao.trim());
            $('input[name="cor"]').minicolors("value", cor);
            $('#formCategoria').append("<input type='hidden' name='id' value='"+id+"'/>");
            $('input[name="acao"]').val("alterar");
        });

        $("#formCategoria").submit(function(){
            var data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "../../controller/ControllerCategoria.php",
                data: data,
                success: function(data){
                    $('#formCategoria').trigger("reset");
                    $('input[name="acao"]').val("cadastrar");
                    $('input[name="cor"]').minicolors("destroy");
                    $('input[name="cor"]').minicolors("create");
                    $.notify({
                        title: '<strong>Sucesso!</strong>',
                        message: 'Cadastro efetuado com êxito.'
                    },{
                        delay: 5000,
                        type: "success",
                        placement:{
                            from: "top",
                            align: "left"
                        }
                    });
                    getitens(pagina, nitens);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
            return false;
        });
    });
</script>
</html>
