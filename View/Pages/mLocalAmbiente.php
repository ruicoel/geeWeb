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
                            <table class="table table-condensed tree">
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

<div class="modal fade" id="modalAddAmbiente" tabindex="-1" role="dialog" aria-labelledby="modalAddAmbienteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="modalAddAmbienteLabel" style="font-weight: bold; text-size: 30px;">Adicionar Ambiente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../../controller/ControllerAmbiente.php" method="post" id="formAddAmbiente" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-control-label">Selecione as fotos:</label>
                        <input name="arquivo-ambiente[]" id="arquivo-ambiente" type="file" class="file-loading" multiple>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Nome:</label>
                        <input type="text" class="form-control" name="nomeAmbiente" id="nomeAmbiente"/>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Descrição:</label>
                        <textarea class="form-control" name="descAmbiente" id="descAmbiente" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Valor:</label>
                       R$ <input type="text" class="form-control" name="valorAmbiente" id="valorAmbiente"/>
                    </div>
                    <div class="form-group">
                        <label for="sel1">Divisor de horas:</label>
                        <select class="form-control" name="divisorHoras">
                            <option value="00">xx:00</option>
                            <option value="15">xx:15</option>
                            <option value="30">xx:30</option>
                            <option value="45">xx:45</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="acao" value="cadastrar"/>
                    <input type="hidden" name="idLocalAmbiente" value=""/>
                    <button type="button" class="btn btn-secondary btnCloseModal" data-dismiss="modal">Fechar</button>
                    <input type="submit" class="btn btn-primary" value="Salvar"/>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<?php include_once "footer.php"; ?>
<link href="../Components/Bootstrap/css/jquery.treegrid.css" rel="stylesheet" />
<link href="../Components/Bootstrap/css/datatables.min.css" rel="stylesheet" />
<script src="../Components/Bootstrap/js/datatables.min.js"></script>
<script src="../Components/Bootstrap/js/jquery.treegrid.js"></script>
<script src="../Components/Bootstrap/js/jquery.treegrid.bootstrap3.js"></script>
<script src="../Components/JQuery/file-input/js/fileinput.min.js"></script>
<link rel="stylesheet" href="../Components/JQuery/file-input/css/fileinput.min.css"/>
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
                $('.tree').treegrid({
                    initialState: 'collapsed'
                });
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
        $('#arquivo-ambiente').fileinput({
            allowedFileTypes: ["image"],
            showUpload: false,
            showCaption: false
        });
        $(this).on('click', '.addAmbiente', function () {
            $('input[name="idLocalAmbiente"]').val($(this).data('id'));
           $('#modalAddAmbiente').modal('show');
        });
        $(this).on('click', '.mostraAgenda', function(){
            $.ajax({
                type: "GET",
                url: "../../controller/ControllerAgendamento.php",
                data: "acao=mostrarAgenda&id="+$(this).data('id'),
                success: function(data){
                    $(location).attr('href', data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        });
        $(document).on('click', '.remover', function(){
            var id = $(this).data("id");
            $.ajax({
                type: 'GET',
                data: 'acao=desativar&id='+id,
                url:'../../controller/ControllerLocal.php',
                success: function(retorno){
                    getitens(pagina, nitens);
                    $.notify({
                        title: '<strong>Sucesso!</strong>',
                        message: 'Local desativado com êxito.'
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
                    $('#modalLocal').modal('show');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
            return false;
        });

        $(this).on('click', '.ativar', function(){
            var id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "../../controller/ControllerLocal.php",
                data: 'acao=aprovarLocal&id='+id,
                success: function(data){
                    getitens(pagina, nitens);
                    $.notify({
                        title: '<strong>Sucesso!</strong>',
                        message: 'O Local foi reativado e agora esta disponível para a pesquisa!'
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
            return false;
        });

        $(this).on('click', '.ativarAmbiente', function(){
            var id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "../../controller/ControllerAmbiente.php",
                data: 'acao=ativarAmbiente&id='+id,
                success: function(data){
                    getitens(pagina, nitens);
                    $.notify({
                        title: '<strong>Sucesso!</strong>',
                        message: 'O Ambiente foi reativado e agora esta disponível para agendamentos!'
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
            return false;
        });

        $(this).on('click', '.removerAmbiente', function(){
            var id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "../../controller/ControllerAmbiente.php",
                data: 'acao=desativarAmbiente&id='+id,
                success: function(data){
                    getitens(pagina, nitens);
                    $.notify({
                        title: '<strong>Sucesso!</strong>',
                        message: 'O Ambiente foi desativado!'
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
            return false;
        });

        /*$("#formAddAmbiente").submit(function(e){
            e.preventDefault();
            alert('entrou');
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "../../controller/ControllerAmbiente.php",
                data: $(this).serialize(),
                success: function(data){
                    $('#formAddAmbiente').trigger("reset");
                    $('#arquivo-ambiente').fileinput('reset');
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
    });*/
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
                    getitens(pagina, nitens);
                    $('#modalLocal').modal('toggle');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
            return false;
        });
    });

    function categoriasCheckbox() {
        setTimeout(function () {
            $('.button-checkbox').each(function () {
                // Settings
                var $widget = $(this),
                    $button = $widget.find('button'),
                    $checkbox = $widget.find('input:checkbox'),
                    color = $button.data('color'),
                    settings = {
                        on: {
                            icon: 'glyphicon glyphicon-check'
                        },
                        off: {
                            icon: 'glyphicon glyphicon-unchecked'
                        }
                    };

                // Event Handlers
                $button.on('click', function () {
                    $checkbox.prop('checked', !$checkbox.is(':checked'));
                    $checkbox.triggerHandler('change');
                    updateDisplay();
                });
                $checkbox.on('change', function () {
                    updateDisplay();
                });

                // Actions
                function updateDisplay() {
                    var isChecked = $checkbox.is(':checked');

                    // Set the button's state
                    $button.data('state', (isChecked) ? "on" : "off");

                    // Set the button's icon
                    $button.find('.state-icon')
                        .removeClass()
                        .addClass('state-icon ' + settings[$button.data('state')].icon);

                    // Update the button's color
                    if (isChecked) {
                        $button
                            .removeClass('btn-default')
                            .addClass('btn-' + color + ' active');
                    }
                    else {
                        $button
                            .removeClass('btn-' + color + ' active')
                            .addClass('btn-default');
                    }
                }

                // Initialization
                function init() {

                    updateDisplay();

                    // Inject the icon if applicable
                    if ($button.find('.state-icon').length == 0) {
                        $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
                    }
                }
                init();
            });
        },1000)
    }
</script>
</html>
