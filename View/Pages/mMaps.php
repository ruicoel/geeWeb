<!doctype html>
<html lang="en">
<head>
    <title>Usuarios</title>
    <?php include_once "head.php"; ?>
    <?php require_once "../../models/TipoUsuario.php"; ?>
    <style>
        #legend {
            font-family: Arial, sans-serif;
            background: #fff;
            padding: 10px;
            margin: 10px;
            border: 3px solid #000;
        }
        #legend h3 {
            margin-top: 0;
        }
        #legend img {
            vertical-align: middle;
        }
        .imagem{
            width: 100%;
        }
        .body-detalhes{
            margin: 20px;
        }
    </style>
</head>
<div>
    <?php include_once "menu.php"; ?>

    <div class="container-fluid">
        <div class="row">
            <br>
            <div class="col-md-12">
                <div id="map" style="height: 600px; width: 100%"></div>
                <div id="legend"><h3>Legenda</h3></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalDetalheLocal" tabindex="-1" role="dialog" aria-labelledby="modalDetalheLocalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="modalDetalheLocalLabel" style="font-weight: bold; text-size: 30px;">Detalhes do Local:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container col-md-12 body-detalhes">

                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalLocal" tabindex="-1" role="dialog" aria-labelledby="modalAddNovoLugarLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="modalAddNovoLugarLabel" style="font-weight: bold; text-size: 30px;">Editar Local</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="ControllerLocal.php" method="post" id="formEditarLocal" enctype="multipart/form-data">
                <div class="modal-body">
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
                    <div class="form-group form-type-prop">
                        <label class="form-control-label">Proprietário:</label>
                        <input class="type-prop form-control" name="nome" type="text" placeholder="Pesquisar por nome"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="acao" value="atualizar"/>
                    <input type="hidden" name="idLocal" value=""/>
                    <button type="button" class="btn btn-secondary btnCloseModal" data-dismiss="modal">Fechar</button>
                    <input type="submit" class="btn btn-primary" id="novoLugar" value="Salvar"/>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<?php include_once "footer.php"; ?>
<!-- Map Icons -->
<!--<script type="text/javascript" src="../Components/MapIcons/js/map-icons.js"></script>-->
<script src="../Components/Js/initMapAdm.js"></script>
<link rel="stylesheet" href="../Components/JQuery/file-input/css/fileinput.min.css"/>
<link rel="stylesheet" href="../Components/Bootstrap/css/bootcomplete.css">
<script src="../Components/Bootstrap/js/jquery.bootcomplete.js"></script>
<script src="../Components/JQuery/file-input/js/fileinput.min.js"></script>

<script>
    $(document).ready(function(){
        $('.type-prop').bootcomplete({
            url:'../../controller/ControllerUsuario.php?acao=findProp'
        });
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
        $(document).on('click', '.editar', function(){
            var id = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "../../controller/ControllerLocal.php",
                data: "acao=editar&id="+id,
                success: function(data){
                    //alert(JSON.stringify(data));
                    //console.log(data.nome);
                    $('#nomeLocal').val(data.nome);
                    $('#descLocal').val(data.descricao);
                    $('#chkPrivado').attr('checked', data.privado);
                    $('input[name="idLocal"]').val(id);
                    if(data.privado){
                        $('#textPrivado').html('Privado');
                    }else{
                        $('#textPrivado').html('Público');
                    }
                    $.each(data[0], function(i, item){
                        //alert(item);
                        $('*[data-cat="'+item+'"]*').attr("checked", true);
                    });
                    //alert(data);
                    categoriasCheckbox();
                    $('#input-images').fileinput({
                        allowedFileTypes: ["image"],
                        showUpload: false,
                        initialPreviewAsData: true,
                        initialPreviewFileType: 'image',
                        initialPreview:['http://localhost/'+data.imagem]
                    });
                    $('input[name="idLocal"]').val(id);
                    if(!data.privado){
                        $('.form-type-prop').hide();
                    }
                    $('#modalLocal').modal('show');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
            return false;
        });
        $(this).on('click', '.detalhes', function(){
           var id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "../../controller/ControllerLocal.php",
                data: 'acao=detalheLocal&id='+id,
                success: function(data){
                    $('.body-detalhes').html(data);
                    $('#modalDetalheLocal').modal('show');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
            return false;
        });
        $(this).on('click', '.aprovar', function(){
            var id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "../../controller/ControllerLocal.php",
                data: 'acao=aprovarLocal&id='+id,
                success: function(data){
                    $('#modalDetalheLocal').modal('toggle');
                    $.notify({
                        title: '<strong>Sucesso!</strong>',
                            message: 'O Local foi aprovado e agora esta disponível para a pesquisa!'
                     },{
                        delay: 3000,
                            type: "success",
                            placement:{
                            from: "top",
                                align: "left"
                        }
                    });
                    initMap();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
            return false;
        });
        $(this).on('click', '.negar', function(){
            var id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "../../controller/ControllerLocal.php",
                data: 'acao=negarLocal&id='+id,
                success: function(data){
                    $('#modalDetalheLocal').modal('toggle');
                    $.notify({
                        title: '<strong>Sucesso!</strong>',
                        message: 'O Local foi descartado.'
                    },{
                        delay: 3000,
                        type: "success",
                        placement:{
                            from: "top",
                            align: "left"
                        }
                    });
                    initMap();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
            return false;
        });
        $("#formEditarLocal").submit(function(e){
            var formData = new FormData(this);
            //formData.append("&acao=atualizar");
            $.ajax({
                type: "POST",
                url: "../../controller/ControllerLocal.php",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(data){
                    $('#formEditarLocal').trigger("reset");
                    $('#input-images').fileinput('reset');
                    $.notify({
                        title: '<strong>Sucesso!</strong>',
                        message: 'Alteração efetuada com êxito.'
                    },{
                        delay: 5000,
                        type: "success",
                        placement:{
                            from: "top",
                            align: "left"
                        }
                    });
                    $('#modalLocal').modal('toggle');
                    $('#modalDetalheLocal').modal('toggle');
                    location.reload();
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
<?php include_once "footer.php"; ?>

<script src="../Components/JQuery/jquery-minicolors.js"></script>
<link href="../Components/Css/jquery.minicolors.css" rel="stylesheet" />
</html>