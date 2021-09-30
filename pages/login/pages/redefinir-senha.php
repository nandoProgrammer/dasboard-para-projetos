<?php

if(isset($_POST['submit'])){

  /*NÃO ALTERAR*/

  //Variáveis de POST


  //Pega o valor passado no campo de name 'email'
  $emailValidation = $_POST['email'];



   //Verifica se o valor da variável $emailValidation possui a estrutura de um email
   if(filter_var($emailValidation, FILTER_VALIDATE_EMAIL)){

       //Consulta ao banco de dados

      //Seleciona na tabela 'tb_admin' a linha 
      $selectUserByEmail = MySql::connect() -> prepare("SELECT * FROM `tb_admin` WHERE email = ?");
      $selectUserByEmail -> execute(array($emailValidation));


      //Se uma linha foi afetada
      if($selectUserByEmail -> rowCount() == 1){


        $fetchAllSelectUserName = $selectUserByEmail -> fetchAll();

        foreach ($fetchAllSelectUserName as $key => $value) {
          $userNameEmail = $value['name'];
        }

        
       
        //Gera um id para ser o valor de $tokenReset;
        $tokenReset = uniqid();
        
        //Pega a data atual em que o token foi gerado
        $dateTokenReset = date('Y-m-d H:i:s');
        
        //Atualiza no banco de dados o valor do token_reset que agora passará a ser o id gerado na variável $token reset e tambem atualiza o campo date_token_reset que passará a ter a data em que o token foi gerado, que é o valor da variável $dateTokenReset
        $updateUserByEmail = MySql::connect() -> prepare("UPDATE `tb_admin` SET token_reset = ?,  date_token_reset = ? WHERE email = ?");

        //Se a ação ocorrer exibe uma mensagem de sucesso e envia o email de redefinição para o endereço de email infomado
        if($updateUserByEmail -> execute(array($tokenReset, $dateTokenReset, $emailValidation))){

         $host = '/* SMTP DA SUA CONTA DE EMAIL */';
         $userName = '/* USERNAME DO EMAIL */';
         $password = '/* ENHA DO EMAIL */';
         $myEmail = '/* ENDEREÇO DO EMAIL */';
         $sendTo = $emailValidation;
         $titleEmail = 'Solicitação de redefinição de senha';
         $emailBody = '<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Email</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
</head>
<body style="margin:0;padding:0">

  <div style="width:100%;background-color:#f7f7f7;padding:2% 0">
         <!--<div style="width:80%;height:100%;margin:auto;background-color:#f7f7f7;padding:2% 0;">-->
            <div style="width:50%;height:100%;margin:0 auto 2% auto;background-color:#f7f7f7;min-width:400px">
                <header style="color:white;font-size:10px;padding: 7% 0;text-align:center;width:100%;height:100%;background-color:#313a46;border-top-left-radius: 3px;border-top-right-radius: 3px;background-image: url(https://lh3.googleusercontent.com/pw/ACtC-3eBwzsfR7Qr-pcgYTP_uPdahOIIhqyL44CRsl7FErTJy-F8-_UHBgeM8wxrdUNezlV6r3clp72gs_hDOLwXOc410e-mD3SxfIYNuxFRK_nefKn7hfRMIwAXPE3HSZjozn-8X24gLRhAv7mwxNcJ9Qgb=w1353-h233-no?authuser=0);background-size: 35% auto;background-position: center;background-repeat: no-repeat;">
                  
                </header>
                <div align="center" style="width:100%;padding:7% 6%;background-image:linear-gradient(to left, #3B3B98, #182C61);max-width:88% ">
                  <h1 style="font-size:30px;color:white">Olá '.$userNameEmail.'!</h1>
                    <h2 style="font-size:20px;color:white">Este é o email de redefinição de senha que você solicitou</h2>
                </div>
                <div style="width:100%;padding:2% 6%;background-color:#fff;max-width:88%;padding-bottom:5%">
                    
                  <p style="font-size:18px;color:black">
                  
                    <br /><br /><br />
                    <strong>Observação:</strong>
                    <br /><br/>
                  • Evite senhas com <strong style="color:#182C61">Sequências Numéricas</strong> ou <strong style="color:#182C61">Data de Nascimento</strong>
                  <br /><br />
                  • Use letras <strong style="color:#182C61">Maiúsculas</strong> e <strong style="color:#182C61">Minúsculas</strong>, <strong style="color:#182C61">Números</strong> e <strong style="color:#182C61">Caracteres</strong>
                    </p>
                    <p style="font-size:18px;color:black">
                    <br /><br/><br />
                    <strong>Instruções:</strong>
                    <br /><br/>
                    • Clique no botão <strong style="color:#182C61">Abaixo</strong> para <strong style="color:#182C61">Redefinir a Senha</strong>
                    <br /><br/>
                    • <strong style="color:#182C61">Caso</strong> o botão <strong style="color:#182C61">Não</strong> funcione <strong style="color:#182C61">Copie</strong> e <strong style="color:#182C61">Cole</strong> a <strong style="color:#182C61">URL a Seguir</strong> no <strong style="color:#182C61">Navegador:</strong> <a href="http://agenciaalgoritimo.com/nova-senha?token=bbubb">'.INCLUDE_PATH.'nova-senha?token='.$tokenReset.'</a>
                    </p>
                    <a style="display:block;width:60%;min-width:400px;background-color: #313a46;text-align:center;padding:4% 0;margin:100px auto 0 auto;border-radius:3px;color:#fff;text-decoration:none;font-size:20px;"href="'.INCLUDE_PATH.'nova-senha?token='.$tokenReset.'">Clique aqui para redefinir a senha</a>
                    <p align="center" style="font-size:18px;color:black;padding:5% 0">
                        Obrigado, a equipe Algoritimo
                    </p>


                </div>
            </div>
         <!--</div>-->
    </div>


</body>
</html>';
         $emailAltBody = '
         Olá '.$userNameEmail.'! 

         Este é o email de redefinição de senha que você solicitou

         Observação:

        • Evite senhas com Sequências Numéricas ou Data de Nascimento

        • Use letras Maiúsculas e Minúsculas, Números e Caracteres




        Instruções:

        • Clique no link a Seguir para Redefinir a Senha: '.INCLUDE_PATH.'nova-senha?token='.$tokenReset.'

         ';

         Email::sendMail($host, $userName, $password, $myEmail, $sendTo, $titleEmail, $emailBody, $emailAltBody);
        

        }
        
        //Se mais de uma linha for afetada por ter o mesmo endereço de email exibe uma mensagem de erro
        //Os valores repetidos no banco de dados devem ser alterados manualmente 
        else if($selectUserByEmail -> rowCount() > 1){


           General::alert('error','Esse email pertence a vários usuários, repare o banco de dados');


        }
        
        //Se fugir a todos os casos anteriores exibe uma mensagem de erro
        else{

           
           General::alert('error','Não foi possível redefinir a senha, erro desconhecido');


        }

        
       
      }
      
      //Se a verificação no banco de dados pelo endereço de email informado não afetar nenhuma linha exibe uma mensagem de erro
      else if($selectUserByEmail -> rowCount() == 0){

        General::alert('error','Esse email não pertence a nenhum usuário');

      }

   }

   //Se o valor do email informado como valor da variável $emailValidation não possuir a estrutura de um endereço de email exibe uma mensagem de erro
   else{

      General::alert('error','Insira um endereço de email válido');

   }

   //===================================

}

?>
<form method="post">
  <div style="position:relative" class="w100">
    <input class="input-content input-style" type="text" name="email" placeholder="Coloque aqui o email cadastrado" required="">
    <div class="first-icon"><i class="fas fa-envelope"></i></div>
  </div>
  <!--w100-->
  <div class="w100">
    <input class="input-submit input-style" type="submit" name="submit" value="Enviar">
  </div>
  <!--w100-->
</form>
<div align="center" class="w100">
  <a href="<?php echo INCLUDE_PATH ?>"> <i class="fas fa-arrow-alt-circle-left"></i> Voltar</a>
</div>
<!--w100-->