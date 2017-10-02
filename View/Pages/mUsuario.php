<!doctype html>
<html lang="en">
<head>
    <title>Usuarios</title>
    <?php include_once "head.php"; ?>
    <?php require_once "../../models/TipoUsuario.php"; ?>
</head>
<div>
    <?php include_once "menu.php"; ?>


    <div class="container-fluid">
        <div class="row">
            <br>
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <div class="col-md-8"><h4 class="title">Lista de Usuarios</h4></div>
                        <div class="form-group col-md-4" style="float:right;"><input class="form-control pesquisarNome" placeholder="Pesquisar usuario"/></div>
                    </div>
                    <div class="content">
                        <div>
                            <table class="table table-condensed">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Login</th>
                                    <th>Tipo</th>
                                    <th>Ações</th>
                                </tr>
                                </thead>
                                <tbody id="listaUsuarios">

                                </tbody>
                            </table>
                        </div>

                        <div class="footer"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <br>
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Formulário do Usuário</h4>
                    </div>
                    <div class="content">
                        <form id="formUsuario">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="nome">Nome</label>
                                        <input type="text" name="nome" class="form-control" placeholder="Nome do usuário"/>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="email">E-mail</label>
                                        <input type="text" name="email" class="form-control" placeholder="E-mail do usuário"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="tipo">Tipo de usuário</label>
                                        <select class="form-control" name="tipo">
                                            <?php
                                                foreach(TipoUsuario::getConstants() as $const){
                                                    echo "<option value='".$const."'> ".TipoUsuario::getTipo($const)." </option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="senha">Senha</label>
                                        <input type="text" name="senha" class="form-control" placeholder="Nova senha do usuário"/>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group buttons">
                                        <input type="hidden" name="acao" value="cadastrar"/>
                                        <button type="submit" class="btn btn-primary"> <span class="glyphicon glyphicon-plus"></span> Cadastrar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
            data: 'acao=listar&pag='+pag+'&max='+max,
            url:'../../controller/ControllerUsuario.php',
            success: function(retorno){
                $('#listaUsuarios   ').html(retorno);
                nitens = max;
                pagina = pag;
            }
        })
    }
    $("document").ready(function(){
        getitens(pagina, nitens);
        $('input[name="cor"]').minicolors();
        $(document).on('keyup', '.pesquisarNome', function(){
            $.ajax({
                type: 'GET',
                data: 'acao=listar&nome='+$(this).val()+'&pag='+pagina+'&max='+nitens,
                url:'../../controller/ControllerUsuario.php',
                success: function(retorno){
                    if(retorno == false){
                        $.notify({
                            title: '<strong>Erro!</strong>',
                            message: 'Não há registros econtrados.'
                        },{
                            delay: 3000,
                            type: "warning",
                            placement:{
                                from: "top",
                                align: "left"
                            }
                        });
                    }
                    $('#listaUsuarios').html(retorno);
                }
            })
        });
        $(document).on('click', '.editar', function(){
            var nome = $(this).closest('tr').find('.listaNome').html();
            var email = $(this).closest('tr').find('.listaEmail').html();
            var tipo = $(this).closest('tr').find('.listaTipo').data('tipo');
            $('option[value=""]')
            var id = $(this).data('id');
            $('input[name="nome"]').val(nome.trim());
            $('input[name="email"]').val(email.trim());
            $('#formUsuario').append("<input type='hidden' name='id' value='"+id+"'/>");
            $('input[name="acao"]').val("alterar");
        });
        $(document).on('click', '.remover', function(){
            var id = $(this).data("id");
            $.ajax({
                type: 'GET',
                data: 'acao=remover&id='+id,
                url:'../../controller/ControllerUsuario.php',
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
