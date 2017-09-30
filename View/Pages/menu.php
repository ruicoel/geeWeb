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
                    <a href="#grupo-categoria" class="list-group" data-toggle="collapse"><i class=""></i><p>Categorias</p></a>
                    <div class="collapse" id="grupo-categoria">
                        <a href="#" class="list-group-item"><p id="cat1">Kichute na grama</p></a>
                        <a href="#" class="list-group-item"><p id="cat2">Futebol com a mao</p></a>
                        <a href="#" class="list-group-item"><p id="cat3">Golf</p></a>
                    </div>
                </li>

                <li>
                    <a href="mCategoria.php">
                        <p>Categorias</p>
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
                                Log out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
