<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="d-flex justify-content-lg-start ml-2">
        <a class="btn-just-icon " onclick="history.go(-1)">
            <i class="material-icons">

                <span class="material-icons-outlined text-white">
                    arrow_back
                </span>
            </i>
        </a>

        <a class="btn-just-icon  ml-3" onclick="history.go(+1)">
            <i class="material-icons">

                <span class="material-icons-outlined text-white">
                    arrow_forward
                </span>
            </i>
        </a>

        <a class="btn-just-icon ml-3" onclick="history.go(0)">
            <i class="material-icons mx-auto my-auto">
                refresh
            </i>
        </a>



    </div>

    <div class="container">
        <a class="navbar-brand" href="javascript:;"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">INÍCIO </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        CADASTRAR
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="cadastroCliente.php">CLIENTE</a>
                        <a class="dropdown-item" href="cadastroDespesas.php">DESPESAS</a>
                        <a class="dropdown-item" href="cadastroPasseio.php">PASSEIO</a>
                    </div>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="relatoriosPasseio.php">PASSEIOS </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        RELATÓRIOS
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="listaAniversariantesMes.php">ANIVERSARIANTES DO MÊS</a>
                        <a class="dropdown-item" href="log.php">LOGS</a>
                        <a class="dropdown-item" href="listaPagamentosPendentes.php">PAGAMENTOS PENDENTES</a>
                        <a class="dropdown-item" href="pesquisarPagamentos.php">PAGAMENTOS REALIZADOS </a>
                        <a class="dropdown-item" href="relatorioPeriodico.php">RELATÓRIO PERIÓDICO DE VENDAS </a>
                        <a class="dropdown-item" href="relatorioVendas.php">RELATÓRIO DE VENDAS </a>
                        <a class="dropdown-item" href="teste.php">RELATÓRIO DE VENDAS ADICIONAL </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        PESQUISAR
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="pesquisarCliente.php">CLIENTE</a>
                        <a class="dropdown-item" href="pesquisarPasseio.php">PASSEIO</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">SAIR</a>

                </li>

            </ul>
        </div>
    </div>
</nav> -->



<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="background-color:#3ea8b6 !important;">
  <!-- Container wrapper -->
  <div class="container-fluid">
    <div class="d-flex justify-content-lg-start ml-2 mr-3">
      <a class="btn-just-icon" onclick="history.go(-1)">
        <i class="material-icons">
          <span class="material-icons-outlined text-white">
            arrow_back
          </span>
        </i>
      </a>
      <a class="btn-just-icon  ml-3" onclick="history.go(+1)">
        <i class="material-icons">

          <span class="material-icons-outlined text-white">
            arrow_forward
          </span>
        </i>
      </a>
      <a class="btn-just-icon ml-3" onclick="history.go(0)">
        <i class="material-icons mx-auto my-auto text-white">
          refresh
        </i>
      </a>
    </div>
    <!-- Navbar brand -->
    <!-- <a class="navbar-brand" href="#">Início</a> -->

    <!-- Toggle button -->
    <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <i class="material-icons text-white">
        view_week
      </i>
    </button>
    <!-- Collapsible wrapper -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <!-- Link -->
        <li class="nav-item">
          <a class="nav-link" href="index.php">INÍCIO</a>
        </li>

        <!-- CADASTRAR -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
            CADASTRAR
          </a>
          <!-- Dropdown menu -->
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li>
              <a class="dropdown-item" href="cadastroCliente.php">CLIENTE</a>
            </li>
            <?php
            if ($_SESSION['nivelAcesso'] === ADMINISTRADOR) {

            ?>
              <li>
                <a class="dropdown-item" href="cadastroDespesas.php">DESPESAS</a>
              </li>
            <?php } ?>
            <li>
              <a class="dropdown-item" href="cadastroPasseio.php">PASSEIO</a>
            </li>
          </ul>
        </li>

        <!-- Link -->
        <?php
        if ($_SESSION['nivelAcesso'] === ADMINISTRADOR) {

        ?>
          <li class="nav-item">
            <a class="nav-link" href="relatoriosPasseio.php">PASSEIOS</a>
          </li>
        <?php } ?>
        <!-- PESQUISAR -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
            PESQUISAR
          </a>
          <!-- Dropdown menu -->
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li>
              <a class="dropdown-item" href="pesquisarCliente.php">CLIENTE</a>
            </li>
            <li>
              <a class="dropdown-item" href="pesquisarPasseio.php">PASSEIO</a>
            </li>
          </ul>
        </li>

        <!-- RELATÓRIOS -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
            RELATÓRIOS
          </a>
          <!-- Dropdown menu -->
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li>
              <a class="dropdown-item" href="listaAniversariantesMes.php">ANIVERSARIANTES DO MÊS</a>
            </li>
            <?php
            if ($_SESSION['nivelAcesso'] === ADMINISTRADOR) {
                        
            ?>
            <li>
              <a class="dropdown-item" href="log.php">LOGS</a>
            </li>
            <li>
              <a class="dropdown-item" href="listaPagamentosPendentes.php">PAGAMENTOS PENDENTES</a>
            </li>
            <li>
              <a class="dropdown-item" href="pesquisarPagamentos.php">PAGAMENTOS REALIZADOS</a>
            </li>
            <?php } ?>

            <li>
              <a class="dropdown-item" href="relatorioPeriodico.php">RELATÓRIO PERIÓDICO DE VENDAS</a>
            </li>
            <!-- <li>
              <hr class="dropdown-divider">
            </li> -->
            <!-- <li>
              <a class="dropdown-item" href="relatorioDiario.php">RELATÓRIO DE VENDAS</a>
            </li> -->
            <!-- <li>
                            <a class="dropdown-item" href="teste.php">RELATÓRIO VENDAS ADICIONAL</a>
                        </li> -->
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">SAIR</a>

        </li>
      </ul>

      <!-- Icons -->
      <ul class="navbar-nav d-flex flex-row me-1">
        <li class="nav-item me-3 me-lg-0">
          <a class="nav-link" href="#"><i class="fas fa-shopping-cart"></i></a>
        </li>
        <li class="nav-item me-3 me-lg-0">
          <a class="nav-link" href="#"><i class="fab fa-twitter"></i></a>
        </li>
      </ul>
    </div>
  </div>
  <!-- Container wrapper -->
</nav>