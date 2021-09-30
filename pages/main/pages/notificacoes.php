<?php 

if(isset($_GET['clear'])){
  
  //Pega o id da mensagem a ser marcada como deletada
  $messageToCleanId = $_GET['clear'];
  
  //Atualiza na tebela 'message_read' o valor clear_id para 1 (excluido), quando o id da mensagem seja igual ao passado na url
  $updateCleanMessage = MySql::connect() -> prepare("UPDATE `message_read` SET clear_id = 1  WHERE message_id = ?");

  //Se for atualizado, dá um reload na página
  if($updateCleanMessage -> execute(array($messageToCleanId))){
  
    General::redirect('notificacoes');

  } 

}


//Seleciona todas as mensagens quando o valor da coluna office seja menor ou igual que o cargo atual do usuário 
$selectMessages = MySql::connect() -> prepare("SELECT * FROM `messages` WHERE office <= ?");
$selectMessages -> execute(array($userOffice)); 

//Irá pegar o número de mensagens que possuem cargo menor ou igual que atual
$numberOfMessages = $selectMessages -> rowCount();

//FetchAll de $selectMessages
$fetchAllselectMessages = $selectMessages -> fetchAll();


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

//Seleciona todas as mensagens na tabela 'message_read' quando o valor da coluna clear_id for 1(true, mensagem marcada como excluída) e o valor da coluna user_read_id for igual ao valor do id do usuário atual
$selectOfMessagesClear = MySql::connect() -> prepare("SELECT * FROM `message_read` WHERE clear_id = ? AND user_read_id = ?");
$selectOfMessagesClear -> execute(array($clearAllNotifications, $userId));

//pega a quantidade de mensagens selecionadas em $selectOfMessagesClear
$numberOfMessagesClearForUser = $selectOfMessagesClear -> rowCount();

//$clearAllNotifications recebe o valor de true;
$clearAllNotifications = true;

