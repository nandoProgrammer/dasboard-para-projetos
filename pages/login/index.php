<?php

/*NÃO ALTERAR*/

include_once('./config.php');

//===================================


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel - Login</title>
    <link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH; ?>css/botclass.css">
    <link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH; ?>css/botclass-mobile.css">
    <link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH; ?>pages/login/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH; ?>pages/login/css/main-mobile.css">
    <link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH; ?>css/animations.css">
    <link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH; ?>pages/login/css/animations.css">
    <link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH; ?>css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="icon" href="<?php echo INCLUDE_PATH; ?>assets/favicon.ico" type="image/x-icon">
</head>
<body>
  <div class="layer"></div>
  <div class="w100">
    <div class="content">
      <header>
        <a href="#"><i class="fas fa-arrow-left"></i> Voltar para Home</a>
      </header>
      <div class="w100 center-vertical" id="form-content">
        <div align="center" class="w100">
          <img width="100" height="auto" src="./assets/logo.png">
        </div>
        <!--w100-->
        <?php
          
          /*NÃO ALTERAR*/

          $url = isset($_GET['url']) ? $_GET['url'] : 'login';
                  
          if(file_exists('pages/login/pages/'.$url.'.php')){
              include('pages/login/pages/'.$url.'.php');
          }else{
              General::redirect('');
          }

          //===================================

        ?>
      </div>
      <!--w100-->
    </div>
    <!--content-->
  </div>
  <!--w100-->
</body>
<script src="<?php echo INCLUDE_PATH ?>pages/login/js/main.js"></script>
</html>