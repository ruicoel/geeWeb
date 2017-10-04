<div class="wrapper">
    <div class="sidebar" data-color="azure">

        <!--

            Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
            Tip 2: you can also add an image using data-image tag

        -->

        <div class="sidebar-wrapper" >
            <div class="logo">
                <a href="#" class="simple-text">
                    M o v i m e n t o
                </a>
            </div>

            <ul class="nav">

                <li>
                    <a href="#grupo-categoria" class="list-group" data-toggle="collapse"><i class=""></i><p>Locais</p></a>
                    <div class="collapse" id="grupo-categoria">
                        <a href="#" class="list-group-item"><p id="cat1">Autorização</p></a>
                    </div>
                </li>

                <li>
                    <a href="mCategoria.php">
                        <p><span class="glyphicon glyphicon-tag"></span> Categorias</p>
                    </a>
                </li>

                <li>
                    <a href="mUsuario.php">
                        <p><span class="glyphicon glyphicon-user"></span> Usuários</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Bem Vindo <?php echo $_SESSION["nome"]; ?></a>
                </div>
                <div class="collapse navbar-collapse">

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="../../controller/ControllerLogin.php?acao=logout">
                              <span class="glyphicon glyphicon-log-out"></span> Sair
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
