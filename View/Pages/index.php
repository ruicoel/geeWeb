<?php
session_start();?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="google-signin-client_id" content="37763588086-1rn7q1sb2smthg2cijksvidaj8k45ioq.apps.googleusercontent.com">

    <title>Movimento</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Nosso Css -->
    <link href="../Components/Css/init.css" rel="stylesheet" />

    <!-- Bootstrap core CSS     -->
    <link href="../Components/Bootstrap/css/bootstrap.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="../Components/Libs/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="../Components/Bootstrap/css/light-bootstrap-dashboard.css" rel="stylesheet"/>

    <link rel="stylesheet" href="../Components/JQuery/file-input/css/fileinput.min.css"/>


    <style>
         #banner{
            width: 98%;
            background: linear-gradient(to right, #1DC7EA 0%, #4091ff 100%);
            margin-left: 15px;
            height: 150px
         }
    </style>

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>

    <!-- AAAA -->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
    <script src="https://apis.google.com/js/api:client.js"></script>
    <script>
        var googleUser = {};
        var startApp = function() {
            gapi.load('auth2', function(){
                // Retrieve the singleton for the GoogleAuth library and set up the client.
                auth2 = gapi.auth2.init({
                    client_id: '1rn7q1sb2smthg2cijksvidaj8k45ioq.apps.googleusercontent.com',
                    cookiepolicy: 'single_host_origin',
                    // Request scopes in addition to 'profile' and 'email'
                    //scope: 'additional_scope'
                });
                attachSignin(document.getElementById('customBtn'));
            });
        };

        function attachSignin(element) {
            auth2.attachClickHandler(element, {},
                function(googleUser) {
                    document.getElementById('name').innerText = "Signed in: " +
                        googleUser.getBasicProfile().getName();
                }, function(error) {
                    alert(JSON.stringify(error, undefined, 2));
                });
        }
    </script>

    <!--Style-->

    <style type="text/css">
        #customBtn {
            display: inline-block;
            background: white;
            color: #444;
            width: 10%;
            border-radius: 1px;
            border: thin solid #888;
            box-shadow: 1px 1px 1px grey;
            white-space: nowrap;
        }
        #customBtn:hover {
            cursor: pointer;
        }
        span.label {
            font-family: serif;
            font-weight: normal;
        }
        span.icon {
            background: url('/identity/sign-in/g-normal.png') transparent 5px 10% no-repeat;
            display: inline-block;
            vertical-align: middle;
            width: 10%;
            height: 10%;
        }
        span.buttonText {
            display: inline-block;
            vertical-align: middle;
            padding-left: 10%;
            padding-right: 10%;
            font-size: 14px;
            font-weight: bold;
            /* Use the Roboto font that is loaded in the <head> */
            font-family: 'Roboto', sans-serif;
        }
        .logo{
            margin-top: 50px;
            color: white;
            font-size: 30px;
        }
        .login{
            border: 2px solid white;
            border-radius: 5px;
            margin-top: 35px;
            margin-right: 10px;
        }
        .btnLogin{
            color: white !important;
        }
    </style>

</head>
<body style="background-color: #F3F3F4">

