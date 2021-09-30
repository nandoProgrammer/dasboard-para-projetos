<?php

/*NÃO ALTERAR*/

include_once('./config.php');

//===================================

/*NÃO ALTERAR*/



$url = isset($_GET['url']) ? $_GET['url'] : 'home';


$selectUserInformations = MySql::connect() -> prepare("SELECT * FROM `tb_admin` WHERE id = ?");
$selectUserInformations -> execute(array($_SESSION['id']));


$fetchAllSelectUserInformations = $selectUserInformations -> fetchAll();

 $userId = $_SESSION['id'];

 foreach ($fetchAllSelectUserInformations as $key => $value) {
   $userName = $value['name'];
   $userImg = $value['img'];
   $userEmail = $value['email'];
   $userTelephone = $value['telephone'];
   $userOffice = $value['office'];
   $userDescription = $value['description'];
  
 }

 if(isset($_POST['submit-profile'])){

   $userName =  $_POST['name'];

}

//===================================

/*NÃO ALTERAR*/

//Seleciona todas as mensagens quando o valor do campo id_user for igual ao valor de da variável $userOfice
//A variável $userOfice é o valor do cargo do usuário logado
$selectMessages = MySql::connect() -> prepare("SELECT * FROM `messages` WHERE office <= ?");
$selectMessages -> execute(array($userOffice));

//A variável numberOfMessages tem valor em número da quantidade de elementos afetados pela query a qual faz referência ($selectMessages) 
$numberOfMessages = $selectMessages -> rowCount();


 
//Se alguma linha foi afetada
if($numberOfMessages > 0){

  //Seleciona na tabela 'message_read' a linha linha quando o usuário for igual ao usuário atual
  //Acontece para verificar quais mensagens o usuário visualizou ao clicar no sininho das notificações
  $selectReadMessages = MySql::connect() -> prepare("SELECT * FROM `message_read` WHERE user_read_id = ?");
  $selectReadMessages -> execute(array($userId));
  
  //Número das linhas afetadas
  $numberOfMessagesRead = $selectReadMessages -> rowCount();


  //Se o número total de mensagens for maior que o número de mensagens lidas $displayMessageAlert terá valor "block"
  if($numberOfMessages > $numberOfMessagesRead){
      
      $displayMessageAlert = 'block';
     
  }

  //Se o número total de mensagens for igual o número de mensagens lidas $displayMessageAlert terá valor "none"
  else if($numberOfMessages == $numberOfMessagesRead){

     $displayMessageAlert = 'none';

  }

  //Caso nenhuma verificação seja verdadeira $displayMessageAlert terá valor "none"
  else{

      $displayMessageAlert = 'none';

  }

}

//Caso nenhuma verificação seja verdadeira $displayMessageAlert terá valor "none" e $numberOfMessagesRead terá valor 0
else{
  
   $displayMessageAlert = 'none';
   $numberOfMessagesRead = 0;

}


//Variável que faz menção a limpar todas as notificações marcada como true (delete)
$clearAllNotifications = true;

//Quando a URL for igual a 'loggout'
if($url == 'loggout'){
   
   //Destrói a $_SESSION['login-painel'], se ela existir significa que está logado
   unset($_SESSION['login-painel']);

   //Redireciona para a tela de login
   header('Location: '.INCLUDE_PATH);

}


//Se existir na URL o valor limpar-notificacoes e o valor for igual a true
else if(isset($_GET['limpar-notificacoes']) && $_GET['limpar-notificacoes'] == 'true'){
   
   //Atualiza a coluna clear_id para true (deletado), quando a coluna user_read_id for igual ao id do usuário atual
   $clearNotifications = MySql::connect() -> prepare("UPDATE `message_read` SET clear_id = ? WHERE user_read_id = ?");
   if($clearNotifications -> execute(array($userId, $clearAllNotifications))){
    
     //Redireciona para a URL atual
     General::redirect($url);

   }

}


