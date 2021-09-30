<?php

session_start();//Não apagar, inicializa as $_SESSION


//FUSO-HORÁRIO, Alterar somente quando necessário

//===================================

date_default_timezone_set('America/Sao_Paulo'); //valores disponíveis no site: https://www.php.net/manual/pt_BR/timezones.php

//===================================



/*NÃO ALTERAR*/

//===================================

$autoload = function($class){
  include('classes/'.$class.'.php');
};

spl_autoload_register($autoload);

//===================================




//CONEXÃO COM O BANCO DE DADOS

//Alterar o segundo parâmetro somente quando estiver migrando o site

define('HOST','/* COLOQUE AQUI O SEU HOST */'); //HOST: veja com a sua hospedagem, normalmente localhost

define('DATABASE','/* COLOQUE AQUI O NOME DO SEU BANCO DE DADOS */'); //DATABASE: nome do banco de dados

define('USER','/* COLOQUE AQUI O SEU USUÁRIO */'); //USER: usuário do banco de dados

define('PASSWORD','/* COLOQUE AQUI A SENHA DO SEU USUÁRIO */'); //PASSWORD: senha do banco de dados

//===================================




//ENDEREÇOS URL DO SITE

//Alterar o segundo parâmetro somente quando estiver migrando o site

define('INCLUDE_PATH','/* COLOQUE AQUI A URL RAÍZ */'); //Alterar pela url raiz do pasta seu site 

define('BASE_DIR',__DIR__); //Não alterar

//===================================

//Array com os cargos
$arrOffice = [0 => 'Normal', 1 => 'Sub-Administrador', 2 => 'Administrador'];

?>