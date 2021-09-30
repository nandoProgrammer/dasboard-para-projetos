<?php

/*Não alterar*/

include_once('config.php');

//Verifica se existe a $_SESSION['login-painel']

//Se existir ocorre um include para a página inicial do painel

//Se não existir ocorre um include para a página de login do painel

if(isset($_SESSION['login-painel'])){

   include_once('pages/main/index.php');

}else{

   include_once('pages/login/index.php');

}

//===================================

?>