<div class="wrapper">
        <nav class="navbar navbar-default navbar-fixed" style="border-radius: 3px !important;" id="banner">
            <div class="container-fluid">
                <ul class="nav navbar-nav navbar-left logo">
                    M O V I M E N T O
                </ul>
                <ul class="nav navbar-nav navbar-right login">
                        <?php
                        require_once "../../models/TipoUsuario.php";
                        if(isset($_SESSION['nome'])){
                            echo '<li><a href="../../controller/ControllerLogin.php?acao=logout" style="color: white !important;">'.
                              '<span class="glyphicon glyphicon-log-out"></span> Sair'.
                            '</a>'.
                        '</li>';
                        }else{
                            echo ' <li class="dropdown">'.
                                '<a class="dropdown-toggle btnLogin" data-toggle="dropdown"><span class="glyphicon glyphicon-log-in"></span> Login <b class="caret"></b></a>'.
                                '<ul class="dropdown-menu" style="padding: 15px;min-width: 250px;">' .
                                '<li>' .
                                '<div class="row">' .
                                '<div class="col-md-12">' .
                                '<form class="form" role="form" method="post" action="../../controller/ControllerLogin.php" accept-charset="UTF-8" id="login-nav">' .
                                '<div class="form-group">' .
                                '<label class="sr-only" for="email_pop_up">Email address</label>' .
                                '<input type="email" class="form-control" id="email_pop_up" placeholder="Email" name="login" required>' .
                                '</div>' .
                                '<div class="form-group">' .
                                '<label class="sr-only" for="senha_pop_up">Password</label>' .
                                '<input type="password" class="form-control" id="senha_pop_up" placeholder="Password" name="senha" required>' .
                                '</div>' .
                                '<div class="checkbox">' .
                                '<label>' .
                                '<input type="checkbox"> Lembrar-me' .
                                '</label>' .
                                '</div>' .
                                '<div class="form-group">' .
                                '<button type="submit" class="btn btn-success btn-block">Logar</button>' .
                                '</div>' .
                                '<input type="hidden" name="acao" value="logar"/>' .
                                '</form>' .
                                '</div>' .
                                '</div>' .
                                '</li>' .
                                '<li class="divider"></li>' .
                                '</ul>';
                        }
                        ?>
                    </li>
                </ul>

            </div>
        </nav>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <?php if(isset($_SESSION['nome'])){echo '<div class="col-md-12">';}else{echo '<div class="col-md-8">';} ?>
                        <div class="card">
                            <div class="header">
                                <label>Encontre o seu lugar para emagrecer</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="content">
                                <div id="map" style="height: 600px; width: 100%"></div>
                                <div id="legend"><h3>Legenda</h3></div>
                            </div>
                        </div>
                    </div>
                    <?php

                    if(!isset($_SESSION['nome'])){
                        echo '<div class="col-md-4">' .
                            '<div class="card card-user">' .
                            '<form action="ControllerLogin.php" method="POST" id="formCriarConta">' .
                            '<div class="content">' .
                            '<p>Crie sua Conta</p>' .
                            '<div class="row">' .
                            '     <div class="col-md-12">' .
                            '          <div class="form-group">' .
                            '               <label>Nome</label>' .
                            '                <input type="text" class="form-control" placeholder="Nome" name="nome" required>' .
                            '             </div>' .
                            '          </div>' .
                            '       </div>' .
                            '        <div class="row">' .
                            '             <div class="col-md-12">' .
                            '   <div class="form-group">' .
                            '        <label>Senha</label>' .
                            '         <input type="password" class="form-control" placeholder="Senha" name="senha" required>' .
                            '      </div>' .
                            '   </div>' .
                            '</div>' .
                            ' <div class="row">' .
                            ' <div class="col-md-12">' .
                            '      <div class="form-group">' .
                            '           <label>Email</label>' .
                            '            <input type="text" class="form-control" placeholder="Email" name="email" required>' .
                            '         </div>' .
                            '      </div>' .
                            '   </div>' .
                            '    <div class="row">' .
                            '         <div class="col-md-6">' .
                            '              <div class="form-group">' .
                            '                   <input type="submit" value="Criar Conta" class="btn btn-fill" id="btn_criar_conta"/>' .
                            '                </div>' .
                            '             </div>' .
                            '      </div>' .
                            '   </form>' .
                            '</div>' .
                            '</div>';
                    }
                ?>

                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalAddNovoLugar" tabindex="-1" role="dialog" aria-labelledby="modalAddNovoLugarLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddNovoLugarLabel" style="font-weight: bold; text-size: 30px;">Adicionar Novo Lugar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <form action="ControllerLogin.php" method="post" id="formAddNovoLugar" enctype="multipart/form-data">
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
                                <div id="catNovoLugar"></div>
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
            <div class="modal-body">
                <div class="row" data-step="1" data-title="First Step"></div>
                <div class="row" style="display: none;" data-step="2" data-title="Second Step"></div>
                <div class="row" style="display: none;" data-step="3" data-title="Third Step"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-prev pull-left">Voltar</button>
                <button type="button" class="btn btn-default btn-close-agenda" data-orientation="cancel" data-dismiss="modal">Close</button>
                <!--<button type="button" class="btn btn-success btn-next">Next</button>-->
            </div>
            </div>

            </div>
        </div>
    </div>
</div>
</div>
</body>

<script>

</script>
<!--   Core JS Files   -->
<!-- build:jquery -->
<script src="../Components/JQuery/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="../Components/JQuery/jquery-ui.js"></script>
<!-- endbuild -->

<!-- build:bootstrapjs -->
<script src="../Components/Bootstrap/js/bootstrap.js" type="text/javascript"></script>
<!--  Checkbox, Radio & Switch Plugins -->
<script src="../Components/Bootstrap/js/bootstrap-checkbox-radio-switch.js"></script>

<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="../Components/Bootstrap/js/light-bootstrap-dashboard.js"></script>
<!-- endbuild -->

