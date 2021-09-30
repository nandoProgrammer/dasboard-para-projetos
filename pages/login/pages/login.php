<?php

if(isset($_POST['submit'])){
  
/*NÃO ALTERAR*/

//Variáveis de POST

$user = $_POST['user'];
$password = $_POST['password'];

//===================================



//Criptografia das variáveis user e password

$userCript = md5($user);
$passwordCript = md5($password);

//===================================



    /*NÃO ALTERAR*/

    //Verifica se os campos estão vazios 

    //Se estiver retorna uma mensagem de erro correspondente ao caso

    //Se não estiver nenhum campo vazio executa o bloco de código

	if($user == '' && $password == ''){

	    General::alert('error','Campos usuário e senha não podem ser vazios');
	    
	}else if($password == ''){

	    General::alert('error','Campo senha não pode ser vazia');

	}else if($user == ''){

	    General::alert('error','Campo usuário não pode ser vazio');

	}else{
         
        //consulta ao banco de dados
        

        /*Query MySql que seleciona no banco de dados todas as linhas quando o valor da coluna user e password é igual as variáveis com o usuário e senha encriptados*/
		$selectUser = MySql::connect() -> prepare("SELECT * FROM `tb_admin` WHERE user = ? AND password = ?");
	    $selectUser -> execute(array($userCript, $passwordCript)); 

       
        //Se uma linha for afetada pela query 
		if($selectUser -> rowCount() == 1){

            //Cria-se a $_SESSION['login-painel']
		    $_SESSION['login-painel'] = true;
            

            //fetchall do selecionado de $selectUser
            $fetchAllSelectUserInformations = $selectUser -> fetchAll();

     
            foreach ($fetchAllSelectUserInformations as $key => $value) {

              //Pega o valor da coluna id na linha afetada pela query	
			  $_SESSION['id'] = $value['id'];

            }


		    //Ocorre um novo carregamento da url
		    header('Location: '.INCLUDE_PATH);

		    //Mata o script
	        die();

		}
        
        //Se mais de uma linha for afetada pela query
		else if($selectUser -> rowCount() > 1){
         
            General::alert('error','Erro, mais de um usuário com a mesma senha foram encontrados');

		}

        //Se nenhuma linha for afetada pela query 
		else{

		  	General::alert('error','Usuário ou senha inválidos');

		}
        //===================================
	}

}

?>
<form method="post">
	<div style="position:relative" class="w100">
		<input class="input-content input-style" type="text" name="user" placeholder="Usuário" required="">
		<div class="first-icon"><i class="fas fa-user"></i></div>
	</div>
	<!--w100-->
    <div style="position:relative" class="w100">
		<input class="input-content input-style" type="password" name="password" placeholder="Senha" required="">
		<div class="second-icon"><i class="fas fa-key"></i></div>
    	<div class="password-show-hide"><i class="fas fa-eye"></i><i class="fas fa-eye-slash"></i></div>
	</div>
	<!--w100-->
	<div class="w100">
		<input class="input-submit input-style" type="submit" name="submit" value="Fazer login" >
	</div>
	<!--w100-->
	<div align="center" class="w100">
		<a href="redefinir-senha">Esqueci minha senha</a>
	</div>
	<!--w100-->
</form>