//Seleciona todas as mensagens na tabela message_read quando o o valor da coluna clear id for igual a 1 (deletado) e o valor de user_read_id (id do usuário) for igual ao di do usuário atual
$selectOfMessagesClear = MySql::connect() -> prepare("SELECT * FROM `message_read` WHERE clear_id = ? AND user_read_id = ?");
$selectOfMessagesClear -> execute(array($clearAllNotifications, $userId));

//Quantidade de mensagens selecionadas em $selectOfMessagesClear
$numberOfMessagesClearForUser = $selectOfMessagesClear -> rowCount();



?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Painel - Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Fernando Costa">
    <meta name="description" content="Essa é a dashboard da algoritmo">
    <link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH; ?>css/botclass.css">
    <link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH; ?>css/botclass-mobile.css">
    <link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH; ?>pages/main/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH; ?>pages/main/css/animations-main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH; ?>pages/main/css/animations-main-mobile.css">
    <link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH; ?>pages/main/pages/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH; ?>pages/main/pages/css/styles.css">
    <link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH; ?>pages/main/pages/css/styles-mobile.css">
    <link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH; ?>pages/main/css/main-mobile.css">
    <link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH; ?>css/main.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo INCLUDE_PATH; ?>assets/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo INCLUDE_PATH; ?>assets/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo INCLUDE_PATH; ?>assets/favicon-16x16.png">
    <link rel="manifest" href="<?php echo INCLUDE_PATH; ?>assets/site.webmanifest">
