<?php
// Funções úteis - Funçaõ de redirecionar
require_once "utils/template.php";
// Grava a autenticação do usuário com valor nulo e data negativa e força remoção do cookie
setcookie("authentication", null, time() - 3600);
// Grava dados do usuário com valor nulo e data negativa e força remoção do cookie
setcookie("user", null, time() - 3600);
// Redireciona o usuário para o login
utilsTemplateRedirect('/');
