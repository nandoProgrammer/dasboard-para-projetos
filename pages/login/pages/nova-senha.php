<?php


//Pega o token passado na url
$token = $_GET['token'];

//Se não existir o token redireciona para a página de login
if(!isset($token) || $token === ''){

  General::redirect('');

}


if(isset($_POST['submit'])){

     /*NÃO ALTERAR*/

     //Se existir o token
     if(isset($token)){
     
       //Variáveis de POST


       //variável que pega o valor passado no campo "nova senha"
       $newPassword = $_POST['new_password'];



       //variável que encripta esse valor passado
       $newPasswordEncript = md5($newPassword);

       //===================================



       /*Alterar somente se houver necessidade*/ 


       //variável que define o tamanho mínimo da nova senha
       $sizePassword = 5;

       
       //Se não for passado nenhum valor no campo "nova senha", exibe uma mensagem de erro 
       if($newPassword == ''){

          General::alert('error', 'A nova senha não pode ser nula');


       }
       //===================================



       //Se o valor passado no campo "nova senha" é menor que o valor definido na variavel $size_password, aparece uma mensagem de erro
       else if(strlen($newPassword) < $sizePassword){

           General::alert('error', 'A senha precisa ter pelo menos '.$sizePassword.' caracteres');

       }
       //===================================
 


       //Se o valor de $new_password for igual a um desses valores, aparece uma mensage de erro
       else if(
         $newPassword == '12345' 
         || $newPassword == '123456' 
         || $newPassword == '1234567' 
         || $newPassword == '12345678' 
         || $newPassword == 'senha123' 
         || $newPassword == 'senha123456' 
         || $newPassword == 'qwerty' 
         || $newPassword == 'password' 
         || $newPassword == 'iloveyou' 
         || $newPassword == '111111' 
         || $newPassword == '123123'
       )
       {

          General::alert('error', 'Senha Vulnerável, escolha uma senha mais segura');

       }
       //===================================


       /*Caso o valor de $new_password tenha no mínimo 6 caracteres e seja diferente dos valores definidos anteriormente*/
       else{

       
        /*NÃO ALTERAR*/


        //Querie que seleciona todas as colunas da tabela tb_admin quando o valor da coluna token_redefinir for igual ao da variável $token

        $selectUserHasTokenReset = MySql::connect() -> prepare("SELECT * FROM `tb_admin` WHERE token_reset = ?");
        $selectUserHasTokenReset  -> execute(array($token)); 


        //Se alguma linha foi afetada pela querie
        if($sql -> rowCount() == 1){
            
            //Pega a data atual
            $today = time();

            //foreach atribui o valor da coluna token_redefinir presente na linha selecionada a variável $token_valida
            $fetchallSelectUserHasTokenReset  = $selectUserHasTokenReset  -> fetchAll();

            foreach($fetchallSelectUserHasTokenReset as $key => $value) {
               $tokenValida = $value['token_reset'];
               $tokenData = $value['date_token_reset'];
            }

            //Se a data de definição do token for menor que a data atual menos 24 horas, exibe uma mensagem de erro e quebra o fluxo
            if($today <= strtotime('+1 day')){

                General::alert('error', 'Token expirado');

            }else{

            //Se o valor do token passado na URL for igual ao valor do token que está no banco de dados
            if(($token == $tokenValida)){
            

            //Variável para resetar o valor da coluna token_valida no banco de dados
            $defaultToken = '';

            /*Atualiza o valor da coluna password e token_redefinir na linha em que o valor da coluna token_redefinir seja igual ao token passado na URL*/
            $updateUserHasTokenReset = MySql::connect() -> prepare("UPDATE `tb_admin` SET password = ?, token_reset = ? WHERE token_reset = ?");

            //Se a querie for executada com sucesso, exibe uma mensagem de êxito
            if($updateUserHasTokenReset -> execute(array($newPasswordEncript, $defaultToken, $tokenValida))){

               General::alert('sucess', 'Senha redefinida com sucesso');

            }
          }
        }
        //Caso a consulta não tenha afetado nenhuma linha, exibe uma mensagem de erro
        }else{

            General::alert('error', 'Token inválido');

        } 
      }
     //===================================



     //Se não existir o token exibe essa mensagem de erro
     }else{

        General::alert('error','Token inexistente');

     }
     //===================================
 }


?>

<form method="post">
	<div style="position:relative" class="w100">
		<div class="password-show-hide"><i class="fas fa-eye"></i><i class="fas fa-eye-slash"></i></div>
		<input class="input-content input-style" type="password" name="new_password" placeholder="Nova senha" required="">
    <div class="first-icon"><i class="fas fa-key"></i></div>
	</div>
	<!--w100-->
	<div class="w100">
		<input class="input-submit input-style" type="submit" name="submit" value="Redefinir">
	</div>
	<!--w100-->
</form>
<div align="center" class="w100">
	<a href="<?php echo INCLUDE_PATH ?>"><i class="fas fa-arrow-alt-circle-left"></i> Voltar</a>
</div>