</head>
<body> 
  <aside id="aside-main" class="aside-main-show">
    <header align="center" class="w100 desktop" id="logo-aside">
      
    </header>
    <nav>
        <ul>
            <li>
                <span class="title-nav-aside">INÍCIO</span>
                <div class="items-ul-nav-aside">
                    <a class="name-page-nav-aside" id="home" href="<?php echo INCLUDE_PATH ?>">
                      <div class="box-icon-items-ul-nav-aside">
                        <i class="fas fa-chart-line"></i>
                      </div>
                      <!--box-icon-items-ul-nav-aside-->
                      <span>Visão Geral</span>
                    </a>
                    <!--name-page-nav-aside-->
                </div>
                <!--items-ul-nav-aside-->
            </li>
            <li>
                <span class="title-nav-aside">USUÁRIOS</span>
                <div class="items-ul-nav-aside">
                    <a class="name-page-nav-aside" id="editar-usuarios" href="<?php echo INCLUDE_PATH ?>editar-usuarios">
                      <div class="box-icon-items-ul-nav-aside">
                        <i class="fas fa-user-edit"></i>
                      </div>
                      <!--box-icon-items-ul-nav-aside-->
                       <span>
                         <?php 

                         if($userOffice < 2){

                           echo 'Editar usuário';

                         }else{

                           echo 'Editar usuários';

                         }

                        ?>
                        
                     </span>
                    </a>
                    <!--name-page-nav-aside-->
                </div>
                <!--items-ul-nav-aside-->
            </li>
            <li>
                <span class="title-nav-aside">PÁGINAS</span>
                <div class="items-ul-nav-aside">
                    <a class="name-page-nav-aside" id="editar-paginas" href="<?php echo INCLUDE_PATH ?>editar-paginas">
                      <div class="box-icon-items-ul-nav-aside">
                        <i class="fas fa-file-alt"></i>
                      </div>
                      <!--box-icon-items-ul-nav-aside-->
                      <span>Editar páginas</span>
                    </a>
                    <!--name-page-nav-aside-->
                </div>
                <!--items-ul-nav-aside-->
            </li>
             <li>
                <span class="title-nav-aside">ESTILOS</span>
                <div class="items-ul-nav-aside">
                    <a class="name-page-nav-aside" id="estilo-geral"  href="<?php echo INCLUDE_PATH ?>estilo-geral">
                      <div class="box-icon-items-ul-nav-aside">
                        <i class="fas fa-pencil-ruler"></i>
                      </div>
                      <!--box-icon-items-ul-nav-aside-->
                      <span>Estilo geral</span>
                    </a>
                    <!--name-page-nav-aside-->
                     <a class="name-page-nav-aside" id="editar-css"  href="<?php echo INCLUDE_PATH ?>editar-css">
                      <div class="box-icon-items-ul-nav-aside">
                        <i class="fab fa-css3-alt"></i>
                      </div>
                      <!--box-icon-items-ul-nav-aside-->
                      <span>CSS</span>
                    </a>
                    <!--name-page-nav-aside-->
                </div>
                <!--items-ul-nav-aside-->
            </li>
             <li>
                <span class="title-nav-aside">INFO</span>
                <div class="items-ul-nav-aside">
                    <a class="name-page-nav-aside" id="sobre"  href="<?php echo INCLUDE_PATH ?>sobre">
                      <div class="box-icon-items-ul-nav-aside">
                        <i class="fas fa-info-circle"></i>
                      </div>
                      <!--box-icon-items-ul-nav-aside-->
                      <span>Sobre</span>
                    </a>
                    <!--name-page-nav-aside-->
                </div>
                <!--items-ul-nav-aside-->
            </li>
        </ul>
    </nav>
  </aside>
  <!--aside-main-desktop-->
  <header id="header-main">
    <div class="content display-flex-row space-between">
      <div id="header-menu-mobile" class="mobile">
        <div id="menu-icon">
          <i id="bars" class="fas fa-bars"></i>
          <i id="times" class="fas fa-times"></i>
        </div>
        <!--menu-icon-->
      </div>
      <!--header-menu-mobile-->
      <div id="header-input" class="desktop">
        <form method="post">
          <div id="search-icon">
            <i class="fas fa-search"></i>
          </div>
          <!--search-icon-->
          <input class="input-style-1" type="text" name="search" placeholder="Pesquisar...">
          <input class="button-style-1" type="submit" name="submit-search" value="Enviar">
        </form>
      </div>
      <!--header-input-->
       <ul id="box-header" class="display-flex-row">
         <li id="header-search" class="mobile">
           <i class="fas fa-search"></i>
         </li>
         <!--header-search-->
         <li id="header-info">
          <div style="display:<?php echo $displayMessageAlert; ?>" id="box-alert-bell">
            
          </div>
            <i class="far fa-bell"></i>
         </li>
         <!--header-info-->
         <li id="header-tools">
           <i class="fas fa-th"></i>
         </li>
         <!--header-tools-->
         <li id="header-config">
            <i class="fas fa-cog"></i>
         </li>
         <!--header-config-->
         <li id="header-user" align="center" class="align-flex-center-vertical">
            <div id="box-user">
              <?php 
                 if($userImg != ''){
                   
                   echo '<img width="90%" class="center" height="90%" style="border-radius:50%" src="'.INCLUDE_PATH.'uploads/'.$userImg.'">';

                 }else{

                   echo '<i class="far fa-user-circle center"></i>';

                 }
              ?>
              
            </div>
         </li>
         <!--header-user-->
      </ul>
      <!--box-header-->
    </div>
  </header>
  <div align="center" id="box-items-header-info-main">
      <div align="center" id="info-search" class="box-items-header-info">
          <form method="post">
             <input class="input-style-1" id="header-search-text-mobile" type="text" name="search" placeholder="Pesquisar...">
          </form>
      </div>
      <!--info-search-->
      <div id="info-box" class="box-items-header-info">
            <div class="w100 display-flex-row space-between">
              <span>Notificações</span>
              <a href="<?php echo $url; ?>?limpar-notificacoes=true" style="display:<?php 
                    
                    if($numberOfMessagesClearForUser != $numberOfMessagesRead && $numberOfMessagesClearForUser == $numberOfMessages || $numberOfMessagesClearForUser != $numberOfMessagesRead || ($numberOfMessagesRead == 0 && $numberOfMessages > 0)){

                      echo 'block';

                    }

                    else{

                      echo 'none';

                    }

               ?>">Limpar tudo</a>
            </div>
            <!--w100-->
            <div class="w100">
              <?php 
                 //Se todas as verificações forem verdadeiras significa que todas as notificações estão marcadas como deletadas e exibirá uma imagem e uma mensgem correspondente
                if($numberOfMessagesClearForUser == $numberOfMessagesRead && $numberOfMessagesRead > 0 && $numberOfMessagesRead == $numberOfMessages || $numberOfMessages == 0){
              ?>
              <div class="w100">
                <div align="center" class="w100">
                  <img width="60%" height="auto" src="<?php echo INCLUDE_PATH; ?>pages/main/assets/void.png">
                </div>
                <!--w100-->
                <div align="center" class="w100">
                  <span>Não existem novas notificações</span>
                </div>
                <!--w100-->
              </div>
              <!--w100-->
              <?php 
                 }

                //Se todas as verificações forem verdadeiras, exibirá as notificações que não estão marcadas como deletadas
                else if($numberOfMessagesClearForUser != $numberOfMessagesRead || $numberOfMessagesRead >= 0){
              ?>
              <div class="w100" id="message-box-scrolbar">
                <ul>
                  <?php 

                    //Seleciona todas as mensagens lidas quando o id do usuáriofor igual ao id do usuário atual e o valor de user_read_id for igual a 1(deletada)
                    $selectClearNotifications = MySql::connect() -> prepare("SELECT * FROM `message_read` WHERE  user_read_id = ? AND clear_id = ?");
                    $selectClearNotifications ->execute(array($userId, $clearAllNotifications));

                    //FetchAll de $selectClearNotifications
                    $fetchAllSelectClearNotifications = $selectClearNotifications -> fetchAll();

                    //Pega os valores no banco de dados
                    foreach ($fetchAllSelectClearNotifications as $key => $value) {
                        
                        //Se o valor da coluna clear_id for igual a 1
                        if($value['clear_id'] == 1){
                          
                          //Pega o valor
                          $messageClearId = $value['clear_id'];
                          
                          //Cria uma variável com o índice do valor atual de clear_id e possui valor true (deletado)
                          $mesageClear[$messageClearId] = true;

                        }

                    }

                  ?>

                  <?php 
                     
                     //Número de mensagens selecionadas
                     $numberOfMessages =  $selectMessages -> rowCount();
                     
                     //Se o número de mensagens for maior que zero
                     if($numberOfMessages > 0){
                        
                        //Laço limitado na quantidade de mensagens selecionadas em $selectMessages
                        for ($i=1; $i <= $numberOfMessages; $i++) { 

                           //Se não exixtir uma $mesageClear com p índice atual significa que ela não está marcada como deletada
                           if(!isset($mesageClear[$i])){
                              $mesageClear[$i] = false;
                           }

                        }
                     }
                     

                  ?>
                  <?php 
                  
                  //Fetchall das mensagens selecionadas em $selectMessages
                  $fetchAllSelectMessages = $selectMessages -> fetchAll();
                  

                  foreach($fetchAllSelectMessages as $key => $value) { 

                      //Valores no banco de dados

                      $messageId = $value['id'];
                      $messageOffice = $value['office'];
                      $messageTitle = $value['title'];
                      $messageContent = $value['message'];
                      $messageDate = $value['date'];
                      
                      //Se todas as verificações forem verdadeiras vaio exibir a notificação
                      if(
                        ($messageOffice == 0 && $messageOffice != $userOffice && $mesageClear[$messageId] === false) || 
                        ($messageOffice != 0 && $messageOffice == $userOffice && $mesageClear[$messageId] === false) || 
                        ($numberOfMessagesRead === 0)
                      ){
                        
                  ?>
                    <li>
                      <a class="display-flex-row" href="<?php echo INCLUDE_PATH.'messagem?id='.$messageId; ?>">
                        <div align="left" class="w15 w20-mobile">
                          <?php Painel::boxMessage('box-message-type', $messageTitle);  ?>
                        </div>
                        <!--w15-->
                        <div align="left" style="margin-top:0" class="w85 w85-mobile">
                          <h3>
                            <?php Painel::messageTitle($messageTitle); ?>
                          </h3>
                          <span>
                            <?php 
                              General::daysAgo($messageDate);
                            ?>
                          </span>
                        </div>
                        <!--w80-->
                      </a>
                    </li>
                 <?php } } ?>
                </ul>
              </div>
              <!--w100-->
              <div style="position:absolute;bottom:0;left:50%;transform: translate(-50%, -50%);" align="center" class="w100">
                <a href="<?php echo INCLUDE_PATH ?>notificacoes">Ver tudo</a>
              </div>
              <!--w100-->
            <?php } ?>
            </div>
            <!--w100-->
         </div>
         <!--info-box-->
         <div id="tools-box" class="box-items-header-info">
         </div>
         <!--tools-box-->
         <div align="left" id="user-box" class="box-items-header-info" >
          <span><strong>Olá <?php echo $userName; ?>!</strong></span>
          <ul>
            <li>
              <a href="<?php echo INCLUDE_PATH?>minha-conta"><i class="fas fa-user-alt"></i> <span>Minha Conta</span></a>
            </li>
            <li>
              <a href="<?php echo INCLUDE_PATH; ?>loggout"><i class="fas fa-sign-out-alt"></i> <span>Loggout</span></a>
            </li>
          </ul>
         </div>
         <!--user-box-->
  </div>
  <aside class="aside-hide" id="aside-options">
    <header class="display-flex-row space-between">
      <span>Configurações</span>
      <div id="exit-aside-options">
        <i class="fas fa-times"></i>
      </div>
      <!--exit-aside-options-->
    </header>
    <nav>
      <ul>
        <form>
          <li>
            <span class="title-nav-aside">Nome Do Site</span>
            <div class="bar-tm-1"></div>
            <input class="input-style-1" type="text" name="site_name">
          </li>
          <li>
            <span class="title-nav-aside">Descrição Do Site</span>
            <div class="bar-tm-1"></div>
            <textarea class="input-style-1" type="text" name="site_description"></textarea>
          </li>
          <li>
            <span class="title-nav-aside">Palavras Chave</span>
            <div class="bar-tm-1"></div>
            <textarea class="input-style-1" type="text" name="site_keywords"></textarea>
          </li>
          <li>
            <span class="title-nav-aside">Favicon</span>
            <div class="bar-tm-1"></div>
            <input class="input-style-1" type="file" name="site_favicon">
          </li>
          <div id="submit-save-config" class="button-style-1 submit-save">Salvar</div>
        </form>
      </ul>
    </nav>
  </aside>
  <div id="content-main">
     <?php
          
          /*NÃO ALTERAR*/
                  
          if(file_exists('pages/main/pages/'.$url.'.php')){
              include('pages/main/pages/'.$url.'.php');
          }else{
              General::redirect('');
          }

          //===================================

        ?>
  </div>
  <!--content-main-->
</body>
<script src="<?php echo INCLUDE_PATH; ?>pages/main/js/main.js"></script>
<script src="<?php echo INCLUDE_PATH; ?>pages/main/js/ajax/ajax.js"></script>
<?php if($url == 'minha-conta'){ ?>
<script src="<?php echo INCLUDE_PATH; ?>pages/main/pages/js/minha-conta.js"></script>
<?php } ?>

<?php if(isset($_GET['tab']) && $_GET['tab'] == 'profile'){?>
<script src="<?php echo INCLUDE_PATH; ?>pages/main/pages/js/masks.js"></script>
<?php } ?>

<?php if($url == 'notificacoes'){ ?>
<script src="<?php echo INCLUDE_PATH; ?>pages/main/pages/js/notificacoes.js"></script>
<?php } ?>

</html>
