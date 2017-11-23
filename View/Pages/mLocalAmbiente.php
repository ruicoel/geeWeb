<!doctype html>
<html lang="en">
<head>
    <title>Locais</title>
    <?php include_once "head.php"; ?>

</head>
<div>
    <?php include_once "menu.php"; ?>


    <div class="container-fluid">
        <div class="row">
            <br>
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Lista dos Meus Locais</h4>
                    </div>
                    <div class="content">
                        <div>
                            <table class="table table-condensed">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Ativo</th>
                                    <th>Ações</th>
                                </tr>
                                </thead>
                                <tbody id="listaLocal">

                                </tbody>
                            </table>
                        </div>

                        <div class="footer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalLocal" tabindex="-1" role="dialog" aria-labelledby="modalAddNovoLugarLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="modalAddNovoLugarLabel" style="font-weight: bold; text-size: 30px;">Editar Local</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="ControllerLocal.php" method="post" id="formEditarLocal" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="form-control-label">Selecione as fotos:</label>
                            <input id="input-images" name="arquivo" type="file" class="file-loading" multiple>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Nome:</label>
                            <input type="text" class="form-control" name="nomeLocal" id="nomeLocal"/>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Categoria:</label>
                            <div id="catLocal"></div>
                        </div>
                        <div class="form-group checkPrivado">
                            <label class="form-control-label">Privado/Público:</label>
                            <div class='button-checkbox'>
                                <button type='button' id="btnPrivado" class='btn btn-warning' data-color='warning'>
                                    <span id="textPrivado">Público</span>
                                </button>
                                <input type='checkbox' class='hidden' id="chkPrivado" name='privado' value='0'/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Descrição:</label>
                            <textarea class="form-control" name="descLocal" id="descLocal" rows="4"></textarea>
                        </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="acao" value="cadastrar"/>
                    <button type="button" class="btn btn-secondary btnCloseModal" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="novoLugar">Salvar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

</body>
<?php include_once "footer.php"; ?>
<script src="../Components/JQuery/jquery-minicolors.js"></script>
<link href="../Components/Css/jquery.minicolors.css" rel="stylesheet" />
<script src="../Components/JQuery/file-input/js/fileinput.min.js"></script>
<script>
    var nitens = 5;
    var pagina=1;
    function getitens(pag, max){
        $.ajax({
            type: 'GET',
            data: 'acao=lista&pag='+pag+'&max='+max,
            url:'../../controller/ControllerLocal.php',
            success: function(retorno){
                $('#listaLocal').html(retorno);
                nitens = max;
                pagina = pag;
            }
        })
    }
    $("document").ready(function(){
        getitens(pagina, nitens);
        $.ajax({
            type: "GET",
            url: "../../controller/ControllerCategoria.php",
            data: "acao=listarIndex",
            success: function(result){
                $("#catLocal").html(result);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
        $('#input-images').fileinput({
            allowedFileTypes: ["image"],
            maxFileCount: 1,
            showUpload: false,
            showCaption: false
        });
        $(document).on('click', '.remover', function(){
            var id = $(this).data("id");
            $.ajax({
                type: 'GET',
                data: 'acao=remover&id='+id,
                url:'../../controller/ControllerLocal.php',
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
            var id = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "../../controller/ControllerLocal.php",
                data: "acao=editar&id="+id,
                success: function(data){
                    alert(JSON.stringify(data));
                    //console.log(data.nome);
                    $('#nomeLocal').val(data.nome);
                    $('#descLocal').val(data.descricao);
                    $('#chkPrivado').attr('checked', data.privado);
                    $.each(data[0], function(i, item){
                        $('*[data-cat="'+item+'"]*').attr("checked", true);
                    });
                    $('#modalLocal').modal('show');
                    //alert(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
            return false;
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
<style>
    .modal-backdrop {
        z-index: -1;
    }
</style>
</html>
