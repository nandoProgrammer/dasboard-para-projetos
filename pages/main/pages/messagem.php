<?php 

//pega o id da mensagem passado na url
$id = $_GET['id'];

if(!isset($id) || $id === ''){

   General::redirect('');

}

//Seleciona na tabela 'mensagens' a que possui id igual a valor da variável $id passada na url
$selectMessage = MySql::connect() -> prepare("SELECT * FROM `messages` WHERE id = ? AND office <= ?");
$selectMessage -> execute(array($id, $userOffice)); 

$numberOfMessages = $selectMessage -> rowCount();

if($numberOfMessages == 0){

   General::redirect('');

}else{

//FetchAll da mensagem selecionada
$fetchAllSelectMessage = $selectMessage -> fetchAll();

    //Pega os valores da mensagem selecionada no banco de dados
    foreach ($fetchAllSelectMessage as $key => $value) {
    	  
        $titleMessage = $value['title'];
        $message = $value['message'];
        $date = $value['date'];

    }
    
}

?>
<section>
   <div class="container-items-pages-main">
   	<div class="w100 display-flex-row">
      <div class="w10 w20-mobile">
        <?php Painel::boxMessage('box-message-type-message', $messageTitle);  ?>
      </div>
      <div id="message-title" class="w90 w80-mobile align-flex-center-vertical">
        <h1><?php echo Painel::MessageTitle($titleMessage); ?></h1>
        <span><?php echo General::daysAgo($date); ?></span>
      </div>
   	</div>
   	<!--w100-->
   	<div style="padding:2%" class="w100">
   		<p id="message-content"><?php echo $message; ?></p>
   	</div>
   	<!--w100-->
   </div>
   <!--container-items-pages-main-->
</section>