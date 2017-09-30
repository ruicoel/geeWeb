<!doctype html>
<html lang="en">
<head>
    <title>Home1</title>
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
                            <h4 class="title">Lista de Categorias</h4>
                        </div>
                        <div class="content">
                            <div>
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Previsão</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody id="listaCategorias">

                                    </tbody>
                                </table>
                            </div>

                            <div class="footer">
                                <button type='button' class='btn btn-primary btn-sm'> <span class='glyphicon glyphicon-plus'/></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <br>
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Cadastro de Categoria</h4>
                        </div>
                        <div class="content">
                            <div>
                                <form id="formCategoria">
                                    <div class="form-group">
                                        <label for="descricao">Descrição</label>
                                        <input type="text" name="descricao" class="form-control" placeholder="Descrição da categoria"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="cor">Cor</label><br>
                                        <input type="text" name="cor" data-control="hue" class="form-control minicolors-input input-lg" size="7"/>
                                    </div>
                                    <input type="hidden" name="acao" value="cadastrar"/>
                                    <input type="submit" class="btn btn-primary" value="Submit"/>
                                </form>
                            </div>
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
