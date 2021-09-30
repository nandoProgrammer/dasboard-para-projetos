<?php 
include_once('../../../../config.php');

//id do usuário atual
$userId = $_SESSION['id'];

//Limpa notificações
$clearAllNotifications = 0;

//Seleciona todas as mensagens
$selectAllMessages = MySql::connect() -> prepare("SELECT * FROM `messages`");
$selectAllMessages -> execute();

//Quantidade de mensagens
$numberOfMessages = $selectAllMessages -> rowCount();

//Seleciona todas as mensagens quando o valor da coluna user_read_id for igual ao valor do id do usuário atual
$selectAllMessagesforUser = MySql::connect() -> prepare("SELECT * FROM `message_read` WHERE user_read_id = ?");
$selectAllMessagesforUser -> execute(array($userId));

//Quantidade de mensagens selecionadas em $selectAllMessagesforUser
$numberOfMessagesforUser = $selectAllMessagesforUser -> rowCount();


//Se o número total de mensagens for diferente do número de mensagens do usuário
if($numberOfMessages != $numberOfMessagesforUser){

  //Loop para preencher o banco de dados, para que cada usuário tenha um número de colunas igual ao número de mensagens, com o id de cada mensagem e seu estado (deletado ou não)
	for ($i = $numberOfMessagesforUser; $i < $numberOfMessages; $i++) { 
      
   
        if($numberOfMessagesforUser == 0){

           $messageId = $numberOfMessagesforUser + ($i + 1);

        }
      	
        else if($numberOfMessagesforUser > 0){

        	$messageId = $i + 1;

        }
      
      
      //Insere os valores no banco de dados
	    $insertValuesMensageRead = MySql::connect() -> prepare("INSERT INTO `message_read` VALUES(?,?,?)");
      $insertValuesMensageRead -> execute(array($messageId, $userId, $clearAllNotifications));

      //Quando o valor do id for o igual ao valor do número de mensagens selecionadas pelo usuário atual, para o loop
      if($messageId == $numberOfMessages){

      	break;

      }

    }

   

}


?>