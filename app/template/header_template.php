<?php
include_once 'utils/auth.php';
$user = utilsAuthGetUser();
?>
<header class="p-3 mb-3 w-100 border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/home.php" class="d-flex align-items-center mb-2 me-4 mb-lg-0 text-dark text-decoration-none">
                <img src="/images/logo.svg" alt="Logo" width="160" />
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a target="_blank" href="https://www.forsign.digital/solucoes-de-assinatura-eletronica" class="nav-link px-2 link-dark">Assinatura</a></li>
                <li><a target="_blank" href="https://www.forsign.digital/api-integracao" class="nav-link px-2 link-dark">Integração</a></li>
                <li><a target="_blank" href="https://www.forsign.digital/pt-br/blog" class="nav-link px-2 link-dark">Blog</a></li>
            </ul>

            <div class="dropdown text-end">
                <div class="cursor-pointer d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <small class="me-2">Olá <storng><?= $user->name ?></storng></small>
                    <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
                </div>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="/home.php">Convidar usuários</a></li>
                    <li><a class="dropdown-item" href="/home.php">Configurações</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="/logout.php">Encerrar Sessão</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>