<!-- build:js -->
<script src="../Components/Js/init.js"></script>
<script src="../Components/Js/init2.js"></script>
<!--<script src="../Components/Js/multi-step-modal.js"></script>-->
<script src="../Components/JQuery/file-input/js/fileinput.min.js"></script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-M0IMpBPaMnq6OA55g6S9c0FT08WDf5w&callback=initMap" ></script>

<script src="https://apis.google.com/js/platform.js" async defer></script>
<!-- endbuild -->


<!--  Notifications Plugin    -->
<script src="../Components/Bootstrap/js/bootstrap-notify.js"></script>
<script>
    $("document").ready(function(){
        var count = 1;
        $('.btn-close-agenda').on('click', function () {
            $('[data-step="1"]').show();
            $('[data-step="2"]').hide();
            $('[data-step="3"]').hide();
        });
        $('.btn-prev').on('click', function(){
            if(!$('.btn-prev').hasClass('disabled')){
                prevStep();
            }
        });
        $(document).on('click', '.confirmarHorario', function(){
            $.ajax({
                type: "GET",
                url: "../../controller/ControllerAgendamento.php",
                data: "acao=finalizarAgendamento",
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
        });
        $(document).on('click', '.selecionar', function(){
            var data = new Date();
            alert(data);
            var dataString = data.getFullYear()+"-"+(data.getMonth()+1)+"-"+data.getDate();
            alert(dataString);
            $.ajax({
                type: "POST",
                url: "../../controller/ControllerAgendamento.php",
                data: "acao=listaHtml&id="+$(this).data('id')+"&data="+dataString,
                success: function(data){
                    $('[data-step="2"]').html(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
            nextStep();
        });
        $(document).on('click', '.selecionarHorario', function(){
            $.ajax({
                type: "POST",
                url: "../../controller/ControllerAgendamento.php",
                data: "acao=confirmarAgendamento&hora="+$(this).data('hora'),
                success: function(data){
                    $('[data-step="3"]').html(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
            nextStep();
        });
        $(this).on('click', '.btnAgendar', function(){
            $.ajax({
                type: "GET",
                url: "../../controller/ControllerAmbiente.php",
                data: "acao=listaHtml&id="+$(this).data('id'),
                success: function(data){
                    $('[data-step="1"').html(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        });
        $('#btnPrivado').removeClass('btn-default');
        $('#btnPrivado').addClass('btn-success');
        $('#input-images').fileinput({
            allowedFileTypes: ["image"],
            maxFileCount: 1,
            showUpload: false,
            showCaption: false
        });
       $("#formCriarConta").submit(function(){
           var data = $(this).serialize()+"&acao=criarConta";
           $.ajax({
               type: "POST",
               url: "../../controller/ControllerLogin.php",
               data: data,
               success: function(data){
                   $('#formCriarConta').trigger("reset");
                   $.notify({
                       title: '<strong>Sucesso!</strong>',
                       message: 'Cadastro efetuado com êxito.'
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
        $("#login-nav").submit(function(){
            var data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "../../controller/ControllerLogin.php",
                data: data,
                success: function(data){
                    $('#login-nav').trigger("reset");
                    if(!data){
                        $.notify({
                            title: '<strong>Erro!</strong>',
                            message: 'Usuário não encontrado.'
                        },{
                            delay: 3000,
                            type: "warning",
                            placement:{
                                from: "top",
                                align: "left"
                            }
                        });
                    }else{
                        //alert(data);
                        if(data == 1) {
                            $(location).attr('href', '/View/Pages/home.php');
                        }else if(data == 0){
                            $(location).attr('href', '/View/Pages/index.php');
                        }
                        //alert(data);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
            return false;
        });
        $(document).on("click", "#btnPrivado", function(){
            if($('input[name="privado"]:checked').length > 0){
                $('input[name="privado"]').val(1);
                $('#textPrivado').html("Privado");
            }else{
                $('input[name="privado"]').val(0);
                $('#textPrivado').html("Público");
                $('#btnPrivado').removeClass('btn-default');
                $('#btnPrivado').addClass('btn-success');
            }
        });
        function nextStep(){
            $('[data-step="'+count+'"').hide();
            count++;
            $('[data-step="'+count+'"').show();
            $('.btn-prev').removeClass('disabled');
        }
        function prevStep(){
            $('[data-step="'+count+'"').hide();
            count--;
            $('[data-step="'+count+'"').show();
            if(count == 1){
                $('.btn-prev').addClass('disabled');
            }
        }
    });
</script>
</html>