?>
<section>
   <div class="container-items-pages-main">
      <div class="w100">
         <h1> Notificações</h1>
         <div class="bar-dotted"></div>
      </div>
      <!--w100-->
      <div class="space-1"></div>
      <div class="w100 <?php 
      if($numberOfMessagesClearForUser != $numberOfMessagesRead && $numberOfMessagesClearForUser == $numberOfMessages || $numberOfMessagesClearForUser != $numberOfMessagesRead || ($numberOfMessagesRead == 0 && $numberOfMessages > 0))
      {
      echo 'display-flex-row space-between'; 
       }
      ?>">
         <h3 id="title-notifications">Todas as notificações</h3>
         <?php 
         //Se todas essas verificações forem verdadeiras, irá exibir um link clicável que leva a uma url para marcar todas as mensagens como excluídas
         if($numberOfMessagesClearForUser != $numberOfMessagesRead && $numberOfMessagesClearForUser == $numberOfMessages || $numberOfMessagesClearForUser != $numberOfMessagesRead || ($numberOfMessagesRead == 0 && $numberOfMessages > 0))
      { ?>
         <a id="button-clean-notifications" class="color-black" href="notificacoes?limpar-notificacoes=true">Limpar Tudo</a>
       <?php } ?>
      </div>
      <!--w100-->
      <div class="w100">
         <div id="box-all-notifications">
              <?php 

                 //Se todas essas verificacões forem verdadeiras irá exibir uma imagem e uma mensagem de erro
                 if($numberOfMessagesClearForUser == $numberOfMessagesRead && $numberOfMessagesRead > 0 && $numberOfMessagesRead == $numberOfMessages || $numberOfMessages == 0){

              ?>
              <div align="center" class="w100">
                  <img width="40%" height="auto" src="http://localhost/novo_painel/pages/main/assets/void.png">
                  <h3>Não existem notificações para serem exibidas</h3>
              </div>
              <!--w100-->
             <?php }
             //Se todas as verificações forem verdadeiras irá exibir as notificações
             else if($numberOfMessagesClearForUser != $numberOfMessagesRead || $numberOfMessagesRead >= 0){ ?>
               <ul>
                 <?php 
                    //Seleciona todas as notificações na tabela 'message_read' marcadas como deletadas (que possuem o valor da coluna user_read_id = 1 quando o valor da coluna 'user_read_id' for igual ao valor do usuário atual)
                    $selectClearNotifications = MySql::connect() -> prepare("SELECT * FROM `message_read` WHERE  user_read_id = ? AND clear_id = ?");
                    $selectClearNotifications ->execute(array($clearAllNotifications, $userId));

                    //fetchAll das mensagens marcadas como deletadas e que pertencem ao usuário atual
                    $fetchAllSelectClearNotifications = $selectClearNotifications -> fetchAll();

                    
                    foreach ($fetchAllSelectClearNotifications as $key => $value) {
                        //Se o valor da coluna 'clear_id' for igual a 1
                        if($value['clear_id'] == 1){

                          //$messageClearId terá o valor que está na coluna 'clear_id'
                          $messageClearId = $value['clear_id'];
                          
                          //Cria uma variável $mesageClear com indice igual ao valor de $messageClearId
                          $mesageClear[$messageClearId] = true;

                        }

                        

                    }

                  ?>
                  <?php 

                     
                     //Se o número total de mensagens em que o valor da coluna 'office' for igual ou menor que o valor do cargo do usuárioa atual
                     if($numberOfMessages > 0){
                        
                        //Loop para verificar se aquela mensagem foi maracada como excluída
                        for ($i=1; $i <= $numberOfMessages; $i++) { 

                          //Se não existir, significa que ela não foi marcada como excluída
                           if(!isset($mesageClear[$i])){

                              //Logo $mesageClear[$i] será falso
                              $mesageClear[$i] = false;
                           }

                        }
                     }
                     

                  ?>
               <?php 
                  //Pega os valores de todas as mensagens no banco de dados com coluna 'office' com valor menor ou igual ao cargo do usuário atual
                  foreach($fetchAllselectMessages as $key => $value) { 

                      //Valores 
                      $messageId = $value['id'];
                      $messageOffice = $value['office'];
                      $messageTitle = $value['title'];
                      $messageContent = $value['message'];
                      $messageDate = $value['date'];
                      
                      //Se todas as verificações forem corretas exibe as mensagens
                      if(
                        ($messageOffice == 0 && $messageOffice != $userOffice && $mesageClear[$messageId] === false) || 
                        ($messageOffice != 0 && $messageOffice == $userOffice && $mesageClear[$messageId] === false) || 
                        ($numberOfMessagesRead === 0)
                      ){
                        
                  ?>
                  <li>
                     <div class="w100 display-flex-row">
                      <div class="w07 w07-mobile">
                        <?php Painel::boxMessage('box-message-type-notifications', $messageTitle);  ?>
                      </div>
                        <div style="padding-left: 1.5%" class="w80 w80-mobile">
                           <h1><?php echo Painel::MessageTitle($messageTitle); ?></h1>
                           <span><?php General::daysAgo($messageDate); ?></span>
                        </div>
                        <!--w100-->
                        <div align="right" class="w13 w13-mobile">
                          <a>
                            <i class="fas fa-ellipsis-h"></i>
                          </a>
                        </div>
                        
                        <div class="box-message-type-notifications-options display-flex-row box-options-notifications-hide" style="display:none">
                           <div align="center" class="w50">
                              <a href="<?php echo INCLUDE_PATH.'notificacoes?clear='.$messageId; ?>"><i class="fas fa-backspace"></i></a>
                           </div>
                           <div align="center" class="w50">
                              <a href="<?php echo INCLUDE_PATH.'message?id='.$messageId; ?>"><i class="fas fa-eye"></i></a>
                           </div>
                        </div>
                     </div>
                     <!--w100-->
                     <p>
                        <?php echo General::charaterLimiter($messageContent, 25, true); ?>
                     </p>
                  </li>
                <?php } } ?>
               </ul>
            <?php } ?>
         </div>
         <!--box-all-notifications-->
      </div>
      <!--w100-->
   </div>
</section>